# LEGAiSEE — MASTER SYSTEM BIBLE
### Paste this ENTIRE document at the start of every new AI session on any platform.
### Last updated: 2026-05-17

---

## CRITICAL: READ THIS BEFORE RESPONDING TO ANYTHING

You are working on LEGAiSEE — a Business Memory Operating System built in PHP on a shared server. Before you write a single line of code or make any suggestion, you must understand and follow every rule in this document. Do not guess. Do not suggest alternatives to the established patterns. Do not introduce new patterns without being asked. The architecture is intentional and must be respected exactly.

---

## ARCHITECTURE RULES — NON-NEGOTIABLE

1. **No standalone pages.** Every new feature is a module. Location: `modules/{name}_module.php`. Registered in `kernel/module_registry.php`. Accessed via `shell.php?module=name`. No exceptions unless explicitly told otherwise by John.

2. **No embedded CSS.** All styles go in `ui/global.css`. Modules return HTML fragments only — no `<style>` tags, no `<head>`, no `<body>`, no `<!DOCTYPE>`.

3. **No embedded CSS in prospect.php or ingest.php either.** These are the only two legitimate standalone exceptions. They link `global.css`, they do not embed styles.

4. **shell.php is a router only.** `?module=name` loads one module full-width. No module param shows the Grand Lobby card dashboard. It does not render all modules simultaneously.

5. **Modules return fragments, not pages.** A module returns a string (via `ob_start()`/`ob_get_clean()`), a UIC array, or an inspector array. Shell renders it. The module never outputs a full HTML page structure.

6. **global.css is the only stylesheet.** Every page that needs styling links `/commandcenter/ui/global.css`. One file. Everything inherits from it.

7. **module_registry.php is the source of truth.** Every module must be registered there. If it's not in the registry, it doesn't exist to the system.

8. **AJAX cannot go through shell.php.** The `renderModule()` function uses `ob_start()` which traps JSON responses in a buffer. Any module needing to return JSON must use a standalone endpoint in `api/`. Pattern: `api/{name}_action.php` or `api/{name}_load.php`. These files require kernel_boot.php directly and bypass shell entirely.

9. **DB access via kernel_db() only.** Never raw PDO inline. Never `global $pdo`. Use `$db = kernel_db();` at the top of every module and engine.

10. **No AI platform UI chrome in entity extraction.** The noise filter in `entity_extraction_engine.php` handles this. Do not regress it.

11. **Context separation is active.** The `context` column exists on all major tables. Values: `legaisee` (business data), `memory` (AI chat sessions), `general` (everything else). Tag everything. Never mix contexts in queries.

12. **Plain English always.** Every module output must be human-readable sentences, not raw numbers or key/value dumps. Use `plain_english_helper.php` in `engine/`.

13. **No form tags in React/artifact code.** Use onClick/onChange event handlers. (Only relevant if building UI artifacts.)

---

## WHAT THIS SYSTEM IS

**LEGAiSEE — Business Archaeology & Authority Venture**

An operator-facing backend OS for John Carr (Carr Multimedia) that:
- Ingests historical business artifacts (old marketing, documents, AI chats, websites)
- Analyzes and organizes them using semantic/graph/AI engines
- Produces a verified, human-reviewed strategic authority report for the client
- Offers a client-facing dashboard/login so clients can view their results
- Grows into an ongoing business memory engine — continuously ingesting new data

**John is not a coder. He builds by following AI instructions file by file.**

**Second System: AI Memory & Chat Backup**
John also wants a universal AI memory layer — paste any AI chat, system organizes/deduplicates/tags by project, stores as searchable memory, injects relevant context at start of new sessions.

**The Competitive Moat:**
Human verification layer. AI extracts → John reviews → only confirmed findings go into reports. Not just AI output — human-verified AI intelligence. This is what makes it defensible.

---

## BUSINESS VISION — PHASES

| Phase | Product | Status |
|-------|---------|--------|
| 1 | Authority Dossier (Shallow Dig) — paste prospect info, get scored dossier | ✅ Built — prospect.php |
| 2 | Full Business Archaeology Report — AI sweep + John verification + report | 🔨 In progress |
| 3 | Living Client Vault — subscription, ongoing authority management | 📋 Planned |
| 4 | Cross-client pattern intelligence — industry insights no competitor has | 📋 Planned |
| 5 | Platform licensing to other agencies | 📋 Planned |

