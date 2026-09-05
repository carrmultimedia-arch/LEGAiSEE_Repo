/* ═══════════════════════════════════════════════════════════════════
   LEGAISEE — MASTER DESIGN SYSTEM  v2.0
   Business Archaeology & Authority Systems
   Target: $30M+ Enterprises · San Antonio/Austin I-35 Corridor
   Aesthetic: Rolls Royce · Rolex · Museum · Speakeasy Authority


   SINGLE SOURCE OF TRUTH — no page-level overrides needed.
   No violet. No purple. No exceptions.
   ═══════════════════════════════════════════════════════════════════ */


@import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap');




/* ─── DESIGN TOKENS ────────────────────────────────────────────── */
:root {


  /* ── Core Blacks (Practitioner page standard) ── */
  --obsidian:        #0C0C10;
  --obsidian-light:  #111115;
  --obsidian-mid:    #0f0f13;
  --surface:         #181818;
  --card:            #141414;
  --charcoal:        #1a1a1e;
  --graphite:        #242428;
  --graphite-light:  #2e2e32;


  /* ── True Gold Scale ── */
  --gold:            #C9A961;
  --gold-light:      #D4B978;
  --gold-bright:     #E8D5A3;
  --gold-vivid:      #F0C24B;
  --gold-dim:        rgba(201, 169, 97, 0.45);
  --gold-low:        rgba(201, 169, 97, 0.15);
  --gold-glow:       rgba(201, 169, 97, 0.08);
  --gold-whisper:    rgba(201, 169, 97, 0.04);
  --gold-border:     rgba(201, 169, 97, 0.20);
  --gold-border-str: rgba(201, 169, 97, 0.45);


  /* ── Text (Practitioner-calibrated contrast) ── */
  --text-primary:    rgba(255, 255, 255, 0.92);
  --text-body:       rgba(255, 255, 255, 0.78);
  --text-muted:      rgba(255, 255, 255, 0.55);
  --platinum:        #EBEBEB;
  --silver:          #B0B0B0;
  --pewter:          #787878;
  --white:           #FFFFFF;


  /* ── Typography ── */
  --font-display:    'Cinzel Decorative', 'Cinzel', Georgia, serif;
  --font-cinzel:     'Cinzel', Georgia, serif;
  --font-body:       'Cormorant Garamond', Georgia, serif;
  --font-ui:         'Inter', 'Helvetica Neue', sans-serif;


  /* ── Nav ── */
  --nav-height:      76px;


  /* ── Shadows ── */
  --shadow-gold:   0 0 60px rgba(201,169,97,0.10), 0 0 120px rgba(201,169,97,0.05);
  --shadow-card:   0 24px 80px rgba(0,0,0,0.70), 0 4px 16px rgba(0,0,0,0.50);
  --shadow-lift:   0 32px 100px rgba(0,0,0,0.80), 0 0 60px rgba(201,169,97,0.06);


  /* ── Easing ── */
  --ease-silk:     cubic-bezier(0.25, 0.46, 0.45, 0.94);
  --ease-gold:     cubic-bezier(0.22, 0.68, 0, 1.2);
  --ease-dramatic: cubic-bezier(0.16, 1, 0.3, 1);
}




/* ─── RESET ───────────────────────────────────────────────────── */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
html {
  font-size: 17px;
  scroll-behavior: smooth;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  overflow-x: hidden;
  width: 100%;
}
body {
  font-family: var(--font-ui);
  background: var(--surface);
  color: var(--text-body);
  line-height: 1.78;
  font-weight: 400;
  overflow-x: hidden;
  max-width: 100%;
  width: 100%;
  padding-top: var(--nav-height);
}
/* Subtle grain — the leather feel */
body::after {
  content: '';
  position: fixed;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 9999;
  opacity: 0.25;
}
a { color: inherit; text-decoration: none; transition: color 0.25s ease; }
a:hover { color: var(--gold-light); }
img { display: block; max-width: 100%; }
button { font-family: inherit; cursor: pointer; border: none; background: none; }
p { margin-bottom: 1.2rem; }
p:last-child { margin-bottom: 0; }
::selection { background: rgba(201,169,97,0.18); color: var(--white); }




/* ─── TYPOGRAPHY SYSTEM ───────────────────────────────────────── */


/* Display — Cinzel Decorative for hero / section heads */
h1, h2, h3, .d-xl, .d-lg, .d-md, .d-sm {
  font-family: var(--font-display);
  font-weight: 400;
  color: var(--text-primary);
  line-height: 1.15;
  letter-spacing: 0.04em;
}
h4, h5, h6 {
  font-family: var(--font-cinzel);
  font-weight: 500;
  color: var(--gold);
  font-size: 0.72rem;
  letter-spacing: 0.18em;
  text-transform: none;
}


.d-xl {
  font-size: clamp(2.6rem, 5.5vw, 5rem);
  line-height: 1.08;
  letter-spacing: 0.05em;
  text-transform: none;
}
.d-lg {
  font-size: clamp(1.8rem, 3.5vw, 3.2rem);
  line-height: 1.15;
  letter-spacing: 0.04em;
  text-transform: none;
}
.d-md {
  font-size: clamp(1.3rem, 2.2vw, 2rem);
  line-height: 1.22;
  letter-spacing: 0.05em;
  text-transform: none;
}
.d-sm {
  font-size: clamp(1rem, 1.6vw, 1.4rem);
  letter-spacing: 0.08em;
  text-transform: uppercase;
}


/* Body — Inter (sans-serif) for all prose. Matches Practitioner standard site-wide. */
.b-xl {
  font-family: var(--font-ui);
  font-size: clamp(1.05rem, 1.9vw, 1.3rem);
  font-weight: 400;
  line-height: 1.82;
  color: var(--silver);
}
.b-lg {
  font-family: var(--font-ui);
  font-size: clamp(0.95rem, 1.5vw, 1.1rem);
  font-weight: 400;
  line-height: 1.80;
  color: var(--silver);
}
.b-md {
  font-family: var(--font-ui);
  font-size: 0.96rem;
  line-height: 1.78;
  color: var(--pewter);
}
.b-accent {
  font-family: var(--font-ui);
  font-size: clamp(1rem, 1.7vw, 1.2rem);
  font-style: italic;
  color: var(--gold-bright);
  line-height: 1.8;
}
/* Global p — Inter everywhere */
p {
  font-family: var(--font-ui);
  font-size: clamp(0.95rem, 1.4vw, 1.05rem);
  line-height: 1.82;
  color: var(--text-body);
}


/* Labels */
.prestige-label {
  display: inline-flex;
  align-items: center;
  gap: 16px;
  font-family: var(--font-ui);
  font-size: 0.72rem;
  font-weight: 500;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  color: var(--gold-dim);
  margin-bottom: 24px;
}
.prestige-label::before,
.prestige-label::after {
  content: '';
  flex: 0 0 40px;
  height: 1px;
  background: linear-gradient(to right, transparent, var(--gold));
}
.prestige-label::after {
  background: linear-gradient(to left, transparent, var(--gold));
}


.eyebrow {
  font-family: var(--font-ui);
  font-size: 0.72rem;
  font-weight: 500;
  letter-spacing: 0.24em;
  text-transform: uppercase;
  color: var(--gold-dim);
  display: block;
  margin-bottom: 18px;
}
.micro-label {
  font-family: var(--font-ui);
  font-size: 0.68rem;
  font-weight: 500;
  letter-spacing: 0.24em;
  text-transform: uppercase;
  color: var(--pewter);
  display: block;
}




