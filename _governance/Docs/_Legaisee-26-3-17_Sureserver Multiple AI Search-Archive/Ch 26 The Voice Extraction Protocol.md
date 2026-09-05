CHAPTER 26: The Voice Extraction Protocol
Overview
AI-generated content sounds generic because it lacks a specific human voice. To build systems clients actually use, you must capture their unique communication style—then encode it so AI can replicate it consistently. This chapter is the complete, step-by-step process for extracting any client's voice and engineering prompts that reproduce it.
The Promise: After completing this protocol, you will have an 8-dimension voice profile and a set of prompt modifiers that make AI output indistinguishable from the client's own writing or speaking.

The Problem: Why AI Content Sounds Wrong
Generic AI output fails on three levels:
Vocabulary mismatch: Uses words the client would never use
Rhythm mismatch: Sentence length and flow feel "off"
Perspective mismatch: Wrong stance (too formal, too casual, wrong authority level)
The solution is systematic extraction: analyze real examples, identify patterns, codify those patterns into reusable instructions.

The 8-Dimension Voice Profile
Every voice breaks down into eight measurable dimensions. You will rate each dimension on a scale, document specific patterns, and convert those patterns into prompt engineering.

DIMENSION 1: VOCABULARY REGISTER (Word Choice)
What to measure:
Technical vs. accessible (1–10 scale)
Industry jargon usage (heavy/moderate/light/none)
Slang/colloquialisms (present/absent)
Formality level (casual/conversational/professional/formal)
How to analyze:
Select 3–5 representative content pieces from the client
Highlight every technical term, industry acronym, or specialized word
Count occurrences per 100 words
Note any slang, contractions, or informal phrases
Rate overall accessibility: Could a layperson understand this?
Documentation template:
Table
Aspect
Rating
Evidence
Technical density
6/10
"HVAC," "SEER rating," "BTU" appear 12 times in 500 words
Jargon level
Moderate
Uses industry terms but defines them
Slang
Absent
No colloquialisms detected
Formality
Conversational
Uses contractions, direct address

