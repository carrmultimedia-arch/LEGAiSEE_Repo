<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| ENTITY EXTRACTION ENGINE
|--------------------------------------------------------------------------
| Reads artifact text → extracts entities + relationships → writes MySQL
| Called by excavation_module.php and prospect.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../kernel/kernel_boot.php';

/*
|--------------------------------------------------------------------------
| NOISE FILTER
| Words that should never be treated as entities
|--------------------------------------------------------------------------
*/
function lee_is_noise(string $word): bool {
    static $noise = [
        // Stop words
        'The','This','That','These','Those','With','From','Into','Over','Under',
        'Your','Their','When','Where','What','Which','There','Here','Have','Will',
        'Been','Also','More','Some','Each','Such','Both','Very','Just','Even',
        'Only','Still','Then','Than','About','After','Before','Between','Through',
        'During','Without','Against','Because','While','Since','Although','However',
        // UI chrome from AI platforms
        'Follow','Analyze','Search','Share','Copy','Save','Print','Export','Login',
        'Sign','Click','View','Read','More','Load','Back','Next','Page','Home',
        'Menu','Help','Settings','Profile','Account','Close','Open','Show','Hide',
        'Perplexity','ChatGPT','Claude','Gemini','Copilot','Grok',
        // Common sentence starters that get capitalized
        'According','Based','Given','Note','Please','However','Therefore',
        'Additionally','Furthermore','Moreover','Meanwhile','Overall','Finally',
        'First','Second','Third','Last','Today','Recently','Currently','Now',
        // Single generic words
        'None','True','False','Yes','No','New','Old','Big','Small','High','Low',
        'Good','Best','Top','Key','Main','Core','Full','Real','Free','Live',
        // Fragments
        'Brad','Moore','Builders','Perry','Drees','Journey','Hill','Country',
    ];
    return in_array(trim($word), $noise, true);
}

/*
|--------------------------------------------------------------------------
| ENTITY TYPE DETECTION
|--------------------------------------------------------------------------
*/
function lee_detect_entity_type(string $text): string {
    $t = strtolower(trim($text));

    // Organization signals
    $orgIndicators = ['inc','llc','corp','company','co.','group','associates',
                      'partners','agency','studio','media','solutions','services',
                      'consulting','builders','construction','contracting','realty',
                      'properties','homes','developments','enterprises','ventures'];
    foreach ($orgIndicators as $o) {
        if (str_contains($t, $o)) return 'organization';
    }

    // Location signals
    $locationIndicators = ['street','ave','blvd','drive','road','lane','city',
                           'county','state','texas','tx','new braunfels','san antonio',
                           'austin','houston','dallas','comal','bexar','guadalupe',
                           'hill country'];
    foreach ($locationIndicators as $l) {
        if (str_contains($t, $l)) return 'location';
    }

    // Person signals (titles only — avoid first-name-only false positives)
    $personTitles = ['mr.','mrs.','ms.','dr.','ceo','owner','president','director',
                     'manager','founder','principal'];
    foreach ($personTitles as $p) {
        if (str_contains($t, $p)) return 'person';
    }

    // Signal keywords
    $signalIndicators = ['delay','pricing','lead','conversion','staff','labor',
                         'revenue','cost','growth','decline','gap','friction',
                         'turnover','shortage','complaint','review'];
    foreach ($signalIndicators as $s) {
        if (str_contains($t, $s)) return 'signal';
    }

    // Multi-word proper noun → likely organization or concept
    if (substr_count(trim($text), ' ') >= 1) return 'concept';

    return 'concept';
}

/*
|--------------------------------------------------------------------------
| SPLIT TEXT INTO SENTENCES
|--------------------------------------------------------------------------
*/
function lee_split_sentences(string $text): array {
    // Split on sentence-ending punctuation
    $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    return array_filter(array_map('trim', $sentences), fn($s) => strlen($s) > 20);
}

