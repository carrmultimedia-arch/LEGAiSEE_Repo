LEGAiSEE Master OS/UI — Build Bible
Living document. Sections are added as they are locked in design. This is the canonical reference for the Master OS/UI build — hand relevant chapters to Windsurf (or any executor) as work orders when ready to build.

Table of Contents
Vision & Guiding Principles
Phased Roadmap (V1 / V2 / V3)
System Architecture — Shell & Navigation
Command View (Home Screen)
Clients/Cases — Pipeline & Kanban
Intake
Excavation
Dig Review
Knowledge System
Service Methodology Reference (Exhibit Tiers, CAMERA Authority System)
Backend Status Reference
Handoff Notes (Session Continuity)
(Remaining chapters — Case/Client Drill-In full detail, Vault, Payments, System Health/Project Manager — to be added as each is scoped.)

1. Vision & Guiding Principles
Core mandate: The Master OS/UI is being built from complete scratch as the human interface that operates the LEGAiSEE backend. It is not a redesign of the existing "Grand Lobby" dashboard — that dashboard (a card grid displaying meaningless/non-real numbers, with no unifying intelligence layer) is being trashed entirely and replaced.
Design philosophy: Every screen in the system must answer "what, connections, why — never how." This is the filter for every screen: the interface should describe state and significance in plain language, never expose internal mechanics (database queries, module names, technical errors) except in the one dedicated System Health area.
Long-term goal: The system is designed to outlast standard AI progression over the years — proving "a system will always outlast a tool," not just be another AI wrapper. This means the underlying model/LLM calls should be swappable behind an interface; the system's lasting value is its accumulated business memory and workflow, not any single vendor's model.
Visual identity: The OS/UI should visually match the LEGAiSEE website, specifically the luxury narrative style of legaisee.com/commissions.html — carried into the interface itself, not just the marketing site.
Priority order: Priority 1 is the UI/human interface. Priority 2 is the Project Manager module — expected to largely work once Priority 1 is wired correctly, since PM rides on the same UI/data foundation.
Architecture pillars ("North Star," established in earlier design conversations):
Core Kernel
Brain Layer
Modules
UI System
Data Layer
Tools
Project Manager
Knowledge System
Client and Case Intake
Support / 3rd Party

2. Phased Roadmap (V1 / V2 / V3)
V1 — Operate what's already built, well
Goal: the Master OS/UI as the real front end for the backend that already exists (intake → analysis → dig review → graph → report → vault → payment). Nothing here is new capability — it's making existing capability visible, trustworthy, and usable on a real client.
Master OS/UI replaces Grand Lobby entirely (Command View, Case/Client View, Excavation, Vault & Delivery, System Health), all showing real data, all narrated in plain language
Visual identity matches legaisee.com/commissions.html
Basic live client dashboard — client can see their own case status, artifacts found, current stage
Simple "good morning" landing summary (view of real data, not yet automated report generation)
Graph view (already built, vis-network) — 3D upgrade deferred to V2 as polish
V2 — Automation & compounding intelligence
Goal: the system starts doing work and thinking for itself, not just displaying what happened.
Automated daily AM system report + daily suggestion report + daily AM client-only report
Automatic prompts panel — AI assist surfaced in-dashboard for to-dos, system builds, maintenance, dig info
Full pipeline monitoring — onboarding through final payment, automated, with error/missed-step/efficiency flags
Yearly review dossier generation for 12-month clients
Compounding business memory maturing — Knowledge System accumulating and reusing prior dig findings across clients
Full Authority Marketing System module — channel/content/calendar generation and progress monitoring
3D graph upgrade (3d-force-graph library, spin/rotate) as UI polish
Project Manager pillar comes fully online, riding on the UI/data foundation from V1
Stage-triggered automations on the Kanban (e.g., auto-email on stage change) — beyond the one payment→receipt automation already built in V1
V3 — Frontier / "outlast the tool"
Goal: the parts that make LEGAiSEE genuinely differentiated rather than "a nice dashboard with AI features."
LEGAiSEE designs and runs digs itself, deciding where to look — John only steps in for what the system structurally can't do (password-protected sites, etc.)
Approved system builds build themselves — LEGAiSEE as its own systems engineer
Voice interface
Research track (not phased — needs answers before scoping)
LLM cost modeling: cost of LLM-driven dig automation at scale, cost of a server-deployed/self-hosted LLM vs. API calls, year-1 total infrastructure cost estimate
Artifact storage: local vs. cloud (Google/Dropbox) vs. must-stay-on-server, and tradeoffs
Model-independence strategy: the concrete version of "outlast the tool" — whether/when LEGAiSEE's own logic could reduce dependence on any third-party LLM
Note: CAMERA Authority System™
Not a build item. It's a personal on-camera coaching/training deliverable John teaches clients himself — the tenth pillar of LEGAiSEE's service methodology, not software. See Chapter 8.

