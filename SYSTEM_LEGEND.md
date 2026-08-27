# LEGAiSEE System Legend

*A plain-English translation of the LEGAiSEE codebase for business owners.*

---

## Table of Contents

- [Engine Files](#engine-files)
- [Modules](#modules)
- [Data Model](#data-model)
- [Duplication Flags](#duplication-flags)

---

## Engine Files

### case_manager.php
**Plain English:** Creates a new case folder for a client with empty task queue and network graph, like opening a new project file.

**When it runs / what triggers it:** Triggered when you create a new case for a client through the case creation interface.

**What it produces:** A new case directory with network.json, tasks/queue.json, and meta.json files.

**Business relevance:** This is how you start tracking a new client project or investigation in the system.

---

### client_manager.php
**Plain English:** Creates new client profiles and retrieves the list of all clients, like adding a new customer card to your rolodex.

**When it runs / what triggers it:** Runs when you add a new client or view the client list.

**What it produces:** Client profile.json files with ID, name, and creation date.

**Business relevance:** This is your client database - every client you work with starts here.

---

### cluster_engine.php
**Plain English:** Groups related information together by keywords (risk, growth, opportunity), like sorting loose photos into labeled piles.

**When it runs / what triggers it:** Runs automatically after new data is added to a case's network.

**What it produces:** A clusters.json file that groups nodes into categories like market_risk, growth, opportunity, or general.

**Business relevance:** Helps you see what themes are emerging in a case without reading everything manually.

---

### cross_case_engine.php
**Plain English:** Looks across all your cases to find patterns that repeat, like noticing the same problem appearing for multiple clients.

**When it runs / what triggers it:** Runs when you request cross-case analysis or generate system intelligence.

**What it produces:** A report showing which signals appear in multiple cases and which patterns are shared across clients.

**Business relevance:** Reveals systemic issues - problems that aren't just one client's bad luck but industry-wide patterns you can address strategically.

---

### cross_case_learning_compiler.php
**Plain English:** Aggregates feedback from all executed actions to learn what works and what doesn't, like compiling performance reviews across all projects.

**When it runs / what triggers it:** Runs periodically to update system learning weights based on execution feedback.

**What it produces:** Cross-case weights and global intelligence map files that score modules and actions by success rate.

**Business relevance:** Helps the system get smarter over time by learning from past decisions and outcomes.

---

### dashboard_engine.php
**Plain English:** Formats recommendations for display on the dashboard, like turning a raw report into a readable summary.

**When it runs / what triggers it:** Runs when you view the dashboard to display current recommendations.

**What it produces:** HTML-formatted recommendation cards with priority colors (red for high, orange for medium).

**Business relevance:** This is what you actually see on the dashboard - the actionable items the system wants you to review.

---

### decision_engine_v2.php
**Plain English:** Converts system insights into specific decisions and action plans, like turning analysis into a to-do list.

**When it runs / what triggers it:** Runs automatically after the system insight engine completes its analysis.

**What it produces:** A list of decisions with priorities (critical, medium) and an execution queue for approved actions.

**Business relevance:** This bridges the gap between "here's what we found" and "here's what you should do about it."

---

### decision_governor.php
**Plain English:** Acts as a safety check before executing any action, like a supervisor approving work before it happens.

**When it runs / what triggers it:** Runs before any action is executed to ensure it aligns with goals and plans.

**What it produces:** An approval or rejection score based on goal alignment, plan consistency, system load, and risk level.

**Business relevance:** Prevents the system from doing something stupid or dangerous - your safety net.

---

### entity_extraction_engine.php
**Plain English:** Reads documents and pulls out important names, companies, locations, and relationships, like highlighting key people and organizations in a contract.

**When it runs / what triggers it:** Runs automatically when you ingest new documents or artifacts through the excavation module.

**What it produces:** Database entries in the entities and relationships tables in MySQL.

**Business relevance:** Builds your knowledge graph - the web of who knows whom, which companies are related, and what locations matter.

---

### execution_feedback_engine.php
**Plain English:** Compares what the system decided to do with what actually happened, to learn from the results.

**When it runs / what triggers it:** Runs after actions are executed to evaluate success or failure.

**What it produces:** Feedback events and learning adjustment files that tell the system whether its decisions were good or bad.

**Business relevance:** This is how the system improves - it learns from its mistakes and successes.

---

### execution_router.php
**Plain English:** Takes approved decisions and routes them to the right part of the system for action, like a dispatcher sending work crews to job sites.

**When it runs / what triggers it:** Runs after decisions are approved by the governor.

**What it produces:** Execution logs and active action queues that track what needs to be done and where.

**Business relevance:** Ensures decisions actually get carried out by the right system components.

---

### executive_dashboard_engine.php
**Plain English:** Builds a high-level summary combining clusters, memory evolution, insights, and cross-case patterns.

**When it runs / what triggers it:** Runs when you view the executive dashboard.

**What it produces:** A comprehensive dashboard.json file with summary metrics and cross-case signals.

**Business relevance:** Your bird's-eye view of everything happening across all clients and cases.

---

### goal_alignment.php
**Plain English:** Scores how well each piece of information matches your stated objectives, like grading how relevant a document is to your goals.

**When it runs / what triggers it:** Runs when evaluating whether to add or prioritize information.

**What it produces:** A numerical alignment score for each node against your goals.

**Business relevance:** Keeps the system focused on what matters to you rather than chasing irrelevant data.

---

### goal_arbitration_engine.php
**Plain English:** Resolves conflicts between multiple suggested goals and ranks them by priority, like a mediator deciding which requests get done first.

**When it runs / what triggers it:** Runs when the system generates multiple goal candidates that might conflict.

**What it produces:** A final ranked list of up to 10 active goals with priority scores.

**Business relevance:** Prevents the system from trying to do everything at once and spreading itself too thin.

---

### goal_conflict_resolver.php
**Plain English:** Identifies and eliminates contradictory objectives, like removing "cut costs" and "increase spending" from the same plan.

**When it runs / what triggers it:** Runs after goal arbitration to clean up the final goal list.

**What it produces:** A conflict-free goal list keeping only the higher-priority objectives.

**Business relevance:** Ensures your system isn't giving you impossible or self-defeating advice.

---

### goal_engine.php
**Plain English:** Loads active goals from the database and processes them through arbitration and conflict resolution.

**When it runs / what triggers it:** Runs when the system needs to know what objectives it should be working toward.

**What it produces:** A final set of active goals saved back to the database.

**Business relevance:** This is the system's "to-do list" - what it's trying to accomplish on your behalf.

---

### goal_generator.php
**Plain English:** Automatically suggests new goals based on patterns it detects in your data, like noticing a recurring issue and suggesting you fix it.

**When it runs / what triggers it:** Runs when analyzing graph data to find stable patterns worth addressing.

**What it produces:** Goal candidates with confidence scores, marked as "proposed" status.

**Business relevance:** Helps you spot improvement opportunities you might miss manually.

---

### governance_policy_engine.php
**Plain English:** Defines the rules and constraints the system must follow, like setting speed limits and safety rules.

**When it runs / what triggers it:** Loaded whenever the system needs to check if an action is allowed.

**What it produces:** A policy configuration with maximums, prohibited behaviors, and priority biases.

**Business relevance:** Your control panel - sets boundaries so the system doesn't go rogue or do things you don't want.

---

### graph_data.php
**Plain English:** Exports your knowledge graph data for visualization, like preparing a map for printing.

**When it runs / what triggers it:** Called when you need to view or visualize the entity relationship graph.

**What it produces:** JSON output of nodes and links from the database.

**Business relevance:** Lets you see the web of relationships the system has discovered.

---

### graph_mutation_engine.php
**Plain English:** Automatically modifies your knowledge graph based on insights, like adding new connections when it discovers relationships.

**When it runs / what triggers it:** Runs when the system wants to update the graph based on new intelligence.

**What it produces:** A modified graph with new insight nodes, promoted priority signals, and reinforced edges.

**Business relevance:** Keeps your knowledge graph current as the system learns more.

---

### insight_mutator.php
**Plain English:** Extracts high-confidence insights and prepares them for graph mutation.

**When it runs / what triggers it:** Runs as a preprocessing step before graph mutation.

**What it produces:** A pack of mutation-ready insights with strength scores.

**Business relevance:** Filters insights so only strong ones trigger graph updates.

---

### long_horizon_planner.php
**Plain English:** Simulates future states based on current trends, like forecasting where your business will be in 6 months.

**When it runs / what triggers it:** Runs when doing long-term strategic planning.

**What it produces:** A plan with trend direction, adjusted priorities, and predicted future states.

**Business relevance:** Helps with strategic thinking beyond immediate problems.

---

### memory_evolution_engine.php
**Plain English:** Tracks how your system's understanding has changed over time, like keeping a history of what you've learned.

**When it runs / what triggers it:** Runs when building the executive dashboard to show memory trends.

**What it produces:** A memory evolution file showing trend direction and insight count.

**Business relevance:** Shows whether your system is getting smarter or just accumulating noise.

---

### pattern_stability.php
**Plain English:** Checks if a pattern is stable enough to be trusted, like verifying a trend isn't just random noise.

**When it runs / what triggers it:** Runs before creating goals based on patterns.

**What it produces:** A true/false stability score based on variance and item count.

**Business relevance:** Prevents the system from overreacting to random fluctuations.

---

### pipeline_adapters.php
**Plain English:** Connects different engines to file paths, like plugging different tools into a common power source.

**When it runs / what triggers it:** Called by other engines to resolve case IDs from file paths.

**What it produces:** Helper functions that extract case IDs and call appropriate engines.

**Business relevance:** Infrastructure code - keeps the system modular and organized.

---

### plain_english_helper.php
**Plain English:** Translates technical data into human-readable sentences, like converting "entity_count: 12" to "The system has identified 12 entities."

**When it runs / what triggers it:** Called by modules to display user-friendly interpretations of their data.

**What it produces:** Plain English text blocks that explain what the numbers mean.

**Business relevance:** Makes the system usable without needing to understand the technical output.

---

### policy_enforcement_engine.php
**Plain English:** Takes system recommendations and turns them into enforced rules that all engines must follow.

**When it runs / what triggers it:** Runs after system recommendations are generated to create enforcement context.

**What it produces:** A policy-enforced context file with constraints, engine rules, and execution flags.

**Business relevance:** Ensures the system actually follows its own recommendations consistently.

---

### portfolio_engine.php
**Plain English:** Loads all cases from all clients into one combined view, like putting all client files on one big table.

**When it runs / what triggers it:** Called by cross-case and portfolio analysis engines.

**What it produces:** A combined array of all case graphs and a global node list.

**Business relevance:** Enables analysis across your entire client base, not just one at a time.

---

### predictive_intelligence_engine.php
**Plain English:** Forecasts what's likely to happen based on patterns across all clients, like predicting weather from historical data.

**When it runs / what triggers it:** Runs when generating portfolio-level predictions.

**What it produces:** Predictive insights with forecasts about risk dominance, growth opportunities, and conflicts.

**Business relevance:** Helps you anticipate problems before they become critical.

---

### reasoning_engine.php
**Plain English:** Analyzes clusters to generate insights, like noticing that risk and growth appear together and flagging it.

**When it runs / what triggers it:** Runs after clustering to interpret what the clusters mean.

**What it produces:** An insights.json file with observations about risk vs growth, clean opportunities, and confidence levels.

**Business relevance:** Turns raw data groupings into actionable observations.

---

### recommendation_engine.php
**Plain English:** Converts insights into specific recommended actions, like turning "high risk detected" into "review risk signals and reduce exposure."

**When it runs / what triggers it:** Runs after insights are generated to create actionable recommendations.

**What it produces:** A recommendations.json file with titles, actions, and priority levels.

**Business relevance:** This is the "what should I do" layer - turns analysis into action items.

---

### semantic_cluster_engine.php
**Plain English:** Groups information by meaning rather than just keywords, like putting all "customer satisfaction" items together regardless of the exact words used.

**When it runs / what triggers it:** Called by portfolio and cross-case analysis engines.

**What it produces:** Clusters grouped by semantic categories like audience_performance, risk_signals, growth_signals.

**Business relevance:** More sophisticated grouping that understands context, not just word matching.

---

### system_behavior_spec.php
**Plain English:** Defines what the system is designed to optimize for and what it's not allowed to do.

**When it runs / what triggers it:** Loaded to configure system behavior and constraints.

**What it produces:** A specification with optimization priorities, allowed domains, and prohibited behaviors.

**Business relevance:** The master configuration that defines the system's purpose and boundaries.

---

### system_insight_engine.php
**Plain English:** Analyzes cross-case patterns to generate system-level intelligence about risks, opportunities, and insights.

**When it runs / what triggers it:** Runs after cross-case analysis to interpret the patterns.

**What it produces:** A system intelligence object with insights, risks, opportunities, and recommendations.

**Business relevance:** High-level analysis that tells you what's happening across your entire business.

---

### system_recommendation_engine.php
**Plain English:** Converts system insights into policy recommendations that affect the whole system.

**When it runs / what triggers it:** Runs after system insights to generate governance policies.

**What it produces:** System recommendations with policy types, rules, and enforcement levels.

**Business relevance:** Creates the rules that guide all system behavior - your governance layer.

---

### temporal_memory_engine.php
**Plain English:** Saves snapshots of the system state over time, like taking periodic photos to track progress.

**When it runs / what triggers it:** Runs periodically to record the current state of graphs and goals.

**What it produces:** Database entries in temporal_memory table with compressed state snapshots.

**Business relevance:** Lets you look back at how the system's understanding has evolved.

---

## Modules

### alert_module.php
**Plain English:** This is the button labeled "Alerts" on the dashboard. Clicking it shows you any urgent issues the system has detected across your cases.

**When it runs / what triggers it:** Displays when you click the Alerts module or when the dashboard loads alerts.

**What it produces:** A list of active alerts with severity levels (HIGH/MEDIUM) linked to specific cases.

**Business relevance:** Shows you what needs immediate attention - your fire alarm system.

---

### anomaly_engine_module.php
**Plain English:** This is the button labeled "Anomaly Detection" on the dashboard. Clicking it runs a health check on your knowledge graph to find weird data.

**When it runs / what triggers it:** Runs when you click the module or request an anomaly scan.

**What it produces:** A risk score (LOW/MODERATE/HIGH/CRITICAL) and counts of orphans, hubs, weight anomalies, alias explosions, and relationship conflicts.

**Business relevance:** Data quality check - tells you if your knowledge graph has corruption or strange patterns that need fixing.

---

### brain_module.php
**Plain English:** This is the button labeled "Brain" on the dashboard. Clicking it shows you the system's internal status and health check.

**When it runs / what triggers it:** Displays when you click the Brain module for system diagnostics.

**What it produces:** A system status report showing module count, data layer readiness, and engine availability.

**Business relevance:** Your system health monitor - tells you if everything is running correctly.

---

### cases_module.php
**Plain English:** This is the button labeled "Cases" on the dashboard. Clicking it shows you all your cases with their status and associated clients.

**When it runs / what triggers it:** Displays when you click the Cases module to view your case list.

**What it produces:** A list of cases with IDs, status (open/closed), client names, and pattern tags.

**Business relevance:** Your case management view - see all active investigations at a glance.

---

### clients_module.php
**Plain English:** This is the button labeled "Clients" on the dashboard. Clicking it shows you all your client intelligence dossiers.

**When it runs / what triggers it:** Displays when you click the Clients module to view your client list.

**What it produces:** A list of clients with names, industries, locations, and unique IDs.

**Business relevance:** Your client roster - the businesses you're working with.

---

### cluster_module.php
**Plain English:** This is the button labeled "Clusters" on the dashboard. Clicking it shows you a specific cluster and its associated pages.

**When it runs / what triggers it:** Displays when you click a cluster ID to view its contents.

**What it produces:** A cluster view showing the cluster name, summary, and all pages belonging to that cluster.

**Business relevance:** Lets you drill down into a specific topic area to see all related content.

---

### compare_module.php
**Plain English:** This is the button labeled "Compare" on the dashboard. Clicking it lets you compare two cases side by side.

**When it runs / what triggers it:** Displays when you enter two case IDs and click compare.

**What it produces:** A comparison view showing the two cases you selected.

**Business relevance:** Lets you see similarities and differences between two cases or clients.

---

### dashboard_module.php
**Plain English:** This is the button labeled "Dashboard" on the dashboard. Clicking it shows you basic system totals.

**When it runs / what triggers it:** Displays when you click the Dashboard module for overview stats.

**What it produces:** Simple counts of total cases and total clients.

**Business relevance:** Quick system overview - how much data you have in the system.

---

### decision_module.php
**Plain English:** This is the button labeled "Decision Engine" on the dashboard. Clicking it shows you predicted next actions for each case.

**When it runs / what triggers it:** Displays when you click the Decision Engine module.

**What it produces:** Case-level decisions with priority scores and recommended actions, plus global priority rankings.

**Business relevance:** Shows you what the system thinks should happen next for each case.

---

### dig_review_module.php
**Plain English:** This is the button labeled "Dig Review" on the dashboard. Clicking it lets you review and approve/reject extracted findings before they go into reports.

**When it runs / what triggers it:** Displays when you click the Dig Review module to verify extracted entities and relationships.

**What it produces:** A review queue where you can confirm, reject, or mark items as needing more info, with filtering by status and context.

**Business relevance:** Your quality control gate - ensures only accurate findings make it into your reports.

---

### entity_resolution_module.php
**Plain English:** This is the button labeled "Entity Resolution" on the dashboard. Clicking it shows you the status of duplicate entity detection.

**When it runs / what triggers it:** Displays when you click the Entity Resolution module.

**What it produces:** Status showing total entities and aliases, with available actions to run scans or analyze specific entities.

**Business relevance:** Helps you clean up duplicate or similar entities in your knowledge graph.

---

### excavation_module.php
**Plain English:** This is the button labeled "Excavation" on the dashboard. Clicking it processes client artifacts to extract signals and generate executive narratives.

**When it runs / what triggers it:** Displays when you click the Excavation module to process new client data.

**What it produces:** Auto-generated executive cases with narratives, signal clusters, and recommended actions based on artifact analysis.

**Business relevance:** Your automated analysis pipeline - turns raw client data into actionable intelligence.

---

### executive_dashboard_module.php
**Plain English:** This is the button labeled "Executive Dashboard" on the dashboard. Clicking it shows you high-level intelligence metrics and system status.

**When it runs / what triggers it:** Displays when you click the Executive Dashboard module.

**What it produces:** Executive intelligence snapshot with system signals, metrics dataset, and system status message.

**Business relevance:** Your C-level view - strategic intelligence without technical details.

---

### files_module.php
**Plain English:** This is the button labeled "Files" on the dashboard. Clicking it opens a file manager to browse, upload, create, and edit files.

**When it runs / what triggers it:** Displays when you click the Files module to manage system files.

**What it produces:** A Windows-style file navigator with tree view, file list, and viewer/editor.

**Business relevance:** Your file management system - organize and access all your documents and data files.

---

### graph_module.php
**Plain English:** This is the button labeled "Graph" on the dashboard. Clicking it lets you explore your knowledge graph by traversing relationships from any entity.

**When it runs / what triggers it:** Displays when you click the Graph module or when querying the graph API.

**What it produces:** Graph traversal results showing paths from a starting entity through connected relationships.

**Business relevance:** Lets you explore "who is connected to whom" in your knowledge network.

---

### ingest_module.php
**Plain English:** This is the button labeled "Ingest" on the dashboard. Clicking it lets you paste AI chat transcripts or upload files to store in memory.

**When it runs / what triggers it:** Displays when you click the Ingest module to add new data.

**What it produces:** Forms to paste AI sessions, upload files, or view stored sessions with word counts and metadata.

**Business relevance:** Your data entry point - how you get information into the system's memory.

---

### ingest_view_module.php
**Plain English:** This is the button labeled "Ingested Memory" on the dashboard. Clicking it shows you a list of stored AI sessions.

**When it runs / what triggers it:** Displays when you click the Ingested Memory module.

**What it produces:** A list of ingested memory sessions with titles and source AI platforms.

**Business relevance:** Quick view of what AI conversations you've stored in the system.

---

### insight_module.php
**Plain English:** This is the button labeled "Insights" on the dashboard. Clicking it shows you the status distribution across your cases.

**When it runs / what triggers it:** Displays when you click the Insight Engine module.

**What it produces:** A status distribution showing how many cases are in each status category.

**Business relevance:** Quick overview of your case pipeline health.

---

### intelligence_dashboard_module.php
**Plain English:** This is the button labeled "Intelligence Dashboard" on the dashboard. Clicking it shows you executive intelligence signals and system metrics.

**When it runs / what triggers it:** Displays when you click the Intelligence Dashboard module.

**What it produces:** Intelligence snapshot with authority signals, opportunity windows, and system metrics.

**Business relevance:** Strategic intelligence view for high-level decision making.

---

### pm_module.php
**Plain English:** This is the button labeled "Project Manager" on the dashboard. Clicking it opens a task board for managing projects and tasks, with optional links to AI sessions.

**When it runs / what triggers it:** Displays when you click the Project Manager module.

**What it produces:** A project and task management interface with status tracking, priority levels, due dates, and session linking.

**Business relevance:** Your project management system - track work, link AI conversations to tasks, manage project status.

---

### predictive_module.php
**Plain English:** This is the button labeled "Predictive" on the dashboard. Clicking it shows you pattern transition probabilities and case-level predictions.

**When it runs / what triggers it:** Displays when you click the Predictive Engine module.

**What it produces:** Pattern transition probabilities, case-level predictions of next patterns, and global predicted patterns.

**Business relevance:** Shows you what's likely to happen next based on historical patterns.

---

### recommendation_module.php
**Plain English:** This is the button labeled "Recommendations" on the dashboard. Clicking it shows you specific recommended actions based on detected patterns.

**When it runs / what triggers it:** Displays when you click the Recommendations module.

**What it produces:** A list of recommended actions with titles, priorities, and specific steps to take.

**Business relevance:** Your action list - what the system thinks you should do about the patterns it found.

---

### relations_module.php
**Plain English:** This is the button labeled "Relations" on the dashboard. Clicking it shows you how cases, clients, and patterns are connected to each other.

**When it runs / what triggers it:** Displays when you click the Relationship Engine module.

**What it produces:** Relationship maps showing case-to-client, client-to-case, case-to-pattern, and pattern co-occurrence graphs.

**Business relevance:** Shows you the web of connections across your data - which clients share which patterns.

---

### report_module.php
**Plain English:** This is the button labeled "Report" on the dashboard. Clicking it lets you search and compare normalized documents.

**When it runs / what triggers it:** Displays when you click the Report module with search and comparison tools.

**What it produces:** A searchable list of normalized documents with Set A/Set B comparison capability.

**Business relevance:** Your document research and comparison tool.

---

### root_cause_graph_module.php
**Plain English:** This is the button labeled "Root Cause Graph" on the dashboard. Clicking it shows you a clustered graph visualization of cases, clients, and patterns.

**When it runs / what triggers it:** Displays when you click the Root Cause Graph module.

**What it produces:** A graph data structure with nodes (cases, clients, patterns) and edges showing connections and co-occurrences.

**Business relevance:** Visual map of how everything connects - helps you see root causes through pattern clusters.

---

### search_module.php
**Plain English:** This is the button labeled "Search" on the dashboard. Clicking it opens a powerful search tool that looks across your entire system and lets you compare results side by side.

**When it runs / what triggers it:** Displays when you click the Search module.

**What it produces:** A three-pane interface with search results, Set A viewer, and Set B viewer with find-in-page functionality.

**Business relevance:** Your universal search tool - find anything across JSON files, MySQL tables, and documents, then compare results.

---

### semantic_cluster_module.php
**Plain English:** This is the button labeled "Semantic Clusters" on the dashboard. Clicking it runs an advanced clustering algorithm on your knowledge graph entities.

**When it runs / what triggers it:** Displays when you click the Semantic Cluster module.

**What it produces:** Clusters of entities with cohesion, density, purity, and cluster scores, ranked by quality.

**Business relevance:** Advanced grouping that finds natural communities in your knowledge graph.

---

### time_intelligence_module.php
**Plain English:** This is the button labeled "Time Intelligence" on the dashboard. Clicking it shows you trend analysis comparing recent activity to historical baselines.

**When it runs / what triggers it:** Displays when you click the Time Intelligence module.

**What it produces:** Trend analysis showing last 7 days vs 30-day baseline with rising/stable/declining indicators.

**Business relevance:** Shows you which patterns are getting more or less common over time.

---

### vault_module.php
**Plain English:** This is the button labeled "Vault" on the dashboard. Clicking it shows you all client artifacts stored in the archaeology vault.

**When it runs / what triggers it:** Displays when you click the Vault module.

**What it produces:** A list of clients with their associated artifacts and metadata.

**Business relevance:** Your artifact repository - all the raw data you've collected from clients.

---

### view_module.php
**Plain English:** This is the button labeled "View" on the dashboard. Clicking it lets you compare two documents with executive summary analysis.

**When it runs / what triggers it:** Displays when you click the View module with two document IDs selected.

**What it produces:** A comparison view with executive summary showing added/removed/changed elements and signal shifts.

**Business relevance:** Document comparison tool that highlights what changed between versions in business terms.

---

## Data Model

### Cases
A case represents a specific project, investigation, or analysis for a client. Each case has its own network graph showing entities and relationships, a task queue for tracking work, and metadata like creation date and status. Cases are where you track specific business issues or opportunities you're analyzing.

### Clients
A client represents a business or organization you work with. Each client has a profile with name, industry, location, and contact information. Clients can have multiple cases, and all client data including artifacts and cases are organized under the client directory.

### Prospects
Prospects are potential clients - businesses you might work with but haven't engaged yet. They have similar structure to clients with business names, industries, and other identifying information, but they're in a separate pool until they become active clients.

### Brains
Brains appear to be stored analysis snapshots or graph states, possibly representing intermediate analysis results. Each brain file seems to capture a specific state of the system's understanding at a point in time.

### Network
The network directory stores graph data files that represent relationship maps. These files contain nodes (entities) and edges (relationships) that show how different things are connected. Network files can be specific to cases or represent broader relationship maps.

### Mesh
The mesh directory currently appears to be empty and may be reserved for future use, possibly for more complex multi-dimensional relationship mapping or mesh network structures.

### Causal Memory
The causal_memory.json file appears to track cause-and-effect relationships learned by the system. It likely stores information about what causes what, helping the system understand causal chains rather than just correlations.

---

## Duplication Flags

### Client Data Duplication
Client information exists in multiple locations:
- `data/clients/` directory with JSON profile files
- MySQL `clients` table (referenced by clients_module.php)
- Potential overlap with `legaisee/clients/` directory (not audited in this pass)

### Case Data Duplication
Case information exists in multiple locations:
- `data/cases/` directory with individual case JSON files
- `data/cases.json` master index file
- MySQL database may also store case information (referenced by various modules)

### Entity/Relationship Storage Duplication
Entity and relationship data exists in multiple formats:
- MySQL `entities` and `relationships` tables (primary storage per entity_extraction_engine.php)
- JSON network files in `data/network/` directory
- Case-specific network.json files in individual case directories

### Memory/Ingest Duplication
There are multiple memory-related storage mechanisms:
- MySQL `memory_ingest` table for AI session storage
- `data/memory/` directory for memory files
- `data/brains/` directory for brain snapshots
- Potential overlap with other memory storage mechanisms

### Auth/Kernel Duplication
The work order mentioned auth logic in both root kernel and ProjectManager/Core/, but ProjectManager directory was not found in this audit. This duplication flag cannot be verified from the available codebase.

### Graph Data Duplication
Graph data exists in multiple places:
- MySQL database (entities, relationships tables)
- JSON network files in `data/network/`
- Case-specific network.json files
- `data/brains/graph.json`

### Module vs Engine Functionality Overlap
Several modules appear to duplicate functionality that exists in engines:
- `modules/semantic_cluster_module.php` and `engine/semantic_cluster_engine.php` both perform semantic clustering
- `modules/predictive_module.php` and `engine/predictive_intelligence_engine.php` both perform predictive analysis
- `modules/decision_module.php` and `engine/decision_engine_v2.php` both generate decisions
- `modules/recommendation_module.php` and `engine/recommendation_engine.php` both generate recommendations

---

## Audit Summary

**Total files audited:** 66 files (36 engine files + 30 modules)

**Files with unclear purpose:** 0 files (all purposes were determinable from code)

**Duplication flags found:** 7 areas of potential duplication/fragmentation

---

*End of System Legend*
