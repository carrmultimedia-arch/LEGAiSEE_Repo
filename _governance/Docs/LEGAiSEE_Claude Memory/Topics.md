Dev Workflow
Summary
John's preferred coding workflow/tools for building his apps as a non-coder
Details
Prefers a local workflow: code in Windsurf/VS Code, then upload to the server via FileZilla when ready
Frustration point: code-build tokens/usage limits expire fast on free plans
Windsurf sessions work well quality-wise, but daily/monthly usage caps force waiting between sessions; finds VS Code AI extensions inadequate or not free
Considering reverting to a "bible" document + manually copy-pasting LLM-generated code, due to budget constraints and subscription/usage-cap friction
Testing qwen2.5-coder:7b running locally via Ollama as a free executor option
Decided to shift workflow back to: Claude tracks the project and writes work orders, GPT/Kimi/etc. generate code from them, John reviews/pastes the code into cPanel's File Manager himself — reserving Windsurf's capped sessions for larger multi-file builds rather than small fixes
Runs Cline in VS Code (currently pointed at local qwen2.5-coder:7b via Ollama); machine has 16GB RAM, a real ceiling on local model size/quality. qwen2.5-coder:7b proved unreliable on multi-step/multi-file tasks (invents nonexistent paths, loops on questions it already answered).
Switched Cline's provider to Google Gemini (2.5 Pro, free tier via Google AI Studio API key) as of 2026-08-05 — succeeded on the first try at a task the local model had looped on all evening. Free tier is expected to be rate-limited and may drop to Gemini Flash once quota's hit, so best reserved for harder/higher-value tasks rather than every small check.
Also has GitHub Copilot's free tier available as a lower-setup fallback (agent mode, no API key management) if the Gemini quota runs out mid-session.
Standing methodology going forward (adopted 2026-08-05, explicitly to avoid repeating the system's own history of side-tangent drift): design work stays in pure design mode by default. If a design decision hits a real unknown (an assumption that needs verifying against actual code/schema), pause design, audit/check the real files to learn ground truth, document that specific check as its own entry in the Bible doc, then return to design where it left off — not open-ended exploration, not fixing what's found along the way unless explicitly asked.
Standing instruction: whenever Claude gives an execute-ready instruction/prompt for Cline (or any executor), suggest which available model/tool fits that specific instruction best (e.g. Gemini free tier for harder multi-file reasoning, local Ollama for trivial/low-stakes edits, Windsurf's capped hours for large builds).
John now has a reset daily and weekly Windsurf quota. New standing workflow going forward: split remaining work into small VS Code/Gemini-suitable fixes vs. larger/more complex multi-file Windsurf WOs, handed out of strict build order when useful since everything stays local until John does a manual upload. Wants a "built locally, not yet published/uploaded" tracking list maintained given this local-first workflow.
Reconsidering executor tooling as of 8/19: Windsurf only clears ~3/4 of a work order per week before hitting limits; Gemini/VS Code has a track record of fabricating results; other free VS Code agents tend to hang/not complete tasks. Leaning back toward the manual workflow (GPT/Kimi generate code, John copy-pastes into cPanel) since that's how most of LEGAiSEE was originally built.
LOCKED workflow decision (8/19): Claude has proven most trustworthy so far, so Claude becomes primary architect + code writer for new LEGAiSEE work, using file-download output (not chat-paste) to avoid page-splitting/length limits — John pastes to server and verifies via FileZilla timestamp, same trust model as before. Cline/Gemini/local tools get reassigned to a narrower "file survey" role only — reading and reporting back the content of multiple existing files (3-5+) when a task needs that context — instead of John manually pasting several full files into chat and burning tokens. GPT/Kimi remain backup/parallel code-generation capacity; Windsurf remains available for genuinely large multi-file builds when quota allows, not the default anymore.
LOCKED workflow decision (8/26, superseded same day): zip uploads to Claude are eliminated entirely going forward — too token-expensive.
MAJOR UPGRADE (8/26, same day): John surfaced a live-mirrored GitHub repo — https://github.com/carrmultimedia-arch/LEGAiSEE_Repo (confirmed real via direct file content matching prior audit findings exactly, e.g. root cluster_engine.php's clusterNodes()). This replaces the snippet-paste workflow entirely: Claude can git clone the repo directly in its own sandbox (github.com/codeload.github.com are allowed network domains) and grep/read the ACTUAL current code directly — no zip, no snippet-pasting, no relying on possibly-stale audit-file memory for anything checkable this way. This is now the primary verification method for any live/dead-caller question, exact-current-text patches, etc. Confirm repo freshness/sync-with-live-server periodically if something seems off, but treat it as ground truth by default.

Music
Summary
John's musicianship
Details
Working musician (guitar and piano since the mid-1980s)


Production Background
Summary
John's multimedia and broadcast production career history
Details
33-year production career spanning broadcast television (KPLC NBC, KVHP FOX 29, WLFT), institutional/corporate production (including Houston Methodist Hospital), and aerial/drone cinematography
Holds an FCC license; worked as a broadcast TD
Aerial/drone cinematography, FAA Part 107 certified
Addy Award recipient
Production background forms the "Exhibit Zero" proof-of-concept underpinning the LEGAiSEE practitioner page (includes Rock and Roll Fantasy Camp clips with professional musicians)
Carr Multimedia's excavation surfaced three eras: Broadcast Years (1992–2006, Golden Era), Houston Build (2006–2020), Methodology Emergence (2020–present)



Recent Work
Summary
Work activity and job-search context that doesn't rise to a standalone project
Details
Actively seeking regular employment in broadcast/multimedia production
Considering applying for an in-house Content Producer/Social Media role at Lind Plastic Surgery (Spring, TX)
Currently unemployed, actively job hunting

