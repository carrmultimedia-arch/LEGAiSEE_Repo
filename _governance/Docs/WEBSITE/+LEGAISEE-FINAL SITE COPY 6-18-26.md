Here's the complete instruction set:

INSTRUCTION SET: ALL PAGE REWRITES

PAGE: registry.html
Page Title — Change to:
plain
The Private Registry — LEGAiSEE · Business Archaeology & Authority Systems
Head / Meta Description — Replace existing with:
plain
The Private Registry is not a contact form. It is the first act of the excavation — a qualification gate for enterprises with the depth of history worth recovering. Three clients maximum. No public intake. Confidential by design.
Head / Add FAQ Schema JSON-LD — Insert before </head>:
JSON
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is the Private Registry?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The Private Registry is not a contact form. It is the first act of the excavation — a qualification gate for enterprises with the depth of history worth recovering. Every submission is read personally by The Architect."
      }
    },
    {
      "@type": "Question",
      "name": "Who qualifies for the Private Registry?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Enterprises with five or more years of operating history, annual revenue at or approaching $30M+, operating presence in the San Antonio–Austin I-35 corridor, and leadership willing to look back before building forward."
      }
    },
    {
      "@type": "Question",
      "name": "What happens after I submit?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The Architect reviews every submission personally. If your enterprise qualifies, you will receive a private response within five business days. There is no automated sequence, no sales funnel, and no follow-up campaign."
      }
    },
    {
      "@type": "Question",
      "name": "Is my submission confidential?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Everything that enters the Registry is governed by a confidentiality standard that is not negotiable. No team reviews your submission. No system flags it. No algorithm scores it. One human being reads what you wrote."
      }
    }
  ]
}

Section 1 (Hero — above the fold) — Current: "The Door Is Here · The Conversation Is What Opens It!" with existing pills and CTA.
Text Content — Replace hero headline with:
plain
The Door Is Here.
The Conversation Is What Opens It.
Text Content — Replace hero subhead with:
plain
The Registry is not a contact form. It is the first act of the excavation — the moment you step forward and say that what was lost is worth recovering.
Text Content — Hero pills (replace existing or add if missing):
Three Clients Maximum
No Public Intake
Confidential by Design
One Practitioner
Text Content — Hero CTA buttons (replace existing):
Primary: "Begin the Excavation" → links to #intake-sanctuary anchor
Secondary: "What Happens Next" → links to #what-happens anchor
Format Change — Add id="registry-hero" to the hero <section> tag if not present.

Section 2 (What Happens After You Submit) — This is NEW. Insert AFTER the hero section, BEFORE your existing Intaketest.html embed section.
Suggested section code (use your existing .lux-section and .bg-vault-mid classes):
HTML
<section class="lux-section bg-vault-mid" id="what-happens">
  <div class="section-inner">
    <div class="section-label">
      <span class="label-line"></span>
      <span class="label-text">The Process</span>
      <span class="label-line"></span>
    </div>
    <h2 class="d-lg">What Happens After You Submit</h2>
    <!-- 4-step timeline here -->
  </div>
</section>
Text Content — Section label: "The Process"
Text Content — Section headline (H2): "What Happens After You Submit"
Text Content — Intro paragraph:
plain
The Registry submission initiates a private review. The Architect reads every submission personally. There is no automated response, no sales sequence, no follow-up funnel. There is a human being who reads what you wrote and decides whether to open the door.
Text Content — Secondary paragraph:
plain
If your enterprise qualifies — if the history is deep enough, the access is available, and a dig site worth opening exists — you will receive a private response within five business days.
Text Content — 4-step timeline (use your existing .timeline or .process-timeline classes if you have them, or build as a simple vertical list):
Step 01 — "Submission Received"
Your credentials enter the Private Registry. No algorithm scores them. No assistant pre-sorts them. They arrive, intact, in the order they were written.
Step 02 — "The Architect Reviews"
Every submission is read by the same practitioner who will conduct the excavation if the engagement proceeds. The review considers depth of history, access to archives, and the presence of a genuine inflection point worth documenting.
Step 03 — "Private Response"
If the record warrants a conversation, you receive a personal response within five business days. If the fit is not present, you receive an honest and immediate decline — no ghosting, no soft maybes.
Step 04 — "The Conversation"
A single call. No pitch deck. No discovery questionnaire. The Architect listens to what you have built, what you have lost, and what you suspect is still buried in the record. From that conversation, the appropriate Exhibit is proposed.
Format Change — No photo needed. This is a text-forward timeline section.

