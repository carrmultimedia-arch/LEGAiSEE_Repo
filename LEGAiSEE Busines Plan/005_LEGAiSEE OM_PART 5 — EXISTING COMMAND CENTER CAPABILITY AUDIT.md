# PART 5 — EXISTING COMMAND CENTER CAPABILITY AUDIT

## 5.1 Purpose

This audit establishes what the existing LEGAiSEE Command Center contains, how its components are connected, and what must be verified before additional development begins.

The objective is not to redesign the system.

The objective is to establish a reliable baseline so that subsequent work builds on the existing implementation, repairs actual deficiencies, and avoids creating duplicate functionality.

The audit distinguishes six conditions:

| Classification | Meaning |
| --- | --- |
| Confirmed in code | The relevant implementation is visible in an inspected source file. |
| Functionally verified | A defined test demonstrated that the implementation works. |
| Present, unverified | The implementation exists, but its runtime behavior has not been demonstrated. |
| Incomplete or inconsistent | The code, routing, data model, or documentation indicates an unresolved issue. |
| Missing | The required capability could not be located in the inspected scope. |
| Security or operational concern | The implementation creates a risk that must be assessed or addressed. |

**Important:** A file's existence is not proof that a feature works. A documented feature is not proof that it has been implemented. A successful test in one environment is not proof that the production server behaves identically.

This document records a preliminary source-code audit, not a completed live-server or runtime audit.

## 5.2 Source-of-Truth Rules

The authoritative live-server copy remains the operational source of truth.

The GitHub repository is an inspection source. It helps establish the implementation and identify likely defects, but it does not independently establish that the live server contains the same files or that those files are operational.

Before any code change:

1. Identify the exact live-server file.
2. Inspect its current contents.
3. Determine whether the proposed change affects existing functionality.
4. Preserve a recoverable copy of the original.
5. Make the smallest change that addresses the verified problem.
6. Test the change against explicit acceptance criteria.
7. Record the result and the actual file changed.

Do not replace working server code merely because a repository version looks cleaner.

Do not introduce a second database, application shell, project-management system, or orchestration layer until the existing implementation has been examined.

The CAMERA project and its associated folders are outside this audit's scope.

## 5.3 Application Entry Point and Routing

### Finding A — `shell.php` exists as the central application shell

**Classification:** Confirmed in code; runtime behavior unverified.

The inspected `shell.php`:

* Loads `kernel/kernel_boot.php`.
* Loads shared utility and UI-rendering files.
* Loads the module registry.
* Reads the requested module from the `module` query parameter.
* Resolves the module against the registry.
* Includes the registered module file.
* Handles several possible module return formats.
* Provides a dashboard with grouped navigation cards.
* Includes early handling for report generation and vault downloads.

This is a meaningful application structure. LEGAiSEE is not simply a collection of unrelated PHP pages; it has a central entry point intended to coordinate modules.

### Finding B — Module rendering is implemented

The `renderModule()` function in `shell.php` checks whether the requested module is registered and whether its target file exists.

It then attempts to execute the module and render its output.

The renderer supports HTML output, strings, structured UI arrays, inspector-style results, and generic data arrays.

This provides a shared mechanism for displaying different kinds of modules.

**What remains unverified:**

* Whether every dashboard destination resolves correctly.
* Whether every registered module file exists on the live server.
* Whether all modules return data in formats the renderer handles correctly.
* Whether module errors are logged and presented appropriately.
* Whether permissions are enforced consistently.
* Whether every important action persists its changes correctly.

A central router is an established implementation component. A fully functional operating system has not yet been demonstrated.

## 5.4 Module Registry

### Finding C — A central module registry exists

**Classification:** Confirmed in code; route completeness unverified.

The inspected `kernel/module_registry.php` maps module names to PHP files.

The registry includes entries for:

* `dashboard`
* `intelligence_dashboard`
* `brain`
* `pm`
* `clients`
* `cases`
* `vault`
* `report`
* `payment`
* `excavation`
* `ingest`
* `files`
* `search`
* `graph`
* `relations`
* `semantic_cluster`
* `predictive`
* `recommendation`
* `dig_review`

Additional entries cover other system functions.

This means the existing application already has a substantial collection of named module destinations.

### Required verification

The next audit step is to compare three things:

1. Every module registered in `kernel/module_registry.php`.
2. Every module file actually present in the authoritative server copy.
3. Every module destination exposed through the `shell.php` interface.

The comparison must identify:

* Registered modules whose files are missing.
* Existing modules that are not registered.
* Dashboard links that do not resolve to registered modules.
* Modules with obsolete or duplicate implementations.
* Modules that load but fail during execution.
* Modules whose visible interfaces do not perform their advertised operations.

Do not rebuild the navigation until this comparison is complete.

## 5.5 Kernel and Database Bootstrap

### Finding D — A shared kernel bootstrap exists

**Classification:** Confirmed in code; runtime behavior unverified.

The inspected `kernel/kernel_boot.php` loads:

* `kernel/db.php`
* `kernel/kernel_paths.php`
* The UI bootstrap when its expected file exists
* The PHP session when one is not already active

It also attempts to initialize a global database connection using `kernel_db()`.

If initialization throws an exception, the inspected code assigns `null` to the global `$db` variable.

A runtime-validation helper checks whether the global database object is a PDO instance.

This shows an existing effort to centralize application initialization and support both newer database access patterns and older modules.

### Operational implications

A failed database connection must not be mistaken for a functioning application merely because the bootstrap continues executing.

The audit must establish:

* Whether database initialization succeeds on the live server.
* Whether the connection uses the intended MySQL database.
* Whether required tables and columns exist.
* Whether failures are logged.
* Whether modules fail safely when the database is unavailable.
* Whether legacy modules depend on global `$db` while newer code uses `kernel_db()`.
* Whether configuration files contain credentials or other sensitive information that should not be exposed.

No database migration or connection redesign should occur until these questions are answered.

## 5.6 Dashboard

### Finding E — A dashboard module exists

**Classification:** Confirmed in code; actual runtime output unverified.

The inspected `modules/dashboard_module.php` loads case and client records from JSON directories and returns a structured result containing totals.

Its current implementation is simple: it reports the number of cases and clients loaded through those JSON-directory functions.

The existence of a dashboard module therefore does not establish that it provides a comprehensive operational overview.

### Required verification

Determine whether the dashboard:

* Loads successfully through the central shell.
* Displays accurate case and client counts.
* Reflects the authoritative data sources.
* Handles empty directories and invalid JSON files.
* Distinguishes prospects from active clients.
* Reports useful operational status rather than only record totals.
* Links to working operational functions.

The dashboard should not be expanded until the underlying data-source questions are resolved.

## 5.7 Project Management

### Finding F — An existing project-management interface is implemented

**Classification:** Confirmed in code; database operations and runtime behavior unverified.

The inspected `modules/pm_module.php` describes itself as a single-page workspace with project navigation and list/board views.

The file:

* Uses `kernel_db()`.
* Defines task statuses, including Backlog, Architecting, Building, Review, Blocked, and Done.
* Defines a separate project lifecycle, including Intake, Approved, Planning, Active, On Hold, At Risk, Review, Completed, and Archived.
* Contains code for project creation.
* Generates unique URL-safe project slugs.
* Uses prepared statements for the inspected project-creation query.

This is an existing implementation, not merely a proposed feature.

### Required verification

The audit must test:

1. Project creation.
2. Project retrieval.
3. Project editing.
4. Project status changes.
5. Task creation and updates.
6. Task-to-project relationships.
7. List and board views.
8. Persistence after a reload.
9. Handling of missing or incompatible database tables.
10. Error handling and permission enforcement.

The code excerpt inspected is not sufficient to certify all ten behaviors.

**Decision:** Preserve the existing project-management module and verify it before considering replacement or substantial redesign.

