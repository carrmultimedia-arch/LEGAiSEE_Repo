/* ═══════════════════════════════════════════════════════════════
   LEGAISEE — LUXURY ENHANCEMENT SYSTEM
   legaisee-luxury.css  v2.0


   Link on EVERY page immediately after legaisee.css:
     <link rel="stylesheet" href="legaisee-luxury.css" />


   This file handles:
   01. Root background — kill white bars permanently
   02. Mobile static backgrounds — iOS Safari fix
   03. Typography — Inter body, Cinzel Title Case
   04. Contrast — readable luminance on all elements
   05. Luxury backgrounds — gold spotlights + leather texture
   06. Card depth — warm surfaces, not flat dark mode
   07. Interactive enhancements — glows, transitions
   08. Nav Enter Registry — black text on gold
   09. Container crop fix — 2-col cards at wide viewports
   10. Home — Five Stages responsive stacking
   11. Method — Tier Grading System luminance
   12. Serve — remove white backgrounds
   13. Architect — edge-to-edge banner containers
   14. Practitioner — align to site system
   15. Commissions — is/is-not, Q&A gold, luminance
   16. Registry — alternating backgrounds, intake prominence
   17. Mobile background system — mobilebkgd.png per section
   18. CAMERA Authority System™ styles
   ═══════════════════════════════════════════════════════════════ */




/* ══════════════════════════════════════════════════════════════
   01. ROOT — KILL WHITE BARS PERMANENTLY
   ══════════════════════════════════════════════════════════════ */


html {
  background: #0C0C10;
}


html::before {
  content: '';
  position: fixed;
  inset: 0;
  z-index: -999;
  background: #0C0C10;
  pointer-events: none;
}


body {
  background: #0C0C10;
}


.section-block,
.lux-section,
.lux-section-sm,
.lux-section-lg {
  /* Ensure no section leaks transparent to white html */
  background-color: #0C0C10;
}