**The actual workflow:**
1. AI sweep — system ingests, extracts, scores
2. John's review — confirms/rejects/flags via Dig Review Interface
3. System assembles — report from confirmed findings only
4. Client receives — human-verified, AI-powered deliverable

---

## SERVER & STACK

```
Host:       SureServer shared hosting — s413.sureserver.com
User:       carrmulti
Live URL:   https://www.legaisee.com/commandcenter/
Main entry: shell.php (Grand Lobby)
Stack:      PHP 8+, MySQL, flat JSON files
Brand:      LEGAiSEE — gold/black
Colors:     #F4E185 (gold), #CDAD69 (mid gold), #89612B (dark gold), #0a0a0c (black)
```

**Credentials reminder:** DB credentials are still plaintext in `kernel/kernel_boot.php`. Move to config file outside web root before client portal goes live.

---

## DATABASE

```
Host:    localhost
DB name: carrmulti_legaiseearchive
User:    legaiseeuser
Connect: kernel_db() function in kernel/kernel_boot.php
```

### All Tables

| Table | Rows (approx) | Context | Notes |
|-------|--------------|---------|-------|
| artifacts | 0 | legaisee | empty — needs excavation pipeline |
| cases | 1 | legaisee | live |
| clusters | varies | legaisee | case cluster storage |
| documents | 1+ | legaisee | Gemini prospecting migrated here |
| embeddings | 0 | — | PLANNED — vector storage for semantic search |
| entities | 0 | legaisee | empty — needs excavation to populate |
| entity_aliases | 0 | legaisee | empty |
| events | 0 | legaisee | empty — timeline engine waiting |
| files | 2+ | legaisee | live |
| folders | 5 | legaisee | live |
| goal_proposals | 0 | — | empty |
| memory_domains | 4 | memory | seeded: Legaisee Build, Business Archaeology, Prospecting, General |
| memory_ingest | varies | memory | AI transcript storage |
| page | 16 | legaisee | live |
| page_content | 16 | legaisee | live |
| projects | 3 | — | seeded: Command Center Build, Client Analysis, New Braunfels Prospecting |
| relationships | 0 | legaisee | empty — needs excavation |
| reports | 0 | legaisee | empty |
| review_flags | 0 | legaisee | Dig Review — confirmed/rejected/needs_more_info |
| saved_views | 0 | — | empty |
| tasks | 0 | — | empty |

**Context column** exists on all major tables (added via `context_migration.sql`). Values: `legaisee`, `memory`, `general`.

**SQLite:** Fully retired. All 3 SQLite files deleted.

---

## COMPLETE FOLDER STRUCTURE

