Folder Ownership

This is the map we'll follow throughout the project.

ProjectManager/

├── governance/
│   ├── PROJECT_MANAGER_BIBLE/
│   ├── BUILD_STATUS.md
│   ├── CHANGELOG.md
│   ├── CURRENT_BUILD_TARGET.md
│   ├── TODO.md
│   └── PROJECT_MANAGER.code-workspace
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── repositories/
│   ├── services/
│   ├── middleware/
│   ├── helpers/
│   ├── interfaces/
│   ├── traits/
│   ├── events/
│   ├── jobs/
│   ├── components/
│   ├── partials/
│   └── views/
│
├── api/
├── assets/
├── database/
├── storage/
├── tests/
├── vendor/
│
├── bootstrap.php
├── config.php
├── permissions.php
├── router.php
├── index.php
└── README.md


What each batch will produce

Every batch will end with two deliverables:

Governance
PROJECT_MANAGER_BIBLE/

xxxx.md
Code

Everything owned by those chapters, placed directly into the correct folders.

Example:

0310_DATABASE_SCHEMA.md

↓

database/schema/

schema.sql

↓

database/migrations/

001_initial.sql

↓

app/models/

Project.php

↓

tests/

DatabaseSchemaTest.php

Nothing waits until the end.

Chat Rules

To avoid the problems from the last project, I suggest these standing rules:

No revising locked chapters unless you explicitly request it.
No inventing new folders.
No inventing new files unless authorized by the Canonical File Registry.
Every MD immediately generates its code.
Every batch updates BUILD_STATUS.md and CURRENT_BUILD_TARGET.md.
At approximately 85% of the conversation capacity, I will generate a complete 0999_SESSION_HANDOFF.md containing:
Current project status
Completed chapters
Generated code
Remaining build order
Open issues (if any)
Exact next starting point for the following chat

That way, a new conversation can resume with virtually no loss of context.

Recommendation

Yes—start a new chat now.

Use this as the opening prompt:

PROJECT MANAGER BUILD — EXECUTION MODE

We are building the LEGAiSEE Project Manager according to the frozen architecture in /commandcenter/ProjectManager/.

Rules:

Do not redesign the architecture.
Do not add folders or files outside the approved structure.
Build in batches using the workflow: MD → Lock → Code → Test → Update Status → Next Batch.
Each MD owns its code.
Previously approved chapters are immutable unless I explicitly request a revision.
At approximately 85% chat capacity, generate a complete 0999_SESSION_HANDOFF.md.

Start with Batch 1 (0000_PROJECT_MANAGER_MANIFEST.md, 0005_PROJECT_GOVERNANCE.md, 0010_DESIGN_PRINCIPLES.md) and immediately generate the code those chapters define.

From that point onward, we'll stay in execution mode until the Project Manager is complete.