/*
|--------------------------------------------------------------------------
| EXTRACT CANDIDATE ENTITIES FROM TEXT
| Returns array of cleaned name strings
|--------------------------------------------------------------------------
*/
function lee_extract_entity_candidates(string $text): array {
    $candidates = [];

    // Multi-word capitalized proper noun phrases (2–4 words) — preferred
    preg_match_all('/\b([A-Z][a-z]{1,25}(?:\s+[A-Z][a-z]{1,25}){1,3})\b/', $text, $matches);
    foreach ($matches[1] as $m) {
        $m = trim($m);
        if (strlen($m) < 5) continue;
        if (lee_is_noise($m)) continue;
        // Skip if any word in the phrase is noise
        $words = explode(' ', $m);
        $allNoise = true;
        foreach ($words as $w) {
            if (!lee_is_noise($w)) { $allNoise = false; break; }
        }
        if ($allNoise) continue;
        $candidates[] = $m;
    }

    // Single-word capitalized — only if clearly an org/location/concept (not a common word)
    preg_match_all('/\b([A-Z][a-z]{3,20})\b/', $text, $singles);
    foreach ($singles[1] as $s) {
        $s = trim($s);
        if (lee_is_noise($s)) continue;
        // Only keep single words that look like proper nouns (rare — multi-word preferred)
        $type = lee_detect_entity_type($s);
        if (in_array($type, ['organization', 'location'])) {
            $candidates[] = $s;
        }
    }

    // Explicit signal phrases
    $signalPhrases = [
        'operational delay','pricing pressure','lead friction',
        'labor issue','revenue decline','cost overrun',
        'conversion breakdown','staff turnover','market shift',
        'brand gap','authority gap','trust deficit','delivery delay',
        'subcontractor issue','permit delay','material shortage'
    ];
    $textLower = strtolower($text);
    foreach ($signalPhrases as $phrase) {
        if (str_contains($textLower, $phrase)) {
            $candidates[] = ucwords($phrase);
        }
    }

    return array_values(array_unique($candidates));
}

