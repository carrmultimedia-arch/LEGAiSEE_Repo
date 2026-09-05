LEGAiSEE — MASTER PREFACE / PROJECT BOOTSTRAP
PURPOSE OF THIS DOCUMENT
This document is the persistent bootstrap context for LEGAiSEE. It exists so a new Claude conversation can understand the objective, methodology, and working rules of the LEGAiSEE recovery/completion project without requiring the entire historical conversation to be carried forward.
This document is not the complete project documentation. It is the starting point and controlling context for each new Claude work session.
Read in this order:
This Preface (rules — rarely changes)
LEGAiSEE_CURRENT_STATE.md (where the project actually stands — changes every session)
LEGAiSEE_MASTER_TOC.md (the living documentation skeleton)
Only then, the specific audit/code/documentation files needed for the current bounded task

1. THE OBJECTIVE
LEGAiSEE already has a substantial amount of code, systems, modules, engines, interfaces, experiments, prototypes, and partially completed functionality. The objective is not to redesign LEGAiSEE from scratch. The objective is to determine, with evidence, what LEGAiSEE actually is today — what was built, started, abandoned, disconnected, duplicated, broken, unfinished, or otherwise left behind — and only then decide what the final system should become.
2. THE RECOVERY / COMPLETION SEQUENCE
STAGE 1 — SYSTEM ARCHAEOLOGY. Not "does this file execute" but: what does it do, is it connected, what depends on it, is it duplicated elsewhere, is it working/broken/orphaned/unfinished, is it potentially valuable despite being disconnected, does it belong in the eventual system. Do not prematurely delete, redesign, replace, or rebuild during archaeology.
STAGE 2 — TRIAGE. Classify each discovered system/cluster:
KEEP — working or valuable, belongs as-is
RESTORE — sound but disconnected/broken/unusable
FIX — useful but has identifiable defects
FINISH — substantially built but incomplete
INTEGRATE — works independently, needs connecting
REPLACE — valid purpose, inferior/conflicting implementation
DEFER — potentially useful, not addressed yet
DELETE — only genuinely disposable material; a conclusion from evidence, never a default consequence of being orphaned
STAGE 3 — DOCUMENT THE ACTUAL SYSTEM. After archaeology and triage, write the first comprehensive description of what actually exists: what each system does, its inputs/outputs/dependencies, what depends on it, its connections, and its status. Terminology (modules/wings/systems/engines/domains) should emerge from the code, not be imposed prematurely.
STAGE 4 — SYSTEM MAP / SITE MAP. Once the actual system is understood, determine how it should be organized for human use — sections, modules, dashboards, navigation, pipeline order. Do not design final UI before this map exists.
STAGE 5 — RECOVER, FIX, FINISH, WIRE. Make the discovered functionality actually work together: fix broken pieces, restore disconnected ones, complete unfinished ones, connect orphaned-but-valuable ones, resolve duplicates, fix data flow/routing/rendering. Ugly temporary test pages are explicitly fine here — the priority is proving the underlying system works, not making the test page attractive.
STAGE 6 — FINAL OS / UI. Only after the underlying system is recovered, connected, and functionally tested does the final interface get built. It should make the recovered system understandable, navigable, usable, coherent, and appropriate for John as the actual user. The UI must never be used to hide unresolved architectural problems underneath it.
3. DOCUMENT THE ENTIRE PROCESS
Capture what was discovered, retained, restored, fixed, completed, integrated, replaced, deferred, deleted, and why — plus how systems connect and how the finished system works. Do not build an enormous documentation "Bible" prematurely; start with a Master TOC and expand chapters as the system becomes understood.
4. NON-NEGOTIABLE WORKING RULES
Do not redesign prematurely. A cleaner-looking new implementation is not automatically better than recovering an existing one.
Do not delete based on orphan status alone. Orphaned means disconnected, not useless. An orphaned system may contain valuable functionality worth restoring.
Do not rebuild before checking whether it already exists. Before creating new implementations, search for duplicate functionality, alternate implementations, prototypes, abandoned attempts, engines, renderers, APIs, helper classes, existing data structures. Confirmed real risk in this codebase: the same concept has been independently rebuilt from scratch in multiple locations more than once.
Preserve discoveries. Document something potentially important before modifying or removing it.
Follow the evidence. Don't assume what a system does from its filename — read the code and its actual connections.
Work in bounded tasks. Do not attempt to execute the entire recovery project in a single conversation. Each session has one clearly defined objective; finish it, document the result, update project state, leave a clean continuation point.
5. SESSION START PROTOCOL
Read this Preface.
Read LEGAiSEE_CURRENT_STATE.md.
Determine the current phase and the bounded task for this session.
Read only the audit/documentation/code files that task actually requires.
Do the work.
Do not reconstruct the entire historical conversation from memory.
At session end, update: completed work, discoveries, decisions, unresolved issues, next task, relevant documentation, audit/triage status — in LEGAiSEE_CURRENT_STATE.md and the audit checklist.
The next session should be able to continue from those files without needing this conversation.
6. SESSION COMPLETION RECORD
Every significant session should leave behind:
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

This record matters more than preserving the conversation itself.
7. DEFINITION OF SUCCESS
Not merely that the PHP executes, pages load, errors disappear, the UI looks good, or individual modules work in isolation. Success is a coherent, functioning LEGAiSEE system where the valuable existing functionality has been identified, preserved where appropriate, repaired/restored where appropriate, completed where appropriate, connected where appropriate, and presented through a usable final interface — reflecting what was actually discovered and validated, not an architecture imagined before the archaeology was done.
8. MOST IMPORTANT INSTRUCTION TO CLAUDE
Do not try to finish LEGAiSEE in one conversation. The job each session is to advance the project from its current documented state to the next verified state. Preserve what you learn. Document what you change. Do not make the next session depend on this session's memory — the project files are the persistent memory; the conversation is temporary.