body {
  background: transparent;
}
/* Utilities */
.text-gold    { color: var(--gold); }
.text-gold-b  { color: var(--gold-bright); }
.text-gold-l  { color: var(--gold-light); }
.text-silver  { color: var(--silver); }
.text-plat    { color: var(--platinum); }
.text-italic  { font-style: italic; }


/* Dividers */
.divider-gold {
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(201,169,97,0.50), transparent);
  margin: 44px auto;
}
.divider-gold.short { width: 80px; }
.divider-gold.med   { width: 160px; }
.divider-gold.full  { width: 100%; }




/* ═══════════════════════════════════════════════════════════════
   NAVIGATION
   Single system. One desktop nav. One mobile nav.
   No conflicts. No duplicates.
   ═══════════════════════════════════════════════════════════════ */


.site-nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 900;
  height: var(--nav-height);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 48px;
  background: rgba(12, 12, 16, 0.94);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(201,169,97,0.10);
  transition: background 0.4s ease, border-color 0.4s ease;
}
.site-nav.scrolled {
  background: rgba(8, 8, 12, 0.98);
  border-bottom-color: rgba(201,169,97,0.16);
}


/* Logo */
.nav-logo-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}
.nav-logo-wrap img {
  height: 38px;
  width: auto;
  filter: brightness(1.05);
}
.nav-logo-text {
  font-family: var(--font-cinzel);
  font-size: 0.72rem;
  font-weight: 500;
  letter-spacing: 0.28em;
  text-transform: none;
  color: var(--gold);
  line-height: 1;
}


/* ── Desktop: Two-tier nav ── */
/* Primary links — the practice pages */
.nav-links {
  display: flex;
  align-items: center;
  gap: 32px;
  list-style: none;
}
.nav-links a {
  font-family: var(--font-ui);
  font-size: 0.60rem;
  font-weight: 500;
  letter-spacing: 0.20em;
  text-transform: none;
  color: var(--text-muted);
  position: relative;
  padding-bottom: 3px;
  white-space: nowrap;
  transition: color 0.3s ease;
}
.nav-links a::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0;
  width: 0; height: 1px;
  background: var(--gold);
  transition: width 0.35s var(--ease-silk);
}
.nav-links a:hover,
.nav-links a.is-active {
  color: var(--gold-light);
}
.nav-links a:hover::after,
.nav-links a.is-active::after {
  width: 100%;
}


/* ── Enter the Registry CTA — gold box, black text; inverts on hover ── */
.nav-cta {
  font-family: var(--font-cinzel) !important;
  font-size: 0.58rem !important;
  font-weight: 600 !important;
  letter-spacing: 0.20em !important;
  text-transform: uppercase !important;
  color: var(--obsidian) !important;
  background: var(--gold) !important;
  border: 1px solid var(--gold) !important;
  padding: 10px 22px !important;
  white-space: nowrap !important;
  transition: background 0.32s ease, color 0.32s ease, border-color 0.32s ease !important;
  flex-shrink: 0;
}
.nav-cta:hover {
  background: transparent !important;
  color: var(--gold) !important;
  border-color: var(--gold-border-str) !important;
}
.nav-cta::after { display: none !important; }


/* ── Hamburger — hidden on desktop ── */
.nav-hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  cursor: pointer;
  background: none;
  border: none;
  padding: 6px;
  z-index: 910;
}
.nav-hamburger span {
  display: block;
  width: 26px;
  height: 2px;
  background: var(--gold);
  border-radius: 1px;
  transition: transform 0.28s ease, opacity 0.28s ease, background 0.28s ease;
  transform-origin: center;
}
.nav-hamburger[aria-expanded="true"] span:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
.nav-hamburger[aria-expanded="true"] span:nth-child(2) {
  opacity: 0;
  transform: scaleX(0);
}
.nav-hamburger[aria-expanded="true"] span:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}


/* ── Mobile Nav Drawer ── */
.nav-mobile {
  display: none;           /* hidden by default — JS adds .is-open */
  position: fixed;
  top: var(--nav-height);
  left: 0; right: 0;
  background: rgba(8, 8, 12, 0.98);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border-bottom: 1px solid rgba(201,169,97,0.14);
  flex-direction: column;
  padding: 0;
  z-index: 899;
  overflow: hidden;
  max-height: 0;
  transition: max-height 0.40s var(--ease-silk);
}
.nav-mobile.is-open {
  display: flex;
  max-height: 600px;       /* tall enough for all links */
}
.nav-mobile a {
  font-family: var(--font-ui);
  font-size: 0.78rem;
  font-weight: 500;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--text-muted);
  padding: 18px 32px;       /* generous touch target */
  border-bottom: 1px solid rgba(201,169,97,0.07);
  transition: color 0.2s ease, background 0.2s ease, padding-left 0.2s ease;
}
.nav-mobile a:last-child {
  border-bottom: none;
}
.nav-mobile a:hover {
  color: var(--gold-light);
  background: rgba(201,169,97,0.04);
  padding-left: 40px;
}
/* Registry CTA in mobile nav */
.nav-mobile a[href*="registry"] {
  color: var(--gold);
  border-top: 1px solid rgba(201,169,97,0.14);
  margin-top: 4px;
}


/* ── Responsive breakpoints ── */
@media (max-width: 1200px) {
  .nav-links { gap: 22px; }
  .site-nav { padding: 0 36px; }
}
@media (max-width: 1024px) {
  .nav-links  { display: none; }
  .nav-cta    { display: none; }
  .nav-hamburger { display: flex; }
  .site-nav   { padding: 0 28px; }
}
@media (max-width: 600px) {
  .site-nav { padding: 0 20px; }
}




/* ═══════════════════════════════════════════════════════════════
   LAYOUT SYSTEM
   ═══════════════════════════════════════════════════════════════ */


.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 clamp(1.25rem, 5vw, 4rem);
  /* Prevent children from escaping on mobile */
  overflow-x: hidden;
}
.section-inner {
  max-width: 1320px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  /* Contain children — fixes backgrounds going infinite */
  overflow: hidden;
}
.section-inner-narrow { max-width: 960px;  margin: 0 auto; overflow: hidden; }
.section-inner-wide   { max-width: 1480px; margin: 0 auto; overflow: hidden; }


.lux-section    { position: relative; padding: 120px 90px; width: 100%; overflow: hidden; }
.lux-section-sm { padding: 80px 90px; overflow: hidden; }
.lux-section-lg { padding: 160px 90px; overflow: hidden; }
.section-block  { display: block; width: 100%; padding: 5rem 0; overflow: hidden; }


/* Grids */
.two-col        { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: start; }
.two-col-6040   { grid-template-columns: 60% 40%; }
.two-col-4060   { grid-template-columns: 40% 60%; }
.three-col      { display: grid; grid-template-columns: repeat(3, 1fr); gap: 44px; }
.four-col       { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; }
.five-col       { display: grid; grid-template-columns: repeat(5, 1fr); gap: 24px; }
.asym-grid-a    { display: grid; grid-template-columns: 58% 42%; gap: 64px; align-items: start; }
.asym-grid-b    { display: grid; grid-template-columns: 42% 58%; gap: 64px; align-items: start; }




/* ═══════════════════════════════════════════════════════════════
   SECTION CHROME
   ═══════════════════════════════════════════════════════════════ */


.section-label {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  margin-bottom: 1.75rem;
}
.label-line {
  flex: 1;
  height: 1px;
  background: rgba(201,169,97,0.28);
  display: block;
  min-width: 1rem;
}
.label-text {
  font-family: var(--font-ui);
  font-size: 0.72rem;
  font-weight: 500;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.75);
  white-space: nowrap;
  flex-shrink: 0;
}
.section-divider {
  width: 100%;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--gold-dim), transparent 30%);
}




