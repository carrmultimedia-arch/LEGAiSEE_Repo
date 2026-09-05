LEGAiSEE System Audit — 51 Top-Level Standalone Files
Audit type: Macro/system-level — real connections, not "does it execute."

THE PATTERN
Checked every file in this group for real references anywhere in the codebase. Almost all of them — roughly 40 of 51 — have zero references from anywhere. This isn't scattered coincidence: most of them share one thing in common — they all pull in the same file, lib/semantic_diff_engine.php (245 lines) — which is itself never referenced by anything in the live system either. This is a third disconnected island, alongside the old index.php prototype and the api/v8/cli/engine-goal cluster already found: a set of standalone experimental tools built around a shared library, none of it wired into shell.php.
Files confirmed genuinely dead (zero references anywhere)
ai_process.php, create_review_flags.php, create_session.php, diagnostics2.php, dossier_v2.php, embed_generate.php, export_report.php, intelligence.php, legaisee_prospects.php, load_module.php, load_sets.php, mission.php, parser.php, peek.php, save_set.php, saved_views.php, search_dual.php, semantic_engine.php, session.php, setup.php, view_file.php
Files with 1-2 references (effectively still isolated — referenced only within this same dead cluster)
excavation_engine.php, files.php, indexer.php, temp_dashboard.php, view_ingest.php, cluster_engine.php
The one real, reused utility in this group
response.php (7 references) — a clean "API Response Contract Guard" (json_response()), meant to standardize how API endpoints return JSON so the UI doesn't crash on bad responses. This is genuinely good practice and actually gets reused — worth keeping regardless of what happens to the rest.

Two things worth flagging directly, not just "orphaned"
setup.php — a public "Initialize Database" script that creates a SQLite database (legaisee.db) via SQLite3. This is a leftover from before the SQLite→MySQL migration already on record. It's disconnected from anything today, but if it were ever hit directly by URL, it would create a stray SQLite file, unrelated to the real MySQL database everything else uses — worth deleting outright rather than leaving it live, since it has no legitimate current purpose and creates real confusion if triggered.
embed_generate.php — an "Embedding Generator" meant to call OpenAI, with a placeholder in the source: $OPENAI_API_KEY = "YOUR_API_KEY_HERE";. Never configured, so it can't currently leak anything — but it's a plain-text placeholder for a real secret sitting in a web-accessible file. Worth knowing about now, before anyone ever fills that placeholder in without also moving it out of a publicly reachable script.
What this cluster appears to have been building toward
Reading them together: dossier_v2.php and excavation_engine.php both reference the exact same hardcoded network ID (net_69eee12e374d30_99173905) — meaning these were built and tested against one specific piece of sample data, not general-purpose. session.php and create_session.php reference a legaisee/clients/{client}/excavations/{session}/ folder structure — a fourth data layout, different from both the MySQL tables and the data/cases/, data/clients/ flat-JSON layer already confirmed live elsewhere. This reads as an earlier or parallel experiment in "semantic diffing" and session-based excavation browsing that never got adopted — plausibly predating, or built alongside, the current live system, then abandoned when the current modules/+MySQL+data/cases/ approach became the real one.
One file in here is a different kind of thing entirely: legaisee_prospects.php (676 lines) — not a system tool at all. It's a standalone, styled HTML sales/lead-generation page ("Legaisee Prospect List — Austin & San Antonio Corridor"). Unrelated to the archaeology system's functionality — likely a business-development page that happens to live in the same folder.

Genuinely load-bearing top-level files (already confirmed elsewhere, not re-audited here)
bootstrap.php, config.php, db.php, shell.php, graph_view.php, prospect.php, index.php, api.php — all already accounted for in earlier audit files.
Confirmed test/debug clutter, not yet individually opened but self-evidently scaffolding
test_db.php, test_excavation_module.php, test_full_checkout.php, test_graph.php, test_kernel.php, test_modules.php, test_search.php, test_ui.php, test_visual.php, create_test_data.php — file names alone make their purpose clear; low priority to open individually unless you want confirmation of what each specifically tests.

Section summary
Of the 51 top-level files, roughly 4 are genuinely load-bearing (once you exclude the ones already covered elsewhere), ~10 are self-evident test/debug scaffolding, 1 is a real, reused utility (response.php), and the remaining ~36 form a third disconnected experimental cluster (the semantic-diff/excavation-session tools) plus two files worth a security-hygiene look (setup.php, embed_generate.php) and one unrelated marketing page (legaisee_prospects.php).
Combined with the earlier backend audit, the honest picture is now: three separate disconnected systems exist in this codebase (old index.php prototype, the unwired engine/+api/v8+cli autonomous-agent cluster, and this semantic-diff experimental cluster) layered around one real, live system (shell.php + modules/ + the working slice of engine//kernel/).

Top-level files complete. Per the master checklist, next up: ui/ (19 files), then api/ top-level (45 unread), then ProjectManager/ internals (88 files).

