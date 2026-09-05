LEGAiSEE System Audit Backend Layer
Audit type: Macro / system-level, backend this time — not "what's in the UI," but what code actually exists, what calls it, and if nothing does, why not.
Method: for every file in these directories, checked whether any other file in the entire 1,243-file codebase references it at all. Zero references = genuinely dead code, not just "not in the sidebar."

THE HEADLINE FINDING
The codebase is not one system with some rough edges — it's at least three separate, mostly non-communicating systems layered on top of each other, plus a large body of never-connected speculative code. This is the real answer to "why does the system feel bigger than what I can see": most of its size isn't live surface area at all.
The real, live system — shell.php + modules/ (39 files, already fully audited) + a working slice of engine/ and kernel/ underneath it.
An abandoned earlier prototype — index.php, a self-labeled <!--TEST--> "LEGAiSEE Control Center UI" that reads/writes its own flat JSON files directly (bypassing the MySQL database entirely), separate from everything shell.php does.
A large, ambitious, never-wired "autonomous AI agent" architecture — goal-setting, planning, governance, and self-directed execution code that appears to have been designed but never connected to anything that runs.

engine/ — 36 files: 15 are completely dead, several more only reachable through other dead files
Checked every file for real references anywhere in the codebase (not just the sidebar). Result:
Zero references anywhere — fully orphaned: cross_case_learning_compiler.php, decision_governor.php, execution_feedback_engine.php, executive_dashboard_engine.php, goal_alignment.php, goal_engine.php, goal_generator.php, governance_policy_engine.php, graph_mutation_engine.php, insight_mutator.php, long_horizon_planner.php, pattern_stability.php, plain_english_helper.php, system_behavior_spec.php, temporal_memory_engine.php
Referenced only by other dead files (so also effectively dead):
goal_arbitration_engine.php and goal_conflict_resolver.php — only called by goal_engine.php, which is itself dead.
memory_evolution_engine.php — only called by executive_dashboard_engine.php (NOT the real, live modules/executive_dashboard_module.php — a different file with a near-identical name), which is itself dead.
case_manager.php, client_manager.php — only called by create_test_data.php, a data-seeding script, not the live app.
graph_data.php — only called by test_graph.php, a test file.
Reachable only through cli/ or api/v8/, which are themselves not called from the live web app (see below): execution_router.php (via kernel/engine_bindings.php, itself orphaned), pipeline_adapters.php and predictive_intelligence_engine.php (via cli/worker.php), graph_engine.php (via api/v8/build_graph.php).
Genuinely wired into the live system: entity_extraction_engine.php (confirmed already, powers Dig Review/Excavation), cluster_engine.php, cross_case_engine.php, recommendation_engine.php, system_insight_engine.php, decision_engine_v2.php, policy_enforcement_engine.php, portfolio_engine.php, semantic_cluster_engine.php, system_recommendation_engine.php, dashboard_engine.php, reasoning_engine.php.
What the dead cluster actually was trying to be, based on file names alone: a full autonomous-agent system — goals get generated (goal_generator), arbitrated against each other (goal_arbitration_engine), checked for conflicts (goal_conflict_resolver) and alignment (goal_alignment), planned over a long horizon (long_horizon_planner), governed by policy (governance_policy_engine, decision_governor), executed (execution_router, execution_feedback_engine), and the system's own memory evolves over time (memory_evolution_engine, temporal_memory_engine). This is a coherent, ambitious design for a self-directing system — and none of it runs today.