/* ═══════════════════════════════════════════════════════════════
   BACKGROUNDS & PARALLAX
   ═══════════════════════════════════════════════════════════════ */


.bg-parallax { position: relative; }
.bg-parallax::before {
  content: '';
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  z-index: 0;
}
/* Disable fixed attachment on all touch/mobile — prevents infinite backgrounds */
@media (max-width: 1024px) {
  .bg-parallax::before {
    background-attachment: scroll;
    background-size: cover;
    background-position: center center;
  }
}
/* Also catch iOS specifically */
@supports (-webkit-touch-callout: none) {
  .bg-parallax::before {
    background-attachment: scroll;
  }
}


/* Named image assignments */
.bg-hero::before      { background-image: url('http://www.legaisee.com/Images/HeroLightsWide.png');       opacity: 0.22; }
.bg-dig::before       { background-image: url('http://www.legaisee.com/Images/DigWfloor1.png');           opacity: 0.18; }
.bg-library::before   { background-image: url('http://www.legaisee.com/Images/Library2Diamond.png');      opacity: 0.15; }
.bg-lapidary::before  { background-image: url('http://www.legaisee.com/Images/LapidaryVerticleBlue.png'); opacity: 0.16; }
.bg-atelier::before   { background-image: url('http://www.legaisee.com/Images/AtelierObsidian.png');      opacity: 0.20; }
.bg-case::before      { background-image: url('http://www.legaisee.com/Images/CaseMask2.png');            opacity: 0.18; }
.bg-intake::before    { background-image: url('http://www.legaisee.com/Images/Intake1.png');              opacity: 0.14; }
.bg-preform::before   { background-image: url('http://www.legaisee.com/Images/Preforming1.png');          opacity: 0.16; }
.bg-polish::before    { background-image: url('http://www.legaisee.com/Images/PolishCaseMask.png');       opacity: 0.18; }


.bg-parallax > * { position: relative; z-index: 1; }


/* Ambient vault backgrounds */
.bg-vault {
  background:
    radial-gradient(ellipse at 18% 28%, rgba(201,169,97,0.04) 0%, transparent 52%),
    radial-gradient(ellipse at 82% 72%, rgba(139,112,64,0.02) 0%, transparent 48%),
    var(--obsidian);
}
.bg-vault-mid {
  background:
    radial-gradient(ellipse at 50% 0%, rgba(201,169,97,0.03) 0%, transparent 50%),
    var(--obsidian-mid);
}




/* ═══════════════════════════════════════════════════════════════
   BUTTON SYSTEM
   ═══════════════════════════════════════════════════════════════ */


.btn {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  font-family: var(--font-cinzel);
  font-size: 0.65rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.20em;
  padding: 16px 40px;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.38s var(--ease-silk);
  text-decoration: none;
  white-space: nowrap;
}
.btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
  left: -60%; width: 40%;
  transition: left 0.60s var(--ease-silk);
  pointer-events: none;
}
.btn:hover::before { left: 130%; }


/* Gold-fill — primary action */
.btn-gold {
  background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, rgba(201,169,97,0.7) 100%);
  color: var(--obsidian);
  border: 1px solid transparent;
}
.btn-gold:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 36px rgba(201,169,97,0.28);
  color: var(--obsidian);
}


/* Outline — secondary */
.btn-outline-gold {
  background: transparent;
  color: var(--gold);
  border: 1px solid var(--gold-border-str);
}
.btn-outline-gold:hover {
  background: rgba(201,169,97,0.07);
  border-color: var(--gold);
  transform: translateY(-2px);
  color: var(--gold-light);
}


/* Legacy aliases */
.btn-primary   { @extend .btn-gold; }
.btn-secondary { @extend .btn-outline-gold; }


.btn-group {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-wrap: wrap;
}




/* ═══════════════════════════════════════════════════════════════
   CARD SYSTEM (Practitioner-calibrated: #141414 base)
   ═══════════════════════════════════════════════════════════════ */


/* Museum Card — signature border treatment */
.museum-card {
  background: var(--card);
  border: 1px solid var(--gold-border);
  padding: 48px 44px;
  position: relative;
  transition: border-color 0.40s var(--ease-silk), transform 0.40s var(--ease-silk), box-shadow 0.40s var(--ease-silk);
}
.museum-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
  opacity: 0.5;
}
.museum-card:hover {
  border-color: var(--gold-border-str);
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
}


/* Specimen Card */
.specimen-card {
  background: var(--card);
  border: 1px solid rgba(201,169,97,0.12);
  padding: 44px 40px;
  position: relative;
  transition: border-color 0.36s ease, transform 0.36s ease, box-shadow 0.36s ease;
}
.specimen-card:hover {
  border-color: var(--gold-border);
  transform: translateY(-3px);
  box-shadow: var(--shadow-card);
}


/* Phase Card */
.phase-card {
  background: var(--card);
  border-left: 2px solid var(--gold-dim);
  padding: 40px 36px 40px 48px;
  position: relative;
  overflow: hidden;
}
.phase-card .phase-ghost {
  position: absolute;
  top: -8px; right: 14px;
  font-family: var(--font-display);
  font-size: 5.5rem;
  font-weight: 700;
  color: rgba(201,169,97,0.04);
  line-height: 1;
  pointer-events: none;
  user-select: none;
}


/* Exhibit Card */
.exhibit-card {
  background: var(--card);
  border: 1px solid rgba(201,169,97,0.12);
  padding: 44px 40px;
  position: relative;
  overflow: hidden;
  transition: all 0.40s var(--ease-silk);
}
.exhibit-card:hover {
  border-color: var(--gold-border);
  transform: translateY(-3px);
  box-shadow: var(--shadow-card);
}


/* Speakeasy Frame — double-border prestige */
.speakeasy-frame {
  border: 1px solid rgba(201,169,97,0.14);
  position: relative;
  overflow: hidden;
}
.speakeasy-frame::before {
  content: '';
  position: absolute;
  top: 8px; left: 8px; right: 8px; bottom: 8px;
  border: 1px solid rgba(201,169,97,0.06);
  pointer-events: none;
}
.speakeasy-frame::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent 10%, var(--gold-dim) 50%, transparent 90%);
  opacity: 0.7;
}


/* Signal Block */
.signal-block {
  border-left: 3px solid var(--gold);
  padding: 26px 30px;
  background: rgba(201,169,97,0.04);
}
.signal-block .signal-label {
  font-family: var(--font-ui);
  font-size: 0.58rem;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  color: var(--gold-dim);
  margin-bottom: 10px;
}


/* Surface (generic) */
.card-surface {
  background: var(--card);
  border: 1px solid rgba(201,169,97,0.13);
  padding: clamp(1.75rem, 3vw, 2.75rem);
  position: relative;
  z-index: 2;
}
.card-surface--glass {
  background: rgba(20, 20, 20, 0.72);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);
  border: 1px solid rgba(201,169,97,0.18);
}


/* Record Card (Practitioner page style — globally available) */
.record-card {
  background: var(--card);
  border: 1px solid rgba(201,169,97,0.10);
  padding: 2rem;
}
.record-card--accented { border-top: 2px solid var(--gold); }
.record-card-label {
  font-family: var(--font-ui);
  font-size: 0.60rem;
  font-weight: 500;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 0.65rem;
}
.record-card-title {
  font-family: var(--font-display);
  font-size: clamp(0.82rem, 1.4vw, 1rem);
  font-weight: 400;
  color: var(--text-primary);
  line-height: 1.4;
  margin-bottom: 0.4rem;
}
.record-card-meta {
  font-family: var(--font-ui);
  font-size: 0.70rem;
  color: var(--text-muted);
  margin-bottom: 0.9rem;
}
.record-card-body {
  font-family: var(--font-ui);
  font-size: 0.90rem;
  color: var(--text-body);
  line-height: 1.80;
}


