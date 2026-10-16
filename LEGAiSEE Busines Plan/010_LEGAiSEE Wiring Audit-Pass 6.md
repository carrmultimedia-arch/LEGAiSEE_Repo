## 1. File Ingestion and Excavation Use Different Case Directories

### Ingestion module

**Source:** `modules/ingest_module.php` [Inspect ingestion module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/ingest_module.php)

When a user uploads a file and selects a case, the module checks for:

`data/cases/{case_id}/`

It then stores the uploaded file under:

`data/cases/{case_id}/files/`

The module also copies the file to `normalized/` and inserts its metadata into the MySQL `files` table. It subsequently calls the ingestion pipeline with the case ID and a network file path under the same `data/cases/{case_id}/` directory.

### Excavation module

**Source:** `modules/excavation_module.php` [Inspect excavation module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/excavation_module.php)

The excavation module scans a different structure:

`data/clients/{client_id}/cases/{case_id}/files/`

It looks for artifacts in that client-specific directory and passes their contents to the entity-extraction engine.

### WIR-038 — Ingestion writes files where excavation does not look for them

**Severity: High integration concern**

The two modules expect different paths:

| Operation | Expected or written path |
| --- | --- |
| Ingestion upload | `data/cases/{case_id}/files/` |
| Ingestion network | `data/cases/{case_id}/network.json` |
| Excavation file discovery | `data/clients/{client_id}/cases/{case_id}/files/` |
| Excavation metadata discovery | `data/clients/{client_id}/artifacts/metadata/` |

The ingestion module's case selector also obtains its cases from `data/cases/*/meta.json`, whereas excavation scans client-specific directories.

**Impact:** A file uploaded through the ingestion interface is not automatically available to excavation through the path excavation scans. The two modules can operate independently without sharing the same artifacts.

This is a direct source-level mismatch. It does not prove that the live server has no separate copying or synchronization process.

**Audit disposition:** Trace all writers and readers for both directory structures before choosing a canonical layout. Do not simply move files or rewrite paths yet.

---

## 2. Excavation Generates Case Files in a Location the Cases Module Does Not Read

The excavation module groups artifacts into signal clusters and generates synthetic executive cases with IDs such as:

`auto_case_ops_delay_{timestamp}`

Its persistence loop writes those generated cases to:

`data/clients/{client_id}/cases/{generated_case_id}.json`

The Cases module, however, loads JSON files directly from:

`data/cases/`

It does not recursively scan the client-specific case directories in the inspected implementation.

Sources:

* [Excavation module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/excavation_module.php)
* [Cases module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/cases_module.php)

### WIR-039 — Generated executive cases are written outside the Cases module's discovery path

**Severity: High integration concern**

The excavation module generates case records in a client-specific directory, while the Cases module discovers case records from a separate root directory.

Consequently, the Cases module will not discover those generated files through its current `load_json_dir()` call.

There is an additional structural difference: the excavation module writes files named after generated case IDs directly into the client-specific `cases` directory. The ingestion and excavation readers, by contrast, expect case directories containing files or metadata.

**Impact:** The system has multiple concepts of a case:

1. A case directory under `data/cases/{case_id}/`.
2. A case directory under `data/clients/{client_id}/cases/{case_id}/`.
3. A generated executive-case JSON file under `data/clients/{client_id}/cases/{generated_case_id}.json`.
4. A MySQL case record referenced by Client View.

Those may represent distinct intended objects, but the current source does not demonstrate a consistent contract connecting them.

**Audit disposition:** Determine whether generated executive cases are supposed to become canonical client cases, remain analytical outputs, or be stored as evidence attached to an existing case.

---

## 3. The Excavation Module Is Both a Reader and a Writer

The excavation module does more than analyze existing files.

It:

1. Scans client-specific case directories for files.
2. Reads file contents.
3. Calls entity extraction.
4. Scans artifact metadata JSON files.
5. Identifies simple text signals.
6. Groups artifacts into clusters.
7. Generates executive-case records.
8. Writes generated JSON into client-specific directories.

This makes the module a data producer, not merely a report view.

### WIR-040 — Generated cases are not visibly registered in MySQL

The generated executive-case persistence loop writes JSON files. The inspected loop does not insert those generated cases into the MySQL `cases` table.

Client View queries MySQL for the client's most recent case. The Cases module discovers JSON files from `data/cases/`.

**Impact:** An executive case generated by excavation is not automatically established as a canonical MySQL case, nor is it automatically visible to the Cases module through its current root-directory scan.

That may be intentional if generated cases are analytical outputs rather than client case records. The distinction must be explicit in the data model.

**Required decision:** Define whether a generated analytical case is:

* A real case record;
* An analytical finding attached to an existing case; or
* A standalone JSON output awaiting operator review.

