LEGAiSEE Institutional State — Checkpoint
Dated: August 19, 2026
This is a dated snapshot of where LEGAiSEE stands — business model, methodology, build status, and open decisions — compiled for permanent archive outside of AI memory. Treat this as a point-in-time record, not a living document; take a new checkpoint every few weeks rather than editing this one.

1. What LEGAiSEE Is
Luxury B2B consultancy built on a proprietary methodology, Business Archaeology: forensic excavation of a company's own institutional history — abandoned assets, proven-but-forgotten positioning, "Golden Era" patterns — reconstructed into a present-day Authority System. Recovers proven messages, never invents them. Grades all evidence on a 4-tier confidence scale (VERIFIED / PROBABLE / PLAUSIBLE / UNCERTAIN / UNVERIFIED).
Target client: businesses operating 5–10+ years, OR family/ generationally owned, OR $30M+ revenue. Primarily San Antonio/Austin I-35 corridor. Capacity deliberately capped by design.
Core metaphor (canon, used everywhere): Gemstone — Stage 0 Natural Habitat (undiscovered history) → Stage 1 Raw Stone (excavated) → Stage 2 Cut & Shaped (refined) → Stage 3 Mounted (set into Authority System) → Stage 4 Museum Display (delivered/verified/presented).
Bedrock Pledge (doctrine): every claim excavated/triangulated, never invented; 3-Source Rule (two independent sources or one Tier 1 verified primary); Continuous Verification (new evidence incorporated via addenda, never hidden post-delivery).
2. The Exhibit System (pricing/service ladder)
Tier
What it is
Price
Phase 0 — Shallow/Surface Dig
1–3 surfaced assets, Golden Era estimate, one inflection point, excavation brief
$2,500
Exhibit A — Archaeological Excavation
Full 40+ channel dig
$5,000–$7,500
Exhibit B — The Lapidary
Full institutional record → Authority System deliverable
$8,500–$18,000
Exhibit C — The Mounting
Ongoing execution/monitoring retainer
from $4,500/mo
Exhibit D — CAMERA
On-camera authority coaching (John personally, not software)
$6,500–$7,500
Exhibit E — Master Craftsman's Presence
Enterprise retainer
$18,000/mo
Exhibit F — Estate & Provenance Appraisal
Enterprise
$25,000–$50,000
Exhibit G — Curator's Secret Intelligence
Enterprise, quarterly
$35,000/qtr

CAMERA Authority System™ (Exhibit D) is a personal coaching deliverable, not a software module — John teaches clients (using his 30-year broadcast background) to shoot their own content. Six dimensions: Character Positioning, Audience Targeting, Monetization Design, Engagement Engineering, Repurposing Infrastructure, AI Acceleration.
Ten interlocking doctrine frameworks total: 40+ Channel Taxonomy, 3-Source Rule, Hierarchy of Truth, Triangulation Protocol, Continuous Verification, 8-Dimension Voice Profile, ROI Triggers, Competitive Asymmetry, Private Archaeology Protocol, plus CAMERA.
3. The Client Journey — Business Execution vs. Code Reality
Stage
Business need
Code status
Lead / Shallow Dig
Capture prospect, small forensic pass, sell Full Excavation
✅ Confirmed working (ingest_module.php + pipeline)
Full Excavation
40+ channels, entity extraction, pattern detection, human review
✅ Confirmed working (entity_resolution/semantic_cluster/root_cause_graph/dig_review, tested graph 22 nodes/20 edges)
Findings → Authority System
Turn verified findings into the actual step-by-step deliverable
❌ Not built — the real gap. No Recommendation/Initiative objects exist; report_module.php formats a thin PDF, doesn't compose a structured system
Delivery & Payment
Payment-gated delivery, archive
🟡 Mechanically close — Stripe backend built, needs http→https fix, missing payments.tier column
Ongoing (Exhibit C retainer)
Quarterly performance ingest, change detection, recommendations, client notifications
❌ Not built — correctly sequenced as v2, depends on the Findings→Authority System gap being closed first