3. System Architecture — Shell & Navigation
Model: Rail is law (like a Mac Dock) — fixed, identical everywhere, same items/order/position always. The adaptive layer lives in the top bar instead (Mac menu-bar model), changing per section to match that section's verbs.
Left rail (fixed, never changes): the primary navigation — Command, Clients/Cases, Excavation, Vault, System (small, de-emphasized, bottom of rail)
Top bar (adaptive per section):
In Command → global search, notifications, "customize" toggle
In Clients/Cases → client search/filter, sort, "new case" action
In Excavation → pipeline filters, stage jump
Each section's top bar is built for that section's verbs
Why this shape: Predictability matters for a system meant to "outlast the tool" — the rail is the constant "where am I" anchor; it mirrors real broadcast/production control-room layouts (persistent monitor wall + fast search/switch).
Sub-dashboard layout rule: Each North Star pillar gets its own full-real-estate sub-dashboard (no shared space with Command's widgets), with layout matched to content type:
Graph-heavy (Excavation's relationship graph) → canvas-first, minimal chrome
List/form-heavy (Clients/Cases directory) → table/filter-first
Narrative/report-heavy (Vault) → document-first reading layout
All sub-dashboards share the same rail, same top-bar adaptive pattern, and the same visual language (site colors/type/dark theme).

4. Command View (Home Screen)
Model: A customizable widget home screen — like a Windows/Mac/phone home screen on boot-up. Three tiers.
Tier 1 — System Voice (fixed, top, always visible)
Good Morning, John — plain-language daily brief: what happened overnight (new artifacts ingested, payments received, emails sent), what needs a decision today (dig review approvals, pending payment follow-ups), what the system will handle on its own tonight
Needs Your Attention — live queue: dig reviews awaiting approval, reports awaiting sign-off, pending payments — anything sitting in John's court right now
System Diary — persistent, append-only audit log (like a GitHub commit history), NOT an ephemeral feed. Purpose: answer "when did X happen" questions (e.g., a client asks what day they sent a payment) by scrolling/filtering history rather than digging through modules. Entries are never individually edited or deleted — only a full-log archive/reset action is allowed, gated by a double-confirm. Filterable by client/type/date range. Shows compact (last several entries) in the widget, expands to a full searchable view.
System Health — small, corner, quiet until something's wrong (green/yellow/red). Only expands/demands attention if something needs fixing. This is the one place "how" is allowed to live. Infrastructure pillars (Tools, 3rd Party, Core Kernel) fold in here rather than getting their own Tier 2 tiles, since they're not business-facing activity.
Tier 2 — Pillar Overview Tiles (one per business-facing North Star pillar, always shown)
Each tile is a glance-level summary; clicking through opens that pillar's full sub-dashboard for detail.
Clients/Cases — active count, new this week
Excavation — digs at each stage
Dig Review — items awaiting approval
Knowledge System — patterns/connections discovered recently
Vault — reports delivered this month
Payments — business-wide aggregate only: last paid, outstanding/overdue (per-client payment history lives on that client's own page, not here)
Intake — new prospects/leads
Tier 3 — Swappable Utility Widgets (user's choice, add/remove/rearrange)
Task Manager / Week View — non-urgent to-dos and calendar (separate from the system-generated "Needs Your Attention")
Quick Client Contact Lookup — fast name-to-phone/email search for incoming calls
(Additional swappable widgets can be added over time: pipeline snapshot, revenue detail, etc.)
Widget sizing: size-aware tiers snapping to a grid (e.g., 1×1 compact stat, 2×1 wide list, 2×2 large graph/chart) rather than freeform drag-anywhere placement — keeps the polished/luxury feel intentional rather than messy.

5. Clients/Cases — Pipeline & Kanban
Model: HoneyBook-style drag-and-drop Kanban pipeline (John used HoneyBook for years in his freelance business and specifically wants this interaction pattern) — kept simple and easy on both John's end and the client-facing side for now, upgradeable to more complexity later.
Pipeline stages are fully custom per client — built by John at intake via a stage-builder (add/name/order stages). No fixed template dictates what's available; John defines it fresh per client, or copies a prior client's structure as a starting point to save time. Stages are NOT derived from a fixed master list or from the Exhibit tier purchased.
"Lead" is the universal default first stage every client's custom pipeline starts at (see Chapter 6, Intake)
Cards show: client name, last activity, payment status indicator, next action needed
Clicking a card opens the full Case/Client drill-in view (timeline, graph, findings, report, payment — all in one place; full spec pending, see Chapter 10 placeholder)
Client-facing dashboard mirrors that client's own custom stages as a simplified read-only "you are here" progress indicator — not an editable Kanban. Same underlying data, two views: John's editable, client's read-only.
Deferred to V2: Stage-triggered automations beyond payment (e.g., "on move to Paid → send receipt email" generalized to any stage firing any action). V1 keeps the one automation payment_module.php already has: payment received → receipt email.
Email integration (new scope, affects this pillar and the Case/Client drill-in): John has full email access via cPanel on his server (IMAP/SMTP available server-side). Client management needs real mailbox integration — read/send, matched to client/case — not just transactional sends. This affects the Case/Client drill-in view (needs an email thread panel) and the System Diary (email events belong in the audit log).

6. Intake
Two distinct dig products (not one dig at two scales):
Shallow/Mini Dig — $2,000 entry point. Initial search finds 1-3 proof-of-concept artifacts, delivered with a preliminary authority plan. The $2k price point primarily serves to filter out non-serious inquiries ("tire kickers"), not to price the actual small amount of work involved.
Full Excavation — same initial search step, but scales to 40+ channels, as complete an archaeological dig as possible, followed by the complete Authority Placement Marketing System.
Single client record from first touch — no separate lead-vs-client entities. Whether a lead comes from the passive lead-magnet site or from John running the prospecting tool live (e.g., on his iPad in a meeting), either path creates the same client record starting at a "Lead" status/stage. A Shallow Dig → Full Excavation upgrade appends new stages to that same record rather than creating a new one — avoiding double-entry of re-creating a client already in the system.
Phase 0 — Prospecting (pre-sale, but still creates the client record at "Lead" stage): A lightweight, fast tool usable two ways:
Remote: John runs it himself ahead of a meeting, exports a proof-of-concept dossier PDF, brings or sends it
In-person: run live on John's iPad in front of the lead, generate the dossier PDF on the spot, hand it over with a call to action to sign up for the $2k dig on the website
Output: a clean, brand-matched PDF — 1-3 artifacts, a preliminary authority read, contact info, sign-up link. This is a sales artifact first, an analysis artifact second — needs to look impressive fast, not be exhaustive. (See Chapter 8 / excavation-channels reference for the "Beta-Gemstone Sprint" playbook, which documents exactly this kind of pitch-deck output in practice.)
Prospecting artifacts carry forward into the client record once they sign up — the real dig does not re-find what Phase 0 already found; it expands from there.
Phase 1 — Actual dig begins once the client signs up/pays: custom Kanban stages get built via the stage-builder (Chapter 5), client-facing portal account created/invited (possibly via the cPanel email integration).

7. Excavation
IMPORTANT CORRECTION (supersedes earlier framing in this chapter): The real pipeline order is Discovery → Local Storage → Ingest → Dig Review, not "the system searches the channel list directly." Discovery is external and manual right now — John runs LLMs outside the system to search the 40+ channels; found artifacts can be anything: Wayback captures, YouTube videos, scanned old posters, printed photos, mailers, old hard drive dumps, employee interview recordings. Artifacts land on a local hard drive first, then get uploaded into the system at Ingest. This makes Ingest a bigger requirement than originally scoped — it must accept and organize arbitrary heterogeneous file types in one consistent interface, not just structured/scraped web data.
Why discovery is manual right now: the system is hosted on shared hosting (SureServer), which cannot run persistent background jobs, headless browsers, or autonomous scraping at scale — a real infrastructure constraint, not a scope choice. True autonomous discovery is a V3 goal that would require either a VPS/dedicated server or an external service triggered from the shared server on a schedule. John's long-term plan (once revenue allows) is to purchase his own server with a strong GPU to run a local/self-hosted LLM — this would also resolve this constraint.
Channel checklist is built from the fixed master list, NOT custom-built per client like the Kanban stages. See the full channel reference: 10 categories, 40+ specific channels with direct links and search tactics, documented separately in the LEGAiSEE Excavation Channels reference (companion document — Web Archives, Video & Broadcast, Print & News, Government & Legal, Social Media, Industry & Awards, Directories & Listings, Audio & Podcast, Physical/Digital Hybrid, "Deep Cuts").
What varies per client/dig-type is how many channels get activated:
Shallow Dig → 1-3 targeted channels
Full Excavation → all applicable channels across the 10 categories
UI structure: channels grouped by the same 10 categories (collapsible groups), each channel showing status: not started / in progress / ingested / analyzed.
Core view (per-client dig progress): reached from a client's Kanban card once they're in an active dig stage, or from the Excavation pillar tile on Command. Shows the channel/source checklist, live artifact count, analysis status (entity resolution, clustering, relations, root-cause graph — mapping to the already-built WO-D backend modules), and a "Ready for Review" flag once enough analysis is complete to move into Dig Review.
Pillar-level view (all clients): shows all active digs across all clients at once — "what's cooking right now" (e.g., 3 clients mid-dig, 1 stalled, 2 ready for review).
Manual-required flag: channels John must handle himself (password-protected sites, etc.) get marked manual-required — John drops in artifacts himself, and the system still tracks/counts/analyzes them the same as anything auto-ingested.
Reference workflows (documented in the companion Excavation Channels doc, available for eventual system automation in V2/Knowledge System):
Manual priority workflow: 10 highest-value channels in priority order, ~4-5 hours manual pass
"4-query AI parallel" method: 4 LLMs run simultaneously with specialist roles (Historian/Analyst/Archivist/Investigator), synthesized into a confidence-scored 1-page snapshot — compresses the manual pass to ~90 minutes

8. Dig Review
Locked: Dig Review is per-client, locked to that client's own artifacts — their excavation, their data — never a cross-client aggregate view. Command's Dig Review tile is only a quick average/count scrape across all clients, same glance-only pattern as other Tier 2 tiles.
CRITICAL locked principle: nothing found is ever discarded. Every artifact is a reusable data point for the eventual Authority Marketing System — an old commercial becomes Reels content, an old poster becomes an Instagram post, an employee interview becomes YouTube content. This splits Dig Review into two distinct layers:
Raw artifact library — every file ever found, permanently retained regardless of review outcome.
Analytical claims/findings — what the analysis engines concluded about those artifacts (entity/relationship/pattern conclusions). Approve/Edit/Reject applies only here, never to the underlying artifact. "Reject" means the claim wasn't accurate — not that anything gets deleted. Rejected claims still log to the System Diary for a "why isn't X in the report" trail later.
Locked: the two layers are not a fixed two-step for every client — review scales to what's actually ingested.
Small/simple dig (few artifacts, mostly text/web) → goes straight to claims review.
Large/complex dig (many artifacts, mixed media — video, scanned prints, audio) → needs artifact-level triage first, since claims can't be meaningfully reviewed on unorganized raw media.
Rationale: a small local business (e.g. lawn/cleaning service) won't have the same artifact volume/complexity as a multi-million-dollar corridor company, so review depth should match dig size rather than being uniform. This is the same underlying principle as Clients/Cases' custom-per-client Kanban stages — see the cross-cutting design principle noted below.
Cross-cutting design principle (applies across pillars, not just this one): the system should flex per client rather than forcing uniform steps for everyone. Same logic behind the custom-per-client Kanban stages (Chapter 5) and the scaled Dig Review depth here. A lawn/cleaning service and a multi-million-dollar corridor corporation should never be forced through identical pipelines.
(Backend already exists: dig_review_module.php loads real findings with approve/edit actions. This chapter defines the OS/UI layer and the artifact-triage extension still to be built.)

9. Knowledge System
Two distinct functions:
Per-client knowledge base — everything approved in Dig Review (claims) plus the raw artifact library for that client, organized and searchable. Feeds the Case/Client drill-in view and the eventual report/Authority Marketing System.


Cross-client pattern intelligence — when multiple clients show the same abandoned tactic, the same industry shift, the same type of "gemstone" (per the Excavation Channels doc's terminology), the system should notice and surface it as business intelligence about John's own service, not to any client.


Locked: cross-client pattern intelligence is NEVER shown to clients in a way that reveals its source. It's sellable knowledge for John's own business use — fueling upgrade pitches, and populating a market/competitor report section within a client's deliverable. Patterns get repackaged/anonymized insight, never "here's what we found for another client."
Where this connects to the rest of the system:
The System Diary is the raw event log; Knowledge System is the meaning layer built from patterns in that history.
Command's Knowledge System tile ("patterns/connections discovered recently") is the glance-level surface of this.
Scope note: this chapter defines the concept/structure now; actual pattern-detection logic is explicitly V2 build work ("compounding business memory maturing" per the roadmap), not V1.

10. Service Methodology Reference
(Business context, not build spec — included here so the OS/UI design stays consistent with the actual service offering.)
Exhibit tiers (Business Archaeology offering pricing structure) — see LEGAiSEE Services reference doc for full tier breakdown ($500–$250,000 range), including the higher-tier additions: full institutional timeline reconstruction, "Revenue Leak Detection System" review, competitive intelligence integration, provenance/asset-lineage documentation, and (enterprise tier) "Institutional Reputation Recovery" protocol with board-ready signal reporting.
The CAMERA Authority System™ — the tenth interlocking framework of the LEGAiSEE methodology. A personal on-camera presence/platform authority coaching deliverable (not software) — John teaches clients, using his 30 years of broadcast experience, to shoot and create their own content.
Six-dimension framework: Character Positioning, Audience Targeting, Monetization Design, Engagement Engineering, Repurposing Infrastructure, AI Acceleration (AI trained on the client's "Voice Profile" — an 8-dimension linguistic fingerprint extracted during excavation)
Five modules: On-Camera Foundations, Delivery Naturalization, Technical Excellence, Platform Mastery, Crisis & Recovery
All tiers include: personal on-camera equipment configuration, platform-specific content strategies, 10 signature piece scripts, crisis response protocols, async video review (duration by tier)

11. Backend Status Reference
(Snapshot as of this document's writing — see /areas/legaisee-command-center working file for the live, up-to-date version.)
All eight original V1 backend work orders are complete:
WO-A — audit
WO-B — shell navigation (+ WO-B1 kernel guard standardization fix)
WO-C — ingest
WO-D — analysis engines (entity resolution, semantic clustering, relations, root-cause graph, brain pipeline)
WO-E — graph view (vis-network, 2D; 3D upgrade deferred to V2)
WO-F — review, report, vault (dig_review_module.php, report_module.php with dompdf, vault_module.php)
WO-G — Stripe + email payment trigger (built and tested backend-only; still needs before live: real Stripe test-mode keys confirmed in config, Stripe PHP SDK confirmed installed, one full test checkout run with Stripe's test card 4242 4242 4242 4242 to confirm the whole loop — webhook, payment status update, both emails)
SMTP email delivery is configured and a test email has been sent successfully.
Architecture rules (locked, apply to all future work): shell.php is the sole routing entry, kernel_db() is the sole DB access point, ui/global.css is the sole stylesheet, complete replacement files only — never patches.

12. Handoff Notes (Session Continuity)
This chapter exists so a fresh chat can pick up design work exactly where it left off. Update it whenever a session ends mid-work.
Status as of this handoff: Chapters 1–11 above are locked and complete. Design has been proceeding pillar-by-pillar through the confirmed scoping order:
Intake → Excavation → Dig Review → Knowledge System → Case/Client drill-in → Vault → Payments → System Health/PM
Next up: Case/Client drill-in view — the full "everything about this one client" page that Kanban cards open into. Known requirements already gathered for it (from earlier chapters, not yet formally spec'd as its own chapter):
Timeline, graph, findings, report, payment all in one place
Needs an email thread panel (per the cPanel email integration scope — see Chapter 5)
Should reflect that client's own custom Kanban stages and per-client Dig Review depth
After that: Vault, Payments (dedicated sub-dashboard — Command's tile is aggregate-only, detail lives here), System Health/Project Manager.
Also still open / not yet designed:
The actual visual design system (colors, type, components) pulled from legaisee.com — mentioned as a requirement, never scoped in detail
The Intake stage-builder UI itself (the tool John uses to build a client's custom stages) — concept locked, UI not designed
The Phase 0 prospecting tool UI (fast search + PDF dossier export, usable on iPad) — concept locked, UI not designed
Full spec for what "manual-required" artifact entry looks like in Excavation
Persistent memory note: All decisions in this document are also mirrored in Claude's persistent memory (files: /areas/legaisee-command-center.md, /areas/legaisee-os-vision.md, /areas/legaisee-os-design-log.md, /areas/legaisee-excavation-channels.md, /areas/legaisee-services.md). A fresh chat with Claude will already have this context loaded — this document is the human-readable, exportable mirror of that memory, not a replacement for it.
To resume: open a new chat and say "continue LEGAiSEE Master OS/UI design — next is the Case/Client drill-in view" (or reference this document directly). No need to re-explain anything already locked above.

13. Case/Client Drill-In
Model: Document-first reading layout (same rail + adaptive top bar as everywhere else). Top bar here = client search/switcher, stage indicator, quick actions (send report, request payment).
Fixed header block (always visible, no scroll): client name, current Kanban stage, Exhibit tier, next action, payment status chip.
Six sections as tabs (not a stacked scroll):
Timeline — client-scoped slice of the System Diary: stage changes, artifacts ingested, claims approved/rejected, emails, payments
Graph — that client's node graph embed (vis-network now, 3D later), scoped to their case only
Findings — the claims-review layer from Dig Review (Chapter 8) — approve/edit/reject happens here, not a separate page
Report — generated PDF(s), version history
Payment — Stripe status/history, existing "Request Payment" button
Email — IMAP/SMTP thread panel matched to this client/case (per the Chapter 5 email integration scope)
14. Vault
Model: not a document-first reading layout like Museum Display — artifacts are heterogeneous media (video, scanned images, audio, PDFs, plain text), so this needs a browsable media library: grid/thumbnail view for visual media, list view with type icons for everything else, toggleable. Leverages the already-confirmed real search_module.php (cross-source search across files + DB) as its backing search, rather than building new search logic.
Scope: per-client, same pattern as Dig Review — each client's Vault holds only their own artifacts. No cross-client browsing here (cross-client intelligence lives in Knowledge System, Chapter 9, and stays anonymized).
Core content — the raw artifact library. Every artifact ever found for this client, permanently retained regardless of Dig Review outcome (per the Chapter 8 locked principle: nothing found is ever discarded, "reject" only ever applies to a claim about an artifact, never the artifact itself).
Each artifact entry shows:
Preview (thumbnail/media player for visual/audio, icon + filename for documents)
Source channel (from the Chapter 7 channel taxonomy — e.g. "Web Archives," "Print & News")
Date found, date ingested
Manual-required flag if John hand-entered it (per Chapter 7)
Link to any claims/findings tied to it (jumps to that artifact's entry in Dig Review / Case-Client Findings tab)
Filter/search bar: by channel category, artifact type, date range, and free-text search (via search_module.php).
Explicitly not here: generated reports (Museum Display, Chapter 15), payment requests (Payments, Chapter 16). Vault is raw material only — a client's Vault growing over time as future Authority Marketing content is exactly why nothing gets discarded, but that reuse-tracking itself is V2 scope (Knowledge System's compounding-memory work), not V1 display.




17. System Health / Project Manager
Model: this is the one place "how" is allowed to live, per the core design philosophy (Chapter 1) — the only screen in the whole system permitted to show technical/mechanical detail instead of plain-language business meaning.
Two distinct halves under one roof:
System Health — status of the machinery itself. Green/yellow/red at a glance (matches the Command tile, Chapter 4 — this is that tile's full detail view). Folds in the infrastructure pillars that don't get their own Command tile because they're not business-facing: Tools, 3rd Party connections, Core Kernel. Shows: which modules/engines are actually running vs. broken (the kind of thing Cline/Gemini audits have been surfacing — e.g. the memory_ingest/memory_ingests table-name mismatch bug would show up here), API/integration status (Stripe, SMTP, any future connectors), and error/exception logs. This is diagnostic, not narrative — tables and status lights, not sentences.
Project Manager — internal task/project tracking for John's own business operations (not client-facing, not the client's dig progress — that's Excavation/Dig Review). Rides on pm_module.php (already built, passed WO-002 completion criteria) and the projects/pm_tasks tables. Per Chapter 1's priority order, this is expected to largely work once the UI/data foundation from the rest of V1 is wired correctly, since PM sits on the same underlying identity/data layer as everything else.
Open dependency, flagged not solved here: PM's projects table has that unresolved domain_id question from the identity-layer audit — this chapter's PM half can't be fully specified until that's answered. Marking as open per the new rule, not blocking the rest of this chapter.

That's every chapter in the Bible's original remaining list now drafted. Per the Handoff Notes, what's left unscoped is the smaller stuff: the visual design system (colors/type/components pulled from legaisee.com), the Intake stage-builder UI, and the Phase 0 prospecting tool UI. Want to keep going into one of those, or pause here?




























Addendum — Part II / Part IX
Confirmed: Identity Layer Blocks Everything Downstream, Including Display
Date: 2026-08-05 Status: Evidence confirmed, not yet resolved.
What happened
Loaded the live Cockpit module (cockpit_module.php) — a working, previously-built daily-briefing dashboard, confirmed reachable via shell.php?module=cockpit. It correctly rendered, but showed only "1 active client (Test Client)" — none of the real prospects (Brad Moore Builders, Faust Hotel, Cowboy Plumbing) appeared.
Separately, cases_module.php's live output showed 13 "cases," several of them real records with real data (case_006 / Summit Realty, case_011 / Acme Manufacturing, case_014 / Velocity Auto Sales) mixed in with bare numbered rows showing "unknown/Unknown" — empty stub records with no real content.
Why
This is the client-data and case-data duplication already flagged in the SYSTEM_LEGEND.md audit (Part IX), now visibly confirmed rather than theoretical. Cockpit reads clients through client_manager.php's own store, which is disconnected from wherever the real prospect records actually live. Cases are being pulled from two sources at once — real flat-file records under data/cases/{case_id}.json and a separate, mostly-empty MySQL cases table — blended into one list with no reconciliation.
Rule this confirms (governing principle for all future build work)
Data layer before logic layer before display layer, no exceptions. The "ugly stretched-row" appearance of the Cockpit output was not the real problem and is not worth fixing yet — it's a bare HTML fragment by design, awaiting shell.php's chrome/grid CSS, which is expected at this stage. The real problem underneath it is that the identity layer (Part II) doesn't exist yet, so every module built on top of it — no matter how well-written, and Cockpit is well-written — surfaces wrong or duplicated data. Fixing individual modules (Cockpit's client list, Cases' stub filtering) is explicitly rejected as the wrong move here: it would be patching symptoms module-by-module while the root cause (no single source of truth for what a client or a case is) remains unfixed, guaranteeing the same class of bug resurfaces in every other module built the same way.
Frontend/visual polish work is deferred until after the identity layer and data layer are correct, system-wide — not per module, not as an exception for any one screen no matter how bad it looks in the meantime.
Status
Part II (tree_nodes identity layer) remains the next required build item. This addendum is evidence supporting that priority, not a new work item on its own.



End of current sections. Remaining chapters to draft as they're scoped: Case/Client Drill-In (full detail), Vault, Payments (dedicated sub-dashboard), System Health/Project Manager, plus the visual design system chapter and the Intake stage-builder/prospecting-tool UI detail.