The code should not be changed until that distinction is established.

---

## 4. File Upload Records and Physical Files Are Separate Representations

The ingestion module saves a physical file, creates a normalized copy, and inserts a row into MySQL's `files` table containing fields such as filename, filepath, file type, size, context, and case ID.

It also reads the file into a variable named `$content`, but the subsequent call to `ingestToNode()` passes a filename-based note and network path rather than the contents variable.

**Source:** [Ingestion module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/ingest_module.php)

### WIR-041 — Uploading a file does not establish that its contents reach the node-ingestion step

The inspected call is effectively:

`ingestToNode(case_id, "File uploaded: filename", network_file)`

The module reads the uploaded file contents but does not pass that string to the function.

**Impact:** The file can be saved and its metadata recorded without the node-ingestion call receiving the document text through that argument.

This does not establish that the document is never processed elsewhere. It establishes that this particular ingestion call does not pass the contents it just read.

That distinction matters because successful upload, successful metadata insertion, successful node creation, and successful extraction of document content are four different outcomes.

---

## 5. Database Compatibility: A Second Concern in File Ingestion

The ingestion module inserts a row into MySQL's `files` table using:

`datetime('now')`

The previously inspected entity-extraction engine uses the same SQLite-style expression in inserts for entities, aliases, and relationships.

Sources:

* [Ingestion module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/ingest_module.php)
* [Entity extraction engine](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/engine/entity_extraction_engine.php)

### WIR-042 — SQLite-style timestamp expressions appear in MySQL-oriented insert paths

**Severity: Potential execution defect; requires runtime verification**

The application obtains its database connection through `kernel_db()`, which is intended to provide the shared PDO connection. The affected modules execute SQL containing `datetime('now')`.

That expression is characteristic of SQLite syntax. Its behavior is not equivalent to using MySQL's normal timestamp expressions in every context.

**Impact:** These inserts may fail on the live MySQL connection, depending on the exact statement and server configuration.

The ingestion module catches and suppresses exceptions around its file metadata insertion and node-ingestion call. It can therefore report that the physical upload succeeded even if the database or network-ingestion work failed.

**Audit disposition:** Verify these statements against the actual MySQL version and schema. Do not infer successful database writes from the upload success message alone.

---

## 6. The Current Case Lifecycle Is Not a Single Demonstrated Path

Combining the preceding findings gives this observed flow:

```text
INGESTION UI
    │
    ├── Reads case choices from:
    │   data/cases/*/meta.json
    │
    ├── Saves uploaded file to:
    │   data/cases/{case_id}/files/
    │
    ├── Copies file to normalized/
    │
    ├── Attempts MySQL files insert
    │
    └── Calls node-ingestion function
             │
             └── data/cases/{case_id}/network.json

EXCAVATION MODULE
    │
    ├── Reads:
    │   data/clients/{client_id}/cases/*/files/
    │
    ├── Reads:
    │   data/clients/{client_id}/artifacts/metadata/*.json
    │
    ├── Runs entity extraction
    │
    ├── Groups simple text signals
    │
    └── Writes generated executive cases:
        data/clients/{client_id}/cases/{generated_case_id}.json

CASES MODULE
    │
    └── Reads JSON files directly from:
        data/cases/

CLIENT VIEW
    │
    ├── Reads clients and cases from MySQL
    ├── Reads payments from MySQL
    ├── Reads confirmed review flags from MySQL
    └── Locates reports in client-specific filesystem paths
```

This is not a claim that every branch is broken. It is a map of the separate paths established by the inspected source.

---

## 7. Updated Findings

| ID | Finding | Status |
| --- | --- | --- |
| WIR-038 | Ingestion and excavation use different case-file paths | Confirmed source-level mismatch |
| WIR-039 | Generated executive cases are outside the Cases module's discovery path | Confirmed source-level mismatch |
| WIR-040 | Generated executive cases are not visibly inserted into MySQL `cases` | Confirmed for the inspected persistence loop |
| WIR-041 | File contents are read but not passed to the visible node-ingestion call | Confirmed source-level omission |
| WIR-042 | SQLite-style timestamp expressions appear in MySQL-oriented inserts | Potential runtime defect; test required |

### Pass 6 conclusion

The evidence now points to three distinct integration boundaries:

1. **Storage boundary:** Different modules expect files in different directory structures.
2. **Record boundary:** Generated analytical cases are not visibly registered as canonical MySQL cases.
3. **Processing boundary:** A successful file upload does not establish that the file contents reached node ingestion or entity extraction.

These are more actionable than a general finding that the system is incomplete. They identify where data can stop moving between components.

The next step is to trace the ingestion pipeline, network readers, and canonical case-creation paths. That will show whether a second process connects these paths or whether the current implementation leaves them isolated.