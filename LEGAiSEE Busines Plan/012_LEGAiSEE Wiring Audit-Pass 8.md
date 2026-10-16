## 1. The Module Registry Confirms That the Main System Exposes Multiple Intelligence Components

**Source:** `kernel/module_registry.php` [Inspect module registry](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/kernel/module_registry.php)

The registry maps module names to PHP files. It includes entries for:

* `predictive`
* `semantic_cluster`
* `cross_case_engine`
* `graph`
* `entity_resolution`
* `excavation`
* `ingest`
* `dig_review`
* `report`
* `payment`

The shell loads the registry and uses it to resolve ordinary module requests. The dashboard also presents these modules as separate navigation destinations.

**Source:** [Main shell](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/shell.php)

### WIR-050 — Registry membership proves route registration, not operational integration

A registered module can be reachable through the shell without being connected to the rest of the intelligence pipeline.

For example, the registry contains both `predictive` and `semantic_cluster`, but those names alone do not establish that the predictive module consumes the output of the semantic-clustering engine.

Similarly, the `graph` module is registered, but registration does not establish that its database queries can resolve the relationship records produced by extraction.

**Impact:** Module counts and navigation availability are insufficient indicators of system readiness.

**Classification:** Confirmed architectural distinction. This is not a defect in the registry itself; it is a limitation of what registration tells us.

---

## 2. Two Predictive Implementations Use Different Data Sources

### Implementation A: Registered Predictive module

**Source:** `modules/predictive_module.php` [Inspect Predictive module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/predictive_module.php)

This module loads JSON case records from:

`data/cases/`

It reads each case's `analysis.patterns` array, calculates pattern-transition counts and probabilities, and returns:

* Pattern transition probabilities.
* Case-level predictions.
* Global predicted patterns.

It does not use the `loadAllCases()` function from the Portfolio Engine in the inspected implementation.

### Implementation B: Portfolio-level Predictive Intelligence Engine

**Source:** `engine/predictive_intelligence_engine.php` [Inspect Predictive Intelligence Engine](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/engine/predictive_intelligence_engine.php)

This engine calls `loadAllCases()`, which searches for network files under:

`data/clients/{client_id}/cases/{case_directory}/network.json`

It aggregates network nodes, clusters them, calculates signal distributions, and writes:

`data/portfolio/predictive_insights.json`

### WIR-051 — Two predictive systems operate on different representations of a case

| Property | Registered Predictive module | Portfolio Predictive engine |
| --- | --- | --- |
| Main input | JSON case records | JSON network files |
| Input root | `data/cases/` | `data/clients/` |
| Required data | `analysis.patterns` | `nodes` |
| Processing | Pattern-transition probabilities | Keyword-based signal classification and thresholds |
| Output | Module response | `predictive_insights.json` |
| Registered as `predictive` | Yes | No separate registry entry shown for the engine itself |

Both implementations may be useful. They analyze different representations of the data and do not necessarily need to be merged.

The integration problem is that the inspected code does not establish a shared input contract or a relationship between their outputs.

**Impact:** A case may be available to one predictive implementation but absent from the other.

**Classification:** Confirmed competing implementations; whether they are intentionally separate remains unresolved.

**Required decision:** Determine which predictive functions are current product capabilities and which are experiments, earlier versions, or specialized subsystems.

Do not delete either implementation solely because they overlap.

---

## 3. The Registered Predictive Module Does Not Consume the Portfolio Engine's Output

The registered Predictive module calculates its predictions directly from the case JSON collection it loads.

The portfolio engine writes a separate output file, `data/portfolio/predictive_insights.json`.

The inspected Predictive module does not read that output file.

### WIR-052 — The two predictive outputs are not visibly integrated

The source establishes two separate paths:

```text
data/cases/*.json
        │
        ▼
modules/predictive_module.php
        │
        ▼
Pattern transition results
```

And:

```text
data/clients/*/cases/*/network.json
        │
        ▼
Portfolio Engine
        │
        ▼
Predictive Intelligence Engine
        │
        ▼
data/portfolio/predictive_insights.json
```

No connection between these output paths has been demonstrated in the inspected modules.

**Impact:** A successful run of one predictive implementation does not establish that the other has run or consumed the same evidence.

**Classification:** Confirmed separation of the inspected paths. Whether another dashboard or script combines the outputs remains to be checked.

---

## 4. The Semantic-Clustering Module and Engine Are Also Separate Implementations

**Sources:**

* `modules/semantic_cluster_module.php`
* `engine/semantic_cluster_engine.php`

[Inspect semantic-clustering engine](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/engine/semantic_cluster_engine.php)

The engine exposes:

`buildSemanticClusters($nodes)`

It classifies nodes into groups using keyword matching. The inspected categories include audience performance, risk signals, growth signals, and unclassified nodes.

The previously inspected module contains a separate clustering implementation.

### WIR-053 — The registered clustering module and engine are not demonstrated as one shared implementation

The Portfolio Predictive Engine explicitly includes and calls the engine implementation.

The existence of a separate registered semantic-clustering module means the shell exposes another clustering path.

**Impact:** Changes to one implementation do not necessarily change the behavior of the other.

This is a maintenance and consistency concern if both are intended to provide the same analytical function. It may be acceptable if one serves interactive case-level analysis and the other performs portfolio-level classification.

**Required verification:** Compare the module's inputs, outputs, and intended purpose with the engine's contract before designating either as canonical.

---

## 5. The Graph Module Uses a Different Relationship Access Pattern

**Source:** `modules/graph_module.php` [Inspect Graph module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/graph_module.php)