/* Proof Block */
.proof-block {
  border-left: 3px solid var(--gold);
  padding: 1.5rem 2rem;
  background: var(--gold-glow);
  margin: 2rem 0;
}
.proof-block-label {
  font-family: var(--font-ui);
  font-size: 0.60rem;
  font-weight: 500;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 0.5rem;
}
.proof-block-title {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 400;
  color: var(--text-primary);
  margin-bottom: 0.4rem;
}
.proof-block-body {
  font-family: var(--font-ui);
  font-size: 0.88rem;
  color: var(--text-body);
  line-height: 1.78;
}




/* ═══════════════════════════════════════════════════════════════
   PRACTITIONER PAGE COMPONENTS — NOW GLOBAL
   ═══════════════════════════════════════════════════════════════ */


/* Stat Strip — 4-col horizontal bar */
.stats-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  border-top: 1px solid var(--gold-dim);
  border-bottom: 1px solid var(--gold-dim);
}
.stat-cell {
  padding: 2.5rem 1.5rem;
  text-align: center;
  border-right: 1px solid var(--gold-dim);
}
.stat-cell:last-child { border-right: none; }
.stat-figure {
  font-family: var(--font-display);
  font-size: clamp(1.7rem, 3.5vw, 2.6rem);
  font-weight: 400;
  color: var(--gold);
  display: block;
  line-height: 1;
  margin-bottom: 0.5rem;
}
.stat-label {
  font-family: var(--font-ui);
  font-size: 0.62rem;
  font-weight: 500;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--text-muted);
}


/* Era Headers */
.era-header { margin-bottom: 4rem; }
.era-title {
  font-family: var(--font-display);
  font-size: clamp(1.3rem, 2.8vw, 2rem);
  font-weight: 400;
  color: var(--text-primary);
  line-height: 1.2;
  margin-bottom: 0.5rem;
}
.era-subtitle {
  font-family: var(--font-ui);
  font-size: 0.72rem;
  font-weight: 500;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--text-muted);
}


/* Timeline */
.timeline { position: relative; padding-left: 2rem; }
.timeline::before {
  content: '';
  position: absolute;
  left: 0; top: 0.6rem; bottom: 0;
  width: 1px;
  background: var(--gold-dim);
}
.timeline-item { position: relative; padding-bottom: 2.25rem; }
.timeline-item::before {
  content: '';
  position: absolute;
  left: -2.3rem; top: 0.5rem;
  width: 7px; height: 7px;
  background: var(--gold);
  border-radius: 50%;
}
.timeline-year {
  font-family: var(--font-ui);
  font-size: 0.63rem;
  font-weight: 500;
  letter-spacing: 0.18em;
  color: var(--gold);
  margin-bottom: 0.22rem;
}
.timeline-body {
  font-family: var(--font-ui);
  font-size: 0.88rem;
  color: var(--text-body);
  line-height: 1.75;
}
.timeline-org { font-weight: 500; color: var(--text-primary); }


/* Pull Quote */
.pull-quote {
  text-align: center;
  padding: 5rem 0;
  max-width: 780px;
  margin: 0 auto;
}
.pull-quote__mark {
  font-family: var(--font-display);
  font-size: 4rem;
  color: var(--gold-dim);
  line-height: 0.5;
  margin-bottom: 1.5rem;
  display: block;
}
.pull-quote__text {
  font-family: var(--font-display);
  font-size: clamp(1rem, 2.3vw, 1.5rem);
  font-weight: 400;
  color: var(--text-primary);
  line-height: 1.5;
  font-style: italic;
}
.pull-quote__rule {
  width: 48px; height: 1px;
  background: var(--gold);
  margin: 2rem auto 0;
}


/* Field Note */
.field-note {
  background: rgba(201,169,97,0.03);
  border: 1px solid rgba(201,169,97,0.12);
  padding: 1.5rem 2rem;
  margin-top: 2rem;
}
.field-note-label {
  font-family: var(--font-ui);
  font-size: 0.58rem;
  font-weight: 500;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--text-muted);
  margin-bottom: 0.45rem;
}
.field-note-body {
  font-family: var(--font-ui);
  font-size: 0.84rem;
  color: var(--text-muted);
  font-style: italic;
  line-height: 1.7;
}




/* ═══════════════════════════════════════════════════════════════
   IMAGE & GEM SYSTEM
   ═══════════════════════════════════════════════════════════════ */


.image-frame {
  border: 1px solid var(--gold-border);
  padding: 10px;
  background: var(--card);
  position: relative;
  overflow: hidden;
}
.image-frame img {
  width: 100%;
  display: block;
  filter: saturate(0.78) contrast(1.05);
  transition: filter 0.55s ease, transform 0.65s var(--ease-silk);
}
.image-frame:hover img {
  filter: saturate(0.95) contrast(1.05);
  transform: scale(1.04);
}


.gem-frame {
  position: relative;
  overflow: hidden;
  border: 1px solid var(--gold-border);
  background: var(--card);
}
.gem-frame img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  filter: saturate(0.68) contrast(1.08);
  transition: filter 0.65s ease, transform 0.75s var(--ease-silk);
}
.gem-frame:hover img {
  filter: saturate(0.90) contrast(1.06);
  transform: scale(1.04);
}


.gem-placeholder-box {
  background: linear-gradient(135deg, var(--charcoal) 0%, var(--card) 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 10px;
  min-height: 320px;
  border: 1px solid var(--gold-border);
  position: relative;
}
.gem-placeholder-box::before {
  content: '';
  position: absolute;
  inset: 12px;
  border: 1px solid rgba(201,169,97,0.07);
  pointer-events: none;
}
.gem-catalog {
  position: absolute;
  top: 14px; left: 14px;
  font-family: var(--font-ui);
  font-size: 0.53rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--gold-dim);
  background: rgba(5,5,5,0.75);
  padding: 4px 10px;
  border: 1px solid rgba(201,169,97,0.18);
}
.gem-stage-name {
  font-family: var(--font-cinzel);
  font-size: 0.88rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--pewter);
}
.gem-stage-desc {
  font-family: var(--font-body);
  font-size: 0.84rem;
  color: var(--pewter);
  font-style: italic;
  text-align: center;
  max-width: 240px;
}
.gem-caption-bar {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 18px 20px;
  background: linear-gradient(to top, rgba(5,5,5,0.96) 0%, rgba(5,5,5,0.4) 70%, transparent 100%);
}
.gem-caption-title {
  font-family: var(--font-cinzel);
  font-size: 0.72rem;
  color: var(--gold-light);
  letter-spacing: 0.10em;
  text-transform: uppercase;
  margin-bottom: 3px;
}
.gem-caption-sub {
  font-family: var(--font-body);
  font-size: 0.80rem;
  color: var(--pewter);
  font-style: italic;
}


/* Gemstone Journey Grid */
.gem-journey-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 0;
  border: 1px solid rgba(201,169,97,0.10);
}
.gem-journey-card {
  position: relative;
  border-right: 1px solid rgba(201,169,97,0.08);
  overflow: hidden;
  transition: all 0.55s var(--ease-silk);
}
.gem-journey-card:last-child { border-right: none; }
.gem-journey-card:hover { z-index: 2; }
.gem-journey-img {
  width: 100%; aspect-ratio: 2/3;
  object-fit: cover;
  display: block;
  filter: saturate(0.4) contrast(1.15) brightness(0.7);
  transition: filter 0.65s ease, transform 0.75s var(--ease-silk);
}
.gem-journey-card:hover .gem-journey-img {
  filter: saturate(0.75) contrast(1.1) brightness(0.85);
  transform: scale(1.05);
}
.gem-journey-overlay {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 22px 18px 18px;
  background: linear-gradient(to top, rgba(5,5,5,0.98) 0%, rgba(5,5,5,0.65) 55%, transparent 100%);
}
.gem-journey-number {
  font-family: var(--font-ui);
  font-size: 0.52rem;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  color: var(--gold-dim);
  margin-bottom: 5px;
}
.gem-journey-stage {
  font-family: var(--font-cinzel);
  font-size: 0.80rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 5px;
}
.gem-journey-desc {
  font-family: var(--font-body);
  font-size: 0.78rem;
  color: var(--pewter);
  font-style: italic;
  line-height: 1.55;
}




