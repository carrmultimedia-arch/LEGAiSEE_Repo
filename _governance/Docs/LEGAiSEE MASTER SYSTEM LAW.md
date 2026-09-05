LEGAiSEE
MASTER SYSTEM LAW
The Build Table of Contents — Version 1.0
Prepared for John Carr · LEGAiSEE / Carr Multimedia
 
Governing Principle
The Law: This document is the single source of truth for what LEGAiSEE is, structurally, end to end. Once approved, work proceeds by opening this document, finding the next unbuilt or broken item, and building only that. Changes to this document happen only as corrections to bugs discovered during execution, or as explicit, deliberate revisions John approves. Nothing gets added because it seemed like a good idea mid-build. Future ideas become a v2 note, not a detour.
The Pipeline: Claude thinks. The executor builds. John approves. Nobody improvises.
The Format: All code changes are delivered as complete replacement files with explicit paths. No patches, no diffs, no snippets, unless John explicitly asks otherwise.

Document Map
This Master Law is organized in the order the system should be built, not the order problems happened to surface. Each Part below corresponds to a layer of the LEGAiSEE OS. Lower layers must be stable before upper layers are trustworthy — a broken Identity layer (Part II) will produce confusing bugs in every layer built on top of it, so it is built first.
Part I — What LEGAiSEE Is (Business Definition)
Part II — The Identity Layer (The File Tree / Node System)
Part III — The Operation Ladder (Client Lifecycle)
Part IV — System Divisions (LEGAiSEE / Private / Operations)
Part V — Intake & Excavation (The Brain Pipeline)
Part VI — The Public Site (legaisee.com)
Part VII — The Command Center (Internal Backend)
Part VIII — Methodology & Doctrine (Locked Reference Content)
Part IX — Known Issues & Active Bugs
Part X — Out of Scope for v1 (The v2 List)
Appendix A — Glossary of LEGAiSEE Terms
Appendix B — Server & Path Reference

Part I — What LEGAiSEE Is
LEGAiSEE is a solo-practice, luxury B2B consultancy built around a proprietary methodology called Business Archaeology: the forensic excavation of a long-running company's own institutional history — its abandoned assets, its proven-but-forgotten positioning, its Golden Era patterns — followed by the disciplined reconstruction of that signal into a present-day Authority System.
The practice does not invent marketing messages. It recovers messages the client's own history already proved, grades the evidence behind them on a four-tier confidence scale, and rebuilds them into a living system the client can deploy today.
1.1 Target Client
Businesses operating 5–10+ years, OR family/generationally owned, OR $30M+ revenue.
Primarily located along the San Antonio / Austin I-35 corridor.
Capacity is deliberately capped — LEGAiSEE operates with a small number of concurrent clients by design, not as a growth constraint to be solved.
1.2 The Core Metaphor
Every engagement is narrated through a single continuous gemstone metaphor, used consistently across the website, the methodology, and client-facing deliverables:
Stage 0 — Natural Habitat: the institutional history, undiscovered, where the asset still sleeps.
Stage 1 — Raw Stone: the asset excavated, pulled from the archive, uncut.
Stage 2 — Cut & Shaped: the Lapidary phase — refined into a strategic instrument.
Stage 3 — Mounted: set into the Authority System / Master Operations Doctrine.
Stage 4 — Museum Display: delivered, verified, and presented as restored public authority.
This metaphor is canon. It appears in site copy, in the Command Center's internal language where relevant, and in client deliverables. It is not decorative — it is the structural narrative of every Exhibit.
1.3 The Bedrock Pledge (Operating Principles)
Pillar I: Every word is sacred. No claim is invented. Every claim is either excavated from the client's own record or synthesized through triangulation from verified sources.
Pillar II: The 3-Source Rule. No significant claim is published without two independent sources, or one Tier 1 verified primary source.
Pillar III: Continuous Verification. New evidence after delivery is welcomed, not resisted, and is incorporated through addenda — never silently, never defensively.
1.4 The Hierarchy of Truth
Component
Status
Notes
Tier 1 — Verified Primary
—
Irrefutable documented evidence: signed filings, dated financial records, original physical media.
Tier 2 — Probable
—
Highly credible secondary sources: internal reports, consistent trade-press coverage.
Tier 3 — Plausible
—
Reasonable inference supported by context; a thread worth pulling, not yet a foundation.
Tier 4 — Uncertain
—
Speculative or directly conflicting; recorded transparently, never hidden.