Section 3 (Who Qualifies) — This is NEW. Insert AFTER Section 2, BEFORE your existing Intaketest.html embed.
Suggested section code:
HTML
<section class="lux-section bg-vault" id="who-qualifies">
  <div class="section-inner">
    <div class="section-label">
      <span class="label-line"></span>
      <span class="label-text">Qualification</span>
      <span class="label-line"></span>
    </div>
    <h2 class="d-lg">Who Qualifies for the Private Registry</h2>
    <p class="b-lg">Not every enterprise carries the depth of record that makes excavation worthwhile. These six criteria separate the candidates from the curious.</p>
    <!-- 6-criteria grid here -->
  </div>
</section>
Text Content — Section label: "Qualification"
Text Content — Section headline (H2): "Who Qualifies for the Private Registry"
Text Content — Section subhead:
plain
Not every enterprise carries the depth of record that makes excavation worthwhile. These six criteria separate the candidates from the curious.
Text Content — Six qualification criteria (use your existing card/grid classes — .museum-card, .specimen-card, or .exhibit-card):
I. "Operating History" — Required
Five years minimum — preferably ten or more, or generationally owned. The excavation requires sediment.
II. "Enterprise Scale" — Required
At or approaching the $30M+ annual revenue threshold. The methodology is built for structural depth, not startup velocity.
III. "Geographic Presence" — Required
Operating presence in the San Antonio–Austin I-35 corridor. The practice serves this corridor with forensic precision.
IV. "The Lost Signal" — Critical
A sense that something precise was lost in the transition from what the business was to what it is now. Nostalgia is not enough. Accuracy is.
V. "Archive Access" — Preferred
Access to historical archives, former personnel, and financial records from the enterprise's formative years. The dig requires source material.
VI. "Leadership Appetite" — Essential
Willingness to look back before building forward — without defensiveness about what the archaeology may reveal. The truth is the client.
Format Change — No photo. Use your existing card grid (3-column on desktop, 1-column on mobile).

Section 4 (What You Receive / Phase 0 Brief) — This is NEW. Insert AFTER Section 3, BEFORE your existing Intaketest.html embed.
Suggested section code:
HTML
<section class="lux-section bg-vault-mid" id="what-you-receive">
  <div class="section-inner">
    <div class="section-label">
      <span class="label-line"></span>
      <span class="label-text">The Deliverable</span>
      <span class="label-line"></span>
    </div>
    <!-- two-column layout: text left, deliverable preview right -->
  </div>
</section>
Text Content — Section label: "The Deliverable"
Text Content — Section headline (H2): "What You Receive"
Text Content — Lead paragraph:
plain
Every engagement — regardless of Exhibit — begins with Phase 0: The Shallow Dig. It is not an intake form. It is the first act of the excavation.
Text Content — Body paragraph:
plain
This is not a lead magnet. There is no white paper. No downloadable framework. No automated sequence that delivers a generic assessment and a sales call. What follows is a genuine forensic pass across your institutional record — conducted by a practitioner, delivered as a written brief, and used as the foundation of every subsequent Exhibit.
Text Content — Investment block (use your existing .signal-block class):
Label: "Investment"
Value: "$2,500 · One-time · Non-refundable"
Note: "Principals only. Delivered as written forensic brief."
Text Content — Deliverable preview box (right column, use .museum-card or .card-surface):
Header: "◆ The Phase 0 Brief Contains"
List items:
Your Estimated Golden Era — The period in your institutional history during which the business operated closest to its highest potential.
One Abandoned Asset — A capability, relationship, method, or competitive advantage that existed in your record and was discontinued.
The Competitive Gap — The forensic measurement between what your business has documented and what your primary competitors are able to prove.
One Undeniable Inflection Point — A moment in the institutional timeline where the business changed direction, located and documented as active evidence.
Footer note:
plain
If the brief reveals that a deeper Exhibit is warranted, that determination will be stated plainly. The Shallow Dig serves the record — not the engagement pipeline.
Format Change — Two-column layout (.two-col or .asym-grid-a). Left: text + investment. Right: deliverable preview card. No photo.

Section 5 (Intaketest.html Embed) — This is your EXISTING section. DO NOT TOUCH. Keep exactly as-is.
Format Change — Add id="intake-sanctuary" to the section tag that wraps your Intaketest.html embed, if not already present. This allows the hero CTA to scroll to it.

