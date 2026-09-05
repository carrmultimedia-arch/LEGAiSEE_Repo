LEGAiSEE — MASTER PREFACE / PROJECT BOOTSTRAP
PURPOSE OF THIS DOCUMENT
This document is the persistent bootstrap context for LEGAiSEE.
It exists so a new Claude conversation can understand the current state, objective, methodology, and rules of the LEGAiSEE recovery/completion project without requiring the entire historical conversation to be carried forward.
This document is not the complete project documentation.
It is the starting point and controlling context for each new Claude work session.
Claude should read this document first, then consult the appropriate current audit, state, task, code, and documentation files needed for the specific task at hand.

1. THE OBJECTIVE
LEGAiSEE already has a substantial amount of code, systems, modules, engines, interfaces, experiments, prototypes, and partially completed functionality.
The immediate objective is NOT to redesign LEGAiSEE from scratch.
The immediate objective is to determine, with evidence, what LEGAiSEE actually is today.
We need to establish the first genuinely complete view of the system that was built, started, abandoned, disconnected, duplicated, broken, unfinished, or otherwise left behind.
Only after that understanding exists should we decide what the final LEGAiSEE system should become.

2. THE RECOVERY / COMPLETION SEQUENCE
The project proceeds through these major stages.
STAGE 1 — COMPLETE THE SYSTEM ARCHAEOLOGY
We have an extensive audit already underway.
The audit is not simply asking:
"Does this PHP file execute?"
It asks:
What does this file/system actually do?
Is it connected to anything?
What data does it use?
What other systems depend on it?
Does another system duplicate its functionality?
Is it working?
Is it partially working?
Is it broken?
Is it orphaned?
Is it unfinished?
Is it potentially valuable despite being disconnected?
Can it be restored?
Does it belong to the eventual LEGAiSEE system?
Continue the audit until we have sufficient knowledge of the entire codebase to make informed decisions.
Do not prematurely delete, redesign, replace, or rebuild systems during archaeology.

3. STAGE 2 — TRIAGE WHAT WE FOUND
Once sufficient archaeology has been completed, classify the discovered systems and files.
Possible classifications include:
KEEP
Working or valuable systems that belong in LEGAiSEE.
RESTORE
Systems that appear fundamentally sound but have become disconnected, broken, or unusable.
FIX
Systems that are useful but contain identifiable defects.
FINISH
Systems that are substantially built but incomplete.
INTEGRATE
Systems that work independently but need to be connected to the rest of LEGAiSEE.
REPLACE
Systems whose purpose is valid but whose implementation is inferior or conflicting with another implementation.
DEFER
Potentially useful systems that should not be addressed yet.
DELETE
Only genuinely disposable material.
DELETE is a conclusion reached from evidence, not a default consequence of being orphaned.
An orphaned system may contain valuable unfinished functionality.

4. STAGE 3 — DOCUMENT THE ACTUAL LEGAiSEE SYSTEM
After archaeology and triage, create the first comprehensive description of the system that actually exists.
Document the system in logical major and minor sections.
The eventual terminology for these sections — modules, wings, systems, engines, domains, etc. — should emerge from understanding the actual code rather than being imposed prematurely.
This documentation should establish:
what each system does
what data it works with
what its inputs are
what its outputs are
what it depends upon
what depends upon it
how it connects to other systems
whether it is active, dormant, broken, incomplete, or obsolete
This becomes the factual foundation for the next stage.

5. STAGE 4 — CREATE THE COMPLETE SYSTEM MAP / SITE MAP
Once the actual system is understood, determine how it should be organized for human use.
This includes determining:
major system sections
modules
submodules
dashboards
standalone views
combined views
navigation
relationships between systems
which functionality deserves its own PHP/view
which functionality belongs together on a labeled dashboard
how the user moves through LEGAiSEE
The order of LEGAiSEE business execution to put the system together in a Pipeline order
Do not design the final UI before this system map is understood.
The site map should emerge from the actual capabilities and relationships discovered during archaeology.

6. STAGE 5 — RECOVER, FIX, FINISH, AND WIRE THE SYSTEM
Only after the system has been sufficiently mapped should implementation recovery begin.
The objective is to make the discovered LEGAiSEE functionality actually work together.
This includes:
fixing broken functionality
restoring disconnected functionality
completing unfinished functionality
connecting orphaned-but-valuable systems
resolving duplicate/conflicting implementations
fixing data flow
fixing routing
fixing rendering
fixing backend/frontend connections
testing real functionality
Temporary ugly test pages are explicitly acceptable.
If a simple Test Page.php is the fastest and safest way to prove that a system works, create one.
The test page is a diagnostic tool, not the final UI.
Do not spend time making test pages attractive.
The priority is:
Does the underlying system actually work?

7. STAGE 6 — BUILD THE FINAL LEGAiSEE OS / UI
Only after the underlying system has been recovered, connected, and functionally tested should the final user interface be built/refined.
The final UI should make the recovered system:
understandable
navigable
usable
visually coherent
efficient
appropriate for John as the actual user
The UI is the final presentation layer.
It should not be used to hide unresolved architectural or functional problems underneath it.