```
commandcenter/
│
├── kernel/                          ← BOOT LAYER — loads first, always
│   ├── kernel_boot.php              ← session_start(), kernel_paths, kernel_db() PDO singleton
│   ├── kernel_paths.php             ← defines ROOT constants (see below)
│   ├── kernel.php
│   ├── kernel_contract.php
│   ├── module_contract.php
│   ├── module_registry.php          ← SOURCE OF TRUTH — all modules registered here
│   ├── engine_bindings.php
│   └── guard.php
│
├── modules/                         ← SHELL LOADS THESE — {name}_module.php only
│   ├── ingest_module.php            ✅ rebuilt — paste AI chat, upload file, session list
│   ├── files_module.php             ✅ rebuilt — full file manager (tree, viewer, CRUD)
│   ├── search_module.php            ✅ rebuilt — 3-col search + dual compare panes
│   ├── dig_review_module.php        ✅ built — confirm/reject/needs-more-info findings
│   ├── intelligence_dashboard_module.php  ✅ working
│   ├── graph_module.php             ✅ working — entity/relationship counts
│   ├── clients_module.php           ✅ working — client cards from JSON
│   ├── cases_module.php             ✅ working — case rows with status/client/patterns
│   ├── excavation_module.php        ⚠️ partial — shows {} when no artifact metadata
│   ├── report_module.php            ✅ connected — assembly not yet built
│   ├── dashboard_module.php         ✅ working — case/client counts from JSON
│   ├── vault_module.php             ✅ working — 0 artifacts, needs excavation
│   ├── recommendation_module.php    ✅ rebuilt — reads from JSON cases
│   ├── executive_dashboard_module.php ✅ working
│   ├── brain_module.php             ✅ working — system status, module registry
│   ├── predictive_module.php        ✅ working — pattern transition probabilities
│   ├── anomaly_engine_module.php    ✅ working — returns LOW risk (no entities yet)
│   ├── entity_resolution_module.php ✅ working — 0 entities, waiting on excavation
│   ├── insight_module.php           ✅ working — case status distribution
│   ├── cluster_module.php           ✅ working
│   ├── compare_module.php           ✅ working — compare UI, semantic_diff not wired
│   ├── decision_module.php          ✅ working
│   ├── relations_module.php         ✅ working — case→client map
│   ├── root_cause_module.php        ✅ working
│   ├── time_intelligence_module.php ✅ working — empty, needs data
│   ├── cross_case_module.php        ✅ working
│   └── utils/
│       ├── bootstrap.php            ← load_json_dir()
│       ├── debug_helpers.php
│       ├── file_helpers.php
│       └── uic_v1.php               ← render_generic(), render_list(), render_grid() etc
│
├── engine/                          ← PROCESSING ENGINES — called by modules
│   ├── entity_extraction_engine.php ✅ rebuilt — sentence-level, 80+ noise words, 10 rel types, confidence scoring
│   ├── plain_english_helper.php     ✅ built — lee_interpret($module, $data) → human sentences
│   ├── semantic_cluster_engine.php
│   ├── predictive_intelligence_engine.php
│   ├── decision_engine_v2.php
│   ├── anomaly_detection_engine.php
│   ├── recommendation_engine.php
│   ├── execution_router.php
│   └── cross_case_engine.php
│
├── core/                            ← BRAIN & MEMORY
│   ├── brain_orchestrator.php
│   ├── memory_evolution_engine.php
│   ├── temporal_memory_engine.php
│   └── reasoning_engine.php
│
├── agents/                          ← AUTONOMOUS WORKERS (Phase 2)
│   ├── agent_spawn.php
│   ├── agent_tick.php               ← cron-driven scheduler
│   └── autonomous_engine.php
│
├── api/                             ← JSON ENDPOINTS ONLY — bypass shell.php
│   ├── api.php
│   ├── search_load.php              ✅ built — content loader for search module
│   └── files_action.php             ✅ built — file manager CRUD operations
│
├── data/                            ← FLAT FILE STORE
│   ├── cases/                       ← 17 JSON files (case_001.json etc)
│   ├── clients/                     ← 5 JSON files
│   ├── prospects/                   ← JSON files (auto-created by prospect.php)
│   ├── network/                     ← 8 JSON files
│   ├── memory/
│   ├── goals/
│   ├── graph/
│   └── brains/
│
├── ui/                              ← FRONTEND ASSETS
│   ├── global.css                   ← THE ONLY STYLESHEET
│   ├── ui_bootstrap.php             ← legaisee_ui_bootstrap()
│   └── images/
│
├── portal/                          ← CLIENT-FACING (planned)
│   ├── login.php
│   ├── dashboard.php
│   └── vault.php
│
├── shell.php                        ← GRAND LOBBY — module router + card dashboard
├── prospect.php                     ← LEGITIMATE STANDALONE — shallow dig, authority dossier
├── ingest.php                       ← LEGITIMATE STANDALONE — keep until fully replaced
└── .htaccess
```

---

## KERNEL BOOT CHAIN

```php
// kernel/kernel_boot.php loads in this order:
require_once __DIR__ . '/kernel_paths.php';  // defines all ROOT constants
session_start();
global $db;
$db = kernel_db();                           // PDO singleton
kernel_validate_runtime();                   // returns true if DB connected
```