Section 6 (Philosophy Depth — "Optional Depth") — This is NEW. Insert AFTER Section 5 (the intake embed), BEFORE your existing footer.
Suggested section code:
HTML
<section class="lux-section bg-vault" id="philosophy-depth">
  <div class="section-inner">
    <div class="section-label">
      <span class="label-line"></span>
      <span class="label-text">Optional Depth</span>
      <span class="label-line"></span>
    </div>
    <h2 class="d-lg">The Philosophy of the Gate</h2>
    <!-- three depth blocks -->
  </div>
</section>
Text Content — Section label: "Optional Depth"
Text Content — Section headline (H2): "The Philosophy of the Gate"
Text Content — Depth Block 1:
Label: "The Registry as Filter"
Title: "Why the Door Is Narrow"
Body paragraph 1:
Most service practices optimize for volume. They build funnels, nurture sequences, and automated qualification systems designed to move as many prospects as possible toward a sales conversation. The Private Registry inverts this logic.
Body paragraph 2:
The Registry is designed to be difficult to enter. The questions are open-ended. The criteria are strict. The response is slow by design. This is not inefficiency — it is structural selectivity. The enterprises that complete the Registry are the same enterprises that have the patience, the historical depth, and the leadership seriousness to sustain a genuine archaeological engagement.
Text Content — Depth Block 2:
Label: "Why Invitation Only"
Title: "The Three-Client Maximum"
Body paragraph 1:
The practice serves three clients at a time. Not because of capacity constraints, but because attention is the non-renewable resource. Every excavation requires the same depth of focus, the same forensic discipline, and the same personal presence that the first client received. Scaling that attention would dilute it.
Body paragraph 2:
When a client graduates — when their signal is restored and their system is self-sustaining — that slot opens. The next enterprise enters not by urgency, but by fit. This is why there is no public intake, no advertising, and no outbound sales. The work speaks. The right enterprises find the door.
Text Content — Depth Block 3:
Label: "The Architect's Burden"
Title: "What It Costs to Read Every Word"
Body paragraph 1:
Reading every submission personally is not a marketing posture. It is a methodological necessity. The Architect cannot delegate the judgment of whether an enterprise carries the depth of record worth excavating. That judgment requires the same forensic intuition that the excavation itself demands — the ability to sense, from a few paragraphs of institutional memory, whether there is bedrock beneath the surface or only sediment.
Body paragraph 2:
This is why the response takes five business days. Not because the Architect is busy, but because the decision is consequential. Opening the door commits both parties to a process that will surface truths that have been buried for years. That commitment deserves deliberation.
Format Change — Stack vertically. No photos. Use .divider-gold or .section-divider between blocks if desired.

Section 7 (Engagement Door — Final CTA) — This is NEW. Insert AFTER Section 6, BEFORE footer.
Suggested section code:
HTML
<section class="lux-section bg-vault-mid section-lit" id="engagement-door">
  <div class="lighting-overlay"></div>
  <div class="section-inner" style="text-align: center;">
    <!-- centered content -->
  </div>
</section>
Text Content — Section label: "The Final Word"
Text Content — Headline (H2): "If You Are Reading This, You Already Know"
Text Content — Body paragraph:
plain
Enterprises that find their way to the Private Registry rarely arrive by accident. They arrive because something in the way this practice is described resonated with something they have been unable to name.
Text Content — Accent/italic line:
plain
That feeling is not nostalgia. It is accurate perception. The archaeology will confirm it, document it, and give it the precise name it deserves.
Text Content — Gate seal (use your existing .gate-seal class):
Line 1: "Three Clients Maximum"
Line 2: "By Invitation Only"
Line 3: "The Signal, Restored"
Text Content — CTA buttons:
Primary: "Begin the Registry" → links to #intake-sanctuary
Secondary: "Return to the Vault" → links to index.html
Format Change — Center-aligned. Use .section-lit for the gold spotlight overlay. No photo.

Section 8 (FAQ Section — Visible) — This is NEW. Insert AFTER Section 7, BEFORE footer.
Suggested section code:
HTML
<section class="lux-section-sm bg-vault" id="faq">
  <div class="section-inner-narrow">
    <div class="section-label">
      <span class="label-line"></span>
      <span class="label-text">Frequently Asked</span>
      <span class="label-line"></span>
    </div>
    <h2 class="d-md">Questions About the Registry</h2>
    <!-- FAQ items -->
  </div>
