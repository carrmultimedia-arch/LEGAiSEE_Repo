

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LEGAiSEE — Grand Lobby</title>

<style>

/* =====================================================
   BASE SYSTEM STYLE (STABLE + SIMPLE)
===================================================== */

body {
    margin: 0;
    padding: 40px;
    font-family: Arial, sans-serif;
    background: #0b0b0d;
    color: #d6b35a;
}

/* LAYOUT */

.wrap {
    max-width: 1200px;
    margin: auto;
}

/* PANELS */

.panel {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 12px;
}

/* FORM */

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

label {
    font-size: 11px;
    color: #8a6a2a;
    text-transform: uppercase;
}

input, select, textarea {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #333;
    background: #111;
    color: #f4e185;
}

textarea {
    min-height: 180px;
}

.full {
    grid-column: 1 / -1;
}

button {
    margin-top: 15px;
    width: 100%;
    padding: 12px;
    border-radius: 999px;
    border: none;
    background: #f4e185;
    color: #111;
    font-weight: bold;
    cursor: pointer;
}

/* TABLE */

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

td, th {
    border-bottom: 1px solid rgba(255,255,255,0.08);
    padding: 8px;
    text-align: left;
    font-size: 13px;
}

</style>
</head>

<body>

<div class="wrap">

<!-- =====================================================
     EXEC VIEW (PIPELINE TEST OUTPUT)
===================================================== -->

<div class="panel">
    <h2>Executive Snapshot</h2>

    <div>System operational — ingest pipeline active.</div>

    <table>
        <tr>
            <th>Session</th>
            <th>Source</th>
            <th>Date</th>
        </tr>

                <tr>
            <td>_Llama on Sureserver</td>
            <td>ChatGPT</td>
            <td>2026-05-08 04:44:42</td>
        </tr>
                <tr>
            <td>LEGAiSEE Server Build 5-7-26</td>
            <td>ChatGPT</td>
            <td>2026-05-08 04:40:34</td>
        </tr>
                <tr>
            <td>LEGAiSEE Server Build 5-8-26</td>
            <td>ChatGPT</td>
            <td>2026-05-08 04:39:29</td>
        </tr>
                <tr>
            <td>Building a psychotherapy telehealth SAAS with insurance integration</td>
            <td>Claude</td>
            <td>2026-05-08 04:32:00</td>
        </tr>
                <tr>
            <td>Building a psychotherapy telehealth SAAS with insurance integration</td>
            <td>Claude</td>
            <td>2026-05-08 04:25:17</td>
        </tr>
        
    </table>
</div>

<!-- =====================================================
     INGEST FORM
===================================================== -->

<div class="panel">

    <h2>Memory Ingest Wing</h2>
    <div>Sovereign Memory Intake</div>

    <form method="POST">

        <div class="grid">

            <div class="field">
                <label>Memory Domain</label>
                <select name="domain_id">
                    <option value=''>Select</option><option value='2'>General Archive</option><option value='3'>Legaisee Build</option><option value='1'>LEGAiSEE Vault</option>                </select>
            </div>

            <div class="field">
                <label>Project</label>
                <select name="project_id">
                    <option value=''>Select</option><option value='1'>AI Memory System</option>                </select>
            </div>

            <div class="field">
                <label>AI Source</label>
                <select name="source_ai">
                    <option>ChatGPT</option>
                    <option>Claude</option>
                    <option>Gemini</option>
                    <option>Grok</option>
                    <option>Cursor</option>
                    <option>Windsurf</option>
                </select>
            </div>

            <div class="field">
                <label>Session Title</label>
                <input name="session_title" type="text">
            </div>

        </div>

        <div class="field full">
            <label>Transcript</label>
            <textarea name="raw_transcript"></textarea>
        </div>

        <button type="submit">INGEST</button>

    </form>

</div>

</div>

</body>
</html>