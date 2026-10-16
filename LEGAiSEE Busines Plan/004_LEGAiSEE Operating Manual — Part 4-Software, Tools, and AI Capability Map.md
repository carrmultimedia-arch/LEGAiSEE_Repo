# LEGAiSEE

## Operating Manual — Part 4: Software, Tools, and AI Capability Map

**Document status:** Operating model specification **Version:** 1.0 **Prepared:** October 16, 2026 **Project:** LEGAiSEE Business Operating System **Dependencies:** Parts 1, 2, and 3 of the LEGAiSEE Operating Manual

---

# 1. Purpose

This document maps the capabilities required to operate LEGAiSEE to the software, tools, and infrastructure that could provide them.

It answers six practical questions:

1. What capabilities does LEGAiSEE need?
2. Which operating pipelines and roles require them?
3. What existing LEGAiSEE components might already provide them?
4. What remains unverified or missing?
5. What can be accomplished using existing or free tools?
6. What should be implemented first to support revenue generation and dependable client delivery?

The objective is not to select a large collection of software products.

It is to establish the smallest reliable collection of capabilities that supports the business.

## 1.1 Operating assumptions

This capability map uses the following established constraints:

* LEGAiSEE is currently pre-revenue.
* The Founder is the sole human operator.
* The Command Center is under construction.
* Existing software functionality has not been comprehensively verified.
* The existing PHP and MySQL architecture should be reused where practical.
* AI execution must respect explicit authority and security boundaries.
* Free and low-cost solutions are preferred.
* New subscriptions and paid APIs require demonstrated justification.
* Revenue generation must not be displaced by unnecessary infrastructure development.

These assumptions are operating constraints, not proof that any particular software component works.

## 1.2 The central architectural decision

**LEGAiSEE should have one authoritative operating environment, one authoritative set of business records, and multiple ways to perform work within those boundaries.**

The existing Command Center is the intended operational home.

External tools may support individual tasks, but they should not create competing sources of truth.

For example:

* A general-purpose LLM may analyze a research package.
* A browser may discover public sources.
* A local document processor may extract text.
* A spreadsheet may temporarily help validate a dataset.
* The Command Center should ultimately hold or reference the authoritative operational record.

A temporary working document is acceptable when useful. It must not silently become a second permanent operating system.

## 1.3 Four separate capability layers

LEGAiSEE needs four distinguishable layers.

### Layer A — Business operations

The processes that acquire prospects, qualify opportunities, manage engagements, deliver work, and maintain client relationships.

### Layer B — Knowledge and evidence

The processes that ingest artifacts, preserve provenance, verify claims, establish relationships, and support analytical findings.

### Layer C — AI-assisted execution

The models and procedures that help the Founder and functional roles perform work.

### Layer D — Technical infrastructure

The application, database, authentication, permissions, storage, backups, monitoring, and integration mechanisms that support the other layers.

These layers interact, but they are not interchangeable.

An LLM is not a CRM.

A database is not an evidence-verification methodology.

A visible interface is not proof of a working backend.

An automation is not reliable merely because it can be demonstrated once.

---

# 2. Capability Status Definitions

Every capability in this document receives a provisional status.

| Status | Meaning |
| --- | --- |
| **Established requirement** | The operating model requires the capability. This does not establish that software implementing it exists. |
| **Reported existing** | Previous project information identifies a potentially relevant component, but its current implementation has not been verified here. |
| **Unverified** | A candidate implementation or component may exist, but its operation, completeness, or reliability is unknown. |
| **Missing or to be established** | No dependable implementation has been established by the available information. The capability may still exist in code that has not been inspected. |
| **Manual fallback** | The task can initially be performed using a documented human or AI-assisted procedure without building new software. |
| **Optional future capability** | Useful only if demonstrated operating requirements justify its cost and complexity. |

These labels describe the evidence available for this operating model.

They are not the results of a completed code audit.

For example, the handoff identifies a project-management module. That establishes a reported component, not a verified project-management workflow.

Similarly, the handoff identifies payment functionality. That does not establish that its pricing, transaction handling, or payment confirmation are correct.

---

# 3. Master Capability Inventory

The following inventory identifies the major capabilities needed across LEGAiSEE.

| ID | Capability | Primary purpose | Initial implementation | Priority |
| --- | --- | --- | --- | --- |
| CAP-01 | General-purpose LLM | Reasoning, drafting, summarization, and structured analysis | Existing accessible LLM interface | P1 |
| CAP-02 | Public-source research | Discover potentially relevant business evidence | Browser and search tools | P1 |
| CAP-03 | Artifact collection | Preserve relevant source material | Approved files and storage | P1 |
| CAP-04 | Text extraction | Convert documents into searchable, usable text | Existing software or local extraction tools | P1 |
| CAP-05 | Evidence register | Track artifacts, claims, provenance, and verification | Existing database if adequate; otherwise a minimal implementation | P1 |
| CAP-06 | Prospect management | Track businesses, qualification, outreach, and follow-up | Existing CRM or verified Command Center capability | P1 |
| CAP-07 | Task management | Assign work, track status, and record handoffs | Existing project-management capability if verified | P1 |
| CAP-08 | Identity and access control | Protect the application, records, and client information | Existing authentication and authorization, after security testing | P0 |
| CAP-09 | Backup and recovery | Recover application data and files after failure | Hosting backups plus independent verified backups | P0 |
| CAP-10 | Analytical workflow | Convert reviewed evidence into findings and recommendations | Structured LLM-assisted procedure | P1 |
| CAP-11 | Deliverable generation | Produce professional reports and evidence packages | Document templates and available office software | P1 |
| CAP-12 | Client and project records | Maintain engagement scope, milestones, and approvals | Existing Command Center where verified | P1 |
| CAP-13 | Contract and payment workflow | Manage approved commercial terms and payment status | Approved documents and verified payment provider | P1 before accepting payments |
| CAP-14 | Email and calendar support | Manage communications, appointments, and follow-up | Existing email and calendar, initially manual | P2 |
| CAP-15 | Financial administration | Track revenue, expenses, invoices, and obligations | Existing financial records or a simple controlled ledger | P1 |
| CAP-16 | Quality assurance | Test research, analysis, workflows, and application behavior | Checklists and repeatable test cases | P1 |
| CAP-17 | Technical monitoring | Detect errors, outages, and operational failures | Hosting controls and application logs | P0/P1 |
| CAP-18 | Searchable business memory | Preserve findings and business knowledge across engagements | Existing database and document references where adequate | P2 |
| CAP-19 | Entity and relationship analysis | Connect businesses, people, events, artifacts, and claims | Existing graph or relationship components if functional | P2 |
| CAP-20 | Automated workflow execution | Execute approved multistep procedures | Manual orchestration initially | P3 |
| CAP-21 | Client access portal | Provide controlled client access to approved materials | Existing portal capabilities if verified; otherwise defer | P3 |
| CAP-22 | Advanced analytics and authority monitoring | Monitor changes and evaluate continuing authority opportunities | Manual research and reporting initially | P3 |