8. DOCUMENT THE ENTIRE PROCESS
The recovery process itself must be documented.
Documentation should capture:
what was discovered
what was retained
what was restored
what was fixed
what was completed
what was integrated
what was replaced
what was deferred
what was deleted
why significant decisions were made
how systems connect
how the finished LEGAiSEE system works
Do not create an enormous documentation "Bible" prematurely.
Start with a Master Table of Contents / roadmap.
Expand the chapters as the actual system becomes understood.

9. NON-NEGOTIABLE WORKING RULES
DO NOT REDESIGN THE SYSTEM PREMATURELY
The existing codebase contains potentially valuable work that may currently be disconnected.
Do not assume that a cleaner-looking new implementation is better than recovering an existing one.

DO NOT DELETE BASED ON ORPHAN STATUS ALONE
"Orphaned" means disconnected.
It does not automatically mean useless.
An orphaned system may contain valuable functionality that should be restored.

DO NOT REBUILD SOMETHING BEFORE DETERMINING WHETHER IT ALREADY EXISTS
Before creating a new implementation, search the existing codebase for:
duplicate functionality
alternate implementations
prototypes
abandoned implementations
engines
renderers
APIs
helper classes
existing data structures
This is especially important because the audit has already discovered examples where valuable functionality exists but is disconnected.

PRESERVE DISCOVERIES
When something potentially important is discovered, document it before modifying or removing it.

FOLLOW THE EVIDENCE
Do not assume what a system is supposed to do based solely on filenames.
Read the code and follow its actual behavior and connections.

WORK IN BOUNDED TASKS
Do not attempt to execute the entire LEGAiSEE recovery project in a single conversation.
Each Claude session should have a clearly defined current objective.
Finish that objective, document the result, update the project state, and leave a clean continuation point.

10. CURRENT AUDIT STATUS
The LEGAiSEE codebase contains approximately 1,243 files.
Approximately 185 files (~15%) have been fully or partially covered by the audit.
Approximately 1,058 files remain to be opened.
The audit distinguishes between:
fully read/audited files
connectivity-checked files
files whose contents have not yet been examined
This distinction is important.
"Connectivity checked" does NOT mean "fully understood."

11. COMPLETED AUDIT AREAS
The following areas have already been audited to varying degrees:
Sidebar — Graph & Entities
7 files.
Finding:
Network Graph shows counts only; real graph data exists but is unwired.
Sidebar — Excavation
6 files.
Finding:
Ingest file-upload has a confirmed silent-failure bug.
Sidebar — Intelligence Engines
7 files.
Findings include:
Insight is a mis-wired Ingest duplicate.
Predictive Link V1 output is destroyed by the renderer.
Sidebar — Command
5 files.
Finding:
uic_v1.php is a good renderer but is barely used.
Planning, Clients & Cases, Tools + Sidebar Summary
Approximately 12 files.
Finding:
Compare module is a stub while the real compare_engine.php is orphaned.
engine/
Approximately 36–37 files.
Important discovery:
plain_english_helper.php appears to be a ready-built unused fix.
More importantly:
15 orphaned engine files appear to form a real unfinished autonomous-agent pipeline.
This discovery is particularly important.
Do not dismiss those files merely because they are orphaned.
api.php / api/v8/
Approximately 30 files connectivity-checked.
Finding:
Entirely unreachable; api.php has zero callers.
cli/
9 files connectivity-checked.
Finding:
Only reachable through an orphaned index.php prototype.
Top-level index.php
Read and live-tested.
Finding:
Separate abandoned prototype that remains directly reachable by exact URL.
ExcavationCommand/
3 files connectivity-checked.
Finding:
Zero references anywhere; fully orphaned.
ProjectManager/
88 files.
External connectivity has been confirmed dead from the main shell/modules.
The internal contents have not yet been read.
Therefore the internal state of ProjectManager remains unknown.

12. OTHER PARTIALLY AUDITED AREAS
kernel/
21 files.
High priority.
This is foundational plumbing involving areas such as:
database connection
bootstrap
module registry
It is especially important because it is already associated with the SQLite/MySQL migration problem.
Top-level standalone PHP files
51 files.
Known mixture of:
load-bearing files
test/debug clutter
unknown-purpose systems
Examples of potentially important unknowns include:
ai_process.php
dossier_v2.php
intelligence.php
mission.php
response.php
indexer.php
parser.php
semantic_engine.php
excavation_engine.php
cluster_engine.php
Some may represent top-level duplicates of functionality also found under engine/.
This should be investigated rather than assumed.
ui/
19 files.
This is the rendering layer and includes the already discovered orphaned compare_engine.php.
Top-level api/
Approximately 45 files remain unread.
Only search_load.php and files_action.php have so far been confirmed live.
components/
6 files.
Not yet examined.
database/
2 files.
Not yet examined.
_backup/
1 file.
Likely historical/low priority, but not yet formally closed.

