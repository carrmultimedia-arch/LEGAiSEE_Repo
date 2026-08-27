# LEGAiSEE Command Center — Capability Map

*A plain-language inventory of what's actually built on the server, organized by function rather than folder.*

---

## 1. Core Kernel (the spine)
The always-on plumbing everything else depends on.
- `shell.php` — sole routing entry / Grand Lobby dashboard
- `kernel.php`, `kernel_paths.php` — core routing/path resolution
- `bootstrap.php` — app startup
- `db.php` — sole DB access (`kernel_db()`)
- `guard.php` — access/safety checks
- `session.php` — session handling
- `nav.php`, `nav_engine.php` — navigation
- `index.php` — front controller

## 2. The Brain Layer (`engine/` — ~35 files)
This is the actual AI/reasoning intelligence. Grouped by what they do:

**Reasoning & decisions**
- `reasoning_engine.php`, `decision_engine_v2.php`, `decision_governor.php`
- `goal_engine.php`, `goal_generator.php`, `goal_alignment.php`, `goal_conflict_resolver.php`, `goal_arbitration_engine.php`
- `long_horizon_planner.php`, `execution_router.php`, `execution_feedback_engine.php`

**Learning & memory**
- `cross_case_learning_compiler.php`, `cross_case_engine.php`
- `memory_evolution_engine.php`, `temporal_memory_engine.php`
- `pattern_stability.php`

**Clustering & entity intelligence**
- `semantic_cluster_engine.php`, `cluster_engine.php`, `cluster_intelligence.php`
- `entity_extraction_engine.php`
- `graph_engine.php`, `graph_mutation_engine.php`, `graph_auto_builder.php`, `graph_data.php`

**Prediction & recommendations**
- `predictive_intelligence_engine.php`
- `recommendation_engine.php`, `system_recommendation_engine.php`
- `insight_mutator.php`, `system_insight_engine.php`

**Governance & translation**
- `policy_enforcement_engine.php`, `governance_policy_engine.php`
- `plain_english_helper.php` — CPU-language → human-language translation (this is your "human language" requirement, already started)

**Case/client/portfolio management**
- `case_manager.php`, `client_manager.php`, `portfolio_engine.php`
- `dashboard_engine.php`, `executive_dashboard_engine.php`
- `pipeline_adapters.php`, `system_behavior_spec.php`, `closed_loop.js`
- `folder_engine.php`, `system_health.php`, `ingestion_pipeline.php`, `engine_bindings.php`

## 3. Modules — the Wings (`modules/` — ~33 files)
User-facing feature surfaces, each one a distinct Wing:
- `dashboard_module.php`, `executive_dashboard_module.php`, `intelligence_dashboard_module.php`, `cockpit_module.php`
- `excavation_module.php`, `ingest_module.php`, `ingest_view_module.php`, `dig_review_module.php`
- `brain_module.php`, `insight_module.php`, `anomaly_engine_module.php`
- `cases_module.php`, `clients_module.php`, `pm_module.php` (Project Manager)
- `cluster_module.php`, `semantic_cluster_module.php`, `relations_module.php`, `graph_module.php`, `root_cause_graph_module.php`
- `predictive_module.php`, `predictive_link_module_v1.php`, `recommendation_module.php`, `decision_module.php`, `time_intelligence_module.php`
- `entity_resolution_module.php`, `compare_module.php`, `search_module.php`
- `report_module.php`, `alert_module.php`, `governance_module.php`, `vault_module.php`, `files_module.php`, `view_module.php`
- `utils/` — shared helpers (file, debug, JSON, bootstrap, UI-in-console v1/v2)

## 4. UI System (`ui/`)
The rendering layer that all modules plug into:
- `layout_engine.php`, `layout_contract.php`, `layout.php` — page structure rules
- `component_registry.php`, `component_contract.php`, `components.php`, `registry.php`, `component.php` — reusable UI components + their contracts
- `theme.php`, `global.css` — visual system
- `ui_boot.php`, `ui_bootstrap.php`, `ui_engine.php`, `component_boot.php` — startup
- `file_explorer.php`, `compare_engine.php`
- `components/` subfolder — ingest-specific widgets, cards, scroll/blur effects