**Priority definitions**

* **P0 — Essential protection:** Must be addressed before exposing sensitive client information or relying on a system for consequential operations.
* **P1 — Minimum viable operation:** Required for dependable prospecting and the first controlled delivery workflows.
* **P2 — Operational improvement:** Useful after the basic process works.
* **P3 — Future expansion:** Defer until justified by actual clients, workload, and revenue.

A P0 item can block a particular activity without blocking all other business activity.

For example, a defect in the payment workflow should prevent payment acceptance through that workflow. It does not necessarily prevent manual prospect research.

---

# 4. General-Purpose LLM Capability

## 4.1 Business purpose

The general-purpose LLM provides the reasoning and language-processing capability used by the functional roles.

It can assist with:

* Research planning.
* Source summarization.
* Claim extraction.
* Evidence classification.
* Contradiction identification.
* Analytical drafting.
* Deliverable preparation.
* Task planning.
* Administrative work.
* Quality-control checklists.
* Structured output generation.

The LLM is an execution aid, not the authoritative source of business facts.

## 4.2 Pipeline support

Potentially supports all 12 pipelines, particularly:

* A. Market Intelligence &amp; Business Development.
* B. Qualification &amp; Lead Management.
* C. Marketing &amp; Authority Development.
* D. Outreach &amp; Sales.
* F. Evidence Acquisition &amp; Excavation.
* G. Evidence Processing &amp; Verification.
* H. Analysis &amp; Authority Reconstruction.
* I. Deliverables, Review &amp; Client Acceptance.
* L. Internal Technology &amp; System Operations.

The model's usefulness depends on the quality of the task instructions, inputs, source access, and review process.

## 4.3 Roles

Primary users:

* Founder.
* L4 Producer.
* L3 Director.
* L2 Research &amp; Evidence Operator.
* L2 Analysis &amp; Deliverables Operator.
* L1 Operations Assistant.

## 4.4 Required inputs

* Role instructions.
* Approved task objective.
* Relevant methodology.
* Source artifacts or authorized source references.
* Project-specific context.
* Required output structure.
* Acceptance criteria.
* Applicable authority boundaries.

## 4.5 Expected outputs

Depending on the task:

* Research plans.
* Structured evidence records.
* Draft analyses.
* Reports.
* Project briefs.
* Administrative records.
* Quality-control findings.
* Proposed next actions.

## 4.6 Existing capability

**Status: Available in the current working environment; production integration unverified.**

The Founder can use an accessible general-purpose LLM interface to perform role-based tasks without first building an API integration.

The handoff also identifies an existing AI-related application component, `ai_process.php`, but its present functionality has not been verified.

It must not be assumed that this component provides reliable orchestration, persistent context, or authorized tool execution.

## 4.7 Low-cost implementation

Start with a single accessible LLM interface.

Use separate role prompts and task templates.

Do not create separate agents merely to simulate the organizational chart.

When comparing free model interfaces, evaluate them against actual LEGAiSEE tasks rather than generic intelligence rankings.

A useful evaluation set includes:

1. Extracting claims from a historical document.
2. Identifying source dependencies.
3. Comparing conflicting dates.
4. Producing a structured evidence record.
5. Drafting an analysis from reviewed evidence.
6. Identifying unsupported conclusions.
7. Following a strict output format.

Evaluate accuracy, correction time, context limits, file handling, privacy, and repeatability.

Free-tier availability and usage limits may change. Do not make a critical operating procedure dependent on a particular provider's free allowance without a fallback.

## 4.8 Paid service requirement

**Not established.**

A paid LLM subscription or API is not a launch prerequisite if the Founder can perform the required work through an available interface.

A paid API becomes worth considering only when a demonstrated requirement justifies it, such as repeatable application integration, volume, or a capability unavailable through existing tools.

## 4.9 Security considerations

* Do not upload confidential client artifacts to an external service unless its use is authorized.
* Review applicable data-handling terms before sending sensitive material.
* Provide only the context necessary for the task.
* Avoid exposing credentials, private keys, payment data, or unnecessary personal information.
* Require source references for material research claims.
* Treat model-generated code and database operations as untrusted until tested.

## 4.10 Priority

**P1.**

The immediate task is to establish dependable role-based use, not autonomous multi-agent execution.

---

# 5. Research and Source Discovery

## 5.1 Business purpose

Discover the sources needed to establish a business's history, identity, institutional characteristics, and relevant present-day context.

## 5.2 Pipeline support

Primarily:

* A. Market Intelligence &amp; Business Development.
* B. Qualification &amp; Lead Management.
* F. Evidence Acquisition &amp; Excavation.
* G. Evidence Processing &amp; Verification.
* H. Analysis &amp; Authority Reconstruction.

## 5.3 Roles

* Research Operator: primary.
* Assistant: source organization.
* Director: scope and acceptance review.
* Analysis Operator: identifies additional research requirements.

## 5.4 Required inputs

* Target business.
* Research question.
* Geographic and historical scope.
* Known names and aliases.
* Search restrictions.
* Evidence requirements.
* Available source material.

## 5.5 Expected outputs

* Candidate source list.
* Source references.
* Artifact inventory.
* Search log.
* Relevant extracted claims.
* Source relationships.
* Contradictions and evidence gaps.

## 5.6 Existing capability

**Status: Manual capability available; integrated research workflow unverified.**

Public-source research can initially be performed through a browser and accessible search tools.

The existence of an LLM or a Command Center module does not establish that LEGAiSEE has a working automated research capability.

## 5.7 Low-cost implementation

Use a browser-based research procedure.

Prioritize sources appropriate to the question, such as:

* Official business records.
* Historical newspapers.
* Government records.
* Archived company webpages.
* Industry publications.
* Original documents and photographs.
* Interviews and oral histories.
* Contemporary reporting.

Record the original source whenever possible.

Search-result snippets and AI-generated summaries are discovery aids, not substitutes for source inspection when verification is required.

A browser-based process is sufficient for initial prospecting and limited excavations.

## 5.8 Paid service requirement

**Not established.**

Specialized archival subscriptions, paid data providers, or commercial research databases may eventually be useful, but they should be purchased only when a specific research problem cannot be solved adequately through available sources.

## 5.9 Security and confidentiality

Public-source research is different from research using private client records.

Private material must be accessed only under the relevant authorization and engagement scope.

