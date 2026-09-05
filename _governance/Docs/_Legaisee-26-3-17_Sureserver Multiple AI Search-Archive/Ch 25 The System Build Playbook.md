CHAPTER 25: The System Build Playbook — Granular Execution Guide
Overview
When a client says YES to Stage 2 (The Build, $5,500–$18,000), you have 21 days to deliver four core systems that transform their content chaos into a repeatable machine. This chapter is your click-by-click instruction manual.
The Four Core Systems:
Content Production Engine (Days 1–7) — AI workflows that generate scripts, hooks, repurposed content, and optimized titles
Publishing Rhythm (Days 8–14) — Calendar, scheduling, approval workflows, and batch production
Performance Feedback Loop (Days 13–16) — Metrics dashboard and weekly review rituals
Asset Library & Reuse System (Days 17–20) — Organized, searchable, reusable content archive
Week 3 (Days 15–21): Training, soft launch, documentation, and handoff to retainer.

WEEK 1: FOUNDATION & AI WORKFLOWS (Days 1–7)
DAY 1: CLIENT DEEP-DIVE INTERVIEW
Objective: Extract voice, goals, constraints, and success criteria
Time: 4 hours (2-hour call + 2-hour processing)
The Interview Structure (120 minutes)
Segment 1: Voice & Style (30 minutes)
"Let's talk about how you communicate. I'm going to describe 5 pieces of content — tell me which sounds most like you and why."
Show 5 variations of the same message: formal, casual, humorous, technical, story-based
Note their choice and reasoning
Ask: "If you could only use one style forever, which?"
Ask: "What do your customers say about how you explain things?"
Segment 2: Goals & Success (30 minutes)
"What does success look like 6 months from now? Be specific."
Metric goals: Revenue, leads, engagement rates?
Qualitative goals: Authority, trust, awareness?
Personal goals: Time freedom, team confidence, legacy?
Ask: "What would make you say 'this was worth every penny'?"
Segment 3: Constraints & Boundaries (30 minutes)
"What are the hard constraints I need to design around?"
Time: How many hours weekly can they spend on content?
Skills: What can't they do? (video editing, writing, design?)
Approvals: Who must approve? How fast?
Taboos: What will they never say or do?
Compliance: Industry regulations, legal review needed?
Segment 4: Content Examples (30 minutes)
"Show me your best content — what you're proud of, what worked."
Request 3–5 examples (emails, posts, videos)
Ask: "Why did this work? What were you thinking?"
Ask: "What do you wish you could create more of?"
Ask: "What have you tried that failed?"
Post-Interview Processing (2 hours)
Transcribe key quotes (use Otter.ai or manual)
Create Voice Profile draft (Chapter 26 framework)
Document Goals & Constraints summary
Tag content examples by pillar, format, performance
Draft initial content pillars (3–5 themes)
Deliverable: Voice Profile v0.1, Goals Document, Content Examples Library, Draft Pillars

DAY 2: VOICE EXTRACTION & PROFILE FINALIZATION
Objective: Create the 8-dimension voice profile that makes AI sound like them
Time: 4 hours
The 8-Dimension Analysis
Dimension 1: Vocabulary Register
Read through 5 content examples
Count technical terms per paragraph
Note jargon density (heavy/moderate/light/none)
Rate formality (1–10, 10=academic paper, 1=text to friend)
Document specific words they use repeatedly
Dimension 2: Sentence Architecture
Calculate average words per sentence (total words ÷ sentence count)
Note simple vs. compound vs. complex sentence mix
Observe fragment usage (frequent/occasional/rare)
Document rhythm preference
Dimension 3: Humor & Tone
Identify humor type (witty, self-deprecating, observational, absent)
Rate enthusiasm level (1–10, 10=hyped, 1=restrained)
Note emotional openness (guarded/warm/vulnerable)
Document conflict handling style
Dimension 4: Perspective & Stance
Determine expert vs. peer positioning
Note teacher vs. learner stance
Observe optimist vs. realist vs. critic default
Document insider vs. outsider language
Dimension 5: Transitions & Flow
Highlight favorite transition phrases
Note storytelling transitions
Count question usage per piece
Document pacing signals
Dimension 6: CTAs & Directives
Analyze command strength ("Do this" vs "Consider" vs "You might")
Note urgency level ("Now" vs "Soon" vs "When ready")
Observe benefit framing
Document risk addressing
Dimension 7: Evidence & Proof
Count data points per piece
Note anecdote style (personal/observed/hypothetical)
Observe social proof integration
Document authority signaling
Dimension 8: Visual Language
Highlight metaphors and analogies
Note sensory detail dominance
Observe concrete vs. abstract preference
Document scene-setting frequency
Voice Profile Write-Up (1 hour)
Template:
"[Client] communicates as a [expert/peer] with [enthusiasm level] enthusiasm. Their vocabulary is [technical level], using [jargon level] industry terminology with [formality level] formality. Sentences average [X] words, creating a [rhythm description] rhythm. Humor is [type/frequency]. They address readers as [relationship], using [CTA style] calls to action. Evidence comes through [proof types]. Visual language is [metaphor frequency], creating [imagery type] imagery."
Deliverable: Finalized 8-Dimension Voice Profile (1 page), Voice Modifiers for Prompts (bullet list)