## 5. Data Layer (`data/`)
Where everything actually lives, in flat JSON (not yet a real DB for most of this):
- `cases/` — one JSON bundle per case: network, tasks, goals, insights, artifacts, memory, strategy_plan, clusters
- `clients/` — one folder per client: profile + nested cases
- `prospects/` — sales pipeline entries (Brad Moore Builders, Cowboy Plumbing, Faust Hotel, Good Ol' Rockin Therapy, etc.)
- `brains/` — per-brain reasoning output + a `graph.json`
- `network/` — per-session network graphs
- `goals/`, `events/`, `memory/`, `mesh/`, `agency/`, `predictions/`, `chains/` (genome/performance/templates), `causal_memory.json`, `learning.json`
- `portfolio/` — system-wide insights, global graph, cross-case clusters, predictive insights
- `auto_log/`, `compressed/`, `records.json`, `files/` — logging & archival

## 6. Tools (`tools/`)
Batch scripts for building/maintaining the graph:
- `build_clusters.php`, `build_relations.php`, `name_clusters.php`
- `build_cluster_summaries.php`, `build_cluster_summaries_ai.php`, `extract_cluster_insights.php`, `detect_cluster_opportunities.php`

## 7. ProjectManager — a full sub-application
This isn't just `pm_module.php` — it's an entire mini-framework living inside the Command Center:
- **Core framework**: Router, Dispatcher, Request/Response, Container, Application, ExceptionHandler
- **Models**: User, Role, Permission, Attachment, ActivityLog
- **Services/Policies**: AuthorizationService + policies for Document, User, Permission, Role, Project, Task
- **API surface** (~20 endpoint groups): tasks, projects, comments, permissions, reports, notes, graph, cases, auth, clients, attachments, labels, customfields, intelligence, subtasks, milestones, search, users, ingest, timeline, activity, automations, calendar
- **Database migrations**: users, roles, permissions, role_permissions, user_roles, activity_log, attachments, audit tables
- **Governance library**: a full numbered spec set (`PROJECT_MANAGER_BIBLE`, ~50 docs) covering everything from manifest and build rules to permission model, UI design language, kanban, timeline, client portal, and session handoff
- **Tests**: unit, integration, acceptance, UI, plus targeted auth/permissions suites

## 8. KnowledgeSystem — the governance & vision library
Your numbered documentation series (this is effectively the constitution for the whole build):
- **000 Governance** — The Law, master index, build order, doc/numbering standards, folder structure, writing style, session protocol/handoff, relationship model
- **100 Vision** — mission, core principles, business philosophy, operator philosophy, 10-year and 100-year vision
- **200 System Architecture** — kernel, router, boot sequence, navigation, scheduler, database, security, file system, storage
- **300 Excavation System** — ingestion, artifact extraction, entity resolution, graph building, relationship discovery, recommendations, timeline generation, dossier production
- **400 Knowledge Graph** — nodes, edges, clusters, memory, temporal intelligence, prediction, reasoning, learning
- **500 AI Systems** — command engine, mentor engine, teacher engine, planner engine, project manager, voice interface, autonomous operations
- **600 User Interface** — dashboard, excavation command, executive dashboard, investigation workspace, visualization, widgets, navigation
- **700 Operations** — deployment, backup, recovery, testing, validation, performance, monitoring
- **800 Future Systems** — research, experimental, roadmap, patent ideas, investment opportunities, acquisition strategy, long-term expansion

## 9. Client & Case Intake (raw files)
- `legaisee/` — raw client intake documents by client name
- `normalized/` — normalized/extracted text cache from ingestion (hashed filenames)
- `dossiers/` — output deliverables

## 10. Supporting / third-party
- `lib/dompdf/` — PDF generation library (third-party, for dossier export)
- Miscellaneous top-level utilities: `response.php`, `files.php`, `semantic_engine.php`, `legaisee_prospects.php`, `search_dual.php`, `saved_views.php`, `load_sets.php`, `ai_process.php`, `export_report.php`, `ingest2.php`
- Legacy/backup: `legaisee_diagnostic.phpbak`, `brain.phpbak`, `test_modules.php`, `test_visual.php`, `clients_module.phpbak`

---

## What this tells you
You already have almost every primitive the "umbrella OS" needs — goal engines, decision engines, cross-case learning, a plain-English translation layer, a recommendation engine, and a full governance doc system describing how it should all behave. What you described wanting (self-maintaining, learns, suggests, human language, one system with business end goals) **already has a home in this tree** — series 500 (AI Systems) and the goal/decision/recommendation engines are exactly that layer. The gap is almost certainly not "what to build" but "wiring what's already built into shell.php as one coherent surface" rather than parallel modules that don't yet share a single front door.