</section>
Text Content — Section label: "Frequently Asked"
Text Content — Section headline (H2): "Questions About the Registry"
Text Content — FAQ Item 1:
Question: "What is the Private Registry?"
Answer: "The Private Registry is not a contact form. It is the first act of the excavation — a qualification gate for enterprises with the depth of history worth recovering. Every submission is read personally by The Architect."
Text Content — FAQ Item 2:
Question: "Who qualifies for the Private Registry?"
Answer: "Enterprises with five or more years of operating history, annual revenue at or approaching $30M+, operating presence in the San Antonio–Austin I-35 corridor, and leadership willing to look back before building forward."
Text Content — FAQ Item 3:
Question: "What happens after I submit?"
Answer: "The Architect reviews every submission personally. If your enterprise qualifies, you will receive a private response within five business days. There is no automated sequence, no sales funnel, and no follow-up campaign."
Text Content — FAQ Item 4:
Question: "Is my submission confidential?"
Answer: "Everything that enters the Registry is governed by a confidentiality standard that is not negotiable. No team reviews your submission. No system flags it. No algorithm scores it. One human being reads what you wrote."
Format Change — Use your existing .faq-item class structure. No photos.

Move Section 4 to Section 2 position — On your current registry.html, your existing sections appear to be in this order:
Hero
Intake embed
"Before the Door Opens" (What Happens When You Apply)
"What the Review Considers" (qualification criteria)
"What Is Inside" (deliverables)
Confidentiality
Final quote section
New order should be:
Hero (Section 1 — rewrite text per above)
What Happens After You Submit (Section 2 — NEW, per above)
Who Qualifies (Section 3 — NEW, per above)
What You Receive (Section 4 — NEW, per above)
Intaketest.html embed (Section 5 — EXISTING, untouched, keep in place)
Philosophy Depth (Section 6 — NEW, per above)
Engagement Door (Section 7 — NEW, per above)
FAQ (Section 8 — NEW, per above)
Footer (existing, untouched)
This means: Move your existing "Before the Door Opens" content AFTER the intake embed (or replace it with the Philosophy Depth content), and insert the three new Tier 2 sections BEFORE the intake embed.

PAGE: comparison.html
Page Title — Change to:
plain
The Comparison — LEGAiSEE · Business Archaeology & Authority Systems
Head / Meta Description — Replace with:
plain
A forensic comparison of traditional marketing consultancy versus Business Archaeology. Ten interlocking frameworks. One structural truth. See why excavation beats invention.
Head / Add noindex if not present — Ensure this line exists:
plain
<meta name="robots" content="noindex, follow" />
Format Change — No new sections needed. This page is a hidden discovery page. Just update title, meta, and ensure the 10-phase archaeological parallel uses your existing glass card classes.

PAGE: archaeology.html
Page Title — Change to:
plain
The Archaeology — LEGAiSEE · 40+ Channel Taxonomy · Business Archaeology
Head / Meta Description — Replace with:
plain
Business Archaeology is the forensic excavation of the precise strategic structure that once produced your most profitable era. Forty-plus channels mapped. Eight classes of evidence. The Lindy Effect applied to institutional memory.
Section 1 (Hero) — Current hero text.
Text Content — Hero headline: "The Archaeology"
Text Content — Hero subhead:
plain
The forensic excavation of the precise strategic structure that once produced your most profitable era — and the disciplined reconstruction of that signal for the market that exists today.
Section 2 (What Business Archaeology Is) — If this section exists.
Text Content — Section headline: "What Business Archaeology Is"
Text Content — Body:
plain
Business Archaeology is not marketing. It is not branding. It is not content strategy. It is the forensic discipline of excavating, classifying, verifying, and reconstructing the strategic assets that once made an enterprise unmistakable — and mounting that signal for the present market.
Section 3 (Channel Taxonomy) — If this section exists.
Text Content — Section headline: "Forty-Plus Channels Mapped"
Text Content — Intro:
plain
No single lens is sufficient to see what has been lost. The excavation maps your institutional record across every channel through which your signal once traveled — from print to broadcast to digital to emerging platforms.
Text Content — Channel classes (use your existing taxonomy from Chapter 17):
Class I: Print (1890s–present)
Class II: Broadcast Radio (1920s–present)
Class III: Broadcast Television (1940s–present)
Class IV: Cinema / Video (1900s–present)
Class V: Digital Web (1990s–present)
Class VI: Mobile (2000s–present)
Class VII: Social Media (2000s–present)
Class VIII: Advanced Digital (2010s–present)
Format Change — Use your existing .gem-journey-grid or card grid. No new photos needed.
Section 4 (The Lindy Effect) — If this section exists.
Text Content — Section headline: "The Lindy Effect"
Text Content — Body:
plain
What has survived longest is most likely to survive into the future. Your oldest, most durable competitive advantages are not obsolete — they are quietly forgotten. This is an archaeological dig worth millions.

