# LEGAiSEE Wiring Audit

## Pass 9 — API Entry Points, Ingestion Callers, and Background Processing

**Scope:** Trace visible entry points into ingestion and AI processing, determine what actually connects, and identify unresolved execution paths.

**Inspection source:** Public LEGAiSEE repository. **Limitation:** No live-server execution, database inspection, cron inspection, or production logs were available for this pass.

---

## 1. Findings at a Glance

This pass establishes four important distinctions:

1. **File upload is connected to a node-writing function**, but the function receives a filename-based description rather than the uploaded document's contents.
2. **Pasted AI transcripts are stored in `memory_ingest`**, while `ai_process.php` reads from different tables. No connection between those paths is demonstrated in the inspected code.
3. **The background processor has an incomplete visible dependency chain.** It requires `api/prompts.php` and calls `process_ai()`, but the referenced prompt file could not be retrieved at the expected path in the public repository, and the processor itself does not define `process_ai()`.
4. **An API or background-processing component cannot be classified as obsolete merely because its caller has not yet been found.** Its external callers, scheduled execution, and live-server counterpart remain unresolved.

---

## 2. WIR-057 — AI Processor References a Prompt File Not Found at the Expected Public Path

**Severity:** High — execution dependency unresolved **Status:** Source-level discrepancy; live status unknown

The public `ai_process.php` begins with:

* `require_once __DIR__ . '/kernel/db.php'`
* `require_once __DIR__ . '/api/prompts.php'`

The processor then calls `getPrompt($task, $input)`.

The expected `api/prompts.php` path could not be retrieved from the inspected public repository. This does not prove the file is missing from the live server, but it means the public source snapshot does not presently let us verify the dependency.

**Why it matters:** If the file is absent from the deployed location, the processor cannot reach its prompt-building stage.

**Next verification:** Check whether `api/prompts.php` exists on the live server and whether its deployed version defines `getPrompt()`.

Source: [ai_process.php — public repository](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/ai_process.php?utm_source=chatgpt.com)

---

## 3. WIR-058 — The AI Processor Calls an AI Function Whose Implementation Is Not Established

**Severity:** High — execution dependency unresolved **Status:** Unresolved

After assembling its input and obtaining a prompt, `ai_process.php` calls:

`process_ai($prompt)`

The file includes the database layer and the prompt file, but does not itself define `process_ai()`.

Its inline comment says that the AI layer should already exist. That comment is not evidence that the implementation is present, loaded, or operational.

**What we can establish:**

* The processor expects an AI execution function.
* The implementation is not present in the processor itself.
* The inspected file does not establish which component provides the function.

**What remains unknown:**

* Whether another included file defines it.
* Whether a bootstrap or global include is expected to provide it.
* Whether the live deployment has a dependency absent from the public snapshot.

**Next verification:** Locate the actual `process_ai()` definition and trace how it is loaded before this call.

---

## 4. WIR-059 — The Background Processor Has No Visible Connection to Pasted AI Transcripts

**Severity:** High — pipeline disconnect **Status:** No connection demonstrated in inspected code

The ingest module stores pasted transcripts in `memory_ingest`. It records the transcript text, word count, platform, project tag, and optional domain and project identifiers.

The separate `ai_process.php` processor follows a different route:

1. Select one pending row from `processing_queue`.
2. Read the corresponding case identifier.
3. Retrieve the latest matching record from `raw_data`.
4. Assemble input from `website_history`, `reviews`, and `social`.
5. Build a prompt.
6. Call `process_ai()`.
7. Store the result in `tasks`.
8. Mark the queue row as done.

The inspected processor does not read from `memory_ingest`, and the inspected transcript-storage handler does not enqueue a job for `ai_process.php`.

**Conclusion:** These are two distinct data paths in the source examined. A bridge may exist elsewhere, but it has not been demonstrated.

**Next verification:** Search for every writer to `processing_queue` and `raw_data`, then determine whether any of them consume `memory_ingest` records.

Sources:

* [Ingest module](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/ingest_module.php?utm_source=chatgpt.com)
* [AI processor](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/ai_process.php?utm_source=chatgpt.com)

---

## 5. WIR-060 — Background Execution Is Not Established

**Severity:** High — operational path unknown **Status:** Unresolved