/*
|--------------------------------------------------------------------------
| UPSERT ENTITY
|--------------------------------------------------------------------------
*/
function lee_upsert_entity(PDO $db, string $canonicalName, string $type, float $confidence = 0.7): ?int {
    $hash = md5(strtolower(trim($canonicalName)));

    $stmt = $db->prepare("SELECT id FROM entities WHERE normalized_hash = ?");
    $stmt->execute([$hash]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) return (int)$row['id'];

    $stmt = $db->prepare("
        INSERT INTO entities (entity_type, canonical_name, normalized_hash, confidence, created_at)
        VALUES (?, ?, ?, ?, datetime('now'))
    ");
    $stmt->execute([$type, $canonicalName, $hash, $confidence]);
    return (int)$db->lastInsertId();
}

/*
|--------------------------------------------------------------------------
| INSERT ALIAS
|--------------------------------------------------------------------------
*/
function lee_insert_alias(PDO $db, int $entityId, string $alias, string $sourceType, float $confidence = 0.7): void {
    $stmt = $db->prepare("SELECT id FROM entity_aliases WHERE entity_id = ? AND alias = ?");
    $stmt->execute([$entityId, $alias]);
    if ($stmt->fetch()) return;

    $stmt = $db->prepare("
        INSERT INTO entity_aliases (entity_id, alias, source_type, confidence, created_at)
        VALUES (?, ?, ?, ?, datetime('now'))
    ");
    $stmt->execute([$entityId, $alias, $sourceType, $confidence]);
}

/*
|--------------------------------------------------------------------------
| DETECT RELATIONSHIP TYPE FROM SENTENCE CONTEXT
| Now uses the specific sentence containing both entities
|--------------------------------------------------------------------------
*/
function lee_detect_relationship_type(string $nameA, string $nameB, string $context): string {
    $ctx = strtolower($context);

    if (str_contains($ctx, 'compet') || str_contains($ctx, 'rival') || str_contains($ctx, 'versus') || str_contains($ctx, ' vs '))
        return 'competes_with';
    if (str_contains($ctx, 'client') || str_contains($ctx, 'customer') || str_contains($ctx, 'hired') || str_contains($ctx, 'contracted'))
        return 'client_of';
    if (str_contains($ctx, 'built') || str_contains($ctx, 'constructed') || str_contains($ctx, 'developed') || str_contains($ctx, 'completed'))
        return 'built';
    if (str_contains($ctx, 'locat') || str_contains($ctx, 'based in') || str_contains($ctx, 'office in') || str_contains($ctx, 'serving'))
        return 'located_in';
    if (str_contains($ctx, 'own') || str_contains($ctx, 'found') || str_contains($ctx, 'started') || str_contains($ctx, 'established'))
        return 'founded_by';
    if (str_contains($ctx, 'employ') || str_contains($ctx, 'staff') || str_contains($ctx, 'hire') || str_contains($ctx, 'team'))
        return 'employs';
    if (str_contains($ctx, 'partner') || str_contains($ctx, 'collab') || str_contains($ctx, 'work with') || str_contains($ctx, 'subcontract'))
        return 'partners_with';
    if (str_contains($ctx, 'review') || str_contains($ctx, 'rated') || str_contains($ctx, 'complaint') || str_contains($ctx, 'feedback'))
        return 'reviewed_by';
    if (str_contains($ctx, 'delay') || str_contains($ctx, 'issue') || str_contains($ctx, 'problem') || str_contains($ctx, 'complaint'))
        return 'has_issue_with';
    if (str_contains($ctx, 'permit') || str_contains($ctx, 'license') || str_contains($ctx, 'certif') || str_contains($ctx, 'regulat'))
        return 'regulated_by';

    return 'co_occurs_with';
}

/*
|--------------------------------------------------------------------------
| UPSERT RELATIONSHIP
|--------------------------------------------------------------------------
*/
function lee_upsert_relationship(
    PDO    $db,
    int    $fromId,
    string $fromName,
    int    $toId,
    string $toName,
    string $relationType,
    float  $strength = 0.5,
    string $context  = ''
): void {
    $stmt = $db->prepare("
        SELECT id FROM relationships
        WHERE from_entity_id = ? AND to_entity_id = ? AND relation_type = ?
    ");
    $stmt->execute([$fromId, $toId, $relationType]);
    if ($stmt->fetch()) return;

    $stmt = $db->prepare("
        INSERT INTO relationships
            (from_entity, to_entity, relation_type, strength, source_context, from_entity_id, to_entity_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, datetime('now'))
    ");
    $stmt->execute([
        substr($fromName, 0, 64),
        substr($toName, 0, 64),
        $relationType,
        $strength,
        $context,
        $fromId,
        $toId
    ]);
}

/*
|--------------------------------------------------------------------------
| MAIN ENTRY POINT
|--------------------------------------------------------------------------
*/
function lee_extract_and_store(
    PDO    $db,
    string $text,
    string $sourceType  = 'artifact',
    string $clientId    = '',
    string $artifactRef = ''
): array {
    $candidates  = lee_extract_entity_candidates($text);
    $entityIds   = [];
    $entityNames = [];
    $inserted    = 0;
    $relationships = 0;

    // --- Store entities ---
    foreach ($candidates as $name) {
        $type       = lee_detect_entity_type($name);
        $confidence = in_array($type, ['organization', 'location', 'person']) ? 0.8 : 0.55;
        $id         = lee_upsert_entity($db, $name, $type, $confidence);

        if ($id) {
            $entityIds[]   = $id;
            $entityNames[] = $name;
            $inserted++;

            if ($artifactRef) {
                lee_insert_alias($db, $id, $artifactRef, $sourceType, 0.6);
            }
        }
    }

    // --- Store relationships using sentence-level co-occurrence ---
    $sentences = lee_split_sentences($text);
    $nameToId  = array_combine($entityNames, $entityIds);

    foreach ($sentences as $sentence) {
        // Find which entities appear in this sentence
        $foundInSentence = [];
        foreach ($entityNames as $idx => $name) {
            if (stripos($sentence, $name) !== false) {
                $foundInSentence[] = $idx;
            }
        }

        // Only create relationships for entities that share a sentence
        $count = count($foundInSentence);
        if ($count < 2) continue;

        // Cap per-sentence pairs to avoid explosion on entity-dense sentences
        $limit = min($count, 5);
        for ($i = 0; $i < $limit - 1; $i++) {
            for ($j = $i + 1; $j < $limit; $j++) {
                $idxA = $foundInSentence[$i];
                $idxB = $foundInSentence[$j];

                $relType = lee_detect_relationship_type(
                    $entityNames[$idxA],
                    $entityNames[$idxB],
                    $sentence   // ← sentence context only, not full text
                );

                lee_upsert_relationship(
                    $db,
                    $entityIds[$idxA], $entityNames[$idxA],
                    $entityIds[$idxB], $entityNames[$idxB],
                    $relType,
                    0.6,
                    substr($sentence, 0, 200)
                );
                $relationships++;
            }
        }
    }

    return [
        'entities_extracted'   => count($candidates),
        'entities_stored'      => $inserted,
        'relationships_stored' => $relationships,
        'source'               => $artifactRef,
    ];
}