Prompt engineering output:
plainCopy
VOCABULARY MODIFIERS:
- Use industry terms naturally but define on first use
- Avoid slang and colloquial expressions
- Use contractions freely (don't, can't, won't)
- Address reader directly ("you," "your")
- Technical density: moderate (1 term per 50 words)

DIMENSION 2: SENTENCE ARCHITECTURE (Structure)
What to measure:
Average sentence length (words per sentence)
Complexity (simple/compound/complex sentence mix)
Rhythm (short punchy/mixed/flowing)
Fragment usage (frequent/occasional/rare)
How to analyze:
Take one 200-word sample
Count total words
Count total sentences
Calculate: Words ÷ Sentences = Average length
Categorize each sentence: Simple (one clause), Compound (two independent), Complex (independent + dependent)
Note fragments (incomplete sentences used for effect)
Documentation template:
Table
Metric
Measurement
Pattern
Average length
14 words
Shorter than academic, longer than social
Simple sentences
40%
Direct statements
Compound sentences
35%
"This and that" structure
Complex sentences
25%
Some subordination for flow
Fragments
Occasional
Used for emphasis ("Not happening.")

Prompt engineering output:
plainCopy
SENTENCE MODIFIERS:
- Average 12-16 words per sentence
- Mix simple and compound for rhythm (avoid complex academic structures)
- Use occasional fragments for emphasis (1-2 per piece)
- Vary sentence length: short punchy followed by longer explanatory
- Avoid run-on sentences beyond 25 words

DIMENSION 3: HUMOR & TONE (Personality)
What to measure:
Humor type (witty/sarcastic/self-deprecating/absent)
Enthusiasm level (restrained 1–10 hyped)
Emotional openness (guarded/professional/warm/vulnerable)
Conflict handling (diplomatic/direct/confrontational)
How to analyze:
Read content for emotional temperature
Highlight any humorous moments—what type?
Note self-reference: Do they share personal stories? Admit mistakes?
Find how they handle disagreement or problems
Documentation template:
Table
Aspect
Assessment
Examples
Humor type
Self-deprecating
"I learned this the hard way..."
Enthusiasm
6/10
Energetic but not salesy
Emotional openness
Warm
Shares customer stories, some personal
Conflict handling
Diplomatic
"Some approaches work better than others"

Prompt engineering output:
plainCopy
TONE MODIFIERS:
- Use gentle self-deprecating humor when appropriate
- Enthusiasm level: genuinely helpful, not hype-driven
- Share specific customer examples (with permission)
- Handle disagreements diplomatically—acknowledge multiple valid approaches
- Avoid aggressive or confrontational language

DIMENSION 4: PERSPECTIVE & STANCE (Positioning)
What to measure:
Expert vs. peer (authority figure/fellow traveler)
Teacher vs. learner (instructor/explorer)
Optimist vs. realist vs. critic
Insider vs. outsider language
How to analyze:
Identify pronouns and positioning: "I know" vs. "We're figuring this out"
Note how they present information: "Here's how to do it" vs. "Here's what I'm learning"
Check overall outlook: Problems emphasized or solutions?
Language: Jargon that excludes newcomers, or inclusive explanations?
Documentation template:
Table
Aspect
Assessment
Evidence
Expert/peer
Expert
"After 20 years, I've seen..."
Teacher/learner
Teacher
Clear step-by-step instructions
Outlook
Realist-optimist
Acknowledges problems, focuses on solutions
Language
Inclusive expert
Uses jargon but explains it

Prompt engineering output:
plainCopy
PERSPECTIVE MODIFIERS:
- Position as experienced expert (cite years, volume of experience)
- Teach clearly with step-by-step structure
- Acknowledge challenges honestly but emphasize workable solutions
- Use inclusive language that welcomes newcomers to the topic
- Avoid "we're all figuring this out"—lead with confidence

DIMENSION 5: TRANSITIONS & FLOW (Connectivity)
What to measure:
Logical connectors (therefore/however/because)
Storytelling transitions ("Here's what happened"/"Picture this")
Question usage (rhetorical/direct/invitational)
Pacing signals ("Quick tip"/"Deep dive"/"Bottom line")
How to analyze:
Highlight every transition phrase between ideas
Count questions per piece: How many? What type?
Note pacing markers that signal content structure
Identify storytelling frames
Documentation template:
Table
Element
Frequency
Examples
Logical connectors
Moderate
"Because," "That's why," "However"
Story transitions
Frequent
"I had a customer last week..."
Questions
3-4 per piece
Mostly rhetorical, some invitational
Pacing signals
Regular
"Quick tip," "Here's the thing," "Long story short"

Prompt engineering output:
plainCopy
TRANSITION MODIFIERS:
- Use "That's why" and "Here's the thing" to bridge ideas
- Open with specific customer stories or scenarios when possible
- Include 2-3 rhetorical questions per piece to engage reader
- Use pacing signals: "Quick tip" for short points, "Deep dive" for detailed explanation
- Avoid over-formal transitions ("Furthermore," "Moreover")

DIMENSION 6: CTAs & DIRECTIVES (Action Style)
What to measure:
Urgency level ("Now"/"Soon"/"When ready")
Command strength ("Do this"/"Consider"/"You might")
Benefit framing ("So you can"/"This means"/"Imagine")
Risk addressing (acknowledged/ignored/reframed)
How to analyze:
Find every call-to-action or directive
Rate urgency: Immediate, soon, or open-ended?
Note command strength: Direct imperative or soft suggestion?
Check how benefits are presented
See if objections or risks are addressed
Documentation template:
Table
Aspect
Pattern
Examples
Urgency
Moderate
"This week," not "Right now"
Command strength
Direct but polite
"Make sure you..."
Benefit framing
"So you can"
"Schedule now so you can..."
Risk addressing
Acknowledged
"I know this sounds expensive, but..."

Prompt engineering output:
plainCopy
CTA MODIFIERS:
- Use moderate urgency: "This month" rather than "Right now" or "Whenever"
- Give direct but polite commands: "Make sure," "Don't forget," "Schedule"
- Frame benefits with "so you can" structure
- Acknowledge common objections before they arise
- Avoid aggressive scarcity ("Only 3 left!") unless authentic

DIMENSION 7: EVIDENCE & PROOF (Credibility)
What to measure:
Data usage (frequent/occasional/rare)
Anecdote style (personal/observed/hypothetical)
Social proof integration (seamless/forced/absent)
Authority signaling (credentials/experience/results)
How to analyze:
Count statistics, numbers, or data points per piece
Note story sources: Personal experience, customer example, or hypothetical scenario?
Check how testimonials or social proof appear
Identify authority markers: Years in business, credentials, specific results
Documentation template:
Table
Element
Frequency
Examples
Data
Occasional
"73% of systems," "15 years"
Anecdotes
Observed
Customer stories, not personal
Social proof
Seamless
Integrated into narrative
Authority
Experience-based
"After 500 installations..."

Prompt engineering output:
plainCopy
EVIDENCE MODIFIERS:
- Include specific numbers when available (years, percentages, counts)
- Use observed customer stories rather than personal anecdotes
- Integrate social proof naturally into content flow
- Lead with experience volume: "After [X] [units/time]..."
- Avoid unsupported claims—always anchor to specific evidence

DIMENSION 8: VISUAL LANGUAGE (Imagery)
What to measure:
Metaphor frequency (constant/regular/rare)
Sensory detail (visual/auditory/kinesthetic)
Concrete vs. abstract (specific examples/general concepts)
Scene-setting (vivid/minimal/none)
How to analyze:
Highlight every metaphor or analogy
Note sensory words: See, hear, feel, taste, smell
Check for concrete specifics vs. abstract generalities
Rate scene-setting: Do you visualize what's described?
Documentation template:
Table
Aspect
Assessment
Examples
Metaphors
Regular
"Your HVAC is like a car..."
Sensory
Visual dominant
"You can see the dust..."
Concrete/abstract
Concrete
Specific temperatures, dollar amounts
Scene-setting
Moderate
Brief scenarios, not lengthy descriptions

Prompt engineering output:
plainCopy
VISUAL MODIFIERS:
- Use practical analogies (HVAC = car maintenance, etc.)
- Lead with visual details readers can picture
- Prefer concrete specifics: exact temperatures, dollar amounts, time frames
- Set brief scenes (2-3 sentences) before delivering information
- Avoid lengthy descriptive passages—keep imagery functional

The Voice Extraction Process: Step-by-Step
Step 1: Collection (90 minutes)
Gather 5–7 examples of the client's best content:
Table
Source
What to Get
Why It Matters
Best-performing social post
Highest engagement
Shows what resonates with audience
Best sales email
Highest conversion
Reveals persuasion style
Best video/transcript
Most natural delivery
Captures authentic speech patterns
Best testimonial about them
How others describe them
External perspective on their voice
Best customer review
What resonates with customers
Proof of what works
Written bio or mission statement
Official self-description
Intentional positioning
Recorded interview or podcast
Unscripted speaking
Most authentic voice

Collection methods:
Ask client directly: "Send me your 3 best emails"
Search their social media: Highest engagement posts
YouTube/podcast platforms: Most-viewed content
Website: About page, mission statement
Ask: "What are you most proud of writing or saying?"

Step 2: Analysis (90 minutes)
For each piece, rate 1–10 on all 8 dimensions.
Use this analysis grid:
Table
Dimension
Piece 1
Piece 2
Piece 3
Piece 4
Piece 5
Pattern
1. Vocabulary
6
5
7
6
6
Moderate technical
2. Sentence length
14
16
12
15
14
~14 words avg
3. Humor
3
4
3
5
4
Light, self-deprecating
4. Perspective
Expert
Expert
Expert
Peer
Expert
Mostly expert
5. Transitions
Story
Logical
Story
Story
Story
Story-focused
6. CTA strength
7
6
8
7
7
Direct, moderate urgency
7. Evidence
6
7
6
5
6
Experience-based
8. Visual
5
6
5
5
5
Practical analogies

Look for patterns:
Consistent across all pieces = Core voice (non-negotiable)
Varies by platform = Situational adaptation (platform-specific modifiers)
Varies by topic = Contextual flexibility (topic-specific adjustments)
Strongest dimensions = Superpowers (emphasize in prompts)
Weakest dimensions = Growth areas (avoid or strengthen)

Step 3: Profile Creation (60 minutes)
Write the 1-paragraph voice profile:
Template:
"[Client] communicates as a [expert/peer] with [enthusiasm level] enthusiasm. Their vocabulary is [technical level], using [jargon level] industry terminology with [formality level] formality. Sentences average [X] words, creating a [rhythm description] rhythm. Humor is [type/frequency]. They address readers as [relationship], using [CTA style] calls to action. Evidence comes through [proof types]. Visual language is [metaphor frequency], creating [imagery type] imagery."
Example completed profile:
"Sarah communicates as an experienced expert with measured enthusiasm. Her vocabulary is moderately technical, using HVAC industry terminology with conversational formality. Sentences average 14 words, creating a direct but flowing rhythm. Humor is light and self-deprecating, used occasionally. She addresses readers as a helpful advisor, using direct but polite calls to action. Evidence comes through specific customer examples and years of experience. Visual language is practical and analogy-based, creating concrete, actionable imagery."

Step 4: Prompt Engineering (60 minutes)
Create voice-specific prompt additions:
Base Prompt + Voice Modifiers = Client-Specific Output
Example Voice Modifiers for Sarah:
plainCopy
Write in the style of Sarah:

VOCABULARY:
- Use HVAC industry terms naturally but define on first use
- Avoid slang; use contractions freely
- Address reader directly as "you"
- Technical density: moderate (1 term per 50 words)

SENTENCE STRUCTURE:
- Average 12-16 words per sentence
- Mix simple and compound sentences
- Use occasional fragments for emphasis (1-2 per piece)

TONE:
- Measured enthusiasm: genuinely helpful, not hype-driven
- Light self-deprecating humor when appropriate
- Share specific customer examples
- Handle disagreements diplomatically

PERSPECTIVE:
- Position as experienced expert (cite 15+ years)
- Teach clearly with step-by-step structure
- Acknowledge challenges but emphasize solutions
- Use inclusive, welcoming language

TRANSITIONS:
- Use "That's why" and "Here's the thing"
- Open with specific customer scenarios
- Include 2-3 rhetorical questions per piece
- Use "Quick tip" and "Deep dive" as pacing signals

CTAs:
- Moderate urgency: "This month" rather than "Right now"
- Direct but polite commands: "Make sure," "Schedule"
- Frame benefits with "so you can"
- Acknowledge objections before they arise

EVIDENCE:
- Include specific numbers (years, percentages, counts)
- Use observed customer stories
- Integrate social proof naturally
- Lead with experience volume

VISUAL LANGUAGE:
- Use practical analogies (HVAC = car maintenance)
- Lead with visual details
- Prefer concrete specifics
- Set brief 2-3 sentence scenes

Step 5: Testing & Refinement (Ongoing)
Generate 3 test pieces using the voice profile:
Test 1: Simple topic, familiar to client
Evaluate: Does it sound like them?
Check: Voice markers present?
Note: What's missing or wrong?
Test 2: Complex topic, technical
Evaluate: Does complexity break voice consistency?
Check: Technical terms used correctly?
Note: Where does it drift generic?
Test 3: Emotional or persuasive topic
Evaluate: Does emotion feel authentic?
Check: Tone appropriate?
Note: Where does it sound like AI, not them?
Revise profile based on feedback:
Table
Issue
Solution
Prompt Adjustment
"Too formal"
Increase contractions, shorten sentences
Add "Use contractions in 80% of sentences"
"Not technical enough"
Increase jargon density
Change "moderate" to "heavy" technical
"Sounds salesy"
Reduce enthusiasm rating
Change "measured" to "restrained"
"Too wordy"
Shorten average sentence length
Change 14 words to 10 words

Client review process:
Send 3 test pieces labeled "A," "B," "C"
Ask: "Which sounds most like you? Least like you?"
Ask: "What specifically feels right or wrong?"
Adjust profile based on specific feedback
Build voice evolution log (how voice changes over time)

The Voice Maintenance System
Quarterly Voice Audits
Review recent content: Does it still match profile?
Check for drift: Generic AI creeping in?
Update profile: New patterns emerging?
Refresh examples: New "best of" to add?
Audit checklist:
[ ] Review last 10 pieces of client content
[ ] Rate each on 8 dimensions
[ ] Compare to original profile
[ ] Identify drift areas
[ ] Update profile document
[ ] Adjust AI prompts
[ ] Archive old profile version
When Voice Evolves
Clients change over time. Update the profile when:
New role or positioning (promotion, pivot)
New audience (expanding market, different demographic)
New platform (TikTok requires different voice than LinkedIn)
Intentional rebrand (deliberate voice shift)
Evolution documentation:
Date of change
Reason for change
What changed (which dimensions)
New profile
A/B test results (if available)

Platform-Specific Voice Adaptations
The core voice stays constant, but expression varies by platform:
LinkedIn Voice Modifiers
plainCopy
LINKEDIN ADAPTATION:
- Increase formality +1 level
- Lead with professional credential or result
- Include data point in first 2 sentences
- Use industry terminology without explanation (professional audience)
- CTA: softer, "I'd love your thoughts" vs direct command
TikTok Voice Modifiers
plainCopy
TIKTOK ADAPTATION:
- Decrease sentence length to 8-10 words average
- Increase enthusiasm +2 levels
- Use "you" and "your" in every sentence
- Hook in first 3 seconds with pattern interrupt
- CTA: "Follow for more," "Save this," "Comment if..."
- Visual language: describe what viewer sees on screen
Email Voice Modifiers
plainCopy
EMAIL ADAPTATION:
- Increase personal pronouns (I, we, my, our)
- Use storytelling transitions frequently
- Include specific customer example or personal anecdote
- CTA: single, clear action with benefit framing
- Sign-off: warm, personal, not corporate
YouTube Voice Modifiers
plainCopy
YOUTUBE ADAPTATION:
- Longer sentences allowed (up to 20 words)
- Retention hook every 2 minutes: "But here's what they don't tell you..."
- Use "you're watching this because..." to create relevance
- Evidence: specific, timestamped, visual
- CTA: subscribe, notification bell, specific video link

Troubleshooting Common Voice Problems
Problem: "It still sounds like AI"
Diagnosis: Voice modifiers too generic, not specific enough
Solution: Add specific vocabulary lists and forbidden words
plainCopy
ADD TO PROMPT:
SPECIFIC VOCABULARY TO USE:
- "System" not "unit"
- "Maintenance" not "service"
- "Efficiency" not "savings"

FORBIDDEN WORDS:
- "Leverage" (use "use")
- "Synergy" (use "working together")
- "Optimize" (use "improve")
- "Utilize" (use "use")
Problem: "It's close but not quite right"
Diagnosis: Missing subtle patterns—rhythm, transition phrases, or sentence starters
Solution: Add pattern mimicry instructions
plainCopy
ADD TO PROMPT:
SENTENCE STARTERS TO MIMIC:
- "Here's the thing about..."
- "I had a customer last week who..."
- "Most people think... but actually..."
- "The real problem is..."
- "So here's what you do..."

TRANSITION PHRASES:
- "That's why..."
- "Which means..."
- "But here's what they don't tell you..."
- "Long story short..."
Problem: "Different topics sound like different people"
Diagnosis: Voice not robust across content types
Solution: Create topic-specific voice layers
plainCopy
BASE VOICE + TOPIC MODIFIER:

Educational content:
- Increase patience, step-by-step structure
- More analogies and examples
- Slower pace, more verification

Persuasive content:
- Increase urgency slightly
- More social proof
- Stronger benefit framing

Story content:
- Increase sensory detail
- More emotional openness
- Scene-setting emphasis
Problem: "It sounds like me from 5 years ago, not now"
Diagnosis: Voice profile based on old examples
Solution: Refresh source material quarterly
plainCopy
REFRESH PROTOCOL:
1. Collect 3 new "best of" examples from last 90 days
2. Re-run 8-dimension analysis
3. Compare to current profile
4. Update dimensions that changed
5. Archive old profile, date new version

The Voice Extraction Toolkit
Tools for Analysis
Table
Tool
Purpose
Cost
Hemingway Editor
Sentence length, readability
Free
Readable.com
Formality scoring
Free tier
Otter.ai
Transcript analysis
Free tier
Google Docs
Word count, collaboration
Free
Excel/Sheets
Pattern tracking
Free

Templates Provided
8-Dimension Analysis Grid (blank)
Voice Profile Template (fill-in-the-blank)
Prompt Modifier Builder (structured output)
Platform Adaptation Worksheet (customize per channel)
Voice Evolution Log (track changes over time)

Deliverables Checklist
After completing Chapter 26, you will have:
[ ] 5–7 content examples collected and catalogued
[ ] 8-dimension analysis completed for each example
[ ] Pattern identification and core voice determination
[ ] 1-paragraph voice profile written
[ ] Voice-specific prompt modifiers created
[ ] 3 test pieces generated and evaluated
[ ] Client feedback incorporated
[ ] Platform-specific adaptations documented
[ ] Quarterly audit scheduled
[ ] Voice evolution log started

Integration with Chapter 25
The Voice Extraction Protocol feeds directly into the System Build Playbook:
Day 1 of Stage 2 Build: Conduct deep-dive interview, begin collection
Day 2 of Stage 2 Build: Complete 8-dimension analysis, create profile
Day 3 of Stage 2 Build: Use voice profile to build Script Generator
Day 4–7 of Stage 2 Build: Test and refine voice replication in all workflows
Ongoing: Quarterly voice audits, profile updates

This is the complete Voice Extraction Protocol. Every dimension, every step, every template included for zero-knowledge implementation.
Shall I continue with Chapter 27: The Complete Discovery Call & Proposal System?