`ai_process.php` contains code to process a single pending queue item. The file does not establish how it is launched.

The inspected source does not show whether it is run through:

* A scheduled task or cron job.
* An HTTP request.
* A manual administrative action.
* Another PHP process or application component.

The file also selects a pending item without visibly claiming it atomically before processing. If multiple instances execute concurrently, they could potentially select the same pending job. Whether that occurs in practice depends on the actual execution environment.

The processor also has no visible surrounding error-handling workflow for failures during prompt creation, AI execution, or task storage.

**Important distinction:** A processor file existing is not proof that background processing is running. Conversely, failure to find its scheduler in the files examined is not proof that no scheduler exists.

**Next verification:** Inspect the live hosting control panel for scheduled tasks and identify any HTTP or application callers of `ai_process.php`. Then verify how a job is claimed, retried, and marked failed.

---

## 6. WIR-061 — The File-Upload Path Writes a Node, but Not a Document-Content Node

**Severity:** High — evidence-ingestion limitation **Status:** Confirmed in inspected source

The upload handler reads the uploaded file into `$content`, but calls:

`ingestToNode($case_id, "File uploaded: {$safe_name}", $network_file)`

The `$content` variable is not passed to that function.

The ingestion pipeline stores the supplied text in a node's `content` field and derives its basic type, strength, and tags from that text. Because the supplied text is the upload notice, the resulting node describes the upload event rather than the actual document.

**Implication for Business Archaeology:** The upload path establishes that a file was uploaded and records a filename-based node. It does not, by itself, demonstrate extraction of the file's substantive evidence into the node network.

This finding reinforces WIR-006 and WIR-041; it is not a new, independent defect.

Sources:

* [Upload handler](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/ingest_module.php?utm_source=chatgpt.com)
* [Ingestion pipeline](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/kernel/ingestion_pipeline.php?utm_source=chatgpt.com)

---

## 7. WIR-062 — The Ingestion Pipeline Writes to a File Network, Not the Entity/Relationship Database Graph

**Severity:** High — integration boundary unresolved **Status:** Separate storage paths confirmed; downstream bridge not demonstrated

`ingestToNode()` loads a JSON network file, appends a node to its `nodes` array, and writes the JSON file back. It does not itself insert an entity or relationship into the MySQL graph tables.

Other inspected modules, including semantic clustering and graph traversal, query MySQL `entities` and `relationships`.

That creates two distinct structures:

| Structure | Visible responsibility |
| --- | --- |
| Case `network.json` | Stores nodes produced by the file-ingestion pipeline |
| MySQL `entities` and `relationships` | Stores entities and graph relationships used by graph-oriented modules |

A conversion or synchronization process could connect these structures, but the inspected ingestion function does not do so.

**Conclusion:** Do not treat a successful file upload or node write as proof that the MySQL entity graph has been populated.

**Next verification:** Locate every caller of the entity-extraction engine and determine whether it reads `network.json`, the original uploaded file, or another source—and whether it writes records with the IDs and ownership fields expected by graph consumers.

Sources:

* [Ingestion pipeline](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/kernel/ingestion_pipeline.php?utm_source=chatgpt.com)
* [Semantic-cluster module](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/semantic_cluster_module.php?utm_source=chatgpt.com)

---

## 8. What This Pass Does—and Does Not—Establish

### Established in the inspected source

* The upload handler calls `ingestToNode()`.
* The ingestion pipeline appends nodes to a JSON network.
* The transcript handler stores transcripts in `memory_ingest`.
* `ai_process.php` uses `processing_queue`, `raw_data`, and `tasks`.
* The processor depends on `getPrompt()` and `process_ai()`.
* The inspected upload and transcript handlers do not visibly connect their inputs to the AI processor's queue.

### Still unverified

* Whether the live server contains a different or additional prompt file.
* Where `process_ai()` is defined and loaded.
* Which components create `raw_data` and `processing_queue` records.
* Whether a scheduled task or external caller launches `ai_process.php`.
* Whether any process synchronizes JSON network nodes with MySQL entities and relationships.
* Whether other API endpoints or legacy scripts provide missing connections.

### Audit discipline

These findings identify **unproven connections**, not a blanket conclusion that the corresponding components are unused. The next pass should trace the missing callers and writers before any component is classified as dead code or recommended for replacement.