## 5.10 Priority

**P1.**

---

# 6. Artifact Collection, Document Ingestion, and Text Extraction

## 6.1 Business purpose

Convert documents, webpages, images, recordings, and other source materials into preserved artifacts and usable information.

## 6.2 Pipeline support

Primarily:

* F. Evidence Acquisition &amp; Excavation.
* G. Evidence Processing &amp; Verification.
* H. Analysis &amp; Authority Reconstruction.

Also supports:

* I. Deliverables, Review &amp; Client Acceptance.
* J. Retention &amp; Continuing Authority Management.
* L. Internal Technology &amp; System Operations.

## 6.3 Required capabilities

The workflow needs to distinguish:

1. Original artifact.
2. Stored or referenced copy.
3. Extracted text or metadata.
4. Claims extracted from the artifact.
5. Verified findings based on the artifact and other evidence.

These are different records or states, even if a single interface displays them together.

## 6.4 Expected outputs

* Preserved artifact or approved reference.
* File metadata.
* Extracted text.
* Relevant page or passage references.
* Extraction status.
* Error or quality notes.
* Link between the artifact and the resulting claims.

## 6.5 Existing capability

**Status: Unverified.**

The existing system reportedly contains ingestion-related functionality.

However, the current implementation has not been examined sufficiently to establish:

* Which formats are supported.
* Whether uploaded files are stored safely.
* Whether text extraction works.
* Whether extracted text remains linked to the original artifact.
* Whether errors are reported.
* Whether duplicate files are detected.
* Whether processing can be resumed after failure.

## 6.6 Low-cost implementation

Use existing operating-system and document tools where practical.

For example:

* PDF text extraction for searchable PDFs.
* OCR for scanned documents.
* Local document conversion for unsupported formats.
* Browser printing or saving for relevant webpages.
* Manual transcription for a small number of critical artifacts.

A local document-processing utility can reduce repetitive work without requiring an external API.

The correct tool depends on the source format and whether the content is text-based, scanned, audiovisual, or structurally complex.

### Minimum ingestion procedure

1. Identify the source artifact.
2. Confirm authorization to collect and store it.
3. Preserve the original or approved reference.
4. Record provenance.
5. Extract text or metadata where possible.
6. Record extraction success or failure.
7. Preserve page, passage, or timestamp references.
8. Associate the artifact with the relevant business and project.
9. Make extracted information available for evidence review.

The original artifact must remain distinguishable from its extracted representation.

## 6.7 Paid service requirement

**Not established.**

Local extraction tools should be evaluated before purchasing a document-processing service.

A paid OCR or document-intelligence service may be justified for large volumes of poor-quality scans or complex documents, but that is a future workload decision.

## 6.8 Security considerations

Uploaded artifacts can contain sensitive data or malicious content.

Required safeguards include:

* File-type validation.
* File-size limits.
* Restricted storage.
* Safe download and serving behavior.
* Protection against executable uploads.
* Appropriate access controls.
* Backup and recovery procedures.

The exact controls require technical verification.

## 6.9 Priority

**P1 for a dependable manual or semi-manual process.**

Automated bulk ingestion can wait until actual workload justifies it.

---

# 7. Evidence Register and Provenance

## 7.1 Business purpose

Provide the evidence foundation for LEGAiSEE's Business Archaeology work.

This is one of the most important capabilities in the entire system.

Without traceable evidence, the business risks producing attractive narratives that cannot be defended.

## 7.2 Pipeline support

Primarily:

* F. Evidence Acquisition &amp; Excavation.
* G. Evidence Processing &amp; Verification.
* H. Analysis &amp; Authority Reconstruction.
* I. Deliverables, Review &amp; Client Acceptance.

## 7.3 Required information

At minimum, the evidence system must support the relationship between:

* Business or entity.
* Project or excavation.
* Artifact.
* Source.
* Claim.
* Verification status.
* Related evidence.
* Contradictions.
* Finding.
* Analytical interpretation.
* Deliverable.

These relationships do not necessarily require a graph database.

A properly designed relational database can represent them.

## 7.4 Required inputs

* Collected artifacts.
* Source metadata.
* Extracted claims.
* Research questions.
* Applicable verification requirements.
* Reviewer decisions.

## 7.5 Expected outputs

* Searchable evidence records.
* Source-linked claims.
* Verification status.
* Contradiction records.
* Evidence packages.
* Traceable support for findings and deliverables.

## 7.6 Existing capability

**Status: Unverified.**

The handoff identifies several potentially relevant components:

* `KnowledgeSystem`
* Existing database structures.
* Ingestion-related functionality.
* A `dig_review` module.
* A `brain` module.
* Relationship and entity-resolution functionality previously reported.

These are candidates for inspection.

They do not establish that the evidence lifecycle works.

In particular, the existence of a Dig Review interface would not prove that source provenance, reviewer decisions, or claim status are reliably persisted.

## 7.7 Low-cost implementation

Prefer the existing MySQL database if it can support the required records and relationships.

The first implementation should establish a minimum evidence lifecycle:

**Artifact → Extracted Claim → Review → Verified Finding or Unresolved Claim → Analysis Reference.**

A minimal evidence record should contain:

* Unique identifier.
* Business or project reference.
* Source artifact reference.
* Claim text.
* Supporting passage or location.
* Source date and retrieval date, when available.
* Source relationship or dependency notes.
* Verification status.
* Reviewer notes.
* Relevant contradictions.
* Next action.

The exact schema should be determined after inspecting the existing database.

Do not create a new evidence database before establishing whether the existing system already provides the required structure.

## 7.8 Paid service requirement

**None established.**

The initial requirement is a dependable data model and review procedure, not a commercial knowledge-management platform.

## 7.9 Security considerations

Evidence may contain confidential client information.

The system must enforce access restrictions at the server and data-operation levels.

Original evidence should not be silently overwritten.

Substantive status changes should be traceable.

## 7.10 Priority

**P1.**

This is a core delivery capability.

---

# 8. Prospect Management and CRM

## 8.1 Business purpose

Identify, qualify, track, and follow up with businesses that may benefit from LEGAiSEE.

The system must support business development without requiring a large CRM subscription.

## 8.2 Pipeline support

Primarily:

* A. Market Intelligence &amp; Business Development.
* B. Qualification &amp; Lead Management.
* C. Marketing &amp; Authority Development.
* D. Outreach &amp; Sales.

Also supports:

* E. Contracting, Payment &amp; Onboarding.
* J. Retention &amp; Continuing Authority Management.

## 8.3 Required inputs

* Business identity.
* Geographic and industry information.
* Historical relevance.
* Source references.
* Qualification criteria.
* Contact information obtained through authorized means.
* Outreach history.
* Next action.
* Follow-up date.
* Current status.

