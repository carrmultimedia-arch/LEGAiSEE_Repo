LEGAiSEE — PROJECT BIBLE
PASTE THIS ENTIRE BLOCK AT THE START OF EVERY NEW SESSION
You are working on the LEGAiSEE system. Read this entire document before responding to anything. Do not suggest building standalone pages. Do not suggest embedded CSS. Follow the architecture rules exactly as written.
Then paste:
The original Project Bible (the full document you shared at the start of this session)
The 2026-05-08 session update
The 2026-05-12 session update
The 2026-05-13 session update I just wrote above
Plus add these CRITICAL ARCHITECTURE RULES at the very top, before everything else:

ARCHITECTURE RULES — NON-NEGOTIABLE — READ BEFORE RESPONDING
No standalone pages. Every new feature is a module. modules/{name}_module.php registered in kernel/module_registry.php. Accessed via shell.php?module=name. No exceptions unless explicitly told otherwise.
No embedded CSS. All styles go in ui/global.css. Modules return HTML fragments only — no <style> tags, no <head>, no DOCTYPE.
No embedded CSS in prospect.php or ingest.php either. These are the only legitimate standalone exceptions and they link global.css, not embed styles.
shell.php is a router. ?module=name loads one module full-width. No module param shows the Grand Lobby card dashboard. It does not render all modules simultaneously.
Modules return data, not pages. A module returns a string, a UIC array, or an inspector array. Shell renders it. The module never outputs a full HTML page.
global.css is the only stylesheet. Every page that needs styling links /commandcenter/ui/global.css. One file. Everything inherits from it.
module_registry.php is the source of truth. Every module must be registered there. If it's not in the registry, it doesn't exist to the system.
No AI platform UI chrome in entity extraction. The noise filter in entity_extraction_engine.php handles this. Do not regress it.
Context separation is coming. Do not mix LEGAiSEE business data with General/Memory data in any new DB queries. Tag everything with a context when adding new tables or columns.
Plain English always. Every module output must be human-readable sentences, not raw numbers or key/value dumps.

Paste this at the start of every new AI session
Last updated: 2026-05-08 Session with: Claude (Anthropic) — Sonnet 4

WHAT THIS SYSTEM IS
LEGAiSEE Business Archaeology & Authority Venture An operator-facing backend OS for John Carr (Carr Multimedia) that:
Ingests historical business artifacts (old marketing, documents, AI chats)
Analyzes and organizes them using semantic/graph/AI engines
Produces a strategic authority report for the client
Offers a client-facing dashboard/login so clients can view their results
John is not a coder. He builds by following AI instructions file by file. The system is approximately 50-60% complete.

SECOND GOAL — AI MEMORY SYSTEM
John wants to build a universal AI memory/storage/retrieval layer so he never has to re-teach an AI platform what he's building. The idea:
Paste/dump any AI chat session into the system
System organizes, deduplicates, tags by project/platform
Stores as searchable memory (RAG / semantic search)
Injects relevant context automatically at the start of new sessions
This conversation itself is the first real test case for that system.