## 5.8 Data Storage and Duplication

### Finding G — The system documentation identifies multiple storage mechanisms

**Classification:** Documented concern; actual data consistency requires verification.

The existing `SYSTEM_LEGEND.md` identifies possible duplication in several areas:

**Client records**

* JSON files under `data/clients/`.
* A MySQL `clients` table.
* Potential overlap with another client directory.

**Case records**

* Individual JSON files under `data/cases/`.
* A master `data/cases.json` file.
* Possible database representations.

**Entities and relationships**

* MySQL entity and relationship tables.
* JSON network files.
* Case-specific network files.

**Memory and analysis snapshots**

* A MySQL `memory_ingest` table.
* Files under `data/memory/`.
* Files under `data/brains/`.

**Graph information**

* Database records.
* Network JSON files.
* Case-specific graphs.
* A graph snapshot under the brains directory.

The documentation also identifies possible functional overlap between some modules and engines.

These observations are important, but the existence of multiple representations does not automatically mean that the system is broken. Some may be deliberate indexes, exports, snapshots, or caches.

### Required investigation

For each important business object, determine:

1. Where it is created.
2. Where it is stored.
3. Which component reads it.
4. Which component updates it.
5. Whether a second representation is synchronized.
6. Which representation wins when records disagree.
7. Whether deletion or archival propagates correctly.
8. Whether the information can be recovered after a failure.

The audit must not arbitrarily declare MySQL or JSON to be the authoritative source for every object.

That decision must be based on actual implementation and existing operating requirements.

### Decision

Do not consolidate storage until the write paths, read paths, dependencies, and existing records have been mapped.

## 5.9 Initial Operational Risk

### Finding H — Error display requires production review

**Classification:** Security and operational concern; exploitability not established.

The inspected `shell.php` explicitly enables full PHP error reporting and sets `display_errors` to `1`.

This may expose implementation details when errors occur.

The production configuration should be checked to establish whether errors are displayed to visitors, written to logs, or handled by the hosting environment.

The intended production behavior is to log diagnostic details privately while displaying a safe error message to the user.

This finding does not establish that sensitive information has actually been exposed. It identifies a configuration that warrants immediate verification.

### Additional security checks

The audit must also inspect:

* Authentication and authorization.
* Session configuration.
* CSRF protection on state-changing requests.
* Input validation.
* File-upload handling.
* Download authorization.
* SQL query safety.
* Sensitive configuration files.
* Access to backups, diagnostic scripts, and test utilities.
* Whether error messages expose paths, queries, or credentials.

These checks are prerequisites for accepting real client information or conducting real transactions.

## 5.10 Repository Documentation Integrity

### Finding I — The root README is not LEGAiSEE project documentation

**Classification:** Confirmed in repository.

The inspected root `README.md` contains documentation for Dompdf, an HTML-to-PDF library.

It does not serve as an accurate primary guide to the LEGAiSEE application.

The repository also contains `SYSTEM_LEGEND.md`, which provides a plain-English description of the codebase and records possible duplication areas.

### Required action

Do not rely on the root README to establish application architecture.

A future documentation repair should provide a concise, accurate entry point explaining:

* What LEGAiSEE currently does.
* How the application starts.
* How modules are routed.
* How the database is initialized.
* Where important data is stored.
* How to verify a deployment.
* Which capabilities are implemented versus planned.

This documentation repair should follow the implementation audit rather than precede it.

## 5.11 Minimum Audit Sequence

The remaining audit should follow this order.

### Stage 1 — Application integrity

* Inspect the complete kernel bootstrap.
* Inspect the module registry.
* Compare registered module files against the live-server inventory.
* Identify unresolved entry points and route mismatches.
* Verify the production error-handling configuration.

### Stage 2 — Data integrity

* Identify the actual database connection and schema.
* Map important tables and JSON stores.
* Trace client, prospect, case, project, task, artifact, and review records.
* Identify authoritative write paths.
* Identify synchronization and duplication risks.