/* ═══════════════════════════════════════════════════════════════
   STATS & AUTHORITY STRIP
   ═══════════════════════════════════════════════════════════════ */


.authority-strip {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  background: var(--charcoal);
  border-top: 1px solid rgba(201,169,97,0.10);
  border-bottom: 1px solid rgba(201,169,97,0.10);
}
.authority-item {
  padding: 38px 24px;
  text-align: center;
  border-right: 1px solid rgba(201,169,97,0.07);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 9px;
  transition: background 0.3s ease;
}
.authority-item:last-child { border-right: none; }
.authority-item:hover { background: rgba(201,169,97,0.025); }
.authority-value {
  font-family: var(--font-display);
  font-size: clamp(1.6rem, 2.8vw, 2.6rem);
  color: var(--gold);
  line-height: 1;
}
.authority-label {
  font-family: var(--font-ui);
  font-size: 0.56rem;
  font-weight: 500;
  letter-spacing: 0.20em;
  text-transform: uppercase;
  color: var(--pewter);
}




/* ═══════════════════════════════════════════════════════════════
   FEATURE LISTS & BADGES
   ═══════════════════════════════════════════════════════════════ */


.feature-list { list-style: none; }
.feature-list li {
  position: relative;
  padding-left: 26px;
  margin-bottom: 14px;
  font-family: var(--font-body);
  font-size: 1.02rem;
  color: var(--silver);
  line-height: 1.7;
}
.feature-list li::before {
  content: '◆';
  position: absolute;
  left: 0; top: 2px;
  color: var(--gold-dim);
  font-size: 0.58rem;
}


.badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(201,169,97,0.06);
  border: 1px solid var(--gold-border);
  padding: 5px 14px;
  font-family: var(--font-ui);
  font-size: 0.58rem;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--gold);
}


/* Credential Pill (Practitioner hero) */
.credential-pill {
  font-family: var(--font-ui);
  font-size: 0.63rem;
  font-weight: 500;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--text-muted);
  border: 1px solid rgba(201,169,97,0.20);
  padding: 0.4rem 0.9rem;
}


/* Truth Tier */
.truth-tier {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-ui);
  font-size: 0.56rem;
  font-weight: 600;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  padding: 5px 12px;
  border: 1px solid;
}
.tier-1 { color: var(--gold);   border-color: var(--gold-dim);    background: rgba(201,169,97,0.05); }
.tier-2 { color: var(--silver); border-color: var(--pewter); }
.tier-3 { color: var(--pewter); border-color: var(--graphite); }
.tier-4 { color: #4a4a4a;       border-color: var(--graphite); }




/* ═══════════════════════════════════════════════════════════════
   CTA BOXES & GATE SEAL
   ═══════════════════════════════════════════════════════════════ */


.cta-box {
  padding: 90px 70px;
  text-align: center;
  background: linear-gradient(145deg, var(--charcoal) 0%, var(--obsidian) 100%);
  border: 1px solid rgba(201,169,97,0.14);
  position: relative;
  overflow: hidden;
}
.cta-box::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
}


.gate-seal {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  border: 1px solid var(--gold-border);
  padding: 26px 48px;
  margin-top: 44px;
}
.gate-seal .seal-line {
  font-family: var(--font-ui);
  font-size: 0.60rem;
  letter-spacing: 0.36em;
  text-transform: uppercase;
  color: var(--gold-dim);
}
.gate-seal .seal-line:first-child { color: var(--gold); }




/* ═══════════════════════════════════════════════════════════════
   TICKER
   ═══════════════════════════════════════════════════════════════ */


@keyframes ticker-scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.ticker-wrap {
  overflow: hidden;
  border-top: 1px solid rgba(201,169,97,0.08);
  border-bottom: 1px solid rgba(201,169,97,0.08);
  padding: 16px 0;
  background: var(--charcoal);
}
.ticker-track {
  display: flex;
  white-space: nowrap;
  animation: ticker-scroll 44s linear infinite;
}
.ticker-track:hover { animation-play-state: paused; }
.ticker-item {
  display: inline-flex;
  align-items: center;
  gap: 26px;
  padding: 0 46px;
  font-family: var(--font-cinzel);
  font-size: 0.66rem;
  text-transform: uppercase;
  letter-spacing: 0.22em;
  color: var(--pewter);
}
.ticker-dot {
  width: 4px; height: 4px;
  background: var(--gold);
  border-radius: 50%;
  flex-shrink: 0;
  opacity: 0.6;
}
.ticker-gold { color: var(--gold); }




/* ═══════════════════════════════════════════════════════════════
   GEOGRAPHY STRIP
   ═══════════════════════════════════════════════════════════════ */


.geography-strip {
  background: var(--charcoal);
  border-top: 1px solid rgba(201,169,97,0.08);
  border-bottom: 1px solid rgba(201,169,97,0.08);
  padding: 48px 90px;
}
.geography-inner {
  max-width: 1320px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 56px;
}
.geography-label {
  font-family: var(--font-ui);
  font-size: 0.56rem;
  letter-spacing: 0.28em;
  text-transform: uppercase;
  color: var(--gold-dim);
  white-space: nowrap;
  flex-shrink: 0;
}
.geography-divider {
  flex: 0 0 1px;
  height: 36px;
  background: rgba(201,169,97,0.16);
}
.geography-text {
  font-family: var(--font-cinzel);
  font-size: clamp(0.95rem, 1.5vw, 1.2rem);
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--platinum);
}
.geography-text em {
  font-family: var(--font-body);
  font-style: italic;
  font-size: 0.88em;
  color: var(--pewter);
  text-transform: none;
  letter-spacing: 0;
  display: block;
  margin-top: 4px;
}




/* ═══════════════════════════════════════════════════════════════
   FORMS
   ═══════════════════════════════════════════════════════════════ */


.registry-form { max-width: 640px; }
.registry-form input,
.registry-form textarea,
.registry-form select {
  width: 100%;
  background: var(--obsidian);
  border: 1px solid var(--graphite);
  color: var(--platinum);
  font-family: var(--font-ui);
  font-size: 0.95rem;
  padding: 16px 20px;
  margin-bottom: 18px;
  outline: none;
  transition: border-color 0.3s ease;
}
.registry-form input:focus,
.registry-form textarea:focus { border-color: var(--gold-dim); }
.registry-form input::placeholder,
.registry-form textarea::placeholder { color: var(--pewter); font-style: italic; }




/* ═══════════════════════════════════════════════════════════════
   FOOTER
   ═══════════════════════════════════════════════════════════════ */


.site-footer {
  background: var(--charcoal);
  border-top: 1px solid rgba(201,169,97,0.10);
  padding: 90px 90px 60px;
}
.footer-grid {
  display: grid;
  grid-template-columns: 1.8fr 1fr 1fr 1fr;
  gap: 70px;
  margin-bottom: 70px;
  max-width: 1320px;
  margin-left: auto;
  margin-right: auto;
}
.footer-brand-tagline {
  font-family: var(--font-body);
  font-size: 1rem;
  color: var(--pewter);
  line-height: 1.75;
  margin: 18px 0 24px;
  font-style: italic;
}
.footer-col-title {
  font-family: var(--font-ui);
  font-size: 0.58rem;
  font-weight: 600;
  letter-spacing: 0.26em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 22px;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 11px; }