## 8.4 Expected outputs

* Prospect records.
* Qualification assessments.
* Prioritized prospect lists.
* Follow-up queues.
* Outreach records.
* Opportunity status.
* Conversion reporting.

## 8.5 Existing capability

**Status: Unverified.**

The existing Command Center reportedly includes client and project-related functionality.

However, the handoff does not establish whether a working prospect CRM exists or whether it supports the required lifecycle.

A client record and a prospect record are not necessarily interchangeable.

## 8.6 Low-cost implementation

Use the existing Command Center if it can reliably support:

1. Prospect creation.
2. Prospect search.
3. Qualification status.
4. Contact records.
5. Outreach history.
6. Follow-up dates.
7. Conversion to a client or engagement.
8. Basic reporting.

If these capabilities are absent, implement the smallest necessary extension.

A temporary spreadsheet can support a small prospecting batch while the system is assessed, provided one authoritative record is designated and duplicate entry is avoided.

## 8.7 Suggested initial qualification fields

* Prospect ID.
* Business name.
* Website.
* Location.
* Industry.
* Approximate company scale, where reasonably supported.
* Years in operation or historical period of interest.
* Potential authority problem.
* Evidence of historical significance.
* Source references.
* Qualification status.
* Next action.
* Follow-up date.
* Outreach status.
* Notes and unresolved questions.

The system must distinguish documented information from estimated company size or preliminary judgments.

## 8.8 Paid service requirement

**Not established.**

An additional CRM subscription is unnecessary if the existing system can support the workflow reliably.

## 8.9 Security considerations

Contact information and correspondence must be stored and used appropriately.

Access to client and prospect records should follow the same authorization principles as the rest of the Command Center.

## 8.10 Priority

**P1.**

Prospect management is one of the most immediate revenue-supporting capabilities.

---

# 9. Task Management and Workflow Coordination

## 9.1 Business purpose

Coordinate work across the six functional roles and the 12 operating pipelines.

## 9.2 Pipeline support

All 12 pipelines.

## 9.3 Required inputs

* Project brief.
* Task objective.
* Owner.
* Required inputs.
* Acceptance criteria.
* Dependencies.
* Approval boundaries.
* Expected output.

## 9.4 Expected outputs

* Task records.
* Project status.
* Assignment records.
* Dependency tracking.
* Review results.
* Exception reports.
* Handoff records.

## 9.5 Existing capability

**Status: Reported existing; operational status unverified.**

The handoff identifies:

* `ProjectManager`
* A project-management module.
* `shell.php?module=pm`

The current implementation must be inspected and tested before it is treated as the authoritative task-management system.

## 9.6 Low-cost implementation

Reuse the existing project-management capability if it can satisfy the following minimum tests:

1. Create a task.
2. Assign an owner.
3. Record required inputs and acceptance criteria.
4. Change task status.
5. Record a blocker.
6. Associate a task with a project.
7. Record review or approval.
8. Preserve the completion evidence.
9. Identify the next owner.
10. Retrieve the task later.

If it fails these tests, determine whether a small repair is sufficient.

Do not install a separate project-management platform merely because the existing module is incomplete.

## 9.7 Paid service requirement

**Not established.**

## 9.8 Priority

**P1.**

The initial workflow can remain partly manual as long as accountability and task status are reliable.

---

# 10. Analysis and Deliverable Generation

## 10.1 Business purpose

Transform reviewed evidence into findings, interpretations, recommendations, and client deliverables.

## 10.2 Pipeline support

Primarily:

* H. Analysis &amp; Authority Reconstruction.
* I. Deliverables, Review &amp; Client Acceptance.

Also supports:

* C. Marketing &amp; Authority Development.
* J. Retention &amp; Continuing Authority Management.

## 10.3 Required inputs

* Approved project scope.
* Reviewed evidence package.
* Applicable methodology.
* Client objectives.
* Current business context, where relevant.
* Required deliverable structure.
* Acceptance criteria.

## 10.4 Expected outputs

* Analytical findings.
* Evidence-linked interpretations.
* Recommendations.
* Executive summaries.
* Research reports.
* Client-facing documents.
* Supporting appendices.
* Review and revision records.

## 10.5 Existing capability

**Status: Manual capability available; integrated workflow unverified.**

The Founder can use an accessible LLM and existing document tools to prepare drafts.

The handoff does not establish that the Command Center can reliably generate, store, version, review, and release complete deliverables.

## 10.6 Low-cost implementation

Begin with:

* Document templates.
* Structured analytical prompts.
* A defined review checklist.
* Consistent file naming.
* Source references.
* A clear draft, review, and approved status.
* A controlled delivery procedure.

The output should be created in a format the Founder can inspect and edit.

The system should preserve the distinction between:

* Draft.
* Submitted for review.
* Revised.
* Approved.
* Delivered.

## 10.7 Paid service requirement

**Not established.**

A document-generation subscription or custom AI integration should not be purchased until the existing workflow has been tested.

## 10.8 Security considerations

Client-facing documents must be reviewed for:

* Confidential information.
* Unsupported claims.
* Incorrect source references.
* Accidental disclosure of other clients' information.
* Unauthorized commitments.
* Unapproved conclusions.

## 10.9 Priority

**P1.**

---

# 11. Client Management, Contracting, and Payment Processing

## 11.1 Business purpose

Move a qualified prospect through engagement approval, contracting, payment, onboarding, delivery, and closure.

## 11.2 Pipeline support

Primarily:

* D. Outreach &amp; Sales.
* E. Contracting, Payment &amp; Onboarding.
* I. Deliverables, Review &amp; Client Acceptance.
* J. Retention &amp; Continuing Authority Management.
* K. Finance &amp; Administration.

## 11.3 Required capabilities

The workflow needs to distinguish:

* Proposal drafted.
* Proposal approved.
* Proposal issued.
* Proposal accepted.
* Contract drafted.
* Contract approved.
* Contract executed.
* Invoice or payment request issued.
* Payment pending.
* Payment confirmed.
* Engagement authorized.
* Client onboarding complete.

These are separate states.

## 11.4 Existing capability

**Status: Reported payment module; commercial and operational correctness unverified.**

The handoff reports a payment module and previously observed discrepancies between public pricing and payment-module values.

Those figures have not been independently verified as current prices, and the Founder has stated that the commercial structure remains exploratory.

Therefore, no previously reported price should be treated as the authoritative commercial configuration.

## 11.5 Low-cost implementation

Before accepting real payments:

