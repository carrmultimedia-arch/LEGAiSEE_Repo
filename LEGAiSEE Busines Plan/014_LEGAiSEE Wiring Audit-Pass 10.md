# LEGAiSEE Wiring Audit

## Pass 10 — Database Writers and Entity-Extraction Callers

**Scope:** Trace the visible callers of entity extraction and compare their database writes with the consumers that read the resulting records.

**Inspection source:** Public repository source files. **Limitation:** This is not a live-server test. The findings below apply to the inspected source and must be checked against the deployed files before making production changes.

---

## 1. Findings at a Glance

This pass clarifies five issues:

1. The entity-extraction engine has two documented callers: `modules/excavation_module.php` and `prospect.php`.
2. The prospect workflow is a standalone PHP entry point. The excavation module's normal route remains questionable because `shell.php` previously showed a special-case interception for `module=excavation`.
3. Entity and relationship records are stored globally in the inspected engine; the write operations do not persist the supplied client identifier as an ownership field.
4. The graph consumer's traversal query conflicts with the relationship writer's use of `from_entity` and `from_entity_id`.
5. The prospect workflow, file-ingestion workflow, and AI queue processor remain separate processing paths. No complete end-to-end pipeline connecting all three has been established.

---

## 2. WIR-063 — Entity Extraction Has Two Identified Callers, but One Has a Route Problem

**Severity:** High — execution path uncertainty **Status:** Callers identified; normal excavation route remains unresolved

The entity-extraction engine's own header identifies two callers:

* `modules/excavation_module.php`
* `prospect.php`

The excavation module includes the engine and calls `lee_extract_and_store()` while scanning files under client case directories and legacy artifact metadata.

The standalone `prospect.php` entry point also includes the engine and calls `lee_extract_and_store()` on submitted prospect text.

However, the earlier shell audit found that `shell.php` intercepts `module=excavation` and renders a different interface rather than normally dispatching to the registered excavation module.

**Implication:** The existence of the excavation module and its extraction call does not prove that the normal shell navigation executes that code.

The prospect workflow is a separate, identifiable entry point. Its actual availability and behavior on the live server have not been tested.

Sources:

* [Entity extraction engine](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/engine/entity_extraction_engine.php)
* [Excavation module](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/excavation_module.php)
* [Standalone prospect entry point](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/prospect.php)

---

## 3. WIR-064 — Entity Extraction Writes Global Entities, Not Explicitly Client-Owned Entities

**Severity:** High — data ownership and isolation **Status:** Confirmed in inspected insert statements

The extraction function accepts a `$clientId` parameter, but its entity upsert writes these fields:

* `entity_type`
* `canonical_name`
* `normalized_hash`
* `confidence`
* `created_at`

The relationship upsert writes:

* `from_entity`
* `to_entity`
* `relation_type`
* `strength`
* `source_context`
* `from_entity_id`
* `to_entity_id`
* `created_at`

Neither insert persists the supplied client identifier.

Entity deduplication uses a hash of the normalized entity name. Consequently, the inspected implementation can return the same entity record for the same normalized name across separate clients.

That may be intentional if LEGAiSEE is building a shared, cross-client intelligence graph. But the source does not establish an explicit ownership or authorization model that distinguishes shared entities from client-specific evidence.

**Important distinction:** A globally shared entity is not inherently a defect. The unresolved issue is whether the application intentionally shares the entity itself, the supporting evidence, the relationships, or all three—and whether access is controlled accordingly.

**Next verification:** Inspect the deployed schema and graph access rules. Determine how evidence provenance, client ownership, case ownership, and access permissions are represented.

Source: [Entity extraction engine](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/engine/entity_extraction_engine.php)

---

## 4. WIR-065 — Relationship Storage and Graph Traversal Still Disagree About the Source Field

**Severity:** High — graph traversal may fail **Status:** Mismatch confirmed in inspected source

The relationship writer stores the source entity's name in `from_entity` and its numeric ID in `from_entity_id`.

The graph module then queries:

`WHERE from_entity = ?`

The parameter supplied to that query is the numeric entity ID.

The graph module later resolves `to_entity` by looking up its value as a canonical entity name. That second step aligns with the extraction writer, which stores the destination entity's name in `to_entity`.

The source side does not align.

**Expected consequence if these files are deployed together with the same schema:** The graph traversal may fail to find relationships because it searches the name field using a numeric ID.

The separate `from_entity_id` and `to_entity_id` columns already exist in the writer's insert statement, so the mismatch is not caused by the extraction engine failing to generate entity IDs. It is a disagreement about which column the consumer should use.

This reinforces WIR-014 and WIR-054. It should be treated as one continuing integration issue, not three unrelated defects.

Sources:

* [Entity extraction engine](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/engine/entity_extraction_engine.php)
* [Graph module](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/graph_module.php)

---

## 5. WIR-066 — The Extraction Engine Uses a MySQL-Incompatible Timestamp Expression

**Severity:** High — potential runtime failure **Status:** Confirmed expression; runtime failure not tested

The entity and alias insert statements use:

`datetime('now')`

The same expression appears in the relationship insert.

The rest of the inspected database layer uses PDO with a MySQL-oriented schema and SQL syntax. In MySQL, the SQLite-style `datetime('now')` expression is not the normal equivalent of a current timestamp and can be interpreted as an invalid function call.

**Implication:** Entity extraction may fail when it reaches these inserts on a MySQL deployment.

This is a source-level compatibility concern, not proof that the live engine is currently failing. The actual deployed code, database engine, and schema must be checked before changing it.

