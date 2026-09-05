LEGAiSEE Sovereign Build Operations Manual
Purpose
This document is the operational control system for building, protecting, and scaling the LEGAiSEE platform.
This system exists to:
Prevent architecture drift
Prevent accidental system breakage
Prevent AI hallucinated rewrites
Create recoverable checkpoints
Maintain architectural continuity
Keep Claude as strategic overseer
Use Windsurf/GPT/Kimi as controlled execution workers
Maintain full sovereign ownership of the platform
This document is written for ZERO prior Git or Windsurf experience.

SECTION 1 — CORE BUILD PHILOSOPHY
LEGAiSEE Rules
These rules override all other instructions.
Rule 1 — Never Trust One AI Blindly
Claude remains:
Architect
Planner
Validator
Governance system
Drift detector
Other AIs are execution workers only.
Windsurf/GPT/Kimi:
DO NOT make architecture decisions
DO NOT redesign systems
DO NOT rename systems
DO NOT reorganize folders
DO NOT modernize code automatically
DO NOT optimize unless specifically ordered
They only:
Build exact requested features
Repair exact requested bugs
Follow build specifications exactly

Rule 2 — Never Work Without Recovery
Before EVERY work session:
Git commit
Git push
Verify backup exists
Verify live mirror exists
If recovery is impossible:
STOP.

Rule 3 — Never Edit Without Reading Governance Files
Before ANY coding:
Read:
07_MASTER_SYSTEM_BIBLE.txt
12_BUILD_SPEC.txt
13_ARCHITECTURE_LOCK.txt
14_PROTECTED_FILES.txt
16_DRIFT_PATTERNS.txt
10_VALIDATION_CHECKLIST.txt
If the requested change conflicts with these files:
STOP.
Escalate to Claude.

Rule 4 — No Partial Replacements
Never allow AI to:
Replace entire systems casually
Rewrite working modules
Refactor unrelated code
Reorganize folders
“Improve structure” without authorization
Only modify:
Exact target files
Exact target functions
Exact target behavior

Rule 5 — Every Session Must Produce Recovery Points
At minimum:
Git commit
Git push
Session log update
Change summary
Validation pass

SECTION 2 — YOUR CURRENT SYSTEM ARCHITECTURE
Current Environment
Local Build Mirror
Location:
D:_Legaisee\LEGAiSEE_LIVE_MIRROR
This is now the MASTER WORKSPACE.
You should NOT work directly in cPanel anymore unless emergency recovery is required.

Live Server
Server:
legaisee.com
Remote Path:
/home/carrmulti/www/www/commandcenter

Git Repository
Repository:
urlLEGAiSEE_Repo GitHub Repositoryhttps://github.com/legaisee26-netizen/LEGAiSEE_Repo
Branch:
main

Primary Tools
Tool
Purpose
Claude
Strategic architect + governance
Windsurf
Controlled implementation
Git
Recovery + version history
GitHub
Offsite backup
SFTP
Live deployment
cPanel
Emergency recovery only


SECTION 3 — DAILY STARTUP PROCEDURE
Perform this EXACT sequence EVERY work session.

STEP 1 — Open Windsurf
Launch Windsurf
Click:
File → Open Folder
Open:
D:_Legaisee\LEGAiSEE_LIVE_MIRROR
Wait for indexing to finish

STEP 2 — Open Terminal
Inside Windsurf:
Click:
Terminal → New Terminal
Verify terminal path says:
D:_Legaisee\LEGAiSEE_LIVE_MIRROR

STEP 3 — Pull Latest Git Backup
Paste:
git pull origin main

Press ENTER.
This downloads latest backed up state.

STEP 4 — Verify Git Status
Paste:
git status

Expected safe output:
nothing to commit, working tree clean

If files changed unexpectedly:
STOP.
Do NOT continue until understood.

STEP 5 — Read Governance Files
Before ANY coding:
Read:
_governance/

Especially:
04_CURRENT_OBJECTIVE.txt
05_DAILY_WORK_ORDER.txt
07_MASTER_SYSTEM_BIBLE.txt
12_BUILD_SPEC.txt
13_ARCHITECTURE_LOCK.txt
14_PROTECTED_FILES.txt

STEP 6 — Define ONE Objective
Only ONE major task at a time.
Examples:
GOOD:
Build Search Workspace V1
Repair ingestion dashboard
Add graph visualization
BAD:
Rebuild whole system
Optimize everything
Modernize architecture

SECTION 4 — DAILY EXECUTION LOOP
This is the official execution pipeline.

Phase 1 — Claude Planning
Claude creates:
Build specification
Exact file targets
Exact logic
Validation requirements
Rollback plan
Claude DOES NOT generate massive uncontrolled rewrites.
Claude produces:
Task lists
Controlled implementation instructions
Governance validation

Phase 2 — Windsurf Execution
Windsurf receives:
Exact file list
Exact change scope
Exact expected behavior
Windsurf executes ONLY:
Requested modifications
Requested additions
Requested repairs

Phase 3 — Validation
After EVERY modification:
Validate:
UI Validation
Does page load?
Does navigation work?
Any broken CSS?
Any blank screens?
PHP Validation
Any fatal errors?
Any undefined functions?
Any include failures?
Any duplicate functions?
System Validation
Existing modules still function?
Existing routes still function?
Existing APIs still function?

Phase 4 — Commit Recovery Point
After validation:
git add .

Then:
git commit -m "Describe exact change here"

Then:
git push origin main

NEVER skip push.

SECTION 5 — DEPLOYMENT PROCEDURE
Safe Deployment Workflow
NEVER deploy random files blindly.