DAY 3: SCRIPT GENERATOR BUILD
Objective: Create the AI workflow that writes video scripts in their voice
Time: 4 hours
Step 1: Base Prompt Engineering (90 minutes)
Template:
plainCopy
You are [CLIENT_NAME], a [INDUSTRY] expert with [VOICE_TRAITS].

Write a [PLATFORM] script about [TOPIC_VARIABLE].

Requirements:
- Hook: First 3 seconds must [HOOK_TYPE: question/shock/promise/curiosity gap]
- Length: [DURATION] seconds = approximately [WORD_COUNT] words
- Tone: [VOICE_PROFILE_SUMMARY]
- Structure: Hook → Problem → Solution → Proof → CTA
- Include: [KEY_POINT_1], [KEY_POINT_2], [KEY_POINT_3]
- CTA: [SPECIFIC_ACTION] with [URGENCY_LEVEL]

Output format:
HOOK: [text]
PROBLEM: [text]
SOLUTION: [text]
PROOF: [text]
CTA: [text]

Write in the style of [CLIENT_NAME]: [VOICE_MODIFIERS]
Step 2: Testing & Refinement (90 minutes)
Test 1: Run prompt with simple topic
Does it sound like them?
Voice markers present?
What's missing?
Revise: Adjust voice modifiers, add specific vocabulary
Test 2: Run with complex topic
Does complexity break voice consistency?
Technical terms used correctly?
Revise: Add technical vocabulary list
Test 3: Run with emotional topic
Does emotion feel authentic?
Tone appropriate?
Revise: Add emotional range guidance
Step 3: Variation Creation (60 minutes)
Create 3 platform variants:
TikTok: 60 seconds, high energy, pattern interrupt at 0:30
YouTube: 8–10 minutes, educational, retention hooks every 2 min
LinkedIn: 3–5 minutes, professional, data-supported
Create 3 hook type variants:
Question hook: "What if I told you..."
Shock hook: "I can't believe I'm sharing this..."
Promise hook: "In the next 60 seconds, you'll learn..."
Deliverable: Script Generator Base Prompt (tested), 3 Platform Variants, 3 Hook Type Variants

DAY 4: HOOK TESTER BUILD
Objective: Create the system that rates and improves opening lines
Time: 4 hours
Step 1: Hook Pattern Library (60 minutes)
Curiosity Gap:
"I discovered something that changed everything..."
"The truth about [common belief] that nobody talks about"
Pattern Interrupt:
"Stop doing [common practice] immediately"
"I was wrong about [topic] for 10 years"
Specificity Shock:
"Exactly 73% of [audience] make this mistake"
"I lost $50K learning this lesson"
Identity Challenge:
"If you're [identity], you need to hear this"
"Real talk for [profession/role] only"
Step 2: Rating Rubric (60 minutes)
Rate 1–10 on:
Curiosity Gap
Specificity
Emotional Trigger
Pattern Interrupt
Relevance
Total ÷ 5 = Average rating
Step 3: AI Prompt Engineering (90 minutes)
plainCopy
Rate these 5 hooks for [PLATFORM] targeting [AUDIENCE]:

[Hook 1]
[Hook 2]
...

Rate each 1-10 on:
1. Curiosity Gap
2. Specificity
3. Emotional Trigger
4. Pattern Interrupt
5. Relevance

For each hook:
- List specific strengths
- Identify one weakness
- Suggest one improvement

Recommend the top 2 hooks with reasoning.
Step 4: Testing (30 minutes)
Test with actual client hooks from Day 3. Adjust rubric weights if needed.
Deliverable: Hook Pattern Library (20 examples), Rating Rubric, AI Testing Prompt

DAY 5: REPURPOSING ENGINE BUILD
Objective: Turn one long-form piece into multiple short-form assets
Time: 4 hours
Step 1: Input Format Definition (30 minutes)
What goes in:
Long-form video transcript
Blog post or article (1,000+ words)
Podcast transcript (30+ minutes)
Live presentation recording
Step 2: Output Matrix (90 minutes)
One input → Multiple outputs:
Video Input →
3× 60-second TikTok scripts (different angles)
5× Quote graphics
1× Email newsletter summary
2× Twitter threads
1× LinkedIn article outline
Step 3: AI Prompt Engineering (2 hours)
plainCopy
Take this long-form content:
[PASTE_CONTENT]

Extract for [PLATFORM]:
- 3 short video scripts (60 sec each)
- 5 quote graphics
- 1 email summary
- 2 Twitter threads

Requirements:
- Maintain [CLIENT_NAME] voice
- Each piece must stand alone
- Add appropriate CTAs
- Include suggested visuals
Step 4: Efficiency Optimization (60 minutes)
Template shortcuts:
"Repurpose for TikTok only" (fast option)
"Repurpose for full ecosystem" (complete option)
"Repurpose for email + social" (common combo)
Deliverable: Repurposing Engine Prompt, Input/Output Matrix, Efficiency Templates

DAY 6: TITLE/THUMBNAIL OPTIMIZER BUILD
Objective: Maximize click-through rate
Time: 4 hours
Step 1: Title Formula Library (60 minutes)
How-To: "How to [achieve result] in [timeframe] without [obstacle]"
Listicle: "[Number] [things] that [benefit]"
Question: "Why do [audience] always [problem]?"
Shock: "I stopped [common practice] and [unexpected result]"
Specificity: "Exactly how I [achieved result] in [timeframe]"
Step 2: CTR Prediction Rubric (60 minutes)
Rate 1–10 on:
Curiosity
Clarity
Specificity
Relevance
Urgency
Step 3: AI Prompt Engineering (90 minutes)
plainCopy
Generate 10 titles for this content:
[CONTENT_SUMMARY]

Use formulas:
- 2 How-To
- 2 Listicle
- 2 Question
- 2 Shock
- 2 Specificity

Rate each 1-10 on Curiosity, Clarity, Specificity, Relevance, Urgency.

Recommend top 3 with reasoning.

For each, suggest:
- Thumbnail concept
- Color scheme
- Text overlay
Step 4: Thumbnail Concepts (60 minutes)
Face + emotion (surprise, concern, excitement)
Before/after split
Object + text overlay
Number/stat large format
Question mark + curious expression
Deliverable: Title Formula Library, CTR Rubric, AI Title Generator, Thumbnail Concepts

DAY 7: INTEGRATION TESTING & WEEK 1 DELIVERABLE
Objective: Ensure all 4 workflows work together
Time: 4 hours
Integration Test:
Script Generator: Create 3 platform variants
Hook Tester: Rate hooks, select best 2
Repurposing Engine: Take best script, create ecosystem
Title Optimizer: Generate titles for main piece
Evaluation:
Does output sound like client?
Are hooks strong?
Is repurposing efficient?
Would titles get clicked?
Week 1 Deliverable Package:
System 1: Content Production Engine (complete, tested)
Voice Profile (finalized, 8-dimension)
Prompt Library (Script Gen, Hook Tester, Repurposing, Title Optimizer)
Test Results documentation

