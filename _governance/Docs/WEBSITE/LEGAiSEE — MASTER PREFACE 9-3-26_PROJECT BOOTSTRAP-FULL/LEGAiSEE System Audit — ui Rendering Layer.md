LEGAiSEE System Audit — ui Rendering Layer
Audit type: Macro/system-level — real connections, not "does it execute."
The honest picture, up front
Of the ~27 files in ui/ (16 top-level PHP files, plus a ui/components/ subfolder and a global.css), only two files are genuinely load-bearing in a real, currently-used way — and even one of those is functionally inert. Everything else here is either already-known orphaned code, or a second, more disciplined rendering system that was built and never wired in.
What's actually live
ui/ui_engine.php + ui/layout.php — the one real, working piece. These are pulled in by modules/view_module.php, which IS registered in the live module system (?module=view). This route is a side-by-side "page compare / executive diff" tool — pick two saved pages from a page/page_content database table, and it highlights additions, removals, and keyword-signal shifts between them. layout.php is the actual HTML shell this tool renders inside — its own full <!DOCTYPE html> page with an inline <style> block (the black/gold/"diamond" luxury theme).
Correction to the earlier top-level-files finding: that report said lib/semantic_diff_engine.php (the shared library behind the big disconnected "semantic-diff" cluster) was "never referenced by anything in the live system." That's not quite right — view_module.php requires it, and view_module.php is live and reachable. So that experimental cluster isn't fully dead; it has exactly one live doorway into it, through the Compare/Executive-diff view. Worth knowing since a fix or cleanup pass touching lib/semantic_diff_engine.php would actually affect a working feature, not just dead files.
ui/ui_bootstrap.php — technically loaded by kernel/kernel_boot.php (which is live), but functionally dead: it defines a function that returns a <link> tag for global.css, but the wrapper function meant to call it (kernel_assets(), defined right next to it in kernel_boot.php) is never actually called anywhere in the codebase. So it's loaded into memory but never does anything.
The big finding: global.css is a dead "single source of truth"
ui/global.css is 1,924 lines and its own header comment states: "All pages link this. No embedded CSS anywhere else." That's false in practice — because of the dead ui_bootstrap.php chain above, this stylesheet is never actually linked into any live page. Meanwhile, at least three separate inline <style> blocks exist and do the real work instead: one in shell.php (the main app shell), one in ui/layout.php (the Compare-view shell), and one in modules/view_module.php itself. There's also a fourth, fully orphaned CSS file, ui/theme.php, using the same gold/obsidian palette but wired into nothing. All four use recognizably the same design language (matches the palette in ui/components/legaisee_web_colors.md), so this reads like an intended-but-abandoned consolidation: someone built the "real" global stylesheet and then the actual pages kept their own copies instead of switching over.
Confirmed orphaned (already known from the kernel/ audit)
ui/compare_engine.php
ui/file_explorer.php
A second, more disciplined — and fully dead — component system (11 files)
This is the most interesting find in the folder: a parallel rendering architecture, more structured than what's actually live, that appears to have been built as a replacement and never adopted.
ui/component_contract.php — a documented rule set for how components should behave (string-only output, no inline styles, no DB access, no business logic)
ui/component_registry.php + ui/component.php — a registry-driven component loader (ui_component($name, $props))
ui/component_boot.php — registers components (card, button, tag, folder_tree) against handler functions
ui/registry.php — a second, different component registry (inline closures for card, button, panel, compare)
ui/layout_engine.php + ui/layout_contract.php — a layout renderer that takes an array of {type, props} blocks and dispatches each to the registry above
ui/ui.php + ui/ui_boot.php — yet another small "core" helper pair (ui_shell(), ui_card())
ui/components.php — a folder-tree HTML renderer
None of these 11 files are referenced anywhere outside this group — zero external callers. component_boot.php does correctly resolve its includes, but to a different, root-level /components/ folder (not ui/components/) — one the master checklist had listed as "unknown purpose, 6 files unread." It's actually 10 files, and this audit confirms its purpose: it's the component library for this dead second rendering system (ui_card.php, ui_folder_tree.php, ui_tag.php, plus nav.php, compare.php, and design-reference files). Worth folding that into the same finding rather than auditing it as a mystery folder later.
Separately, ui/component_registry.php also points at four files inside ui/components/ that don't exist at all — button.php, heading.php, input.php, folder_tree.php. So even on its own terms, this system was left mid-build.
ui/components/ subfolder (inside ui/, distinct from the root /components/ above)
card.php — referenced only by the dead component_registry.php, not live
ingestforshell.php and ingest_exec snap.php (note: literal space in the filename) — two near-identical files (~4,750 bytes each), zero references anywhere
legaisee_web_colors.md / .png — a design reference (color palette + swatch image), not code
blur_bkgd, scroll_fx — extensionless HTML snippets (visual effects), zero references anywhere
ui/images/
One background image, confirmed genuinely in use — but via other already-covered live files (prospect.php, ingest.php, global.css itself, template pages), not through anything in this ui/ audit specifically.
Section summary
Of everything in ui/, exactly one feature is truly live: the Compare/Executive-diff view (ui_engine.php + layout.php, reached via ?module=view), which also turns out to be the sole live doorway into the previously-flagged lib/semantic_diff_engine.php cluster. The documented "single global stylesheet" (global.css) is dead code in practice — never linked into any page — while three-plus competing inline style blocks do the actual work. And there's a second, architecturally cleaner component/layout system sitting fully unused alongside the live one, itself missing some of the files it points to.