STEP 1 — Verify Git Clean
git status


STEP 2 — Test Locally First
Before upload:
Open affected pages
Open affected APIs
Test navigation
Test module loading

STEP 3 — Upload Changed Files Only
Inside Windsurf:
Right-click changed file
Click Upload
OR:
Use SFTP Sync carefully.
Avoid uploading entire system unless necessary.

STEP 4 — Live Validation
Open live site.
Test:
Dashboard
Modules
APIs
File loading
Navigation
Search
Ingestion

STEP 5 — Emergency Recovery If Broken
If deployment breaks:
Recovery Option A — Git Rollback
git log --oneline

Copy previous stable commit ID.
Then:
git checkout COMMIT_ID

OR:
git revert COMMIT_ID


Recovery Option B — Restore From cPanel Backup
Restore:
affected files
backup snapshots
prior known working state

SECTION 6 — WINDSURF SAFETY RULES
NEVER Allow Windsurf To:
rename architecture
move directories
rebuild working systems
create frameworks
introduce package managers
install random dependencies
rewrite working modules
merge unrelated systems
replace stable code

ALWAYS Force Windsurf To:
work incrementally
modify only target files
explain intended changes BEFORE writing
list impacted files BEFORE execution
validate after execution
preserve compatibility

SECTION 7 — YOUR SAFE AI EXECUTION PROMPT
Paste this BEFORE every AI build session.
You are operating inside the LEGAiSEE Sovereign Architecture System.

You are NOT the architect.
You are an execution worker.

Before ANY modification:

1. Read:
- _governance/07_MASTER_SYSTEM_BIBLE.txt
- _governance/12_BUILD_SPEC.txt
- _governance/13_ARCHITECTURE_LOCK.txt
- _governance/14_PROTECTED_FILES.txt
- _governance/16_DRIFT_PATTERNS.txt
- _governance/10_VALIDATION_CHECKLIST.txt

2. NEVER:
- refactor unrelated systems
- rename architecture
- modernize structure
- replace working code
- introduce frameworks
- reorganize folders
- overwrite protected files

3. ONLY:
- modify explicitly requested files
- implement requested behavior
- preserve backward compatibility
- maintain existing architecture

4. BEFORE WRITING CODE:
- list files being modified
- explain exact intended changes
- identify risks
- identify rollback strategy

5. AFTER WRITING CODE:
- validate includes
- validate functions
- validate routes
- validate UI
- validate APIs
- summarize all changes

If scope drift is detected:
STOP and escalate.


SECTION 8 — GIT COMMANDS FOR ZERO-KNOWLEDGE USE
Check Current Status
git status

Shows:
changed files
staged files
untracked files

Add All Changes
git add .

Stages changes for commit.

Create Backup Snapshot
git commit -m "Describe changes"

Example:
git commit -m "Added ingestion dashboard navigation buttons"


Upload Backup To GitHub
git push origin main


Download Latest Backup
git pull origin main


View Previous Recovery Points
git log --oneline


Restore Older Version
git checkout COMMIT_ID

Replace:
COMMIT_ID
with actual commit number.

SECTION 9 — CURRENT CONFIGURATION BACKUP
Git Safe Directory
Already configured.

Repository
Remote:
https://github.com/legaisee26-netizen/LEGAiSEE_Repo


Local Repository
D:\_Legaisee\LEGAiSEE_LIVE_MIRROR


Live Server Path
/home/carrmulti/www/www/commandcenter


Windsurf SFTP Configuration
Current configuration:
Protocol: SFTP
Sync Mode: update
uploadOnSave: false
remotePath: /home/carrmulti/www/www/commandcenter

SECTION 10 — REQUIRED DAILY TASKS
Every day:
REQUIRED
1. Pull latest Git
git pull origin main


2. Read Governance Files
Especially:
Current objective
Architecture lock
Protected files

3. Define ONE Build Goal
Never multitask major architecture changes.

4. Build Incrementally
One subsystem at a time.

5. Validate Constantly
After EVERY change.

6. Commit Frequently
Small commits are safer.

7. Push Frequently
GitHub is your recovery system.

8. Update Logs
Maintain:
session logs
change history
architecture notes

SECTION 11 — WHAT TO DO WHEN SOMETHING BREAKS
NEVER PANIC DELETE
Do NOT:
wipe folders
reinstall system
replace everything
trust random AI fixes

SAFE RECOVERY PROCESS
Step 1
Identify:
exact error
exact file
exact last change

Step 2
Check:
git status


Step 3
View previous commits:
git log --oneline


Step 4
Restore previous stable state if necessary.

SECTION 12 — LONG TERM EVOLUTION PLAN
Phase 1 — Stabilization
Current focus.
Goals:
stable architecture
governance system
protected execution
reproducible builds
recovery systems

Phase 2 — Modular Intelligence
Goals:
memory graph
cross-case intelligence
excavation pipelines
recommendation systems
predictive insight systems

Phase 3 — Sovereign Infrastructure
Goals:
dedicated VPS
private AI routing
local model execution
architecture persistence
autonomous workflows

Phase 4 — Executive Intelligence Platform
Goals:
industrial archaeology
operational memory systems
enterprise continuity systems
authority reconstruction
long-horizon intelligence

SECTION 13 — MOST IMPORTANT RULE
Protect continuity over speed.
A slower stable system is infinitely more valuable than a fast unstable system.
Every commit should:
preserve recoverability
preserve architecture
preserve continuity
preserve intelligence history
LEGAiSEE is not a disposable app.
It is a sovereign long-horizon intelligence system.

