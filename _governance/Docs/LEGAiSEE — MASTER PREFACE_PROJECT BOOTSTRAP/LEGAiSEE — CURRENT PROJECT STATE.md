LEGAiSEE — CURRENT PROJECT STATE
(Companion to LEGAiSEE_MASTER_PREFACE.md — read the Preface first for the rules, this file for where things actually stand today)
Last updated: 2026-08-24

LEGAiSEE — SESSION UPDATE (paste into Master Preface doc, replaces §10-13 of CURRENT STATE)
10. CURRENT PROJECT PHASE (update)
Phase 1 — System Archaeology: COMPLETE, more complete than this doc's 8-24 snapshot. A second, function-level micro-audit pass (sessions 8-25/8-26) covered engine/ (all 38 files), every previously-untouched top-level directory, and all ~49 loose top-level scripts. Genuinely 100% of the codebase has now been read at least once.
Phase 2 — Triage: UNDERWAY. Several clusters now have real decisions (below), not just documentation. A handful of unambiguous security/bug items were also pulled ahead of formal triage and are being executed directly, since they don't need a KEEP/RESTORE/FIX debate.
Major workflow change: re-uploading the zip is retired. A live-mirrored GitHub repo (https://github.com/carrmultimedia-arch/LEGAiSEE_Repo) now serves as ground truth — Claude clones and greps it directly to verify exact file contents and real callers, no zip, no manual snippet-pasting.
11. TRIAGE DECISIONS MADE THIS SESSION (8/26)
ProjectManager/ — GO, finish it. First step when its turn comes: fix TaskRepository.php's pm_tasks/projects table-name mismatch, then write migrations 010-014, then start the UI layer (currently 100% empty).
Autonomous agent/brain system (5 rebuild attempts total) — reframed as "what's the smartest brain to run the business," not "which PHP batch survives." Plan: KEEP the real DB-backed data layer (graph_engine.php, semantic_cluster_engine.php, graph_ranker.php, get_cases/get_clients.php, network_add_node.php), KEEP the brain_orchestrator.php/brain_synthesis.php architecture shape (prompt → route to models → weighted synthesis), BUILD a real model_router.php (actual AI-model calls — everything today is fake stubs), DELETE the rest as redundant simulation.
Recommendation engine — same standard. DELETE the 2 dead versions (kernel/, engine/). The live one (modules/recommendation_module.php) is a hardcoded lookup table, not real intelligence — kept as a placeholder until the real brain supersedes it.
plain_english_helper.php — RESTORE/INTEGRATE confirmed. Matches John's stated need exactly: turning raw counts (e.g. "500+ nodes and connections") into what that means for the business. Still needs a "where does it get wired in" decision.
Naming-collision duplicate pairs — checked individually, none are exact copies. cluster_engine.php: root version is real/working, engine/ version is a 0-byte empty decoy. graph_view.php: the orphaned views/ copy is actually MORE built out than the live root one — worth reviewing before deleting. view_module.php: orphaned copy is smaller, safe to delete. graph_engine.php/excavation_engine.php/semantic_engine.php collisions remain unverified.
12. ITEMS EXECUTED THIS SESSION (ahead of formal triage — security/dead-file cleanup, verified via the real repo)
index.php (root) — confirmed pre-shell/modules leftover by John, contains an unauthenticated arbitrary-file-read + an unauthenticated worker-trigger button. Fix: delete outright.
view_file.php — confirmed via repo grep: only referenced by index.php. Delete outright.
dashboard.php, dossier_v2.php (root) — confirmed via repo grep: zero real callers, broken wrong-path duplicates of real api/v8/ files. Delete outright.
mission.php, saved_views.php — confirmed via repo grep: zero real callers, both depend only on components/nav.php, which nothing live loads. Delete outright.
Held back, NOT deleted: files.php (confirmed via grep to be the only trigger for indexer.php, the real live search-indexing backend — deleting it would silently break search indexing until indexer.php gets a new trigger point) and search_dual.php (zero callers too, but stays an open "which search implementation wins" decision, not a dead-file cleanup).
Six files above = one cPanel deletion pass, pending John doing the actual deletion.
13. NEXT RECOMMENDED TASK
Continue Stage 2 triage on the still-undecided clusters: UI rendering (2 competing systems), semantic-diff/excavation-session cluster, ingested-content search (real unmet need), and the Goal→Decision→Execution→Feedback→Learning governance pipeline (~17 files, zero callers but architecturally the most complete thing found in the whole audit). Also pending: WO-4 (DB credential consolidation, blocked on John confirming which password is live), WO-5 (setup.php), WO-6 (cli/worker.php crash fix), WO-7 (tools/ bootstrap.php fix).

14. Current State Updates
Update 2026-08-24 (session 2): Phase 2 Triage begun. ProjectManager/ triaged as FINISH — backend/permissions/migrations confirmed clean by code review, DB connectivity now confirmed LIVE (not just read). Full UI build still needed (zero front-end exists, auth wiring incomplete) — scoped as days/weeks of one-file-at-a-time work orders, not started yet. All 3 standing hazard flags RESOLVED: ProjectManager DB password moved out of web root to /home/carrmulti/private/, setup.php deleted (its HTML/CSS saved separately as a UI style reference for later), embed_generate.php's OpenAI key placeholder moved to /home/carrmulti/private/openai_key.php. Next task: triage remaining 5 rebuild families, starting with autonomous agent/brain cluster. 

Update 2026-08-24 (session 3): Full-system documentation pass — 6 micro-audits complete.
Sequencing correction made this session: triage is not done per-cluster as each is examined. Corrected order going forward — (1) finish examining/documenting the entire system, (2) make all triage decisions together, (3) execute repair/fix/delete as one pass, (4) build. No fixing happens until step 3.
Completed full function-level micro-audits of all 6 originally-identified rebuild families:
Brain/autonomous agent cluster — full inventory across 3 locations (engine/, api/v8/, api/ top-level). Real DB-backed foundation exists and works; fake flat-JSON "universe" and most of the simulation cluster are disposable. The one real gap is model_router.php (no real AI-model calls exist anywhere yet).
UI rendering — discovered a third, previously-unknown live shell system (shell.php + module_registry.php + uic_v1.php), confirmed as the likely actual production entry point, distinct from index.php and the earlier-documented pages/shell_template.php. Corrected an earlier finding: global.css is live (hardcoded links), not dead.
Recommendation engine — 4 divergent implementations found, not duplicates. Found a systemic bug: brain_module.php's engine-health checks all point at a nonexistent /system/ folder, so all 5 engine-health flags are permanently false regardless of real status.
Excavation / semantic-diff — "excavation" turned out to mean 3 unrelated things: one real working feature, one fake AI-simulation chain that would write garbage into the real database if triggered (flagged as higher-priority hazard), and one unrelated orphaned dev tool. Also found semantic_diff_engine.php — solid, complete code that's simply never been wired to a caller.
Search — one real, mature, live implementation (hybrid JSON+MySQL) sitting next to an entire earlier-generation prototype system that's fully dead (6 files + 2 orphaned dependencies).
ProjectManager/ — has its own governance/Bible system, unusually reliable. Auth/User/Role/Permission layer is real and validated. Task/Milestone/Comment/Label side has Controllers and API code but no database tables (build stalled mid-batch). Found a real bug: TaskRepository.php queries pm_tasks, but the actual table is projects (unprefixed) — a naming mismatch independent of the missing migrations. Confirmed zero UI exists (empty Views/assets/Components folders).
All findings filed to their own tracking docs, nothing executed yet — everything queues for the single system-wide triage pass once examination is fully complete.
Next: confirm whether any part of the system remains unexamined outside these 6 families; if not, move to Phase 2 triage decisions across everything at once.
15. Current State Updates
8-26-26

modules/ folder is now fully read — all 34 registered files. Summary of this session's findings:
Real, live, working features that are bigger than the original picture suggested:
pm_module.php (922 lines) — a full kanban Project/Task manager, actively wired, using its own projects/pm_tasks/task_sessions tables. This is a third separate "project manager" implementation in the codebase (alongside the standalone ProjectManager/ app and yet another one below).
A genuine end-to-end pipeline: dig-review (confirm/reject findings) → PDF report generation → vault storage — all three pieces are real and actually connected.
Real Stripe payment integration matching your Exhibit pricing tiers.
A real client hub view, anomaly detection, and more.
New problems found (queued for triage, not fixed yet):
brain_module.php (the file actually wired to the "Brain" nav button) was never covered by the earlier brain audit — it's a totally different, simple self-inspection panel, and it's the one with the broken /system/ folder check already on your hazard list.
insight_module.php vs ingest_module.php — near-duplicate files, both live and clickable in the nav, but insight uses old/wrong database column names. Clicking into "Insight" and submitting a form would likely error out.
A third "project manager" folder (modules/project_manager/) sitting unregistered/possibly orphaned.
Two more untouched folders found: _operations/ and _generated/.
Everything's filed to the tracker — no fixes made, per your locked sequencing. Next unexamined chunk is kernel/, api/, engine/, pages/, or the ~45 loose top-level scripts. Want me to keep going into one of those now, or wrap here for this session?
LEGAiSEE — Session Handoff (2026-08-25)
Where things stand
Phase: Full-system documentation/examine phase — NOT complete yet. Phase 2 triage has not started.
Locked sequencing (do not deviate): (1) examine/document EVERY part of the system, nothing skipped → (2) THEN make all triage decisions together, system-wide → (3) THEN execute repair/fix/delete as one pass → (4) THEN build. No fixing or coding happens until step 3. Findings from each completed micro-audit are documented and done, but nothing gets acted on in isolation — everything queues for the single system-wide triage pass.
Fully micro-audited (function-level, done)
Brain/autonomous agent cluster (3 locations: engine/, api/v8/, api/ top-level) → /areas/legaisee-brain-micro-audit.md
UI rendering → /areas/legaisee-ui-micro-audit.md
Recommendation engine → /areas/legaisee-recommendation-micro-audit.md
Excavation/semantic-diff → /areas/legaisee-excavation-semanticdiff-micro-audit.md
Search → /areas/legaisee-search-micro-audit.md
ProjectManager/ → /areas/legaisee-projectmanager-micro-audit.md
modules/ folder (all 34 registered files) → /areas/legaisee-modules-micro-audit.md
kernel/ folder (22 files + model/) → /areas/legaisee-kernel-micro-audit.md — NEWLY COMPLETE this session
What the modules/ pass found
The real, live MySQL-backed feature surface is bigger than the original 6-family list suggested:
pm_module.php — a full working kanban Project/Task manager (its own projects/pm_tasks/task_sessions tables) — a third separate "project manager" implementation, alongside the standalone ProjectManager/ app and a newly-found modules/project_manager/ subfolder.
A real, fully-wired end-to-end pipeline: dig-review (confirm/reject findings) → PDF report generation → vault storage.
Real Stripe payment integration matching the Exhibit pricing tiers.
A real client hub view (joins clients/cases/payments/entities/relationships), and real anomaly detection (orphan/hub entity checks).
New hazards found (queued for triage, nothing fixed):
brain_module.php — the file actually wired to the live "Brain" nav button — was never covered by the earlier brain audit. It's a separate, simple self-inspection panel, and it's the one already flagged with the broken /system/ folder check (all 5 engine-health flags permanently false).
insight_module.php vs ingest_module.php — near-duplicate files, both live/clickable in the nav, but insight writes to memory_ingest using old/mismatched column names — likely errors if used.
A third, unregistered "project manager" folder (modules/project_manager/) — possibly orphaned.
Two more untouched top-level directories found: _operations/, _generated/.
search_module.php and view_module.php (in modules/) may be the true live front-ends for the already-audited search and excavation/semantic-diff clusters — not yet cross-checked against those audits, flagged as a follow-up.
What the kernel/ pass found
A third parallel data paradigm, alongside the flat-JSON case files and the entities/clients MySQL schema: a "page/folder wiki" system (folders, page, page_content, page_relations tables). Confirmed live — ui/file_explorer.php calls into it.
system_health.php (a diagnostics endpoint, separate from brain_module.php's inspection panel) has two real bugs: its module-registry check is silently broken and always reports every real module as an "orphan," and it checks for constants (COMMANDCENTER_BOOTSTRAPPED, DB_AUTHORITY, SYSTEM_MODE) that are never defined anywhere in the codebase.
task_generator.php has a genuine bug — mixes old mysqli-style and new PDO-style code and references a variable that's never set. Would fail if ever called.
Two files confirmed fully dead (zero callers anywhere): engine_bindings.php and guard.php — safe delete candidates.
Possible loose end on something marked "already fixed": the standing note says a stray SQLite DB in setup.php was already deleted, but the root setup.php and a kernel/legaisee.db file still reference each other. May be a different instance than the one already handled — needs a quick check before assuming it's resolved.
Partial correction to the brain audit: part of the "100% fake, no real AI" flat-JSON network system (ingestion_pipeline.php) actually has a real live caller now — the case file-upload feature in modules/ingest_module.php uses it.
Not yet started
Most of api/ (only a handful of endpoints touched across prior audits, plus api/files_action.php and api/search_load.php newly flagged as needed)
engine/ needs a systematic checklist pass (many files touched incidentally, not confirmed complete)
pages/ (only 2 files touched)
~10 entirely untouched top-level directories: Logs/, _backup/, _governance/, _operations/, _generated/, archive/, cli/ (partial), clients/, database/, dossiers/, legaisee/, normalized/, sets/, tools/, views/
~45 loose top-level PHP scripts never opened at all
modules/build_dossier.php (real, feeds report_module.php) not yet deep-read
Bottom line: this will take several more sessions of the same file-by-file treatment before "nothing left to examine" is actually true.
How to resume in a new chat
Read /areas/legaisee-recovery-roadmap.md first — governs sequencing and overall status
Read /areas/legaisee-modules-micro-audit.md and /areas/legaisee-kernel-micro-audit.md for what's already found
Re-upload commandcenter.zip if not already present in the new session's sandbox
Move on to api/, engine/, pages/, or the untouched top-level directories/scripts — keep filing findings to the same per-cluster memory files, don't fix/code anything, just document
Standing cross-cutting things worth remembering (already resolved, don't re-investigate)
ProjectManager/config.php plaintext DB password — FIXED (moved outside web root)
setup.php stray SQLite DB — FIXED (deleted) — but see kernel/ findings above: root setup.php + kernel/legaisee.db may be a separate, not-yet-fixed instance of this same pattern, needs a check
Naming collisions are a recurring pattern across this codebase — now confirmed across brain, project-manager (3x), search/view, cross_case_engine, predictive, and clients_module (live vs .phpbak) — always verify which file is actually being referenced before concluding connectivity
Master reference docs (read as needed, not every session)
/areas/legaisee-master-system-law.md — the approved system-wide spec (identity layer, build order, doctrine)
/areas/legaisee-audit-checklist.md — the EARLIER macro-audit (folder-level, already complete) that this micro-audit phase is going deeper than the audit checklist itself — legaisee-audit-checklist.md is the earlier pass that only went folder-by-folder (confirming a folder exists, roughly what's in it). This current phase is going file-by-file, function-by-function inside each of those folders — which is how it's turning up things the folder-level pass wouldn't have caught, like the insight/ingest column mismatch or the dead engine_bindings.php. So "deeper than" means deeper than that macro-level folder pass, not deeper than some other document. 
pages/ folder done (9 files). Short version: none of it is actually connected to the live system — I grepped everywhere and nothing routes to any file in there.
What was in it:
shell_template.php — turns out to be the original prototype of your live "Grand Lobby" shell. This is literally where that name and the "Wings" terminology came from. It's got its own small bug (points at a module file that doesn't exist), but since nothing loads this file anymore, it's harmless.
network_view.php — a real, working force-graph visualizer, but it's hardcoded to that same fake test ID that keeps showing up elsewhere in the system.
search.php — a real, self-contained search+compare tool that doesn't touch the database at all. Worth noting because it's now the fourth completely separate search/compare implementation I've found across the codebase — none of them share code.
A handful of one-line placeholder pages (Goals, Home, Logs, etc.) — never filled in.
One broken debug scratch file that would crash if it ever ran — but it can't be reached, so no real risk.
One correction to something I told you last time: the insight/ingest duplicate-schema bug I flagged as "new" — turns out that was already found and written up back on 8/23 in your command-center notes. Not a new problem, I just re-found it independently this session. Wanted to be straight about that rather than let it look like a fresh discovery.
Next up: api/ (38 files) or engine/ (38 files) — both similar size, still fully unexamined. Want me to keep going into one of those?
The brain-audit already covered ~30 of these (the brain_*/agency_*/case_*/network_* cluster). Let me read what's left: file.php, recommendations_generate.php, search.php, tree.php, plus a real look at files_action.php and search_load.php (only lightly confirmed as "real" in an earlier pass, not function-audited).
Viewed 2 files, ran 2 commands, created a memory · 1 note
api/ is now fully covered — combining today's pass with the earlier brain audit, which already handled most of it.
What's new from today:
tree.php — solid, real REST API for the tree/folder structure, no issues.
files_action.php — the backend for your "Files" nav item is real and does properly prevent path-traversal tricks... but its sandbox boundary is set to your entire application folder, not just a data directory. So once that page is used, it can read/write/delete/rename anything in the whole codebase — including any config or credential files sitting in there. Not broken, just worth a second look at how wide that access should really be.
One more (5th!) completely different way the code decides where a case's "network" JSON file lives, found in recommendations_generate.php. That brings the count of incompatible network-file-location schemes to five across the system — worth standardizing on one before any real fix to the graph/network features.
search_load.php, file.php, search.php — all small, real, and clean.
Only engine/ (38 files) is left as a full unread folder, plus the pile of untouched top-level directories and ~45 loose scripts. Want me to keep going into engine/ next?
The brain-audit already covered ~30 of these (the brain_*/agency_*/case_*/network_* cluster). Let me read what's left: file.php, recommendations_generate.php, search.php, tree.php, plus a real look at files_action.php and search_load.php (only lightly confirmed as "real" in an earlier pass, not function-audited).
Viewed 2 files, ran 2 commands, created a memory · 1 note
api/ is now fully covered — combining today's pass with the earlier brain audit, which already handled most of it.
What's new from today:
tree.php — solid, real REST API for the tree/folder structure, no issues.
files_action.php — the backend for your "Files" nav item is real and does properly prevent path-traversal tricks... but its sandbox boundary is set to your entire application folder, not just a data directory. So once that page is used, it can read/write/delete/rename anything in the whole codebase — including any config or credential files sitting in there. Not broken, just worth a second look at how wide that access should really be.
One more (5th!) completely different way the code decides where a case's "network" JSON file lives, found in recommendations_generate.php. That brings the count of incompatible network-file-location schemes to five across the system — worth standardizing on one before any real fix to the graph/network features.
search_load.php, file.php, search.php — all small, real, and clean.
Only engine/ (38 files) is left as a full unread folder, plus the pile of untouched top-level directories and ~45 loose scripts. Want me to keep going into engine/ next?
LEGAiSEE — Session Handoff (2026-08-25, end of session)
Where things stand
Phase: Full-system documentation/examine phase — NOT complete yet. Phase 2 triage has not started.
Locked sequencing (do not deviate): (1) examine/document EVERY part of the system, nothing skipped → (2) THEN make all triage decisions together, system-wide → (3) THEN execute repair/fix/delete as one pass → (4) THEN build. No fixing or coding happens until step 3. Findings from each completed micro-audit are documented and done, but nothing gets acted on in isolation — everything queues for the single system-wide triage pass.
Fully micro-audited (function-level, done)
Brain/autonomous agent cluster (3 locations: engine/, api/v8/, api/ top-level) → /areas/legaisee-brain-micro-audit.md
UI rendering → /areas/legaisee-ui-micro-audit.md
Recommendation engine → /areas/legaisee-recommendation-micro-audit.md
Excavation/semantic-diff → /areas/legaisee-excavation-semanticdiff-micro-audit.md
Search → /areas/legaisee-search-micro-audit.md
ProjectManager/ → /areas/legaisee-projectmanager-micro-audit.md
modules/ folder (all 34 registered files) → /areas/legaisee-modules-micro-audit.md
kernel/ folder (22 files + model/) → /areas/legaisee-kernel-micro-audit.md
pages/ folder (9 files) → /areas/legaisee-pages-micro-audit.md
api/ folder (top-level + api/v8/, combined with brain audit) → /areas/legaisee-api-toplevel-audit.md — NEWLY COMPLETE this session
What each newly-completed piece found
modules/: real MySQL-backed feature surface is much bigger than the original 6-family list implied — a full kanban PM system (pm_module.php), a real end-to-end pipeline (dig-review confirm → PDF report → vault storage), real Stripe payments, real client hub view. New hazards: brain_module.php (the actual live "Brain" nav item) was never covered by the earlier brain audit; insight_module.php/ingest_module.php are near-duplicates with mismatched DB columns (note: this specific bug was already found on 8/23 in /areas/legaisee-command-center.md, not new — just re-confirmed); a third orphaned "project manager" folder at modules/project_manager/; two more untouched top-level dirs (_operations/, _generated/).
kernel/: a third parallel data paradigm found (page/folder "wiki" tables — confirmed live via ui/file_explorer.php); system_health.php has 2 real bugs (its module-registry check is silently always-broken, and it checks constants that are never defined anywhere); task_generator.php has a genuine broken-function bug (undefined $pdo); engine_bindings.php and guard.php confirmed fully orphaned (zero callers, safe delete candidates); possible unresolved duplicate of the "stray SQLite DB" issue — root setup.php + kernel/legaisee.db still reference each other despite a standing note saying this was already fixed elsewhere (needs a quick check, may be a second instance not the same one). Also: ingestion_pipeline.php (part of the "fake" flat-JSON network system) has a real live caller from modules/ingest_module.php — partial correction to the brain audit's "100% fake" finding.
pages/: entire folder confirmed orphaned — nothing in the live system routes to any file here. Contains the earlier, unwired prototype of the live Grand Lobby shell (pages/shell_template.php — where the "Grand Lobby"/"Wings" terminology originated), a real self-contained flat-file search+compare tool with no DB dependency (a 4th distinct search/compare implementation), and one confirmed-broken debug scratch file.
api/ (top-level + api/v8, combined with the earlier brain audit which covered the ~30 brain/agency/case files): tree.php is solid. files_action.php (backend for the "Files" nav item) is real and properly path-guarded, but its sandbox boundary is the ENTIRE application directory, not just user data — worth a security-relevant second look at triage. Found a 5th distinct, non-interoperable "network JSON file" naming/location convention (in recommendations_generate.php) — on top of 4 already known, meaning any real fix to the graph/network system needs to standardize this first.
Not yet started
engine/ (38 files) — needs a systematic checklist pass; many files touched only incidentally while chasing other clusters, not confirmed complete
~10 entirely untouched top-level directories: Logs/, _backup/, _governance/, _operations/, _generated/, archive/, cli/ (partial), clients/, database/, dossiers/, legaisee/, normalized/ (partially touched via api/file.php + api/search.php + pages/search.php, but the directory itself not inventoried), sets/, tools/, views/
~45 loose top-level PHP scripts never opened at all
modules/build_dossier.php (real, feeds report_module.php) not yet deep-read
modules/project_manager/ subfolder — found but not deep-read, may be orphaned
search_module.php/view_module.php in modules/ — flagged as possibly being the true live front-ends for the already-audited search/excavation clusters, not yet cross-checked
Bottom line: this will take at least one, probably several more sessions before "nothing left to examine" is actually true. engine/ is the next natural full-folder target — similar size to the api/ pass just completed.
How to resume in a new chat
Read /areas/legaisee-recovery-roadmap.md first — governs sequencing and overall status, has the running list of session updates
Read the specific micro-audit files above as needed for detail
Re-upload commandcenter.zip if not already present in the new session's sandbox
Start with engine/ (38 files) — keep filing findings to a new /areas/legaisee-engine-micro-audit.md file, cross-reference against what the brain audit already covered in engine/ (the brain-related ~9 files) so it isn't re-audited
After engine/, move to the untouched top-level directories/loose scripts
Don't fix/code anything — just document, per the locked sequencing
Standing cross-cutting things worth remembering (already resolved, don't re-investigate)
ProjectManager/config.php plaintext DB password — FIXED (moved outside web root)
setup.php stray SQLite DB — FIXED (deleted) — but see kernel/ findings above: root setup.php + kernel/legaisee.db may be a separate, not-yet-fixed instance of this same pattern, needs a check
Naming collisions are a recurring pattern across this codebase — confirmed across brain, project-manager (3x), search/view/compare (4x), cross_case_engine, predictive, clients_module (live vs .phpbak), and network-JSON file location (5 different conventions) — always verify which file/path is actually being referenced before concluding connectivity
Master reference docs (read as needed, not every session)
/areas/legaisee-master-system-law.md — the approved system-wide spec (identity layer, build order, doctrine)
/areas/legaisee-audit-checklist.md — the EARLIER macro-audit (folder-level only, already complete) that this file-by-file micro-audit phase is going deeper than
/areas/legaisee-command-center.md — separate, larger operational/live-debugging history (production deployment, work orders, UI redesign plans) — a different narrative thread than this pure-code-audit phase, but shares some overlapping findings (cross-check before calling something "new")
The engine/ folder audit is done — all 38 files now examined (10 already covered by the brain audit, 2 by the recommendation audit, 26 newly read this session). Here's what matters most:
The big one: your real background worker is probably crashing every time it runs
cli/worker.php is the actual production task processor — the one invoked by run_worker.php via shell_exec. Inside its main loop, for any case that just has a tasks/queue.json file sitting there, it unconditionally calls three functions, and two of them don't exist anywhere in your codebase:
clusterNodes() — never defined (the file that's supposed to define it, cluster_engine.php, is empty — 0 bytes)
generateRecommendationsFromPath() — never defined (a different function name exists, but not this one)
generateSystemInsights() — never defined (called at the very end of the script)
That means the worker almost certainly fatal-errors on its first real case, before finishing its run. This is a live bug, not a "someday" documentation note — worth knowing about now even though we're holding off on fixes until the full-system triage.
A fourth "autonomous brain" rebuild, fully orphaned
Beyond the 3 brain rebuilds already found earlier, engine/ contains yet another attempt: a complete Goal → Decision → Execution → Feedback → Learning pipeline (~17 files). It's actually the most architecturally complete design found anywhere in the system — a real closed loop on paper. But nothing in the live app calls any of it, and a few pieces would crash even if wired up (undefined functions in goal_engine.php and decision_governor.php, plus a couple of SQL-injection-shaped queries).
One genuine bright spot
plain_english_helper.php — a solid, 293-line library that turns module output into plain-language explanations — is fully built and completely unwired. Worth flagging as a "restore this" candidate rather than a delete, since it's exactly the kind of non-technical explanation layer you've said you want.
Everything's filed in a new legaisee-engine-micro-audit.md, and the roadmap is updated. Per the handoff's next step, the remaining unexamined territory is the ~10 untouched top-level directories and ~45 loose scripts — want me to keep going into those now, or pause here?
Pass 1 done: top-level directories
Here's what matters:
A fifth orphaned autonomous system, in cli/. Besides worker.php (already known broken from last session), the other 8 files in cli/ form a completely separate "event → goal alignment → multi-chain reasoning → chain evolution" pipeline — genuinely clever design on paper, zero live callers anywhere, its own sixth-plus flat-file data convention. It even has its own internal bug: a $$score typo (should be $score) that quietly breaks its core scoring logic even if you ran it standalone.
Your Logs folder confirms the worker.php crash actually happened. Real production log entries from May 2026 show a real client/case writing to exactly the queue file path that triggers the undefined-function crash I found last session. Not proof, but strong circumstantial evidence it's hit in the wild, not just in theory.
A whole maintenance toolkit (tools/) is broken for a dumb, easy-to-understand reason. Seven real, well-built scripts for clustering/summarizing your data — including one that actually calls OpenAI for real (unlike the fake stubs found in the brain audit) — all fail immediately because they point at the wrong bootstrap file. The root bootstrap.php is just a 2-line "this is deprecated" comment with no code in it; they should be pointing at modules/utils/bootstrap.php. This one's a simple fix once we get to that phase.
Two more naming collisions, extending the pattern we keep finding: graph_view.php and view_module.php each exist in two places — one live, one an orphaned lookalike.
Possible lead on your standing "stray SQLite DB" mystery — a database migration for the tree_nodes table uses SQLite syntax even though your config says MySQL-only, and tree_nodes is a real, live table. Might explain where that stray database keeps coming from.
Everything's filed. Ready for pass 2 — the ~45 loose top-level scripts — whenever you say go.



Legaisee Recovery Roadmap
Summary
John's 6-phase plan for what happens after the system audit — triage, documentation, site map, wiring/testing, final UI polish. Read this to see which phase is active and what's next.
Details
John's 6-phase plan, decided once the full macro-audit (legaisee-audit-checklist) was complete:
Audit (DONE) — the complete documented audit: what's working, broken, orphaned, unconnected, across every system/section
Triage — for every piece found, decide: keep, restore, fix, finish, vs. genuinely deletable
Document the full system — the first real "what was built/started" view of all of LEGAiSEE, organized into sections/"wings" (naming TBD) covering every major and minor piece
Site map design — decide the real information architecture: which modules get their own page/view, which get combined onto a shared labeled dashboard, etc.
Wiring & testing — fix and connect everything found in the audit; create simple, deliberately ugly "test page" style scaffolding as needed just to prove functionality works, before appearance matters
Final OS/UI — make it all polished and usable, last, only once everything underneath actually works
Document this whole process as it happens — possibly starting as just a To-Do table of contents broken into chapters; undecided yet whether this next phase needs a full Bible-style spec (like the ProjectManager attempt had) or something lighter
Current phase: audit is NOT yet complete system-wide (see below) — Phase 2 triage has not begun.
Sequencing correction (2026-08-24): triage decisions are not made or acted on per-cluster as each gets examined. Full sequence, all-together, in this order: (1) finish examining/documenting EVERY part of the system with nothing left unexamined, (2) THEN make all triage decisions across the whole system together, (3) THEN execute repair/fix/delete as one pass, (4) THEN build. No fixing/repair/coding work happens until step 3 — fixing burns tokens on code and shouldn't start mid-examination. Findings from each completed micro-audit are documented and complete, but do not get executed in isolation — they wait and feed into the single system-wide triage-then-execute pass alongside every other cluster.
Formalized a 3-document Google Docs bootstrap protocol to carry context between sessions without relying on conversation history: LEGAiSEE_MASTER_PREFACE.md (rules, rarely changes), LEGAiSEE_CURRENT_STATE.md (where the project stands, updated every session), and LEGAiSEE_MASTER_TOC.md (living documentation skeleton) all live as sections in one published Google Doc John maintains and shares by link each session — read in that order at the start of any session, only then the specific audit/code files the bounded task needs. Standing instruction going forward: at the start of any new LEGAiSEE session, fetch that doc first (John will provide the current link) before relying on local memory files for project status.
Phase 2 triage starting unit: the 6 rebuild families (autonomous agent/brain 3x-rebuilt, UI rendering live-vs-abandoned, recommendation engine, semantic-diff/excavation-session cluster, ingested-content search, ProjectManager/) plus 3 standing hazard flags (ProjectManager plaintext DB password, embed_generate.php plaintext API key placeholder, setup.php stray SQLite DB) — not folder-by-folder
Original 6-family list (brain, UI, recommendation, excavation/semantic-diff, search, ProjectManager) is now fully micro-audited. Discovered mid-session that the true unexamined surface is much larger than that list implied — see legaisee-modules-micro-audit for the newly-found modules/ folder (39 files, in progress) and its own "still to do beyond modules/" list covering kernel/, api/, engine/, pages/, and ~10 entirely untouched top-level directories plus ~45 unopened loose PHP scripts. "Nothing left to examine" is not yet true system-wide — will take several more sessions of the same file-by-file treatment.
Update (2026-08-25): modules/ folder is now FULLY read (all 34 registered files). Turned up 3 more naming-collision families beyond the original list (brain — modules/brain_module.php is the real live nav item, not covered by the earlier brain cluster audit; project-manager — a 3rd implementation at modules/project_manager/; possibly search/view). Also found a real live end-to-end pipeline (dig-review confirm → PDF report → vault storage) and a live-looking bug (insight_module.php vs ingest_module.php have mismatched DB column names, both separately registered/reachable). Two more untouched top-level dirs found: _operations/, _generated/ (added to the still-to-examine list). Full detail in legaisee-modules-micro-audit.
Update (2026-08-25, same session): kernel/ folder (22 files + model/) is now FULLY read → legaisee-kernel-micro-audit. Found a THIRD parallel data paradigm (page/folder wiki tables — confirmed live, called from ui/file_explorer.php), a broken system_health.php self-check (2 real bugs), a genuinely-broken task_generator.php function (undefined $pdo), 2 confirmed-orphaned files (engine_bindings.php, guard.php — safe delete candidates), and a possible re-discovery of the "stray SQLite DB" issue (root setup.php + kernel/legaisee.db still reference it — may not actually be the same instance the standing hazard note says is already fixed, needs a quick confirm-or-correct pass before triage). Also confirms part of the "fake" flat-JSON network system (ingestion_pipeline.php) has a real live caller from modules/ingest_module.php — partial correction to legaisee-brain-micro-audit's "100% fake" Group B finding.
Update (2026-08-25, same session): pages/ folder (9 files) is now FULLY read → legaisee-pages-micro-audit. Whole folder confirmed orphaned — nothing in the live system routes to any file in pages/. Contains an earlier, unwired prototype of the live Grand Lobby shell (pages/shell_template.php — this is where the "Grand Lobby"/"Wings" terminology originated), a real self-contained flat-file search+compare tool with no DB dependency (a 4th distinct search/compare implementation, not overlapping with the other 3), and one confirmed-broken debug scratch file. Correction: the insight_module.php/ingest_module.php duplicate-schema issue flagged as "NEW" in legaisee-modules-micro-audit was actually already found and documented on 2026-08-23 in legaisee-command-center — not a new discovery, just independently re-confirmed this session.
Update (2026-08-25, same session): api/ folder is now FULLY covered → legaisee-api-toplevel-audit (combined with the earlier legaisee-brain-micro-audit, which already handled the ~30 brain/agency/case files and all of api/v8/). New findings: files_action.php's file-manager sandbox is scoped to the ENTIRE application directory, not just user data, so the live Files nav item can reach the app's own source/config files; and a 5th distinct, non-interoperable "network JSON file" naming convention was found in recommendations_generate.php, on top of the 4 already known — any real fix to the graph/network system needs to standardize this first. Remaining unexamined: engine/ (38 files, needs a systematic pass — many touched only incidentally so far), ~10 untouched top-level directories, ~45 loose top-level scripts.
Update (2026-08-25, new session): engine/ folder (38 files) is now FULLY covered → legaisee-engine-micro-audit (10 files already handled by legaisee-brain-micro-audit and 2 by legaisee-recommendation-micro-audit were cross-referenced, not re-audited; 26 files newly read). Two major new findings: (1) cli/worker.php — the REAL, live background worker actually invoked by the system — is likely fatally broken on every real run via undefined-function calls (clusterNodes(), generateRecommendationsFromPath(), generateSystemInsights()) inside its main per-case processing loop; flagged to John as worth knowing sooner rather than later, ahead of the normal triage-then-fix sequencing. (2) A fourth, previously-undiscovered "autonomous" rebuild attempt was found — a full Goal→Decision→Execution→Feedback→Learning governance pipeline (~17 files) — entirely orphaned (zero live callers) and reading/writing a fourth separate flat-file convention (data/system/*.json), on top of the 3 brain rebuilds already known. Also found one strong restore candidate: plain_english_helper.php, a built-but-never-wired plain-language explanation layer matching John's stated UI preferences. Remaining unexamined: ~10 untouched top-level directories, ~45 loose top-level scripts.
Update (2026-08-26, new session, pass 1 of 2): top-level directories are now FULLY covered → legaisee-toplevel-dirs-micro-audit. _operations/ and _generated/ don't exist in this zip; archive/, dossiers/, sets/ are genuinely empty. Key findings: (1) cli/ contains a FIFTH orphaned autonomous subsystem (event/goal/multi-chain-reasoning pipeline, ~8 files, zero live callers, its own real internal bug — a $$score typo that breaks its scoring logic even standalone) on top of the 4 already known. (2) Real Logs/ files provide corroborating evidence the cli/worker.php crash bug found last session likely fired in actual production. (3) tools/ — a real, coherent clustering-maintenance suite (7 files, real PDO/OpenAI code) — is currently 100% broken because it requires the deprecated root bootstrap.php (a 2-line comment with no code) instead of the real modules/utils/bootstrap.php. (4) 2 more live-vs-orphaned naming collisions confirmed: root graph_view.php (live) vs views/graph_view.php (orphaned, different/bigger file), and modules/view_module.php (live, registered) vs views/view_module.php (orphaned, different file). (5) database/migrations/'s tree_nodes table uses SQLite syntax despite MySQL-only config — flagged as the most promising lead yet on the still-open "stray SQLite DB" question from legaisee-kernel-micro-audit. Remaining: ~45 loose top-level PHP scripts (pass 2, same session).
Update (2026-08-26, same session, pass 2 of 2 — FULL-SYSTEM EXAMINE PHASE NOW COMPLETE): the ~49 loose top-level PHP scripts are now FULLY covered → legaisee-loose-scripts-audit. This closes out the examine/document phase per the locked sequencing — nothing left unexamined system-wide. Two urgent items flagged to John directly, ahead of normal triage timing: (1) 3 separate plaintext live DB-credential exposures across config.local.php, temp_dashboard.php, and view_ingest.php (2 different username/password pairs for the same production DB — worth checking which is current); (2) an unauthenticated arbitrary-file-read bug in root index.php (likely the actual document-root home page) via an unvalidated ?view_file= parameter — could directly expose config.local.php's password — plus an unauthenticated one-click "Run Worker" button on the same page that triggers the already-known cli/worker.php crash. Also found: setup.php is still live and NOT deleted (corrects this file's own standing note below — its POST handler can still recreate a stray SQLite DB); the likely precise fix location for one of the two worker.php undefined-function bugs (a real, working clusterNodes() sits in root-level cluster_engine.php — pipeline_adapters.php's require just points at the wrong, empty file in engine/ instead); 2 more real live features (a "Memory Ingest Wing" transcript archiver, since superseded by modules/ingest_module.php per that module's own docblock; and prospect.php, a well-built, confirmed-live "Prospect Dossier" tool wired into shell.php); and a whole disconnected earlier-generation front-end shell (index.php/files.php/search_dual.php/mission.php, tied together by components/nav.php, which itself has zero live callers).
CORRECTION to the earlier resolved-issues note above: "setup.php stray SQLite DB — FIXED (deleted)" is stale/inaccurate — per legaisee-loose-scripts-audit, setup.php itself is still present, unauthenticated, and web-reachable, and its POST handler still creates ./legaisee.db if one doesn't exist. Whatever was fixed was at most the resulting .db file at some point in time, not the script that can recreate it. Needs a real fix at triage, not just documentation.
SYSTEM CHANGE (2026-08-26): given the 4hr-lockout/3-4-response-per-zip-upload reality, replaced the "triage everything, then execute everything" plan with a rolling work-order queue → legaisee-work-orders, now THE entry point for any new LEGAiSEE session (read before anything else, before even asking for the zip). First batch of 7 fully-specified, ready-to-execute work orders written (5 security/Priority 0, 2 bug-fix/Priority 1). This file remains the phase-level status log; legaisee-work-orders is where actual next-action detail now lives.



Legaisee Work Orders
Summary
THE entry point for any new LEGAiSEE chat session — read this file FIRST, before anything else, even before the zip is re-uploaded. Queue of bounded, self-contained, ready-to-execute work orders generated from the completed system-wide audit, so a new session can act in 1-2 responses instead of re-deriving findings.
Details
Created 2026-08-26 because re-uploading commandcenter.zip only buys John 3-4 responses before a 4hr lockout, and the full-system examine phase (documented across legaisee-brain-micro-audit, legaisee-ui-micro-audit, legaisee-recommendation-micro-audit, legaisee-excavation-semanticdiff-micro-audit, legaisee-search-micro-audit, legaisee-projectmanager-micro-audit, legaisee-modules-micro-audit, legaisee-kernel-micro-audit, legaisee-pages-micro-audit, legaisee-api-toplevel-audit, legaisee-engine-micro-audit, legaisee-toplevel-dirs-micro-audit, legaisee-loose-scripts-audit) took days across many sessions. Purpose of this file: turn that finished audit into small, independently-executable tasks so future sessions spend their limited turns fixing, not re-reading.
HOW TO USE THIS FILE (for future Claude sessions): (1) Read this file first. (2) Pick the next PENDING work order in priority order (or the one John names). (3) Ask John to upload commandcenter.zip if not already present. (4) Open ONLY the specific file(s) named in that work order — do not re-audit the whole system, the audit is done and its findings are trusted. (5) Make the exact change described. (6) Deliver the fixed file(s) for John to paste into cPanel's online editor (his current workflow — no FileZilla). (7) Mark the work order DONE in this file with the date, and add a one-line note if anything differed from the plan. (8) Stop — don't pull in unrelated findings from the audit files unless John asks.
Sequencing note: this REPLACES the original "triage everything together, then execute everything as one pass" plan from legaisee-recovery-roadmap — that plan assumed unlimited session length, which isn't the reality. Work orders below are still roughly grouped by priority, but each is independent and can be done in any order John wants, standalone.
PRIORITY 0 — SECURITY, do these first regardless of anything else
WO-1: Remove/gate the unauthenticated arbitrary-file-read in index.php. File: root index.php. The if(isset($_GET['view_file'])){ ... echo file_get_contents($file); } block has zero path validation — currently lets anyone read config.local.php (live DB password) or any other server file readable by PHP. Fix: either delete this block entirely, or restrict it to a realpath-checked whitelist directory the way a proper file browser should. STATUS: PENDING.
WO-2: Same bug, same fix, in view_file.php. File: root view_file.php. Identical unvalidated $_GET['file'] → file_get_contents() pattern. STATUS: PENDING.
WO-3: Gate or remove the "Run Worker" button in index.php. Same file as WO-1: shell_exec("php cli/worker.php 2>&1") fires on a plain unauthenticated GET (?run_worker=1). At minimum requires a login check; better, remove the web-triggerable version entirely and only run the worker via actual cron. Can be bundled into the same delivery as WO-1. STATUS: PENDING.
WO-4: Consolidate/rotate the DB credentials. Files: root config.local.php (password ends @), temp_dashboard.php and view_ingest.php (both hardcode a DIFFERENT password ending $, plus bypass kernel_db() entirely). Needs John's input first: which password is actually current on the live server? Once known: (a) confirm/rotate the real one, (b) delete the two hardcoded raw-PDO connections in temp_dashboard.php/view_ingest.php and have them use kernel_db() like the rest of the app. STATUS: PENDING — blocked on John confirming current live password.
WO-5: Auth-gate or delete setup.php. File: root setup.php. Still live, unauthenticated, can recreate a stray SQLite DB (legaisee.db) via POST. Since the real MySQL DB is already initialized and working, simplest fix is likely just deleting this file outright (John to confirm nothing still depends on visiting it). STATUS: PENDING.
PRIORITY 1 — real bugs breaking live features
WO-6: Fix the cli/worker.php crash (partial, high-value fix). File: engine/pipeline_adapters.php. Its require_once __DIR__ . '/cluster_engine.php' resolves to the empty (0-byte) engine/cluster_engine.php. A real, working clusterNodes($case_id) already exists in root-level cluster_engine.php — change the require to point there instead (__DIR__ . '/../cluster_engine.php'). This fixes 1 of the 3 undefined-function crashes in the worker. The other 2 (generateRecommendationsFromPath(), generateSystemInsights()) have no existing real implementation anywhere — those need either a new function written, or removing those calls from cli/worker.php/pipeline_adapters.php until a real implementation exists. Recommend doing the clusterNodes fix now (WO-6) and deciding on the other two as a separate, smaller follow-up work order once John says which of the two he actually wants working. STATUS: PENDING.
WO-7: Fix the tools/ + export_report.php bootstrap.php dependency. Files: all 7 files in tools/ (build_clusters.php, build_relations.php, name_clusters.php, build_cluster_summaries.php, build_cluster_summaries_ai.php, extract_cluster_insights.php, detect_cluster_opportunities.php) plus root export_report.php. All require_once __DIR__ . "/../bootstrap.php" (or root bootstrap.php directly), which is a dead 2-line deprecated stub — none of these currently work. Fix: swap that require for root db.php (require __DIR__.'/../db.php'; from tools/, or require __DIR__.'/db.php'; from export_report.php) — db.php is the real, working 4-line wrapper already used correctly elsewhere. STATUS: PENDING.
Still-undecided items (need John's call before a work order can be written — not yet actionable)
The whole orphaned "Goal→Decision→Execution→Feedback→Learning" governance pipeline (~17 files in engine/) and the separate ~8-file cli/ event/chain-reasoning pipeline — both fully documented, both zero live callers. Decision needed: restore/wire up, or delete as dead weight? Nothing to execute until John picks one.
plain_english_helper.php — flagged as a strong restore candidate (built, unwired, matches John's plain-language preference). Needs a decision on WHERE to wire it in before this becomes a work order.
The 3+ "Files" implementations (files.php, api/files_action.php, modules/ file tools) and the sandbox-too-broad issue shared by the first two — needs a decision on which one is the intended long-term Files feature before writing a consolidation work order.
search_dual.php vs the other 4 already-known search/compare implementations — needs cross-check + a "which one wins" decision.
The naming-collision file pairs (graph_view.php x2, view_module.php x2, cluster_engine.php x2, and the long list in legaisee-recovery-roadmap) — low-risk to just delete the confirmed-orphaned half of each pair once John gives a blanket "yes, delete orphaned duplicates" go-ahead; not written as individual work orders yet since there are ~10+ of these and they're cheap to batch into one cleanup work order later.
STILL TO DO
Write WO-8+ for the naming-collision cleanup batch once John gives the go-ahead to treat "confirmed zero callers" as sufficient grounds for deletion without asking file-by-file.
After Priority 0 + Priority 1 are cleared, revisit legaisee-recovery-roadmap's original Phase 2/3/4 plan and decide whether the remaining "still-undecided" items above get their own work orders one at a time, or a batched decision session.

Legaisee Current State
Summary
LEGAiSEE — CURRENT PROJECT STATE. The single living-status file — read this every session, right after legaisee-preface.md. Gets REWRITTEN each session, not endlessly appended to.
Details
Companion to legaisee-preface (rules) — read the Preface first, this file for where things actually stand today. Supersedes the now-deprecated status roles of legaisee-recovery-roadmap, legaisee-audit-checklist, and legaisee-work-orders — those three files still hold real detail (pointed to below) but are no longer where a new session should start.
CURRENT PROJECT PHASE
Phase 1 — System Archaeology: COMPLETE, and more complete than John's own 8-24 doc snapshot recorded. That doc (last updated 2026-08-24) reported ~404/1,243 files (~33%) individually read via an earlier folder-level macro-audit. Since then (sessions 2026-08-25 and 2026-08-26), Claude ran a second, deeper function-level micro-audit pass covering engine/ (all 38 files), every previously-untouched top-level directory, and all ~49 loose top-level scripts — genuinely 100% of the codebase has now been read at least once, most of it at function-level detail, not just connectivity-traced.
Phase 2 — Triage: UNDERWAY. Several clusters now have real decisions (see list below). A batch of unambiguous security/bug items was pulled ahead of formal triage and executed directly — Priority 0 is 4/5 done, Priority 1 is fully done (see "Items already actioned" below). Do not treat this as Phase 2 having started for the big undecided clusters (UI rendering, semantic-diff/excavation, ingested-content search) — those are still open.
Next bounded task: continue Stage 2 triage on the still-undecided clusters (see NEXT RECOMMENDED TASK below). WO-5 is now closed.
setup.php — RESOLVED
WO-5 done: John deleted setup.php live on the server (8/27). GitHub repo not yet synced to reflect this — repo will show it present until John's next push; don't treat that as contradicting this.
Genuinely live/working today (confirmed across both audit passes)
files_action.php + search_load.php (api/) — Files and Search modules
modules/files_module.php + api/files_action.php — a "Windows/macOS style" file browser for the app's OWN filesystem (not ingested case content — no keyword search over normalized/ content exists live anywhere)
ui_engine.php + layout.php via the 'view' module — page-compare/executive-diff tool (depends on lib/semantic_diff_engine.php)
modules/recommendation_module.php — hardcoded pattern-to-action lookup table (the real, simplified recommendation logic)
modules/brain_module.php — stripped-down read-only health check only (no intel display, no graph)
entity_extraction_engine.php (engine/) — real PDO-based entity/relationship extraction, wired into excavation_module.php and prospect.php
prospect.php — confirmed-live "Prospect Dossier" tool, wired into shell.php
Major dead/orphaned clusters (unit of Stage 2 triage decisions)
The original 6 rebuild families from the 8-24 doc still stand; 3 more have since surfaced. Full detail for all of these lives in the micro-audit files listed under "Where the detail lives" below — this file only tracks the decision status.
Autonomous agent/brain system — rebuilt from scratch 3x (engine/, api/v8/, api/ top-level ~30 files). DECISION (8/26): John's framing is macro, not "which PHP batch survives" — goal is the smartest possible brain/intelligence backend to run the LEGAiSEE business, full stop. None of the existing attempts qualifies as-is: Group A (graph_engine.php, semantic_cluster_engine.php, cluster_insights.php, graph_ranker.php, get_cases/get_clients.php, network_add_node.php) is the only real DB-backed logic across all 5 rebuild attempts, but has no actual AI reasoning in it. brain_orchestrator.php+brain_synthesis.php (api/ top-level) is the best architectural SHAPE found (prompt-build → route to 3 models → weighted synthesis) but sits on fake model_router.php stubs. Plan: KEEP Group A as the real data foundation, KEEP the orchestrator/synthesis shape, BUILD a real model_router.php (actual OpenAI/Claude/Gemini calls), DELETE the rest of Group B/C simulation code as redundant. The two newer orphaned governance pipelines (family 7: Goal→Decision→Execution→Feedback→Learning, ~17 files; family 8: cli/ event/chain-reasoning, ~8 files) are more architecturally complete on paper but zero live callers and each has its own undefined-function bugs — not adopted outright, but decision_engine_v2.php→system_insight_engine.php→cross_case_engine.php (the one internally-working sub-chain in family 7) is worth reusing when the real brain gets built. Execution detail (what actually gets built) still needs its own work order once WO-1 through WO-7 are cleared.
UI rendering — two full systems (live: inline HTML/CSS everywhere; abandoned: registry-based component system + global.css, itself incomplete). DECISION: pending.
Recommendation engine — 2 dead versions (kernel/, engine/) vs 1 live simplified version. DECISION (8/26): same macro standard as the brain family — judge by what best runs the business, not which file survives. DELETE the 2 dead versions (kernel/'s marketing-keyword matcher, engine/'s per-case JSON version). The current live one (modules/recommendation_module.php) is a hardcoded pattern-lookup table, not real intelligence — treat it as a placeholder to eventually be superseded by real brain/model_router output once that's built, not a permanent KEEP.
Semantic-diff/excavation-session cluster — earlier data-organization model, one live doorway via Compare/view tool. DECISION: pending.
File browser vs. content search — browser DID get rebuilt and is live. DECISION (8/28): CORRECTED via direct repo read — pasted-transcript content (memory_ingest.raw_text) IS already full-text searched live by modules/search_module.php, so this need is largely met, not "unmet anywhere" as previously framed. Dead-prototype remnants (api/search.php, lib/archive_search.php, pages/search.php, search.phpbak, test_search.php, components/nav.php) DELETED (8/28, WO-9). Real remaining gap, narrower than first thought: uploaded file content is not full-text searchable — live search only matches files.filename, not what's inside the file; uploaded files land in normalized/ and a case's network.json graph but nothing indexes their content. The documents table (also content-searched by the same module) has zero live INSERT anywhere — wired up but nothing ever writes to it, a dead/unused table, not a functioning feature. Open build candidate if John wants this closed: extract/index uploaded-file content into documents (or extend files search to scan normalized/ directly) — not yet scoped as a work order.
ProjectManager/ (88 files) — NOT ad-hoc. Disciplined standalone PM app, real MVC + 9-table migrations + full permission system, backend genuinely finished and clean. Every UI-facing chapter is a 0-byte placeholder. Most recoverable dead cluster in the whole audit. SECURITY: config.php had a live plaintext DB password — already FIXED (moved outside web root, confirmed via live dbcheck.php test — this one's real, unlike the setup.php discrepancy above). DECISION (8/26): GO — finish it. Next concrete step when its turn comes: fix the TaskRepository.php pm_tasks/projects table-name mismatch, write migrations 010-014, then start on the UI layer (currently 100% empty).
Goal→Decision→Execution→Feedback→Learning governance pipeline (~17 files in engine/) — a 4th independent autonomous-system rebuild attempt, zero live callers, own 4th flat-file convention (data/system/*.json). DECISION (8/28, re-verified live against GitHub repo, not just the audit doc): this is a design-reuse call, not delete-vs-keep. KEEP-AS-DESIGN: decision_engine_v2.php → system_insight_engine.php → cross_case_engine.php — internally sound, no undefined calls, ready to plug into the future brain build as-is. REWRITE (not restorable — the missing logic was never written): goal_engine.php (top-level code calls loadGoalProposals()/saveActiveGoals(), neither defined anywhere; also has a live SQL-injection shape via unescaped $case_id in raw mysqli) and decision_governor.php (evaluateExecution() calls isGoalAligned()/isPlanConsistent(), neither defined anywhere). KEEP-AS-DESIGN, orphaned but internally coherent, no bugs found (wire up as-is when the real brain build reaches this stage): goal_arbitration_engine.php, goal_conflict_resolver.php, goal_generator.php, goal_alignment.php, governance_policy_engine.php, execution_router.php, execution_feedback_engine.php, cross_case_learning_compiler.php, policy_enforcement_engine.php, long_horizon_planner.php, pattern_stability.php, insight_mutator.php, system_behavior_spec.php. Same SQL-injection pattern as goal_engine.php also found in temporal_memory_engine.php — fix required before either ever gets wired to real input. Not an isolated execution item — feeds directly into item 1's future brain-build work order, not its own separate build.
[NEW, found 8-26] cli/ event/goal/multi-chain-reasoning pipeline (~8 files) — a 5th independent autonomous-system attempt, zero live callers, own flat-file convention, has its own internal bug ($$score typo breaks its scoring logic even standalone). DECISION: pending.
Duplicate root-vs-nested file pairs — John asked (8/26): are these exact copies, or different code? CONFIRMED DIFFERENT CODE in every pair checked so far, none are simple copies: cluster_engine.php (root = real, working clusterNodes(); engine/ = literally 0 bytes, not a copy at all, an empty decoy) — safe DELETE of the engine/ side. graph_view.php (root, 115 lines, live/wired) vs views/graph_view.php (312 lines, orphaned) — genuinely different, and the orphaned one is actually MORE built out — worth a quick look for functionality worth merging before deleting, not a blind delete. view_module.php (modules/, 263 lines, live/registered) vs views/view_module.php (122 lines, orphaned) — genuinely different, smaller orphaned version, safer to just delete. recommendation_engine.php (kernel/ vs engine/) — different domains entirely (marketing-keyword matching vs per-case JSON), not copies of each other or of the live modules/recommendation_module.php — see item 3 above. dashboard.php/dossier_v2.php (root) — broken copy-paste duplicates of api/v8/ originals with wrong relative-path depth, zero callers — safe DELETE. STILL UNVERIFIED (named as colliding in the original macro pass but never line-diffed): graph_engine.php, excavation_engine.php, semantic_engine.php — don't assume same disposition as the confirmed pairs until checked.
plain_english_helper.php — 293-line library, converts raw module output into plain-language explanations across 11 module types (relations, graph, anomaly, insight, recommendation, cluster, cross-case, time-intelligence, generic). John confirmed (8/26) this matches exactly what he wants it for: e.g. turning "500+ nodes and connections" into what that actually means for the business and how it helps him run it — not raw numbers. DECISION: RESTORE/INTEGRATE, confirmed. Still needs a "where does this get wired in" answer — natural candidates are the graph/node view and any brain/recommendation output surface, to be picked when this item's work order comes up.
Items already actioned ahead of formal triage (unambiguous — security/crash bugs, not real triage calls)
Full detail and exact fix instructions in legaisee-work-orders (still valid as a task list, just no longer the session entry point):
WO-1 (index.php arbitrary-file-read): DONE — confirmed dead leftover, deleted via cPanel.
WO-2 (view_file.php, same bug): DONE — confirmed zero other callers, deleted via cPanel.
WO-3 ("Run Worker" trigger, same file as WO-1): DONE — resolved automatically by WO-1's deletion.
WO-4 (DB credentials): DONE — password rotated (config.local.php only, going forward); temp_dashboard.php and view_ingest.php consolidated off their own hardcoded PDO connections onto the shared kernel_db().
WO-5 (setup.php): DONE (8/27) — deleted live by John.
WO-6 (cli/worker.php crash, partial fix): DONE — engine/pipeline_adapters.php's cluster_engine.php require repointed to the real root-level file. 2 of 3 crash points in the worker remain unfixed (no real implementation exists anywhere yet for those two functions).
WO-7 (tools/ + export_report.php dead bootstrap.php dependency): DONE — all 8 files swapped to the real db.php wrapper.
WO-8 (dead-file batch, confirmed via direct repo grep): DONE for dashboard.php, dossier_v2.php, mission.php, saved_views.php (all deleted). HELD BACK (not deleted, real reasons): files.php (only trigger for the real search indexer, indexer.php — needs a new trigger point first) and search_dual.php (open "which search wins" decision, not a dead-file cleanup).
Known hazards carried into triage (naming collisions, etc.)
graph_engine.php, recommendation_engine.php, cluster_engine.php, excavation_engine.php, semantic_engine.php, graph_view.php, view_module.php each exist as 2+ genuinely different files in different locations.
5 different files named bootstrap.php across the codebase (root — dead stub, kernel/, modules/utils/ — the real one, ProjectManager/, plus a vendor file).
database/migrations/'s tree_nodes table uses SQLite syntax despite a MySQL-only config — possible link to the setup.php/legaisee.db discrepancy above, unconfirmed.
embed_generate.php has a plaintext OpenAI key PLACEHOLDER (not a real key) in a web-accessible file — not currently leaking, but relocate before ever filling in a real one.
Where the detail lives (Part I reference material — open only what the current bounded task needs)
Original 8-24 macro-audit reports: LEGAiSEE_System_Audit_Graph_Entities / Excavation / Intelligence_Engines / Command / Planning_Clients_Tools_and_Summary / Backend_and_Orphaned_Systems / Kernel / Top_Level_Files / Bootstrap_Recommendations / UI / API_TopLevel / ProjectManager / Final_Small_Folders (these live in John's Google Doc + his own Google Docs copies, not all individually in Claude's memory). Deeper 8-25/8-26 function-level micro-audits (in Claude's memory, aliases in parens): legaisee-brain-micro-audit, legaisee-ui-micro-audit, legaisee-recommendation-micro-audit, legaisee-excavation-semanticdiff-micro-audit, legaisee-search-micro-audit, legaisee-projectmanager-micro-audit, legaisee-modules-micro-audit, legaisee-kernel-micro-audit, legaisee-pages-micro-audit, legaisee-api-toplevel-audit, legaisee-engine-micro-audit, legaisee-toplevel-dirs-micro-audit, legaisee-loose-scripts-audit.
NEXT RECOMMENDED TASK
Continue Stage 2 triage on the still-undecided clusters: UI rendering (item 2), semantic-diff/excavation-session (item 4), and the cli/ event/chain-reasoning pipeline (item 8). Items 5 and 7 are now decided (8/28). Nothing open from WO-8 anymore.

Legaisee Current State
Summary
LEGAiSEE — CURRENT PROJECT STATE. The single living-status file — read this every session, right after legaisee-preface.md. Gets REWRITTEN each session, not endlessly appended to.
Details
Companion to legaisee-preface (rules) — read the Preface first, this file for where things actually stand today. Supersedes the now-deprecated status roles of legaisee-recovery-roadmap, legaisee-audit-checklist, and legaisee-work-orders — those three files still hold real detail (pointed to below) but are no longer where a new session should start.
CURRENT PROJECT PHASE
Phase 1 — System Archaeology: COMPLETE, and more complete than John's own 8-24 doc snapshot recorded. That doc (last updated 2026-08-24) reported ~404/1,243 files (~33%) individually read via an earlier folder-level macro-audit. Since then (sessions 2026-08-25 and 2026-08-26), Claude ran a second, deeper function-level micro-audit pass covering engine/ (all 38 files), every previously-untouched top-level directory, and all ~49 loose top-level scripts — genuinely 100% of the codebase has now been read at least once, most of it at function-level detail, not just connectivity-traced.
Phase 2 — Triage: UNDERWAY. Several clusters now have real decisions (see list below). A batch of unambiguous security/bug items was pulled ahead of formal triage and executed directly — Priority 0 is 4/5 done, Priority 1 is fully done (see "Items already actioned" below). Do not treat this as Phase 2 having started for the big undecided clusters (UI rendering, semantic-diff/excavation, ingested-content search) — those are still open.
Next bounded task: continue Stage 2 triage on the still-undecided clusters (see NEXT RECOMMENDED TASK below). WO-5 is now closed.
setup.php — RESOLVED
WO-5 done: John deleted setup.php live on the server (8/27). GitHub repo not yet synced to reflect this — repo will show it present until John's next push; don't treat that as contradicting this.
Genuinely live/working today (confirmed across both audit passes)
files_action.php + search_load.php (api/) — Files and Search modules
modules/files_module.php + api/files_action.php — a "Windows/macOS style" file browser for the app's OWN filesystem (not ingested case content — no keyword search over normalized/ content exists live anywhere)
ui_engine.php + layout.php via the 'view' module — page-compare/executive-diff tool (depends on lib/semantic_diff_engine.php)
modules/recommendation_module.php — hardcoded pattern-to-action lookup table (the real, simplified recommendation logic)
modules/brain_module.php — stripped-down read-only health check only (no intel display, no graph)
entity_extraction_engine.php (engine/) — real PDO-based entity/relationship extraction, wired into excavation_module.php and prospect.php
prospect.php — confirmed-live "Prospect Dossier" tool, wired into shell.php
Major dead/orphaned clusters (unit of Stage 2 triage decisions)
The original 6 rebuild families from the 8-24 doc still stand; 3 more have since surfaced. Full detail for all of these lives in the micro-audit files listed under "Where the detail lives" below — this file only tracks the decision status.
Autonomous agent/brain system — rebuilt from scratch 3x (engine/, api/v8/, api/ top-level ~30 files). DECISION (8/26): John's framing is macro, not "which PHP batch survives" — goal is the smartest possible brain/intelligence backend to run the LEGAiSEE business, full stop. None of the existing attempts qualifies as-is: Group A (graph_engine.php, semantic_cluster_engine.php, cluster_insights.php, graph_ranker.php, get_cases/get_clients.php, network_add_node.php) is the only real DB-backed logic across all 5 rebuild attempts, but has no actual AI reasoning in it. brain_orchestrator.php+brain_synthesis.php (api/ top-level) is the best architectural SHAPE found (prompt-build → route to 3 models → weighted synthesis) but sits on fake model_router.php stubs. Plan: KEEP Group A as the real data foundation, KEEP the orchestrator/synthesis shape, BUILD a real model_router.php (actual OpenAI/Claude/Gemini calls), DELETE the rest of Group B/C simulation code as redundant. The two newer orphaned governance pipelines (family 7: Goal→Decision→Execution→Feedback→Learning, ~17 files; family 8: cli/ event/chain-reasoning, ~8 files) are more architecturally complete on paper but zero live callers and each has its own undefined-function bugs — not adopted outright, but decision_engine_v2.php→system_insight_engine.php→cross_case_engine.php (the one internally-working sub-chain in family 7) is worth reusing when the real brain gets built. Execution detail (what actually gets built) still needs its own work order once WO-1 through WO-7 are cleared.
UI rendering — two full systems (live: inline HTML/CSS everywhere; abandoned: registry-based component system + global.css, itself incomplete). DECISION: pending.
Recommendation engine — 2 dead versions (kernel/, engine/) vs 1 live simplified version. DECISION (8/26): same macro standard as the brain family — judge by what best runs the business, not which file survives. DELETE the 2 dead versions (kernel/'s marketing-keyword matcher, engine/'s per-case JSON version). The current live one (modules/recommendation_module.php) is a hardcoded pattern-lookup table, not real intelligence — treat it as a placeholder to eventually be superseded by real brain/model_router output once that's built, not a permanent KEEP.
Semantic-diff/excavation-session cluster — earlier data-organization model, one live doorway via Compare/view tool. DECISION: pending.
File browser vs. content search — browser DID get rebuilt and is live. DECISION (8/28): CORRECTED via direct repo read — pasted-transcript content (memory_ingest.raw_text) IS already full-text searched live by modules/search_module.php, so this need is largely met, not "unmet anywhere" as previously framed. Dead-prototype remnants (api/search.php, lib/archive_search.php, pages/search.php, search.phpbak, test_search.php, components/nav.php) DELETED (8/28, WO-9). Real remaining gap, narrower than first thought: uploaded file content is not full-text searchable — live search only matches files.filename, not what's inside the file; uploaded files land in normalized/ and a case's network.json graph but nothing indexes their content. The documents table (also content-searched by the same module) has zero live INSERT anywhere — wired up but nothing ever writes to it, a dead/unused table, not a functioning feature. Open build candidate if John wants this closed: extract/index uploaded-file content into documents (or extend files search to scan normalized/ directly) — not yet scoped as a work order.
ProjectManager/ (88 files) — NOT ad-hoc. Disciplined standalone PM app, real MVC + 9-table migrations + full permission system, backend genuinely finished and clean. Every UI-facing chapter is a 0-byte placeholder. Most recoverable dead cluster in the whole audit. SECURITY: config.php had a live plaintext DB password — already FIXED (moved outside web root, confirmed via live dbcheck.php test — this one's real, unlike the setup.php discrepancy above). DECISION (8/26): GO — finish it. Next concrete step when its turn comes: fix the TaskRepository.php pm_tasks/projects table-name mismatch, write migrations 010-014, then start on the UI layer (currently 100% empty).
Goal→Decision→Execution→Feedback→Learning governance pipeline (~17 files in engine/) — a 4th independent autonomous-system rebuild attempt, zero live callers, own 4th flat-file convention (data/system/*.json). DECISION (8/28, re-verified live against GitHub repo, not just the audit doc): this is a design-reuse call, not delete-vs-keep. KEEP-AS-DESIGN: decision_engine_v2.php → system_insight_engine.php → cross_case_engine.php — internally sound, no undefined calls, ready to plug into the future brain build as-is. REWRITE (not restorable — the missing logic was never written): goal_engine.php (top-level code calls loadGoalProposals()/saveActiveGoals(), neither defined anywhere; also has a live SQL-injection shape via unescaped $case_id in raw mysqli) and decision_governor.php (evaluateExecution() calls isGoalAligned()/isPlanConsistent(), neither defined anywhere). KEEP-AS-DESIGN, orphaned but internally coherent, no bugs found (wire up as-is when the real brain build reaches this stage): goal_arbitration_engine.php, goal_conflict_resolver.php, goal_generator.php, goal_alignment.php, governance_policy_engine.php, execution_router.php, execution_feedback_engine.php, cross_case_learning_compiler.php, policy_enforcement_engine.php, long_horizon_planner.php, pattern_stability.php, insight_mutator.php, system_behavior_spec.php. Same SQL-injection pattern as goal_engine.php also found in temporal_memory_engine.php — fix required before either ever gets wired to real input. Not an isolated execution item — feeds directly into item 1's future brain-build work order, not its own separate build.
[NEW, found 8-26] cli/ event/goal/multi-chain-reasoning pipeline (~8 files) — a 5th independent autonomous-system attempt, zero live callers, own flat-file convention, has its own internal bug ($$score typo breaks its scoring logic even standalone). DECISION: pending.
Duplicate root-vs-nested file pairs — John asked (8/26): are these exact copies, or different code? CONFIRMED DIFFERENT CODE in every pair checked so far, none are simple copies: cluster_engine.php (root = real, working clusterNodes(); engine/ = literally 0 bytes, not a copy at all, an empty decoy) — safe DELETE of the engine/ side. graph_view.php (root, 115 lines, live/wired) vs views/graph_view.php (312 lines, orphaned) — genuinely different, and the orphaned one is actually MORE built out — worth a quick look for functionality worth merging before deleting, not a blind delete. view_module.php (modules/, 263 lines, live/registered) vs views/view_module.php (122 lines, orphaned) — genuinely different, smaller orphaned version, safer to just delete. recommendation_engine.php (kernel/ vs engine/) — different domains entirely (marketing-keyword matching vs per-case JSON), not copies of each other or of the live modules/recommendation_module.php — see item 3 above. dashboard.php/dossier_v2.php (root) — broken copy-paste duplicates of api/v8/ originals with wrong relative-path depth, zero callers — safe DELETE. STILL UNVERIFIED (named as colliding in the original macro pass but never line-diffed): graph_engine.php, excavation_engine.php, semantic_engine.php — don't assume same disposition as the confirmed pairs until checked.
plain_english_helper.php — 293-line library, converts raw module output into plain-language explanations across 11 module types (relations, graph, anomaly, insight, recommendation, cluster, cross-case, time-intelligence, generic). John confirmed (8/26) this matches exactly what he wants it for: e.g. turning "500+ nodes and connections" into what that actually means for the business and how it helps him run it — not raw numbers. DECISION: RESTORE/INTEGRATE, confirmed. Still needs a "where does this get wired in" answer — natural candidates are the graph/node view and any brain/recommendation output surface, to be picked when this item's work order comes up.
Items already actioned ahead of formal triage (unambiguous — security/crash bugs, not real triage calls)
Full detail and exact fix instructions in legaisee-work-orders (still valid as a task list, just no longer the session entry point):
WO-1 (index.php arbitrary-file-read): DONE — confirmed dead leftover, deleted via cPanel.
WO-2 (view_file.php, same bug): DONE — confirmed zero other callers, deleted via cPanel.
WO-3 ("Run Worker" trigger, same file as WO-1): DONE — resolved automatically by WO-1's deletion.
WO-4 (DB credentials): DONE — password rotated (config.local.php only, going forward); temp_dashboard.php and view_ingest.php consolidated off their own hardcoded PDO connections onto the shared kernel_db().
WO-5 (setup.php): DONE (8/27) — deleted live by John.
WO-6 (cli/worker.php crash, partial fix): DONE — engine/pipeline_adapters.php's cluster_engine.php require repointed to the real root-level file. 2 of 3 crash points in the worker remain unfixed (no real implementation exists anywhere yet for those two functions).
WO-7 (tools/ + export_report.php dead bootstrap.php dependency): DONE — all 8 files swapped to the real db.php wrapper.
WO-8 (dead-file batch, confirmed via direct repo grep): DONE for dashboard.php, dossier_v2.php, mission.php, saved_views.php (all deleted). HELD BACK (not deleted, real reasons): files.php (only trigger for the real search indexer, indexer.php — needs a new trigger point first) and search_dual.php (open "which search wins" decision, not a dead-file cleanup).
Known hazards carried into triage (naming collisions, etc.)
graph_engine.php, recommendation_engine.php, cluster_engine.php, excavation_engine.php, semantic_engine.php, graph_view.php, view_module.php each exist as 2+ genuinely different files in different locations.
5 different files named bootstrap.php across the codebase (root — dead stub, kernel/, modules/utils/ — the real one, ProjectManager/, plus a vendor file).
database/migrations/'s tree_nodes table uses SQLite syntax despite a MySQL-only config — possible link to the setup.php/legaisee.db discrepancy above, unconfirmed.
embed_generate.php has a plaintext OpenAI key PLACEHOLDER (not a real key) in a web-accessible file — not currently leaking, but relocate before ever filling in a real one.
Where the detail lives (Part I reference material — open only what the current bounded task needs)
Original 8-24 macro-audit reports: LEGAiSEE_System_Audit_Graph_Entities / Excavation / Intelligence_Engines / Command / Planning_Clients_Tools_and_Summary / Backend_and_Orphaned_Systems / Kernel / Top_Level_Files / Bootstrap_Recommendations / UI / API_TopLevel / ProjectManager / Final_Small_Folders (these live in John's Google Doc + his own Google Docs copies, not all individually in Claude's memory). Deeper 8-25/8-26 function-level micro-audits (in Claude's memory, aliases in parens): legaisee-brain-micro-audit, legaisee-ui-micro-audit, legaisee-recommendation-micro-audit, legaisee-excavation-semanticdiff-micro-audit, legaisee-search-micro-audit, legaisee-projectmanager-micro-audit, legaisee-modules-micro-audit, legaisee-kernel-micro-audit, legaisee-pages-micro-audit, legaisee-api-toplevel-audit, legaisee-engine-micro-audit, legaisee-toplevel-dirs-micro-audit, legaisee-loose-scripts-audit.
NEXT RECOMMENDED TASK
Continue Stage 2 triage on the still-undecided clusters: UI rendering (item 2), semantic-diff/excavation-session (item 4), and the cli/ event/chain-reasoning pipeline (item 8). Items 5 and 7 are now decided (8/28). Nothing open from WO-8 anymore.

So the real split for WO-14, deletion list (confirmed dead application code, zero live callers, no design value):
All 11 files in ui/: component.php, component_boot.php, component_contract.php, component_registry.php, components.php, layout_contract.php, layout_engine.php, registry.php, theme.php, ui.php, ui_boot.php
From root /components/: card.php, compare.php, nav.php, ui_card.php, ui_folder_tree.php, ui_tag.php
The duplicate ingest mockup file: ui/components/ingest_exec snap.php
Keep as design reference, not code (no action needed, just leaving these alone):
ui/components/ingestforshell.php (the ingest mockup)
components/blur_bkgd, components/scroll_fx (visual effect demos)
components/legaisee_web_colors.md, components/legaisee_web_colors.png (color palette reference)
That's 18 files to delete. Want me to log this as WO-14 now?
yes
Read and edited memory · 1 note
Logged as WO-14, marked done, and current-state updated.
Here's the file list to delete via cPanel — 18 files total:
ui/ folder (11 files):
 component.php, component_boot.php, component_contract.php, component_registry.php, components.php, layout_contract.php, layout_engine.php, registry.php, theme.php, ui.php, ui_boot.php
Root /components/ folder (6 files):
 card.php, compare.php, nav.php, ui_card.php, ui_folder_tree.php, ui_tag.php
ui/components/ subfolder (1 file):
 ingest_exec snap.php (the duplicate — keep ingestforshell.php, that one stays)
Everything else in those folders (ingestforshell.php, blur_bkgd, scroll_fx, legaisee_web_colors.md, legaisee_web_colors.png) stays untouched as design reference.
That closes out UI rendering. Two Stage 2 clusters remain: semantic-diff/excavation-session, and the cli/ event/chain-reasoning pipeline. Want to keep going into one of those, or stop here for now?



Legaisee Current State  8-30-26
Summary
LEGAiSEE — CURRENT PROJECT STATE. The single living-status file — read this every session, right after legaisee-preface.md. Gets REWRITTEN each session, not endlessly appended to.
Details
Companion to legaisee-preface (rules) — read the Preface first, this file for where things actually stand today. Supersedes the now-deprecated status roles of legaisee-recovery-roadmap, legaisee-audit-checklist, and legaisee-work-orders — those three files still hold real detail (pointed to below) but are no longer where a new session should start.
CURRENT PROJECT PHASE
Phase 1 — System Archaeology: COMPLETE. Genuinely 100% of the codebase read at least once, most of it at function-level detail.
Phase 2 — Triage: COMPLETE (8/30). Every major dead/orphaned cluster (items 1-10 below) now has a real decision behind it — nothing left undecided. A long run of unambiguous security/bug items and cluster-triage cleanups has already been executed directly rather than waiting for a separate execute pass (see "Items already actioned" below, WO-1 through WO-16).
Phase 3 — Execution/Build: UNDERWAY. What's left is no longer "decide what to do with X," it's "go build/finish Y." See NEXT RECOMMENDED TASK at the bottom.
Genuinely live/working today (confirmed across all audit passes)
files_action.php + search_load.php (api/) — Files and Search modules
modules/files_module.php + api/files_action.php — a "Windows/macOS style" file browser for the app's OWN filesystem
modules/search_module.php + api/search_load.php — hybrid search; full-text searches pasted-transcript content (memory_ingest.raw_text) live today. Gap: uploaded FILE content is not indexed, only filenames match (see item 5).
ui_engine.php + layout.php via the 'view' module — page-compare/executive-diff tool. Requires lib/semantic_diff_engine.php but never calls it — real upgrade opportunity flagged under item 4.
modules/recommendation_module.php — hardcoded pattern-to-action lookup table (placeholder logic, not real intelligence — see item 3)
modules/brain_module.php — stripped-down read-only health check only (no intel display, no graph)
entity_extraction_engine.php (engine/) — real PDO-based entity/relationship extraction, wired into excavation_module.php and prospect.php
modules/excavation_module.php — real, substantial, live feature; keyword-based signal extraction + case clustering
prospect.php — confirmed-live "Prospect Dossier" tool, wired into shell.php
shell.php — confirmed (8/30) as the actual production entry point; every live module routes through it via kernel/module_registry.php
ProjectManager/ — backend database foundation is now genuinely functional (pm_projects, pm_tasks, pm_milestones, pm_comments, pm_notes all live, correctly isolated from the shared DB's unrelated tables). Zero UI exists yet — see item 6.
Major dead/orphaned clusters — ALL DECIDED
Full technical detail for all of these lives in the micro-audit files listed under "Where the detail lives" below — this file tracks decision + execution status only.
Autonomous agent/brain system (5 total rebuild attempts across engine/, api/v8/, api/ top-level, engine/'s governance pipeline, cli/'s chain-reasoning pipeline). DECISION: KEEP Group A (graph_engine.php, semantic_cluster_engine.php, cluster_insights.php, graph_ranker.php, get_cases/get_clients.php, network_add_node.php) as the real DB-backed data foundation. KEEP the brain_orchestrator.php+brain_synthesis.php shape (prompt-build → route to 3 models → weighted synthesis). BUILD a real model_router.php (actual OpenAI/Claude/Gemini calls — currently fake stubs). Also KEEP-AS-DESIGN: decision_engine_v2.php→system_insight_engine.php→cross_case_engine.php (from item 7) and chain_evolver.php+chain_generator.php's "compete strategies, score outcomes, evolve" idea (from item 8, WO-16). Not yet started as a build — this is the biggest remaining piece of work.
UI rendering — DONE (WO-14). Dead registry-based component system deleted (18 files). shell.php confirmed as live entry point. 4 design-reference files intentionally kept for future UI polish.
Recommendation engine — DONE (WO-10). 2 dead versions deleted. Live version (modules/recommendation_module.php) is a hardcoded lookup table — treat as a placeholder to be superseded once the real brain/model_router (item 1) exists.
Semantic-diff/excavation-session cluster — DONE (WO-15). Fake AI-simulation chain deleted as a security-adjacent priority item (was unauthenticated + wrote fabricated entities into the real production DB). ExcavationCommand/ dev-tool deleted. Real, solid lib/semantic_diff_engine.php kept — flagged as an upgrade opportunity (the live 'view' module requires it but never calls it, running weaker JS logic instead). Not yet scoped as a WO.
Ingested-content search — DONE (WO-9). Dead prototype generation deleted. Pasted-transcript content already fully searchable live — earlier "unmet need" framing was wrong. Real, narrower remaining gap: uploaded file content isn't indexed, only filenames match. Open build candidate, not yet scoped as a WO.
ProjectManager/ — GO, in progress. Table-name mismatch fixed (WO-12). Migrations 010-013 written and successfully run (WO-13) after surfacing and fixing 2 real blocking bugs (Milestone.php was a wrong copy of Client.php; CommentRepository.php/PermissionRepository.php were broken/wrong duplicate drafts) plus a major schema collision (the shared DB already had unrelated projects/tasks tables — fixed by renaming every ProjectManager table to a pm_ prefix). Backend is now genuinely functional, not just superficially "validated" like Batch 1-6 claimed. Next real gap: zero UI exists — Views folder completely empty. This is the next concrete build task for this cluster.
Goal→Decision→Execution→Feedback→Learning governance pipeline (~17 files in engine/) — DONE, design-reuse decision made. KEEP-AS-DESIGN: decision_engine_v2.php→system_insight_engine.php→cross_case_engine.php (internally sound, ready to plug into the future brain build). REWRITE (not restorable): goal_engine.php, decision_governor.php (both call functions that were never defined anywhere). KEEP-AS-DESIGN, no bugs, wire up later: the other 13 files. Feeds directly into item 1's build, not its own separate work.
cli/ event/goal/multi-chain-reasoning pipeline (~8 files) — DONE (WO-16). Purpose: an earlier, separate attempt at self-improving case-triage automation, redundant with item 7's better-built version. DELETE 6 files (event_worker.php, goal_engine.php [cli/ version], reasoning_engine.php, graph_scheduler.php, meta_goal_engine.php, autonomous_run.php) — pending John's execution via cPanel. KEEP-AS-DESIGN: chain_evolver.php + chain_generator.php — a genuinely novel idea (compete strategies, score real outcomes, evolve) not duplicated anywhere else.
Duplicate root-vs-nested file pairs — DONE for the confirmed pairs. cluster_engine.php (engine/ side, 0-byte decoy) — DELETED (WO-11). views/view_module.php (smaller orphaned copy) — DELETED (WO-11). views/graph_view.php — held back intentionally, MORE built out than the live copy, needs a look before deleting (not yet done). graph_engine.php/excavation_engine.php/semantic_engine.php collisions — excavation_engine.php's collision resolved as part of item 4 (the root one was the fake-chain file, deleted); graph_engine.php and semantic_engine.php still unverified.
plain_english_helper.php — DECIDED: RESTORE/INTEGRATE, confirmed match for John's plain-language use case. Not yet wired in — still needs a "where does this get wired in" call (natural candidates: graph/node view, or any brain/recommendation output surface) before this becomes a WO.
Items already actioned (WO-1 through WO-16)
Full detail and exact fix instructions in legaisee-work-orders (task list, not the session entry point). All DONE except where noted:
WO-1/2/3 (index.php + view_file.php arbitrary-file-read, "Run Worker" trigger): DONE — deleted.
WO-4 (DB credentials): DONE — password rotated, 2 files consolidated onto shared kernel_db().
WO-5 (setup.php): DONE — deleted.
WO-6 (cli/worker.php crash, partial): DONE — 1 of 3 crash points fixed (bad require path). 2 remain unfixed, no real implementation exists yet for those functions.
WO-7 (tools/ + export_report.php dead bootstrap dependency): DONE.
WO-8 (dead-file batch: dashboard.php, dossier_v2.php, mission.php, saved_views.php): DONE. Held-back items (files.php, indexer.php, search_dual.php) resolved and deleted too, once confirmed part of the old dead search-prototype generation, not the live search feature.
WO-9 (ingested-content search cleanup + correction): DONE — 6 files deleted.
WO-10 (dead recommendation-engine versions): DONE — 3 files deleted.
WO-11 (decoy duplicate files): DONE — 2 files deleted. views/graph_view.php intentionally held back.
WO-12 (ProjectManager table-name fix): DONE.
WO-13 (ProjectManager migrations 010-013 + schema-collision fix): DONE — full detail in item 6 above.
WO-14 (UI rendering cleanup): DONE — 18 files deleted, 4 kept as design reference.
WO-15 (semantic-diff/excavation cleanup): DONE — 3 files + 1 folder deleted (security-adjacent priority).
WO-16 (cli/ chain-reasoning cleanup): PENDING — 6 files identified for deletion, not yet executed by John.
Known hazards carried forward
graph_engine.php, semantic_engine.php still have unverified naming-collision pairs (see item 9) — don't assume disposition until checked.
5 different files named bootstrap.php across the codebase (root — dead stub, kernel/, modules/utils/ — the real one, ProjectManager/, plus a vendor file).
database/migrations/'s old tree_nodes table uses SQLite syntax despite a MySQL-only config — unconfirmed link to any live issue.
embed_generate.php has a plaintext OpenAI key PLACEHOLDER (not a real key) in a web-accessible file — not currently leaking, but relocate before ever filling in a real one.
Where the detail lives
Deeper function-level micro-audits (in Claude's memory, aliases in parens): legaisee-brain-micro-audit, legaisee-ui-micro-audit, legaisee-recommendation-micro-audit, legaisee-excavation-semanticdiff-micro-audit, legaisee-search-micro-audit, legaisee-projectmanager-micro-audit, legaisee-modules-micro-audit, legaisee-kernel-micro-audit, legaisee-pages-micro-audit, legaisee-api-toplevel-audit, legaisee-engine-micro-audit, legaisee-toplevel-dirs-micro-audit, legaisee-loose-scripts-audit. Original 8-24 macro-audit reports live in John's own Google Docs, not individually in Claude's memory.
NEXT RECOMMENDED TASK
Triage is fully complete. Remaining work, roughly in order of value: (a) execute WO-16's pending delete list, (b) the brain-family build (model_router.php + orchestrator/synthesis skeleton) — the single biggest remaining piece, (c) ProjectManager's UI layer (backend now works, zero views exist), (d) plain_english_helper.php's wire-in decision, (e) the semantic_diff_engine.php upgrade (WO-15's flagged item), (f) views/graph_view.php's held-back merge-before-delete review.

9-1-26
---
name: legaisee-current-state
description: LEGAiSEE — CURRENT PROJECT STATE. The single living-status file — read this every session, right after legaisee-preface.md. Gets REWRITTEN each session, not endlessly appended to.
---

## CURRENT PROJECT PHASE
Phase 1 — System Archaeology: COMPLETE.
Phase 2 — Triage: COMPLETE (8/30).
Phase 3 — Execution/Build: UNDERWAY, reframed (9/1). The work-order queue is still the right unit of execution, but it is no longer the definition of "done." See MACRO VIEW RULING and REAL V1 CHECKPOINT below.

## MACRO VIEW RULING (John, 9/1 — standing rule, now in Master Preface)
A companion GPT-sourced vision doc proposed 25 "2026 competitive" features (temporal knowledge graph, evidence/provenance, contradiction engine, MCP agent interface, "Wings" architecture, etc.), tiered V1/V2/V3 by its own author. John's ruling: none of it gets sidelined — all folded into the macro view/plan now, only sequenced (postponed in execution order) for V2/V3, never dropped out of view. V1's schema/architecture must be built to support all of it later so the foundation is never re-poured. Practical effect: when tree_nodes (WO-18) gets built/confirmed, it should carry provenance, timestamp, status/lifecycle, and clean relationship fields from day one.

## REAL V1 CHECKPOINT — CORRECTED DEFINITION (9/1)
First framing this session ("prospect in → dossier out") was WRONG, corrected by John: the Shallow Dig/mini-dig → dossier is just the lead-magnet FUNNEL ENTRY, not the business.

The actual V1 checkpoint: prospect in → Full Signal Excavation across the 40+ channel taxonomy → artifact-level evidence gathered and graded (Hierarchy of Truth Tier 1-4, 3-Source Rule) → composed into the delivered Authority Marketing System. That full path, run once end-to-end (even ugly), is what "V1 works" means — not each module individually passing its own test.

Three connected gaps sit directly on that path, none yet closed:
1. Real confidence scoring — brain_synthesis.php currently outputs rand(60,95), a random placeholder, not real Hierarchy-of-Truth-based scoring. Breaks artifact-proof traceability, not just cosmetic.
2. Findings → Authority System object — no Recommendation/Initiative data object exists yet between reviewed Findings and delivery; report_module.php just formats a thin dossier pull. Confirmed V1 gap in Master System Law Part IX, not v2 polish.
3. 40+ channel excavation verification — the channel taxonomy and workflow are designed but not confirmed running end-to-end against real live client data in the current build.

These three gaps, not the WO queue, are the real next-phase target. WO-18 (tree_nodes/identity layer) still has to land first since the whole pipeline is meant to key off node_id per Master System Law Part V.

## Genuinely live/working today
- files_action.php + search_load.php (api/) — Files and Search modules
- modules/files_module.php + api/files_action.php — app's own filesystem browser
- modules/search_module.php + api/search_load.php — hybrid search, live full-text on pasted-transcript content; uploaded FILE content not indexed, only filenames match
- ui_engine.php + layout.php via the 'view' module — page-compare/diff tool; lib/semantic_diff_engine.php required but never called (upgrade opportunity)
- modules/recommendation_module.php — hardcoded lookup table, placeholder logic
- modules/brain_module.php — stripped-down read-only health check only
- entity_extraction_engine.php (engine/) — real PDO-based entity/relationship extraction, wired into excavation_module.php and prospect.php
- modules/excavation_module.php — real, substantial, live feature
- prospect.php — confirmed-live Prospect Dossier tool, wired into shell.php
- shell.php — confirmed production entry point, every live module routes through it
- ProjectManager/ — backend functional (pm_projects, pm_tasks, pm_milestones, pm_comments, pm_notes all live). Zero UI exists yet.

## Major dead/orphaned clusters — ALL DECIDED
1. Autonomous agent/brain system — KEEP Group A data foundation + orchestrator/synthesis shape. model_router.php now real for Claude (WO-17), OpenAI/Gemini gated behind unconfigured keys. Real Hierarchy-of-Truth confidence scoring (currently rand(60,95)) is the most important unresolved piece — see REAL V1 CHECKPOINT.
2. UI rendering — DONE (WO-14). 18 dead files deleted, shell.php confirmed live entry.
3. Recommendation engine — DONE (WO-10). Live version is a placeholder lookup table pending real brain/model_router.
4. Semantic-diff/excavation-session cluster — DONE (WO-15). Fake AI-simulation chain deleted (was writing fabricated data into production). Real semantic_diff_engine.php kept, unused, flagged as upgrade.
5. Ingested-content search — DONE (WO-9). Pasted-transcript content fully searchable live. Uploaded file content still not indexed.
6. ProjectManager/ — backend done, zero UI. Real but sequenced behind the checkpoint gaps, not on the critical path to a working client journey.
7. Goal→Decision→Execution→Feedback→Learning pipeline (~17 files) — KEEP-AS-DESIGN, feeds item 1's build.
8. cli/ event/goal/chain-reasoning pipeline — DONE (WO-16), 6 redundant files deleted, 2 kept as design.
9. Duplicate root-vs-nested file pairs — mostly resolved; views/graph_view.php held back (more built-out, needs review before deleting); graph_engine.php/semantic_engine.php still unverified.
10. plain_english_helper.php — RESTORE/INTEGRATE decided, not yet wired in.

## Items already actioned (WO-1 through WO-17)
WO-1 through WO-16: all DONE (security fixes, dead-file/cluster deletions, ProjectManager migrations, UI/excavation cleanup — full itemized log in Work Orders doc).
WO-17 (8/31): api/model_router.php makes real Claude API calls; OpenAI/Gemini real code, gated behind unconfigured keys, honestly returns "not_configured." brain_synthesis.php now reports honest single-model confidence instead of fake rand()-based cross-model weighting. STATUS: handed to John, not yet confirmed pasted live, not yet wired to a clickable page.

## AUDIT FINDING — tree_nodes Status (WO-18, OPEN, now the gating item)
Schema (modules/001_create_tree_nodes.php) and full API (api/tree.php) already exist in code, not wired to any UI. Unknown whether the table is actually created live on the production database. Per the macro-view ruling: when built/confirmed, add provenance + timestamp + status/lifecycle fields now. This gates the REAL V1 CHECKPOINT — the brain-pipeline rebuild (real client identity via node_id) depends on tree_nodes existing first.

## Known hazards carried forward
- graph_engine.php, semantic_engine.php — unverified naming-collision pairs.
- 5 different files named bootstrap.php across the codebase.
- database/migrations/'s old tree_nodes table uses SQLite syntax despite MySQL-only config.
- embed_generate.php has a plaintext OpenAI key PLACEHOLDER (not real) in a web-accessible file.

## NEXT RECOMMENDED TASK
1. Resolve WO-18 (tree_nodes live-or-build), with macro-view fields included from the start.
2. Then, in order, close the three REAL V1 CHECKPOINT gaps: real Hierarchy-of-Truth confidence scoring, a real Findings→Authority System data object, and confirming the 40+ channel excavation runs end-to-end against one real live client's data.
3. Everything else in the open WO queue (ProjectManager UI, semantic_diff_engine.php wiring, graph_view.php merge review, plain_english_helper.php wire-in) is real, not abandoned, but sequenced behind the checkpoint.

Understood — let's build it right rather than build on the deprecated system. First I need to see the actual shape of what we're migrating before proposing anything. Let me check the tables client_view_module.php depends on.

That reconnaissance just revealed the real size of this: 16 files across the codebase depend on the old clients/cases/payments/processing_queue tables — not just client_view_module.php. That includes live billing (payment_module.php, real Stripe data), report_module.php itself (the very thing Gap #2 needs to fix), cockpit_module.php, and — importantly — api/v8/get_cases.php/get_clients.php, which were explicitly marked "KEEP as the real DB-backed data foundation" back when the brain-system triage happened.

So this isn't "one old page to migrate" — it's a second, separate identity-layer migration, roughly the same size and weight as WO-18 itself, touching real payment data this time. That's not something to scope on the fly at the tail end of an already long session — it deserves the same careful, dedicated treatment WO-18 got (its own mapping session, its own verification passes, nothing rushed).

Memory's fully updated with today's real progress and the new discovery. Here's where things stand at the end of this session:

Closed today:

WO-19 — Brain pipeline wired end-to-end (button → orchestrator → synthesis), verified working, just needs a funded API key to produce real output.
WO-20 — Real Hierarchy-of-Truth confidence scoring, fully built and tested against real scenarios. Gap #1 is genuinely done.

Open, clearly scoped for next time:

A second identity-layer migration (client_view_module.php + 15 other files still on the old clients/cases/payments scheme) — this is the next real piece of work, and it deserves a fresh, focused session given it touches live billing data.
Once that's done, real Findings can actually get created and report_module.php can pull from them for real.

Good place to stop for today.