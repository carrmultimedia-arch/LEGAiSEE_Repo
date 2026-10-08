LEGAiSEE System Audit — modules-utils-bootstrap-the Recommendation Module Question
Audit type: Macro/system-level — real connections, not "does it execute."
The question this closes
Earlier audits found the codebase has TWO different recommendation_engine.php files (one in kernel/, one in engine/), both dead code, plus api/recommendations_generate.php whose live status was unconfirmed. The open question was: where does the real, working Recommendation feature actually get its content from?
What modules/utils/bootstrap.php actually is
Not recommendation-specific at all. It's a small (33-line) generic utility file containing one function: load_json_dir(), which reads every .json file in a folder and returns them as an array. It's a shared helper — 9 different modules use it (dashboard, cases, alerts, relations, time intelligence, root cause graph, decisions, predictive, and recommendations), plus 6 more files that just require it without calling that specific function.
Where the real Recommendation logic actually lives
modules/recommendation_module.php (48 lines) — this is the true live source, confirmed wired into shell.php. It:
Loads every case file from data/cases/ (via load_json_dir())
Reads each case's detected patterns array
Runs each pattern through a small hardcoded lookup table (ops_delay, pricing_pressure, lead_friction, labor_issue → a title/action/priority triple)
Falls back to a generic "Investigate Pattern: X" recommendation for any pattern not in the table
Returns a plain list — no AI, no engine file, no external call involved
So the honest picture: the live Recommendations feature is a simple rules-lookup against already-detected patterns, not a generation engine. It's functional, but simplistic — same pattern already seen elsewhere in this audit (real feature, much thinner than the surrounding architecture would suggest).
api/recommendations_generate.php — now confirmed dead-but-reachable
This file is technically wired into api.php's router (case "recommendations" → calls it → which requires kernel/recommendation_engine.php's generateRecommendations()). But a full-codebase search found no caller anywhere — no UI button, no JS fetch, nothing — that ever triggers action=recommendations against api.php. This is the exact same "present but never called" pattern already documented in the api/v8 + cli + engine/ autonomous-agent cluster: reachable if hit directly, invisible to the actual product.
New finding: bootstrap.php naming collision is worse than previously known
There are five files named bootstrap.php in this codebase, not the two (kernel/, root) already on record:
/bootstrap.php (root) — 2 lines
/kernel/bootstrap.php — 2 lines
/modules/utils/bootstrap.php — 33 lines (the one covered here)
/ProjectManager/bootstrap.php — 67 lines
/lib/vendor/stripe/stripe-php/tests/bootstrap.php — third-party test file, not part of the system, safe to ignore
All four non-vendor ones are genuinely different files with different jobs. This is the same collision-risk pattern flagged with the *_engine.php files — a future edit by any AI or by John needs to be careful to target the exact right bootstrap.php.
Section summary
Question closed: recommendation content comes from modules/recommendation_module.php, a simple hardcoded pattern-lookup, not from either recommendation_engine.php or bootstrap.php. bootstrap.php itself is just a shared JSON-loading utility. The dead kernel/recommendation_engine.php is technically reachable through api.php's router but has no live caller — consistent with the broader dead-cluster findings already on record.

