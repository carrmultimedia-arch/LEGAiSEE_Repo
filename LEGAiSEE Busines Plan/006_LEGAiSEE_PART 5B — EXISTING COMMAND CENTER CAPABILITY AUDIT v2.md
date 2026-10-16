# PART 5 — EXISTING COMMAND CENTER CAPABILITY AUDIT

## Pass 3: Review, Reporting, and Vault Integration

### 1. Scope

This pass examines the downstream evidence lifecycle:

1. Entity and relationship extraction.
2. Dig Review queue creation.
3. Human verification.
4. Retrieval of confirmed findings.
5. PDF report generation.
6. Report storage.
7. Report retrieval through the Vault.

The purpose is to determine whether these components are connected into a coherent workflow or merely coexist in the repository.

### 2. WIR-012 — Dig Review combines database records with filesystem-derived findings

**Classification:** Confirmed mixed-source behavior **Priority:** High

**Source:** `modules/dig_review_module.php`

The module loads two different collections of findings.

The first collection comes from case-analysis files under:

`data/clients/*/cases/*/`

It searches for:

* `meta.json`
* `insights.json`
* `clusters.json`
* `network.json`

The second collection comes from MySQL's `review_flags` table.

The module merges the collections for display.

This creates two distinct review paths:

| Finding type | Origin | Persistent review record |
| --- | --- | --- |
| Entity | MySQL `entities` table, after queueing | Yes, when successfully inserted into `review_flags` |
| Relationship | MySQL `relationships` table, after queueing | Yes, when successfully inserted into `review_flags` |
| Insight | Filesystem analysis output | Not created by the display-loading code |
| Cluster | Filesystem analysis output | Not created by the display-loading code |
| Network node | Filesystem graph output | Not created by the display-loading code |

The interface only presents the normal review-action buttons when a displayed finding has an `id`. Filesystem-derived findings do not receive a persistent review-flag ID from the loading process.

Consequently, those findings appear in the interface but cannot be confirmed or rejected through the normal persistent-review action.

**Wiring conclusion:** The review interface is connected to the MySQL entity and relationship review mechanism, but the filesystem-derived findings are not connected to the same review lifecycle.

**Disposition:** Preserve both loading paths until we establish which case-analysis files are still operational. Then determine whether those findings should be retired, migrated into a supported data model, or retained as a separate analytical-results view.

Do not assume every JSON file is obsolete merely because JSON was formerly used as database storage.

### 3. WIR-013 — The review queue does not automatically include every supported source type

**Classification:** Confirmed limitation in the queueing logic **Priority:** Medium–High

The `queue_unreviewed` operation selects entities and relationships that do not already have corresponding records in `review_flags`.

It does not perform equivalent queueing for the `documents` table, even though the rendering code contains logic to retrieve document titles and sources when a review flag references a document.

This suggests an incomplete or partially evolved review interface.

The code supports displaying document-backed review records if they exist, but the inspected queueing operation does not create those records.

**Wiring conclusion:** Document review is not connected to the same automatic queueing mechanism as entity and relationship review.

**Disposition:** Determine whether documents are supposed to be reviewed directly, whether only extracted findings should be reviewed, or whether document-level verification belongs to a separate stage.

Do not add document queueing until the intended review model is established.

### 4. WIR-014 — Relationship display uses fields inconsistent with the extractor's ID-based relationships

**Classification:** Confirmed source-level field mismatch **Priority:** High

The entity extraction engine writes relationship records using both name-based fields and ID-based fields:

* `from_entity`
* `to_entity`
* `from_entity_id`
* `to_entity_id`

In the inspected implementation, the first pair contains entity names and the second pair contains entity IDs.

Dig Review's relationship hydration query joins the `entities` table using the name-based fields:

`e1.id = r.from_entity`

`e2.id = r.to_entity`

That is inconsistent with the extractor's representation.

If the schema follows the extractor's insert statements, the review query should use the ID fields for those joins.

The relevant files are:

* `engine/entity_extraction_engine.php`
* `modules/dig_review_module.php`