```php
// kernel/kernel_paths.php constants:
define('KERNEL_ROOT',  __DIR__ . '/../');           // commandcenter/
define('DATA_ROOT',    KERNEL_ROOT . 'data/');
define('FILES_ROOT',   DATA_ROOT . 'files/');
define('CLIENTS_ROOT', DATA_ROOT . 'clients/');
define('CASES_ROOT',   DATA_ROOT . 'cases/');
define('MEMORY_ROOT',  DATA_ROOT . 'memory/');
define('MODULES_ROOT', KERNEL_ROOT . 'modules/');
define('ENGINE_ROOT',  KERNEL_ROOT . 'engine/');
```

---

## MODULE PATTERN — EXACT TEMPLATE

Every module must follow this exact pattern:

```php
<?php
// modules/example_module.php

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

$db = kernel_db();

// ... logic here ...

ob_start();
?>
<!-- HTML fragment here — no DOCTYPE, no head, no body, no style tags -->
<div class="example-wrap">
    <!-- content -->
</div>
<?php
return ob_get_clean();
```

**Module return options:**
- Return a string → rendered directly by shell
- Return array with `'type'` key → routed through `uic_render()`
- `ob_start()`/`ob_get_clean()` → return HTML string (preferred for complex layouts)

---

## API ENDPOINT PATTERN

For any operation that returns JSON (AJAX calls from modules):

```php
<?php
// api/example_action.php

require_once __DIR__ . '/../kernel/kernel_boot.php';

header('Content-Type: application/json');

$db     = kernel_db();
$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'do_something':
        // ... logic ...
        echo json_encode(['ok' => true, 'data' => $result]);
        break;
    default:
        echo json_encode(['ok' => false, 'error' => 'Unknown action']);
}
exit;
```

---

## SHELL.PHP BEHAVIOUR

- `shell.php` (no params) → Grand Lobby card dashboard showing all module wings grouped by category
- `shell.php?module=search` → loads `search_module.php` full width
- `renderModule($name)` → looks for `modules/{name}_module.php`, loads it
- Static `$loaded[]` array prevents double-loading (second load shows "Already loaded: {name}")
- Module wings grouped by category: Executive, Excavation, Intelligence, Operations, Memory, Client

---

## DATABASE QUERY PATTERNS

```php
// Always use kernel_db()
$db = kernel_db();

// Always include context filter when relevant
$stmt = $db->prepare("SELECT * FROM entities WHERE context = 'legaisee' AND name LIKE :q");
$stmt->execute([':q' => "%{$query}%"]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Wrap everything in try/catch — tables may be empty
try {
    $count = $db->query("SELECT COUNT(*) FROM entities")->fetchColumn();
} catch (Exception $e) {
    $count = 0;
}
```

---

## CSS PATTERNS — GOLD/BLACK THEME

All CSS in `ui/global.css`. Reference patterns for new modules:

```css
/* Input fields */
.mymod-input {
    background: #0a0a0c !important;
    border: 1px solid rgba(244,225,133,.3) !important;
    color: #e8e0cc !important;
    border-radius: 6px;
    padding: 0.5rem 0.7rem;
    font-family: inherit !important;
    -webkit-appearance: none;
}

/* Buttons */
.mymod-btn {
    background: #89612B;
    color: #F4E185;
    border: 1px solid rgba(244,225,133,.3);
    border-radius: 6px;
    padding: 0.5rem 1.2rem;
    font-weight: 700;
    cursor: pointer;
}
.mymod-btn:hover { background: #CDAD69; color: #0a0a0c; }

/* Cards */
.mymod-card {
    background: rgba(10,10,12,.5);
    border: 1px solid rgba(244,225,133,.15);
    border-radius: 10px;
    padding: 1rem;
}

/* Tables */
.mymod-table th { color: #CDAD69; font-size: .72rem; text-transform: uppercase; letter-spacing: .05em; }
.mymod-table td { color: #c8bfa8; border-bottom: 1px solid rgba(255,255,255,.04); }

/* Stat blocks */
.mymod-stat__n { font-size: 1.5rem; font-weight: 700; color: #F4E185; }
.mymod-stat__l { font-size: .68rem; color: #CDAD69; text-transform: uppercase; }
```