1. Establish the actual approved service offerings.
2. Establish the approved price or pricing method for each offering.
3. Establish scope and exclusions.
4. Define payment milestones and conditions.
5. Verify the payment provider and account configuration.
6. Verify how successful transactions are confirmed.
7. Verify that failed or pending payments are not treated as received.
8. Verify refunds and cancellation handling.
9. Ensure the Command Center reflects the approved terms.
10. Test the entire process using an appropriate test mode where available.

A payment processor can handle transaction mechanics. It does not replace the need for correct service definitions, contracts, and approval controls.

## 11.6 Paid service requirement

A payment processor may be necessary when LEGAiSEE begins accepting electronic payments.

The exact provider and configuration should be selected only after the Founder establishes the commercial model.

A paid automation platform is not required merely to generate an invoice or record a payment.

## 11.7 Security considerations

Payment credentials and sensitive financial data must not be exposed to the LLM.

The application should rely on the payment provider's appropriate transaction mechanisms rather than treating a browser return page or manually supplied message as definitive payment confirmation.

## 11.8 Priority

**P0 for the payment workflow before accepting real payments.**

Proposal preparation and prospecting can proceed separately.

---

# 12. Email, Calendar, and External Communications

## 12.1 Business purpose

Support prospect outreach, appointment scheduling, follow-up, and client communication.

## 12.2 Pipeline support

* A. Market Intelligence &amp; Business Development.
* B. Qualification &amp; Lead Management.
* C. Marketing &amp; Authority Development.
* D. Outreach &amp; Sales.
* E. Contracting, Payment &amp; Onboarding.
* I. Deliverables, Review &amp; Client Acceptance.
* J. Retention &amp; Continuing Authority Management.

## 12.3 Existing capability

**Status: External account availability and application integration unverified.**

The current handoff does not establish a working email or calendar integration in the Command Center.

## 12.4 Low-cost implementation

Initially:

1. Draft communications using the approved role procedures.
2. Review them before sending.
3. Send through the existing authorized email account.
4. Record the actual send status.
5. Record replies and next actions.
6. Schedule follow-ups using the existing calendar or task system.

This procedure requires no new automation platform.

## 12.5 Future integration

Email and calendar integration may be useful when manual volume becomes significant.

Before implementing it, define:

* Which accounts may be accessed.
* Which messages may be read.
* Whether the AI may draft or send.
* Which messages require approval.
* How correspondence is associated with prospects and clients.
* How sensitive content is handled.
* How actions are logged.

## 12.6 Paid service requirement

**Not established.**

Use existing services and manual workflows initially.

## 12.7 Priority

**P2 for integration; P1 for the underlying outreach and follow-up process.**

---

# 13. Financial Administration

## 13.1 Business purpose

Maintain reliable records of revenue, expenses, payment obligations, and operating costs.

## 13.2 Pipeline support

Primarily K. Finance &amp; Administration.

Also supports:

* D. Outreach &amp; Sales.
* E. Contracting, Payment &amp; Onboarding.
* L. Internal Technology &amp; System Operations.

## 13.3 Required inputs

* Approved invoices.
* Payment records.
* Expenses.
* Receipts.
* Refunds.
* Subscription costs.
* Hosting costs.
* Other business transactions.

## 13.4 Expected outputs

* Transaction register.
* Expense categories.
* Revenue records.
* Outstanding payment records.
* Operating-cost summary.
* Basic cash-flow visibility.
* Supporting documentation.

## 13.5 Existing capability

**Status: Unverified.**

The handoff identifies a payment module, but it does not establish that a complete financial-administration workflow exists.

Payment processing and financial accounting are related but distinct functions.

## 13.6 Low-cost implementation

Start with a simple, controlled financial record.

For each transaction, record:

* Date.
* Transaction ID or reference.
* Category.
* Description.
* Amount.
* Status.
* Supporting document.
* Related client or project, where relevant.
* Reconciliation status.

Use existing financial software or a properly maintained spreadsheet if the Command Center does not yet provide the required capability.

Do not build a full accounting system into LEGAiSEE unless actual requirements justify it.

## 13.7 Paid service requirement

**Not established for initial operations.**

The business may eventually benefit from dedicated accounting software or professional accounting support, depending on transaction volume and reporting requirements.

## 13.8 Priority

**P1.**

---

# 14. Security, Backup, Recovery, and Monitoring

## 14.1 Business purpose

Protect the application, data, client information, and continuity of operations.

This capability is foundational because the business depends on evidence and historical records that may be difficult or impossible to recreate.

## 14.2 Pipeline support

Primarily:

* K. Finance &amp; Administration.
* L. Internal Technology &amp; System Operations.

It also supports every client-facing pipeline.

## 14.3 Required capabilities

### Identity and access

* Authentication.
* Server-side authorization.
* Appropriate client separation.
* Restricted administrative access.
* Controlled AI and API permissions.

### Application security

* Safe error handling.
* Input validation.
* Secure file handling.
* Protected secrets.
* Appropriate session management.
* Controlled database operations.

### Backup and recovery

* Database backups.
* File backups.
* Configuration backups where appropriate.
* Backup retention.
* Independent copies.
* Recovery procedures.
* Periodic restoration tests.

### Monitoring

* Application error logs.
* Failed workflow visibility.
* Backup status.
* Resource and availability monitoring.
* Security-related alerts where feasible.

## 14.4 Existing capability

**Status: Partially reported; current operational effectiveness unverified.**

The handoff identifies a hosting environment and reported hosting backup functionality.

It also records prior observations of PHP warnings that may expose server-side paths and line numbers.

Those observations warrant investigation but do not establish that the system has been compromised.

The actual backup contents, retention, recoverability, authentication, authorization, and error-handling controls remain unverified.

## 14.5 Low-cost implementation

Begin with a focused security and recovery review.

Verify:

1. Whether all Command Center routes require appropriate authentication.
2. Whether server-side authorization protects every relevant operation.
3. Whether APIs enforce equivalent permissions.
4. Whether clients are restricted to their own records.
5. Whether uploaded files are stored and served safely.
6. Whether production errors expose sensitive implementation details.
7. Whether database credentials and other secrets are protected.
8. Whether backups cover the required files and databases.
9. Whether backups can be restored.
10. Whether the restored system can operate.

Do not rely solely on the existence of an automatic hosting backup.

A backup is useful only if it contains the required data and can be recovered.

## 14.6 Paid service requirement

**No additional security subscription is established as necessary.**

Use available hosting controls, application-level protections, and independent backups where feasible.

Additional services should be considered only when a specific security or recovery requirement cannot be met adequately with the existing environment.

## 14.7 Priority

**P0.**

Security and recovery controls must be established before sensitive client records are exposed to an unverified system.

---

# 15. Searchable Business Memory and Relationship Analysis