WEEK 2: PUBLISHING & RHYTHM (Days 8–14)
DAY 8: EDITORIAL CALENDAR DESIGN
Objective: Create the content scheduling system
Time: 4 hours
Step 1: Cadence Determination (60 minutes)
Options:
Light: 2 pieces/week
Standard: 4 pieces/week
Heavy: 7 pieces/week
Burst: 3 weeks on, 1 week off
Decision: Start at 70% of what they think they can do
Step 2: Content Pillar Mapping (90 minutes)
Finalize 3–5 pillars. Example for HVAC:
Seasonal Preparedness
Money-Saving Tips
Behind the System
Customer Wins
Step 3: Calendar Tool Setup (60 minutes)
Google Sheets Setup:
Create: "[Client] Content Calendar 2026"
Share with client (Editor access)
Tabs: Master Calendar, Content Ideas, Performance Log
Columns: Date, Pillar, Format, Topic, Status, Owner, Due Date, Notes
Conditional formatting: Green=Live, Red=Overdue
Deliverable: Editorial Calendar (populated with first month), shared with client

DAY 9: SCHEDULING TOOL SETUP
Objective: Automate publishing
Time: 4 hours
Step 1: Platform Audit (30 minutes)
Where do they publish? Start with 2–3 primary platforms.
Step 2: Tool Selection (60 minutes)
Free Options:
Later: Instagram, TikTok (free tier: 30 posts/month)
Buffer: Twitter, Facebook, LinkedIn (free tier: 10 posts/channel)
Native: Meta Business Suite, YouTube Studio
Step 3: Account Connection (90 minutes)
Walk through authentication for each platform. Use client's credentials; you guide.
Step 4: Scheduling SOP (60 minutes)
Document: "How to Schedule Content for [Client]"
Checklist:
[ ] Content approved
[ ] File format correct
[ ] Caption proofread
[ ] Hashtags researched
[ ] Thumbnail selected
[ ] Date/time selected
[ ] Preview checked
[ ] Scheduled confirmed
[ ] Calendar updated
Deliverable: Scheduling tool connected, SOP document, best times documented

DAY 10: APPROVAL WORKFLOW DESIGN
Objective: Quality control system
Time: 4 hours
Step 1: Approval Chain Mapping (60 minutes)
Who must approve? Solo, Duo, or Team structure?
Step 2: Workflow Tool (60 minutes)
Simple: Google Docs + Email
Structured: Trello or Asana (free)
Professional: Notion or Airtable
Step 3: Quality Rubric (90 minutes)
Content Approval Checklist:
Voice & Tone:
[ ] Sounds like [Client Name]
[ ] Appropriate energy level
[ ] Jargon level matches audience
Accuracy & Safety:
[ ] Facts checked
[ ] No compliance violations
[ ] No copyright issues
Engagement & Quality:
[ ] Hook is strong
[ ] CTA is clear
[ ] Visual quality acceptable
Step 4: SLA Agreement (30 minutes)
"Content submitted for review will receive:
Initial feedback within 24 hours
Final approval within 48 hours
Emergency expedite: 4 hours (use sparingly)"
Deliverable: Approval workflow documented, quality rubric, SLA agreement

DAY 11: PLATFORM-SPECIFIC FORMATTING
Objective: Optimize for each platform's requirements
Time: 4 hours
Step 1: Platform Specs Document (2 hours)
Create: "[Client] Platform Formatting Guide"
Instagram Feed:
1080×1080 (square), 1080×1350 (portrait)
Caption: 2,200 max, 125 visible before "more"
Hashtags: 30 max
TikTok:
1080×1920 (9:16)
Length: 15 sec – 3 min (optimal: 21–34 sec)
Hook in 0–1 seconds
YouTube:
1920×1080 (16:9) or 1080×1920 (Shorts)
Title: 60 characters max
Thumbnail: 1280×720
LinkedIn:
Personal post: 3,000 characters
Article: 125,000 characters
Native video > external links
Step 2: Cross-Platform Adaptation SOP (30 minutes)
Document: "How to Adapt One Idea for Multiple Platforms"
Example: "3 HVAC Mistakes"
Instagram: Carousel
TikTok: Rapid-fire video
LinkedIn: Professional text post
Email: Detailed explanation
Deliverable: Platform Formatting Guide, Cross-Platform Adaptation SOP

