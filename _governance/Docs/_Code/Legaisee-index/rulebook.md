We’re going to stabilize this like a system kernel, not a collection of PHP files.

0. CORE DECISION (I AM MAKING THIS FOR YOU BASED ON EVIDENCE)
Your system already clearly shows:
MySQL is active (carrmulti_legaiseearchive)
v8 intelligence layer depends on relational data
graph + clusters + relations already exist in MySQL schema
So the correct choice is:
MySQL is the ONLY authority database. SQLite is dead context.
This is now locked as system truth going forward.

1. WHAT YOU ACTUALLY NEED (NOT MORE CODE, A LAW LAYER)
Right now your system fails because it has:
modules (execution units)
API (v8 intelligence units)
DB (truth store)
shell (UI wrapper)
data folders (file archaeology layer)
BUT NO RULEBOOK that defines how they interact.
So we are building this:
👉 “COMMAND CENTER LAW SPEC”
Think of it as a master table of contents + constitution + runtime contract
Not code-heavy. STRUCTURE-FIRST.

2. MASTER TOC (THIS BECOMES YOUR SYSTEM BIBLE)
This is the ONLY hierarchy your system should obey:

1. CORE AUTHORITY LAYER
Defines truth and execution rules
bootstrap.php (DB authority)
db connection (MySQL ONLY)
global config rules

2. RUNTIME SHELL LAYER
Defines how anything is executed
shell.php (ONLY entry point)
module loader
navigation truth menu
layout injection
RULE:
Nothing runs outside shell context

3. MODULE LAYER (UI + BUSINESS LOGIC)
All files in:
/modules/
Examples:
search_module.php
graph_module.php
files_module.php
RULE:
Modules NEVER define DB connection
 Modules NEVER run standalone
They only:
receive $pdo
output HTML or JSON
no system assumptions

4. API INTELLIGENCE LAYER (v8)
Location:
/api/v8/
Purpose:
autonomous logic
graph reasoning
memory + prediction
RULE:
v8 NEVER touches UI directly
 v8 outputs structured data ONLY

5. DATA LAYER (TRUTH STORE)
MySQL tables:
page
page_content
clusters
page_relations
saved_views
RULE:
ONLY source of truth for structured intelligence

6. FILE ARCHAEOLOGY LAYER (SECONDARY MEMORY)
/normalized/
/data/
RULE:
Read-only or ingestion only
 NEVER treated as system truth

7. GRAPH + RELATIONSHIP LAYER
D3 graph system
cluster_module
relations_module
RULE:
Must derive ONLY from MySQL relationships

8. SYSTEM TEST + VALIDATION LAYER
This replaces your current broken “system test”
RULE:
Test must verify runtime execution, not file existence

3. EXECUTION LAW (THIS IS THE IMPORTANT PART)
This is your system constitution:
LAW 1 — SINGLE ENTRY POINT RULE
All requests must pass through shell.php

LAW 2 — SINGLE DB AUTHORITY RULE
Only bootstrap.php defines DB connection (MySQL)

LAW 3 — MODULE ISOLATION RULE
Modules cannot initialize environment state

LAW 4 — API IS HEADLESS RULE
v8 produces data, never UI

LAW 5 — NO DUAL TRUTH RULE
No system may reference SQLite and MySQL as parallel truths
(SQLite is now conceptually deprecated)

4. WHY THIS FIXES EVERYTHING (IMPORTANT)
Right now your system breaks because:
modules assume environment exists
environment sometimes doesn’t exist
DB assumptions differ per file
shell is inconsistent
API is unbounded
After this structure:
every file has a defined “legal behavior”
So instead of debugging chaos, you get:
deterministic execution
predictable module behavior
clean API boundaries
stable DB truth

5. WHAT YOU DO NEXT (ONLY THIS ORDER)
Do NOT touch v8 yet.
Do NOT rebuild UI yet.
Do NOT refactor modules yet.

STEP 1 — LOCK bootstrap.php (already done)
✔ MySQL is now authority

STEP 2 — FORCE SHELL ENTRY RULE
Everything must route through:
/commandcenter/shell.php
If it doesn’t → it is illegal execution path

STEP 3 — ADD THIS SINGLE REQUIREMENT TO ALL MODULES
At top of every module:
require_once __DIR__ . "/../bootstrap.php";
That is the only enforcement needed at module level.

STEP 4 — IGNORE SQLITE ENTIRELY
Do not reference:
legaisee.db
sqlite schema test results
They are historical artifacts only.

6. THE REAL SHIFT YOU JUST MADE
You stopped building:
a collection of PHP tools
And are now building:
a structured intelligence operating system
That requires:
law layer
execution contract
single truth authority

7. IF YOU WANT NEXT STEP
Next step is NOT coding.
It is:
I restructure your shell.php into a true runtime kernel (module router + navigation truth + execution validator)
That is what will make everything “snap into place” and stop drifting.
Just say:
 “build shell kernel”
and I’ll convert this into a stable operating system layer instead of a dashboard.

