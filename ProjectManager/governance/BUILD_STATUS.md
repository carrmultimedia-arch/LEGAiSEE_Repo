PROJECT: LEGAiSEE Project Manager
STATUS: Architecture Complete
PHASE: EXECUTION
VERSION: v1.0

======================================================================
PROJECT PURPOSE
======================================================================

We are building a standalone Project Manager application for LEGAiSEE.

This is NOT a module.

This is NOT an extension of shell.php.

This is a complete application located at:

/www/www/commandcenter/ProjectManager/

The application will integrate with LEGAiSEE's existing systems (Kernel, Authentication, Clients, Cases, Intelligence, Graph, Search, Reports, Memory Ingest, etc.) but will remain its own application.

The goal is to build a professional project management system comparable to Notion, Asana, Monday, ClickUp or Jira while using LEGAiSEE intelligence as enhancements—not replacements—for normal project management workflows.

======================================================================
ARCHITECTURE STATUS
======================================================================

Architecture is COMPLETE.

Folder structure is COMPLETE.

Bible structure is COMPLETE.

Governance system is COMPLETE.

No additional folders or architecture changes are permitted unless explicitly authorized by the project owner.

======================================================================
PROJECT LOCATION
======================================================================

/www/www/commandcenter/ProjectManager/

Current top-level structure is frozen.

governance/
app/
api/
assets/
database/
storage/
tests/
vendor/

bootstrap.php
config.php
permissions.php
router.php
index.php
README.md

======================================================================
GOVERNANCE LOCATION
======================================================================

/governance/

Contains:

PROJECT_MANAGER_BIBLE/

BUILD_STATUS.md

CHANGELOG.md

CURRENT_BUILD_TARGET.md

TODO.md

PROJECT_MANAGER.code-workspace

======================================================================
PROJECT BIBLE
======================================================================

All Bible placeholder files already exist.

They will be completed in order.

Every chapter becomes LOCKED after approval.

Locked chapters are immutable.

They may NEVER be rewritten unless the project owner explicitly authorizes a revision.

======================================================================
BUILD METHODOLOGY
======================================================================

Every batch follows exactly this sequence.

1.
Write MD

2.
Approve

3.
LOCK chapter

4.
Generate ALL owned code

5.
Generate database objects if required

6.
Generate API if required

7.
Generate tests

8.
Acceptance test

9.
Update BUILD_STATUS.md

10.
Update CURRENT_BUILD_TARGET.md

11.
Proceed to next batch

There are NO exceptions.

======================================================================
AI BUILD RULES
======================================================================

The AI may NOT:

• redesign previous chapters

• add folders

• invent new architecture

• create files not authorized by the Canonical File Registry

• postpone coding

• leave TODO code

• use placeholders when production code can be generated

• rewrite approved chapters

If improvements are discovered they go into TODO.md for Version 2.

======================================================================
EVERY CHAPTER MUST END WITH
======================================================================

FILES CREATED

FILES MODIFIED

DATABASE TABLES

API ENDPOINTS

DEPENDENCIES

TESTS REQUIRED

NEXT BUILD TARGET

======================================================================
BATCH SIZE
======================================================================

Build in small batches.

Normally

3–5 Bible chapters

↓

Immediately create all owned production code

↓

Run tests

↓

Continue

======================================================================
CURRENT BUILD TARGET
======================================================================

Batch 1

0000_PROJECT_MANAGER_MANIFEST.md

0005_PROJECT_GOVERNANCE.md

0010_DESIGN_PRINCIPLES.md

Immediately after those three chapters are approved:

Generate every owned production file.

No additional design work.

======================================================================
END GOAL
======================================================================

When Chapter 0999 is complete the Project Manager will be a production-ready standalone application fully integrated with LEGAiSEE.

The build should be reproducible solely from the Project Bible.

No undocumented code.

No undocumented files.

No undocumented database objects.

Everything must trace back to a Bible chapter.

Execution begins immediately with Batch 1.



======================================================================================