This same Tier 1–4 grading system is the confidence model the Brain pipeline (Part V) must eventually apply to every excavated artifact, and the language the client-facing Dossier (brain_dossier.php) must speak in.

Part II — The Identity Layer (The File Tree / Node System)
Founding Mandate: “Essentially whole system needs to be based on a usual file tree system. I need full control of where things are stored.” — John Carr. This requirement is not a feature request; it is the foundational layer every other part of this document depends on. It is built first.
2.1 The Problem This Solves
Prior to this layer, intake fed a flat bucket with no organizational structure, requiring search.php to locate anything. Separately, client identity was fragmented across three incompatible schemes: client_id/case_id (used by network_add_node.php), brain_id (used by the nine Brain pipeline files), and raw prospect rows in prospect_ingests (MySQL). None of these referenced each other. This layer replaces all three with one identity system.
2.2 The Node Model
Every client, project, sub-project, and individual work item — without exception — is represented as a single row in one table: tree_nodes. A client is a node with no parent. A project under that client is a node whose parent is the client. An individual item (“Find a Doc Interview Dr. Smith”) is a node whose parent is the project above it. Depth is unlimited and is never hard-coded into the schema.
2.2.1 Schema — tree_nodes
Component
Status
Notes
node_id
PK, auto-increment
Universal ID. Replaces client_id, case_id, and brain_id as separate concepts.
parent_id
Nullable FK → node_id
Null for top-level (client) nodes.
name
varchar
Human-entered label — what John types into the text box.
node_type
enum/varchar
client / project / subproject / item — informs UI rendering, never restricts depth.
sort_order
int
Preserves intentional ordering (“1. Tour, 2. Interview, 3. Social”) — not alphabetical.
created_at
datetime


updated_at
datetime



2.2.2 API — api/tree.php
create — add a node under a given parent_id (or null for a new top-level client).
rename — update a node's name.
move — change a node's parent_id (re-parent in the tree).
delete — remove a node. Default behavior: BLOCK deletion if the node has children, and surface a clear warning, rather than silently cascading. This prevents accidental loss of an entire client's tree.
get_tree — fetch the full subtree for a given node_id (or all top-level nodes if none given), for UI rendering.
2.3 Migration of Existing Data
The three live prospects currently in prospect_ingests (Brad Moore Builders, Faust Hotel, Cowboy Plumbing) are migrated once, becoming the first three top-level nodes in tree_nodes. prospect_ingests gains a node_id column referencing this new table rather than being replaced outright — preserving existing data while establishing the new system as the single source of truth going forward.
2.4 Everything Else Attaches to a Node
This is the rule that makes the rest of this document coherent. No new feature, table, or pipeline stage is permitted to invent its own identity scheme. Each part below states explicitly how it attaches to node_id.
Component
Status
Notes
intake.php (Part V)
Pending rebuild
Captures the interview, attaches result to a node_id.
Brain pipeline (Part V)
Pending revision
Every stage reads/writes against node_id, not file + brain_id in isolation.
network_add_node.php (Part V)
Fixed, pending re-point
Task queue folds into tree.php's node operations; queue path keys off node_id.
search.php (Part VII)
Pending demotion
Becomes secondary filter on top of tree browsing, not the primary retrieval method.


