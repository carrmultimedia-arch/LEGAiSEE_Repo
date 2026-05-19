// CLOSED-LOOP AUTONOMOUS INTELLIGENCE ENGINE (v1)

let SYSTEM_STATE = {
    baselineAnomaly: 0,
    adaptationRate: 0.05,
    memory: {}
};

/* ---------------- OUTCOME SIMULATION ---------------- */

function simulateOutcome(beforeScore, actionImpact){

    // simulate system change after execution
    let improvement = actionImpact * (Math.random() * 0.6 + 0.2);

    let afterScore = Math.max(0, beforeScore - improvement);

    return {
        before: beforeScore,
        after: afterScore,
        delta: beforeScore - afterScore,
        effectiveness: improvement / (beforeScore || 1)
    };
}

/* ---------------- ADAPTIVE THRESHOLD ENGINE ---------------- */

function updateSystemThresholds(outcome){

    let memory = SYSTEM_STATE.memory;

    if(!memory.total) memory.total = 0;

    memory.total++;

    // system learns whether actions work
    if(outcome.delta > 10){
        SYSTEM_STATE.adaptationRate += 0.01;
    } else {
        SYSTEM_STATE.adaptationRate -= 0.005;
    }

    SYSTEM_STATE.adaptationRate = Math.max(0.01, Math.min(0.2, SYSTEM_STATE.adaptationRate));
}

/* ---------------- REINFORCEMENT LEARNING (LIGHTWEIGHT) ---------------- */

function reinforceDecision(decision, outcome){

    let key = decision.title;

    if(!SYSTEM_STATE.memory[key]){
        SYSTEM_STATE.memory[key] = {
            success:0,
            failure:0,
            score:0
        };
    }

    let entry = SYSTEM_STATE.memory[key];

    if(outcome.delta > 5){
        entry.success++;
        entry.score += 2;
    } else {
        entry.failure++;
        entry.score -= 1;
    }

    // clamp
    entry.score = Math.max(-10, Math.min(10, entry.score));
}

/* ---------------- CLOSED LOOP STEP ---------------- */

function runClosedLoopEngine(decisions, currentAnomaly){

    let results = [];

    decisions.forEach(d => {

        let outcome = simulateOutcome(currentAnomaly, d.impact);

        reinforceDecision(d, outcome);
        updateSystemThresholds(outcome);

        results.push({
            decision: d.title,
            outcome: outcome
        });
    });

    return results;
}