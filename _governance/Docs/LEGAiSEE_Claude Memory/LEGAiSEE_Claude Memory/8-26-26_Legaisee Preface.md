8-26-26_Legaisee Preface
Summary
LEGAiSEE Master Preface — the rules for how any Claude session works on the recovery project. Rarely changes. Read this FIRST, before legaisee-current-state.md, before anything else.
Details
Source: John's own Google Doc bootstrap (published, last updated 2026-08-24) — adopted verbatim as the canonical process rules going forward, replacing the ad-hoc file structure Claude had drifted into (a growing append-only legaisee-recovery-roadmap log, a separate legaisee-audit-checklist, and a legaisee-work-orders file that jumped ahead of formal triage — all three now deprecated as entry points, see their own files for redirect notes).
Read in this order: (1) this Preface, (2) legaisee-current-state — where the project actually stands, changes every session, (3) legaisee-master-toc — the living documentation skeleton, (4) only then the specific audit/code/documentation files the current bounded task actually needs.
THE OBJECTIVE
LEGAiSEE already has a substantial amount of code, systems, modules, engines, interfaces, experiments, prototypes, and partially completed functionality. The objective is not to redesign LEGAiSEE from scratch. The objective is to determine, with evidence, what LEGAiSEE actually is today — what was built, started, abandoned, disconnected, duplicated, broken, unfinished, or otherwise left behind — and only then decide what the final system should become.
THE RECOVERY / COMPLETION SEQUENCE
STAGE 1 — SYSTEM ARCHAEOLOGY. Not "does this file execute" but: what does it do, is it connected, what depends on it, is it duplicated elsewhere, is it working/broken/orphaned/unfinished, is it potentially valuable despite being disconnected, does it belong in the eventual system. Do not prematurely delete, redesign, replace, or rebuild during archaeology.
STAGE 2 — TRIAGE. Classify each discovered system/cluster: KEEP (working/valuable, belongs as-is) / RESTORE (sound but disconnected/broken/unusable) / FIX (useful but has identifiable defects) / FINISH (substantially built but incomplete) / INTEGRATE (works independently, needs connecting) / REPLACE (valid purpose, inferior/conflicting implementation) / DEFER (potentially useful, not addressed yet) / DELETE (only genuinely disposable material — a conclusion from evidence, never a default consequence of being orphaned).
STAGE 3 — DOCUMENT THE ACTUAL SYSTEM. After archaeology and triage, write the first comprehensive description of what actually exists: what each system does, its inputs/outputs/dependencies, what depends on it, its connections, and its status. Terminology should emerge from the code, not be imposed prematurely.
STAGE 4 — SYSTEM MAP / SITE MAP. Once the actual system is understood, determine how it should be organized for human use. Do not design final UI before this map exists.
STAGE 5 — RECOVER, FIX, FINISH, WIRE. Make the discovered functionality actually work together. Ugly temporary test pages are explicitly fine here — the priority is proving the underlying system works, not making the test page attractive.
STAGE 6 — FINAL OS / UI. Only after the underlying system is recovered, connected, and functionally tested does the final interface get built. The UI must never be used to hide unresolved architectural problems underneath it.
NON-NEGOTIABLE WORKING RULES
Do not redesign prematurely. A cleaner-looking new implementation is not automatically better than recovering an existing one.
Do not delete based on orphan status alone. Orphaned means disconnected, not useless.
Do not rebuild before checking whether it already exists — confirmed real risk in this codebase: the same concept has been independently rebuilt from scratch in multiple locations more than once.
Preserve discoveries. Document something potentially important before modifying or removing it.
Follow the evidence. Don't assume what a system does from its filename — read the code and its actual connections.
Work in bounded tasks. One clearly defined objective per session; finish it, document the result, update project state, leave a clean continuation point.
SESSION START PROTOCOL
Read this Preface. 2. Read legaisee-current-state. 3. Determine the current phase and the bounded task for this session. 4. Read only the audit/documentation/code files that task actually requires. 5. Do the work. 6. Do not reconstruct the entire historical conversation from memory. 7. At session end, update legaisee-current-state (and legaisee-master-toc if a new document was produced) with: completed work, discoveries, decisions, unresolved issues, next task.
DEFINITION OF SUCCESS
Not merely that the PHP executes, pages load, errors disappear, or individual modules work in isolation. Success is a coherent, functioning LEGAiSEE system where the valuable existing functionality has been identified, preserved/repaired/restored/completed/connected where appropriate, and presented through a usable final interface reflecting what was actually discovered and validated — not an architecture imagined before the archaeology was done.
MOST IMPORTANT INSTRUCTION
Do not try to finish LEGAiSEE in one conversation. The job each session is to advance the project from its current documented state to the next verified state. Preserve what you learn. Document what you change. The project files are the persistent memory; the conversation is temporary.