### Stage 3 — Core workflow verification

Test the minimum operational sequence:

1. Create or retrieve a prospect.
2. Create or retrieve a client.
3. Create a project or case.
4. Add an artifact.
5. Record its processing or review status.
6. Retrieve the artifact and associated records.
7. Generate or retrieve the resulting analysis.
8. Produce a deliverable.
9. Verify that changes persist.
10. Confirm that access and permissions behave correctly.

Where a workflow step does not exist, record it as missing rather than inventing an implementation.

### Stage 4 — Operational readiness

* Verify backup coverage.
* Verify that a restore can be performed.
* Confirm error logging.
* Check sensitive configuration and file exposure.
* Verify the basic operational interface.
* Record defects and their impact.

### Stage 5 — Minimal remediation

Only after the audit should we decide which existing components require repair, which require completion, and which should remain untouched.

## 5.12 Acceptance Criteria

Part 5 is complete only when the audit can answer the following questions with evidence:

* Does the live application load?
* Does the module registry match the actual module files?
* Which core modules have been tested successfully?
* Which database and JSON stores are authoritative for each major record type?
* Can a prospect become a client and enter a project or case workflow?
* Can artifacts be ingested, retrieved, and reviewed?
* Can the resulting information be used to create a deliverable?
* Do state changes persist after reload?
* Are authentication and authorization adequate for the intended use?
* Can the system be backed up and restored?
* Which defects prevent safe operational use?
* What is the smallest repair sequence that makes the existing system usable?

Until these questions are answered, the correct status is **partially inventoried, not production-certified**.

The next action is to continue the source-code audit against the authoritative server copy, using the GitHub implementation to identify the files and workflows that require verification.

===========================================================

I’ve continued the audit, and your clarification changes how I’m interpreting the data architecture.

I’ll treat MySQL as the current data architecture and the older JSON-based records as presumed legacy—not as competing authoritative databases. However, I’ve found current code that still reads some of those JSON paths. That distinction matters: obsolete data files can remain harmless, but code that still depends on them can produce incomplete or inconsistent results.

I also uncovered an urgent security issue in the public repository that takes priority over the rest of the audit.

1. Urgent: Credentials exposed in the public repository

The publicly accessible repository contains:

config.local.php with database connection credentials. sftp.json with FTP connection credentials and the server's remote application path.

I inspected both files directly. The credentials are exposed in readable source, so they must be treated as compromised. I will not reproduce them here.

Recommended immediate actions Change the database password through the hosting control panel and update the live application's private configuration to match. Change the FTP password and update your local deployment configuration. Check hosting access logs for unfamiliar connections or changes. Remove credentials from the repository and add the relevant configuration files to .gitignore. Address the Git history as well. Removing a file from the latest commit does not remove credentials from earlier commits. Review the tracked legaisee.db file to determine whether it contains any data that should not have been publicly accessible. Its presence in the repository is confirmed, but I have not established its contents.

Changing the credentials comes first. Removing the files from GitHub without invalidating the exposed credentials is insufficient.

I have not attempted to use these credentials or access your server.

LEGAiSEE Operating Manual — Part 5, Continued 2. Revised data-architecture assessment

Your clarification establishes the historical context:

Earlier versions stored information such as client records and imported AI conversations in JSON files. The system has since moved to MySQL. Many JSON files that once served as database storage are probably obsolete.

That changes the working assumption for this audit.

Data area	What the repository currently shows	Audit interpretation Client records	The client module queries MySQL's clients table.	MySQL is the current implementation path in this module. Project records	The project-management module uses kernel_db() and SQL queries.	MySQL-backed implementation. Imported AI conversations	The ingest module inserts transcripts into memory_ingest.	MySQL-backed ingestion is implemented in source. Case records	The cases module reads JSON files under data/cases/.	Legacy dependency remains in the inspected code. Case analysis	Dig Review reads JSON files for insights, clusters, and graph nodes.	Legacy analysis files still feed part of the review interface. Uploaded files	The ingest module stores files on disk and records metadata in MySQL.	Hybrid file-storage/database design.

