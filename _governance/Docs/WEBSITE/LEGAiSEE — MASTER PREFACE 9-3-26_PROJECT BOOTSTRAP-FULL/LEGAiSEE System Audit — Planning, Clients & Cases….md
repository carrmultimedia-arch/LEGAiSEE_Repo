LEGAiSEE System Audit — Planning, Clients & Cases, and Tools
Audit type: Macro / system-level. Final three sidebar sections.

Planning
Project Board (modules/pm_module.php)
Supposed to do: task/project kanban, Backlog → Done.
What it actually does: a substantial (922-line), real drag-and-drop kanban board with live status updates.
Verdict: Built correctly. Consistent with the level of investment visible in the ProjectManager governance docs already on file.

Clients & Cases
Client Vault (modules/clients_module.php)
What it actually does: real client list with city/state/UID, dispatched through the 'type' => 'list' rendering path (a real named renderer, not the generic fallbacks).
Verdict: Built correctly, human-legible.
Cases (modules/cases_module.php)
What it actually does: real HTML — case ID, color-coded status, client name, pattern tags.
Verdict: Built correctly, human-legible.
Vault (modules/vault_module.php)
What it actually does: real file/artifact storage UI — and also contains the actual "create Stripe checkout" JavaScript logic.
Cross-module finding: the checkout-creation code lives here, in Vault — not in the separate "Payments" module (below), which is what the sidebar implies would handle payments.
Reports (modules/report_module.php)
What it actually does: generates a real PDF, confirmed working mechanically. Already flagged in prior sessions as a "thin dossier" — it only pulls approved findings with a note, not a composed Authority System record. No new finding here, just confirming it's consistent with what's already on record.
Payments (modules/payment_module.php)
Supposed to do, per sidebar: "Stripe checkout & billing."
What it actually does: displays a static price list for the Exhibit tiers. That's it — no checkout button, no billing history, no actual Stripe interaction in this file.
Cross-module finding, paired with Vault above: the sidebar puts "Payments" and "Vault" in the same section as if they're separate concerns, but the real checkout logic is in Vault, not Payments. If you click "Payments" expecting to start or review a checkout, you'll only ever see a price list — the actual working feature is one click away, mislabeled.
Verdict: Static/incomplete relative to its own label; the real capability exists but is filed under the wrong sidebar entry.

Tools
Compare (modules/compare_module.php) — MAJOR FINDING
Supposed to do, per sidebar: "Dual-document intelligence compare."
What it actually does: a form with two text boxes (Set A / Set B). If both are filled in, it just echoes back whatever you typed — there is no comparison logic in this file at all.
The real logic exists and is orphaned: ui/compare_engine.php contains a genuine comparison renderer (side-by-side rendering, a toggle view) — but I searched the entire codebase for anything that includes or requires this file, and nothing does. It's dead code, fully built, completely disconnected from the module the sidebar actually points to.
Verdict: Same pattern as Root Cause/Network Graph and Predictive Link V1 — real capability exists in the codebase, wired to nothing. This is the clearest "stub in front, real logic orphaned behind" case found in the whole audit.
View (modules/view_module.php)
What it actually does: a real interactive artifact/diff viewer, JS-driven.
Verdict: Built correctly.
Alert (modules/alert_module.php)
What it actually does: real detection logic (e.g. flags a "lead decline detected" pattern per case) producing genuine alerts.
Rendering path: JSON-dump pattern, same fixable translation gap as most of Intelligence Engines.
Verdict: Real logic, translation gap.

Whole-system summary (all sections combined)
The dominant pattern across all ~30 modules audited: the system's underlying logic is, in most places, genuinely working and often quite sophisticated — real risk scoring, real pattern prediction, real clustering, real client/case data. The system fails almost entirely at the last step: showing you what it found in a way you can read. That happens in three distinct, now-identified ways:
Raw JSON dumped into a <pre> box — the single most common failure, traced to one shared function (render_inspector()), affecting roughly half of all modules audited (Relations, Root Cause, Semantic Cluster, Cross-Case, Excavation, Decision, Predictive, Time Intelligence, Alert, Executive Dashboard, Brain, System Dashboard).
Real list data silently collapsed to just a count — a second shared function (exec-panel fallback), confirmed to destroy Predictive Link V1's actual output entirely.
Real, working logic that exists in the codebase but is never called by the module the sidebar actually points to — confirmed three times: Root Cause writes graph data Network Graph never reads; a real comparison engine (compare_engine.php) is fully orphaned behind a stub; Vault holds the real payment logic that "Payments" implies it should have itself.
Two additional standalone findings, unrelated to presentation:
Insight is a mis-wired duplicate of Ingest, writing to conflicting column names in the same database table — a build/wiring mistake, not a display issue, and a plausible partial explanation for "ingest doesn't save."
Memory Ingest's file-upload path has a confirmed silent-failure bug (leftover SQLite syntax + an empty error catch) that can show "success" even when the database save failed.
What already works well, as a reference for what "done" looks like: Cockpit, Clusters, Ingest View, Files, Search, Dig Review, Client Vault, Cases, Project Board, Intel Dashboard (via the uic_v1 system), Compare's sibling engine file (though unwired), and Recommendation.
Every module in the whole sidebar is still labeled 'status' => 'working' in shell.php's source, regardless of any of the above — confirmed system-wide, not section-specific.

Audit complete — all sidebar sections covered: Command, Planning, Clients & Cases, Excavation, Intelligence Engines, Graph & Entities, Tools.

