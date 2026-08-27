# FILE: _governance/ARCHITECTURE_LOCK.md

# LEGAiSEE — ARCHITECTURE LOCK

### Immutable System Architecture

### Version 1.0

### Last Updated: 2026-05-19

---

# PURPOSE

This document defines the permanent architectural foundation of LEGAiSEE.

These decisions are considered locked unless explicitly overridden by John Carr.

AI systems are NOT authorized to reinterpret, modernize, replace, simplify, or redesign these architectural decisions.

This document exists to prevent:

* architecture drift
* framework creep
* uncontrolled modernization
* routing fragmentation
* duplicated systems
* long-term entropy

---

# LOCKED CORE STACK

## Backend Stack

LOCKED:

* PHP 8+
* MySQL
* Flat JSON supplemental storage

FORBIDDEN WITHOUT APPROVAL:

* Node.js migration
* Laravel
* Symfony
* Django
* Rails
* serverless rewrites

---

## Frontend Stack

LOCKED:

* server-rendered PHP fragments
* global.css singleton stylesheet
* lightweight JS only

FORBIDDEN WITHOUT APPROVAL:

* React migration
* Vue migration
* Angular
* Tailwind conversion
* component framework rewrites

---

# LOCKED ROUTING ARCHITECTURE

## shell.php

LOCKED PURPOSE:
Router and Grand Lobby only.

shell.php:

* loads modules
* routes via ?module=
* renders dashboard cards

shell.php MUST NOT:

* become SPA router
* become API gateway
* contain business logic
* contain module logic

---

## Module System

LOCKED STRUCTURE:

```text id="4n9u7p"
modules/{name}_module.php
```

All system functionality is module-based unless explicitly approved otherwise.

Modules:

* return fragments only
* do not output full pages
* do not embed CSS
* do not return JSON

---

## API Architecture

LOCKED STRUCTURE:

```text id="r7jtf9"
api/{name}_action.php
```

All JSON/AJAX logic routes through api/.

Modules NEVER directly return JSON through shell.php.

---

# LOCKED CSS SYSTEM

## global.css

LOCKED RULE:
Single stylesheet architecture.

ALL styling must exist in:

```text id="9y7kq2"
ui/global.css
```

FORBIDDEN:

* inline CSS
* module style tags
* alternate theme systems
* CSS frameworks
* scattered stylesheets

---

# LOCKED DATABASE ACCESS

LOCKED RULE:
Use kernel_db() only.

FORBIDDEN:

* direct PDO creation
* mysqli
* duplicate DB layers
* ORM systems unless explicitly approved

---

# LOCKED CONTEXT SEPARATION

Contexts are mandatory:

* legaisee
* memory
* general

This separation MUST remain intact.

Cross-context contamination is forbidden.

---

# LOCKED TERMINOLOGY

The following terminology is canonical:

* Excavation
* Archaeology
* Authority
* Dossier
* Grand Lobby
* Wings
* Vault
* Artifact
* Brain
* Dig
* Dig Review
* Sovereign Intelligence Environment

AI systems may NOT rename these concepts.

---

# LOCKED DEPLOYMENT MODEL

Current deployment model:

* SureServer shared hosting
* live production editing
* modular PHP deployment

Future upgrade path:

* VPS
* dedicated server
* sovereign client appliance

The architecture should remain compatible with this roadmap.

---

# FINAL RULE

If an AI believes:

* a framework would be “better”
* architecture should be “modernized”
* routing should be “simplified”
* systems should be “refactored”

The AI must:

1. STOP
2. Explain reasoning
3. Wait for explicit approval

No architectural reinterpretation is allowed.

---

# END ARCHITECTURE LOCK

==================================================
FILE: _governance/DECISION_LOG.md
=================================

# LEGAiSEE — DECISION LOG

### Institutional Architectural Memory

### Last Updated: 2026-05-19

---

# PURPOSE

This document records WHY architectural decisions were made.

AI systems must consult this file before proposing changes.

This prevents:

* repeated debates
* architecture drift
* forgotten reasoning
* accidental reversals

---

# DECISION ENTRIES

---

## 2026-05-19

### Decision:

Use module-only architecture.

### Reason:

Prevents routing fragmentation and preserves centralized shell control.

### Alternatives Rejected:

* standalone pages
* multi-page architecture
* SPA conversion

### Long-Term Impact:

