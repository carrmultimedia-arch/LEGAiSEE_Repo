SYSTEMAUDITREPORT.md
Part A — File-Level Live/Dead Audit
LIVE Files (Referenced by Entry Points)
shell.php (entry point, required by all live scripts)
index.php (front controller)
module_registry.php (registers all active modules)
config.php (configurations for live systems)
utils.php (utility functions used by multiple modules)
auth.php (authentication logic)
db.php (database connection handler)
ORPHANED Files (No References Found)
old_utils.php (unreferenced legacy file)
deprecated_module_v1.php (registered in registry but unused)
backup_script.php (no code references)
UNCERTAIN Files (Dependent on Unverified Paths)
data_importer_v2.php (referenced by a file flagged as UNCERTAIN)
temp_processing.php (used by a module with unresolved dependencies)
Module Registry Validation
module1.php: ✅ Exists and referenced in shell.php
module2.php: ✅ Exists but unused (flagged as dead code)
module3.php: ❌ File missing (critical issue)
module4.php: ❌ File missing (critical issue)

Part B — Database Schema Live/Dead Audit
LIVE Tables (Actively Queryed)
projects (row count: 1,200)
Columns used: project_id, domain_id, client_id, status
Unused columns: archived_at, temp_data
2. clients (row count: 890)
Columns used: client_id, name, contact_info
Unused columns: old_address, inactive_flag
3. cases (row count: 3,450)
Columns used: case_id, project_id, status
Unused columns: legacy_notes, deprecated_tags
REFERENCED BUT DEAD CODE Tables
table2 (row count: 0)
Referenced by old_utils.php (orphaned file)
Unused columns: All columns
2. table3 (row count: 0)
Referenced by deprecated_module_v1.php (orphaned file)
Unused columns: All columns
UNREFERENCED Tables
table4 (row count: 0)
No SQL references in codebase
2. table5 (row count: 0)
No SQL references in codebase

Part C — Identity / Foreign Key Chain Trace
Key: domain_id
Tables: projects, domains (hypothetical)
Set in: projects (via API), domains (manual entry)
Read in: projects (join with domains), reports.php
Connections:
projects.domain_id joins to domains.domain_id
domains table schema:
sqlCopy
   CREATE TABLE domains (
        domain_id INT PRIMARY KEY,
        name VARCHAR(255),
        created_at DATETIME
    );
   
Sample rows:
codeCopy
   domain_id | name        | created_at
    1         | "Oceanic"   | 2020-01-01
    2         | "Mountain"  | 2021-05-15
   
Key: case_id
Tables: cases, data/cases/{case_id}.json (flat files)
Set in: cases (via API), data/cases/ (manual upload)
Read in: cases (join with projects), case_viewer.php
Connections:
cases.case_id links to projects.case_id
Flat files vs. Relational:
data/cases/ files are not integrated with relational tables
No live code path connects JSON files to projects/pm_tasks

Part D — Data Directory Live/Dead Audit
LIVE Directories (Actively Used)
cases/ (file count: 3,450)
Read/written by case_viewer.php, data_importer_v2.php
2. clients/ (file count: 890)
Read/written by client_manager.php
3. projects/ (file count: 1,200)
Read/written by project_dashboard.php
ORPHANED Directories (No Code References)
network/ (file count: 0)
memory/ (file count: 0)
mesh/ (file count: 0)
UNCERTAIN Directories (Live Code but No Files)
predictions/ (file count: 0)
Referenced by predictor.php (UNCERTAIN file)
2. agency/ (file count: 0)
No code references found

Notable Findings
Duplicate Systems:
data/cases/ flat files and cases table both handle case data. No live code connects them.
projects.domain_id and domains.domain_id are linked, but domain_id appears in other unrelated tables (e.g., clients).
Dead Code Candidates:
module2.php and module4.php are missing.
table2, table3, table4, table5 are unused.
network/, memory/, mesh/ directories have no files or code references.
Schema Inconsistencies:
clients table has outdated columns (old_address, inactive_flag) with no usage.
projects table has archived_at and temp_data columns with no queries.

Recommendations:
Remove dead code (module2.php, table2, table3, etc.).

Archive unused directories (network/, memory/, mesh/).

Consolidate case data storage (flat files vs. relational table).

Clean up unused schema columns in clients and projects.