**Wiring conclusion:** Relationship records may be created, but the current review interface may fail to resolve their endpoint names correctly.

This is a field-contract defect between two connected components, not proof that the relationship engine itself is unusable.

**Disposition:** Verify the live MySQL schema and existing records. Then correct the joins to match the established schema, if the mismatch is confirmed against the authoritative server.

### 5. WIR-015 — Confirmed findings are not yet demonstrated to be case-specific

**Classification:** Confirmed query-scope limitation **Priority:** High

The report module retrieves confirmed findings from `review_flags` using the selected client ID as its context filter.

It does not filter those findings by the selected case ID.

The module separately loads case and client records from MySQL, but those lookups do not constrain the confirmed-findings query.

As implemented, the report-generation path can therefore select all confirmed findings associated with a client context, rather than only findings belonging to the selected case.

This creates a risk that a report for one case could contain findings associated with another case for the same client.

There is an additional uncertainty: the review queue populates context from the entity or relationship record's `context` field. The inspected extraction engine accepts a `clientId` argument, but the shown entity and relationship insert statements do not establish a consistent case-level provenance relationship.

**Wiring conclusion:** The report module is connected to the review table, but the relationship between a finding, a client, and a specific case is not adequately established by the inspected queries.

**Disposition:** Before changing report generation, establish the canonical relationship among:

* Client.
* Case.
* Source artifact.
* Extracted entity or relationship.
* Review decision.

Then ensure the report query selects findings for the correct case and client, rather than relying on an ambiguous context string.

### 6. WIR-016 — The report generator produces a PDF but includes limited finding detail

**Classification:** Confirmed limitation in report assembly **Priority:** Medium–High

The report module:

1. Loads confirmed review records.
2. Loads case and client information from MySQL.
3. Generates HTML.
4. Renders the HTML through Dompdf.
5. Saves the resulting PDF.
6. Sends the PDF to the browser.

The generated report lists the source table, source record ID, and operator note for each confirmed finding.

The inspected report-generation function does not hydrate each finding into its substantive analytical content. For example, it does not resolve an entity ID to its canonical name or a relationship ID to its endpoint names and relationship type before building the report.

Consequently, the PDF-generation mechanism exists, but the resulting content is closer to an index of confirmed records than a complete evidence-based analytical report.

**Wiring conclusion:** The report generator is connected to the review table, but the transformation from approved records into meaningful client-facing evidence is incomplete.

**Disposition:** Preserve the PDF-generation infrastructure. First repair the finding-to-case relationship and determine the required report content. Then connect the report assembler to the correct evidence and analysis records.

### 7. WIR-017 — Case selection uses JSON while report metadata is loaded from MySQL

**Classification:** Confirmed mixed-source behavior **Priority:** High

The report module builds its case-selection dropdown by scanning:

`data/clients/*/cases/*/meta.json`

When the form is submitted, it retrieves the selected case and client from MySQL.

This creates a mixed-source path:

**Filesystem case metadata → selection form → MySQL case lookup → report generation**

The approach can work if the filesystem metadata and database records remain synchronized. The inspected code does not establish that synchronization.

A case could appear in the dropdown but not exist in MySQL, or its filesystem metadata could identify a different client than the corresponding database record.

The module also falls back to placeholder metadata when a case or client lookup returns no record, rather than stopping immediately when the requested records are absent.

**Wiring conclusion:** The report interface is not using one consistently verified source for case selection and case identity.

**Disposition:** Establish the current authoritative case store. Given the migration history you described, MySQL should be treated as the current architectural direction, but the actual live schema and existing workflow must be verified before retiring the JSON case-selection path.

### 8. WIR-018 — The Vault download link does not match the download handler

**Classification:** Confirmed request-parameter mismatch **Priority:** High

The Vault module scans the filesystem for PDF reports and displays a download link containing:

`action=download&report_id={filename}`

However, its download handler checks for:

`action=download&report_path={path}`

The handler requires `report_path`; the link supplies `report_id`.

Therefore, the download link does not satisfy the handler's request contract.

