LEGAiSEE — What the Orphaned Engine Files Actually Are
You asked the right question: they weren't built for nothing. Read through all 15+ of them. They fall into two very different categories that need two very different answers.

CATEGORY 1: A ready-made fix for today's #1 problem — plain_english_helper.php
This one is not speculative architecture. It's a direct, already-built solution to the exact core finding of this whole audit.
Its own file header says, verbatim: "Every module currently shows raw numbers. This helper converts them into sentences a client can read."
Someone — almost certainly a past AI session — diagnosed this exact problem before, and built the fix. It has working, specific translator functions for:
Relations (lee_interpret_relations)
Graph / Network (lee_interpret_graph)
Anomaly (lee_interpret_anomaly)
Insight (lee_interpret_insight)
Recommendation (lee_interpret_recommendation)
Cluster (lee_interpret_cluster)
Cross-Case (lee_interpret_cross_case)
Time Intelligence (lee_interpret_time_intelligence)
Plus a generic fallback for anything not named above.
That list maps almost one-to-one onto the modules flagged in the earlier audits as "real data, dumped as raw JSON" — Relations, Network Graph, Cross-Case Engine, Time Intelligence, Anomaly, and Recommendation are named specifically.
Why it's disconnected: nothing calls lee_interpret(). It was built, and then the work to actually route each module's output through it — replacing json_encode($content) with lee_interpret($module, $data) — never happened. It's a finished tool sitting in a drawer.
Should it be wired in? Yes — this is close to a genuine "we already built the fix" situation, not new work. It doesn't need to be designed; it needs to be called. This should move to the top of whatever fix-priority list comes out of the audit, above the uic_v1.php approach discussed earlier — this file already exists specifically for this purpose, hand-tailored to these exact modules, and doesn't require touching the rendering machinery in shell.php at all.

CATEGORY 2: A real, coherent, unfinished "autonomous intelligence" architecture
The rest — goal_engine, goal_generator, goal_alignment, goal_arbitration_engine, goal_conflict_resolver, long_horizon_planner, decision_governor, governance_policy_engine, graph_mutation_engine, execution_feedback_engine, cross_case_learning_compiler, temporal_memory_engine, memory_evolution_engine, pattern_stability, insight_mutator, system_behavior_spec — are not random scraps. Read together, they form one coherent pipeline, in order:
goal_generator.php — scans the graph, groups signals by cluster, proposes candidate goals.
goal_alignment.php — scores how well a graph node supports a given goal (a simple keyword-overlap + strength/priority formula — functional but basic, not sophisticated NLP).
goal_arbitration_engine.php — filters out low-confidence goals (below 60%), ranks the rest.
goal_conflict_resolver.php — removes contradictory goals, keeps the higher-priority one.
pattern_stability.php — statistically checks a pattern isn't just noise before it's allowed to become a goal (needs 5+ data points, checks variance).
long_horizon_planner.php — looks at historical trend + the surviving goals, simulates where the system is heading.
decision_governor.php — the actual gatekeeper: scores a proposed action starting at 100 and subtracts points if it's not goal-aligned or violates other rules — this is what would decide whether the system is allowed to act on its own conclusions.
governance_policy_engine.php — the constraints file: max 10 active goals, max 200 queued tasks, max 15 "mutations" per cycle, plus named prohibited behaviors.
graph_mutation_engine.php — labeled in its own header "controlled self-rewriting intelligence layer" — actually edits the graph based on insights.
execution_feedback_engine.php — compares what the system did against what actually happened, generates a learning signal.
cross_case_learning_compiler.php — aggregates those learning signals across every client/case into system-wide weights, separating universal patterns from single-case noise.
temporal_memory_engine.php / memory_evolution_engine.php — snapshot the system's state and beliefs over time, so it can be compared later ("what we believed then vs. now").
system_behavior_spec.php — a config file naming LEGAiSEE's primary domain (client business intelligence) and listing intended future expansion domains: CRM, archaeology AI, document intelligence, media analysis, field data processing.
This is not filler code. It's a real, thought-through design for a self-directing system: propose goals from real data → filter/rank/deconflict them → check they're stable, not noise → plan a trajectory → gate any action against goals and hard constraints → act → measure the outcome → learn from it, per-case and system-wide → remember what changed over time.
And here's the important part: this is the same architecture already described in your [[legaisee-authority-engine]] vision doc — recommendations with a full lifecycle (evidence → decision → outcome → reassessment), quarterly system evolution, versioned beliefs over time, a change-detection engine. Someone (likely during a Windsurf or GPT "architect mode" session, matching the pattern already flagged in that file) started actually building toward that vision at the code level — and it stopped mid-wiring, before anything in modules/ was ever connected to it.
Why it's disconnected — most likely explanation: this is exactly the shape of a multi-session AI build that ran out of runway (quota, context, or scope) after the components were written but before the last step — wiring them into the live request path — happened. Nothing here looks abandoned due to being wrong; it looks abandoned due to being unfinished.
Should it be wired in?
Honestly — not yet, and not as the next move. Two reasons:
It depends on things that don't exist yet. This whole pipeline assumes a goals database table, and assumes the graph/entity data underneath it is trustworthy — but this same audit found the graph pipeline itself has wiring gaps (Network Graph not reading network.json) and a presentation layer that hides real data. Autonomous goal-generation built on top of a foundation that's still being stabilized would just produce a more sophisticated version of the same "confidently wrong/invisible" problem already found everywhere else today.
It's the single biggest scope risk in the whole codebase. This is the exact kind of thing you flagged wanting to avoid — an ambitious autonomous system becoming its own months-long project, layered on top of a foundation that isn't finished.
Is it a feature you'd lose by not wiring it in right now? No — nothing currently depends on it, so leaving it alone loses nothing. It's safe to set aside as a real, already-designed future phase — worth keeping (don't delete it), worth referencing when the Authority Engine work resumes, but not worth activating until the basics (presentation, real ingest, correct wiring) are solid enough to trust feeding it.

Direct answers to your four questions
What do they do? One (plain_english_helper.php) is a ready-made fix for today's core finding. The rest form a real, coherent autonomous goal/planning/governance/learning pipeline.
Why were they built? Almost certainly a prior AI session working toward the same long-term vision already in [[legaisee-authority-engine]] — persistent, evolving, self-improving business memory — starting at the code level before the foundation under it was ready.
Why are they not connected? Most likely ran out of build session before the final wiring step. Nothing found suggests they were abandoned because they were broken or wrong.
Should they be connected? Do you lose a feature by not doing it now? plain_english_helper.php — yes, connect it soon, it's a near-free fix. The goal/planning/governance cluster — no, not yet; nothing depends on it today, and wiring it in before the foundation is stable would risk becoming exactly the kind of open-ended project you've said you want to avoid.