---

## PLAIN ENGLISH HELPER USAGE

Located at `engine/plain_english_helper.php`. Require it in kernel boot or at top of module.

```php
require_once ENGINE_ROOT . 'plain_english_helper.php';

// Get a sentence for a module's data
$text = lee_interpret('graph', [
    'entity_count'       => 12,
    'relationship_count' => 8,
    'entity_types'       => ['PERSON' => 5, 'ORG' => 4, 'LOCATION' => 3],
]);

// Or render a styled block directly in module output
echo lee_interpret_block('anomaly', [
    'risk_level'    => 'LOW',
    'anomaly_count' => 0,
]);
```

Supported modules: `relations`, `graph`, `anomaly`, `insight`, `recommendation`, `cluster`, `cross_case`, `time_intelligence`

---

## ENTITY EXTRACTION ENGINE

Located at `engine/entity_extraction_engine.php`.

**Key facts:**
- Sentence-level co-occurrence for relationships (not combinatorial pairing)
- 80+ noise words filter (prevents UI chrome like "Follow", "Analyze", "Perplexity" becoming entities)
- 10 relationship types: `competes_with`, `client_of`, `built`, `located_in`, `founded_by`, `employs`, `partners_with`, `reviewed_by`, `has_issue_with`, `regulated_by`
- Confidence scoring per entity and relationship
- Do NOT regress the noise filter

**Main function:**
```php
lee_extract_and_store($text, $source_id, $source_table, $context = 'legaisee');
```

---

## DIG REVIEW INTERFACE

Module: `modules/dig_review_module.php`
Table: `review_flags`

**Flow:**
1. Excavation extracts entities/relationships → stored in `entities`/`relationships` tables
2. Click "Queue New Findings" → unreviewed items pulled into `review_flags` with status `pending`
3. John reviews each finding: `confirmed` / `rejected` / `needs_more_info`
4. Report assembly queries only `confirmed` findings

**Schema:**
```sql
review_flags (
    id, source_table, source_id, context,
    status ENUM('pending','confirmed','rejected','needs_more_info'),
    operator_note TEXT,
    reviewed_at DATETIME,
    created_at DATETIME
)
```

**NEEDED:** Add `case_id` column to `review_flags` — required for report assembly to tie findings to specific clients.

---

## AUTHORITY REPORT TEMPLATE — 12 SECTIONS

The Phase 2 deliverable. Sections in order:

1. Cover Page
2. Executive Summary (1 page max, plain English)
3. Business Identity Profile (entities, aliases, people, locations)
4. Digital & Content Footprint (web, social, content history, gaps)
5. Reputation & Signal Analysis (positive/negative/anomaly signals)
6. Relationship & Network Map (connections by type)
7. Timeline & History (chronological events, phase analysis)
8. Competitive Position (competitors, positioning, gaps)
9. Authority Score Breakdown (0-100, 5 sub-scores of 20 each)
10. Strategic Recommendations (3-5 prioritized, effort + impact)
11. Methodology & Data Sources (verification statement)
12. Appendix (full entity/relationship lists, rejected findings)

**Tiers:**
- Authority Dossier (Phase 1): Sections 1, 2, 4, 5, 9
- Full Authority Report (Phase 2): All 12 sections
- Living Report (Phase 3 subscription): Full report + quarterly updates

---

## AUTHORITY SCORE SUB-DIMENSIONS

```
Digital Presence Score    (0-20)
Content & Credibility     (0-20)
Network Strength          (0-20)
Reputation Signals        (0-20)
Consistency & Clarity     (0-20)
TOTAL                     (0-100)
```

Current scoring in `prospect.php`: confidence-weighted, requires 2+ keyword hits, range 28-96, content depth bonus.

---

## THREE SYSTEMS / ONE INTELLIGENCE LAYER

| System | Context Tag | Contents |
|--------|------------|---------|
| LEGAiSEE Business | `legaisee` | Clients, cases, prospects, reports, portal |
| AI Memory & Chat Backup | `memory` | AI session transcripts, project bibles |
| General / Everything Else | `general` | Notes, side projects, Carr Multimedia docs |
| Shared Intelligence | (all) | Entity extraction, clustering, anomaly — data separated by context |