Part III — The Operation Ladder (Client Lifecycle)
This is the literal sequence a real prospect moves through, end to end, as stated directly by John. Each rung below should ultimately correspond to a node_type or a node state within the tree, and to a concrete deliverable the system must be able to generate.
3.1 Lead Generation
Prospecting businesses with the history and revenue profile to qualify for Business Archaeology.
3.2 Dig Site Surface Scrape
Initial contact with a quick surface-scrape lead magnet — a single found artifact with relevance description and possible future use — pitching the Shallow Dig ($2,500).
3.3 Shallow Dig — $2,500
Upon payment: estimated Golden Era, 1–3 surfaced assets, competitive gap mapping, one undeniable inflection point, one excavation brief for Exhibit selection. Purpose: determine whether the business has enough history to warrant full excavation. Delivered live (in person or via call), followed by a pitch into the full system.
3.4 Full Signal Excavation
Full historical record audit, proof-point extraction and cataloguing, primary signal architecture, foundational positioning statement. (Maps to Exhibit A, $5,000–$7,500.)
3.5 Full Institutional Record
Complete institutional timeline, abandoned-asset recovery, competitive intelligence integration, revenue-leak detection review, full positioning and narrative system. (Maps to Exhibit B, the Lapidary / Authority System Build, $8,500–$18,000.)
3.6 Institutional Signal Retainer
Ongoing excavation, signal maintenance, strategic positioning continuity: monthly signal audit, competitive landscape monitoring, proof-point library maintenance, strategic advisory. (Maps to Exhibit C, The Mounting, from $4,500/month.)
3.7 Enterprise Commissions
Enterprise Signal Retainer — full-scale forensic management: institutional reputation recovery, full competitive forensic monitoring, enterprise positioning, mission clarity architecture, monthly board-ready report, Forensic CAC / LTV:CAC 3:1 audit.
The Permanent Record — quarterly full forensic audit, permanent proof-point library, continuous market monitoring, exit-multiple and enterprise-value tracking, quarterly positioning review.
Exhibit D — The CAMERA Authority Framework™ ($6,500–$7,500): Character Positioning, Audience Psychology, Monetization Alignment, Engagement Engineering, Repurposing Infrastructure, AI Acceleration.
Private Commissions — Exhibit E (Master Craftsman's Presence, $18,000/mo), Exhibit F (Estate & Provenance Appraisal, $25,000–$50,000), Exhibit G (The Curator's Secret Intelligence, $35,000/qtr).
3.8 System Implication
Build Requirement: Each rung of this ladder must eventually be representable as a status or milestone on a client's node in the tree — e.g., a client node should be able to show “Shallow Dig delivered, Full Excavation in progress” as a queryable state, not just as a folder of loose files. This is a Part V/VII concern, not Part II's, but Part II's schema must not block it.

Part IV — System Divisions
The system is organized into three top-level divisions, as defined directly by John. These map to access boundaries and top-level tree structure, not separate codebases.
4.1 LEGAiSEE Division — The Business Archaeology Engine
Excavation / Dig / Search Assistant — coordinated multi-model search across the 40+ channel taxonomy to find a specific business's past marketing assets.
The Brain / Operating System — ingests all found material (past marketing, AI chats, etc.), organizes it, connects nodes, finds patterns, analyzes past initiatives against present/future needs.
Builds client-facing Shallow Dig reports, full Dossiers, and complete Dig Reports.
Suggests strategies and actions to move the business from present state to an authoritative future; helps design and build the Authority System the client (or John) executes against.
Continuously monitors all ingests for changes/new input on existing clients; tracks changes against the client's knowledge base; posts updates to the Client Portal so clients can track LEGAiSEE progress, reports, and communications pertaining to them.
Self-monitoring — the system watches its own stability, storage, and efficiency, and surfaces maintenance/upgrade suggestions before any glitch or crash becomes visible.
4.2 Private Division
John's personal section — his own ingests (logged/saved AI chats, LEGAiSEE future goals, growth strategy notes) that the Brain sorts, analyzes, and reports on using the same engine as client work, but walled off from any client-facing surface.
4.3 Operations Division — “Legaisee Operations”
The internal operations side: CRM, billing, email, and the Client Portal itself (the client-facing access point for updates, emails, and texts pertaining to them).
Build Implication: These three divisions are primarily an access-control and top-level-node concern, not three separate applications. Part II's tree_nodes table is shared across all three; division membership is an attribute of the top-level node (or its access rules), not a structural fork.

Part V — Intake & Excavation (The Brain Pipeline)
5.1 Current State (Honest Inventory)
Component
Status
Notes
intake.php
Under-built
Too few entry fields; no node attachment; output destination currently unknown/undocumented.
search.php (×2-3 variants)
Fragmented
Multiple half-working competing UIs; doing the job a tree should do for free.
brain_start.php
Working, isolated
Creates a session keyed by brain_id only; no client/case context.
brain_stream.php / brain_stream_v4.php
Working, isolated
Advances session by brain_id; v4 is a simulated-chunk variant, not yet unified with brain_stream.php.
brain_orchestrator.php
Working, isolated
Calls route_models() against a raw file; no client context; depends on model_router.php (not yet reviewed).
brain_memory_graph.php
Working, isolated
Appends to one global graph.json; no per-client/node segregation.
brain_dossier.php / brain_state.php
Working, isolated
Read session by brain_id; correctly designed to pull from one session record — good pattern to replicate for node_id.
brain_synthesis.php
Working, isolated
Weighting logic is explicitly placeholder (“simplified v1”, random confidence scores) — not yet real.
network_add_node.php
Fixed this session
Single write/single echo, full field validation. Still needs to be re-pointed at node_id (Part II) instead of client_id/case_id.