## 15.1 Business purpose

Preserve business knowledge across projects and over time.

The longer-term vision includes a persistent memory of evidence, findings, business changes, and relationships.

That capability should evolve from dependable evidence and recordkeeping rather than being treated as a prerequisite for initial revenue.

## 15.2 Pipeline support

* F. Evidence Acquisition &amp; Excavation.
* G. Evidence Processing &amp; Verification.
* H. Analysis &amp; Authority Reconstruction.
* I. Deliverables, Review &amp; Client Acceptance.
* J. Retention &amp; Continuing Authority Management.

## 15.3 Required capabilities

Potential requirements include:

* Searchable artifact records.
* Searchable claims and findings.
* Links between businesses and historical entities.
* Relationships between artifacts and claims.
* Historical state changes.
* Approved analytical findings.
* Client and project context.
* Retrieval of relevant prior work.

## 15.4 Existing capability

**Status: Reported components; functionality unverified.**

The handoff identifies `KnowledgeSystem`, entity-resolution functionality, relationship or graph capabilities, and a `brain` module as potential existing components.

Their actual behavior and suitability remain unknown.

## 15.5 Low-cost implementation

First establish the authoritative records and relationships in the existing MySQL environment.

Then test whether the current system can:

1. Find a business by name or identifier.
2. Retrieve its artifacts.
3. Retrieve associated claims.
4. Identify verification status.
5. Find related entities.
6. Retrieve approved findings.
7. Distinguish historical findings from current business information.
8. Preserve changes over time.

If those functions work, improve them incrementally.

If they do not, repair the specific missing capability.

Do not assume that a graph database, vector database, or specialized memory platform is required.

## 15.6 Optional future capabilities

Potential future additions include:

* Semantic search.
* Automated entity resolution.
* Relationship visualization.
* Change detection.
* Cross-project analytical retrieval.
* Carefully scoped retrieval-augmented generation.

These are future options, not launch prerequisites.

## 15.7 Paid service requirement

**Not established.**

A specialized database or managed search service should be considered only after the limitations of the existing architecture are demonstrated.

## 15.8 Priority

**P2 for advanced retrieval and relationship analysis.**

The underlying evidence records remain P1.

---

# 16. Agent Orchestration and Tool Execution

## 16.1 Business purpose

Allow AI roles to perform authorized operations through software rather than merely describing what should be done.

## 16.2 The critical distinction

An LLM can generate a proposed action.

An execution mechanism performs the action.

A reliable workflow records whether the action succeeded.

These are separate capabilities.

For example:

* Drafting a prospect record is not saving it to the database.
* Producing SQL is not executing the SQL.
* Generating an email is not sending it.
* Producing a payment status summary is not confirming payment.
* Writing a PHP change is not deploying or testing it.

## 16.3 Existing capability

**Status: Unverified.**

The handoff identifies `ai_process.php`, the Command Center, API routes, and other application components.

Their current ability to execute authorized actions has not been verified.

## 16.4 Low-cost implementation

Initially use explicit, manually supervised handoffs.

For each task:

1. The Founder or Producer defines the objective.
2. The Director prepares the task.
3. The relevant operator produces the output.
4. A reviewer evaluates the result.
5. An authorized person or verified tool performs any required external action.
6. The actual outcome is recorded.

Only automate a specific action after its manual procedure is stable.

## 16.5 When orchestration becomes justified

A tool-enabled workflow becomes worthwhile when:

* The task recurs frequently.
* Inputs and outputs are sufficiently standardized.
* The workflow has clear failure conditions.
* The necessary permissions can be restricted.
* The result can be verified.
* Automation saves meaningful time.
* Recovery is practical.

## 16.6 Paid service requirement

**Not established.**

Do not purchase an orchestration platform merely to create six AI roles.

## 16.7 Priority

**P3 for autonomous orchestration.**

Simple, verified tool execution may be introduced earlier when a specific operational need justifies it.

---

# 17. Minimum Tool Configuration by Role

The following table identifies the minimum practical toolset for each role.

| Role | Essential capabilities | Initial implementation |
| --- | --- | --- |
| Founder | Business records, prospect status, task review, decision records, financial visibility | Existing Command Center where verified; otherwise controlled manual records |
| L4 Producer | Project briefs, priorities, acceptance criteria, resource and risk assessment | Role prompt plus task/project records |
| L3 Director | Task assignment, status tracking, output review, handoff management | Existing project-management module if verified; otherwise a simple task register |
| L2 Research Operator | Browser research, artifact collection, text extraction, evidence records | Browser, local document tools, and approved evidence records |
| L2 Analysis Operator | Reviewed evidence, approved methodologies, document drafting, quality control | General-purpose LLM and document templates |
| L1 Assistant | Record preparation, file organization, checklists, formatting, status updates | Reusable procedures and existing approved storage |

This is a functional toolset, not a requirement to buy one product per role.

The same browser, LLM, database, and document tools may support several roles.

---

# 18. Capability Mapping to the 12 Operating Pipelines

This section consolidates the preceding inventory into the business-process structure established in Part 1.

## Pipeline A — Market Intelligence &amp; Business Development

**Required capabilities**

* Public-source research.
* Prospect discovery.
* Historical relevance assessment.
* Business record preparation.
* Qualification and prioritization.

**Primary roles**

Producer, Research Operator, Analysis Operator, Assistant.

**Existing candidates**

Command Center prospect or client functionality, research tools, and any relevant existing records.

**Status**

The research process can begin manually. The integrated prospecting workflow remains unverified.

**Priority**

P1.

## Pipeline B — Qualification &amp; Lead Management

**Required capabilities**

* Prospect records.
* Qualification criteria.
* Opportunity status.
* Follow-up scheduling.
* Source-linked qualification evidence.

**Primary roles**

Founder, Producer, Director, Assistant.

**Existing candidates**

Project-management, client-management, or CRM-related functionality, if present and suitable.

**Status**

Unverified.

**Priority**

P1.

## Pipeline C — Marketing &amp; Authority Development

**Required capabilities**

* Approved business positioning.
* Content and communication drafting.
* Evidence-backed claims.
* Content review.
* Publication approval.

**Primary roles**

Founder, Producer, Analysis Operator, Assistant.

**Existing candidates**

The general-purpose LLM, approved methodology, document templates, and existing public-facing materials.

**Status**

Drafting is possible manually. A complete marketing workflow is unverified.

**Priority**

P1 for basic business development; advanced automation can wait.

## Pipeline D — Outreach &amp; Sales

**Required capabilities**

* Prospect prioritization.
* Communication drafting.
* Approval.
* Sending and status recording.
* Follow-up management.
* Proposal preparation.