---

## INFRASTRUCTURE ROADMAP

### Current: SureServer shared hosting
Fine for Phase 1. Adequate for ingest, metadata extraction, dashboarding, search, report generation.

### Next upgrade: VPS ($40-80/month)
When: first 5-10 paying clients. Same codebase, more RAM + storage.

### Phase 2: Own dedicated server or physical box
Hardware spec for 20+ clients:
- CPU: 8-16 core
- RAM: 64GB
- Storage: 4-8TB
- GPU: none needed until local AI inference
- Cost: ~$3-5k one-time or $150-300/month rented

### Phase 3 product: Client-owned "memory appliance"
Physical server installed at client location. Client owns data. $5-15k product + annual support.

### Deployment model decision
- Now: Centralized (all clients on John's server) — easier to update/bill
- Premium upsell: Client-owned appliance (data sovereignty)
- Long-term: Hybrid (local memory core + cloud intelligence layer)

---

## UPCOMING TECHNICAL COMPONENTS (Phase 2)

### Vector Database
Semantic search — finds meaning, not just keywords.
Options: pgvector (PostgreSQL), Qdrant (Docker, free), or store OpenAI vectors as MySQL BLOB.
Cost: OpenAI `text-embedding-3-small` at ~$0.02/million tokens. Negligible.

### Embedding Pipeline
On every ingest: call embedding API → store vector → enables semantic search.
Function needed: `lee_embed($text)` → returns vector → stored in `embeddings` table.

### Timeline Engine
`events` table exists but empty. Needs: date extraction from documents → auto-create events tagged with type (marketing_change, leadership_change, pricing_change, branding_pivot, operational_change).

### Continuous Ingestion
`agents/agent_tick.php` is the cron worker. Phase 2 sources: website snapshots, review platform monitoring, social metrics, ad performance exports.

---

## JOHN'S TERMINOLOGY — USE THESE EXACT WORDS

| Term | Meaning |
|------|---------|
| Excavation | Ingesting/analyzing historical business artifacts |
| Archaeology | The overall methodology |
| Authority | The strategic positioning output |
| Dossier | Compiled client intelligence file |
| Grand Lobby | The shell.php main dashboard |
| Wings | The sections/cards of the Grand Lobby |
| Vault | Client-facing secure area |
| Artifact | Any raw input document (old ad, chat, document) |
| Brain | The AI reasoning/memory orchestration layer |
| Dig | A single client excavation job |
| Dig Review | The operator verification interface |
| Sovereign Intelligence Environment | The overall system brand name |

---

## MODULE STATUS — COMPLETE LIST

| Module | File | Status | Notes |
|--------|------|--------|-------|
| intelligence_dashboard | intelligence_dashboard_module.php | ✅ Working | Mock data — needs pipeline |
| dashboard | dashboard_module.php | ✅ Working | JSON case/client counts |
| files | files_module.php | ✅ Rebuilt | Full file manager — tree, viewer, CRUD |
| ingest | ingest_module.php | ✅ Rebuilt | Paste transcript, upload, session list |
| search | search_module.php | ✅ Rebuilt | 3-col search + dual compare panes |
| dig_review | dig_review_module.php | ✅ Built | confirm/reject/needs_more_info |
| graph | graph_module.php | ✅ Working | Entity/rel counts (both 0) |
| clients | clients_module.php | ✅ Working | Client cards from JSON |
| cases | cases_module.php | ✅ Working | Case rows |
| brain | brain_module.php | ✅ Working | System status |
| anomaly_engine | anomaly_engine_module.php | ✅ Working | LOW risk (no entities) |
| cluster | cluster_module.php | ✅ Working | DB clusters |
| compare | compare_module.php | ✅ Working | Two-input compare, diff not wired |
| decision | decision_module.php | ✅ Working | JSON decisions |
| entity_resolution | entity_resolution_module.php | ✅ Working | 0 entities |
| insight | insight_module.php | ✅ Working | Status distribution |
| predictive | predictive_module.php | ✅ Working | Pattern probabilities |
| recommendation | recommendation_module.php | ✅ Rebuilt | JSON cases |
| relations | relations_module.php | ✅ Working | Case→client map |
| report | report_module.php | ✅ Connected | Assembly not built |
| root_cause | root_cause_module.php | ✅ Working | 22 node graph |
| time_intelligence | time_intelligence_module.php | ✅ Working | Empty — needs data |
| vault | vault_module.php | ✅ Working | 0 artifacts |
| excavation | excavation_module.php | ⚠️ Partial | Shows {} — needs pipeline wiring |
| cross_case | cross_case_module.php | ✅ Working | Waiting on data |

---

## API ENDPOINTS (api/ folder)

| File | Purpose | Called by |
|------|---------|-----------|
| `api/search_load.php` | Load file/record content for search panes | search_module.php JS |
| `api/files_action.php` | File manager CRUD (list, read, create, delete, rename, move, upload, save) | files_module.php JS |
| `api/api.php` | General API (existing) | various |

---

## STANDALONE PAGES (legitimate exceptions only)

| File | Status | Notes |
|------|--------|-------|
| `prospect.php` | Keep — legitimate standalone | Shallow dig, authority dossier. Links global.css. |
| `ingest.php` | Keep until fully replaced | Legacy standalone. Links global.css. |

**All other standalones have been deleted:**
`search.php`, `brain.php`, `temp_dashboard.php`, `view_ingest.php`, `legaisee_diagnostic.php`, `legaisee_sqlite_viewer.php`, `legaisee_migrate_sqlite.php`

---

## FILES THAT NEED TO BE DEPLOYED (pending as of 2026-05-17)

If these are not yet on the server, deploy them before building anything new:

| File | Upload to | Priority |
|------|-----------|---------|
| `search_module.php` | `modules/` | High — Set A/B now works |
| `search_load.php` | `api/` | High — required for search panes |
| `files_module.php` | `modules/` | High — file manager |
| `files_action.php` | `api/` | High — required for file manager |
| `ingest_module.php` | `modules/` | High |
| `dig_review_module.php` | `modules/` | Medium |
| `plain_english_helper.php` | `engine/` | Medium |
| Run `context_migration.sql` | phpMyAdmin SQL tab | Medium — adds context column |
| Paste `ingest_and_files_css.css` | Bottom of `ui/global.css` | High |
| Paste `search_module_css.css` | Bottom of `ui/global.css` | High |

---

## NEXT BUILD PRIORITIES (in order)

1. Deploy all pending files above
2. Run context_migration.sql
3. Add `case_id` column to `review_flags` table
4. Build `lee_embed()` embedding function — call OpenAI API, store in embeddings table
5. Wire embedding into `ingest_module.php` — embed on every transcript save
6. Populate `events` table — extract dates from documents, auto-create timeline events
7. Build `report_module.php` section assembler — confirmed findings only
8. Add plain English layer to 8 priority modules (relations, graph, anomaly, insight, recommendation, cluster, cross_case, time_intelligence)
9. Test full pipeline: Brad Moore Builders prospect → dig review → authority report
10. Begin client portal (`portal/login.php`, `portal/dashboard.php`)

---

## KEY TECHNICAL FACTS

- `global $db` is set at boot — `kernel_boot.php` sets `global $db; $db = kernel_db();`. Modules can use either `$db` or `kernel_db()` — both work.
- `kernel_validate_runtime()` returns true if DB connected.
- `renderModule()` uses static `$loaded[]` — second load of same module shows "Already loaded: {name}".
- UIC types: `artifact`, `dataset`, `system`, `list`, `grid` + generic fallback.
- AJAX from modules MUST go to `api/` endpoints — never through `shell.php`.
- `load_json_dir()` in `modules/utils/bootstrap.php` — used by cases, clients, dashboard, insight modules.
- `data/prospects/` auto-created by `prospect.php` on first run.
- DB credentials plaintext in `kernel/kernel_boot.php` — move before portal launch.
- All modules must be registered in `module_registry.php` or they don't exist to the system.
- CSS class naming convention: prefix with module name (`.ingest-wrap`, `.srch3-col`, `.fm-tree-col`).