5.2 The Core Defect
None of the nine Brain files carry, store, or forward client identity. They only ever know file and brain_id. This was not a transport bug in any one file — it is a missing layer underneath all of them. The fix is architectural, not a patch to one endpoint.
5.3 The Fix — Session-Stored Identity
Decision (Locked): brain_start.php is revised to require node_id at session creation and persist it in the session JSON alongside brain_id. Every downstream stage that needs client context (brain_stream, brain_state, brain_dossier, brain_memory_graph, brain_orchestrator, brain_synthesis) loads the session by brain_id and reads node_id from it — never re-collects it from the frontend. This mirrors the pattern brain_dossier.php and brain_state.php already use successfully for brain_id-scoped lookups.
Rationale: a node_id maps to exactly one excavation for the life of that brain_id session. Re-excavation later (a client returns for a follow-up phase) becomes a new node or a new session under the same client node — not a concurrent-case problem requiring its own identity scheme.
5.4 Rebuild Order for This Part
Confirm tree_nodes (Part II) is live before touching any Brain file.
Revise brain_start.php to require and persist node_id.
Revise brain_stream.php, brain_stream_v4.php, brain_orchestrator.php, brain_memory_graph.php, brain_dossier.php, brain_state.php, brain_synthesis.php to read node_id from the session record.
Re-point network_add_node.php's queue path to key off node_id rather than client_id/case_id.
Rebuild intake.php as a real form bound to a node_id, replacing the current under-built version.
Demote search.php to a secondary filter over the tree, once browsing replaces it as primary retrieval.
5.5 Known Open Question
Needs John's Input: brain_synthesis.php's confidence scoring is explicitly a random placeholder (rand(60,95)). This must eventually be replaced with real scoring tied to the Hierarchy of Truth (Part I.4) before any Dossier output is shown to a client. Not blocking for the tree/identity rebuild, but flagged so it isn't mistaken for working logic later.

Part VI — The Public Site (legaisee.com)
6.1 Architecture — Seven Destinations
Component
Status
Notes
index.html (Home)
In progress
Velvet Rope entry, Restoration Thesis, gem metaphor, framework overview.
archaeology.html
In progress
Narrative Drift deep dive, the Lindy Effect, methodology comparison Easter egg.
method.html
In progress
Ten Interlocking Frameworks, Hierarchy of Truth, 8-Dimension Voice Profile.
serve.html (Industries)
In progress
Industry-specific dig sites; three archetype cards with .card--illumine.
practitioner.html (The Practitioner)
Built
“Exhibit Zero: A Live Reconstruction” — archaeology performed on John himself; primary credibility proof pre-Archive.
commissions.html
In progress
All Exhibits A–G, CAMERA framework block, Bedrock Pledge clauses with .card--illumine.
registry.html
In progress
Confidentiality cells with .card--illumine; intake/access-request entry point.

Note: practitioner.html is referred to as both “The Practitioner” and “architect.html” across different planning documents in this project's history. This Master Law standardizes on the seven-destination structure above; architect.html content is understood to already live inside practitioner.html.
6.2 Design System (Locked)
Component
Status
Notes
Obsidian
#050505
Page background, deepest black.
Gold
#C9A961
Primary accent, CTAs.
Platinum
#EBEBEB
Primary text.
Fonts
Cinzel / Cormorant Garamond / Inter
Display / body-serif / UI respectively.
Violet
Forbidden
Remnant of a discarded earlier theme — must never reappear anywhere in the system.