api/ vs. api/v8/ — two different things wearing the same name
Top-level api/ (not v8): search_load.php and files_action.php are confirmed real and live — Search and Files modules call them directly via JavaScript fetch(). This part is genuinely working backend infrastructure.
api.php (a single top-level router file with a legacy() wrapper) — checked every file in the codebase for anything that calls it: nothing does. It has zero callers.
api/v8/ (29 files — insights.php, compressor.php, graph_ranker.php, predictor.php, dossier_v2.php, memory_store.php, agent.php, create_network.php, run_worker.php, and more) is only reachable through api.php's legacy() wrapper — which, per the above, nothing calls. The entire api/v8/ directory is dead code, unreachable from the live site.
cli/ — 9 files, reachable only through the abandoned prototype
meta_goal_engine.php, chain_evolver.php, event_worker.php, autonomous_run.php, chain_generator.php, graph_scheduler.php, worker.php, reasoning_engine.php (a different file from engine/reasoning_engine.php), and a second, different goal_engine.php.
The only thing in the entire codebase that calls into cli/ is index.php — the abandoned prototype (see below) — via a ?run_worker=1 URL parameter that runs shell_exec("php cli/worker.php"). Nothing in the live shell.php/modules/ system touches cli/ at all. I found no cron-job reference in the code confirming whether anything on the server schedules these — that's a live-server question (cPanel's Cron Jobs page), not something visible from the codebase.
index.php — a second, abandoned entry point, still possibly reachable
This is a real finding worth flagging clearly: index.php is a completely separate system from shell.php. It's explicitly labeled <!--TEST--> in its own opening comment. It reads and writes its own flat JSON files under data/portfolio/ and data/clients/ — bypassing the MySQL database that every real module you use relies on. It also contains that ?run_worker=1 trigger described above.
Why this matters practically: index.php is the standard default filename a web server loads when someone visits a folder URL with nothing after it. I checked the site's .htaccess file and found no rule redirecting the bare URL to shell.php — meaning it's plausible that visiting your site's folder root (rather than the shell.php?module=... URLs you actually use) could still serve this old prototype instead of the real system. This needs a live check, not something I can confirm from the code alone — worth visiting your site's bare root URL (no shell.php, no ?module=) and telling me what loads.
ExcavationCommand/ (3 files) — confirmed fully orphaned
Checked every file in the codebase: nothing references ExcavationCommand/ at all. Whatever this was (a second dashboard/planner prototype, per its file names), it's completely disconnected from the live system today.
ProjectManager/ (88 files) — confirmed structurally disconnected, not just "not working yet"
This matches what's already on record as "confirmed NOT working yet" — but the audit adds a sharper finding: nothing in shell.php or modules/ links to it at all. It's not a working feature with bugs; it's a fully separate 88-file sub-application with no live entry point from anywhere you actually navigate.

What this means, plainly
Of the roughly 1,243 PHP files in the codebase, a very large share — the 15+ dead engine/ files, all 29 api/v8/ files plus api.php, all 9 cli/ files, index.php's entire prototype, the 3 ExcavationCommand/ files, and the 88 ProjectManager/ files — are not part of the system you actually use. That's real weight contributing to "I don't know what's working anymore" that has nothing to do with bugs — it's inventory that was never live, or was superseded and left behind.
The live system is meaningfully smaller than the codebase suggests: shell.php, the 39 modules/ files, the working slice of engine/ (about a dozen files) and kernel/, plus api/search_load.php and api/files_action.php.
Real open questions this raises (not fixes yet, per your instruction — just what needs a decision)
Does anything on the live server actually run cli/worker.php on a schedule (cron)? Can't tell from code — needs a look at cPanel's Cron Jobs page.
Does the bare site URL (no shell.php) serve index.php's old prototype? Needs a live look.
Is the ?run_worker=1 trigger on index.php still reachable by anyone who knows the URL, with no login check visible in the code I read? Worth a direct look at whether that file requires authentication at all.
ProjectManager/ and ExcavationCommand/ — are these meant to be revived, or are they safe to formally retire? That's a scope decision, not a bug.

This completes the backend layer. Combined with the 5 earlier files, the audit now covers: all 7 shell.php sidebar sections (~30 modules), the engine/kernel logic layer, and the orphaned/parallel systems (api/v8, cli/, index.php, ExcavationCommand, ProjectManager).

