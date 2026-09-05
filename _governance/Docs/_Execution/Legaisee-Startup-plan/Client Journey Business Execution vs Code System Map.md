LEGAiSEE: Client Journey (Business Execution) vs. Code System Map
Two lenses on the same system: what the business needs to happen at each stage, and what code currently exists (and its real, verified status) to make it happen. Gaps are where they don't line up.
Verified/confirmed status pulled from actual live-testing sessions, not claims. "Confirmed" = you or a real diagnostic script saw it work. "Built, unverified" = code exists but hasn't been proven live. "Not built" = no code attempts this yet, even as a placeholder.

1. Lead Generation → Shallow Dig ($2,500)
Business needs: capture a prospect, run a small forensic pass (1-3 artifacts), produce an excavation brief that sells the Full Excavation.
Piece
Code home
Status
Public intake entry point
registry.html (public site)
Live static page
Prospect capture into system
ingest_module.php, tree_nodes (Part II identity layer)
Confirmed working
Shallow artifact pull
Same excavation pipeline as below, scaled down
Confirmed working
Excavation brief output
report_module.php (dompdf)
PDF generation confirmed working (headers bug fixed) — but see gap below

Gap: the PDF generator works mechanically. What it's pulling from to build the brief is thinner than it should be — see #4.

2. Full Excavation ($5,000–$18,000, Exhibits A/B)
Business needs: run all 40+ channels, extract entities/relationships, surface patterns, human-review the claims, produce the full institutional record.
Piece
Code home
Status
Ingest 40+ channel artifacts
ingest_module.php + files_module.php/search_module.php
Confirmed real, working
Entity extraction
entity_resolution_module.php
Built, confirmed writes insights.json
Pattern/cluster detection
semantic_cluster_module.php
Built, confirmed writes clusters.json
Relationship/root-cause graph
root_cause_graph_module.php
Built, confirmed writes network.json
Human verification of claims
dig_review_module.php
Confirmed core, tested (WO-D/F)
Graph visualization
graph_view.php (vis-network)
Tested, 22 nodes/20 edges confirmed

Status: this stage is your strongest layer. It's real, it's tested, and it's the one part of the system that already does more than describe itself.

3. Findings → Authority System (Exhibit B "Lapidary," the actual deliverable)
Business needs: take everything found and reviewed, and turn it into the step-by-step Authority Marketing System — channels, content, calendar, positioning, the actual thing the client is paying $8,500–$18,000 for.
Piece
Code home
Status
Claims review (approve/edit/reject)
dig_review_module.php, Findings tab (client drill-in)
Confirmed working
Turning approved findings into an Authority System
No dedicated module
Not built
Structured Recommendation/Initiative objects
None exist
Not built
Final deliverable generation
report_module.php (dompdf)
Generates a PDF, but from a thin dossier shape — not a structured, multi-part Authority System

This is the gap you named correctly. Findings review works. PDF export works. But there is no module that takes "here's what we found and verified" and builds "here is the client's step-by-step Authority System." Right now that leap happens in your head, not in the system. This is the missing spine — not the middle-tier dashboards, this specific translation layer.

4. Delivery & Payment (Museum Display / Vault)
Business needs: gate delivery on payment, deliver the finished system, archive it.
Piece
Code home
Status
Payment processing
Stripe + email backend
Built; needs http→https fix, missing payments.tier column
Payment-gated delivery
Museum Display status logic (locked design, "Awaiting Payment" state)
Design locked, build status unconfirmed
Archive/download
vault_module.php
Confirmed working (filesystem-based, reports table itself is orphaned)

Status: mechanically close to working, a few real bugs away.

5. Ongoing Execution & Adjustment (Exhibit C "Mounting," $4,500/mo retainer)
Business needs: monitor the delivered Authority System, ingest performance data over time, suggest and make adjustments, notify the client.
Piece
Code home
Status
Quarterly performance ingest
None
Not built
Change detection against original strategy
None
Not built
Recommendation queue + human approval
None
Not built
Client-facing portal / login
None
Not built — v2/deferred
Notification engine (email/SMS)
None
Not built

Status: this entire stage — everything the ChatGPT doc (now in [[legaisee-authority-engine]]) is describing — has zero code. That's correct and expected: it's v2, sequenced after v1 per your Master System Law. Not a current gap, a future one.

The honest picture
Lead → Shallow Dig → Full Excavation → Findings → AUTHORITY SYSTEM → Delivery → Ongoing
  ✅        ✅              ✅            ✅            ❌               🟡          ❌

Strongest layer: ingest → analysis → review → graph. This is real and tested, not vaporware.
The actual missing spine: the translation from "verified findings" into "structured Authority System deliverable." This is v1 work, not v2 — it's the thing Exhibit B is supposed to be, and right now nothing builds it. The report generator formats a PDF; it doesn't compose a system.
v2 correctly deferred: the quarterly feedback loop, client portal, and recommendation engine from the Authority Engine doc. Don't pull that forward — it depends on the missing spine existing first.
What the "Workspace" idea (from JobHunt) maps to here
You already have the equivalent of workspace.php — it's the Client View/Drill-In (Timeline/Graph/Findings/Report/Payment/Email tabs), locked and mostly built. The fix isn't a new page. It's that the Findings and Report tabs need a real object between them — something that holds "Authority Initiative," "Recommendation," "Claim → Strategy" — instead of jumping straight from reviewed claims to a formatted PDF.
Suggested next concrete step
Scope a single work order: define the minimum data shape for an "Authority System" record (sections it must contain — positioning, channels, content calendar, initiatives — pulled from Master Law's canon language) and wire report_module.php to compose from that structured record instead of whatever it currently pulls from. Small, testable, and it's the one piece that turns "1-3 page dossier" into "the actual paid deliverable."