6.3 The .card--illumine Effect
Museum light from card top shining downward, gold palette (rgba(201,169,97)), hover-triggered. Approved and ready for application. HTML structure: an .illumine-layer div (containing .slit, .lumen > .min + .mid + .hi, .darken > .sl + .ll + .slt + .srt) inserted as the first child inside the card.
Applies to: Exhibit cards + Bedrock Pledge clauses on commissions.html
Applies to: three archetype cards on serve.html
Applies to: Lindy proof cells on archaeology.html
Applies to: confidentiality cells on registry.html
CSS lives in legaisee-luxury.css. This is a closed, approved spec — implementation only, no redesign.
6.4 The Logo Splash Sequence
Animated SVG logo intro inspired by non-linear light ignition: staggered CSS animation across approximately 58 addressable spark points organized into roughly 12 groups, with the three diamond gems and the polyhedron acting as primary ignition points. Currently under direct construction in Affinity Designer / Illustrator, with bevel layers separated into eight named layer groups. This is an asset-production task, not a code task, until the SVG itself is delivered for integration.
6.5 Resolved Issues (Do Not Reopen)
Competing mobile nav systems consolidated into a single .is-open toggle pattern.
CTA button restored to gold-box/black-text, inverting to gold-outline/gold-text on hover.
Page-level CSS duplication absorbed into master legaisee.css / legaisee-luxury.css.
White bars between sections fixed via background color set on the html element.
Mobile background rendering fixed: background-attachment: fixed replaced with scroll on mobile; dedicated mobilebkgd.png introduced with per-section filter/opacity control.
Body text standardized to Inter; Cinzel headings corrected from uppercase transform to true Title Case.

Part VII — The Command Center (Internal Backend)
Server: /home/carrmulti/www/www/commandcenter/ — SureServer, MySQL 5.7 Percona, PHP 8.4. Database: carrmulti_legaiseearchive.
7.1 Architectural Rules (Locked)
Rule 1: shell.php is the sole routing entry point for page-rendering requests.
Rule 2: kernel_db() is the only permitted database access pattern.
Rule 3: ui/global.css is the only permitted stylesheet for Command Center UI.
Rule 4: AJAX calls cannot route through shell.php due to ob_start() buffering. All JSON endpoints must live in api/ and be called directly — this is why api/v8/network_add_node.php exists as a standalone file rather than a shell.php route.
7.2 Modules Built
Prospect excavation module with entity extraction engine.
Dig Review interface.
Search module (three-column layout) — pending demotion per Part V.4, item 6, once tree browsing (Part II) is live.
File manager.
Ingest module.
18+ file governance/doctrine system establishing the rules in 7.1.
7.3 Open Backend Item
Pending Fix Confirmed This Session: api/v8/network_add_node.php — corrected to single read/single write/single echo with explicit per-field validation. Still needs re-pointing from client_id/case_id to node_id once Part II is live (see Part V.4).

Part VIII — Methodology & Doctrine (Locked Reference Content)
This is canon copy and structural language. It is not rewritten during build — it is implemented faithfully wherever the site or client deliverables reference it.
8.1 The Ten Interlocking Frameworks
40+ Channel Taxonomy across eight evidence classes (Advertising/Marketing, Financial/Filings, Operations/Infrastructure, Digital Presence, Brand Voice, Personnel/Leadership, Customer/Market Data, Competitive Landscape) · 3-Source Rule · Hierarchy of Truth (Tiers 1–4, see Part I.4) · Triangulation Protocol · Continuous Verification Model · 8-Dimension Voice Profile (Vocabulary, Sentence Architecture, Humor & Tone, Perspective, Transitions, Calls-to-Action, Evidence Style, Visual Language) · ROI Triggers · Competitive Asymmetry · Private Archaeology Protocol (digital, physical, and human artifact recovery).
8.2 The CAMERA Authority Framework™
Character Positioning · Audience Psychology/Targeting · Monetization Alignment/Design · Engagement Engineering · Repurposing Infrastructure · AI Acceleration. Already built as a standalone commission block on commissions.html (Exhibit D).
8.3 Pricing Ladder (Canon)
Component
Status
Notes
Phase 0 — Surface Survey
$2,500
Gatekeeper; determines if recoverable authority exists.
Exhibit A — Archaeological Excavation
$5,000–$7,500
Decision-Grade Executive Briefing, 30–50 pages.
Exhibit B — The Lapidary
$8,500–$18,000
Authority System Build / Master Operations Doctrine.
Exhibit C — The Mounting
From $4,500/mo
Ongoing strategic partnership.
Exhibit D — CAMERA Framework
$6,500–$7,500
Executive on-camera signal coaching.
Exhibit E — Master Craftsman's Presence
$18,000/mo
John personally directs high-stakes production.
Exhibit F — Estate & Provenance Appraisal
$25,000–$50,000
For sale/succession/capital-raise prep.
Exhibit G — Curator's Secret Intelligence
$35,000/qtr
Invitation-only cross-client pattern brief.