.footer-links a {
  font-family: var(--font-ui);
  font-size: 0.78rem;
  color: var(--pewter);
  transition: color 0.24s ease;
}
.footer-links a:hover { color: var(--gold-light); }
.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 32px;
  border-top: 1px solid rgba(255,255,255,0.04);
  max-width: 1320px;
  margin: 0 auto;
}
.footer-copy {
  font-family: var(--font-ui);
  font-size: 0.66rem;
  color: rgba(168,168,168,0.42);
  letter-spacing: 0.06em;
}
.footer-seal {
  font-family: var(--font-cinzel);
  font-size: 0.68rem;
  letter-spacing: 0.20em;
  text-transform: uppercase;
  color: var(--gold-dim);
  opacity: 0.6;
}




/* ═══════════════════════════════════════════════════════════════
   PATCH COMPONENTS (from patch CSS — now consolidated)
   Exhibit, Case Studies, FAQ, Archaeology, Serve, Registry
   ═══════════════════════════════════════════════════════════════ */


/* ── Exhibit System ── */
.exhibit-metrics-bar {
  display: flex; align-items: flex-start; gap: 0;
  margin-top: 4rem;
  border: 1px solid rgba(201,169,97,0.20);
}
.metric-cell { flex: 1; padding: 2rem 2.5rem; }
.metric-divider {
  width: 1px; align-self: stretch;
  background: rgba(201,169,97,0.20); flex-shrink: 0;
}
.metric-label {
  display: block;
  font-family: var(--font-cinzel);
  font-size: 0.68rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 0.75rem;
}
.metric-desc {
  font-family: var(--font-ui);
  font-size: 0.92rem;
  color: var(--text-body);
  line-height: 1.7;
}


