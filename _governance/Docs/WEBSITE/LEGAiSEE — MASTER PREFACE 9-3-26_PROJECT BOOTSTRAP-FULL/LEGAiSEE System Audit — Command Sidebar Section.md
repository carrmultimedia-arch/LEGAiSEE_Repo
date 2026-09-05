LEGAiSEE System Audit — "Command" Sidebar Section
Audit type: Macro / system-level. Not "does the PHP execute."
Status labels in shell.php: all 5 marked 'status' => 'working'.

POSITIVE FINDING: a third, genuinely good rendering system already exists and is barely used
modules/utils/uic_v1.php is a small, well-designed component library — uic_artifact() (title, summary, bulleted signals, confidence %), uic_dataset() (readable metric/value/status rows), uic_system() (a plain status message). These render as real cards and labeled rows, not JSON dumps. Only Intelligence Dashboard (below) currently uses it.
This matters a lot for "how do we fix this without months of work": the fix for most of the JSON-dump problem found across Graph & Entities, Excavation, and Intelligence Engines doesn't require inventing a new display pattern — it requires routing existing correct data through uic_dataset()/uic_artifact() instead of json_encode(). That's a mechanical swap in each module, not new design.

1. System Dashboard (modules/dashboard_module.php)
Supposed to do: overview of cases & clients.
What it actually does: counts cases and clients — that's the entire module, 20 lines.
Rendering path: JSON-dump pattern (small — just two numbers, but still wrapped as raw JSON text rather than "X cases, Y clients").
Verdict: Trivial, correct, poorly presented for how simple a fix would be.
2. Intel Dashboard (modules/intelligence_dashboard_module.php)
Supposed to do: executive intelligence overview.
What it actually does: builds a real artifact card + dataset + system-status message using the uic_v1 system above.
Rendering path: the good one — actual cards, not JSON.
Verdict: Built correctly, and proof the good rendering pattern already works elsewhere in the system.
3. Executive Dashboard (modules/executive_dashboard_module.php)
Supposed to do: system overview, top risk patterns, pattern frequency, system health.
What it actually does: real computed data across all four sections.
Rendering path: JSON-dump pattern for all four blocks — ironically, this dashboard doesn't use the uic system Intel Dashboard (a very similarly-named, similarly-purposed module) already uses two files away.
Verdict: Real data, same fixable translation gap. Notable that two dashboards with near-identical purposes ended up on two different rendering paths — one good, one not.
4. Brain (modules/brain_module.php)
Supposed to do, per its own sidebar description: "System intelligence & module registry" — i.e., this is meant to be the system's own self-status report.
What it actually does: genuinely checks system status, the module registry, data-layer readiness, and engine health.
Rendering path: JSON-dump pattern for every section.
Verdict: worth calling out specifically — the one module whose entire job is telling you what state the system is in fails the exact same legibility test as everything it's supposed to be reporting on.
5. Cockpit (modules/cockpit_module.php)
Supposed to do: main landing dashboard with health status and navigation into the rest of the system.
What it actually does: real HTML, health-status indicators, and a "System Pillars" tile grid linking into Clients, Excavation, Dig Review, Graph, Vault, Payments, Ingest.
Rendering path: bypasses the fallback system entirely — hand-built HTML, like Clusters/Ingest/Files/Search/Dig Review.
Verdict: Built correctly. Consistent with the earlier note that Cockpit was the first clean full render confirmed in this system.
One thing worth naming: its "System Pillars" tile for Knowledge System links to ?module=graph — the same Network Graph card confirmed broken (bare counts only) in the first audit. Cockpit itself is fine; it's pointing at a module downstream that isn't.

Section summary
2 of 5 (Cockpit, Intel Dashboard) are built correctly — one via hand-written HTML, one via the good uic_v1 component system.
3 of 5 (System Dashboard, Executive Dashboard, Brain) have real, correct underlying data undermined entirely by the JSON-dump rendering path — including Brain, whose whole job is supposed to be showing you system health in the first place.
Confirms the fix priority forming across the whole audit so far: this is overwhelmingly a presentation-layer problem, not a logic problem. Most engines compute the right thing; most screens fail to say so in plain language.

Next: Clients & Cases (Client Vault, Cases, Vault, Reports, Payments) and Tools (Compare, View, Alert) — the last two sections.