Improves maintainability and architectural consistency.

---

## 2026-05-19

### Decision:

Use global.css as single stylesheet.

### Reason:

Prevents CSS fragmentation and visual inconsistency.

### Alternatives Rejected:

* component CSS
* inline styles
* CSS frameworks

### Long-Term Impact:

Preserves unified visual system.

---

## 2026-05-19

### Decision:

Separate JSON APIs into api/ endpoints.

### Reason:

shell.php buffering interferes with JSON responses.

### Alternatives Rejected:

* AJAX through shell.php
* mixed HTML/API routing

### Long-Term Impact:

Clear separation between rendering and data transport.

---

## 2026-05-19

### Decision:

Claude acts as governance layer while Windsurf/GPT act as execution workers.

### Reason:

Claude preserves architecture more reliably while execution AIs are faster at implementation.

### Long-Term Impact:

Reduces architecture drift and preserves continuity.

---

# FUTURE ENTRIES

Append future decisions here.

Always include:

* date
* decision
* reasoning
* rejected alternatives
* long-term implications

---

# END DECISION LOG

==================================================
FILE: _governance/PROTECTED_FILES.md
====================================

# LEGAiSEE — PROTECTED FILES

### Restricted Modification List

### Last Updated: 2026-05-19

---

# PURPOSE

These files are considered high-risk architectural components.

AI systems may NOT modify these files unless:

* explicitly approved
* directly included in BUILD_SPEC
* operator-authorized

---

# CRITICAL PROTECTED FILES

## Core Routing

```text id="m2nrt5"
shell.php
```

Risk:
Global routing failure.

---

## Kernel Boot

```text id="tk0q0y"
kernel/kernel_boot.php
kernel/kernel_paths.php
kernel/kernel.php
```

Risk:
Entire runtime instability.

---

## Registry Systems

```text id="tl4yvt"
kernel/module_registry.php
```

Risk:
Module discoverability failure.

---

## CSS Core

```text id="xjmnz7"
ui/global.css
```

Risk:
System-wide UI damage.

---

## Server Rules

```text id="yec0g0"
.htaccess
```

Risk:
Routing/security breakage.

---

# SEMI-PROTECTED FILES

These require caution:

```text id="0a2ggo"
modules/search_module.php
modules/files_module.php
modules/ingest_module.php
api/search_load.php
api/files_action.php
```

Reason:
Core operational systems.

---

# RULES

If modification is required:

1. Explain WHY
2. Explain risk
3. Explain affected systems
4. Request approval before editing

---

# END PROTECTED FILES

==================================================
FILE: _governance/CHANGE_IMPACT_MATRIX.md
=========================================

# LEGAiSEE — CHANGE IMPACT MATRIX

### Dependency Awareness Map

### Last Updated: 2026-05-19

---

# PURPOSE

This document teaches AI systems how changes propagate through LEGAiSEE.

Before modifying any file:

* identify downstream systems
* identify risk zones
* identify dependency chains

---

# CORE SYSTEM IMPACTS