.exhibit-card {
  background: var(--card);
  border: 1px solid rgba(201,169,97,0.18);
  padding: 2.5rem;
  display: flex; flex-direction: column; gap: 1.5rem;
  transition: border-color 0.3s ease, background 0.3s ease;
}
.exhibit-card:hover {
  border-color: rgba(201,169,97,0.40);
  background: rgba(201,169,97,0.03);
}
.exhibit-card--entry { border-color: rgba(201,169,97,0.35); }
.exhibit-card--flagship {
  border-color: rgba(201,169,97,0.50);
  background: rgba(201,169,97,0.04);
}
.exhibit-name {
  font-family: var(--font-cinzel);
  font-size: clamp(0.92rem, 1.4vw, 1.08rem);
  color: var(--gold);
  letter-spacing: 0.06em;
  margin: 0; line-height: 1.4;
}
.exhibit-label {
  font-family: var(--font-ui);
  font-size: 0.62rem;
  letter-spacing: 0.20em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.65);
}
.exhibit-price {
  font-family: var(--font-cinzel);
  font-size: clamp(1.3rem, 2.2vw, 1.7rem);
  color: var(--gold);
  letter-spacing: 0.04em;
}
.exhibit-price-note {
  font-family: var(--font-ui);
  font-size: 0.62rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: rgba(201,169,97,0.48);
}
.exhibit-desc {
  font-family: var(--font-ui);
  font-size: clamp(0.88rem, 1.3vw, 1rem);
  color: var(--text-body);
  line-height: 1.82;
}
.exhibit-deliverables { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
.exhibit-deliverables li {
  font-family: var(--font-ui);
  font-size: 0.72rem;
  letter-spacing: 0.08em;
  color: rgba(255,255,255,0.62);
  padding-left: 1.25rem; position: relative;
}
.exhibit-deliverables li::before {
  content: '';
  position: absolute; left: 0; top: 50%;
  transform: translateY(-50%) rotate(45deg);
  width: 5px; height: 5px;
  background: rgba(201,169,97,0.48);
}


/* ── Case Cards ── */
.case-card {
  border: 1px solid rgba(201,169,97,0.15);
  background: var(--card);
  display: flex; flex-direction: column;
  transition: border-color 0.3s ease;
}
.case-card:hover { border-color: rgba(201,169,97,0.35); }
.case-card__body { padding: 2rem; display: flex; flex-direction: column; gap: 1.25rem; flex: 1; }
.case-card__title {
  font-family: var(--font-cinzel);
  font-size: clamp(0.82rem, 1.3vw, 0.98rem);
  color: var(--gold); letter-spacing: 0.06em; margin: 0; line-height: 1.4;
}
.case-card__finding {
  font-family: var(--font-ui);
  font-size: clamp(0.86rem, 1.3vw, 0.96rem);
  color: var(--text-body); line-height: 1.82;
}
.case-card__outcome {
  padding: 1rem;
  background: rgba(201,169,97,0.05);
  border-left: 2px solid rgba(201,169,97,0.40);
}
.case-outcome-label {
  font-family: var(--font-ui);
  font-size: 0.58rem; letter-spacing: 0.18em;
  text-transform: uppercase; color: rgba(201,169,97,0.48); display: block;
}
.case-outcome-value {
  font-family: var(--font-cinzel);
  font-size: 0.74rem; color: var(--gold); letter-spacing: 0.06em; display: block;
}


/* ── FAQ ── */
.faq-item {
  border-bottom: 1px solid rgba(201,169,97,0.08);
  padding: 2.25rem 0;
}
.faq-item:first-child { border-top: 1px solid rgba(201,169,97,0.08); }
.faq-question {
  font-family: var(--font-cinzel);
  font-size: clamp(0.82rem, 1.3vw, 0.96rem);
  color: var(--text-primary); letter-spacing: 0.05em;
  margin: 0; line-height: 1.5;
}
.faq-answer {
  font-family: var(--font-ui);
  font-size: clamp(0.88rem, 1.4vw, 0.98rem);
  color: var(--text-body); line-height: 1.85;
  margin: 1rem 0 0; max-width: 780px;
}


/* ── Philosophy (Archaeology) ── */
.philosophy-block {
  display: grid;
  grid-template-columns: 3.5rem 1fr;
  gap: 0 2.5rem;
  padding: 2.75rem 0;
  border-bottom: 1px solid rgba(201,169,97,0.10);
}
.philosophy-block:first-child { border-top: 1px solid rgba(201,169,97,0.10); }
.philosophy-block__numeral {
  font-family: var(--font-cinzel);
  font-size: 0.68rem; letter-spacing: 0.15em;
  color: rgba(201,169,97,0.32); padding-top: 0.3rem; user-select: none;
}
.philosophy-block__heading {
  font-family: var(--font-cinzel);
  font-size: clamp(0.82rem, 1.3vw, 0.98rem);
  color: var(--text-primary); letter-spacing: 0.06em; margin: 0; line-height: 1.45;
}
.philosophy-block__body {
  font-family: var(--font-ui);
  font-size: clamp(0.88rem, 1.4vw, 0.98rem);
  color: var(--text-body); line-height: 1.85; max-width: 720px;
}


/* ── Serve Definitions ── */
.serve-definition-term {
  font-family: var(--font-cinzel);
  font-size: clamp(0.82rem, 1.3vw, 0.96rem);
  color: var(--gold); letter-spacing: 0.08em; margin: 0; line-height: 1.4;
}
.serve-definition-body {
  font-family: var(--font-ui);
  font-size: clamp(0.88rem, 1.4vw, 0.98rem);
  color: var(--text-body); line-height: 1.85; max-width: 740px;
}


/* ── Registry surfaces ── */
.surface-item {
  display: flex; gap: 1.25rem; align-items: flex-start;
  padding: 2rem;
  border: 1px solid rgba(201,169,97,0.15);
  background: rgba(201,169,97,0.025);
  transition: border-color 0.3s ease;
}
.surface-item:hover { border-color: rgba(201,169,97,0.35); }
.surface-item__gem {
  width: 8px; height: 8px;
  background: var(--gold);
  transform: rotate(45deg);
  flex-shrink: 0; margin-top: 0.5rem;
}
.surface-item__title {
  font-family: var(--font-cinzel);
  font-size: clamp(0.76rem, 1.1vw, 0.88rem);
  color: var(--gold); letter-spacing: 0.07em; margin: 0; line-height: 1.4;
}
.surface-item__body {
  font-family: var(--font-ui);
  font-size: clamp(0.84rem, 1.3vw, 0.92rem);
  color: var(--text-body); line-height: 1.8;
}


/* Registry terms bar */
.registry-terms-bar {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 1.5rem;
  padding: 2rem 2.5rem;
  border: 1px solid rgba(201,169,97,0.22);
  margin-top: 3rem;
}
.registry-term__label {
  font-family: var(--font-ui);
  font-size: 0.58rem; letter-spacing: 0.20em;
  text-transform: uppercase; color: rgba(201,169,97,0.48);
}
.registry-term__value {
  font-family: var(--font-body);
  font-size: 1.02rem; color: var(--gold); line-height: 1.3;
}
.registry-term-divider {
  width: 1px; height: 2.5rem;
  background: rgba(201,169,97,0.18); flex-shrink: 0;
}




/* ═══════════════════════════════════════════════════════════════
   SCROLL REVEAL ANIMATIONS
   ═══════════════════════════════════════════════════════════════ */


.reveal {
  opacity: 0;
  transform: translateY(32px);
  transition: opacity 0.90s var(--ease-silk), transform 0.90s var(--ease-silk);
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-left  { transform: translateX(-40px); opacity: 0; transition: opacity 0.90s var(--ease-silk), transform 0.90s var(--ease-silk); }
.reveal-right { transform: translateX(40px);  opacity: 0; transition: opacity 0.90s var(--ease-silk), transform 0.90s var(--ease-silk); }
.reveal-left.visible,
.reveal-right.visible { opacity: 1; transform: translateX(0); }


.reveal-d1 { transition-delay: 0.10s; }
.reveal-d2 { transition-delay: 0.20s; }
.reveal-d3 { transition-delay: 0.32s; }
.reveal-d4 { transition-delay: 0.44s; }
.reveal-d5 { transition-delay: 0.56s; }




/* ═══════════════════════════════════════════════════════════════
   TRACK LIGHTING
   ═══════════════════════════════════════════════════════════════ */


.section-lit { position: relative; overflow: hidden; }
.lighting-overlay {
  position: absolute; inset: 0;
  pointer-events: none; z-index: 1;
  background:
    radial-gradient(ellipse 55% 35% at 50% 0%, rgba(201,169,97,0.10) 0%, transparent 100%),
    radial-gradient(ellipse 35% 30% at 15% 100%, rgba(201,169,97,0.06) 0%, transparent 100%),
    radial-gradient(ellipse 28% 45% at 95% 55%, rgba(201,169,97,0.05) 0%, transparent 100%),
    radial-gradient(ellipse 40% 40% at 50% 50%, rgba(201,169,97,0.03) 0%, transparent 100%);
}
.section-lit > :not(.lighting-overlay) { position: relative; z-index: 2; }




/* ═══════════════════════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════════════════════ */


@media (max-width: 1200px) {
  .lux-section    { padding: 100px 60px; }
  .lux-section-sm { padding: 70px 60px; }
  .lux-section-lg { padding: 130px 60px; }
  .footer-grid    { grid-template-columns: 1fr 1fr; gap: 48px; }
  .authority-strip { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
  .two-col, .asym-grid-a, .asym-grid-b,
  .two-col-6040, .two-col-4060 { grid-template-columns: 1fr; gap: 40px; }
  .three-col { grid-template-columns: 1fr; gap: 28px; }
  .four-col  { grid-template-columns: repeat(2, 1fr); }
  .five-col  { grid-template-columns: repeat(2, 1fr); }
  .gem-journey-grid { grid-template-columns: repeat(3, 1fr); }
  .stats-strip { grid-template-columns: repeat(2, 1fr); }
  .stat-cell:nth-child(2) { border-right: none; }
  .stat-cell:nth-child(3) { border-top: 1px solid var(--gold-dim); }
  .geography-strip { padding: 40px 40px; }
  .geography-inner { gap: 36px; }
  .exhibit-metrics-bar { flex-direction: column; }
  .metric-divider { width: 100%; height: 1px; align-self: auto; }
  .philosophy-block,
  .serve-definition-item { grid-template-columns: 1fr; gap: 1rem 0; }
  .philosophy-block__numeral,
  .serve-definition-numeral { display: none; }
}
@media (max-width: 768px) {
  /* ── Base font up on mobile — everything readable ── */
  html { font-size: 16px; }


  /* ── Section padding ── */
  .lux-section    { padding: 64px 20px; }
  .lux-section-sm { padding: 48px 20px; }
  .lux-section-lg { padding: 80px 20px; }
  .section-block  { padding: 2.5rem 0; }


  /* ── Overflow hard-stop ── */
  section, .lux-section, .section-block,
  .section-inner, .container, .lux-section-sm, .lux-section-lg {
    overflow-x: hidden;
    max-width: 100%;
    box-sizing: border-box;
  }


  /* ── Typography bumps — all small labels come up ── */
  .eyebrow, .label-text       { font-size: 0.76rem; letter-spacing: 0.20em; }
  .prestige-label             { font-size: 0.76rem; letter-spacing: 0.20em; }
  .micro-label                { font-size: 0.72rem; letter-spacing: 0.18em; }
  .seal-line                  { font-size: 0.68rem; letter-spacing: 0.22em; }
  .authority-label            { font-size: 0.64rem; }
  .footer-col-title           { font-size: 0.68rem; }
  h4, h5, h6                  { font-size: 0.80rem; }


  /* ── Body text ── */
  p, .b-xl, .b-lg, .b-md {
    font-size: 1rem;
    line-height: 1.80;
  }


  /* ── Grids collapse ── */
  .four-col       { grid-template-columns: 1fr; }
  .five-col       { grid-template-columns: 1fr; }
  .gem-journey-grid { grid-template-columns: 1fr; }
  .authority-strip  { grid-template-columns: repeat(2, 1fr); }
  .footer-grid    { grid-template-columns: 1fr; gap: 36px; }
  .footer-bottom  { flex-direction: column; gap: 14px; text-align: center; }
  .cta-box        { padding: 48px 20px; }
  .gate-seal      { padding: 18px 24px; margin-top: 32px; }
  .geography-strip { padding: 32px 20px; }
  .geography-inner { flex-direction: column; gap: 16px; }
  .geography-divider { display: none; }
  .site-footer    { padding: 56px 20px 40px; }
  .registry-term-divider { display: none; }
  .registry-terms-bar { flex-direction: column; align-items: flex-start; padding: 1.5rem; }
  .stats-strip { grid-template-columns: repeat(2, 1fr); }


  /* ── Cards ── */
  .museum-card,
  .specimen-card  { padding: 28px 20px; }
  .exhibit-card   { padding: 24px 20px; }
  .phase-card     { padding: 28px 20px 28px 28px; }
  .signal-block   { padding: 20px 22px; }
  .proof-block    { padding: 1.25rem 1.5rem; }
  .field-note     { padding: 1.25rem 1.5rem; }
  .metric-cell    { padding: 1.5rem 1.5rem; }


  /* ── Feature list readable ── */
  .feature-list li { font-size: 0.95rem; line-height: 1.72; }
  .timeline-body  { font-size: 0.92rem; }
  .record-card-body { font-size: 0.92rem; }
  .faq-answer     { font-size: 0.94rem; }
  .exhibit-desc   { font-size: 0.94rem; }


  /* ── Buttons stack better ── */
  .btn-group      { gap: 12px; }
  .btn            { padding: 15px 28px; font-size: 0.65rem; }


  /* ── Authority strip ── */
  .authority-item { padding: 28px 16px; }
  .authority-value { font-size: clamp(1.4rem, 5vw, 2rem); }


  /* ── Pull quote ── */
  .pull-quote { padding: 2.5rem 0; }
  .pull-quote__text { font-size: clamp(1rem, 4.5vw, 1.3rem); }


  /* ── Nav ── */
  .site-nav { padding: 0 20px; }
}


@media (max-width: 480px) {
  html { font-size: 15px; }


  /* Hard viewport lock */
  *, *::before, *::after { max-width: 100%; }
  body { width: 100vw; overflow-x: hidden; }


  /* Scale display type */
  .d-xl { font-size: clamp(1.7rem, 8vw, 2.4rem); line-height: 1.12; }
  .d-lg { font-size: clamp(1.35rem, 6.5vw, 1.8rem); line-height: 1.18; }
  .d-md { font-size: clamp(1.1rem, 5vw, 1.4rem); }


  /* Body text comfortable minimum */
  p, .b-xl, .b-lg, .b-md { font-size: 1rem; }


  /* Labels readable */
  .eyebrow, .label-text, .prestige-label { font-size: 0.70rem; }


  /* Sections */
  .lux-section    { padding: 52px 18px; }
  .lux-section-sm { padding: 40px 18px; }
  .lux-section-lg { padding: 64px 18px; }
  .gem-journey-grid { grid-template-columns: 1fr; }


  /* Buttons full-width stack */
  .btn-group { flex-direction: column; align-items: stretch; }
  .btn       { width: 100%; justify-content: center; padding: 16px 20px; }


  /* Gate seal compact */
  .gate-seal { padding: 16px 20px; }
  .seal-line { font-size: 0.64rem; letter-spacing: 0.18em; }
}


/* ═══════════════════════════════════════════════════════════════
   MOBILE SECTION BREAKS & FILIGREE ACCENT SYSTEM
   Addresses monotony on small screens — section color variation,
   gold full-width dividers, decorative filigree separators.
   ═══════════════════════════════════════════════════════════════ */


/* ── Full-width gold section divider — drop between any two sections ── */
.gold-section-rule {
  width: 100%;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(201,169,97,0.12) 10%,
    rgba(201,169,97,0.55) 35%,
    rgba(201,169,97,0.80) 50%,
    rgba(201,169,97,0.55) 65%,
    rgba(201,169,97,0.12) 90%,
    transparent 100%
  );
  display: block;
  flex-shrink: 0;
}
/* Thicker variant — more presence */
.gold-section-rule--heavy {
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    var(--gold-dim) 15%,
    var(--gold) 40%,
    var(--gold-bright) 50%,
    var(--gold) 60%,
    var(--gold-dim) 85%,
    transparent 100%
  );
  box-shadow: 0 0 12px rgba(201,169,97,0.18);
}


/* ── Filigree section separator — ornamental, used between major sections ── */
.filigree-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  width: 100%;
  padding: 12px 0;
  position: relative;
  overflow: hidden;
}
.filigree-rule::before,
.filigree-rule::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(201,169,97,0.45));
}
.filigree-rule::after {
  background: linear-gradient(to left, transparent, rgba(201,169,97,0.45));
}
.filigree-rule__inner {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 20px;
  flex-shrink: 0;
  color: rgba(201,169,97,0.55);
  font-size: 0.60rem;
  letter-spacing: 0.10em;
}
/* The ornamental diamond-cross pattern */
.filigree-rule__inner::before {
  content: '◆ ◇ ◆';
  font-size: 0.48rem;
  letter-spacing: 0.18em;
  color: rgba(201,169,97,0.45);
}