DAY 12: BATCH PRODUCTION TRAINING
Objective: Teach client to create 2 weeks of content in 4 hours
Time: 4 hours
The Batch Philosophy
"Setup once, film 10 pieces, edit all, schedule all. 4 hours = 2 weeks of content."
The Workflow
Phase 1: Pre-Production (30 min)
Review calendar
Gather props, scripts
Setup camera, lights, mic
Phase 2: Production (90 min)
Film all talking head content back-to-back
Change shirt/jewelry between videos
Use teleprompter or notes
Phase 3: Post-Production (90 min)
Import all footage
Batch edit: color, audio
Add graphics, export
Phase 4: Scheduling (30 min)
Upload to scheduling tool
Add captions, hashtags
Schedule for optimal times
Client Practice Session (90 minutes)
Do it together. Goal: Complete 4 pieces in 90 minutes.
Deliverable: Client completes first batch, Batch Production SOP

DAY 13: PERFORMANCE DASHBOARD SETUP
Objective: Build System 3 — the feedback loop
Time: 4 hours
Step 1: Metrics Selection (60 minutes)
Awareness: Reach, video views, follower growth
Engagement: Engagement rate, save rate, comment sentiment
Conversion: Click-through rate, lead forms, direct messages
Business: Leads generated, sales closed
Pick 1 from each category = 4 metrics max.
Step 2: Dashboard Tool (60 minutes)
Option A: Google Data Studio (free, robust)
Option B: Simple Spreadsheet (Google Sheets — recommended to start)
Option C: Native platform analytics
Step 3: Spreadsheet Build (2 hours)
Create: "[Client] Performance Tracker"
Tabs:
Weekly Summary
Platform Detail
Content Performance
Goals vs. Actual
Columns: Date, Platform, Content type, Topic, Reach, Engagement rate, Link clicks, Saves, Notes
Step 4: Data Collection SOP (30 minutes)
"Weekly Ritual (30 minutes every Monday):
Open Performance Tracker
Log into each platform's analytics
Record previous week's metrics
Calculate week-over-week changes
Identify top and bottom performers
Write 3 bullet notes: What worked, what didn't, what to try"
Deliverable: Performance Tracker spreadsheet, Data Collection SOP

DAY 14: REVIEW RITUAL DESIGN
Objective: Create the habit of using data to improve
Time: 4 hours
Step 1: Review Meeting Structure (90 minutes)
30-minute weekly agenda:
0–5 min: Wins celebration
5–15 min: Data review
15–25 min: Content analysis (top 3, bottom 3)
25–30 min: Action items
Step 2: Decision Framework (90 minutes)
Persist: Metric trending up 3+ weeks, above average engagement
Pivot: Metric flat/down 4+ weeks, below 50th percentile
Test: New format (4-week trial), different time (2-week test)
Step 3: Optimization Triggers (60 minutes)
"If reach drops 30% → Check algorithm/shadowban, return to proven content"
"If engagement below 2% → Review hook strength with Hook Tester"
"If saves = 0 → Add 'Save this' CTA, increase specificity"
"If link clicks = 0 → Test different CTA, check link placement"
Step 4: Monthly Deep Dive Template (30 minutes)
2-hour monthly session:
Month in Review (15 min)
Content Audit (30 min)
Competitive Check (15 min)
Strategy Adjustments (30 min)
Goal Setting (30 min)
Week 2 Deliverable Package:
System 2: Publishing Rhythm (calendar, scheduling, approval, formatting, batch production)
System 3: Performance Feedback Loop (dashboard, data collection, review ritual)
All SOPs documented
Client trained on batch production

WEEK 3: LIBRARY, TRAINING & HANDOFF (Days 15–21)
DAY 15: ASSET LIBRARY STRUCTURE
Objective: Create organized system that prevents content loss
Time: 4 hours
Step 1: Folder Architecture (90 minutes)
Create: "[Client] Content Asset Library"
plainCopy
/01_RAW (unedited footage)
/02_IN_PROGRESS (drafts)
/03_PUBLISHED (final, live)
  /2026/
    /01_JANUARY/
      /Instagram/
      /TikTok/
      /YouTube/
      /LinkedIn/
      /Email/
