LEGAiSEE System Audit — api Top-Level non-v8
Audit type: Macro/system-level — real connections, not "does it execute."
The honest picture, up front
Of the 37 top-level files in api/ (separate from the already-audited api/v8/), only 2 are genuinely live, 1 is technically wired-but-never-called (already known), and the remaining 34 files are dead — most of them forming a clearly recognizable cluster that's a third home for the same abandoned "autonomous agent" concept already found in engine/ and api/v8/.
Confirmed genuinely live (2 files)
api/files_action.php — the real backend for the Files module (modules/files_module.php, a registered live module). Fetched directly by JavaScript on the page, bypassing api.php's router entirely.
api/search_load.php — same pattern for the Search module (modules/search_module.php). JS fetches this directly to load content into the search viewer.
Both of these match the pattern already noted elsewhere in this audit: the real, working parts of the system route around api.php's central switch statement and get called straight from JavaScript instead.
Already known: dead-but-reachable (1 file)
api/recommendations_generate.php — wired into api.php's router (case "recommendations") but has zero live callers anywhere in the UI. Covered in the prior bootstrap/recommendations report; repeated here for completeness since it lives in this folder.
The other 34 files — a third "autonomous agent" cluster
The remaining files split into two groups, both dead:
A clear thematic cluster (30 files): agency_create.php, agency_dashboard.php, agency_dispatch.php, agency_synthesis.php, agent_spawn.php, agent_tick.php, anomaly_detector.php, brain_commit.php, brain_dossier.php, brain_memory_graph.php, brain_orchestrator.php, brain_start.php, brain_state.php, brain_stream.php, brain_stream_v4.php, brain_synthesis.php, case_agent.php, case_create.php, case_memory.php, case_scheduler.php, case_tick.php, dossier.php, file_tree.php, graph_synthesizer.php, intel_cache.php, model_router.php, network_boot.php, network_tick.php, node_builder.php, excavate.php + excavation_run.php.
These are small (10-53 lines each), self-contained JSON REST endpoints — each one reads or writes its own slice of data (a case file, an agency file, a memory graph) and returns JSON directly, with no shared engine or kernel dependency tying them together. Read as a set, they sketch out an "autonomous agent" concept: agencies that dispatch cases, agents that spawn and tick forward in cycles, a "brain" that orchestrates document analysis and commits findings to memory. excavation_run.php even calls excavate.php via a literal localhost HTTP loopback request — real inter-file wiring, just wiring that nothing outside this cluster ever triggers.
This is the same conceptual pattern already flagged in the engine/ and api/v8/ audits (an unwired autonomous-agent system) — worth knowing this is its third distinct location in the codebase, not a new, unrelated idea. None of these 30 files are called from api.php's router, from any live module, or from any JavaScript found anywhere in the codebase.
Three unrelated stragglers, also dead:
api/file.php — zero real references. (A grep hit came back from an unrelated PHPMailer vendor test file mentioning pharfile.php — a false positive, not a real connection.)
api/search.php — only referenced by files already confirmed dead in the top-level-files audit (saved_views.php, search_dual.php) and by the dead second UI component system's components/nav.php. Not the same file as the live search_load.php above — a naming-adjacent dead twin.
api/tree.php — only referenced by the dead second UI rendering system documented in the ui/ audit (component_registry.php, component_boot.php). Same situation: a live-sounding name with zero real traffic.
Section summary
api/ top-level mirrors the pattern already established elsewhere in this codebase: a small number of genuinely working endpoints (2 here) called directly by JavaScript, one dead-but-technically-wired outlier, and a much larger dead cluster — this time a fairly well-developed "autonomous agent / brain" concept that was apparently built out across three separate parts of the codebase (engine/, api/v8/, and now here) and never connected to the live product in any of them.