/* Obsidian variants */
[style*="var(--obsidian)"]        { background-color: #0C0C10 !important; }
[style*="var(--obsidian-light)"]  { background-color: #111115 !important; }
[style*="var(--obsidian-mid)"]    { background-color: #0f0f13 !important; }




/* ══════════════════════════════════════════════════════════════
   02. MOBILE STATIC BACKGROUNDS — iOS Safari fix
   background-attachment: fixed breaks on all iOS and many
   Android devices. Override all fixed attachments on mobile.
   The .page-bg div (position:fixed) is EXEMPT — it works.
   ══════════════════════════════════════════════════════════════ */


@media (max-width: 1024px) {
  *::before, *::after {
    background-attachment: scroll !important;
    background-size: cover !important;
    background-position: center center !important;
  }
  [style*="background-attachment"] {
    background-attachment: scroll !important;
    background-size: cover !important;
    background-position: center center !important;
  }
  /* .page-bg uses position:fixed — never touch it */
  .page-bg {
    background-attachment: unset !important;
  }
}


@supports (-webkit-touch-callout: none) {
  *::before, *::after {
    background-attachment: scroll !important;
  }
  [style*="background-attachment"] {
    background-attachment: scroll !important;
  }
  .page-bg { background-attachment: unset !important; }
}




/* ══════════════════════════════════════════════════════════════
   03. TYPOGRAPHY
   A) Inter everywhere for body/prose
   B) Cinzel headings: text-transform: none — Title Case only
      (update the actual HTML text to Title Case where needed)
   ══════════════════════════════════════════════════════════════ */


/* ── A) Inter for body ── */
p, li,
.b-xl, .b-lg, .b-md, .b-accent,
.record-card-body, .ledger-item, .faq-answer,
.exhibit-desc, .archetype-desc, .clause-text,
.principle-body, .lexicon-def, .decade-desc,
.excavation-desc, .opening-paragraph, .drift-event,
.industry-desc, .qf-question, .access-text, .conf-text,
.surface-item__body, .serve-definition-body,
.philosophy-block__body, .case-card__finding,
.case-card__result, .hero-statement, .hero-tagline,
.hero-subtitle, .timeline-body, .field-note-body,
.not-cell-desc, .deliverable-text, .commission-desc,
.ethics-body, .lindy-cell p, .archetype-desc,
.camera-lead, .camera-definition, .camera-tier-desc {
  font-family: 'Inter', 'Helvetica Neue', sans-serif !important;
  line-height: 1.80 !important;
}


/* ── B) Cinzel — no all-caps transform ── */
h1, h2, h3,
.d-xl, .d-lg, .d-md, .d-sm,
.archetype-type, .lindy-cell-title, .decade-title,
.excavation-title, .industry-name, .process-title,
.exhibit-name, .commission-name, .era-title,
.camera-title, .closing-headline,
.pledge-clause .clause-title,
.principle-statement,
.not-cell-title, .commission-name,
.lexicon-term, .conf-title, .serve-definition-term,
.case-card__title, .philosophy-block__heading,
.glance-title {
  text-transform: none !important;
}


/* Keep small utility labels uppercase — they're intentional */
/* .eyebrow, .micro-label, .prestige-label → remain uppercase */




/* ══════════════════════════════════════════════════════════════
   04. CONTRAST — READABLE LUMINANCE
   Gold on obsidian: effective color must achieve minimum 3:1
   for decorative / 4.5:1 for readable text.
   ══════════════════════════════════════════════════════════════ */


/* Ghost / watermark numerals — decorative, should be "findable" */
.phase-ghost                       { color: rgba(201,169,97,0.18) !important; }
.principle-ghost-num               { color: rgba(201,169,97,0.14) !important; }
.principle-card:hover
  .principle-ghost-num             { color: rgba(201,169,97,0.24) !important; }
.commission-roman                  { color: rgba(201,169,97,0.22) !important; }
.commission-card:hover
  .commission-roman,
.commission-card.featured
  .commission-roman                { color: rgba(201,169,97,0.38) !important; }
.framework-roman                   { color: rgba(201,169,97,0.28) !important; }
.framework-tile:hover
  .framework-roman                 { color: rgba(201,169,97,0.52) !important; }
.decade-label                      { color: rgba(201,169,97,0.32) !important; }
.decade-cell:hover .decade-label   { color: rgba(201,169,97,0.55) !important; }
.archetype-roman                   { color: rgba(201,169,97,0.20) !important; }
.archetype-card:hover
  .archetype-roman                 { color: rgba(201,169,97,0.35) !important; }


/* Labels — minimum 0.65 opacity gold */
.eyebrow, .micro-label, .phase-label,
.process-gem, .gem-journey-number,
.archetype-threshold, .case-outcome-label,
.section-number, .camera-eyebrow,
.camera-tier-label                 { color: rgba(201,169,97,0.68) !important; }
.prestige-label                    { color: rgba(201,169,97,0.70) !important; }
.signal-label                      { color: rgba(201,169,97,0.72) !important; }


/* Gem system */
.gem-catalog                       { color: rgba(201,169,97,0.72) !important; }
.gem-stage-name                    { color: #bfb090 !important; }
.gem-stage-desc                    { color: rgba(200,185,155,0.75) !important; }
.gem-caption-title                 { color: #d8be80 !important; }
.gem-caption-sub                   { color: rgba(200,188,165,0.68) !important; }


/* Drift diagram */
.drift-signal.strong               { color: #d4b878 !important; }
.drift-signal.fading               { color: rgba(185,172,140,0.72) !important; }
.drift-signal.lost                 { color: rgba(150,140,115,0.55) !important; }
.drift-era                         { color: rgba(201,169,97,0.68) !important; }
.drift-event                       { color: rgba(220,210,190,0.85) !important; }


/* Authority strip */
.authority-value                   { color: #dfc07e !important; }
.authority-label                   { color: rgba(205,195,172,0.72) !important; }


/* Ticker */
.ticker-item                       { color: rgba(185,175,152,0.78) !important; }


/* Footer */
.footer-copy                       { color: rgba(200,190,170,0.48) !important; }
.footer-seal                       { color: rgba(201,169,97,0.58) !important; }
.footer-links a                    { color: rgba(200,190,170,0.68) !important; }
.footer-brand-tagline              { color: rgba(200,190,170,0.65) !important; }


/* Nav */
.nav-links a                       { color: rgba(225,215,195,0.68) !important; }


/* Corridor */
.corridor-city-name                { color: #dfc07e !important; }
.corridor-mid-label                { color: rgba(201,169,97,0.68) !important; }
.corridor-city-sub                 { color: rgba(200,185,155,0.70) !important; }


/* Process */
.process-gem                       { color: rgba(201,169,97,0.65) !important; }
.process-desc                      { color: rgba(200,190,170,0.78) !important; }


/* Exclusion items */
.exclusion-box li                  { color: rgba(195,185,162,0.72) !important; }




/* ══════════════════════════════════════════════════════════════
   05. NAV — ENTER REGISTRY BLACK TEXT ON GOLD
   ══════════════════════════════════════════════════════════════ */


.nav-cta,
a.nav-cta,
.site-nav .nav-cta {
  color: #050505 !important;
  background: #C9A961 !important;
}


.nav-cta:hover,
a.nav-cta:hover {
  color: #C9A961 !important;
  background: transparent !important;
  border-color: rgba(201,169,97,0.65) !important;
}




/* ══════════════════════════════════════════════════════════════
   06. CONTAINER CROP FIX — 2-col cards at wide viewports
   At 1920px, section-inner is 1320px centered = 300px side
   margins. Cards inside grids were cropping on right because
   overflow: hidden on parent clips hover transforms.
   ══════════════════════════════════════════════════════════════ */


.section-inner,
.section-inner-narrow,
.section-inner-wide {
  overflow: visible !important;
}


/* Grid containers: always overflow-visible for hover transforms */
.two-col, .two-col-6040, .two-col-4060,
.asym-grid-a, .asym-grid-b,
.three-col, .four-col, .five-col,
.record-grid, .record-grid--wide,
.record-grid--3col {
  overflow: visible !important;
}


/* lux-section itself can clip so sections don't spill into next */
.lux-section { overflow: hidden; }


/* The right-column content inside asym grids — prevent its own overflow clipping */
.asym-grid-a > div:last-child,
.asym-grid-b > div:last-child,
.two-col > div:last-child {
  overflow: visible !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
}


/* Wider viewport section padding so content doesn't hug edges */
@media (min-width: 1600px) {
  .lux-section,
  .lux-section-sm,
  .lux-section-lg {
    padding-left: 120px !important;
    padding-right: 120px !important;
  }
  .section-inner { max-width: 1480px !important; }
  .section-inner-wide { max-width: 1600px !important; }
}


@media (min-width: 1920px) {
  .lux-section { padding-left: 160px !important; padding-right: 160px !important; }
  .section-inner { max-width: 1600px !important; }
}




/* ══════════════════════════════════════════════════════════════
   07. LUXURY BACKGROUNDS — LEATHER TEXTURE + GOLD SPOTLIGHTS
   ══════════════════════════════════════════════════════════════ */


:root {
  --leather: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='l'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.55' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='matrix' values='0.28 0.22 0.12 0 0 0.28 0.22 0.12 0 0 0.28 0.22 0.12 0 0 0 0 0 1 0'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23l)' opacity='0.06'/%3E%3C/svg%3E");
  --leather-fine: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='f'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.82' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='matrix' values='0.20 0.15 0.08 0 0 0.20 0.15 0.08 0 0 0.20 0.15 0.08 0 0 0 0 0 1 0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23f)' opacity='0.048'/%3E%3C/svg%3E");
}


/* Spotlight utility classes */
.bg-spotlight-nw {
  background:
    var(--leather),
    radial-gradient(ellipse 70% 55% at 15% 20%, rgba(201,169,97,0.09) 0%, transparent 55%),
    radial-gradient(ellipse 40% 35% at 85% 78%, rgba(201,169,97,0.04) 0%, transparent 50%),
    #0C0C10;
}
.bg-spotlight-ne {
  background:
    var(--leather),
    radial-gradient(ellipse 65% 50% at 85% 20%, rgba(201,169,97,0.09) 0%, transparent 55%),
    radial-gradient(ellipse 35% 30% at 15% 80%, rgba(201,169,97,0.04) 0%, transparent 50%),
    #0C0C10;
}
.bg-spotlight-center {
  background:
    var(--leather),
    radial-gradient(ellipse 80% 60% at 50% 35%, rgba(201,169,97,0.08) 0%, transparent 62%),
    radial-gradient(ellipse 50% 40% at 50% 90%, rgba(201,169,97,0.04) 0%, transparent 50%),
    #0C0C10;
}
.bg-spotlight-warm {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 50% at 30% 40%, rgba(201,169,97,0.07) 0%, transparent 55%),
    radial-gradient(ellipse 45% 35% at 75% 70%, rgba(201,169,97,0.04) 0%, transparent 50%),
    #111210;
}


/* Auto-applied leather to charcoal surfaces */
.charcoal-section,
.geography-strip,
.ticker-wrap {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 50% 60% at 50% 50%, rgba(201,169,97,0.04) 0%, transparent 65%),
    #1a1a1e !important;
}


/* Footer */
.site-footer {
  background:
    var(--leather),
    radial-gradient(ellipse 60% 80% at 50% 0%, rgba(201,169,97,0.06) 0%, transparent 55%),
    #1a1a1e !important;
}


/* Authority strip */
.authority-strip {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 100% at 50% 50%, rgba(201,169,97,0.05) 0%, transparent 70%),
    #1a1a1e !important;
}


/* Pledge box */
.pledge-box {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 70% 60% at 50% 30%, rgba(201,169,97,0.07) 0%, transparent 60%),
    #0f0f13 !important;
}


/* Signal block */
.signal-block {
  background:
    radial-gradient(ellipse 80% 60% at 0% 50%, rgba(201,169,97,0.07) 0%, transparent 60%),
    rgba(201,169,97,0.04) !important;
}


/* Golden era frame */
.golden-era-frame {
  background:
    var(--leather),
    radial-gradient(ellipse 80% 70% at 50% 50%, rgba(201,169,97,0.06) 0%, transparent 65%),
    linear-gradient(135deg, #1a1a1e 0%, #0f0f13 100%) !important;
}


/* Speakeasy frame */
.speakeasy-frame {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 50% at 30% 50%, rgba(201,169,97,0.05) 0%, transparent 60%),
    rgba(14,14,12,0.88) !important;
}


/* Hero vault home page */
.hero-vault {
  background:
    var(--leather),
    radial-gradient(ellipse 80% 70% at 50% 40%, rgba(201,169,97,0.07) 0%, transparent 65%),
    #0C0C10 !important;
}


/* Museum cards — warm spotlight from top-right */
.museum-card {
  position: relative;
  background: #141412 !important;
}
.museum-card::after {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse 70% 60% at 80% 15%, rgba(201,169,97,0.06) 0%, transparent 60%);
  pointer-events: none;
  z-index: 0;
  border-radius: inherit;
}
.museum-card > * { position: relative; z-index: 1; }


/* Decade cells */
.decade-cell::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse 80% 70% at 20% 80%, rgba(201,169,97,0.04) 0%, transparent 60%);
  pointer-events: none;
  z-index: 0;
}


