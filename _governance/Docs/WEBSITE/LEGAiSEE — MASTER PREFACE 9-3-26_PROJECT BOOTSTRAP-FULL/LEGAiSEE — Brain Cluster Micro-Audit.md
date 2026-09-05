LEGAiSEE — Brain Cluster Micro-Audit
Companion to the full function inventory (engine/, api/v8/, api/ top-level ~30). This is the final deliverable of the brain micro-audit: which functions are true duplicates, which are divergent capabilities, and a KEEP/RESTORE/FIX/FINISH/INTEGRATE/REPLACE/DEFER/DELETE call for each.

GROUP A — REAL, DB-backed, working paradigm (the "good half")
These all use kernel_db()/PDO against real MySQL tables (entities, cases, clients, tree_nodes, processing_queue, tasks). This is the only paradigm with genuine data behind it.
Function/File
Location
Does
Triage
graph_engine.php (queue_graph_build_for_case, mutateGraph)
engine/
Per-case graph building against real tables
KEEP
build_graph.php
api/v8
Wires to graph_engine.php
KEEP
semantic_cluster_engine.php (buildSemanticClusters)
engine/
Clustering over real entities
KEEP
cluster_insights.php
api/v8
Wires to semantic_cluster_engine.php
KEEP
graph_ranker.php
api/v8
Ranks top-10 entities by strength/confidence
KEEP
get_cases.php / get_clients.php
api/v8
Real case/client data access
KEEP (already established)
network_add_node.php
api/v8
Session-based node identity, matches locked Master System Law Part V
KEEP — this is the canonical identity-layer implementation
debug_queue.php / debug_tasks.php
api/v8
Raw-mysqli ops dumps
KEEP (low-risk ops tools, not core brain logic)

This is the real skeleton of a working brain system. Nothing here needs replacing — it needs connecting to a live UI page, which none of it currently has.

GROUP B — Fake flat-JSON "data/network/" universe (one family, not six ideas)
All read/write the same disconnected flat-file world. Zero real AI, zero real DB. build_edges.php hardcodes a single test network_id.
Function/File
Duplicate of (Group A)
Verdict
create_network.php
— (originates the fake universe)
DELETE
compressor.php
Conceptually overlaps cluster_insights.php (both "aggregate signal by type") but toy math, not clustering
DELETE
event_emit.php
No real equivalent — genuinely unique idea (event queue) but zero consumers found anywhere
DELETE (or DEFER if John wants the concept preserved for a future real event bus)
build_edges.php
Duplicate of graph_engine.php's real graph-building, but hardcoded/toy
DELETE — also has the corrupted-trailing-code bug
compare_networks.php
Duplicate of graph_ranker.php's "score the graph" idea, but toy/disconnected
DELETE — also corrupted-trailing-code bug
mesh.php
No real equivalent, aggregates node type counts across the fake universe
DELETE — also corrupted-trailing-code bug

Recommendation: delete this entire family as one decision, not file-by-file — they only exist to serve each other's flat-file format, and the one real capability they gesture at (graph building, ranking, clustering) already exists properly in Group A.

GROUP C — Simulation / agent-dispatch cluster (api/ top-level, ~30 files)
Already documented as 100% simulation — flat JSON in data/agency/, data/brains/, data/cases/, data/network/. Two pieces worth calling out individually rather than deleting the whole cluster outright:
Function/File
Why it's different from the rest of Group C
Triage
model_router.php
The ONE piece that, if built out for real, would make the whole brain concept functional — currently fake stubs echoing prompts back
FINISH — this is the actual missing piece, not dead weight
brain_orchestrator.php + brain_synthesis.php
Architecturally coherent skeleton (prompt → route to 3 models → weighted-confidence synthesis) built entirely on the fake router above
RESTORE once model_router.php is real — structurally sound, just needs a real engine underneath
brain_start.php
Session-based node_id pattern — same idea as network_add_node.php in Group A, which already won and is live
DELETE — superseded, keep only as historical reference if useful
Remaining ~26 files (agent.php, autonomous_engine.php, dossier*.php, cases.php, insights.php, patterns.php, forecast.php, predictor.php, investigator.php, learn.php, feedback.php, alerts.php, summary.php, etc.)
Deterministic toy-math over flat JSON, hardcoded test network_id, no real logic
DELETE — this is the disposable bulk of the cluster


GROUP D — Everything else (divergent, not duplicate)
Function/File
What it is
Triage
widget_registry.php
Static UI-schema reference data, no consumer found
DEFER — interesting design intent (backend-driven widget schemas), but no live UI to wire it to yet
generate_tasks.php
Explicit unfinished stub ("TEMP SAFE OUTPUT, NO LOGIC YET")
FINISH or DELETE — currently misleading since it silently returns fake data as if real
run_worker.php
Real shell_exec() invocation of cli/worker.php
FIX — works, but shell_exec from a web-reachable endpoint is a fragile pattern worth hardening regardless of the cluster's fate
portfolio_engine.php (loadAllCases, buildGlobalGraph)
Real functions, but reads a THIRD data location (data/clients/{client}/cases/{case}/network.json) that nothing else in the audit touches
VERIFY FIRST — before triaging, confirm whether this path is ever actually populated live; the "most real" cluster (predictive_intelligence_engine.php) depends on it
dashboard_engine.php (renderDashboardPath)
Real, simple recommendation-card HTML renderer
DEFER — cross-reference to the open Brain Dashboard fragments thread; doesn't match the "node graph" memory but is a genuine new fragment


THE BUG LIST (independent of any triage decision)
Regardless of what gets kept/deleted, these are real defects worth fixing or removing outright:
Hard syntax errors (won't execute at all): api/v8/agent.php, forecast.php, alerts.php
Corrupted trailing output (~13 files now): insights.php, patterns.php, predictor.php, investigator.php, learn.php, cases.php, memory_store.php, memory_weight.php, summary.php, autonomous_engine.php, build_edges.php, compare_networks.php, mesh.php — all end with a dead echo json_encode($response); exit; after a real echo already fired
Naming collisions: already documented elsewhere (graph_engine.php, recommendation_engine.php, cluster_engine.php, excavation_engine.php, semantic_engine.php each exist in 2+ locations)

BOTTOM LINE — the merge/rebuild question this micro-audit set out to answer
There is no scenario where 2-3 partial implementations get merged into one better brain system. The honest picture:
Group A (real, DB-backed) is the actual foundation — it already works, already matches the locked Master System Law identity design, and just needs a live UI page pointing at it.
Group B (fake flat-JSON universe) and the bulk of Group C (simulation cluster) are disposable — not because they're orphaned, but because Group A already does what they were reaching for, using real data instead of toy JSON.
The one genuinely missing piece is model_router.php — real AI-model calls. Nothing else in any of the 3 locations has attempted this; it's not a duplicate of anything, it's the actual gap between "brain that queries a database" and "brain that reasons."
brain_orchestrator.php/brain_synthesis.php's architecture is worth keeping as the shape for how a real model_router would get consumed — prompt-build → multi-model route → weighted synthesis is a reasonable design, it's just sitting on nothing real.
Recommended next action: decide whether John wants to (a) build a real model_router.php and restore the orchestrator/synthesis skeleton on top of Group A's real data, or (b) treat "brain" as Group A's existing DB-backed functions only, wired into a live page, with AI-model reasoning deferred entirely to a later phase.