13. CURRENT AUDIT PRIORITY
Unless new evidence changes the priority, continue in this general order, unless these are already done:
kernel/
Top-level standalone PHP files
ui/
Top-level api/
ProjectManager/ internals
components/
database/
_backup/
This order is a starting point, not an immutable command.
If audit evidence reveals that another area is higher leverage, document the reason before changing priority.

14. SESSION START PROTOCOL
At the beginning of a new Claude conversation:
Step 1
Read this Preface.
Step 2
Read the current project state / continuation document.
Step 3
Determine the current project phase and current bounded task.
Step 4
Read only the relevant audit/documentation/code required for that task.
Step 5
Work on that task.
Step 6
Do not unnecessarily reconstruct the entire historical conversation.
Step 7
At the end of the session, update:
completed work
discoveries
decisions
unresolved issues
next task
relevant documentation
audit counts/status
The next Claude session should be able to continue from those artifacts without needing the previous conversation.

15. SESSION COMPLETION PROTOCOL
Every significant work session should leave behind a concise continuation record containing:
SESSION DATE:

CURRENT PHASE:

TASK:

WHAT WAS EXAMINED:

WHAT WAS DISCOVERED:

WHAT WAS CHANGED:

WHAT WAS NOT CHANGED:

DECISIONS MADE:

SYSTEMS AFFECTED:

DOCUMENTATION CREATED/UPDATED:

TESTS PERFORMED:

KNOWN PROBLEMS:

QUESTIONS REQUIRING FUTURE DECISION:

NEXT RECOMMENDED TASK:
This record is more important than preserving the entire conversation.

16. MASTER TO-DO / DOCUMENTATION TOC
This is intentionally a living structure.
Do not fill in chapters merely for the sake of filling them.
PART I — SYSTEM ARCHAEOLOGY
Complete Codebase Audit
System Inventory
Connectivity Map
Orphaned Systems
Duplicate / Conflicting Systems
Existing Engines
Existing Renderers
Existing APIs
Existing Data Structures
PART II — SYSTEM TRIAGE
KEEP
RESTORE
FIX
FINISH
INTEGRATE
REPLACE
DEFER
DELETE
PART III — THE ACTUAL LEGAiSEE SYSTEM
Core / Kernel
Excavation
Intelligence
Graph / Entities
Command
Planning
Clients / Cases
Tools
Project Manager
APIs
Other Discovered Systems
PART IV — SYSTEM MAP
System Relationships
Data Flow
Module Relationships
Navigation
Views
Dashboards
Site Map
PART V — SYSTEM RECOVERY
Broken Systems
Disconnected Systems
Incomplete Systems
Integration
Functional Testing
Temporary Test Pages
PART VI — FINAL LEGAiSEE OS / UI
Final Information Architecture
Navigation
Dashboard
Module Views
User Experience
Visual Design
PART VII — FINAL DOCUMENTATION
Final System Overview
System Map
Technical Documentation
Functional Documentation
User Documentation
Maintenance / Continuation Documentation
This TOC is allowed to change as the actual system is discovered.

17. DEFINITION OF SUCCESS
The project is not successful merely because:
the PHP executes
pages load
errors disappear
the UI looks good
individual modules work in isolation
The eventual objective is a coherent, functioning LEGAiSEE system in which the valuable functionality that already exists has been identified, preserved where appropriate, repaired/restored where appropriate, completed where appropriate, connected where appropriate, and presented through a usable final interface.
The final system should reflect what has actually been discovered and validated rather than an imagined architecture imposed before the archaeology is complete.

18. MOST IMPORTANT INSTRUCTION TO CLAUDE
Do not try to finish LEGAiSEE in this conversation.
Your job is to advance the project from its current documented state to the next verified state.
Preserve what you learn.
Document what you change.
Do not make the next Claude session depend upon the memory of this Claude session.
The project files and documentation are the persistent memory.
The conversation is temporary.

CURRENT PROJECT POSITION
We are currently in SYSTEM ARCHAEOLOGY / AUDIT.
The next major priority is:
Continue completing the audit, beginning with kernel/, unless the current project state specifies a newer task.
Do not jump to final UI design.
Do not prematurely delete orphaned systems.
Do not redesign LEGAiSEE.
First determine what LEGAiSEE actually contains.
Then decide what survives.
Then map it.
Then recover it.
Then make it usable.



Why I would use this version
This is deliberately not much longer than your original Preface, despite adding the operating rules. The important difference is that it separates project knowledge from instructions about how Claude should work.
That matters for the exact problem you're trying to solve.
Your original document tells Claude:
Here is what we've discovered and what we intend to do.
This version additionally tells Claude:
Here is how you are supposed to behave when you enter a fresh context.
I would save this as something like:
LEGAiSEE_MASTER_PREFACE.md
Then separately maintain:
LEGAiSEE_CURRENT_STATE.md
and eventually:
LEGAiSEE_MASTER_TOC.md
That gives you a small permanent bootstrap + changing state + bounded task, rather than repeatedly feeding Claude the entire historical conversation.
And I would not put all ~1,243 files, all audit reports, or the entire original chat into the Preface. Claude can retrieve/read those only when the current task requires them. That is the part that will give you the biggest context-efficiency benefit.