/* Card warm base colors */
.museum-card,
.specimen-card,
.record-card,
.exhibit-card,
.lindy-cell,
.decade-cell {
  background-color: #141412 !important;
}


/* Featured cards */
.exhibit-card.exhibit-card--flagship,
.exhibit-card.exhibit-card--entry,
.commission-card.featured,
.archetype-card:nth-child(2) {
  background: linear-gradient(145deg, #1c1a14 0%, #131210 100%) !important;
}


/* Gate seal */
.gate-seal {
  background: rgba(201,169,97,0.03) !important;
  box-shadow: inset 0 0 40px rgba(201,169,97,0.03) !important;
}


/* Hover glows */
.museum-card:hover, .specimen-card:hover,
.exhibit-card:hover, .commission-card:hover,
.phase-card:hover, .industry-card:hover,
.framework-tile:hover {
  box-shadow:
    0 24px 80px rgba(0,0,0,0.70),
    0 0 40px rgba(201,169,97,0.09),
    0 4px 16px rgba(0,0,0,0.50) !important;
}


/* Button gold richer gradient */
.btn-gold {
  background: linear-gradient(135deg, #e8d5a3 0%, #C9A961 40%, #b8954d 70%, rgba(201,169,97,0.75) 100%) !important;
}




/* ══════════════════════════════════════════════════════════════
   08. HOME PAGE — FIVE STAGES RESPONSIVE STACKING
   Currently: grid-template-columns: repeat(5, 1fr) — all 5
   shrink too narrow on mobile. Fix: stack to 1 column.
   ══════════════════════════════════════════════════════════════ */


@media (max-width: 900px) {
  .gem-journey-grid {
    grid-template-columns: repeat(2, 1fr) !important;
  }
  .gem-journey-card:last-child {
    grid-column: 1 / -1; /* Fifth card full width */
  }
}


@media (max-width: 600px) {
  .gem-journey-grid {
    grid-template-columns: 1fr !important;
  }
  .gem-journey-card:last-child {
    grid-column: auto;
  }
  .gem-journey-card {
    border-right: none !important;
    border-bottom: 1px solid rgba(201,169,97,0.10);
  }
  .gem-journey-img {
    aspect-ratio: 16/7 !important;
    min-height: auto !important;
  }
  .gem-journey-card .gem-placeholder-box {
    min-height: 200px !important;
    aspect-ratio: 16/7 !important;
  }
}




/* ══════════════════════════════════════════════════════════════
   09. METHOD PAGE — HIERARCHY OF TRUTH / TIER GRADING
   Full luminance on all tier text, gold on tier titles/labels.
   ══════════════════════════════════════════════════════════════ */


/* Source hierarchy / tier labels */
.truth-tier,
.tier-1, .tier-2, .tier-3, .tier-4 {
  opacity: 1 !important;
  color: rgba(220,210,190,0.90) !important;
}


.tier-1 { color: #C9A961 !important; border-color: rgba(201,169,97,0.55) !important; }
.tier-2 { color: #b0b0b0 !important; border-color: rgba(176,176,176,0.45) !important; }
.tier-3 { color: rgba(190,180,160,0.82) !important; }
.tier-4 { color: rgba(160,150,130,0.65) !important; }


/* Any heading in a grading / hierarchy section */
.hierarchy-section h2,
.hierarchy-section h3,
.hierarchy-section .d-lg,
.hierarchy-section .d-md,
[data-section="hierarchy"] h2,
[data-section="hierarchy"] h3 {
  color: #C9A961 !important;
}


/* Override any stacked/faded text in the methodology sections */
.source-tier-title,
.tier-heading,
.tier-row-label,
.evidence-class-title {
  color: #C9A961 !important;
  opacity: 1 !important;
}


.source-tier-desc,
.tier-row-body,
.evidence-class-desc {
  color: rgba(220,210,190,0.88) !important;
  opacity: 1 !important;
}


/* Confidence scale markers */
.confidence-verified { color: #C9A961 !important; }
.confidence-probable { color: #b0b0b0 !important; }
.confidence-plausible { color: rgba(185,175,155,0.85) !important; }
.confidence-uncertain { color: rgba(160,150,130,0.72) !important; }
.confidence-unverified { color: rgba(140,130,110,0.55) !important; }




/* ══════════════════════════════════════════════════════════════
   10. SERVE PAGE — REMOVE WHITE / LIGHT BACKGROUNDS
   ══════════════════════════════════════════════════════════════ */


/* section-block defaults to transparent — force dark */
.section-block {
  background: #111210 !important;
}


/* Serve capabilities section — was transparent */
.serve-capabilities {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 50% at 70% 30%, rgba(201,169,97,0.06) 0%, transparent 55%),
    #111210 !important;
}


/* Definition items — no rogue backgrounds */
.serve-definitions-list,
.serve-definition-item {
  background: transparent !important;
}


/* Definition item borders/markers */
.serve-definition-item {
  border-bottom: 1px solid rgba(201,169,97,0.08) !important;
}
.serve-definition-item:first-child {
  border-top: 1px solid rgba(201,169,97,0.08) !important;
}


/* Serve hero — ensure no bleed-through from section below */
.serve-hero {
  background: #0C0C10 !important;
}


/* Archetype grid background */
.archetype-grid {
  background: rgba(201,169,97,0.02) !important;
}


/* Corridor visual — fix any white glitch */
.corridor-visual,
.corridor-city,
.corridor-spine,
.corridor-city-name,
.corridor-mid {
  background: transparent !important;
}




/* ══════════════════════════════════════════════════════════════
   11. ARCHITECT PAGE — EDGE-TO-EDGE BANNER FIX
   Three banner sections have no inner containers:
   .architect-phrase-block and .architect-pull-quote
   ══════════════════════════════════════════════════════════════ */


.architect-phrase-block {
  padding-left: clamp(24px, 8vw, 90px) !important;
  padding-right: clamp(24px, 8vw, 90px) !important;
  box-sizing: border-box !important;
  max-width: 100% !important;
}


.architect-phrase-block__inner,
.architect-phrase-block .signal-block {
  max-width: 1320px !important;
  margin-left: auto !important;
  margin-right: auto !important;
  width: 100% !important;
}


.architect-pull-quote {
  padding-left: clamp(24px, 8vw, 90px) !important;
  padding-right: clamp(24px, 8vw, 90px) !important;
  box-sizing: border-box !important;
}


.architect-pull-quote blockquote,
.architect-pull-quote .pull-quote__text {
  max-width: 1320px !important;
  margin-left: auto !important;
  margin-right: auto !important;
}


/* Third banner — the signal phrase block at bottom */
.phrase-block--signal {
  padding-left: clamp(24px, 8vw, 90px) !important;
  padding-right: clamp(24px, 8vw, 90px) !important;
}


.phrase-block--signal .architect-phrase-block__inner {
  max-width: 1320px !important;
  margin: 0 auto !important;
}


@media (max-width: 768px) {
  .architect-phrase-block,
  .architect-pull-quote,
  .phrase-block--signal {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }
}




/* ══════════════════════════════════════════════════════════════
   12. PRACTITIONER PAGE — ALIGN TO SITE SYSTEM
   Practitioner has standalone CSS; these overrides bring
   its visual language in line with legaisee.css tokens.
   ══════════════════════════════════════════════════════════════ */


/* Body/era sections */
.era-section {
  background: #0C0C10 !important;
}
.era-section--surface {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 50% at 30% 40%, rgba(201,169,97,0.06) 0%, transparent 55%),
    #111210 !important;
}


/* Hero */
.practitioner-hero {
  background:
    var(--leather),
    radial-gradient(ellipse 60% 60% at 70% 40%, rgba(201,169,97,0.09) 0%, transparent 60%),
    #0C0C10 !important;
}


/* Stat strip — practitioner uses slightly different styling */
.stats-strip {
  background: #1a1a1e !important;
  border-color: rgba(201,169,97,0.22) !important;
}


.stat-figure { color: #C9A961 !important; }
.stat-label  { color: rgba(200,190,170,0.68) !important; }
.stat-cell   { border-right-color: rgba(201,169,97,0.18) !important; }


/* Ethics section */
.ethics-block { background: #111210 !important; }
.ethics-body  { color: rgba(220,210,190,0.82) !important; }


/* Closing section */
.closing-section {
  background:
    var(--leather),
    radial-gradient(ellipse 50% 60% at 50% 0%, rgba(201,169,97,0.09) 0%, transparent 70%),
    #0C0C10 !important;
}


/* Credential pills */
.credential-pill {
  background: rgba(201,169,97,0.04) !important;
  border-color: rgba(201,169,97,0.22) !important;
  color: rgba(220,210,190,0.75) !important;
}


/* Timeline */
.timeline::before { background: rgba(201,169,97,0.30) !important; }
.timeline-item::before { background: #C9A961 !important; }
.timeline-year { color: rgba(201,169,97,0.80) !important; }
.timeline-body { color: rgba(220,210,190,0.82) !important; }
.timeline-org  { color: #ebebeb !important; }


/* Record cards */
.record-card {
  background: #141412 !important;
  border-color: rgba(201,169,97,0.14) !important;
}
.record-card--accented {
  border-top: 2px solid #C9A961 !important;
}
.record-card-label { color: rgba(201,169,97,0.72) !important; }
.record-card-title { color: #ebebeb !important; }
.record-card-meta  { color: rgba(200,190,170,0.60) !important; }
.record-card-body  { color: rgba(220,210,190,0.82) !important; }


/* Proof block */
.proof-block {
  background: rgba(201,169,97,0.04) !important;
  border-left-color: #C9A961 !important;
}
.proof-block-label { color: rgba(201,169,97,0.72) !important; }
.proof-block-title { color: #ebebeb !important; }
.proof-block-body  { color: rgba(220,210,190,0.82) !important; }


/* Field note */
.field-note {
  background: rgba(201,169,97,0.03) !important;
  border-color: rgba(201,169,97,0.14) !important;
}
.field-note-label { color: rgba(200,190,170,0.60) !important; }
.field-note-body  { color: rgba(200,190,170,0.72) !important; }


/* Practitioner hero credentials */
.hero-eyebrow-text { color: rgba(201,169,97,0.78) !important; }
.hero-eyebrow-line { background: rgba(201,169,97,0.55) !important; }
.hero-name  { color: #ebebeb !important; }
.hero-title { color: rgba(201,169,97,0.85) !important; }
.hero-statement { color: rgba(220,210,190,0.82) !important; }


/* Pull quote */
.pull-quote__mark { color: rgba(201,169,97,0.35) !important; }
.pull-quote__text { color: #ebebeb !important; }
.pull-quote__rule { background: #C9A961 !important; }


/* Section divider */
.section-divider {
  background: linear-gradient(90deg, transparent, rgba(201,169,97,0.35), transparent 30%) !important;
}


/* Era headers */
.era-title    { color: #ebebeb !important; }
.era-subtitle { color: rgba(200,190,170,0.65) !important; }


/* Closing */
.closing-headline { color: #ebebeb !important; }
.closing-body     { color: rgba(220,210,190,0.80) !important; }
.closing-cta {
  background: #C9A961 !important;
  color: #050505 !important;
}
.closing-note { color: rgba(200,190,170,0.58) !important; }


/* Footer — practitioner has its own simplified footer */
.practitioner-page .site-footer .footer-text {
  color: rgba(200,190,170,0.50) !important;
}




/* ══════════════════════════════════════════════════════════════
   13. COMMISSIONS PAGE — IS/IS-NOT LUMINANCE + Q&A GOLD
   ══════════════════════════════════════════════════════════════ */


/* "This is not / this is" grid — full luminance on excluded items */
.not-this-cell {
  background: #111210 !important;
}
.not-this-cell .not-cell-label {
  color: rgba(170,160,140,0.70) !important;
}
.not-this-cell .not-cell-title {
  color: rgba(200,190,165,0.82) !important;
  text-transform: none !important;
}
.not-this-cell .not-cell-desc {
  color: rgba(200,190,165,0.78) !important;
  font-family: 'Inter', sans-serif !important;
}


/* "This IS" cells — gold labels, full luminance body */
.not-this-cell.is-this {
  background: #141412 !important;
  border-color: rgba(201,169,97,0.20) !important;
}
.not-this-cell.is-this .not-cell-label {
  color: rgba(201,169,97,0.80) !important;
}
.not-this-cell.is-this .not-cell-title {
  color: #ebebeb !important;
}
.not-this-cell.is-this .not-cell-desc {
  color: rgba(225,215,195,0.88) !important;
}


/* Q&A section — gold questions */
.faq-question {
  color: #C9A961 !important;
  font-family: 'Cinzel', serif !important;
  text-transform: none !important;
}
.faq-answer {
  color: rgba(220,210,190,0.85) !important;
  font-family: 'Inter', sans-serif !important;
}
.faq-item {
  border-color: rgba(201,169,97,0.12) !important;
}
.faq-item__marker {
  background: rgba(201,169,97,0.55) !important;
}


/* Exhibit system labels */
.exhibit-label    { color: rgba(201,169,97,0.75) !important; }
.exhibit-price    { color: #C9A961 !important; }
.exhibit-price-note { color: rgba(201,169,97,0.62) !important; }
.exhibit-name     { color: #C9A961 !important; }


/* Process timeline nodes */
.process-node { border-color: rgba(201,169,97,0.35) !important; color: rgba(201,169,97,0.72) !important; }
.process-step:hover .process-node {
  border-color: #C9A961 !important;
  color: #C9A961 !important;
  background: rgba(201,169,97,0.07) !important;
}
.process-title { color: #dfc07e !important; }


/* Pledge clauses */
.clause-num   { color: rgba(201,169,97,0.65) !important; }
.clause-title { color: #dfc07e !important; }
.clause-text  { color: rgba(220,210,190,0.85) !important; font-family: 'Inter', sans-serif !important; }




/* ══════════════════════════════════════════════════════════════
   14. REGISTRY PAGE — ALTERNATING BACKGROUNDS + INTAKE PROMINENCE
   ══════════════════════════════════════════════════════════════ */


/* Intake section — MAXIMUM PRESENCE, catches the eye at any scroll speed */
.intake-prestige-section {
  background:
    var(--leather),
    radial-gradient(ellipse 90% 60% at 50% 20%, rgba(201,169,97,0.14) 0%, rgba(201,169,97,0.05) 50%, transparent 75%),
    radial-gradient(ellipse 60% 40% at 10% 80%, rgba(201,169,97,0.07) 0%, transparent 55%),
    radial-gradient(ellipse 50% 40% at 90% 80%, rgba(201,169,97,0.05) 0%, transparent 50%),
    #0C0C10 !important;
  border-top: 1px solid rgba(201,169,97,0.22) !important;
  border-bottom: 1px solid rgba(201,169,97,0.22) !important;
  position: relative !important;
}


/* Intake frame — prominent glowing border */
.intake-glow-wrap {
  filter: drop-shadow(0 0 40px rgba(201,169,97,0.18)) drop-shadow(0 0 80px rgba(201,169,97,0.08)) !important;
}


.intake-border-frame {
  box-shadow:
    0 0 60px rgba(201,169,97,0.18),
    0 0 120px rgba(201,169,97,0.09),
    0 32px 80px rgba(0,0,0,0.65) !important;
}


/* Intake header prominence */
.intake-prestige-header h2 {
  color: #ebebeb !important;
}


.intake-start-btn {
  border-color: rgba(201,169,97,0.75) !important;
  color: #C9A961 !important;
  font-size: 0.70rem !important;
  padding: 17px 48px !important;
}
.intake-start-btn:hover {
  background: rgba(201,169,97,0.10) !important;
  box-shadow: 0 0 30px rgba(201,169,97,0.18) !important;
}


/* Registry alternating section backgrounds */
.registry-entry-hook {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 55% 50% at 80% 35%, rgba(201,169,97,0.06) 0%, transparent 55%),
    #111210 !important;
}


.threshold-section {
  background:
    var(--leather),
    radial-gradient(ellipse 65% 55% at 75% 40%, rgba(201,169,97,0.08) 0%, transparent 58%),
    #0C0C10 !important;
}


.confidentiality-section {
  background:
    var(--leather-fine),
    radial-gradient(ellipse 60% 50% at 25% 35%, rgba(201,169,97,0.07) 0%, transparent 55%),
    #111210 !important;
}


/* Registry final section (If You Are Still Reading...) */
.registry-entry-hook ~ .lux-section:last-of-type,
section[style*="padding-top: 120px"][style*="padding-bottom: 160px"] {
  background:
    var(--leather),
    radial-gradient(ellipse 60% 55% at 20% 30%, rgba(201,169,97,0.09) 0%, transparent 55%),
    #0C0C10 !important;
}


/* Vault portrait */
.vault-portrait { border-color: rgba(201,169,97,0.22) !important; }
.vault-portrait-caption { background: linear-gradient(to top, rgba(5,5,5,0.98) 0%, rgba(5,5,5,0.55) 65%, transparent 100%) !important; }


/* Access criteria rows */
.access-row:hover { background: rgba(201,169,97,0.03) !important; }
.access-check { border-color: rgba(201,169,97,0.30) !important; color: rgba(201,169,97,0.72) !important; }
.access-text  { color: rgba(220,210,190,0.85) !important; }
.access-status.req  { color: rgba(201,169,97,0.72) !important; }
.access-status.pref { color: rgba(185,175,152,0.68) !important; }


/* Confidentiality cells */
.conf-cell { background: #141412 !important; }
.conf-cell:hover { background: #111210 !important; }
.conf-icon  { color: rgba(201,169,97,0.32) !important; }
.conf-title { color: #dfc07e !important; }
.conf-text  { color: rgba(220,210,190,0.82) !important; font-family: 'Inter', sans-serif !important; }


/* Surface items (Phase 0 surfaces grid) */
.surface-item {
  background: rgba(201,169,97,0.03) !important;
  border-color: rgba(201,169,97,0.18) !important;
}
.surface-item:hover { border-color: rgba(201,169,97,0.38) !important; }
.surface-item__title { color: #C9A961 !important; }
.surface-item__body  { color: rgba(220,210,190,0.82) !important; }


/* Registry terms bar */
.registry-terms-bar { border-color: rgba(201,169,97,0.25) !important; }
.registry-term__label { color: rgba(201,169,97,0.62) !important; }
.registry-term__value { color: #C9A961 !important; }


/* Entry hook headings */
.entry-hook__statement { color: #C9A961 !important; }
.entry-hook__lead { color: rgba(220,210,190,0.85) !important; }
.entry-hook__clarification { color: rgba(210,200,178,0.80) !important; }
.not-magnet__statement { color: #dfc07e !important; }
.not-magnet__detail { color: rgba(210,200,178,0.80) !important; }


/* Back-to-intake button */
.back-to-intake-btn {
  background: #141412 !important;
  border-color: rgba(201,169,97,0.40) !important;
  color: #C9A961 !important;
}
.back-to-intake-btn:hover {
  border-color: rgba(201,169,97,0.70) !important;
  box-shadow: 0 0 20px rgba(201,169,97,0.12) !important;
}




/* ══════════════════════════════════════════════════════════════
   15. MOBILE BACKGROUND SYSTEM
   On mobile, all section ::before background images are
   replaced with mobilebkgd.png. Each section controls its OWN
   filter/opacity in its page's <style> block so you can adjust
   per-section without touching this master file.


   HOW TO USE:
   1. Add class="mobile-bg-section" to any <section> that has
      a background-image in its ::before pseudo-element.
   2. In that page's <style> block, add:


      @media (max-width: 1024px) {
        .your-section-class::before {
          filter: brightness(0.5) blur(3px);
          opacity: 0.30;
        }
      }


   3. Adjust brightness / blur / opacity until it looks right
      for that specific section. Each section is independent.
   ══════════════════════════════════════════════════════════════ */


@media (max-width: 1024px) {


  /* Any section with the utility class */
  .mobile-bg-section::before {
    background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important;
    background-attachment: scroll !important;
    background-size: cover !important;
    background-position: center center !important;
    /* filter and opacity are set per-section in each page's <style> block */
  }


  /* Known site sections — apply the mobile bg by section class */
  /* Each page's <style> block then sets the filter/opacity individually */


  /* archaeology.html */
  .arch-hero::before,
  .arch-cta-section::before       { background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important; }


  /* architect.html */
  .architect-hero::before,
  .silence-section::before,
  .architect-cta::before          { background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important; }


  /* commissions.html */
  .commissions-hero::before,
  .bedrock-section::before        { background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important; }


  /* serve.html */
  .serve-hero::before             { background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important; }


  /* index.html */
  .hero-vault::before,
  .velvet-rope-section::before,
  .final-cta::before              { background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important; }


  /* inline bg-image divs inside sections — these are the absolute-positioned
     overlay divs with inline style="background-image: url(...)". They also
     get overridden here. Per-section opacity is set in page <style> blocks. */
  [style*="background-image"][style*="position: absolute"] {
    background-image: url('https://www.legaisee.com/Images/mobilebkgd.png') !important;
    background-size: cover !important;
    background-position: center center !important;
  }


}


/* Inline background div mobile defaults — moderate brightness */
@media (max-width: 1024px) {
  [style*="background-image"][style*="position: absolute"] {
    /* Default: moderate. Override per-section in page <style>. */
    filter: brightness(0.5) !important;
  }
}




/* ══════════════════════════════════════════════════════════════
   16. GENERAL MOBILE POLISH
   ══════════════════════════════════════════════════════════════ */


@media (max-width: 768px) {
  .lux-section,
  .lux-section-sm,
  .lux-section-lg  { padding-left: 20px !important; padding-right: 20px !important; }
  .section-block   { padding-left: 20px !important; padding-right: 20px !important; }


  .authority-strip { grid-template-columns: repeat(2, 1fr) !important; }
  .authority-item:nth-child(5) { grid-column: 1 / -1; }


  .d-xl { font-size: clamp(1.9rem, 9vw, 2.8rem) !important; }
  .d-lg { font-size: clamp(1.5rem, 7vw, 2.1rem) !important; }


  .btn-group { flex-direction: column !important; align-items: stretch !important; }
  .btn { width: 100% !important; justify-content: center !important; }


  * { max-width: 100%; box-sizing: border-box; }
  .section-inner, .container { overflow-x: hidden !important; }
}


@media (max-width: 480px) {
  .d-xl { font-size: clamp(1.6rem, 8vw, 2.2rem) !important; }
  .d-lg { font-size: clamp(1.3rem, 6.5vw, 1.8rem) !important; }
}




/* ══════════════════════════════════════════════════════════════
   17. CAMERA AUTHORITY SYSTEM™ — Commission section styles
   ══════════════════════════════════════════════════════════════ */


.camera-section {
  position: relative;
  overflow: hidden;
  background:
    var(--leather),
    radial-gradient(ellipse 70% 55% at 15% 25%, rgba(201,169,97,0.10) 0%, transparent 55%),
    radial-gradient(ellipse 50% 40% at 85% 70%, rgba(201,169,97,0.05) 0%, transparent 50%),
    #0C0C10;
  padding: 120px 90px;
}


.camera-eyebrow {
  font-family: 'Inter', sans-serif;
  font-size: 0.65rem;
  font-weight: 600;
  letter-spacing: 0.30em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.72);
  display: block;
  margin-bottom: 20px;
}


.camera-title {
  font-family: 'Cinzel Decorative', 'Cinzel', serif;
  font-size: clamp(1.8rem, 3.5vw, 3rem);
  font-weight: 400;
  color: #ebebeb;
  letter-spacing: 0.05em;
  line-height: 1.15;
  margin-bottom: 8px;
  text-transform: none !important;
}


.camera-tm {
  font-family: 'Inter', sans-serif;
  font-size: 0.60rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.68);
  vertical-align: super;
  margin-left: 6px;
}


.camera-subtitle {
  font-family: 'Cinzel', serif;
  font-size: clamp(0.82rem, 1.3vw, 0.98rem);
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.72);
  margin-bottom: 36px;
  display: block;
}


.camera-lead {
  font-family: 'Inter', sans-serif;
  font-size: clamp(0.98rem, 1.6vw, 1.18rem);
  color: rgba(215,205,182,0.85);
  line-height: 1.82;
  max-width: 780px;
  margin-bottom: 64px;
}


.camera-addon-badge {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-family: 'Inter', sans-serif;
  font-size: 0.58rem;
  font-weight: 600;
  letter-spacing: 0.24em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.78);
  border: 1px solid rgba(201,169,97,0.30);
  padding: 8px 20px;
  margin-bottom: 28px;
  background: rgba(201,169,97,0.04);
}


/* Acronym table */
.camera-acronym {
  display: flex;
  flex-direction: column;
  border: 1px solid rgba(201,169,97,0.14);
  margin-bottom: 64px;
  overflow: hidden;
}


.camera-row {
  display: grid;
  grid-template-columns: 72px 220px 1fr;
  align-items: stretch;
  border-bottom: 1px solid rgba(201,169,97,0.08);
  transition: background 0.3s ease;
}
.camera-row:last-child { border-bottom: none; }
.camera-row:hover { background: rgba(201,169,97,0.04); }


.camera-letter {
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cinzel Decorative', serif;
  font-size: 2rem;
  color: rgba(201,169,97,0.32);
  background: rgba(201,169,97,0.03);
  border-right: 1px solid rgba(201,169,97,0.10);
  transition: color 0.3s ease;
  padding: 26px 16px;
}
.camera-row:hover .camera-letter { color: rgba(201,169,97,0.68); }


.camera-word {
  display: flex;
  align-items: center;
  padding: 26px 28px;
  border-right: 1px solid rgba(201,169,97,0.08);
}
.camera-word-inner {
  font-family: 'Cinzel', serif;
  font-size: clamp(0.80rem, 1.2vw, 0.94rem);
  letter-spacing: 0.10em;
  text-transform: uppercase;
  color: #dfc07e;
  line-height: 1.4;
}


.camera-definition {
  display: flex;
  align-items: center;
  padding: 26px 30px;
  font-family: 'Inter', sans-serif;
  font-size: 0.96rem;
  color: rgba(215,205,182,0.85);
  line-height: 1.70;
}


/* Tier pricing */
.camera-tiers {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 48px;
}


.camera-tier-card {
  background: #141412;
  border: 1px solid rgba(201,169,97,0.15);
  padding: 36px 30px;
  position: relative;
  overflow: hidden;
  transition: border-color 0.3s ease, transform 0.3s ease;
}
.camera-tier-card:hover {
  border-color: rgba(201,169,97,0.38);
  transform: translateY(-4px);
}
.camera-tier-card.featured {
  border-color: rgba(201,169,97,0.35);
  background: linear-gradient(145deg, #1c1a14 0%, #131210 100%);
}
.camera-tier-card.featured::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent 10%, #C9A961 50%, transparent 90%);
}
.camera-tier-label {
  font-family: 'Inter', sans-serif;
  font-size: 0.60rem;
  font-weight: 600;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.68);
  display: block;
  margin-bottom: 10px;
}
.camera-tier-price {
  font-family: 'Cinzel Decorative', serif;
  font-size: clamp(1.3rem, 2.2vw, 1.7rem);
  color: #C9A961;
  letter-spacing: 0.04em;
  display: block;
  margin-bottom: 16px;
  text-transform: none !important;
}
.camera-tier-desc {
  font-family: 'Inter', sans-serif;
  font-size: 0.90rem;
  color: rgba(190,180,158,0.82);
  line-height: 1.72;
  margin-bottom: 20px;
}
.camera-tier-features {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.camera-tier-features li {
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: rgba(205,195,172,0.78);
  padding-left: 18px;
  position: relative;
  line-height: 1.55;
}
.camera-tier-features li::before {
  content: '◆';
  position: absolute;
  left: 0; top: 3px;
  color: rgba(201,169,97,0.48);
  font-size: 0.42rem;
}
.camera-scope-note {
  font-family: 'Inter', sans-serif;
  font-size: 0.78rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.50);
  margin-top: 10px;
  display: block;
}


@media (max-width: 900px) {
  .camera-section { padding: 72px 20px !important; }
  .camera-row { grid-template-columns: 52px 1fr; }
  .camera-word { display: none; }
  .camera-tiers { grid-template-columns: 1fr !important; }
}