PAGE: method.html
Page Title — Change to:
plain
The Method — LEGAiSEE · Four Stages · HAB / RAW / CUT / MNT
Head / Meta Description — Replace with:
plain
Four stages of restoration: Habitat, Raw Stone, Cut & Shaped, Mounted. The natural arc of the gemologist's art — applied to the forensic excavation of institutional memory.
Section 1 (Hero) —
Text Content — Hero headline: "The Method"
Text Content — Hero subhead:
plain
Every engagement follows the natural arc of the gemologist's art — from the stone in the earth to the specimen under museum light. What we excavate from your history follows the same journey.
Section 2 (Four Stages) —
Text Content — Stage 0 (HAB — Habitat):
Title: "Stage 0 — Habitat"
Subtitle: "The gem in earth"
Body: "Your institutional memory in its natural, unexcavated state. The geological formation of your earliest competitive advantage. Nothing has been touched. Everything is present — but invisible."
Catalog: "CAT-HAB-001"
Text Content — Stage 1 (RAW — Raw Stone):
Title: "Stage 1 — Raw Stone"
Subtitle: "Excavated from your archives"
Body: "The uncut mineral specimen — pulled from the earth in its natural state. Recovered. Classified. Catalogued. Every artifact is tagged, dated, and entered into the permanent record."
Catalog: "CAT-RAW-001"
Text Content — Stage 2 (CUT — Cut & Shaped):
Title: "Stage 2 — Cut & Shaped"
Subtitle: "The Lapidary phase"
Body: "Raw findings faceted into strategic instruments of precision and clarity. The ten interlocking frameworks are applied. The triangulation protocol is executed. The truth emerges from the noise."
Catalog: "CAT-CUT-001"
Text Content — Stage 3 (MNT — Mounted):
Title: "Stage 3 — Mounted"
Subtitle: "Set in the case of authority"
Body: "Your signal mounted for deployment. The squircle case — precious metal, museum glass, perfect light. Ready for public view. Ready to be undeniable."
Catalog: "CAT-MNT-001"
Format Change — Use your existing .gem-journey-grid or stage cards. Keep the gemstone placeholder boxes as-is.

PAGE: serve.html
Page Title — Change to:
plain
Who We Serve — LEGAiSEE · I-35 Corridor · $30M+ Enterprises
Head / Meta Description — Replace with:
plain
LEGAiSEE serves enterprises with 5–10+ years of operating history, generationally owned businesses, and the $30M+ giants who built the San Antonio–Austin I-35 corridor.
Section 1 (Hero) —
Text Content — Hero headline: "Who We Serve"
Text Content — Hero subhead:
plain
Not every enterprise carries the depth of record that makes excavation worthwhile. These are the enterprises that do.
Section 2 (I-35 Corridor) —
Text Content — Section headline: "The I-35 Corridor"
Text Content — Body:
plain
San Antonio · Austin · The territory between them. The corridor where Texas-sized businesses built Texas-sized blind spots. The practice serves this corridor with forensic precision.
Section 3 (Qualification Filters) —
Text Content — Filter 1: "Five Years Minimum" — Operating history with sediment worth excavating.
Text Content — Filter 2: "$30M+ Annual Revenue" — Structural depth, not startup velocity.
Text Content — Filter 3: "Generational Ownership" — Family businesses with archives that span decades.
Text Content — Filter 4: "The Lost Signal" — A sense that something precise was lost in the transition.

PAGE: architect.html
Page Title — Change to:
plain
The Architect — LEGAiSEE · Methodology Origin · Voice
Head / Meta Description — Replace with:
plain
The Architect does not sell. The Architect excavates. The Architect listens to the silence between what you say and what your market hears. Meet the practitioner behind the methodology.
Section 1 (Hero) —
Text Content — Hero headline: "The Architect"
Text Content — Hero subhead:
plain
The Architect does not sell. The Architect excavates. The Architect listens to the silence between what you say and what your market hears.
Section 2 (Methodology Origin) —
Text Content — Section headline: "Where the Methodology Was Born"
Text Content — Body:
plain
The ten interlocking frameworks were not invented. They were excavated — from thirty years of signal craft, from the wreckage of campaigns that failed, from the quiet persistence of campaigns that worked, and from the realization that most enterprises do not need more tactics. They need the truth about what they already built.
Section 3 (The Voice) —
Text Content — Section headline: "The Voice of the Practice"
Text Content — Body:
plain
Speakeasy millionaire. Museum-quality prestige. Zero sales speak. The Architect does not pitch. The Architect presents findings. The work speaks, or it does not speak at all.