**Primary roles**

Founder, Producer, Director, Assistant.

**Existing candidates**

Existing email account, calendar, and prospect records.

**Status**

Manual workflow is feasible; application integration is unverified.

**Priority**

P1.

## Pipeline E — Contracting, Payment &amp; Onboarding

**Required capabilities**

* Approved service definitions.
* Proposal and contract records.
* Approval tracking.
* Payment requests.
* Verified payment status.
* Client onboarding records.

**Primary roles**

Founder, Producer, Director, Assistant.

**Existing candidates**

Reported payment module and existing client-related functionality.

**Status**

Unverified; previously reported pricing discrepancies require resolution.

**Priority**

P0 for accepting real payments or onboarding clients through an unverified workflow.

## Pipeline F — Evidence Acquisition &amp; Excavation

**Required capabilities**

* Artifact collection.
* Source provenance.
* Document storage.
* Text extraction.
* Research logs.
* Evidence organization.

**Primary roles**

Research Operator, Assistant, Director.

**Existing candidates**

Reported ingestion-related functionality and existing database structures.

**Status**

Unverified.

**Priority**

P1.

## Pipeline G — Evidence Processing &amp; Verification

**Required capabilities**

* Claim extraction.
* Source comparison.
* Provenance.
* Source-independence assessment.
* Contradiction handling.
* Verification status.
* Review records.

**Primary roles**

Research Operator, Director, Analysis Operator.

**Existing candidates**

Reported Dig Review, knowledge, and relationship-related components.

**Status**

Unverified.

**Priority**

P1.

## Pipeline H — Analysis &amp; Authority Reconstruction

**Required capabilities**

* Retrieval of reviewed evidence.
* Approved methodological frameworks.
* Analytical findings.
* Interpretation and recommendation records.
* Source-linked deliverables.

**Primary roles**

Analysis Operator, Director, Producer.

**Existing candidates**

The LLM capability, `KnowledgeSystem`, and existing application components.

**Status**

Manual analysis is feasible. Integrated analytical workflows are unverified.

**Priority**

P1.

## Pipeline I — Deliverables, Review &amp; Client Acceptance

**Required capabilities**

* Document templates.
* Version control or version records.
* Review and correction.
* Founder approval.
* Delivery confirmation.
* Client acceptance records.

**Primary roles**

Analysis Operator, Director, Producer, Founder.

**Existing candidates**

Existing document tools and project-management functionality.

**Status**

Manual delivery is feasible. Integrated workflow remains unverified.

**Priority**

P1.

## Pipeline J — Retention &amp; Continuing Authority Management

**Required capabilities**

* Client records.
* Historical findings.
* Continuing project records.
* Follow-up dates.
* Change tracking.
* Future research opportunities.

**Primary roles**

Founder, Producer, Research Operator, Analysis Operator.

**Existing candidates**

Existing client records, database structures, and relationship-related functionality.

**Status**

Unverified.

**Priority**

P2 after the initial acquisition and delivery process is dependable.

## Pipeline K — Finance &amp; Administration

**Required capabilities**

* Financial transaction records.
* Expense tracking.
* Invoice and payment records.
* Administrative documentation.
* Cost visibility.

**Primary roles**

Founder, Assistant.

**Existing candidates**

Reported payment functionality and existing recordkeeping tools.

**Status**

Unverified.

**Priority**

P1, with payment controls addressed before accepting payments.

## Pipeline L — Internal Technology &amp; System Operations

**Required capabilities**

* Application security.
* Backup and recovery.
* Error monitoring.
* Deployment controls.
* Database maintenance.
* Technical change records.
* AI execution controls.

**Primary roles**

Founder and authorized technical support.

**Existing candidates**

Current hosting environment, PHP application, MySQL database, and reported backup facilities.

**Status**

The architecture is identified, but operational security and recovery remain unverified.

**Priority**

P0 for security and recovery.

---

# 19. Software and Tool Selection Rules

The following rules govern future additions.

## Rule 1 — Reuse before replacing

Before adding a new tool, establish whether an existing LEGAiSEE component can perform the required function.

If it cannot, determine whether a small repair or extension is sufficient.

## Rule 2 — Prefer one authoritative record

Avoid maintaining separate permanent records of the same prospect, project, claim, or client in multiple systems.

Where temporary copies are necessary, define which record is authoritative.

## Rule 3 — Separate preparation from execution

A model that drafts an action does not establish that the action occurred.

Use explicit status transitions and actual execution evidence.

## Rule 4 — Prefer reversible, low-risk operations

Early automation should emphasize reading, preparing, organizing, and validating.

Actions that send communications, modify production data, expose sensitive information, or create commercial commitments require stronger controls.

## Rule 5 — Establish the procedure before automating it

If a manual process cannot be described clearly, it is not ready for reliable automation.

## Rule 6 — Evaluate actual task performance

Do not select an LLM or tool solely because it is popular, highly ranked, or marketed for agents.

Test it against representative LEGAiSEE work.

## Rule 7 — Account for the full cost

Evaluate:

* Subscription costs.
* API usage.
* Storage.
* Hosting.
* Maintenance.
* Integration effort.
* Failure recovery.
* Manual correction time.
* Data-handling implications.

A nominally free tool may be more expensive in practice if it introduces substantial rework.

## Rule 8 — Do not build a feature without an operational owner

Every new capability needs a defined purpose, accountable owner, acceptance criteria, and maintenance expectation.

## Rule 9 — Do not confuse technical possibility with business necessity

A graph database, vector database, multi-agent framework, client portal, or autonomous workflow may be technically feasible without being commercially justified.

## Rule 10 — Preserve Founder control

The Founder approves material changes to the operating model, consequential external actions, and expansions of autonomy.

---

# 20. Implementation Sequence

The recommended implementation order is as follows.

## Stage 1 — Establish safety and source-of-truth controls

**Objective:** Prevent avoidable loss, unauthorized access, and confusion about which records are authoritative.

Tasks:

1. Confirm the authoritative server version.
2. Verify backup coverage.
3. Perform a restoration test.
4. Review authentication and authorization.
5. Verify API access controls.
6. Check production error handling.
7. Establish a controlled procedure for production changes.

**Acceptance criteria**

* The required data and files are covered by backups.
* Restoration has been demonstrated.
* Relevant routes enforce appropriate permissions.
* Known security defects are documented.
* The authoritative production version is identified.

**Priority:** P0.

## Stage 2 — Establish the minimum revenue workflow

**Objective:** Enable controlled prospecting, qualification, outreach, and follow-up.

Tasks:

1. Establish qualification criteria.
2. Verify or establish prospect records.
3. Establish research procedures.
4. Define outreach approval.
5. Establish follow-up tracking.
6. Create a minimal proposal-preparation procedure.

