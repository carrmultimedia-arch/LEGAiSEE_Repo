8-25-26_Legaisee Pages Micro Audit
Summary
Micro-audit of pages/ (9 files) — an earlier, unwired prototype of the live shell.php "Grand Lobby," plus one real self-contained flat-file search/compare tool and one confirmed-broken scratch file
Details
Read 2026-08-25, continuing the file-by-file examine phase after kernel/ (legaisee-kernel-micro-audit)
STATUS: pages/ FOLDER FULLY READ (8 files + test/ subfolder)
Key finding: pages/ is NOT wired into the live system at all
Grepped the whole codebase for any reference to pages/*.php by filename or a $_GET['page']-style router — found none (the only hits were unrelated matches inside the dompdf vendor library). Nothing routes to any file in pages/. This whole folder is orphaned relative to the live shell.php/module_registry.php system.
pages/shell_template.php (10.8KB) — an earlier prototype of the live Grand Lobby shell
Its own renderModule() function is functionally identical in spirit to shell.php's module loader, but its "wings" nav list and labeling ("Executive Intelligence" / "Excavation Wing" / "Client Vault" etc.) is a different, earlier design pass than what's live now (already-known terminology per legaisee-command-center — "Grand Lobby"/"Wings" are established names, so this confirms which file that terminology originated from). Contains one bug of its own: its wings array points at a module key semantic_cluster_module_v1, which renderModule() would look for as modules/semantic_cluster_module_v1_module.php — that file doesn't exist (the real one is semantic_cluster_module.php, no _v1) — would always render "Module not built yet" if this template were ever live. Moot as long as the file stays unwired.
pages/network_view.php — real code, but hardcodes the same test network_id already flagged elsewhere
Uses vis-network.js to render an actual force-directed graph from a case's network.json — genuinely functional rendering code — but hardcodes network_id = "net_69eee12e374d30_99173905", the same test ID already flagged repeatedly in legaisee-brain-micro-audit (build_edges.php, dossier_v2, api/v8 old paradigm). Confirms that hardcoded test ID pattern reaches even into pages/.
pages/search.php — a real, self-contained, DB-free search+compare tool
Reads normalized/index_meta.json and files under normalized/ (one of the previously "entirely untouched" top-level directories — now confirmed to have real, if unwired, code depending on it), does keyword search plus a side-by-side dual-file compare view. This is a fourth distinct "search+compare" implementation in the codebase, alongside modules/search_module.php (DB-based), modules/view_module.php (semantic_diff_engine.php-based), and the api/v8 compare cluster from the brain audit — all doing conceptually the same job with completely different, non-overlapping code paths. No shared logic between any of them.
pages/goals.php, home.php, logs.php, networks.php, reasoning.php — placeholder stubs
Each is a single line of static HTML (<div class="card">Goals System</div> etc.) — no logic, clearly scaffolding never filled in.
pages/test/shell_module_test.php — confirmed broken scratch/debug file
A malformed hybrid: starts as a copy of shell_template.php's HTML shell, but mid-file has brain_module.php's entire raw source pasted in verbatim (not required/included — literally pasted as inline text) inside what should have been the wings-loop PHP block, and the file cuts off without closing its tags/structure. Would fatal-error if ever executed. Zero risk since nothing routes here, but confirms this was a throwaway debug artifact, not a working file.
Bottom line for triage
Nothing in pages/ is reachable from the live system. Recommend as a family: keep pages/search.php's logic in mind as a possible reference/backup implementation (it's the only one of the four search/compare paths that needs zero database), but the folder as a whole is dead weight — safe delete-as-a-family candidate, same as engine_bindings.php/guard.php in kernel/, pending John's triage call.