/* ── Filigree accent mark — small standalone gem ornament ── */
.filigree-mark {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  color: rgba(201,169,97,0.38);
  margin: 0 auto;
  font-size: 0.42rem;
  letter-spacing: 0.14em;
  user-select: none;
}
.filigree-mark::before { content: '◆ ◇ ◆ ◇ ◆'; }


/* ── Section color alternation classes — apply to lux-section / section-block ── */
/* Slightly lighter panel — breaks monotony of pure obsidian runs */
.section-alt-1 {
  background: var(--obsidian-light);
}
/* Charcoal panel — Practitioner warmth */
.section-alt-2 {
  background: var(--charcoal);
}
/* Subtle gold-tinted surface */
.section-alt-gold {
  background: linear-gradient(180deg,
    var(--obsidian) 0%,
    rgba(201,169,97,0.03) 40%,
    rgba(201,169,97,0.03) 60%,
    var(--obsidian) 100%
  );
}


/* ── Section-top accent bar — 2px gold rule at top of a section ── */
.section-top-rule {
  position: relative;
}
.section-top-rule::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(201,169,97,0.18) 15%,
    rgba(201,169,97,0.60) 50%,
    rgba(201,169,97,0.18) 85%,
    transparent 100%
  );
  z-index: 3;
}


/* ── Photo placeholder variants — additional sizes for site variety ── */
/* Wide cinematic — 16:5 ratio */
.gem-placeholder-box--cinema {
  aspect-ratio: 16 / 5;
  min-height: auto;
}
/* Square */
.gem-placeholder-box--square {
  aspect-ratio: 1 / 1;
  min-height: auto;
}
/* Portrait tall */
.gem-placeholder-box--portrait {
  aspect-ratio: 3 / 4;
  min-height: auto;
}
/* Landscape standard */
.gem-placeholder-box--landscape {
  aspect-ratio: 16 / 9;
  min-height: auto;
}
/* Banner — full-width short */
.gem-placeholder-box--banner {
  aspect-ratio: 3 / 1;
  min-height: auto;
}


/* ── Mobile-specific section break enforcement ── */
@media (max-width: 768px) {
  /* Auto-insert subtle top rule on every major section after the first */
  .lux-section + .lux-section::before,
  .lux-section + .section-block::before,
  .section-block + .lux-section::before {
    content: '';
    position: absolute;
    top: 0; left: 5%; right: 5%;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(201,169,97,0.30), transparent);
    z-index: 3;
  }


  /* Gold rule gets more visible on small screens */
  .gold-section-rule {
    background: linear-gradient(90deg,
      transparent 0%,
      rgba(201,169,97,0.20) 5%,
      rgba(201,169,97,0.65) 30%,
      rgba(201,169,97,0.85) 50%,
      rgba(201,169,97,0.65) 70%,
      rgba(201,169,97,0.20) 95%,
      transparent 100%
    );
  }


  /* Filigree rule scales on mobile */
  .filigree-rule__inner { padding: 0 14px; }
  .filigree-rule__inner::before { font-size: 0.46rem; }


  /* Placeholder boxes never overflow */
  .gem-placeholder-box,
  .gem-placeholder-box--cinema,
  .gem-placeholder-box--portrait,
  .gem-placeholder-box--landscape,
  .gem-placeholder-box--banner,
  .gem-placeholder-box--square {
    max-width: 100%;
    width: 100%;
  }
}