/04_TEMPLATES (reusable graphics)
/05_ARCHIVE (old campaigns)
Step 2: File Naming Convention
[Date]_[Platform]_[Topic]_[Version].[ext]
Examples:
2026-01-15_Instagram_TipsForWinter_v3.jpg
2026-01-15_TikTok_WinterTips_Final.mp4
Step 3: Tagging & Metadata
Track: Pillar, Format, Platform, Topic, Campaign, Performance tier, Repurposed from, Date, Status
Step 4: Search & Retrieval SOP (60 minutes)
"How to Find Any Content in Under 60 Seconds"
By Date: Navigate year → month → platform
By Topic: Drive search
By Pillar: Filtered view
By Performance: Sort by tier
Deliverable: Folder structure created, naming convention, tagging system, Search & Retrieval SOP

DAY 16: RETRIEVAL & REUSE WORKFLOWS
Objective: Make old content findable and reusable
Time: 4 hours
Step 1: Content Refresh Workflow (90 minutes)
When to refresh:
Evergreen topic
Performed well originally (A-tier)
Seasonal recurrence
Process:
Find original (search by topic/date)
Review performance (why it worked?)
Identify updates (what's changed?)
Adapt (new hook, updated info)
Republish (mark "Refreshed from [date]")
Step 2: Content Remix Workflow (90 minutes)
Turn one high-performer into multiple variants.
Example: "5 HVAC Mistakes" (Instagram carousel, performed well)
Remix:
TikTok: Video with text overlay
YouTube Short: 60-second version
Email: Expanded to 10 mistakes
LinkedIn: Professional tone, data-backed
Step 3: Seasonal Content Calendar (90 minutes)
Create template for recurring topics by month.
Step 4: Evergreen Content Bank (60 minutes)
Maintain 20+ pieces per category:
Educational
Myth-busting
Customer stories
Behind-scenes
Tips
Deliverable: Refresh Workflow SOP, Remix Workflow SOP, Annual Content Calendar, Evergreen Content Bank

DAY 17: TEAM TRAINING SESSION #1 — AI WORKFLOWS
Objective: Teach team to use System 1
Time: 4 hours
Pre-Session: Test AI tools, prepare examples, print Voice Profile
Hour 1: Script Generator Mastery
Review, demo, practice, troubleshoot
Hour 2: Hook Tester & Title Optimizer
Why hooks matter, demo, practice
Hour 3: Repurposing Engine
One-to-many strategy, demo, practice
Hour 4: Integration & Q&A
Full workflow, troubleshooting, homework
Homework: Create 5 pieces using System 1 before Session #2
Training Materials:
Printed Voice Profile (laminated)
Digital Prompt Library (Google Doc, bookmarked)
Loom recording of training
"System 1 Daily Use" checklist
Deliverable: Team trained on System 1, practice pieces completed

DAY 18: TEAM TRAINING SESSION #2 — PUBLISHING/PERFORMANCE
Objective: Teach Systems 2 and 3
Time: 4 hours
Hour 1: Editorial Calendar Management
Why planning beats scrambling, demo, practice
Hour 2: Scheduling & Approval Workflow
Tools, SOPs, turnaround times, practice
Hour 3: Batch Production Practice
Setup, film 4 pieces together, edit one
Hour 4: Performance Dashboard & Review Ritual
What metrics matter, demo, practice, schedule weekly review
Training Materials:
Batch Production Checklist (laminated)
Scheduling Checklist (laminated)
Performance Tracker (pre-populated)
Loom recording
Deliverable: Team trained on Systems 2 and 3, batch production completed, first performance review conducted

DAY 19: SOFT LAUNCH — PRODUCE FIRST WEEK TOGETHER
Objective: Ensure systems work in real conditions
Time: 4 hours
Phase 1: Planning (60 min)
Review calendar, assign roles, prepare scripts
Phase 2: Production (90 min)
Client leads, you observe
Film 3–5 pieces
Troubleshoot in real-time
Phase 3: Post-Production (60 min)
Client edits, you review
Optimize, approve
Phase 4: Scheduling & Launch (30 min)
Client schedules, you verify
Go live, monitor 2 hours
Celebrate
Debrief: "What worked? What was hard? What to fix?"
Deliverable: First week of content live, systems stress-tested, improvement list

DAY 20: SYSTEM 4 FINALIZATION & DOCUMENTATION
Objective: Complete Asset Library and finalize SOPs
Time: 4 hours
Step 1: Library Population (90 min)
Organize soft launch content
Tag with pillar, platform, topic, performance
Create 3 reusable templates
Archive old content
Step 2: SOP Finalization (90 min)
Review all System 1–4 SOPs. Each must include:
Purpose
Prerequisites
Step-by-step
Decision trees
Troubleshooting
Resources
Step 3: Client Operations Manual (90 min)
Create: "[Client] Content Operations Manual"
Table of Contents:
Strategy Overview
System 1: Content Production
System 2: Publishing Rhythm
System 3: Performance Feedback
System 4: Asset Library
Weekly Rituals
Emergency Protocols
Contact & Support
Step 4: Video Library (30 min)
Record Loom videos:
System 1 walkthrough (15 min)
System 2 walkthrough (15 min)
System 3 walkthrough (10 min)
System 4 walkthrough (10 min)
Troubleshooting guide (5 min)
Embed in Operations Manual
Deliverable: Client Operations Manual (complete), Video Library (5 Looms), All SOPs finalized

DAY 21: HANDOFF & RETAINER TRANSITION
Objective: Officially transition to retainer
Time: 4 hours
Morning (2 hours): Final Review
Review Operations Manual together
Test retrieval: "Find me the January HVAC tip"
Verify access to all tools
Confirm rituals scheduled
Afternoon (2 hours): Retainer Kickoff
Retainer Scope Confirmation:
"My role going forward:
Weekly: Review content, async video feedback (Loom)
Monthly: 60-min strategy call + performance report
Quarterly: 2-hour deep dive + strategy adjustment
As needed: Emergency troubleshooting (48-hour response)
Your role:
Produce content using the systems
Maintain weekly publishing rhythm
Enter performance data weekly
Attend scheduled calls
Request help when stuck"
First Retainer Tasks (Week 1):
Review their first solo-produced content
Provide feedback (Loom)
Optimize one prompt
Check: Are systems being used? Where's friction?
Documentation:
Signed retainer agreement
Next 3 monthly calls scheduled
Emergency contact protocols
Celebration of completion
Deliverable: Retainer relationship active, first month scheduled, systems operational

CHAPTER 25 COMPLETE: THE SYSTEM BUILD PLAYBOOK
Total Deliverables for Stage 2 (21 Days):
SYSTEM 1: Content Production Engine
Script Generator (voice-optimized)
Hook Tester (pattern library, rating rubric)
Repurposing Engine (input/output matrix)
Title/Thumbnail Optimizer (CTR-focused)
Prompt Library (all documented)
SYSTEM 2: Publishing Rhythm
Editorial Calendar (populated, shared)
Scheduling Tools (connected, SOP)
Approval Workflow (rubrics, SLA)
Platform Formatting Guide (specs for each)
Batch Production SOP (4-hour process)
SYSTEM 3: Performance Feedback Loop
Performance Tracker (dashboard)
Data Collection SOP (weekly ritual)
Review Meeting Structure (30-min agenda)
Decision Framework (persist/pivot/test)
Optimization Triggers (if/then rules)
SYSTEM 4: Asset Library & Reuse
Folder Structure (organized)
Naming Convention (enforced)
Tagging System (implemented)
Retrieval SOPs (60-second find)
Refresh & Remix Workflows
Evergreen Content Bank (20+ pieces)
TRAINING & DOCUMENTATION:
Voice Profile (8-dimension, finalized)
Team Training Session #1 (AI workflows, 4 hours)
Team Training Session #2 (Publishing/Performance, 4 hours)
Soft Launch (first week produced together)
Client Operations Manual (complete, video-embedded)
Video Library (5 Loom walkthroughs)
TRANSITION:
Retainer Agreement (signed)
First Month Scheduled
Emergency Protocols
Systems Operational (client self-sufficient)

This is the complete, click-by-click instruction set for building Stage 2 deliverables. Every step, every tool, every decision documented for zero-knowledge implementation.
Shall I continue with Chapter 26: The Voice Extraction Protocol in the same format?

