LEGAiSEE System Audit — "Intelligence Engines" Sidebar Section
Audit type: Macro / system-level. Not "does the PHP execute."
Status labels in shell.php: all 7 marked 'status' => 'working' — same hardcoded pattern as every prior section.

ROOT-CAUSE FINDING (applies system-wide, not just this section)
Traced why modules show raw JSON or bare numbers instead of readable output. There is one shared rendering function, renderModule() in shell.php, that every module's return value passes through unless the module builds its own full HTML page (like Clusters, Files, Search, Dig Review, Memory Ingest, Ingest View already do). For everything else, it picks one of two fallback paths based on the shape of data the module returns:
If a module returns ['title' => ..., 'items' => [...]] → goes to render_inspector(), which wraps each item's content field in a <pre> tag. A <pre> tag displays text exactly as typed — so if content is a JSON string (which is how the Graph & Entities modules built their output), the user sees the raw JSON, verbatim, in a fixed-width box. This is not a bug being hunted for — it is exactly, mechanically, what the code is built to do.
If a module returns a flat list of key→value pairs (e.g. risk_score, entities, etc.) → goes to a generic exec-panel loop that prints key: value lines. This one is actually somewhat readable (labeled fields, not raw JSON) — except for one serious side effect: if a value is itself an array, the code replaces it with just its count (count($v) . ' records'). Any module whose real output is a list of things (predictions, entities, links) gets silently flattened down to a single number by this fallback, regardless of how good the underlying data is.
This is the actual macro-level lever. Rather than fixing each module's display individually, fixing (or bypassing) these two fallback paths in renderModule()/render_inspector() once would fix the presentation layer for every module that currently dumps JSON or bare counts — a single, shared point of leverage instead of N separate module-by-module rewrites.

1. Anomaly (modules/anomaly_engine_module.php)
Supposed to do: risk & anomaly detection across the entity/relationship graph.
What it actually does: genuinely computes a weighted risk score from five real signals (orphaned entities, hub nodes, weight anomalies, alias explosions, contradictions) and buckets it into CRITICAL/HIGH/MODERATE/LOW.
Rendering path: flat key→value → hits the exec-panel fallback. Since none of its values are arrays, it renders as readable labeled lines (e.g. "risk_level: HIGH", "orphans_detected: 12"). Not pretty, but genuinely legible.
Verdict: Real computation, borderline-acceptable presentation (labeled fields, no narrative sentence, but not raw JSON either).
2. Insight (modules/insight_module.php) — MAJOR FINDING
Supposed to do, per the sidebar: "Case status intelligence."
What the file actually is: its own internal header comment literally reads * ingest_module.php / LEGAiSEE — Ingest & AI Memory Module — this file is a near-duplicate copy of the Memory Ingest module's paste/upload/sessions code, wired to the insight sidebar key instead. There is no case-status-intelligence logic anywhere in this file — I searched for it directly and found none.
The dangerous part: its database insert uses a different set of column names than the real Memory Ingest module —
Real Ingest writes: session_label, project_tag, platform, ..., raw_text, ..., created_at
This "Insight" duplicate writes: session_title, project_tag, source_ai, ..., raw_transcript, ..., created_at, processed
Both target the same table, memory_ingest, with two incompatible column sets. I couldn't confirm the live table schema from the codebase alone, but structurally, this is a real conflict: whichever set of column names doesn't match the live table will fail to save (or silently create orphaned/invisible data), and if the table happens to have both column sets, data pasted through one page would never appear when viewed through the other.
This is a strong candidate explanation for at least part of the "ingest doesn't save" experience — if you (or an earlier session) ever pasted a transcript on whatever page "Insight" resolves to, expecting it to behave like Ingest, it could be silently going to different columns than the ones the Sessions list reads from.
Verdict: Mislabeled, misfiled, duplicate code — not a rendering problem, a wiring/build mistake. This needs a live check: does clicking "Insight" in the sidebar show something that looks like the ingest paste form? If yes, that confirms this finding live.
3. Recommendation (modules/recommendation_module.php)
Supposed to do: turn detected patterns into action recommendations.
What it actually does: maps detected patterns to plain-English titles and action sentences (e.g. "Stabilize Workforce Signals — Investigate staffing consistency and delivery quality"), with a sensible fallback message when nothing's been ingested yet.
Rendering path: title/items shape → render_inspector() → but unlike the Graph & Entities modules, its content field is a plain sentence, not JSON — so the <pre> tag just displays a normal readable sentence.
Verdict: Actually works the way a business user would expect. A third clean example (with Clusters and Ingest View) of the system doing this correctly.
4. Decision Engine (modules/decision_module.php)
Supposed to do: decision logic across cases.
What it actually does: computes real per-case decisions and a ranked global priority list.
Rendering path: title/items with JSON-string content → same raw-JSON-in-a-box problem as most of Graph & Entities.
Verdict: Real logic, translation gap.
5. Predictive (modules/predictive_module.php)
Supposed to do: forecast pattern transitions.
What it actually does: computes real transition probabilities and case-level predictions.
Rendering path: same JSON-dump pattern as Decision Engine above.
Verdict: Real logic, translation gap.
6. Predictive Link V1 (modules/predictive_link_module_v1.php)
Supposed to do: predict likely new relationships between entities using a weighted structural/semantic/cluster/influence score.
What it actually does: a genuinely sophisticated scoring model — computes four separate similarity signals per candidate pair and combines them, keeping only predictions above a real confidence threshold (0.72).
Rendering path: returns a flat predicted_links (array) + total_predictions (number) — hits the exec-panel fallback, which (per the root-cause finding above) collapses the array to just its count. So the actual output — a ranked list of specific predicted relationships with real confidence scores — never reaches the screen at all. You'd see "predicted_links: 37 records" and nothing else.
Verdict: The most sophisticated engine found in this whole audit so far, and it's the most completely invisible. This is the clearest single example of the array-collapsing rendering bug doing real damage.
7. Time Intelligence (modules/time_intelligence_module.php)
Supposed to do: temporal trend analysis (7-day vs. 30-day baseline).
What it actually does: computes real trend deltas, sorted by movement.
Rendering path: same JSON-dump pattern.
Verdict: Real logic, translation gap.

Section summary
1 file shouldn't exist where it is (Insight = a mis-wired duplicate of Ingest, not case-status logic) — a wiring/build mistake, the most serious finding in this section.
1 engine's real output is actively destroyed by the renderer before it reaches the screen (Predictive Link V1) — highest-value fix candidate found so far, since the underlying logic is already sophisticated and correct.
4 of 7 modules (Decision, Predictive, Time Intelligence, and Excavation from the prior section) share the exact same fixable-in-one-place JSON-dump problem.
2 of 7 modules (Recommendation, and Anomaly to a lesser extent) already clear the human-legibility bar as built.

Next: Command section (System Dashboard, Intel Dashboard, Executive Dashboard, Brain, Cockpit), then Clients & Cases, then Tools.

