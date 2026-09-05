LEGAiSEE System Audit — "Graph & Entities" Sidebar Section 8-23-26
Audit type: Macro / system-level — does the module connect to real data and other modules, and can John read the result — NOT "does the PHP execute."
Status labels in shell.php for this whole section: all 7 marked 'status' => 'working' — hardcoded text, not computed from any real check.

1. Network Graph (modules/graph_module.php)
Supposed to do: show the entity/relationship network as a graph.
What it actually does when opened from the sidebar: runs two COUNT(*) SQL queries and returns two numbers (Entities, Relationships). That's the entire output.
Real capability that exists but is unreachable: the file also contains a working path-finding algorithm (multi-hop traversal, scoring, ranking) — but it only runs if the URL is hit directly with special parameters (?start_entity=...). The sidebar never does this.
Does it connect to anything else? No. It reads only live DB counts. It does NOT read network.json (the file that would actually have graph shape data — see #4 below).
Human-legible? No — two raw numbers, no context, no visual.
Verdict: Broken relative to its purpose. Real graph logic exists in the codebase; the UI path to it doesn't.
2. Entities (modules/entity_resolution_module.php)
Supposed to do: entity resolution — find duplicate/alias entities and let you merge them.
What it actually does by default: shows two counts (entities, aliases) plus a text hint listing raw query-parameter syntax (?action=scan | ?action=analyze&id=N) — i.e., it tells a developer how to operate it via URL, not a business user via the UI.
Does it connect to anything? Partially — if the scan action is manually triggered (via URL, not a button in the UI as far as I can see), it writes results to an "insights" file tied to a case. That's a real connection, but it's not reachable through normal use.
Human-legible? No — counts + raw parameter syntax.
Verdict: Executes, but exposes a developer console, not a business tool.
3. Relations (modules/relations_module.php)
Supposed to do: show how cases, clients, and patterns relate to each other.
What it actually does: builds four real data structures (Case→Client, Client→Case, Case→Pattern, Pattern Co-Occurrence) — this part genuinely works and the data is real — but then hands each one back as a raw pretty-printed JSON text block to be displayed as-is.
Human-legible? No — you'd see walls of { "key": "value" } text, not sentences or a diagram.
Verdict: Real data, correctly connected, completely unreadable presentation. This is the clearest case of "the module does its job but John can't see it."
4. Root Cause (modules/root_cause_graph_module.php)
Supposed to do: build a root-cause graph for a case.
What it actually does: builds real node/edge data AND — importantly — writes it to data/cases/{case_id}/network.json, the exact file that graph_view.php (the one file in this whole system that DOES render a real visual graph) reads from.
The catch: this file only writes that data if a case_id is passed in. And even when it does, its own on-screen output is still a raw JSON blob, same as Relations above.
Real finding: this module is the correct data source for a working visual graph — but it's wired to the wrong display (JSON dump) instead of to graph_view.php, and it's disconnected from the sidebar's "Network Graph" card (#1), which uses a totally different, dumber data source (live DB counts).
Verdict: This is the piece that should be feeding #1, and isn't.
5. Clusters (modules/cluster_module.php)
Supposed to do: show a named cluster and its member pages.
What it actually does: the ONE module in this section that renders real, readable HTML — a heading, a summary sentence, and clickable cards.
Verdict: Actually works the way a business user would expect. Worth treating as the template for what "done" should look like elsewhere in this section.
6. Semantic Cluster (modules/semantic_cluster_module.php)
Supposed to do: deeper AI-driven clustering of entities.
What it actually does: produces real cluster data and writes it to clusters.json for the case (a real connection — feeding potential future consumers), but its own on-screen return is a raw array (clusters, total_clusters) — same unreadable pattern as #3/#4.
Verdict: Real logic, no human-facing translation.
7. Cross-Case Engine (modules/cross_case_engine.php)
Supposed to do: find patterns across multiple clients/cases (the actual differentiator value of the whole system, per the Authority Engine vision).
What it actually does: builds three real structures (Client→Case map, Industry Clusters, Cross-Case Links) — genuinely the most business-valuable data in this whole section — then returns them the same way: raw JSON text blocks.
Verdict: The most valuable engine in the section is also completely unreadable as built.

The pattern across all 7 (this is the real finding)
Two separate, independent problems are being labeled with the same word ("working"):
Wiring problem: data that one module correctly produces (Root Cause's network.json) isn't being read by the module that should display it (Network Graph). Two disconnected paths exist for the same concept.
Translation problem: in 4 of 7 modules, real, correct data is being generated — then handed to you as raw JSON text instead of sentences, tables, or a rendered picture. The system is doing its job internally and failing entirely at the last step: telling you, in your language, what it found.
Only one module in this section (Clusters) clears both bars — connects to real data AND presents it in a way a human reads normally.
Suggested fix priority (cheapest leverage first)
Rewire #1 to read network.json (already being written by #4) and render it through the same vis-network code already proven in graph_view.php. This is a data-source swap, not new development — the working graph code already exists in the codebase.
Give Relations, Root Cause, Semantic Cluster, and Cross-Case Engine a plain-language rendering layer modeled on what Clusters already does — even a simple "X relates to Y because Z" sentence list would clear the human-legibility bar without new backend logic.
Replace the hardcoded 'status' => 'working' labels in shell.php with something that reflects a real check — even a simple manual flag you update as sections get verified would stop the dashboard from lying to you about what's actually usable.

Next: continue this same audit format through the remaining sidebar sections (Intelligence Engines, Excavation/Ingest, Tools) to build the full system-level picture.