The actual excavation itself has no automated web access. Nothing in the built code browses the internet. All 40+ channel research has only ever been done by John + LLMs with live browsing (the "4-query AI parallel" method: ChatGPT/Claude/Gemini/Perplexity each running a specialist role, synthesized by hand). This is not a gap to be automated away — it's permanent, necessary "outside point of view" work.
4. What's Actually in the Live Database Right Now
Correction on record: the businesses currently in the live DB (home builder, etc.) are not paying clients. They are real local businesses researched via the 4-query LLM method as test data, ingested through the system to exercise it, since there's no finished OS yet to run a real engagement through. Two paths under consideration once the Authority System piece is built and tested against this data:
Treat as test data, discard, start clean with a first real paying client
If the finished deliverable is genuinely strong, pitch these specific businesses cold with the completed work as proof — a larger-scale version of the already-built "Beta-Gemstone Sprint" playbook
Decision deferred until real output quality is seen.
5. Command Center — Build Status (verified, not claimed)
PHP/MySQL app on SureServer, DB carrmulti_legaiseearchive. Locked architecture: shell.php sole routing entry, kernel_db() sole DB access, ui/global.css sole stylesheet, complete replacement files only.
Confirmed working (live-tested, not just claimed):
Full ingest → entity extraction → clustering → graph pipeline (WO-A through WO-H)
Dig Review interface
Graph visualization (vis-network)
Cockpit/Command View dashboard — real widgets, real data, all 7 pillar tiles live
Client View/Drill-In shell — 6 tabs built (Timeline/Graph/Findings/ Report/Payment/Email), routed via ?module=client_view&id=X
Identity layer (tree_nodes) live, though schema differs from original spec assumptions
Stripe + email payment backend (SMTP confirmed, no full checkout test yet)
PDF generation (dompdf) — header bug fixed, downloads clean
Known open issues (real, not resolved):
WO-R created a duplicate client-view system in shell.php that needs deleting
reports DB table confirmed orphaned/unused
payments table missing a tier column
Stripe URLs hardcoded to http, need https
Cockpit's Clients&Cases tile hardcoded to client id=1 (demo stopgap)
graph_view.php possibly overwrote an earlier working version — unconfirmed
review_flags.context assumed (not confirmed) to hold client_id
The core missing piece: no module or data object exists that composes a structured Authority System from reviewed Findings. This is the single biggest gap between "what's built" and "what's sellable."
6. Standing Lessons (learned the hard way, apply going forward)
Never trust an AI executor's claim that a file was written or a test passed — verify via FileZilla modified-timestamp or direct pasted file content. This has caught real, repeated failures (stale deploys, fabricated log entries, "simulated" DB checks).
Windsurf/Gemini chat tools cannot execute live DB queries — only real uploaded diagnostic scripts (the db_verify.php pattern) give ground truth.
Nothing already built is treated as sacred — expect orphaned files/tables/duplicated logic throughout; this has been confirmed repeatedly (duplicate kernel_db() in three files, 7 flagged duplications in a system audit).
Local/free coding agents (qwen2.5-coder:7b, free VS Code extensions) have proven unreliable for this project's complexity — hallucinate paths, loop, or hang. Currently reconsidering agentic tools broadly in favor of manual LLM-generates-file → John pastes → verify workflow (how most of LEGAiSEE was originally built, via GPT/Kimi).
7. Immediate Next Step (as of this checkpoint)
Define the minimum structured data shape for an "Authority System" record (positioning, channels, content calendar, initiatives — pulled from the Exhibit System canon language above) and wire report_module.php to compose from that record instead of its current thin pull. This is v1 work, not v2 polish — reclassified as such on 8/19 after realizing Master System Law had assumed this piece existed when it doesn't.
8. Site / Brand Notes
Public site at legaisee.com — seven pages, locked palette (obsidian #050505, gold #C9A961, platinum #EBEBEB), Cinzel/Cormorant Garamond/Inter. Currently under reconsideration: was scored 80/100 narrative, 30/100 visual/experience by outside feedback — redesign direction moving toward a museum-room, non-linear navigation concept (Myst-style pre-rendered room transitions), not yet built. Pricing may move off the public site entirely toward invitation-only/contact-for-pricing.

This document reflects memory as of 2026-08-19. It will not update itself — take a fresh checkpoint periodically rather than treating this as current beyond its date.

LEGAiSEE Status — Where Things Stand
As of August 19, 2026
✅ Completed / confirmed working ("mini systems" done)
System
What it does
Confirmed how
Identity layer (tree_nodes)
Every client/project/item as one node type, unlimited depth
Live, though real schema differs from original spec
Ingest pipeline
Intake artifacts, entity extraction, clustering, root-cause graph
Live-tested; writes insights/clusters/network JSON correctly
Dig Review
Human approve/edit/reject of claims
Core, tested (WO-D/F)
Graph visualization
vis-network client relationship graph
Tested, 22 nodes/20 edges confirmed
Cockpit / Command View
Main dashboard, real widgets, real data
Fully working end to end, all 7 pillar tiles live
Client View/Drill-In shell
Timeline/Graph/Findings/Report/Payment/Email tabs
Built (WO-Q–V) — not yet personally watched run live, see gap below
PDF generation
dompdf report export
Working, headers bug fixed, downloads clean
Payment backend
Stripe + SMTP email
SMTP confirmed; needs http→https fix + payments.tier column
Doctrine/methodology
Bedrock Pledge, 3-Source Rule, Hierarchy of Truth, 40+ channel taxonomy
Fully documented, not code — this is the human-executed layer
4-query AI parallel dig method
Multi-LLM discovery + synthesis + confidence tagging + spot-check
Documented and already in use manually

🟡 In progress / partially resolved
Test data situation — real businesses researched via the 4-query method sit in the live DB, ingested through the pipeline, but never turned into a paid engagement. Decision on whether to trash-and-restart-clean vs. pitch-cold-with-finished-work is deferred until the Authority System piece exists and gets tested against this data.
Command Center visual/UX overhaul — HoneyBook-style merge plan locked (nav structure signed off: Home, Pipeline, Contacts, Calendar, Vault, Files, Finance, Services, Templates, Lead Forms, Tools), not yet built area-by-area.
Executor tooling — reconsidering agentic tools (Windsurf/Gemini) in favor of manual LLM-generates-file → paste → FileZilla-verify workflow, given repeated fabricated-success incidents.
📋 Scoped but not built
The Authority System composer — the single biggest gap. No Recommendation/Finding/Authority Initiative objects exist as data. report_module.php formats a thin dossier PDF; nothing composes a real structured Authority System from reviewed Findings.
RAG-vault architecture (candidate implementation for the above) — per-client vector store (ChromaDB/Ollama-style), synthesis constrained to retrieved chunks only, with a hard citation gate: no claim reaches a client deliverable without tracing to a real source tag, regardless of cross-model agreement. Designed, not built. Requires either local machine or a VPS — cannot run on SureServer shared hosting.
Quarterly feedback loop / Exhibit C retainer mechanics (performance ingest, change detection, recommendation queue, client notifications) — correctly sequenced as v2, explicitly depends on the Authority System composer existing first.
Client-facing portal/login — v2/deferred. What exists today (Client View/Drill-In) is internal-facing only.
❌ What's actually missing from the grand pipeline
The translation layer. Findings exist, review exists, PDF export exists — but nothing turns "verified findings" into "the client's actual step-by-step Authority System." This is the real product gap, not a nice-to-have.
Live verification of the drill-in. The Client View/Drill-In is marked built but has never been personally watched running end-to-end on real data — same "code says it works, nobody's seen it fire" pattern that's bitten JobHunt repeatedly.
Storage/hosting decision. The RAG-vault, and honestly the CRM-merge vision generally, keeps running into "SureServer shared hosting can't do this." The VPS move isn't optional infrastructure polish anymore — it's now a blocker for the next real build step.
A locked verification standard for the composer. Just closed this one: citation-required gate, cross-model agreement as triage only. Needs to actually get built into the composer, not just documented.
The honest one-sentence read
The discovery-and-review half of LEGAiSEE is real and tested. The sell-and-deliver half — the actual Authority System — doesn't exist yet as code. Everything scoped above (RAG vault, citation gate, drill-in verification) is aimed at closing exactly that one gap. Nothing else should get built ahead of it.

