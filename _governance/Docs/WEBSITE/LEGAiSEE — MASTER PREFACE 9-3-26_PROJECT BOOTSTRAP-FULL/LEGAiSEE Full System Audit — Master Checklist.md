LEGAiSEE Full System Audit — Master Checklist
Purpose: Track macro-audit coverage of the entire ~1,243-file codebase across sessions, since sessions have hit chat limits mid-audit before. Read this first at the start of any audit session to see exactly where to resume.
Standard for "audited": not "does the PHP execute" — does it connect to real data/other modules, and can a human read the result. Files just "connectivity-checked" (grep for references) but not read line-by-line are marked separately from fully read files.
Output location: each completed section becomes its own file, named LEGAiSEE_System_Audit_<Section>.md, saved to Google Docs by John.

✅ DONE — Fully audited (contents read, findings documented)
Area
Files
Output file
Key finding
Sidebar: Graph & Entities
7
LEGAiSEE_System_Audit_Graph_Entities.md
Network Graph shows counts only; real graph data exists but unwired
Sidebar: Excavation
6
LEGAiSEE_System_Audit_Excavation.md
Ingest file-upload has confirmed silent-failure bug
Sidebar: Intelligence Engines
7
LEGAiSEE_System_Audit_Intelligence_Engines.md
Insight = mis-wired Ingest duplicate; Predictive Link V1 output destroyed by renderer
Sidebar: Command
5
LEGAiSEE_System_Audit_Command.md
uic_v1.php (good renderer) exists, barely used
Sidebar: Planning, Clients & Cases, Tools + whole-sidebar summary
~12
LEGAiSEE_System_Audit_Planning_Clients_Tools_and_Summary.md
Compare module is a stub; real compare_engine.php orphaned
engine/ (all 36-37 files)
37
LEGAiSEE_System_Audit_Backend_and_Orphaned_Systems.md (connectivity) + LEGAiSEE_Orphaned_Engine_Files_Explained.md (deep-dive on the 15 orphaned ones)
plain_english_helper.php = ready-built unused fix; 15 files form a real unfinished autonomous-agent pipeline
api.php, api/v8/ (connectivity only, not line-read)
30
LEGAiSEE_System_Audit_Backend_and_Orphaned_Systems.md
Entirely unreachable — api.php has zero callers
cli/ (connectivity only)
9
same
Only reachable via orphaned index.php prototype
index.php (read + live-tested)
1
same
Separate abandoned prototype, still directly reachable by exact URL
ExcavationCommand/ (connectivity only)
3
same
Zero references anywhere — fully orphaned
ProjectManager/ (connectivity only — confirmed disconnected, contents NOT read)
88
same
Zero live wiring from shell.php/modules; internal contents still unknown


kernel/
21
Core plumbing — db connection, bootstrap, module registry. HIGH PRIORITY — everything else depends on this layer, and it's already ground zero for the SQLite/MySQL migration bug.


51 top-level standalone PHP files
51
Mixed bag — some clearly load-bearing (bootstrap.php, config.php, db.php, shell.php, graph_view.php, prospect.php), some clearly test/debug clutter (test_*.php ×8, peek.php, diagnostics2.php, temp_dashboard.php), several genuinely unknown purpose (ai_process.php, dossier_v2.php, intelligence.php, mission.php, response.php, indexer.php, parser.php, semantic_engine.php, excavation_engine.php, cluster_engine.php — note: possible top-level duplicates of same-named engine/ files, worth checking for the Insight/Ingest-style duplicate-conflict pattern).


ui/
19
The rendering engine itself, including the already-found orphaned compare_engine.php.
api/ (top-level, non-v8)
~45 remaining unread
Only search_load.php and files_action.php confirmed live so far — the other ~45 files' purpose/connectivity unknown.
ProjectManager/ internals
88
Connectivity confirmed dead from outside, but never opened — could contain its own working sub-system, orphaned engines, or duplicate bugs worth knowing about even if not linked in yet.
components/
6
Unknown purpose, not yet opened.
database/
2
Unknown purpose, not yet opened.


Running total fully/partially covered: ~185 of 1,243 files (~15%)

⬜ NOT YET STARTED — contents unread
Area
File count
Notes / why it matters










































_backup/
1
Old backup file(s) — likely just historical, low priority.

Remaining: ~1,058 files not yet opened

Recommended next-session order (highest leverage first)
kernel/ (21 files) — foundational, everything else sits on top of it.
Triage the 51 top-level standalone files — sort into load-bearing / test-clutter / genuinely unknown, then only deep-read the unknowns.
ui/ (19 files) — the rendering layer, directly relevant to the presentation-gap finding already established.
api/ top-level (45 unread files) — likely more real endpoints like search_load/files_action, worth confirming which are live.
ProjectManager/ internals (88 files) — biggest remaining chunk; open once the smaller/higher-leverage areas are done.
components/, database/, _backup/ — small, likely low-risk, quick to close out.

Update this table (and the full narrative in [[legaisee-command-center]]) at the end of every audit session — mark completed rows, move rows from "not started" to "done," and update the running totals — so resuming after a chat-limit cutoff starts here, not from scratch.