Source: [Entity extraction engine](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/engine/entity_extraction_engine.php)

---

## 6. WIR-067 — The Extraction Counter Counts Successful Upsert Returns, Not Necessarily New Records

**Severity:** Medium — misleading reporting **Status:** Confirmed in inspected function logic

The entity upsert first searches for an existing normalized hash. If it finds one, it returns the existing ID.

The caller then increments `$inserted` whenever it receives an ID—even when that ID belongs to an entity that already existed.

Therefore, the returned `entities_stored` count can represent successful entity resolutions/upserts rather than the number of newly inserted database records.

The relationship counter has a similar distinction: the extraction loop increments its counter after calling the relationship upsert, even if that function returns early because the relationship already exists.

**Implication:** Extraction logs may report processing activity as if it were newly stored data. Counts should not be interpreted as database growth without checking what the counters actually measure.

This matters when evaluating whether repeated excavation runs are adding new intelligence or simply revisiting existing records.

Source: [Entity extraction engine](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/engine/entity_extraction_engine.php)

---

## 7. WIR-068 — Prospect Analysis and Excavation Analysis Are Separate Implementations

**Severity:** Medium — duplicated analytical logic **Status:** Confirmed in inspected source

The prospect entry point performs its own signal detection and authority scoring. It identifies categories such as operational delays, pricing pressure, lead friction, workforce issues, brand gaps, growth signals, market shifts, and digital/technology gaps.

The excavation module separately:

* Loads artifacts from client case directories and legacy metadata.
* Calls the entity-extraction engine.
* Detects a smaller set of signal categories.
* Clusters artifacts by those signals.
* Generates executive-case narratives.
* Writes generated case JSON files to the client filesystem.

These workflows share the entity-extraction engine but do not constitute one unified analysis pipeline.

For example, the prospect workflow's authority score and prospect-ingest history are not shown being passed into the excavation module's narrative-generation process. Likewise, the excavation module's generated narratives are not shown being consumed by the prospect workflow.

**Implication:** These may be deliberately different tools serving different stages of the business workflow. The source does not establish that one is supposed to replace the other.

The integration question is whether prospect research should eventually become an input to the same evidence and case model used by excavation.

Sources:

* [Prospect entry point](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/prospect.php)
* [Excavation module](https://raw.githubusercontent.com/carrmultimedia-arch/LEGAiSEE_Repo/HEAD/modules/excavation_module.php)

---

## 8. Caller/Writer Inventory — Current Evidence

This table summarizes the specific connections established in the inspected files. It is not a claim that every caller in the repository has been found.

| Component or data store | Visible writer/caller | Visible consumer | Current conclusion |
| --- | --- | --- | --- |
| `memory_ingest` | Ingest module's pasted-transcript handler | Ingest View and the ingest module's recent-session list | Storage and listing are connected; downstream entity extraction is not demonstrated |
| Case `network.json` | Ingest module through `ingestToNode()` | Portfolio engine reads network files under a different directory pattern | Previously identified path mismatch remains |
| `entities` | Entity-extraction engine | Graph module and other database-oriented modules | Connected at the table level; source-field and ownership issues remain |
| `relationships` | Entity-extraction engine | Graph module and review/client-facing consumers | Connected at the table level; field semantics are inconsistent |
| `prospect_ingests` | Standalone prospect workflow | Prospect workflow's history lookup | Internal read/write path is visible |
| `processing_queue` | Writer not yet established | `ai_process.php` | Queue consumption is visible; queue creation remains unresolved |
| `raw_data` | Writer not yet established | `ai_process.php` | Queue processor expects these records; producer remains unresolved |
| `tasks` | `ai_process.php` | Downstream consumer not yet established | Output storage is visible; subsequent use remains unresolved |

---

## 9. What This Means for the Wiring Audit

The evidence now supports a more precise picture:

* **Prospect intake → entity extraction → MySQL entities and relationships:** A direct call path exists in the inspected source.
* **Excavation artifact scanning → entity extraction → MySQL entities and relationships:** A direct call path exists inside the excavation module, but the normal shell route remains questionable.
* **File upload → JSON network node:** A direct path exists, but the node describes the upload rather than the document contents.
* **Pasted transcript → `memory_ingest` → entity extraction:** The first storage step exists; the downstream bridge has not been demonstrated.
* **`processing_queue` → `raw_data` → AI processing → `tasks`:** The consumer path is visible, but the queue/data producers and AI-function dependencies remain unresolved.
* **MySQL relationship storage → graph traversal:** A consumer exists, but the source-field mismatch may prevent correct traversal.

These are distinct paths. They should not be treated as one functioning end-to-end system merely because the relevant modules and tables exist.

---

## 10. Recommended Next Pass

**Pass 11 should examine the schema and API surface together.**

The priority questions are:

1. What do the deployed table definitions say about `entities`, `relationships`, `files`, `documents`, `memory_ingest`, `processing_queue`, `raw_data`, and `tasks`?
2. Which API files call the graph module, invoke extraction, or create background-processing jobs?
3. Are `from_entity_id` and `to_entity_id` intended to be authoritative, with the name fields retained for display or compatibility?
4. How are client and case ownership represented in the actual schema?
5. Does the live server contain newer versions that resolve any of these source-snapshot mismatches?

Until those questions are answered, I would not recommend replacing the extraction engine, deleting the JSON network path, or redesigning the queue. The immediate objective remains to establish which deployed components are actually connected and which connections are still missing.