| System/File                  | Affects                     | Risk    |
| ---------------------------- | --------------------------- | ------- |
| shell.php                    | all module rendering        | EXTREME |
| kernel_boot.php              | runtime, DB, sessions       | EXTREME |
| module_registry.php          | module discovery            | HIGH    |
| global.css                   | entire UI                   | HIGH    |
| api/*                        | module AJAX behavior        | HIGH    |
| files_module.php             | file management workflows   | HIGH    |
| search_module.php            | compare/search systems      | HIGH    |
| ingest_module.php            | memory ingestion pipeline   | HIGH    |
| entity_extraction_engine.php | archaeology intelligence    | HIGH    |
| plain_english_helper.php     | human-readable outputs      | MEDIUM  |
| data/*                       | persisted operational state | MEDIUM  |

---

# HIGH-RISK CASCADE AREAS

## shell.php

Changes may affect:

* all module rendering
* dashboard navigation
* routing behavior
* rendering flow

---

## global.css

Changes may affect:

* every module
* spacing/layout
* theme consistency
* cards/buttons/tables

---

## kernel_boot.php

Changes may affect:

* database access
* sessions
* runtime validation
* system startup

---

# LOW-RISK SAFE ZONES

Generally safer:

* isolated module UI additions
* isolated engine functions
* isolated api endpoints
* new scoped CSS classes

Still require validation.

---

# END CHANGE IMPACT MATRIX

==================================================
FILE: _governance/RECOVERY_PLAYBOOK.md
======================================

# LEGAiSEE — RECOVERY PLAYBOOK

### Failure Recovery Procedures

### Last Updated: 2026-05-19

---

# PURPOSE

Defines recovery procedures when:

* AI breaks architecture
* routing fails
* CSS drifts
* APIs fail
* modules stop rendering

---

# GENERAL RECOVERY PROCESS

1. STOP editing
2. Identify changed files
3. Restore known-good versions
4. Revalidate architecture
5. Re-test routing
6. Re-test affected modules

---

# KNOWN FAILURE PATTERNS

---

## Failure Pattern:

Standalone utility page created.

### Why Dangerous:

Breaks module architecture consistency.

### Recovery:

* convert into module or api endpoint
* register module correctly
* remove standalone

---

## Failure Pattern:

Inline CSS added.

### Why Dangerous:

Creates styling fragmentation.

### Recovery:

* move CSS into global.css
* remove style tags
* validate theme consistency

---

## Failure Pattern:

AJAX routed through shell.php.

### Why Dangerous:

ob_start() buffering corrupts JSON.

### Recovery:

* move logic into api/
* return proper JSON response
* update JS endpoint

---

## Failure Pattern:

AI performed unrelated refactor.

### Why Dangerous:

Creates hidden regressions.

### Recovery:

* rollback unrelated edits
* isolate intended changes only

---

# ROUTING FAILURE RECOVERY

Symptoms:

* modules not loading
* blank pages
* routing loops

Check:

* shell.php
* module_registry.php
* module file names
* query param handling

---

# CSS FAILURE RECOVERY

Symptoms:

* broken layout
* missing styles
* inconsistent theme

Check:

* global.css
* inline styles
* duplicated CSS systems

---

# DATABASE FAILURE RECOVERY

Symptoms:

* DB connection errors
* missing queries
* context failures

Check:

* kernel_db()
* context filters
* SQL changes
* credentials

---

# END RECOVERY PLAYBOOK

==================================================
FILE: _governance/DEPLOYMENT_CHECKLIST.md
=========================================

# LEGAiSEE — DEPLOYMENT CHECKLIST

### Mandatory Pre-Live Verification

### Last Updated: 2026-05-19

---

# BEFORE EDITING

* [ ] backup affected files
* [ ] review BUILD_SPEC
* [ ] confirm allowed file list
* [ ] confirm rollback plan
* [ ] verify architecture scope

---

# BEFORE SAVING LIVE

* [ ] syntax reviewed
* [ ] no inline CSS added
* [ ] no standalone pages created
* [ ] no unrelated files modified
* [ ] API endpoints validated
* [ ] module registration validated

---

# AFTER DEPLOYMENT

* [ ] shell.php loads
* [ ] Grand Lobby works
* [ ] affected module loads
* [ ] no fatal PHP errors
* [ ] browser console clean
* [ ] AJAX working
* [ ] layout intact

---

# POST-DEPLOYMENT

* [ ] DAILY_STATE updated
* [ ] BUILD_HISTORY updated
* [ ] SESSION_HANDOFF updated
* [ ] validation checklist completed

---

# END DEPLOYMENT CHECKLIST

==================================================
FILE: _governance/MODULE_INDEX.md
=================================

# LEGAiSEE — MODULE INDEX

### System Module Inventory

### Last Updated: 2026-05-19

---

# intelligence_dashboard

File:

```text id="djlwm1"
modules/intelligence_dashboard_module.php
```

Purpose:
System-wide intelligence overview.

Status:
Working

Dependencies:

* module_registry.php
* global.css

---

# search

File:

```text id="kjlwm2"
modules/search_module.php
```

Purpose:
3-column search and compare system.

Dependencies:

* api/search_load.php
* global.css

Known Risks:

* compare pane JS fragility

Status:
Working

---

# ingest

File:

```text id="mjlwm3"
modules/ingest_module.php
```

Purpose:
AI transcript ingestion and upload system.

Dependencies:

* database
* memory tables
* future embedding pipeline

Status:
Working

---

# files

File:

```text id="pjlwm4"
modules/files_module.php
```

Purpose:
File manager and CRUD system.

Dependencies:

* api/files_action.php
* data storage

Status:
Working

---

# excavation

File:

```text id="tjlwm5"
modules/excavation_module.php
```

Purpose:
Business archaeology pipeline.

Status:
Partial

Known Issues:

* metadata rendering incomplete

---

# report

File:

```text id="xjlwm6"
modules/report_module.php
```

Purpose:
Authority report assembly.

Status:
Connected but incomplete

Dependencies:

* review_flags
* confirmed findings

---

# END MODULE INDEX

==================================================
FILE: _governance/BUILD_HISTORY.md
==================================

# LEGAiSEE — BUILD HISTORY

### Historical Build Record

### Last Updated: 2026-05-19

---

# PURPOSE

Tracks:

* builds
* regressions
* successful patterns
* failures
* AI behavior

---

# BUILD ENTRIES

---

## 2026-05-19

### Build:

Governance architecture creation.

### Systems Added:

* BUILD_SPEC
* VALIDATION_CHECKLIST
* DAILY_STATE
* CURRENT_OBJECTIVE
* ACTIVE_TASK_QUEUE
* SESSION_HANDOFF

### Result:

Successful

### Risks Identified:

* governance complexity overhead

### Notes:

Established Claude governance / Windsurf execution model.

---

# FUTURE ENTRIES

Add:

* build date
* feature
* files changed
* AI used
* success/failure
* rollback needed?
* lessons learned

---

# END BUILD HISTORY

==================================================
FILE: _governance/DRIFT_PATTERNS.md
===================================

# LEGAiSEE — DRIFT PATTERNS

### Architecture Drift Detection Rules

### Last Updated: 2026-05-19

---

# PURPOSE

Teaches AI systems how architectural decay appears over time.

AI systems must detect and prevent these patterns.

---

# DRIFT PATTERNS

---

## Pattern:

Standalone helper pages

### Risk:

Routing fragmentation

### Detection:

Random .php pages outside module architecture.

### Correction:

Convert to module or api endpoint.

---

## Pattern:

Inline CSS

### Risk:

Visual inconsistency and stylesheet fragmentation.

### Detection:

<style> tags or style attributes in modules.

### Correction:
Move styles into global.css.

---

## Pattern:
Mixed API/UI logic

### Risk:
Maintenance complexity and broken JSON.

### Detection:
AJAX logic inside modules or shell.php.

### Correction:
Move into api/ endpoint.

---

## Pattern:
Utility sprawl

### Risk:
Unstructured architecture growth.

### Detection:
Random helper files with overlapping purposes.

### Correction:
Consolidate intentionally.

---

## Pattern:
Framework creep

### Risk:
Architectural incompatibility.

### Detection:
React/Vue/Laravel/Tailwind introductions.

### Correction:
Remove unless explicitly approved.

---

## Pattern:
Hidden refactors

### Risk:
Regression and unpredictable behavior.

### Detection:
Large unrelated code changes.

### Correction:
Rollback unrelated modifications.

---

## Pattern:
Terminology drift

### Risk:
Loss of conceptual consistency.

### Detection:
Renamed LEGAiSEE concepts.

### Correction:
Restore canonical terminology.

---

# END DRIFT PATTERNS



==================================================
FILE: _governance/SAFE_EXECUTION_PROMPT.md
==================================================

# LEGAiSEE — SAFE EXECUTION PROMPT
### Reusable AI Execution Wrapper
### Last Updated: 2026-05-19

---

Read:
- MASTER_SYSTEM_BIBLE.md
- ARCHITECTURE_LOCK.md
- CURRENT_OBJECTIVE.md
- BUILD_SPEC.md
- VALIDATION_CHECKLIST.md
- PROTECTED_FILES.md
- DRIFT_PATTERNS.md

You are operating in STRICT EXECUTION MODE.

Your role:
- implementation worker only
- preserve architecture
- avoid drift
- obey scope exactly

Modify ONLY approved files.

DO NOT:
- create standalone pages
- add inline CSS
- refactor unrelated systems
- introduce frameworks
- modify protected files
- reorganize architecture

Before editing:
1. summarize objective
2. summarize architecture constraints
3. list files to modify
4. list risks
5. wait for approval

After editing:
1. list modified files
2. explain changes
3. complete validation review
4. identify possible regressions
5. confirm no drift introduced

If uncertain:
STOP and ask questions.

---

# END SAFE EXECUTION PROMPT