The Graph module queries MySQL's `entities` and `relationships` tables.

It locates the starting entity by `canonical_name`, obtains its ID, and traverses relationship records.

The neighbor lookup queries:

`relationships.from_entity = ?`

using the current entity ID. It then resolves `to_entity` by searching `entities.canonical_name`.

The previously inspected entity-extraction engine, however, writes entity names to `from_entity` and `to_entity` while separately storing `from_entity_id` and `to_entity_id`.

### WIR-054 — Graph traversal has the same endpoint-semantics conflict found in review

If the inspected extraction implementation is the writer for the live relationship table, the Graph module's neighbor lookup will compare an entity ID against a column containing entity names.

That would prevent the query from reliably finding the intended outgoing relationships.

This is related to WIR-014 and WIR-034, but it affects a separate consumer: graph traversal.

**Impact:** Even if relationships exist in MySQL, the Graph module may not traverse them correctly.

**Classification:** Confirmed inconsistency between the inspected writer and reader implementations. Actual live impact depends on the deployed schema, existing records, and whether another writer populates these columns differently.

**Required verification:** Establish one authoritative relationship contract and check every writer and reader against it.

---

## 6. The Brain Module Reports File and Directory Presence, Not Engine Functionality

**Source:** `modules/brain_module.php` [Inspect Brain module](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/brain_module.php)

The Brain module:

* Loads the module registry.
* Counts registered modules.
* Lists the registered module names.
* Checks whether certain data directories exist.
* Checks whether several engine files exist.
* Reports a `data_layer_ready` result based on directory existence.

Its source explicitly describes it as an inspection-only component.

### WIR-055 — Brain's health indicator does not verify that the intelligence pipeline works

The module can report that the data layer is ready when the required directories exist.

It does not, through the inspected checks, establish that:

* MySQL connections succeed.
* Cases can be loaded from the intended source.
* Uploaded files become evidence nodes.
* Network JSON is valid.
* Entity extraction completes.
* Relationships can be traversed.
* Reports contain case-specific evidence.
* Predictive outputs reflect the expected inputs.

**Impact:** The Brain module is useful for inspecting the system's structure, but its readiness status should not be interpreted as end-to-end operational validation.

**Classification:** Confirmed limitation of the implemented checks, not a failure of the inspection module's stated purpose.

---

## 7. The Ingest View Is Connected to Memory Storage, Not the Entire Memory-Processing Lifecycle

**Source:** `modules/ingest_view_module.php` [Inspect Ingest View](https://github.com/carrmultimedia-arch/LEGAiSEE_Repo/blob/main/modules/ingest_view_module.php)

The module queries `memory_ingest` and displays recent entries with their session labels, platforms, and timestamps.

This confirms that the system has a reader for the transcript-storage path identified in Pass 7.

It does not show that the view initiates AI processing or that entries are transformed into entities, network nodes, or searchable knowledge.

### WIR-056 — Memory storage has a visible listing interface, but its downstream transformation remains unproven

The path demonstrated by these modules is:

```text
Transcript submission
        │
        ▼
memory_ingest
        │
        ▼
Ingest View
        │
        ▼
Recent stored transcript entries
```

The separate `ai_process.php` path uses `processing_queue` and `raw_data`.

No bridge between these paths has been demonstrated in the inspected code.

**Impact:** The interface can confirm that a transcript was stored, but the listing itself does not establish that the transcript became part of the system's analytical knowledge.

This may be an intentional archival workflow. The unresolved question is whether archived transcripts are supposed to feed the Business Archaeology evidence pipeline.

---

## 8. Updated Findings

| ID | Finding | Status |
| --- | --- | --- |
| WIR-050 | Module registration does not establish operational integration | Confirmed architectural distinction |
| WIR-051 | Two predictive implementations use different inputs and outputs | Confirmed competing implementations |
| WIR-052 | Predictive output paths are not visibly connected | Confirmed separation in inspected code |
| WIR-053 | Registered semantic-clustering module and engine are separate implementations | Confirmed; intended division unresolved |
| WIR-054 | Graph traversal's relationship-column assumptions conflict with the inspected extraction writer | Confirmed source inconsistency |
| WIR-055 | Brain's readiness indicator checks presence rather than end-to-end functionality | Confirmed limitation |
| WIR-056 | Transcript listing is connected to memory storage, but downstream processing is not demonstrated | Connection unresolved |

---

## 9. Pass 8 Conclusion

This pass establishes three distinct classes of integration concern.

### A. Competing implementations

The registered Predictive module and Portfolio Predictive Engine are separate analytical paths. The registered Semantic Cluster module and clustering engine are also separate implementations.

The correct response is not automatically to consolidate them. First determine whether they serve different purposes or represent design drift.

### B. Data-contract inconsistencies

The Graph module's relationship lookup conflicts with the relationship-column semantics observed in entity extraction.

This is more consequential than duplicated code because it can prevent an existing database record from being consumed correctly.

### C. Health indicators that do not validate processing

The Brain module confirms the presence of registered modules and expected directories. It does not validate the entire path from evidence ingestion to intelligence output.

The system therefore needs a clear distinction between:

* Component exists.
* Component is reachable.
* Component executed.
* Component processed the intended input.
* Component produced a valid, traceable result.

These are different states and should not be conflated.

### Overall audit direction

Continue tracing actual callers and data contracts. Preserve components until their roles are understood. The next priority is to determine which analytical modules are actively invoked, which are only registered, and whether any scheduled or API-driven entry points connect the apparently separate paths.