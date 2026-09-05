LEGAiSEE System Audit — Brain Dashboard Recovered Fragments
Audit type: Feature-history investigation, prompted by John's memory of a prior "Brain" dashboard.
What John remembers
The Brain module used to have its own dashboard showing all the intel in the system at once, including a drawn node/connection graph.
What's live today
modules/brain_module.php is registered and reachable (?module=brain), but it's a stripped-down, read-only system-status inspector. It reports: whether the shell is connected, how many modules are registered, item counts in each data folder (files/clients/cases/memory), and whether five specific engine files exist on disk. No intel display, no graph — just health-check numbers as JSON.
What was found — two real, disconnected fragments that match the memory
pages/network_view.php — a genuine, working force-directed graph using vis-network.js. Draws colored nodes (red for anomalies, green otherwise) with connecting edges, pulled from a network JSON file (currently hardcoded to one specific network ID). This is very likely the actual graph-drawing code John remembers — real and functional, just not wired into any live page today.
pages/shell_template.php ("The Grand Lobby") — an earlier, more ambitious version of the whole app. Instead of the current live shell's one-module-at-a-time view (?module=X), this version laid out every module as a "wing" on one page — Brain, Dashboard, Graph, Cluster, Insight, Predictive, Recommendation, and more, all rendered simultaneously side by side. This matches "showed all the intel in the system at once" closely.
The gap
These two pieces don't appear to have been the same page. The Grand Lobby's Brain wing would only have shown the same plain JSON stats the live Brain module shows today — it doesn't pull in the graph. The graph renderer (network_view.php) reads from a different data source than the Brain module's own memory/session files (data/brains/*.json, written by api/brain_memory_graph.php and api/brain_stream.php/brain_stream_v4.php, part of the dead "autonomous agent/brain" cluster documented in the api/ top-level audit).
So either:
an even earlier version combined these into one true "Brain Dashboard," and that combined version isn't in this codebase snapshot, or
the pieces were always separate and got assembled/disassembled differently across the project's several rebuilds.
Either way, both fragments are real, working code, currently unused, and both would need to be pulled together (and pointed at the Brain's own graph data rather than the network_view's hardcoded network) to actually reconstruct the dashboard John remembers.
Status: open thread
This is not closed out. If more fragments turn up during the remaining audit (especially ProjectManager/, still unopened) — anything else graph-related, anything else "brain," anything resembling a combined dashboard — they should be added here rather than treated as a new, separate finding.


