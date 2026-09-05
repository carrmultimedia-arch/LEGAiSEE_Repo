LEGAiSEE System Audit — Final Small Folders
Audit type: Macro/system-level — real connections, not "does it execute." This closes out the full macro-audit checklist.
root-level /components/ (10 files)
Confirmed: this folder's only purpose is as the component library for the dead second UI rendering system documented in the ui/ audit (ui/component_registry.php and ui/component_boot.php are the only two files anywhere that reference it — both already confirmed dead). Nothing new to add connectivity-wise; contents read for completeness:
ui_card.php, ui_tag.php, ui_folder_tree.php — small, clean render-helper functions (card, tag, recursive folder-tree HTML), meant to be called by the dead component registry
card.php — a similar but separate card renderer, expects raw variables rather than a props array (an earlier or alternate version of the same idea)
compare.php — a side-by-side comparison card renderer (A/B layout) — likely meant for the same Compare feature that's live today through ui/ui_engine.php and pages/network_view.php, just a different, unused implementation of it
nav.php — a simple top nav bar referencing index.php, search.php, ingest.php, files.php as flat top-level links. This is a different navigation model than the current live shell.php (which switches modules via ?module=X inside one page) — likely a remnant of an earlier, simpler site structure from before the module-based shell existed
blur_bkgd — a standalone visual-effect HTML demo (backdrop blur), unrelated to the rest, no live use
legaisee_web_colors.md/.png — design reference only, not code (already noted in the ui/ report)
database/ (2 files)
Both files are the same migration, duplicated: 010_create_tree_nodes_table.php and 010_create_tree_nodes_tablebk.php (a manual backup copy — content is byte-for-byte identical). This is a SQLite migration (not MySQL) that creates a tree_nodes table with parent/child folder relationships — this is the real database schema behind the file-browser feature found in the api/ top-level audit (api/tree.php), confirming that feature was built with a genuine, if abandoned, SQLite migration. No migration runner exists anywhere in the codebase that would actually execute this file — it's a design artifact, not something that runs automatically. This also lines up with the earlier finding that setup.php (top-level files audit) creates a stray SQLite database — both appear to date from the same SQLite-era attempt, before the project settled on MySQL.
_backup/ (2 files)
index_5-17-26-0804pm.php — a manually-dated snapshot of an old index.php, from May 17, 2026. Exactly what it looks like: a personal backup copy, not live code. Worth keeping as-is for historical reference given John's interest in reconstructing the project's timeline, but not worth further analysis.
.gitignore — a standard version-control ignore file, no content of note.
Section summary
Nothing here changes the overall picture — all three folders are small, confirmed dead or purely archival, and each one closes a loop already opened elsewhere in the audit: components/ completes the dead UI-system story, database/ fills in the real schema behind the file-browser feature, and _backup/ is exactly what its name says.

This closes the full macro-audit
With this, every folder and top-level file group on the original checklist has been read and connectivity-traced. See the checklist file for the complete running index of all report files and the final coverage total.