The first three findings come from the inspected client module, project-management module, and ingest module.

The important distinction

The evidence does not support a blanket conclusion that JSON is still an authoritative data store.

It does support a narrower conclusion:

Some current modules still read JSON files, so those code paths must be examined before the corresponding files can safely be considered irrelevant.

I will not recommend migrating all JSON into MySQL, recreating old records, or consolidating the two storage mechanisms simply because both exist.

The objective is to establish what the current system actually uses.

3. Ingestion and AI-memory audit

The inspected modules/ingest_module.php contains a substantial implementation for importing information.

Confirmed in source

The module supports two principal operations.

A. Paste an AI transcript

It accepts a transcript, session label, platform, project tag, domain, and optional project association. It then inserts the transcript into memory_ingest, including its word count and context.

B. Upload a file

It accepts an uploaded file, writes it to a storage directory, copies it into normalized/, and attempts to insert file metadata into the files table. If a case is selected, it also attempts to add a node to a case network.

The module also retrieves counts from the memory_ingest, files, and documents tables, and retrieves project and domain choices from MySQL.

Findings requiring repair or verification Finding	Assessment	Priority File metadata uses datetime('now') in an insert intended for MySQL.	SQLite-style syntax is present in a MySQL-oriented module. It is a likely compatibility defect and must be tested against the actual schema and database.	High File upload errors are swallowed in a database-operation catch block.	The interface can report successful upload even if the metadata insert or case-network operation fails.	High The module reads case metadata from JSON.	This is a legacy filesystem dependency that remains in the current source.	Medium The module duplicates uploaded files into normalized/.	The purpose and downstream consumers of the second copy need verification.	Medium Upload validation is limited in the inspected section.	File-size limits, allowed types, authorization, and path safety need review.	High

The timestamp concern is based on the actual SQL expression in the file; whether it fails in production depends on the live database and schema. The swallowed exceptions and success message are visible in the implementation.

One specific concern

The code chooses a case directory using the submitted case_id and checks whether that path exists. The inspected code does not visibly constrain the submitted identifier to a safe, known case ID before constructing the path.

That warrants a path-traversal review before the upload interface is trusted with untrusted users or files.

I have not attempted to exploit it.

4. Dig Review: The human-verification layer

The Dig Review module is especially important because it sits between machine-extracted information and information that the system may treat as accepted evidence.

The module supports review states including:

Pending Confirmed Rejected Needs more information

It creates or uses a MySQL review_flags table and supports status updates through POST requests. It can also queue unreviewed entities and relationships from MySQL.

This is meaningful existing functionality.

However, I found a significant architectural complication.

The review interface merges two different sources

The module:

Reads MySQL review flags. Reads case findings from JSON files. Combines the two collections for display.

The JSON-derived findings include insights, clusters, and network nodes. They do not necessarily have the same persistent review-record IDs as the MySQL flags.

The interface only renders the review action buttons when a finding has an id. JSON-derived findings without that ID are displayed as automatically loaded case patterns rather than receiving the same persistent review controls.

Why this matters

The screen can look like a unified review queue while actually presenting two different kinds of records:

MySQL records with persistent review status. Filesystem-derived findings that are loaded for display.

Those are not equivalent capabilities.

The current source does not establish that every finding displayed in Dig Review can be confirmed or rejected and have that decision persisted.

This should be a high-priority workflow test.

Recommended direction

Do not rewrite Dig Review yet.

First establish whether the live application still contains valid case-analysis information in those JSON directories. If the files are obsolete, determine whether their loading code is obsolete too. If some contain current information, identify the intended MySQL representation and migration requirements before removing the dependency.

The goal is one coherent evidence-review workflow—not preservation of legacy JSON merely because the code still references it.

5. Client and case management

The client module queries MySQL for the latest 20 client records, including name, industry, location, status, and client UID. That is consistent with the current MySQL architecture.