Even if a report exists and appears in the Vault, the displayed link does not provide the parameter that the handler expects.

**Wiring conclusion:** The report-listing and report-download components are not correctly connected through their request parameters.

**Disposition:** Repair the interface contract rather than replacing the Vault. Prefer a stable report identifier or a validated filename that the server resolves within the authorized report directory. Do not accept arbitrary filesystem paths from the browser.

### 9. WIR-019 — Report generation and Vault storage share a filesystem convention, but client identity remains file-based

**Classification:** Confirmed filesystem dependency; canonical identity unverified **Priority:** Medium–High

The report module saves generated PDFs under:

`data/clients/{client_id}/cases/{case_id}/reports/`

The Vault scans client directories and their nested case report directories for PDFs.

Those paths are consistent with each other.

However, the Vault derives the client display name from:

`data/clients/{client_id}/profile.json`

The report generator obtains the client name from MySQL.

This creates another legacy dependency: the report file may be stored under a database client ID, while the Vault's display name depends on a JSON profile.

If the profile is missing or obsolete, the Vault falls back to displaying the directory name.

**Wiring conclusion:** Report storage and report discovery are connected through a shared directory convention, but client identity and display metadata are sourced inconsistently.

**Disposition:** Do not change the directory structure yet. Establish whether the existing report files must remain where they are and whether the Vault should read client metadata from MySQL.

### 10. WIR-020 — The Vault's payment action assumes a case ID derived from the client ID

**Classification:** Confirmed identifier assumption; runtime impact unverified **Priority:** High before accepting transactions

The Vault's payment action constructs a case identifier by transforming the client ID string.

This is not a reliable client-to-case relationship. A client may have multiple cases, and identifiers need not follow a predictable naming pattern.

The payment request also carries a report filename and a user-entered email address.

The inspected JavaScript therefore relies on an assumed relationship between client ID and case ID instead of resolving the selected report to its actual case record.

**Wiring conclusion:** The report-to-payment connection does not establish a reliable case association.

**Disposition:** Do not use this flow for real client transactions until the payment module's server-side validation and identifier relationships have been verified. Any payment request should resolve the report, case, and client through authoritative records rather than infer identifiers from strings.

### 11. Consolidated findings

| ID | Finding | Classification | Priority |
| --- | --- | --- | --- |
| WIR-012 | Dig Review merges MySQL review flags with filesystem-derived findings. | Mixed-source behavior | High |
| WIR-013 | Automatic review queueing covers entities and relationships but not documents. | Incomplete queueing path | Medium–High |
| WIR-014 | Relationship display joins entity IDs against name-based relationship fields. | Field-contract mismatch | High |
| WIR-015 | Report selection is not used to constrain the confirmed-findings query by case. | Query-scope limitation | High |
| WIR-016 | PDF generation lists record identifiers and notes rather than fully resolved finding content. | Incomplete report assembly | Medium–High |
| WIR-017 | Case selection comes from JSON while report metadata comes from MySQL. | Mixed-source behavior | High |
| WIR-018 | Vault download links send `report_id`, while the handler requires `report_path`. | Confirmed request mismatch | High |
| WIR-019 | Report discovery depends on JSON client profiles even though report generation uses MySQL client records. | Mixed-source dependency | Medium–High |
| WIR-020 | Payment request construction derives a case ID from the client ID. | Identifier-contract concern | High before transactions |

### 12. Current assessment

The repository contains a substantial amount of the intended workflow:

* Entity and relationship extraction.
* Persistent review flags.
* Human confirmation and rejection.
* PDF generation.
* Report storage.
* Report discovery.
* Payment initiation.

However, the existence of these pieces does not establish an end-to-end operational workflow.

The current source contains specific breaks in the interfaces connecting them. These include a mismatch in relationship-field usage, ambiguous case-level provenance, inconsistent sources for case and client identity, and a mismatch between the Vault's download link and its handler.

The next step is to trace the canonical database relationships and inspect the payment module's server-side contract. That will establish which defects are local interface problems and which reflect a deeper disconnect in the current data model.