PAGE: practitioner.html
Page Title — Change to:
plain
The Practitioner — LEGAiSEE · Operations · Engagement Model
Head / Meta Description — Replace with:
plain
Operational details of the LEGAiSEE practice: how engagements are structured, how deliverables are produced, and how the three-client maximum preserves the quality of attention.
Section 1 (Hero) —
Text Content — Hero headline: "The Practitioner"
Text Content — Hero subhead:
plain
Operational details. Engagement structure. The mechanics of how three clients receive the full attention of one practitioner.
Section 2 (Engagement Model) —
Text Content — Section headline: "How Engagements Are Structured"
Text Content — Body:
plain
Each engagement follows the four-stage method: Habitat, Raw Stone, Cut & Shaped, Mounted. The timeline varies by Exhibit, but the sequence does not. Every excavation begins with the Shallow Dig. Every reconstruction ends with a system that produces signal without the practitioner's daily presence.
Section 3 (Deliverables) —
Text Content — Section headline: "What You Receive"
Text Content — Body:
plain
Written forensic briefs. Asset portfolios. Strategic blueprints. AI workflow systems. Voice profiles. Publishing rhythms. Performance dashboards. Everything is documented. Nothing is assumed. The deliverable is the beginning of your self-sustaining system.

PAGE: commissions.html
Page Title — Change to:
plain
Commissions — LEGAiSEE · Pricing · Exhibits · Invitation Mechanics
Head / Meta Description — Replace with:
plain
Commission structures for Business Archaeology engagements: Phase 0 Shallow Dig, Exhibit I through Exhibit IV, and the CAMERA Authority System. Invitation only. Three clients maximum.
Section 1 (Hero) —
Text Content — Hero headline: "Commissions"
Text Content — Hero subhead:
plain
The practice offers four Exhibits, each escalating in depth, duration, and structural impact. Every engagement begins with Phase 0. Every engagement ends with a self-sustaining system.
Section 2 (Phase 0 — Shallow Dig) —
Text Content — Exhibit name: "Phase 0 — The Shallow Dig"
Text Content — Price: "$2,500"
Text Content — Structure: "One-time · Non-refundable"
Text Content — Deliverable: "Written forensic brief"
Text Content — Who: "Principals only"
Section 3 (Exhibit I) —
Text Content — Exhibit name: "Exhibit I — The Audit"
Text Content — Price: "$7,500"
Text Content — Duration: "5–7 business days"
Text Content — Deliverable: "10-page forensic report + asset portfolio + video walkthrough"
Section 4 (Exhibit II) —
Text Content — Exhibit name: "Exhibit II — The Build"
Text Content — Price: "$18,500"
Text Content — Duration: "21–28 days"
Text Content — Deliverable: "Complete authority system + AI workflows + team training"
Section 5 (Exhibit III) —
Text Content — Exhibit name: "Exhibit III — The Partnership"
Text Content — Price: "$6,000–$10,000/month"
Text Content — Duration: "Ongoing · 8–12 hours/month"
Text Content — Deliverable: "Quarterly strategy retreats + annual updates + priority access"
Section 6 (Exhibit IV — CAMERA) —
Text Content — Exhibit name: "Exhibit IV — The CAMERA Authority System™"
Text Content — Price: "$7,500–$12,000"
Text Content — Duration: "16–24 hours · Intensive"
Text Content — Deliverable: "On-camera authority system + platform-specific skills + crisis protocol"
Format Change — Use your existing .exhibit-card classes. Featured/flagship card for Exhibit III (the ongoing retainer).

GLOBAL CHANGES (All Pages)
Nav link "Enter the Registry" — On every page, ensure the nav CTA links to registry.html.
Footer link "The Private Registry" — On every page, ensure the footer links to registry.html.
Meta viewport — Ensure all pages have:
plain
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
llms.txt readiness — Add this comment in the <head> of every page (for future llms.txt parsing):
plain
<!-- llms-ready: LEGAiSEE Business Archaeology & Authority Systems -->

That is the complete instruction set. Execute in whatever order suits your workflow. I am standing by if you need clarification on any section.