SERVER & STACK
Host: SureServer — s413.sureserver.com
User: carrmulti
Live URL: https://www.legaisee.com/commandcenter/
Main entry: shell.php (Grand Lobby — loads modules)
Stack: PHP 8+, MySQL, flat JSON files
Brand: LEGAiSEE — gold/black color scheme (#F4E185, #CDAD69, #89612B, #0a0a0c)

DATABASE
Primary DB: MySQL
Host: localhost
DB name: carrmulti_legaiseearchive
User: legaiseeuser
Connection: kernel_db() function in kernel/kernel_boot.php
MySQL Tables & Status (as of 2026-05-08):
Table
Rows
Status
artifacts
0
empty
cases
1
live
documents
1
just migrated (Gemini prospecting)
entities
0
empty
entity_aliases
0
empty
events
0
empty
files
2
live
folders
5
live
goal_proposals
0
empty
page
16
live
page_content
16
live
relationships
0
empty
reports
0
empty
saved_views
0
empty
tasks
0
empty

SQLite: Retired. All 3 SQLite files deleted after migration session.

FOLDER STRUCTURE (INTENDED / CLEAN)
/commandcenter/
├── kernel/              ← BOOT LAYER (loads first, always)
│   ├── kernel_boot.php  ← starts session, requires paths + db
│   ├── kernel_paths.php ← defines all ROOT constants
│   ├── kernel.php
│   ├── kernel_contract.php
│   ├── module_contract.php
│   ├── module_registry.php
│   ├── engine_bindings.php
│   └── guard.php
│
├── modules/             ← SHELL LOADS THESE ({name}_module.php)
│   ├── intelligence_dashboard_module.php
│   ├── files_module.php
│   ├── graph_module.php
│   ├── clients_module.php
│   ├── cases_module.php
│   ├── excavation_module.php
│   ├── report_module.php
│   ├── search_module.php
│   ├── ingest_module.php
│   ├── dashboard_module.php
│   ├── vault_module.php
│   ├── recommendation_module.php
│   ├── executive_dashboard_module.php
│   ├── brain_module.php
│   ├── predictive_module.php
│   └── utils/
│       ├── bootstrap.php   ← load_json_dir()
│       ├── debug_helpers.php
│       └── file_helpers.php
│
├── engine/              ← PROCESSING ENGINES (called by modules)
│   ├── semantic_cluster_engine.php
│   ├── predictive_intelligence_engine.php
│   ├── decision_engine_v2.php
│   ├── anomaly_detection_engine.php
│   ├── recommendation_engine.php
│   ├── execution_router.php
│   ├── cross_case_engine.php
│   └── ...
│
├── core/                ← BRAIN & MEMORY
│   ├── brain_orchestrator.php
│   ├── memory_evolution_engine.php
│   ├── temporal_memory_engine.php
│   └── reasoning_engine.php
│
├── agents/              ← AUTONOMOUS WORKERS
│   ├── agent_spawn.php
│   ├── agent_tick.php
│   └── autonomous_engine.php
│
├── api/                 ← JSON ENDPOINTS ONLY
│   └── api.php
│
├── data/                ← FLAT FILE STORE
│   ├── cases/           ← 17 JSON files (case_001.json etc)
│   ├── clients/         ← 5 JSON files
│   ├── network/         ← 8 JSON files
│   ├── memory/
│   ├── goals/
│   ├── graph/
│   └── brains/
│
├── ui/                  ← FRONTEND ASSETS
│   ├── global.css
│   ├── ui_bootstrap.php ← legaisee_ui_bootstrap()
│   └── images/
│
├── portal/              ← CLIENT-FACING (IN PROGRESS)
│   ├── login.php
│   ├── dashboard.php
│   └── vault.php
│
├── shell.php            ← GRAND LOBBY (main entry)
├── index.php
└── .htaccess


KERNEL BOOT CHAIN (CRITICAL — MUST LOAD IN THIS ORDER)
// kernel/kernel_boot.php must do ALL of this:
require_once __DIR__ . '/kernel_paths.php';  // ← WAS MISSING, caused FILES_ROOT error
session_start();                              // ← WAS EMPTY BLOCK, session never started
// then defines kernel_db() PDO singleton → MySQL

kernel_paths.php constants:
define('KERNEL_ROOT',  __DIR__ . '/../');
define('DATA_ROOT',    KERNEL_ROOT . 'data/');
define('FILES_ROOT',   DATA_ROOT . 'files/');
define('CLIENTS_ROOT', DATA_ROOT . 'clients/');
define('CASES_ROOT',   DATA_ROOT . 'cases/');
define('MEMORY_ROOT',  DATA_ROOT . 'memory/');


SHELL.PHP — THE GRAND LOBBY
shell.php is the main operator interface. It renders 4 wings:
Executive → loads intelligence_dashboard_module
Excavation → loads files_module
Graph / Network → loads graph_module
Client Vault → loads clients_module
renderModule($name) looks for /modules/{name}_module.php

KNOWN BUGS IDENTIFIED (fix next session)
Bug 1 — graph_module.php
Uses global $db which is never set → null PDO
Also fires JSON headers even when loaded by shell.php (not standalone)
Fix: Replace execution wrapper — detect if standalone vs required, use kernel_db()
Bug 2 — clients_module.php
$clientId undefined on line 13 — mkdir block runs unconditionally
Fix: Wrap mkdir block in if (!empty($clientId))
Bug 3 — kernel_boot.php
require_once kernel_paths.php is MISSING
Session block is empty — session never starts
Fix: Add both lines (shown above)
Bug 4 — intelligence_dashboard_module
Returns indexed arrays [0,1,2] not keyed arrays
shell.php renders keys as "0:", "1:" etc
Fix: Module needs to return named keys

WHAT WAS COMPLETED THIS SESSION
✔ Full system diagnostic built and run
✔ Identified all 4 wing errors in shell.php
✔ Mapped correct folder structure
✔ Deleted all duplicate/copy files (~35 files)
✔ Reviewed all SQLite data
✔ Migrated Gemini prospecting record to MySQL documents table
✔ SQLite fully retired
✔ This Project Bible created

NEXT SESSION — PRIORITY ORDER
Apply the 3 kernel_boot.php fixes
Apply graph_module.php fix
Apply clients_module.php fix
Run live URL and verify all 4 wings render correctly
Begin building: AI Chat Ingest & Memory System
Paste any AI conversation into the system
Auto-tag by project, platform, date
Store in documents table with embeddings
Retrieve relevant context on demand
Inject as system prompt prefix for new sessions

JOHN'S TERMINOLOGY (USE THESE EXACT WORDS)
Excavation = ingesting/analyzing historical business artifacts
Archaeology = the overall methodology
Authority = the strategic positioning output
Dossier = compiled client intelligence file
Grand Lobby = the shell.php main dashboard
Wings = the four sections of the Grand Lobby
Vault = client-facing secure area
Artifact = any raw input document (old ad, chat, document)
Brain = the AI reasoning/memory orchestration layer
Sovereign Intelligence Environment = the overall system brand name

CREDENTIALS REMINDER
Move DB credentials out of kernel_boot.php into a config file outside the web root before the client portal goes live. Currently plaintext in kernel/kernel_boot.php.
LEGAISEE PROJECT BIBLE — SESSION UPDATE
Date: 2026-05-08
AI: Claude Sonnet 4.6
Append this to the bottom of LEGAISEE_PROJECT_BIBLE.md

SESSION 2026-05-08 — WHAT WAS ACCOMPLISHED
System Stabilization Complete
The Grand Lobby (shell.php) is now fully operational with 25 module wings loading correctly.
Files Changed / Created This Session
File
Location
What Changed
kernel_boot.php
kernel/
Added kernel_paths.php require, session_start(), global $db = kernel_db(), kernel_validate_runtime()
kernel_paths.php
kernel/
Confirmed correct — defines FILES_ROOT, CLIENTS_ROOT, CASES_ROOT, MEMORY_ROOT
shell.php
commandcenter/
Full rebuild — single wing-grid, 25 modules, static $loaded[] prevents double-load
graph_module.php
modules/
Wrapped class in class_exists() guard — fixes redeclare fatal error
uic_v1.php
modules/utils/
Added render_generic(), render_list(), render_grid(), uic_truncate(), uic_select(), overflow fixes
files_module.php
modules/
Now pulls from MySQL files + documents tables + data/files + archive folders
ingest_module.php
modules/
Full ingest form as HTML fragment — stats + form + recent sessions
clients_module.php
modules/
Fixed undefined $clientId causing mkdir to run unconditionally
cases_module.php
modules/
Renders each case as card row — ID, status, client, pattern tags
compare_module.php
modules/
Fixed null htmlspecialchars deprecation — clean two-input compare UI
anomaly_engine_module.php
modules/
Fixed global $pdo null — now uses kernel_db() via anomaly_fetch() helper
entity_resolution_module.php
modules/
Fixed $pdo check — now uses kernel_db(), shows entity/alias counts
dashboard_module.php
modules/
Added 'type' => 'list' to return array
insight_module.php
modules/
Added 'type' => 'list' to return array
intelligence_dashboard_module.php
modules/
Working — UIC artifact + dataset + system rendering correctly
legaisee_diagnostic.php
commandcenter/
READ ONLY diagnostic tool — delete after use
legaisee_sqlite_viewer.php
commandcenter/
READ ONLY SQLite viewer — delete after use
legaisee_migrate_sqlite.php
commandcenter/
Migration script — delete after use

Database Changes This Session
MySQL tables added:
memory_domains  -- AI chat domain categories
projects        -- Project groupings for memory
memory_ingest   -- Raw AI transcript storage
clusters        -- Case cluster storage

Seeded data:
memory_domains: Legaisee Build, Business Archaeology, Prospecting, General
projects: Command Center Build, Client Analysis, New Braunfels Prospecting
SQLite fully retired:
Gemini prospecting record migrated to MySQL documents table
database.sqlite, legaisee.db, legaisee.db.bak all deleted
Module Status After This Session
Module
Status
Notes
intelligence_dashboard
✔ Working
Mock data — needs real pipeline connection
dashboard
✔ Working
Shows case/client counts from JSON
excavation
⚠ Partial
Shows {} + empty report — excavation_engine needs wiring
files
✔ Working
Shows files from MySQL + folder scan
graph
✔ Working
Shows entity/relationship counts (both 0 — tables empty)
clients
✔ Working
Renders client cards from JSON
cases
✔ Working
Renders case rows with status/client/patterns
brain
✔ Working
Shows system status, module registry, data layer
ingest
✔ Working
Full ingest form + stats inline in shell
anomaly_engine
✔ Working
Returns LOW risk (no entities/relationships yet)
cluster
✔ Working
Shows clusters from DB
compare
✔ Working
Two-input compare UI — semantic_diff_engine not connected yet
decision
✔ Working
Shows case decisions from JSON
entity_resolution
✔ Working
Ready state — 0 entities (MySQL entities table empty)
insight
✔ Working
Shows case status distribution
predictive
✔ Working
Pattern transition probabilities
recommendation
⚠ Partial
"No cases found" — needs MySQL cases table populated
relations
✔ Working
Case→Client map, pattern co-occurrence
report
✔ Working
Connected
root_cause
✔ Working
22 node graph data
search
✔ Working
Returns file paths with scores
semantic_cluster_v1
✘ Missing
Module file name mismatch — fix shell.php wing name
time_intelligence
✔ Working
Trend analysis (empty — needs data)
vault
✔ Working
0 artifacts — needs excavation pipeline
view
✔ Working
Diff comparison view

Remaining Issues (fix next session)
Semantic cluster module name — in shell.php wings array change to 'semantic_cluster_v1'
Duplicate ingest wing — Memory wing says "Already loaded: ingest" — remove duplicate from Excavation section in shell.php
Entities/Relationships = 0 — MySQL entities and relationships tables are empty. Need excavation pipeline to populate them.
Recommendation "No cases found" — recommendation_module.php reads from MySQL cases table which is empty (only 1 row). Cases live in JSON files. Module needs updating to read from JSON like other modules do.
Excavation wing shows {} — excavation_module.php not fully wired to pipeline
Search showing full server paths — search_module.php returning absolute paths, should return relative or titles only
View wing overflow — long content strings still breaking layout in view_module
Architecture Decision Made This Session
The correct pattern for this system:
shell.php = Grand Lobby — module summary cards only
modules/{name}_module.php = HTML fragment returned via ob_start/ob_get_clean or return string
ingest.php, future pages/clients.php etc = full standalone pages with own layout
Modules must NEVER contain full HTML page structure (DOCTYPE, head, body)
All DB access via kernel_db() — never raw PDO inline or $pdo global
Next Session Priority Order
Fix shell.php semantic_cluster name + remove duplicate ingest wing
Populate MySQL entities/relationships tables via excavation pipeline
Fix recommendation_module.php to read from JSON cases
Fix search_module.php paths
Build full-page views for: Clients, Cases, Excavation, Reports
Wire nav bar links to full-page views
Begin client portal (login + dashboard + vault)
Connect semantic_diff_engine to compare module
Start building AI memory retrieval — query stored transcripts, inject as context
Key Technical Facts to Remember
Global $db is set at boot — kernel_boot.php sets global $db; $db = kernel_db(); So modules can use either $db OR kernel_db() — both work now.
kernel_validate_runtime() — now defined in kernel_boot.php, returns true if DB connected.
renderModule() in shell.php — uses static $loaded[] to prevent double-loading. If a module name appears twice in the wings array, second load shows "Already loaded: {name}".
UIC types supported: artifact, dataset, system, list, grid + generic fallback for all others. Any module returning array with unknown 'type' gets rendered by render_generic().
Module return options:
Return a string → rendered directly
Return array with 'type' key → routed through uic_render()
Return array without 'type' → rendered as key/value exec-panel
Use ob_start()/ob_get_clean() → return HTML string for complex layouts
Data Flow (current state)
JSON files (data/cases/, data/clients/)
    → load_json_dir() in modules/utils/bootstrap.php
    → cases_module, clients_module, dashboard_module, insight_module etc

MySQL (carrmulti_legaiseearchive)
    → kernel_db() PDO singleton
    → files_module, ingest_module, entity_resolution, anomaly etc

memory_ingest table
    → ingest.php form → stores raw AI transcripts
    → NOT YET: processing pipeline to extract/index content

entities + relationships tables
    → EMPTY — need excavation pipeline to populate
    → graph_module, anomaly, entity_resolution all waiting on this


End of 2026-05-08 session update
LEGAISEE PROJECT BIBLE — SESSION UPDATE Date: 2026-05-12 AI: Claude Sonnet 4.6 Append to bottom of LEGAISEE_PROJECT_BIBLE.md

SESSION 2026-05-12 — WHAT WAS ACCOMPLISHED
Bugs Fixed This Session
File
Fix
shell.php
Removed dead code block ($module_request, $intelligence_context, duplicate renderModule) — was causing fatal IntelligenceLayer error
modules/insight_module.php
Added $statusMap build loop — was undefined, causing count() error
modules/recommendation_module.php
Full rewrite — now reads from JSON cases via load_json_dir, returns UIC list
modules/excavation_module.php
Fixed missing comma in items array causing "unexpected token =>" error

New Files Created This Session
File
Purpose
engine/entity_extraction_engine.php
Extracts entities + relationships from artifact text, writes to MySQL entities/relationships/entity_aliases tables. Functions: lee_extract_entity_candidates(), lee_upsert_entity(), lee_insert_alias(), lee_upsert_relationship(), lee_extract_and_store()
commandcenter/prospect.php
Shallow Dig page — paste anything about a prospect, runs signal extraction, produces Authority Dossier with score, signals, narratives, recommended actions. Saves to data/prospects/ as JSON. Print/PDF button included.

Current System Status
All 25 wings loading. Known remaining issues: search_module returning absolute paths, excavation wing shows empty when no artifact metadata exists, semantic_diff_engine not connected to compare module.
Revenue Track Status
prospect.php is built and ready to test. Next session: test a real prospect through it, tweak output, then add Prospect link to shell.php nav bar.
Next Session Priority Order
Test prospect.php with a real prospect — verify dossier output looks good
Add "Prospect Dig" link to shell.php nav bar
Fix search_module.php paths
Build full-page views (Clients, Cases, Reports)
Wire nav bar links
Begin client portal
Architecture Notes
data/prospects/ folder created by prospect.php automatically on first run
DB credentials still plaintext in kernel/kernel_boot.php — move before portal goes live
Original compare layout (compare.php) preserved for reference — gold/black dual-pane with find-in-pane search, to be used when semantic_diff_engine gets wired

Save that to the Bible and paste it at the start of next session. We're one test away from your first working prospect dossier.
LEGAISEE PROJECT BIBLE — SESSION UPDATE Date: 2026-05-13 AI: Claude Sonnet 4.6 Append to bottom of LEGAISEE_PROJECT_BIBLE.md

SESSION 2026-05-13 — WHAT WAS ACCOMPLISHED
Architecture Restored
Shell.php restored to its original intended pattern — ?module=name router. No module param shows grouped card dashboard. Global.css is now the single stylesheet. No embedded CSS anywhere.
Files Changed / Created This Session
File
Location
What Changed
shell.php
commandcenter/
Restored to ?module= router, grouped card dashboard, links global.css
global.css
ui/
Red debug outline removed, glassmorphism cards, background image, blur topbar, full system styles consolidated
module_registry.php
kernel/
Fixed 3 broken mappings, removed duplicate keys
entity_extraction_engine.php
engine/
Full rewrite — sentence-level relationships, 80+ noise words, 10 relationship types, confidence scoring
search_module.php
modules/
Replaced mock data with real search — JSON cases/clients/prospects + MySQL documents/files
prospect.php
commandcenter/
Scoring rewritten — confidence-weighted, requires 2+ keyword hits, score range 28-96, content depth bonus

Key Fixes This Session
Entity extraction was capturing UI chrome (Follow, Analyze, Perplexity) as entities — fixed with expanded noise filter
Relationship detection was combinatorial pairing of first 8 entities regardless of meaning — fixed with sentence-level co-occurrence
Relationship types expanded from 2 to 10 — competes_with, client_of, built, located_in, founded_by, employs, partners_with, reviewed_by, has_issue_with, regulated_by
Prospect scoring was always 98 — fixed with hit-count confidence weighting
module_registry.php had broken mappings: cross_case_engine, entity_resolution_module, predictive_link_module — all fixed
global.css had body { outline: 10px solid red !important; } debug line — removed
Architecture Decisions Made This Session
The correct pattern reconfirmed and restored:
shell.php = module router + Grand Lobby dashboard
modules/{name}_module.php = data/logic only, no DOCTYPE/head/body
ui/global.css = one stylesheet, all pages link it, no embedded CSS
prospect.php + ingest.php = legitimate standalone exceptions (workarounds that preceded the pattern)
All new modules go in modules/ and register in module_registry.php
Standalone Pages That Need Converting to Modules
File
Status
Should Become
temp_dashboard.php
Full page — working ingest
ingest_module.php replacement
view_ingest.php
Full page — piece of files_module
merge into files_module.php
prospect.php
Standalone — keep, legitimate exception
prospect_module.php eventually
search.php
Built this session — should not exist
search_module.php already exists, delete search.php
brain.php
Drifted standalone
already brain_module.php — delete brain.php

System Vision Clarified This Session
LEGAiSEE is not just a prospect tool. It is a three-phase business:
Phase 1 — Authority Dossier (Shallow Dig) — already working, first paid product Phase 2 — Full Business Archaeology Report — AI sweep + John verification + report generation Phase 3 — Living client vault — subscription intelligence, ongoing authority management Phase 4 — Cross-client pattern intelligence — industry insights no competitor can replicate Phase 5 — Platform licensing to other agencies
The actual workflow:
AI sweep — system ingests, extracts, scores
John's review — confirms, corrects, verifies findings
System assembles — report from verified data only
Client receives — human-verified, AI-powered deliverable
The Dig Review Interface needs to be built — operator UI where John marks each extracted finding as confirmed / rejected / needs-more-info. Verified findings only flow into reports.
Three Systems / One Intelligence Layer
System
Contents
LEGAiSEE Business
Clients, cases, prospects, reports, portal — revenue engine
AI Memory & Chat Backup
Paste any AI chat, system sorts by project/date/similarity, generates project bibles
General / Everything Else
Notes, side projects, Carr Multimedia docs, anything else
Shared Intelligence
Entity extraction, clustering, anomaly, recommendations — serves all three, data stays separated by context tag

Next Session Priority Order
Identify and list all duplicate/orphaned standalone pages vs their module equivalents
Merge temp_dashboard.php functionality into ingest_module.php
Merge view_ingest.php functionality into files_module.php
Delete orphaned standalones (search.php, brain.php, any others identified)
Add context column to major DB tables for project separation
Build Dig Review Interface — verified/rejected/needs-more-info flags on extracted findings
Begin plain English output layer — every module interprets its numbers into sentences
Define Authority Report template — what a completed report looks like section by section
Modules Needing Plain English Output Layer
Every module currently shows raw numbers. All need interpretation sentences added. Priority order: relations, graph, anomaly, insight, recommendation, cluster, cross_case, time_intelligence.
Key Technical Facts
Server: SureServer shared hosting — adequate for current build, migrate to own hardware after revenue
Workflow: AI sweep first, John verifies second, report assembles from verified only
Human verification layer is the competitive moat — not just AI output
context tagging not yet implemented — all DB tables currently mix all project data together
prospect.php Prospect Dig link added to shell.php nav

---

## SESSION 2026-05-17 — INFRASTRUCTURE STRATEGY + MEMORY ENGINE ARCHITECTURE

**AI:** Claude Sonnet 4.6

---

### What Was Accomplished This Session

**Modules built / deployed:**
- `ingest_module.php` — full migration of `commandcenter/ingest.php` into proper module pattern. Three tabs: Paste AI Chat, Upload File, Stored Sessions. Handles transcript storage, file upload, session deletion.
- `files_module.php` — full Windows/macOS-style file manager. Folder tree (left), file list (right), inline viewer with edit/save. Create folders, create files, delete, rename, move, upload — all via API.
- `api/files_action.php` — standalone JSON endpoint for all file manager operations. Bypasses shell.php buffer.
- `search_module.php` — rebuilt as true 3-column layout (search column, Pane A, Pane B). Full system search across all JSON and MySQL sources. Select result → Set A/Set B loads content into panes via API.
- `api/search_load.php` — standalone JSON endpoint for search content loading. Fixes the shell.php ob_start() buffer problem that was blocking Set A/Set B from working.

**CSS delivered:**
- `ingest_and_files_css.css` — append to `ui/global.css`
- `search_module_css.css` — append to `ui/global.css`

**Architecture rule learned this session:**
When a module needs to return JSON (AJAX), it CANNOT go through `shell.php` — the `renderModule()` ob_start() buffer traps the response. All JSON endpoints must live in `api/` and be called directly by URL. Pattern: `api/{name}_action.php` or `api/{name}_load.php`.

---

### Infrastructure Strategy — Decisions Made This Session

#### Server Phase Plan

| Phase | Infrastructure | When |
|-------|---------------|------|
| Phase 1 | SureServer shared hosting — current | Now through first 5-10 paying clients |
| Phase 1.5 | VPS upgrade ($40-80/mo) — same codebase, more RAM + storage | When shared server shows strain |
| Phase 2 | Own dedicated server ($150-300/mo) OR physical box ($3-5k one-time) | After consistent revenue |
| Phase 3 | Client-owned "memory appliance" — physical server at client location | Premium upsell product |

**Current shared server is fine for Phase 1.** The bottleneck will be storage (archived client documents), not CPU. GPU not needed until local AI inference — which is not needed while API calls are available.

#### Deployment Model Decision

**Start: Centralized (John's server)**
All clients on one server. Easier to update, maintain, bill, and iterate.

**Upsell: Client-owned appliance (Model B)**
Physical server installed at client location. Client owns data. $5-15k product + annual support contract. Build this after the software is proven. Strong positioning: "You own your intelligence."

**Long-term: Hybrid (Model C)**
Client owns local memory core + vector DB. John provides intelligence layer, dashboards, model routing, updates via cloud. Recurring revenue + data sovereignty. This is probably the eventual winner.

#### Server Sizing for Multiple Clients (John's hardware)

For 20+ clients in Phase 1-2 (business archaeology, document storage, report generation):

```
CPU:     8-16 core (AMD Ryzen 9 or equivalent) — $300-500
RAM:     64GB — $150
Storage: 4-8TB NAS/SSD — $200-400
GPU:     None needed yet (using APIs)
OS:      Ubuntu Server 22.04 LTS
Stack:   PHP 8+, MySQL, Nginx, Docker for vector DB
Monthly: $0 if own hardware, $150-300 if rented dedicated
```

A $2-4k physical server handles Phase 1-2 comfortably. Upgrade GPU when local inference begins.

---

### What LEGAiSEE Actually Is — Vision Locked This Session

LEGAiSEE is not a chatbot, not a website tool, not a reporting dashboard.

**LEGAiSEE is a Business Memory Operating System.**

Core value proposition:
- Companies are sitting on "dark data" — buried marketing assets, forgotten strategies, lost operational knowledge, dormant authority signals
- LEGAiSEE excavates, organizes, and makes that intelligence actionable
- Then it stays alive — continuously ingesting new data so the memory never goes dark again

This is defensible because:
- The longitudinal data (client's full business history) cannot be replicated once built
- Human verification layer (Dig Review) means output is trusted, not just generated
- The longer a client stays, the more valuable the system becomes

---

### Technical Components Needed for Ongoing Business Memory Engine

These are the next major build milestones beyond current Phase 1:

#### 1. Vector Database (Phase 2 priority)

**What:** Converts documents/transcripts into numerical embeddings for semantic search.
**Why:** Keyword search finds "marketing" — vector search finds "any document about brand positioning even if it doesn't use that word."
**How to add:**
- Option A: `pgvector` extension for PostgreSQL (free, familiar SQL-like queries)
- Option B: `Qdrant` — free, runs as Docker container on same server, PHP client available
- Option C: Start with OpenAI embeddings API → store vectors in MySQL BLOB column (hacky but works for Phase 1.5)

**Tables needed:**
```sql
embeddings (
    id, source_table, source_id, context,
    model VARCHAR(64),
    vector BLOB,  -- or use pgvector type
    created_at
)
```

#### 2. Embedding Pipeline

**What:** On every ingest, call embedding API and store the vector.
**Why:** Makes every document semantically searchable immediately.
**How:** PHP function `lee_embed($text)` → calls OpenAI `text-embedding-3-small` → stores result.
Cost: ~$0.0001 per 1,000 tokens. A 10,000-word document costs $0.001. Negligible.

**Where it hooks in:** `ingest_module.php` after storing to `memory_ingest`. `entity_extraction_engine.php` after extracting entities.

#### 3. Timeline Engine (partially built)

**What:** Tracks how a business changed over time. Not just "what happened" but "when and in what sequence."
**Why:** The timeline itself IS the product for many clients — seeing their business evolution is the insight.
**Status:** `events` table exists but is empty. `time_intelligence_module.php` exists but shows no data.
**What's needed:** Populate events table from ingested artifacts. Detect date references in documents. Auto-tag events with: `marketing_change`, `leadership_change`, `pricing_change`, `branding_pivot`, `operational_change`.

#### 4. Continuous Ingestion Layer (Phase 2)

**What:** System automatically pulls new data without John manually pasting.
**Sources to add:**
- Website snapshot monitor (cron + diff detection)
- Google Business Profile changes
- Social media activity (where API available)
- Review platform monitoring (Google, Yelp, BBB)
- Ad performance exports (manual upload initially, API later)

**How:** PHP cron scripts in `agents/` folder — already exists in architecture. `agent_tick.php` is the scheduled worker.

#### 5. Authority Scoring Engine (already started in prospect.php)

**What:** Scores a business's authority across multiple dimensions.
**Current state:** `prospect.php` has confidence-weighted scoring (28-96 range).
**What's needed:** Break into sub-dimensions:
```
Digital Presence Score    (0-20)
Content & Credibility     (0-20)
Network Strength          (0-20)
Reputation Signals        (0-20)
Consistency & Clarity     (0-20)
TOTAL                     (0-100)
```
Each sub-score should update over time as new data is ingested. A client's score improving over months IS the product working.

#### 6. Client Isolation (in progress)

**Status:** `context` column SQL migration written and delivered this session.
**What's needed after running migration:** Add `WHERE context = 'legaisee'` to all module queries that should only see business data. Add `WHERE context = 'memory'` for AI session queries.

---

### Marketing Strategy Notes (from session discussion)

LEGAiSEE's product line maps to the "missing AI categories" identified:

| Category | LEGAiSEE Product |
|----------|-----------------|
| AI Business Archaeology | Phase 2 Full Report — already building |
| AI Legacy Preservation | Phase 3 Living Vault — planned |
| AI Reputation Shield | Authority Monitoring — future module |
| AI Reality Compression | Executive Briefing output — part of report |
| Personal AI Memory Archivist | AI Memory System — second system, in progress |

The differentiator across all of these: **human verification layer**. Not just AI output — AI-assisted, human-confirmed intelligence. That's the moat.

---

### New Components to Add to module_registry.php

```php
'files'      => ['file' => MODULES_ROOT . 'files_module.php',      'label' => 'File Manager',    'category' => 'operator'],
'ingest'     => ['file' => MODULES_ROOT . 'ingest_module.php',      'label' => 'Ingest',          'category' => 'memory'],
'dig_review' => ['file' => MODULES_ROOT . 'dig_review_module.php',  'label' => 'Dig Review',      'category' => 'operator'],
'search'     => ['file' => MODULES_ROOT . 'search_module.php',      'label' => 'System Search',   'category' => 'operator'],
```

---

### Files Delivered This Session

| File | Upload to |
|------|-----------|
| `ingest_module.php` | `commandcenter/modules/` |
| `files_module.php` | `commandcenter/modules/` |
| `files_action.php` | `commandcenter/api/` |
| `search_module.php` | `commandcenter/modules/` |
| `search_load.php` | `commandcenter/api/` |
| `ingest_and_files_css.css` | Paste contents into bottom of `ui/global.css` |
| `search_module_css.css` | Paste contents into bottom of `ui/global.css` |
| `dig_review_module.php` | `commandcenter/modules/` (from prev session) |
| `plain_english_helper.php` | `commandcenter/engine/` (from prev session) |
| `context_migration.sql` | Run in phpMyAdmin → SQL tab (from prev session) |

---

### Next Session Priority Order

1. **Deploy all delivered files** — verify each module loads in shell.php
2. **Run context_migration.sql** — adds context column to all major tables
3. **Add context filters to module queries** — `WHERE context = 'legaisee'` in cases/clients/prospects modules
4. **Build embedding pipeline** — `lee_embed()` function, wire into ingest_module on save
5. **Populate events table** — date extraction from ingested documents → auto-create timeline events
6. **Add case_id to review_flags** — prerequisite for report assembly
7. **Begin report_module.php** — pulls confirmed-only findings, assembles Authority Report sections
8. **Test full prospect → dig review → report pipeline** with Brad Moore Builders data (already in system)
9. **Wire plain_english_helper.php** into all 8 priority modules (relations, graph, anomaly, insight, recommendation, cluster, cross_case, time_intelligence)

---

### Key Technical Facts Added This Session

**AJAX through shell.php is broken by design.**
shell.php uses ob_start() in renderModule(). Any module that needs to return JSON must use `api/` endpoint instead. Pattern: JS fetches `/commandcenter/api/{name}.php?action=...` directly. Never `?module=name&action=...`.

**File manager root:** `KERNEL_ROOT` (commandcenter/ directory). Security check in `files_action.php` ensures all paths stay within that root. kernel/ is explicitly protected from deletion.

**Embedding cost estimate:** OpenAI `text-embedding-3-small` at $0.02/million tokens. A client with 500 documents averaging 2,000 words each = 1,000,000 tokens = $0.02 total. Negligible.

**Vector DB recommendation for Phase 1.5:** Start with `pgvector` if moving to PostgreSQL, or store OpenAI embedding vectors as JSON in a MySQL column. Not elegant but works. Migrate to Qdrant when vector queries become frequent.

**The business model insight:** The longer a client's data is in LEGAiSEE, the more valuable the system becomes. This creates natural lock-in through accumulated intelligence, not artificial barriers. That's the right kind of moat.