8.4 Verification & Confidence Language (Canon)
VERIFIED / PROBABLE / PLAUSIBLE / UNCERTAIN / UNVERIFIED — the five-level confidence label set. Every finding presented to a client carries one of these labels. This is the language brain_synthesis.php's real scoring logic (Part V.5) must eventually speak, and the language any client-facing Dossier output must use verbatim.

Part IX — Known Issues & Active Bugs
Working list. Items are removed only when confirmed fixed and verified, not when a fix is merely written.
Component
Status
Notes
network_add_node.php double-write/double-echo
FIXED (this session)
Replacement file delivered; pending deployment confirmation from John.
Brain pipeline missing client identity
DIAGNOSED, fix designed
Solution = Part V.3 (session-stored node_id). Not yet implemented.
intake.php under-built
OPEN
Too few fields; no node binding. Rebuild scheduled Part V.4, step 5.
2–3 competing search.php UIs
OPEN
To be demoted to secondary filter once tree browsing exists.
brain_synthesis.php placeholder scoring
OPEN, flagged
rand(60,95) is not real confidence scoring. See Part V.5.
No file-tree / node system exists yet
OPEN — Part II is the spec
This Master Law's Part II is the build spec; implementation not yet started.


Part X — Out of Scope for v1 (The v2 List)
Real ideas, deliberately deferred. Nothing here is rejected — it is sequenced. Items move from this list into a future version's TOC only by explicit approval, never by default.
Client Portal (currently named placeholder, per Part IV.3) — full client-facing login, update feed, report access.
CRM, billing, and email integration inside Legaisee Operations (Part IV.3).
Self-monitoring / predictive maintenance system (Part IV.1, final bullet).
Real multi-model excavation assistant (the “4up AI models / 40+ locations” search engine described in the Legaisee Overview) — model_router.php exists but has not been reviewed or specified yet.
Real confidence scoring in brain_synthesis.php to replace the current placeholder.
Animated SVG logo splash sequence — asset is in production (Part VI.4); integration is v1, but the asset itself is on its own production timeline.

Appendix A — Glossary of LEGAiSEE Terms
Component
Status
Notes
Business Archaeology
The core methodology: forensic excavation of a client's own institutional history to recover proven-but-forgotten positioning.
Narrative Drift
The structural blind spot that occurs when institutional memory of what worked is lost over time — through leadership change, rebrands, or simple neglect.
Golden Era
The historical period in a client's past when their positioning/signal was most effective, to be identified and restored.
The Lindy Effect
The principle that what has already survived longest is most likely to keep working — basis for prioritizing old, proven assets over new, untested ones.
Exhibit
A named, priced service tier (A through G) within the commission structure.
The Architect
John's role/voice within client-facing material — the practitioner who performs the excavation.
Tier 1–4
The Hierarchy of Truth confidence grading — see Part I.4.
node_id
The universal identity key in the tree_nodes system — see Part II.
brain_id
The session key used internally by the Brain pipeline files — see Part V.


Appendix B — Server & Path Reference
Command Center (Internal)
Root: /home/carrmulti/www/www/commandcenter/
Database: carrmulti_legaiseearchive (MySQL 5.7 Percona, PHP 8.4)
Client tree path (current, pre-Part II): /data/clients/{client_id}/cases/{case_id}/tasks/queue.json
API endpoints: /api/v8/ — called directly, never through shell.php (see Part VII.1, Rule 4)
Brain session files: /data/brains/{brain_id}.json
Brain memory graph: /data/brains/graph.json
Normalized source documents: /normalized/
Public Site
Domain: legaisee.com
Stylesheets: legaisee.css (base), legaisee-luxury.css (luxury system v2.0)


End of Master System Law v1.0. This document is reviewed and corrected by John before any build work proceeds against it.