**Acceptance criteria**

A candidate business can be identified, researched, documented, qualified, and assigned a next action without losing its source references or status.

**Priority:** P1.

## Stage 3 — Establish the minimum evidence workflow

**Objective:** Demonstrate that LEGAiSEE can produce traceable research.

Tasks:

1. Verify the existing ingestion and evidence capabilities.
2. Establish artifact records.
3. Establish claim records.
4. Establish verification statuses.
5. Establish contradiction handling.
6. Test evidence review.
7. Confirm that the analysis process can retrieve supporting evidence.

**Acceptance criteria**

A research package can be produced and reviewed without confusing original evidence, extracted claims, and verified findings.

**Priority:** P1.

## Stage 4 — Establish the minimum analytical workflow

**Objective:** Convert accepted evidence into a useful, defensible business deliverable.

Tasks:

1. Select a representative test case.
2. Prepare the accepted evidence package.
3. Apply the appropriate documented methodology.
4. Draft the analytical findings.
5. Perform quality review.
6. Correct defects.
7. Obtain Founder approval.

**Acceptance criteria**

The resulting document addresses the objective, supports its material claims, discloses limitations, and passes review.

**Priority:** P1.

## Stage 5 — Verify the commercial workflow

**Objective:** Ensure that actual client engagements can be authorized and administered safely.

Tasks:

1. Establish the approved service definitions.
2. Confirm pricing and payment conditions.
3. Resolve discrepancies in the existing payment configuration.
4. Test transaction status handling.
5. Establish contract and onboarding records.
6. Establish final delivery and acceptance procedures.

**Acceptance criteria**

No client is accepted through a workflow with unapproved terms or unverified payment status.

**Priority:** P0 before accepting payments or beginning engagements that depend on the unverified process.

## Stage 6 — Improve operational efficiency

**Objective:** Reduce repetitive work after the basic process is dependable.

Potential improvements:

* More reliable task records.
* Automated document extraction.
* Standardized evidence packages.
* Reusable analytical templates.
* Improved search.
* Routine administrative automation.

**Acceptance criteria**

Each improvement demonstrably reduces effort, correction time, or operational risk without creating a competing system.

**Priority:** P2.

## Stage 7 — Introduce advanced automation selectively

**Objective:** Automate proven, repetitive workflows.

Potential improvements:

* Bounded AI tool execution.
* Automated task routing.
* Controlled research-package generation.
* More advanced retrieval.
* Continuing authority monitoring.

**Acceptance criteria**

The process has documented inputs, outputs, permissions, failure handling, and measurable benefits.

**Priority:** P3.

---

# 21. Required Capability Verification Tests

Before implementation decisions are made, the existing Command Center should be evaluated against a concise test set.

These tests establish what can be reused.

They are not a substitute for a full security audit.

## Test A — Project management

Verify that the system can create, retrieve, update, and complete a task with an owner, status, acceptance criteria, and supporting record.

## Test B — Prospect management

Verify that the system can create a prospect, associate research references, update qualification status, and record the next action.

## Test C — Evidence ingestion

Verify that a permitted document can be received, stored, referenced, and retrieved without losing its identity or provenance.

## Test D — Evidence review

Verify that a claim can be associated with a source, assigned a review status, and returned for correction or accepted.

## Test E — Analytical traceability

Verify that an analytical finding can reference the evidence supporting it.

## Test F — Client separation

Verify that one client cannot access another client's records through the interface or direct API requests.

## Test G — Payment workflow

Using the appropriate test environment, verify that the application distinguishes successful, failed, pending, and unconfirmed transactions.

## Test H — Backup restoration

Restore the relevant files and databases into an appropriate test environment and confirm that the restored application can operate.

## Test I — Error handling

Verify that failures are logged appropriately without exposing sensitive implementation details to unauthorized users.

## Test J — Completion integrity

Verify that failed actions are not reported as successful and that task status reflects actual execution.

For every test, record:

* Test identifier.
* Date.
* Environment.
* Starting conditions.
* Procedure.
* Expected result.
* Actual result.
* Evidence.
* Defects.
* Corrective action.
* Retest result.

A test should not be marked Passed based on an assumption or an AI-generated description of what the software should do.

---

# 22. What LEGAiSEE Does Not Need Yet

The following capabilities may become useful but are not launch prerequisites.

## 22.1 A separate AI agent for every role

The six roles can initially be performed through one general-purpose model using different instructions.

Separate agents should be introduced only when the benefit is demonstrated.

## 22.2 A dedicated orchestration subscription

The initial workflows can use structured prompts and controlled manual handoffs.

Automation can follow.

## 22.3 A second CRM

The existing Command Center should be evaluated before another permanent prospect database is introduced.

## 22.4 A separate project-management platform

Reuse the existing project-management functionality if it can be made dependable.

## 22.5 A specialized graph database

The existing relational database may be sufficient for the initial evidence and relationship model.

## 22.6 A specialized vector database

Advanced semantic retrieval should be justified by actual search limitations.

## 22.7 Automated bulk ingestion of every artifact type

Start with the formats required for the initial business process.

Add formats as real projects demand them.

## 22.8 An autonomous client portal

A portal should follow demonstrated client requirements and verified access controls.

## 22.9 A fully automated business

LEGAiSEE does not need autonomous commercial decisions, unreviewed client deliverables, or unrestricted external actions to begin operating.

## 22.10 A complete implementation of the long-term vision

The long-term business-memory and authority-system vision can evolve from the operational records created by actual work.

It does not need to be completed before the first controlled engagement.

---

# 23. Final Capability Decision

The initial LEGAiSEE operating model should use the following configuration:

**One Founder. One general-purpose LLM capability. Six defined functional roles. One authoritative operating environment. Verified tools. Explicit human approval.**

The initial capability priorities are:

1. Protect the system and establish recoverable backups.
2. Establish a dependable prospecting and qualification process.
3. Establish traceable evidence acquisition and verification.
4. Establish a defensible analysis and deliverable workflow.
5. Verify the commercial and payment process before using it for real transactions.
6. Improve task coordination and administrative efficiency.
7. Introduce automation only when the underlying procedure is dependable.

The existing Command Center remains the intended operational home, subject to verification.

No new database, CRM, orchestration platform, or major infrastructure component should be introduced without a demonstrated requirement.

The operating model must support the business before it attempts to automate the business.

**The next deliverable is Part 5 — Existing Command Center Capability Audit.**

Part 5 must determine which capabilities are actually present, which work, which are incomplete, and which need repair. It must use the authoritative server version and avoid claiming code inspection or test results that have not actually occurred.