The cases module, by contrast, loads case and client data from JSON directories and builds its display from those records.

This means the current codebase has different storage assumptions in adjacent business-management modules.

That is a confirmed source-level inconsistency, but it is not yet proof of a live operational failure. The live deployment may have legacy files that remain in use, or the code may no longer be part of the actual operating workflow.

Required audit questions Does the live application create and maintain cases in MySQL? Does the case list module use the current case records? Is there a current client-to-case relationship in MySQL? Does the excavation workflow create cases through the same data model? Are the JSON-based case lists still used anywhere operationally? Can a case be opened, analyzed, reviewed, and connected to a client without relying on an obsolete record?

These questions should be resolved before modifying case management.

6. The Brain module is not a complete health check

The Brain module presents a system-status view with the registered module count, data-directory counts, and engine-availability indicators.

But its health indicator checks whether certain directories exist:

data/files data/clients data/cases data/memory

It reports the data layer as ready when those directories exist.

That is a filesystem-presence check, not a comprehensive operational health check.

A directory can exist even when:

The database is unavailable. The expected tables are missing. A module is broken. An ingestion operation fails. A record cannot be retrieved. The data in that directory is no longer authoritative.

This is a relatively straightforward future improvement, but it should follow the basic application and database audit. The first task is to determine which components actually work.

7. Revised findings register

Here is the current evidence-based register from the repository inspection.

ID	Finding	Classification	Priority SEC-01	Database credentials are exposed in a public tracked configuration file.	Confirmed security exposure	Immediate SEC-02	FTP credentials are exposed in a public tracked deployment file.	Confirmed security exposure	Immediate SEC-03	A SQLite database file is present in the public repository; its contents have not been inspected.	Potential data exposure	High DATA-01	Client and project modules use MySQL, while the case-list module reads JSON.	Confirmed code-path inconsistency	High ING-01	Transcript ingestion writes to memory_ingest.	Implemented in source; runtime unverified	High ING-02	File upload metadata uses SQLite-style timestamp syntax in a MySQL-oriented insert.	Likely compatibility defect	High ING-03	Some upload-processing errors are swallowed, while success may still be reported.	Confirmed error-handling weakness	High ING-04	Case selection feeds a filesystem path without an obvious identifier allowlist in the inspected code.	Security concern requiring review	High REV-01	Dig Review merges MySQL review flags with JSON-derived findings.	Confirmed mixed-source behavior	High REV-02	JSON-derived findings do not necessarily receive persistent review controls.	Confirmed behavior in inspected rendering logic	High SYS-01	Brain's data-layer readiness indicator checks directory existence.	Confirmed limitation	Medium DOC-01	Root README contains Dompdf documentation rather than a LEGAiSEE system overview.	Confirmed documentation defect	Low

These are source-level findings, not the results of live-server tests.

8. What I recommend doing next

The audit should proceed in this order:

Contain the exposed credentials. Rotate them before any further work on the public repository. Inspect the current database schema and migration files. Establish the actual tables and relationships used by the current application. Trace the current ingestion pipeline. Follow a transcript and an uploaded document from submission through persistence and retrieval. Trace the case workflow. Determine whether cases are now MySQL-backed and identify any remaining JSON dependencies. Test Dig Review. Verify that a finding can be reviewed, that the decision persists, and that the accepted evidence can be retrieved downstream. Audit the excavation and analysis path. Establish whether the current pipeline produces useful, retrievable evidence and relationships. Only then produce the minimum repair plan.

I will continue to treat the live server as authoritative and GitHub as the source-code inspection copy. I will not assume that every repository file is current, that every module works, or that legacy JSON files should be migrated or preserved.

The key conclusion so far: LEGAiSEE contains real MySQL-backed functionality for projects, clients, and AI-session ingestion, alongside code paths that still depend on legacy filesystem data. The next audit stage must establish whether those paths are still required and whether the core excavation-to-review workflow works end to end.