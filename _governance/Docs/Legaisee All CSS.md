<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE Business Archaeology — Forensic excavation of institutional memory. Narrative Drift, The Lindy Effect, and the restoration of what once made you unmistakable.">
  <title>The Archaeology — LEGAiSEE</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="site-bg-fix.css" />
    
  
  <style>
    /* ── PAGE-SPECIFIC: ARCHAEOLOGY.HTML ─────────────────────────── */

    /* PAGE HERO — Dig site with vertical light */
    .arch-hero {
      position: relative;
      min-height: 88vh;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 60px;
      padding: 0 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .arch-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/DigWfloor1.png');
      background-size: cover;
      background-position: center 30%;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.22;
      z-index: 0;
    }
    .arch-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to bottom, rgba(5,5,5,0.75) 0%, rgba(5,5,5,0.3) 40%, rgba(5,5,5,0.85) 100%),
        linear-gradient(to right, rgba(5,5,5,0.6) 0%, transparent 60%);
      z-index: 1;
      pointer-events: none;
    }
    .arch-hero-content {
      position: relative;
      z-index: 2;
      max-width: 780px;
    }
    .arch-hero-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.40em;
      text-transform: uppercase;
      color: var(--gold-dim);
      display: block;
      margin-bottom: 32px;
      padding-top: 120px;
    }

    /* DRIFT DIAGRAM — Visual representation of narrative drift */
    .drift-diagram {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
      margin: 64px 0;
    }
    .drift-row {
      display: grid;
      grid-template-columns: 120px 1fr 120px;
      align-items: stretch;
      border-bottom: 1px solid rgba(201,169,97,0.07);
    }
    .drift-row:last-child { border-bottom: none; }
    .drift-era {
      padding: 28px 24px;
      background: rgba(201,169,97,0.04);
      border-right: 1px solid rgba(201,169,97,0.08);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.20em;
      text-transform: uppercase;
      color: var(--gold-dim);
      text-align: center;
    }
    .drift-event {
      padding: 28px 40px;
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.70;
      display: flex;
      align-items: center;
    }
    .drift-signal {
      padding: 28px 24px;
      border-left: 1px solid rgba(201,169,97,0.08);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      text-align: center;
    }
    .drift-signal.strong { color: var(--gold); }
    .drift-signal.fading { color: var(--pewter); }
    .drift-signal.lost   { color: rgba(106,106,106,0.4); }

    /* LINDY EFFECT — Two-part visual proof */
    .lindy-proof {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2px;
      background: rgba(201,169,97,0.05);
      border: 1px solid rgba(201,169,97,0.10);
      margin: 48px 0;
    }
    .lindy-cell {
      padding: 52px 48px;
      background: var(--obsidian-light);
      position: relative;
      overflow: hidden;
    }
    .lindy-cell::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .lindy-cell.truth::before  { background: var(--gold); }
    .lindy-cell.modern::before { background: var(--graphite); }
    .lindy-cell:hover::before  { opacity: 1; }
    .lindy-cell-label {
      font-family: var(--font-ui);
      font-size: 0.58rem;
      font-weight: 600;
      letter-spacing: 0.26em;
      text-transform: uppercase;
      margin-bottom: 20px;
      display: block;
    }
    .lindy-cell.truth  .lindy-cell-label { color: var(--gold); }
    .lindy-cell.modern .lindy-cell-label { color: var(--pewter); }
    .lindy-cell-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.6vw, 1.3rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 18px;
    }
    .lindy-cell.truth  .lindy-cell-title { color: var(--platinum); }
    .lindy-cell.modern .lindy-cell-title { color: var(--pewter); }

    /* COST LEDGER — Revenue leak visual */
    .cost-ledger {
      background: var(--obsidian-mid);
      border: 1px solid rgba(201,169,97,0.12);
      overflow: hidden;
    }
    .ledger-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 40px;
      background: rgba(201,169,97,0.04);
      border-bottom: 1px solid rgba(201,169,97,0.10);
      font-family: var(--font-ui);
      font-size: 0.55rem;
      font-weight: 600;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold-dim);
    }
    .ledger-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 32px;
      padding: 22px 40px;
      border-bottom: 1px solid rgba(255,255,255,0.03);
      align-items: center;
      transition: background 0.3s ease;
    }
    .ledger-row:last-child { border-bottom: none; }
    .ledger-row:hover { background: rgba(201,169,97,0.02); }
    .ledger-item {
      font-family: var(--font-ui);
      font-size: 1.02rem;
      color: var(--silver);
      line-height: 1.6;
    }
    .ledger-cost {
      font-family: var(--font-display);
      font-size: 0.82rem;
      letter-spacing: 0.10em;
      text-transform: uppercase;
      white-space: nowrap;
    }
    .ledger-cost.high   { color: rgba(201,169,97,0.4); }
    .ledger-cost.medium { color: rgba(201,169,97,0.25); }

    /* EXCAVATION STAGES — Horizontal timeline */
    .excavation-timeline {
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 0;
    }
    .excavation-timeline::before {
      content: '';
      position: absolute;
      left: 28px; top: 0; bottom: 0;
      width: 1px;
      background: linear-gradient(to bottom, var(--gold), rgba(201,169,97,0.08));
    }
    .excavation-step {
      display: grid;
      grid-template-columns: 56px 1fr;
      gap: 40px;
      padding: 40px 0;
      border-bottom: 1px solid rgba(255,255,255,0.03);
      align-items: start;
    }
    .excavation-step:last-child { border-bottom: none; }
    .excavation-node {
      width: 56px; height: 56px;
      border-radius: 50%;
      background: var(--obsidian-mid);
      border: 1px solid rgba(201,169,97,0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--font-display);
      font-size: 0.78rem;
      color: var(--gold);
      letter-spacing: 0.05em;
      flex-shrink: 0;
      position: relative;
      z-index: 1;
      transition: all 0.4s ease;
    }
    .excavation-step:hover .excavation-node {
      background: rgba(201,169,97,0.08);
      border-color: var(--gold);
      box-shadow: 0 0 20px rgba(201,169,97,0.10);
    }
    .excavation-body {}
    .excavation-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 12px;
    }
    .excavation-desc {
      font-family: var(--font-ui);
      font-size: 1.02rem;
      color: var(--silver);
      line-height: 1.75;
    }
    .excavation-gem {
      margin-top: 16px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }
    .excavation-gem-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--gold-dim);
      flex-shrink: 0;
    }
    .excavation-gem-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--gold-dim);
    }

    /* GOLDEN ERA FRAME */
    .golden-era-frame {
      background: linear-gradient(135deg, var(--charcoal) 0%, var(--obsidian-mid) 100%);
      border: 1px solid rgba(201,169,97,0.15);
      padding: 72px 80px;
      position: relative;
      overflow: hidden;
    }
    .golden-era-frame::before {
      content: 'GOLDEN ERA';
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%) rotate(-8deg);
      font-family: var(--font-display);
      font-size: 8vw;
      font-weight: 700;
      color: rgba(201,169,97,0.025);
      white-space: nowrap;
      pointer-events: none;
      user-select: none;
      letter-spacing: 0.12em;
    }
    .golden-era-frame::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
      opacity: 0.6;
    }

    /* PULL QUOTE — Large italic editorial */
    .pull-quote {
      font-family: var(--font-ui);
      font-size: clamp(1.4rem, 2.8vw, 2.2rem);
      font-style: italic;
      color: var(--platinum);
      line-height: 1.62;
      padding: 52px 0;
      border-top: 1px solid rgba(201,169,97,0.12);
      border-bottom: 1px solid rgba(201,169,97,0.12);
      margin: 60px 0;
      text-align: center;
    }
    .pull-quote em { color: var(--gold); font-style: normal; }

    /* ARCHAEOLOGY CTA section bg */
    .arch-cta-section {
      position: relative;
      overflow: hidden;
    }
    .arch-cta-section::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/LibraryMain.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.12;
      z-index: 0;
    }
    .arch-cta-section > * { position: relative; z-index: 1; }
/* ── CSS to add to archaeology.html <style> block ── */
  .excavation-discovery-link {
    display: block;
    margin-top: 44px;
    padding-top: 24px;
    border-top: 1px solid rgba(201,169,97,0.06);
    font-family: var(--font-ui);
    font-size: 0.56rem;
    letter-spacing: 0.32em;
    text-transform: uppercase;
    color: rgba(201,169,97,0.13);
    text-align: center;
    text-decoration: none;
    transition: color 0.6s ease;
  }
  .excavation-discovery-link:hover {
    color: rgba(201,169,97,0.55);
  }
 
  /* Mobile section background overrides — adjust values as needed */
  @media (max-width: 1024px) {
    .arch-hero::before {
      filter: brightness(0.45) blur(2px);
      opacity: 0.25;
    }
    .arch-cta-section::before {
      filter: brightness(0.40) blur(3px);
      opacity: 0.20;
    }
    /* Inline bg divs inside lux-sections (the absolute-positioned layers) */
    /* legaisee-luxury.css sets filter: brightness(0.5) as a default.
       Override any specific section here if you need different values: */
    /* Example: .lux-section:nth-child(3) [style*="background-image"] {
         filter: brightness(0.35) blur(2px) !important;
       } */
  }
 
 
═══════════════════════════════════════════════════════════
2. ARCHITECT.HTML
═══════════════════════════════════════════════════════════
 
CHANGE A — Remove broken CSS link:
  DELETE: <link rel="stylesheet" href="legaisee-global-fixes.css">
 
CHANGE B — Add luxury CSS:
  ADD: <link rel="stylesheet" href="legaisee-luxury.css" />
 
CHANGE C — Add to the page's existing <style> block:
 
  /* Mobile section background overrides for architect.html */
  @media (max-width: 1024px) {
    .architect-hero::before {
      filter: brightness(0.40) blur(2px);
      opacity: 0.22;
    }
    .silence-section::before {
      filter: brightness(0.38) blur(3px);
      opacity: 0.18;
    }
    .architect-cta::before {
      filter: brightness(0.35) blur(3px);
      opacity: 0.20;
    }
    /* Section 1 inline bg (LibraryMain.png overlay div) */
    .lux-section [style*="LibraryMain"] {
      filter: brightness(0.40) blur(2px) !important;
    }
  }
 
    /* Responsive overrides for this page */
    @media (max-width: 900px) 
    {
      .arch-hero {
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-end;
        gap: 40px;
        padding: 120px 40px 60px;
      }
      .arch-hero > div[style] { width: 100%; max-width: 460px; }
    }
    @media (max-width: 768px) 
    {
      .arch-hero { padding: 120px 28px 60px; min-height: auto; }
      .drift-row { grid-template-columns: 80px 1fr; }
      .drift-signal { display: none; }
      .lindy-proof { grid-template-columns: 1fr; }
      .golden-era-frame { padding: 48px 32px; }
      .excavation-step { grid-template-columns: 44px 1fr; gap: 24px; }
      .ledger-row { grid-template-columns: 1fr; gap: 8px; }
    }
  </style>
</head>

<body>

 <!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology"style="color: var(--gold);">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
===============================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE — The Architect. Three decades of signal craft. The operating doctrine behind Business Archaeology and Authority Systems.">
  <title>The Architect — LEGAiSEE</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />

    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
  <style>
    /* ── PAGE-SPECIFIC: ARCHITECT.HTML ───────────────────────────── */

    /* PAGE HERO — full-screen library ambience */
    .architect-hero {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 140px 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .architect-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/LibraryMain.png');
      background-size: cover;
      background-position: center 30%;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.20;
      z-index: 0;
    }
    .architect-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to right, rgba(5,5,5,0.95) 0%, rgba(5,5,5,0.60) 55%, rgba(5,5,5,0.88) 100%),
        linear-gradient(to bottom, rgba(5,5,5,0.70) 0%, transparent 35%, rgba(5,5,5,0.90) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .architect-hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 88px;
      align-items: center;
      max-width: 1320px;
      margin: 0 auto;
      width: 100%;
    }

    /* PORTRAIT FRAME — squircle gem-case style */
    .portrait-frame {
      position: relative;
      border-radius: 28px;
      overflow: hidden;
      border: 1px solid var(--gold-border);
      aspect-ratio: 3/4;
      background: var(--obsidian-mid);
    }
    .portrait-frame::before {
      content: '';
      position: absolute;
      inset: 12px;
      border: 1px solid rgba(201,169,97,0.06);
      border-radius: 18px;
      z-index: 2;
      pointer-events: none;
    }
    .portrait-frame::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent 15%, var(--gold-dim) 50%, transparent 85%);
      opacity: 0.7;
      z-index: 3;
    }
    .portrait-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 14px;
      background: linear-gradient(160deg, var(--charcoal) 0%, var(--obsidian) 100%);
      position: relative;
    }
    .portrait-placeholder .gem-catalog { top: 16px; left: 16px; }
    .portrait-caption {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      padding: 28px 28px 24px;
      background: linear-gradient(to top, rgba(5,5,5,0.98) 0%, rgba(5,5,5,0.6) 65%, transparent 100%);
      z-index: 4;
    }
    .portrait-title {
      font-family: var(--font-display);
      font-size: 1.05rem;
      letter-spacing: 0.10em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 6px;
    }
    .portrait-sub {
      font-family: var(--font-ui);
      font-size: 0.88rem;
      font-style: italic;
      color: var(--pewter);
    }

    /* CREDENTIAL ROW */
    .credential-strip {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
      margin-bottom: 36px;
    }
    .credential-row {
      display: grid;
      grid-template-columns: 90px 1fr;
      gap: 0;
      border-bottom: 1px solid rgba(201,169,97,0.07);
      transition: background 0.3s ease;
    }
    .credential-row:last-child { border-bottom: none; }
    .credential-row:hover { background: rgba(201,169,97,0.02); }
    .credential-year {
      padding: 22px 18px;
      font-family: var(--font-display);
      font-size: 0.75rem;
      letter-spacing: 0.10em;
      color: var(--gold-dim);
      border-right: 1px solid rgba(201,169,97,0.08);
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .credential-text {
      padding: 22px 28px;
      font-family: var(--font-ui);
      font-size: 0.98rem;
      color: var(--silver);
      line-height: 1.65;
      display: flex;
      align-items: center;
    }

    /* OPERATING PRINCIPLES — large statement cards */
    .principle-card {
      padding: 64px 56px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(201,169,97,0.10);
      background: var(--obsidian-light);
      transition: all 0.5s var(--ease-silk);
    }
    .principle-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; bottom: 0;
      width: 3px;
      background: linear-gradient(to bottom, var(--gold), rgba(201,169,97,0.1));
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .principle-card:hover { border-color: rgba(201,169,97,0.22); transform: translateY(-5px); box-shadow: var(--shadow-lift); }
    .principle-card:hover::before { opacity: 1; }
    .principle-ghost-num {
      position: absolute;
      top: -12px; right: 20px;
      font-family: var(--font-display);
      font-size: 8rem;
      font-weight: 700;
      color: rgba(201,169,97,0.04);
      line-height: 1;
      pointer-events: none;
      user-select: none;
      transition: color 0.4s ease;
    }
    .principle-card:hover .principle-ghost-num { color: rgba(201,169,97,0.07); }
    .principle-eyebrow {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.30em;
      text-transform: uppercase;
      color: var(--gold-dim);
      display: block;
      margin-bottom: 20px;
    }
    .principle-statement {
      font-family: var(--font-display);
      font-size: clamp(1.3rem, 2.2vw, 1.8rem);
      letter-spacing: 0.04em;
      line-height: 1.28;
      color: var(--platinum);
      margin-bottom: 24px;
      position: relative;
      z-index: 1;
    }
    .principle-statement em { color: var(--gold); font-style: normal; }
    .principle-body {
      font-family: var(--font-ui);
      font-size: 1.02rem;
      color: var(--silver);
      line-height: 1.78;
      position: relative;
      z-index: 1;
    }

    /* THIRTY YEAR TIMELINE */
    .decade-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
      background: rgba(201,169,97,0.05);
      border: 1px solid rgba(201,169,97,0.10);
    }
    .decade-cell {
      background: var(--obsidian-light);
      padding: 44px 36px;
      position: relative;
      overflow: hidden;
      transition: background 0.4s ease;
    }
    .decade-cell:hover { background: var(--obsidian-mid); }
    .decade-label {
      font-family: var(--font-display);
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      color: rgba(201,169,97,0.12);
      line-height: 1;
      margin-bottom: 16px;
      transition: color 0.4s ease;
    }
    .decade-cell:hover .decade-label { color: rgba(201,169,97,0.25); }
    .decade-title {
      font-family: var(--font-display);
      font-size: clamp(0.95rem, 1.4vw, 1.1rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--gold-light);
      margin-bottom: 14px;
    }
    .decade-desc {
      font-family: var(--font-ui);
      font-size: 0.96rem;
      color: var(--pewter);
      line-height: 1.72;
    }

    /* SILENCE SECTION — The listening doctrine */
    .silence-section {
      position: relative;
      overflow: hidden;
    }
    .silence-section::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/PreformingVertical.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.13;
      z-index: 0;
    }
    .silence-section > * { position: relative; z-index: 1; }

    /* SIGNAL LEXICON — Definition-style cards */
    .lexicon-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 2px;
      background: rgba(201,169,97,0.05);
      border: 1px solid rgba(201,169,97,0.10);
    }
    .lexicon-entry {
      background: var(--obsidian-light);
      padding: 44px 40px;
      position: relative;
      overflow: hidden;
      transition: background 0.4s ease;
    }
    .lexicon-entry:hover { background: var(--obsidian-mid); }
    .lexicon-term {
      font-family: var(--font-display);
      font-size: clamp(1.1rem, 1.8vw, 1.4rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--gold);
      margin-bottom: 8px;
    }
    .lexicon-pos {
      font-family: var(--font-ui);
      font-size: 0.80rem;
      font-style: italic;
      color: var(--pewter);
      margin-bottom: 16px;
      display: block;
    }
    .lexicon-def {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.78;
    }
    .lexicon-def strong { color: var(--platinum); font-weight: 400; }

    /* ARCHITECT CTA section */
    .architect-cta {
      position: relative;
      overflow: hidden;
    }
    .architect-cta::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/AtelierObsidian.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.16;
      z-index: 0;
    }
    .architect-cta::after {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse 75% 75% at 50% 50%, transparent 0%, rgba(5,5,5,0.88) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .architect-cta > * { position: relative; z-index: 2; }

    @media (max-width: 1100px) {
      .architect-hero { padding: 140px 48px 80px; }
      .architect-hero-inner { grid-template-columns: 1fr; gap: 52px; }
      .portrait-frame { max-width: 420px; margin: 0 auto; aspect-ratio: 4/3; }
      .decade-grid { grid-template-columns: 1fr; }
      .lexicon-grid { grid-template-columns: 1fr; }
      .principle-card { padding: 48px 36px; }
    }
    @media (max-width: 768px) {
      .architect-hero { padding: 120px 28px 60px; min-height: auto; }
      .credential-row { grid-template-columns: 72px 1fr; }
      .principle-card { padding: 40px 28px; }
      .principle-ghost-num { font-size: 5rem; }
      .decade-cell { padding: 36px 28px; }
    }
  </style>
</head>

<body>

<!-- DESKTOP NAV -->
<nav class="site-nav" id="architect">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect"style="color: var(--gold);">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect"style="color: var(--gold);">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>

==================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE Commissions — Business Archaeology engagements, Authority Systems, and the Private Archaeology Protocol. Three clients maximum.">
  <title>Commissions — LEGAiSEE</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />

<style>
    /* ── PAGE-SPECIFIC: INDEX.HTML ──────────────────────────────── */
 /* ─── PAGE-LEVEL VARIABLES ─── */
    :root {
      --obsidian:    #0C0C10;
      --surface:     #181818;
      --card:        #141414;
      --gold:        #C9A961;
      --gold-dim:    rgba(201, 170, 97, 0.4);
      --gold-low:    rgba(201,169,97,0.12);
      --gold-glow:   rgba(201,169,97,0.08);
      --text-primary: rgba(255,255,255,0.92);
      --text-body:    rgba(255,255,255,0.72);
      --text-muted:   rgba(255,255,255,0.62);
      --nav-height:   72px;
    }
    /* PAGE HERO */
    .commissions-hero {
      position: relative;
      min-height: 88vh;
      display: flex;
      align-items: center;
      padding: 140px 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .commissions-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/PolishCaseMask.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.20;
      z-index: 0;
    }
    .commissions-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to right, rgba(5,5,5,0.94) 0%, rgba(5,5,5,0.55) 60%, rgba(5,5,5,0.85) 100%),
        linear-gradient(to bottom, rgba(5,5,5,0.65) 0%, transparent 30%, rgba(5,5,5,0.88) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .commissions-hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 88px;
      align-items: center;
      max-width: 1320px;
      margin: 0 auto;
      width: 100%;
    }

    /* COMMISSION CARDS — the prestige tier system */
    .commission-card {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.12);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.5s var(--ease-silk);
    }
    .commission-card:hover {
      border-color: rgba(201,169,97,0.28);
      transform: translateY(-6px);
      box-shadow: var(--shadow-lift);
    }
    .commission-card.featured {
      background: linear-gradient(160deg, var(--charcoal) 0%, var(--obsidian-mid) 100%);
      border-color: rgba(201,169,97,0.30);
    }
    .commission-card.featured::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent 10%, var(--gold) 50%, transparent 90%);
    }
    .commission-header {
      padding: 48px 48px 36px;
      border-bottom: 1px solid rgba(201,169,97,0.07);
    }
    .commission-roman {
      font-family: var(--font-display);
      font-size: 3.5rem;
      color: rgba(201,169,97,0.12);
      line-height: 1;
      margin-bottom: 20px;
      display: block;
      transition: color 0.4s ease;
    }
    .commission-card:hover .commission-roman,
    .commission-card.featured .commission-roman { color: rgba(201,169,97,0.28); }
    .commission-name {
      font-family: var(--font-display);
      font-size: clamp(1.3rem, 2vw, 1.7rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--platinum);
      margin-bottom: 14px;
      line-height: 1.15;
    }
    .commission-card.featured .commission-name { color: var(--gold-bright); }
    .commission-tagline {
      font-family: var(--font-ui);
      font-size: 1.02rem;
      font-style: italic;
      color: var(--pewter);
      line-height: 1.68;
    }
    .commission-card.featured .commission-tagline { color: var(--silver); }
    .commission-body {
      padding: 36px 48px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }
    .commission-desc {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.78;
    }
    .commission-deliverables {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.07);
    }
    .deliverable-row {
      display: flex;
      align-items: flex-start;
      gap: 16px;
      padding: 14px 20px;
      border-bottom: 1px solid rgba(201,169,97,0.05);
      transition: background 0.3s ease;
    }
    .deliverable-row:last-child { border-bottom: none; }
    .deliverable-row:hover { background: rgba(201,169,97,0.02); }
    .deliverable-dot {
      width: 5px; height: 5px;
      border-radius: 50%;
      background: var(--gold-dim);
      flex-shrink: 0;
      margin-top: 8px;
    }
    .commission-card.featured .deliverable-dot { background: var(--gold); }
    .deliverable-text {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      color: var(--pewter);
      line-height: 1.62;
    }
    .commission-card.featured .deliverable-text { color: var(--silver); }
    .commission-footer {
      padding: 28px 48px 40px;
      border-top: 1px solid rgba(201,169,97,0.07);
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .commission-investment {
      font-family: var(--font-display);
      font-size: 0.78rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold-dim);
    }
    .commission-card.featured .commission-investment { color: var(--gold); }
    .commission-timeline {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--pewter);
    }

    /* PROCESS TIMELINE */
    .process-steps {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
      position: relative;
    }
    .process-steps::before {
      content: '';
      position: absolute;
      top: 56px; left: 10%; right: 10%;
      height: 1px;
      background: linear-gradient(to right, transparent, var(--gold-dim), transparent);
      z-index: 0;
    }
    .process-step {
      padding: 36px 24px 40px;
      text-align: center;
      border-right: 1px solid rgba(201,169,97,0.07);
      position: relative;
      z-index: 1;
      background: var(--obsidian-light);
      transition: background 0.4s ease;
    }
    .process-step:last-child { border-right: none; }
    .process-step:hover { background: var(--obsidian-mid); }
    .process-node {
      width: 44px; height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(201,169,97,0.28);
      background: var(--obsidian);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-family: var(--font-display);
      font-size: 0.80rem;
      color: var(--gold-dim);
      position: relative;
      z-index: 2;
      transition: all 0.4s ease;
    }
    .process-step:hover .process-node {
      border-color: var(--gold);
      background: rgba(201,169,97,0.06);
      color: var(--gold);
      box-shadow: 0 0 16px rgba(201,169,97,0.12);
    }
    .process-title {
      font-family: var(--font-display);
      font-size: clamp(0.85rem, 1.1vw, 1rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--gold-light);
      margin-bottom: 10px;
    }
    .process-gem {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--gold-dim);
      opacity: 0.6;
      margin-bottom: 10px;
      display: block;
    }
    .process-desc {
      font-family: var(--font-ui);
      font-size: 0.88rem;
      color: var(--pewter);
      line-height: 1.65;
    }

    /* BEDROCK PLEDGE — expanded full-page treatment */
    .bedrock-section {
      position: relative;
      overflow: hidden;
    }
    .bedrock-section::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/CaseMask2.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.14;
      z-index: 0;
    }
    .bedrock-section > * { position: relative; z-index: 1; }

    /* PLEDGE CLAUSES */
    .pledge-clauses {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.12);
    }
    .pledge-clause {
      display: grid;
      grid-template-columns: 80px 1fr;
      gap: 0;
      border-bottom: 1px solid rgba(201,169,97,0.07);
      transition: background 0.3s ease;
    }
    .pledge-clause:last-child { border-bottom: none; }
    .pledge-clause:hover { background: rgba(201,169,97,0.02); }
    .clause-num {
      padding: 32px 20px;
      background: rgba(201,169,97,0.04);
      border-right: 1px solid rgba(201,169,97,0.08);
      font-family: var(--font-display);
      font-size: 1rem;
      color: var(--gold-dim);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .clause-body {
      padding: 32px 40px;
    }
    .clause-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--platinum);
      margin-bottom: 10px;
    }
    .clause-text {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.75;
    }

    /* WHAT THIS IS NOT — contrast box */
    .not-this-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.05);
    }
    .not-this-cell {
      padding: 40px 36px;
      background: var(--charcoal);
    }
    .not-this-cell.is-this {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.12);
    }
    .not-cell-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.26em;
      text-transform: uppercase;
      display: block;
      margin-bottom: 16px;
    }
    .not-this-cell .not-cell-label { color: rgba(106,106,106,0.5); }
    .not-this-cell.is-this .not-cell-label { color: var(--gold); }
    .not-cell-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 12px;
    }
    .not-this-cell .not-cell-title { color: rgba(106,106,106,0.4); }
    .not-this-cell.is-this .not-cell-title { color: var(--platinum); }
    .not-cell-desc {
      font-family: var(--font-ui);
      font-size: 0.96rem;
      line-height: 1.72;
    }

     /* Mobile section background overrides for commissions.html */
  @media (max-width: 1024px) {
    .commissions-hero::before {
      filter: brightness(0.42) blur(2px);
      opacity: 0.22;
    }
    .bedrock-section::before {
      filter: brightness(0.38) blur(3px);
      opacity: 0.18;
    }
    /* Closing CTA inline bg div */
    .lux-section [style*="Intake1"] {
      filter: brightness(0.38) blur(2px) !important;
    }
  }
  
    .not-this-cell .not-cell-desc { color: rgba(106,106,106,0.4); }
    .not-this-cell.is-this .not-cell-desc { color: var(--silver); }

    @media (max-width: 1100px) {
      .commissions-hero { padding: 140px 48px 80px; }
      .commissions-hero-inner { grid-template-columns: 1fr; gap: 52px; }
      .process-steps { grid-template-columns: repeat(3, 1fr); }
      .process-step:nth-child(4) { border-top: 1px solid rgba(201,169,97,0.07); }
      .not-this-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .commissions-hero { padding: 120px 28px 60px; min-height: auto; }
      .commission-header, .commission-body, .commission-footer { padding-left: 28px; padding-right: 28px; }
      .process-steps { grid-template-columns: 1fr; }
      .process-steps::before { display: none; }
      .process-step { border-right: none; border-bottom: 1px solid rgba(201,169,97,0.07); }
      .pledge-clause { grid-template-columns: 56px 1fr; }
      .clause-body { padding: 24px 24px; }
    }
  </style>
</head>

<body>

  <!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions"style="color: var(--gold);">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home"style="color: var(--gold);">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions"style="color: var(--gold);">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>
================================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE Commissions — Business Archaeology engagements, Authority Systems, and the Private Archaeology Protocol. Three clients maximum.">
  <title>Commissions — LEGAiSEE</title>
   <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />

<style>
    /* ── PAGE-SPECIFIC: INDEX.HTML ──────────────────────────────── */
 /* ─── PAGE-LEVEL VARIABLES ─── */
    :root {
      --obsidian:    #0C0C10;
      --surface:     #181818;
      --card:        #141414;
      --gold:        #C9A961;
      --gold-dim:    rgba(201, 170, 97, 0.4);
      --gold-low:    rgba(201,169,97,0.12);
      --gold-glow:   rgba(201,169,97,0.08);
      --text-primary: rgba(255,255,255,0.92);
      --text-body:    rgba(255,255,255,0.72);
      --text-muted:   rgba(255,255,255,0.62);
      --nav-height:   72px;
    }
    /* PAGE HERO */
    .commissions-hero {
      position: relative;
      min-height: 88vh;
      display: flex;
      align-items: center;
      padding: 140px 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .commissions-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/PolishCaseMask.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.20;
      z-index: 0;
    }
    .commissions-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to right, rgba(5,5,5,0.94) 0%, rgba(5,5,5,0.55) 60%, rgba(5,5,5,0.85) 100%),
        linear-gradient(to bottom, rgba(5,5,5,0.65) 0%, transparent 30%, rgba(5,5,5,0.88) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .commissions-hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 88px;
      align-items: center;
      max-width: 1320px;
      margin: 0 auto;
      width: 100%;
    }

    /* COMMISSION CARDS — the prestige tier system */
    .commission-card {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.12);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.5s var(--ease-silk);
    }
    .commission-card:hover {
      border-color: rgba(201,169,97,0.28);
      transform: translateY(-6px);
      box-shadow: var(--shadow-lift);
    }
    .commission-card.featured {
      background: linear-gradient(160deg, var(--charcoal) 0%, var(--obsidian-mid) 100%);
      border-color: rgba(201,169,97,0.30);
    }
    .commission-card.featured::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent 10%, var(--gold) 50%, transparent 90%);
    }
    .commission-header {
      padding: 48px 48px 36px;
      border-bottom: 1px solid rgba(201,169,97,0.07);
    }
    .commission-roman {
      font-family: var(--font-display);
      font-size: 3.5rem;
      color: rgba(201,169,97,0.12);
      line-height: 1;
      margin-bottom: 20px;
      display: block;
      transition: color 0.4s ease;
    }
    .commission-card:hover .commission-roman,
    .commission-card.featured .commission-roman { color: rgba(201,169,97,0.28); }
    .commission-name {
      font-family: var(--font-display);
      font-size: clamp(1.3rem, 2vw, 1.7rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--platinum);
      margin-bottom: 14px;
      line-height: 1.15;
    }
    .commission-card.featured .commission-name { color: var(--gold-bright); }
    .commission-tagline {
      font-family: var(--font-ui);
      font-size: 1.02rem;
      font-style: italic;
      color: var(--pewter);
      line-height: 1.68;
    }
    .commission-card.featured .commission-tagline { color: var(--silver); }
    .commission-body {
      padding: 36px 48px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }
    .commission-desc {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.78;
    }
    .commission-deliverables {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.07);
    }
    .deliverable-row {
      display: flex;
      align-items: flex-start;
      gap: 16px;
      padding: 14px 20px;
      border-bottom: 1px solid rgba(201,169,97,0.05);
      transition: background 0.3s ease;
    }
    .deliverable-row:last-child { border-bottom: none; }
    .deliverable-row:hover { background: rgba(201,169,97,0.02); }
    .deliverable-dot {
      width: 5px; height: 5px;
      border-radius: 50%;
      background: var(--gold-dim);
      flex-shrink: 0;
      margin-top: 8px;
    }
    .commission-card.featured .deliverable-dot { background: var(--gold); }
    .deliverable-text {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      color: var(--pewter);
      line-height: 1.62;
    }
    .commission-card.featured .deliverable-text { color: var(--silver); }
    .commission-footer {
      padding: 28px 48px 40px;
      border-top: 1px solid rgba(201,169,97,0.07);
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .commission-investment {
      font-family: var(--font-display);
      font-size: 0.78rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold-dim);
    }
    .commission-card.featured .commission-investment { color: var(--gold); }
    .commission-timeline {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--pewter);
    }

    /* PROCESS TIMELINE */
    .process-steps {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
      position: relative;
    }
    .process-steps::before {
      content: '';
      position: absolute;
      top: 56px; left: 10%; right: 10%;
      height: 1px;
      background: linear-gradient(to right, transparent, var(--gold-dim), transparent);
      z-index: 0;
    }
    .process-step {
      padding: 36px 24px 40px;
      text-align: center;
      border-right: 1px solid rgba(201,169,97,0.07);
      position: relative;
      z-index: 1;
      background: var(--obsidian-light);
      transition: background 0.4s ease;
    }
    .process-step:last-child { border-right: none; }
    .process-step:hover { background: var(--obsidian-mid); }
    .process-node {
      width: 44px; height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(201,169,97,0.28);
      background: var(--obsidian);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-family: var(--font-display);
      font-size: 0.80rem;
      color: var(--gold-dim);
      position: relative;
      z-index: 2;
      transition: all 0.4s ease;
    }
    .process-step:hover .process-node {
      border-color: var(--gold);
      background: rgba(201,169,97,0.06);
      color: var(--gold);
      box-shadow: 0 0 16px rgba(201,169,97,0.12);
    }
    .process-title {
      font-family: var(--font-display);
      font-size: clamp(0.85rem, 1.1vw, 1rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--gold-light);
      margin-bottom: 10px;
    }
    .process-gem {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--gold-dim);
      opacity: 0.6;
      margin-bottom: 10px;
      display: block;
    }
    .process-desc {
      font-family: var(--font-ui);
      font-size: 0.88rem;
      color: var(--pewter);
      line-height: 1.65;
    }

    /* BEDROCK PLEDGE — expanded full-page treatment */
    .bedrock-section {
      position: relative;
      overflow: hidden;
    }
    .bedrock-section::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/CaseMask2.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.14;
      z-index: 0;
    }
    .bedrock-section > * { position: relative; z-index: 1; }

    /* PLEDGE CLAUSES */
    .pledge-clauses {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.12);
    }
    .pledge-clause {
      display: grid;
      grid-template-columns: 80px 1fr;
      gap: 0;
      border-bottom: 1px solid rgba(201,169,97,0.07);
      transition: background 0.3s ease;
    }
    .pledge-clause:last-child { border-bottom: none; }
    .pledge-clause:hover { background: rgba(201,169,97,0.02); }
    .clause-num {
      padding: 32px 20px;
      background: rgba(201,169,97,0.04);
      border-right: 1px solid rgba(201,169,97,0.08);
      font-family: var(--font-display);
      font-size: 1rem;
      color: var(--gold-dim);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .clause-body {
      padding: 32px 40px;
    }
    .clause-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--platinum);
      margin-bottom: 10px;
    }
    .clause-text {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.75;
    }

    /* WHAT THIS IS NOT — contrast box */
    .not-this-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2px;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.05);
    }
    .not-this-cell {
      padding: 40px 36px;
      background: var(--charcoal);
    }
    .not-this-cell.is-this {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.12);
    }
    .not-cell-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.26em;
      text-transform: uppercase;
      display: block;
      margin-bottom: 16px;
    }
    .not-this-cell .not-cell-label { color: rgba(106,106,106,0.5); }
    .not-this-cell.is-this .not-cell-label { color: var(--gold); }
    .not-cell-title {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 12px;
    }
    .not-this-cell .not-cell-title { color: rgba(106,106,106,0.4); }
    .not-this-cell.is-this .not-cell-title { color: var(--platinum); }
    .not-cell-desc {
      font-family: var(--font-ui);
      font-size: 0.96rem;
      line-height: 1.72;
    }

     /* Mobile section background overrides for commissions.html */
  @media (max-width: 1024px) {
    .commissions-hero::before {
      filter: brightness(0.42) blur(2px);
      opacity: 0.22;
    }
    .bedrock-section::before {
      filter: brightness(0.38) blur(3px);
      opacity: 0.18;
    }
    /* Closing CTA inline bg div */
    .lux-section [style*="Intake1"] {
      filter: brightness(0.38) blur(2px) !important;
    }
  }
  
    .not-this-cell .not-cell-desc { color: rgba(106,106,106,0.4); }
    .not-this-cell.is-this .not-cell-desc { color: var(--silver); }

    @media (max-width: 1100px) {
      .commissions-hero { padding: 140px 48px 80px; }
      .commissions-hero-inner { grid-template-columns: 1fr; gap: 52px; }
      .process-steps { grid-template-columns: repeat(3, 1fr); }
      .process-step:nth-child(4) { border-top: 1px solid rgba(201,169,97,0.07); }
      .not-this-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .commissions-hero { padding: 120px 28px 60px; min-height: auto; }
      .commission-header, .commission-body, .commission-footer { padding-left: 28px; padding-right: 28px; }
      .process-steps { grid-template-columns: 1fr; }
      .process-steps::before { display: none; }
      .process-step { border-right: none; border-bottom: 1px solid rgba(201,169,97,0.07); }
      .pledge-clause { grid-template-columns: 56px 1fr; }
      .clause-body { padding: 24px 24px; }
    }
  </style>
</head>

<body>

  <!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions"style="color: var(--gold);">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home"style="color: var(--gold);">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions"style="color: var(--gold);">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>

======================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Not indexed — this page is meant to be discovered, not searched -->
  <meta name="robots" content="noindex, nofollow" />
  <title>Excavation Archive · The Archaeological Parallel | LEGAiSEE</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="legaisee.css" />

  <style>
    /* ── ROOT BACKGROUND ─────────────────────────────────────── */
    html {
      background: #050505;
    }

    html, body {
      background: #050505;
      color: var(--text-primary, #e8dcc8);
      margin: 0;
      padding: 0;
      font-family: var(--ff-body, 'Cormorant Garamond', serif);
      font-size: 18px;
      line-height: 1.7;
      overflow-x: hidden;
    }

    /* Fixed background — content scrolls over it */
    .page-bg {
      position: fixed;
      inset: 0;
      z-index: -1;
      background: #050505 url('https://www.legaisee.com/Images/IMG_3915.png')
                  center top / cover no-repeat;
    }

    /* ── GLASS CARD SYSTEM ───────────────────────────────────── */
    .glass-card {
      position: relative;
      background: rgba(10, 10, 9, 0.78);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-radius: 3px;
    }

    .glass-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 3px;
      padding: 1px;
      background: linear-gradient(
        135deg,
        rgba(201,169,97,0.9)  0%,
        rgba(201,169,97,0.25) 40%,
        rgba(201,169,97,0.55) 70%,
        rgba(201,169,97,0.9)  100%
      );
      -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
      mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    .glass-card--title {
      background: rgba(8, 8, 7, 0.85);
      backdrop-filter: blur(22px);
      -webkit-backdrop-filter: blur(22px);
    }

    .glass-card--table {
      background: rgba(12, 12, 10, 0.82);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      overflow: hidden;
    }

    .glass-card--accent {
      background: rgba(6, 6, 5, 0.84);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
    }

    /* ── NAV ─────────────────────────────────────────────────── */
    /* Uses legaisee.css .site-nav — these are supplemental overrides only */
    .nav-logo {
      font-family: var(--font-display, 'Cinzel Decorative', serif);
      font-size: 1.1rem;
      color: #C9A961;
      letter-spacing: 0.12em;
      text-decoration: none;
    }

    /* ── HERO ────────────────────────────────────────────────── */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 120px 40px 80px;
    }

    .hero-content {
      max-width: 820px;
      padding: 56px 60px;
      animation: heroFade 1.4s ease both;
    }

    @keyframes heroFade {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Archive / field-document badge */
    .archive-badge {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.55rem;
      letter-spacing: 0.38em;
      text-transform: uppercase;
      color: rgba(201,169,97,0.5);
      border: 1px solid rgba(201,169,97,0.18);
      padding: 6px 18px;
      margin-bottom: 28px;
    }

    .archive-badge::before,
    .archive-badge::after {
      content: '◆';
      font-size: 0.4rem;
      opacity: 0.6;
    }

    .hero-title {
      font-family: var(--font-display, 'Cinzel Decorative', serif);
      font-size: clamp(1.8rem, 4.5vw, 3.2rem);
      font-weight: 700;
      color: #dfc07e;
      line-height: 1.2;
      letter-spacing: 0.04em;
      margin-bottom: 24px;
    }

    .hero-rule {
      width: 64px;
      height: 1px;
      background: #C9A961;
      margin: 0 auto 28px;
      opacity: 0.5;
    }

    .hero-subtitle {
      font-family: var(--font-body, 'Cormorant Garamond', serif);
      font-size: clamp(1.05rem, 2vw, 1.3rem);
      font-style: italic;
      font-weight: 300;
      color: rgba(232,220,200,0.75);
      line-height: 1.75;
      margin-bottom: 40px;
    }

    .scroll-cue {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.58rem;
      letter-spacing: 0.24em;
      text-transform: uppercase;
      color: rgba(201,169,97,0.45);
    }

    .scroll-cue-line {
      width: 1px;
      height: 44px;
      background: linear-gradient(180deg, rgba(201,169,97,0.5), transparent);
      animation: scrollPulse 2.2s ease-in-out infinite;
    }

    @keyframes scrollPulse {
      0%, 100% { opacity: 0.4; }
      50%       { opacity: 1; }
    }

    /* ── PAGE BODY ───────────────────────────────────────────── */
    .page-body {
      max-width: 1140px;
      margin: 0 auto;
      padding: 0 40px 100px;
      display: flex;
      flex-direction: column;
    }

    /* ── INTRO CARD ──────────────────────────────────────────── */
    .intro-card {
      padding: 52px 60px;
      text-align: center;
      margin-bottom: 36px;
    }

    .intro-gem {
      font-size: 1.6rem;
      color: #C9A961;
      display: block;
      margin-bottom: 20px;
      filter: drop-shadow(0 0 8px rgba(201,169,97,0.4));
    }

    .intro-body {
      font-size: 1.15rem;
      font-weight: 300;
      color: rgba(232,220,200,0.82);
      line-height: 1.88;
      max-width: 680px;
      margin: 0 auto;
    }

    .intro-body strong {
      color: #dfc07e;
      font-weight: 500;
    }

    /* ── PHASE GROUPS ────────────────────────────────────────── */
    .phase-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 28px;
    }

    .phase-title-card {
      display: flex;
      align-items: flex-start;
      gap: 28px;
      padding: 28px 44px;
    }

    .phase-number {
      font-family: var(--font-display, 'Cinzel Decorative', serif);
      font-size: 3.8rem;
      font-weight: 900;
      color: #C9A961;
      opacity: 0.2;
      line-height: 1;
      flex-shrink: 0;
      margin-top: -4px;
      letter-spacing: -0.02em;
    }

    .phase-title-group { flex: 1; }

    .phase-label {
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.6rem;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: #C9A961;
      opacity: 0.7;
      margin-bottom: 6px;
    }

    .phase-title {
      font-family: var(--font-cinzel, 'Cinzel', serif);
      font-size: clamp(1.2rem, 2.5vw, 1.8rem);
      font-weight: 600;
      color: #dfc07e;
      letter-spacing: 0.06em;
      line-height: 1.2;
    }

    .phase-rule {
      width: 40px;
      height: 2px;
      background: #C9A961;
      margin-top: 14px;
      opacity: 0.5;
    }

    /* ── COMPARISON TABLE ────────────────────────────────────── */
    .phase-table-card { overflow: hidden; }

    .comparison-table {
      width: 100%;
      border-collapse: collapse;
    }

    .comparison-table thead tr th {
      padding: 13px 28px;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.6rem;
      letter-spacing: 0.24em;
      text-transform: uppercase;
      font-weight: 600;
      border-bottom: 1px solid rgba(201,169,97,0.22);
      text-align: left;
      background: rgba(201,169,97,0.05);
    }

    .th-real,
    .th-legaisee {
      color: #C9A961;
      width: 50%;
    }

    .comparison-table tbody tr {
      border-bottom: 1px solid rgba(201,169,97,0.06);
      transition: background 0.2s;
    }

    .comparison-table tbody tr:hover { background: rgba(201,169,97,0.05); }
    .comparison-table tbody tr:last-child { border-bottom: none; }

    .comparison-table td {
      padding: 18px 28px;
      vertical-align: top;
      font-size: 1rem;
      line-height: 1.65;
    }

    .td-real,
    .td-legaisee {
      color: rgba(232,220,200,0.9);
    }

    .td-real { border-right: 1px solid rgba(201,169,97,0.1); }

    .row-label,
    .row-label-real {
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.58rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      font-weight: 600;
      color: #C9A961;
      opacity: 0.75;
      display: block;
      margin-bottom: 5px;
    }

    /* ── GLANCE TABLE ────────────────────────────────────────── */
    .glance-group {
      margin-top: 24px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .glance-title-card {
      padding: 40px 44px;
      text-align: center;
    }

    .glance-eyebrow {
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.6rem;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: #C9A961;
      opacity: 0.7;
      margin-bottom: 12px;
    }

    .glance-title {
      font-family: var(--font-display, 'Cinzel Decorative', serif);
      font-size: clamp(1.3rem, 3vw, 2rem);
      font-weight: 700;
      color: #dfc07e;
      letter-spacing: 0.05em;
      margin-bottom: 14px;
    }

    .glance-intro {
      font-size: 1.05rem;
      font-weight: 300;
      font-style: italic;
      color: rgba(232,220,200,0.7);
    }

    .glance-table-card { overflow: hidden; }

    .glance-table {
      width: 100%;
      border-collapse: collapse;
    }

    .glance-table thead th {
      padding: 13px 24px;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.58rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      font-weight: 600;
      text-align: left;
      color: #C9A961;
      background: rgba(201,169,97,0.05);
      border-bottom: 1px solid rgba(201,169,97,0.22);
    }

    .glance-table tbody tr {
      border-bottom: 1px solid rgba(201,169,97,0.06);
      transition: background 0.2s;
    }

    .glance-table tbody tr:hover { background: rgba(201,169,97,0.05); }
    .glance-table tbody tr:last-child { border-bottom: none; }

    .glance-table td {
      padding: 14px 24px;
      font-size: 0.96rem;
      line-height: 1.5;
      vertical-align: middle;
      color: rgba(232,220,200,0.88);
    }

    .glance-table td:nth-child(1),
    .glance-table td:nth-child(3) {
      font-family: var(--font-cinzel, 'Cinzel', serif);
      color: #dfc07e;
      font-weight: 500;
      letter-spacing: 0.04em;
    }

    .glance-table td:nth-child(2) {
      font-style: italic;
      font-size: 0.88rem;
      border-right: 1px solid rgba(201,169,97,0.12);
    }

    .glance-table td:nth-child(4) {
      font-style: italic;
      font-size: 0.88rem;
    }

    .stage-num {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 22px; height: 22px;
      border: 1px solid rgba(201,169,97,0.45);
      border-radius: 50%;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.56rem;
      font-weight: 600;
      color: #C9A961;
      margin-right: 8px;
      vertical-align: middle;
      flex-shrink: 0;
    }

    /* ── CLOSING CARD ────────────────────────────────────────── */
    .closing-card {
      margin-top: 32px;
      padding: 60px 60px;
      text-align: center;
    }

    .closing-gem {
      font-size: 1.8rem;
      color: #C9A961;
      display: block;
      margin-bottom: 24px;
      filter: drop-shadow(0 0 10px rgba(201,169,97,0.4));
    }

    .closing-quote {
      max-width: 700px;
      margin: 0 auto 32px;
      font-size: clamp(1.05rem, 2.2vw, 1.4rem);
      font-style: italic;
      font-weight: 300;
      color: rgba(232,220,200,0.78);
      line-height: 1.88;
    }

    .closing-quote em {
      color: #dfc07e;
      font-style: normal;
      font-weight: 400;
    }

    .closing-rule {
      width: 1px;
      height: 52px;
      background: linear-gradient(180deg, rgba(201,169,97,0.5), transparent);
      margin: 0 auto;
    }

    /* Back to archaeology link */
    .return-link {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-top: 36px;
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.6rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: rgba(201,169,97,0.45);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .return-link:hover { color: rgba(201,169,97,0.8); }

    /* ── FOOTER ──────────────────────────────────────────────── */
    .method-footer {
      border-top: 1px solid rgba(201,169,97,0.15);
      background: rgba(5,5,5,0.9);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      padding: 28px 48px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 16px;
    }

    .footer-logo {
      font-family: var(--font-display, 'Cinzel Decorative', serif);
      font-size: 0.82rem;
      color: rgba(201,169,97,0.5);
      letter-spacing: 0.15em;
      text-decoration: none;
    }

    .footer-copy {
      font-family: var(--font-ui, 'Inter', sans-serif);
      font-size: 0.6rem;
      letter-spacing: 0.1em;
      color: rgba(232,220,200,0.28);
    }

    /* ── SCROLL REVEAL ───────────────────────────────────────── */
    .reveal {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.65s ease, transform 0.65s ease;
    }

    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* ── MOBILE ──────────────────────────────────────────────── */
    @media (max-width: 900px) {
      .site-nav { padding: 0 20px !important; }
      .page-body { padding: 0 16px 80px; }
      .hero-content { padding: 36px 24px; }
      .intro-card { padding: 32px 24px; }
      .phase-title-card { padding: 22px 20px; flex-direction: column; gap: 8px; }
      .phase-number { font-size: 2.8rem; }

      .comparison-table thead { display: none; }
      .comparison-table tbody tr { display: block; border-bottom: 1px solid rgba(201,169,97,0.1); }
      .comparison-table td {
        display: block;
        width: 100%;
        border-right: none;
        padding: 14px 18px;
      }
      .td-real { border-bottom: 1px solid rgba(201,169,97,0.08); }

      .glance-title-card { padding: 24px 20px; }
      .glance-table thead { display: none; }
      .glance-table tbody tr {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-bottom: 1px solid rgba(201,169,97,0.08);
      }
      .glance-table td:nth-child(2) { border-right: none; }

      .closing-card { padding: 36px 24px; }
      .method-footer { padding: 20px 20px; flex-direction: column; text-align: center; }
    }
  </style>
</head>

<body>

  <!-- FIXED BACKGROUND -->
  <div class="page-bg"></div>

  <!-- NAV — uses site's existing nav classes -->
  <nav class="site-nav" id="site-nav">
    <div class="nav-logo-wrap">
      <a href="/index.html">
        <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
      </a>
    </div>
    <div class="nav-links" id="nav-links">
      <a href="/index.html"         data-nav="home">Home</a>
      <a href="/archaeology.html"   data-nav="archaeology">The Archaeology</a>
      <a href="/method.html"        data-nav="method">The Method</a>
      <a href="/serve.html"         data-nav="serve">Who We Serve</a>
      <a href="/architect.html"     data-nav="architect">The Architect</a>
      <a href="/practitioner.html"  data-nav="practitioner">The Practitioner</a>
      <a href="/commissions.html"   data-nav="commissions">Commissions</a>
      <a href="/registry.html"      class="nav-cta">Enter the Registry</a>
    </div>
    <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </nav>

==========================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE — Business Archaeology & Authority Systems. Forensic excavation of institutional memory for $30M+ enterprises in the San Antonio/Austin I-35 corridor.">
  <title>LEGAiSEE — Business Archaeology & Authority Systems</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />
  <style>
    /* ── PAGE-SPECIFIC: INDEX.HTML ──────────────────────────────── */
 /* ─── PAGE-LEVEL VARIABLES ─── */
    :root {
      --obsidian:    #0C0C10;
      --surface:     #181818;
      --card:        #141414;
      --gold:        #C9A961;
      --gold-dim:    rgba(201, 170, 97, 0.4);
      --gold-low:    rgba(201,169,97,0.12);
      --gold-glow:   rgba(201,169,97,0.08);
      --text-primary: rgba(255,255,255,0.92);
      --text-body:    rgba(255,255,255,0.72);
      --text-muted:   rgba(255,255,255,0.62);
      --nav-height:   72px;
    }
    /* HERO — Full-screen vault entrance */
h1, h2, h3 { 
    font-family: 'Cinzel Decorative', serif; 
}

body, p, nav, button { 
    font-family: 'Inter', sans-serif; 
}

header {
  position: fixed;
  top: 0;
  height: 80px; /* Example height */
  width: 100%;
}

body {
  padding-top: 100px; /* Push content down by the same height as the header */

    .hero-vault {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      overflow: hidden;
      background: var(--obsidian);
    }
    /* Fixed background image revealed on scroll */
    .hero-vault::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url('https://www.legaisee.com/Images/Building-Hero.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.30; filter: blur(1.5px); 
      z-index: 0;
    }
    /* Gradient overlays — darken top/bottom to center spotlight */
    .hero-vault::after {
      content: '';
      position: absolute;
      inset: 0;
      background:
        linear-gradient(to bottom, var(--obsidian) 0%, transparent 22%, transparent 72%, var(--obsidian) 100%),
        radial-gradient(ellipse 70% 70% at 50% 50%, transparent 0%, rgba(5,5,5,0.62) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 980px;
      padding: 0 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0;
    }
    /* Vault seal ring */
    .vault-seal-ring {
      width: 92px; height: 92px;
      border-radius: 50%;
      border: 1px solid rgba(201,169,97,0.38);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      margin-bottom: 48px;
      animation: sealBreath 5s ease-in-out infinite;
    }
    .vault-seal-ring::before {
      content: '';
      position: absolute; inset: 10px;
      border-radius: 50%;
      border: 1px solid rgba(201,169,97,0.16);
    }
    .vault-seal-inner {
      font-family: var(--font-display);
      font-size: 1.6rem;
      color: var(--gold);
      letter-spacing: 0.02em;
    }
    @keyframes sealBreath {
      0%,100% { box-shadow: 0 0 18px rgba(201,169,97,0.06); }
      50%      { box-shadow: 0 0 44px rgba(201,169,97,0.18), 0 0 80px rgba(201,169,97,0.06); }
    }
    .hero-eyebrow {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.42em;
      text-transform: uppercase;
      color: var(--gold-dim);
      margin-bottom: 28px;
      padding: 8px 24px;
      border: 1px solid rgba(201,169,97,0.12);
      background: rgba(5,5,5,0.6);
    }
    .hero-headline {
      font-family: var(--font-display);
      font-size: clamp(2.6rem, 5.5vw, 5rem);
      font-weight: 400;
      line-height: 1.08;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--platinum);
      margin-bottom: 36px;
    }
    .hero-headline .gold-word { color: var(--gold); }
    .hero-divider {
      width: 120px; height: 1px;
      background: linear-gradient(to right, transparent, var(--gold), transparent);
      margin-bottom: 36px;
    }
    .hero-tagline {
      font-family: var(--font-ui);
      font-size: clamp(1.1rem, 2vw, 1.5rem);
      font-style: italic;
      color: var(--gold-bright);
      line-height: 1.8;
      max-width: 720px;
      margin-bottom: 52px;
    }
    .hero-meta {
      display: flex;
      align-items: center;
      gap: 36px;
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: rgba(168,168,168,0.5);
      margin-top: 56px;
    }
    .hero-meta-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--gold); opacity: 0.5; flex-shrink: 0; }
    /* Scroll indicator */
    .scroll-hint {
      position: absolute;
      bottom: 48px; left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      opacity: 0.4;
      animation: hintFloat 2.8s ease-in-out infinite;
    }
    .scroll-hint span {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.32em;
      text-transform: uppercase;
      color: var(--gold-dim);
    }
    .scroll-line {
      width: 1px; height: 48px;
      background: linear-gradient(to bottom, var(--gold-dim), transparent);
    }
    @keyframes hintFloat {
      0%,100% { opacity: 0.3; transform: translateX(-50%) translateY(0); }
      50%      { opacity: 0.5; transform: translateX(-50%) translateY(7px); }
    }

    /* VELVET ROPE — Opening copy section */
    .velvet-rope-section {
      position: relative;
      background: var(--obsidian);
      padding: 120px 90px 0;
    }
    .velvet-rope-section::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url('http://www.legaisee.com/Images/HeroLightsWide.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.35;
      z-index: 0;
    }
    .velvet-content {
      position: relative;
      z-index: 1;
      max-width: 1320px;
      margin: 0 auto;
    }
    .opening-paragraph {
      font-family: var(--font-ui);
      font-size: clamp(1.35rem, 2.2vw, 1.75rem);
      font-weight: 400;
      line-height: 1.85;
      color: var(--platinum);
      max-width: 900px;
    }
    .opening-paragraph + .opening-paragraph { margin-top: 32px; }

    /* THESIS — Two-col with parallax bg reveal */
    .thesis-reveal {
      position: relative;
      overflow: hidden;
    }
    .thesis-reveal::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/DigWfloor1.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.13;
      z-index: 0;
    }

    /* GEMSTONE JOURNEY — Five stage cards */
    .gem-journey-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
    }
    .gem-journey-card {
      position: relative;
      border-right: 1px solid rgba(201,169,97,0.08);
      padding: 0;
      overflow: hidden;
      transition: all 0.6s var(--ease-silk);
    }
    .gem-journey-card:last-child { border-right: none; }
    .gem-journey-card:hover { z-index: 2; }
    .gem-journey-img {
      width: 100%;
      aspect-ratio: 2/3;
      object-fit: cover;
      display: block;
      filter: saturate(0.4) contrast(1.15) brightness(0.7);
      transition: filter 0.7s ease, transform 0.8s var(--ease-silk);
    }
    .gem-journey-card:hover .gem-journey-img {
      filter: saturate(0.75) contrast(1.1) brightness(0.85);
      transform: scale(1.06);
    }
    .gem-journey-overlay {
      position: absolute; bottom: 0; left: 0; right: 0;
      padding: 24px 20px 20px;
      background: linear-gradient(to top, rgba(5,5,5,0.98) 0%, rgba(5,5,5,0.7) 55%, transparent 100%);
    }
    .gem-journey-number {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.30em;
      text-transform: uppercase;
      color: var(--gold-dim);
      margin-bottom: 6px;
    }
    .gem-journey-stage {
      font-family: var(--font-display);
      font-size: 0.82rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 6px;
    }
    .gem-journey-desc {
      font-family: var(--font-ui);
      font-size: 0.80rem;
      color: var(--pewter);
      font-style: italic;
      line-height: 1.55;
    }

    /* FRAMEWORK TILES */
    .framework-tile {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.08);
      padding: 36px 28px;
      text-align: center;
      position: relative;
      overflow: hidden;
      transition: all 0.5s var(--ease-silk);
      cursor: default;
    }
    .framework-tile::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: var(--gold);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .framework-tile:hover {
      border-color: var(--gold-border);
      transform: translateY(-5px);
      box-shadow: var(--shadow-card);
    }
    .framework-tile:hover::before { opacity: 0.5; }
    .framework-roman {
      font-family: var(--font-display);
      font-size: 1.8rem;
      color: rgba(201,169,97,0.18);
      line-height: 1;
      margin-bottom: 16px;
      transition: color 0.4s ease;
    }
    .framework-tile:hover .framework-roman { color: rgba(201,169,97,0.45); }
    .framework-name {
      font-family: var(--font-ui);
      font-size: 0.62rem;
      font-weight: 500;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--silver);
      line-height: 1.6;
    }

    /* BEDROCK CARDS — 3-pillar grid */
    .bedrock-grid .museum-card {
      text-align: center;
      padding: 52px 36px;
    }
    .pillar-icon {
      width: 52px; height: 52px;
      border: 1px solid var(--gold-border);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 28px;
      font-family: var(--font-display);
      font-size: 1.1rem;
      color: var(--gold);
      transition: all 0.4s ease;
    }
    .museum-card:hover .pillar-icon {
      background: rgba(201,169,97,0.06);
      border-color: var(--gold);
    }
    .pillar-title {
      font-family: var(--font-display);
      font-size: 1rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--platinum);
      margin-bottom: 16px;
    }
    .pillar-desc {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      color: var(--pewter);
      line-height: 1.75;
    }

    /* PLEDGE STATEMENT */
    .pledge-box {
      max-width: 880px;
      margin: 0 auto;
      padding: 64px 72px;
      background: var(--obsidian-mid);
      border: 1px solid var(--gold-border);
      text-align: center;
      position: relative;
    }
    .pledge-box::before {
      content: '';
      position: absolute;
      top: 0; left: 50%;
      transform: translateX(-50%);
      width: 140px; height: 1px;
      background: var(--gold);
      opacity: 0.45;
    }
    .pledge-box::after {
      content: '';
      position: absolute;
      bottom: 0; left: 50%;
      transform: translateX(-50%);
      width: 80px; height: 1px;
      background: var(--gold-dim);
      opacity: 0.3;
    }
    .pledge-text {
      font-family: var(--font-ui);
      font-size: clamp(1.1rem, 1.9vw, 1.45rem);
      font-style: italic;
      color: var(--gold-bright);
      line-height: 1.88;
      margin-bottom: 36px;
    }
    .pledge-attribution {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--pewter);
    }

    /* GEOGRAPHY STRIP — Texas I-35 Corridor context */
    .geography-strip {
      background: var(--charcoal);
      border-top: 1px solid rgba(201,169,97,0.08);
      border-bottom: 1px solid rgba(201,169,97,0.08);
      padding: 52px 90px;
    }
    .geography-inner {
      max-width: 1320px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      gap: 64px;
    }
    .geography-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.30em;
      text-transform: uppercase;
      color: var(--gold-dim);
      white-space: nowrap;
      flex-shrink: 0;
    }
    .geography-divider {
      flex: 0 0 1px;
      height: 40px;
      background: rgba(201,169,97,0.16);
    }
    .geography-text {
      font-family: var(--font-display);
      font-size: clamp(1rem, 1.6vw, 1.25rem);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--platinum);
    }
    .geography-text em {
      font-family: var(--font-ui);
      font-style: italic;
      font-size: 0.88em;
      color: var(--pewter);
      text-transform: none;
      letter-spacing: 0;
      display: block;
      margin-top: 4px;
    }

    /* INVITE ONLY CTA — "There is a version..." */
    .final-cta {
      position: relative;
      padding: 160px 90px;
      text-align: center;
      overflow: hidden;
    }
    .final-cta::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/PolishCaseMask.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.14;
      z-index: 0;
    }
    .final-cta::after {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse 80% 80% at 50% 50%, transparent 0%, rgba(5,5,5,0.85) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .final-cta > * { position: relative; z-index: 2; }
    .final-cta-quote {
      font-family: var(--font-ui);
      font-size: clamp(1.3rem, 2.4vw, 1.9rem);
      font-style: italic;
      color: var(--gold-bright);
      max-width: 780px;
      margin: 0 auto 52px;
      line-height: 1.85;
    }
     /* Mobile section background overrides for index.html */
  @media (max-width: 1024px) {
    /* Hero vault ::before */
    .hero-vault::before {
      filter: brightness(0.40) blur(2px);
      opacity: 0.32;
    }
    /* Velvet rope section ::before (HeroLightsWide) */
    .velvet-rope-section::before {
      filter: brightness(0.35) blur(3px);
      opacity: 0.28;
    }
    /* Thesis reveal ::before (DigWfloor1) */
    .thesis-reveal::before {
      filter: brightness(0.38) blur(2px);
      opacity: 0.22;
    }
    /* Gem journey section inline bg div (Library2Diamond) */
    .lux-section [style*="Library2Diamond"] {
      filter: brightness(0.35) blur(2px) !important;
    }
    /* Frameworks section inline bg (LapidaryVerticleBlue) */
    .lux-section [style*="LapidaryVerticleBlue"] {
      filter: brightness(0.32) blur(3px) !important;
    }
    /* Final CTA ::before (PolishCaseMask) */
    .final-cta::before {
      filter: brightness(0.35) blur(3px);
      opacity: 0.18;
    }
  }
 
  /* Note: Five Stages (gem-journey-grid) responsive stacking
     is handled entirely in legaisee-luxury.css — no HTML change needed. */

.centerLogo img{
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%)
}

  </style>
</head>

<body>

  <!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home"style="color: var(--gold);">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home"style="color: var(--gold);">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>

=======================================================================================

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LEGAiSEE — Forensic Intake</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet" />

  <style>
    /* ─── TOKENS ─── */
    :root {
      --obsidian:   #181818;
      --obsidian-2: #0a0a0a;
      --obsidian-3: #111111;
      --gold:       #C9A961;
      --gold-dim:   rgba(201,169,97,0.18);
      --gold-mid:   rgba(201,169,97,0.35);
      --cream:      #f5f0e8;
      --cream-dim:  rgba(245,240,232,0.45);
      --cream-faint:rgba(245,240,232,0.08);
      --err:        #c96161;
    }

    /* ─── RESET ─── */
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    html, body {
      height: 100%;
      background: var(--obsidian);
      color: var(--cream);
      font-family: 'Inter', sans-serif;
      font-weight: 300;
      overflow: hidden;
    }

    /* ─── LAYOUT ─── */
    #app {
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ─── HEADER ─── */
    #hdr {
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 32px;
      border-bottom: 1px solid var(--gold-dim);
      background: var(--obsidian);
      z-index: 10;
    }
    .wordmark {
      font-family: 'Cinzel', serif;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .28em;
      color: var(--gold);
    }
    .wordmark span { color: rgba(245,240,232,0.35); font-weight: 400; }
    .hdr-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    #reset-btn {
      font-family: 'Cinzel', serif;
      font-size: 9px;
      letter-spacing: .2em;
      text-transform: uppercase;
      color: rgba(201,169,97,0.4);
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px 8px;
      transition: color .2s;
      display: none;
    }
    #reset-btn:hover { color: var(--gold); }
    .badge {
      font-family: 'Inter', sans-serif;
      font-size: 9px;
      font-weight: 500;
      letter-spacing: .2em;
      text-transform: uppercase;
      color: var(--gold);
      background: rgba(201,169,97,0.08);
      border: 1px solid var(--gold-mid);
      padding: 4px 11px;
      border-radius: 2px;
    }

    /* ─── MESSAGE AREA ─── */
    #msgs {
      flex: 1;
      overflow-y: auto;
      padding: 32px;
      display: flex;
      flex-direction: column;
      scroll-behavior: smooth;
    }
    #msgs::-webkit-scrollbar { width: 3px; }
    #msgs::-webkit-scrollbar-thumb {
      background: rgba(201,169,97,0.15);
      border-radius: 2px;
    }

    /* ─── SPLASH ─── */
    #splash {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      gap: 18px;
      text-align: center;
      padding: 48px;
    }
    .sigil {
      font-size: 30px;
      color: var(--gold);
      opacity: .45;
      animation: pulse 3s ease-in-out infinite;
    }
    @keyframes pulse {
      0%,100% { opacity:.35; }
      50%      { opacity:.65; }
    }
    .splash-label {
      font-family: 'Cinzel', serif;
      font-size: 10px;
      letter-spacing: .35em;
      text-transform: uppercase;
      color: var(--gold);
    }
    .splash-sub {
      font-family: 'Cormorant Garamond', serif;
      font-size: 16px;
      font-style: italic;
      color: var(--cream-dim);
      max-width: 380px;
      line-height: 1.8;
    }
    #start-btn {
      margin-top: 8px;
      background: transparent;
      border: 1px solid var(--gold-mid);
      color: var(--gold);
      font-family: 'Cinzel', serif;
      font-size: 10px;
      letter-spacing: .28em;
      text-transform: uppercase;
      padding: 12px 30px;
      cursor: pointer;
      border-radius: 2px;
      transition: all .25s;
    }
    #start-btn:hover {
      background: rgba(201,169,97,0.07);
      border-color: var(--gold);
    }

    /* ─── MESSAGE ROW ─── */
    .msg {
      display: flex;
      gap: 20px;
      padding: 20px 0;
      border-bottom: 1px solid var(--cream-faint);
      animation: fadeUp .35s ease both;
    }
    .msg:last-child { border-bottom: none; }
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(7px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .msg-label {
      font-family: 'Cinzel', serif;
      font-size: 8px;
      font-weight: 600;
      letter-spacing: .18em;
      text-transform: uppercase;
      padding-top: 4px;
      flex-shrink: 0;
      width: 78px;
      text-align: right;
    }
    .msg.iv .msg-label { color: var(--gold); }
    .msg.pr .msg-label { color: rgba(245,240,232,0.3); }
    .msg.er .msg-label { color: var(--err); }

    .msg-line {
      width: 1px;
      flex-shrink: 0;
      align-self: stretch;
    }
    .msg.iv .msg-line { background: rgba(201,169,97,0.22); }
    .msg.pr .msg-line { background: rgba(245,240,232,0.1); }
    .msg.er .msg-line { background: rgba(201,97,97,0.3); }

    .msg-text {
      flex: 1;
      font-family: 'Cormorant Garamond', serif;
      font-size: 18px;
      font-weight: 300;
      line-height: 1.78;
      color: var(--cream);
    }
    .msg.pr .msg-text {
      color: rgba(245,240,232,0.5);
      font-size: 17px;
    }
    .msg.er .msg-text {
      color: #e08080;
      font-family: 'Inter', sans-serif;
      font-size: 12px;
      line-height: 1.6;
    }

    /* ─── THINKING INDICATOR ─── */
    #thinking {
      display: none;
      gap: 20px;
      align-items: center;
      padding: 20px 0;
      opacity: .55;
    }
    .thinking-label {
      font-family: 'Cinzel', serif;
      font-size: 8px;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: var(--gold);
      width: 78px;
      text-align: right;
      flex-shrink: 0;
    }
    .thinking-line {
      width: 1px;
      background: rgba(201,169,97,0.2);
      height: 22px;
      flex-shrink: 0;
    }
    .dots { display:flex; gap:6px; align-items:center; }
    .dot {
      width: 4px; height: 4px;
      background: var(--gold);
      border-radius: 50%;
      animation: dotPulse 1.4s ease-in-out infinite;
    }
    .dot:nth-child(2) { animation-delay: .2s; }
    .dot:nth-child(3) { animation-delay: .4s; }
    @keyframes dotPulse {
      0%,80%,100% { opacity:.2; transform:scale(.8); }
      40%          { opacity:1;  transform:scale(1); }
    }

    /* ─── BRIEF BLOCK ─── */
    .brief-wrap {
      padding: 20px 0;
      animation: fadeUp .35s ease both;
    }
    .brief-hdr {
      display: flex;
      gap: 20px;
      align-items: center;
      margin-bottom: 12px;
    }
    .brief-label {
      font-family: 'Cinzel', serif;
      font-size: 8px;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: var(--gold);
      width: 78px;
      text-align: right;
      flex-shrink: 0;
    }
    .brief-line {
      width: 1px;
      background: rgba(201,169,97,0.22);
      height: 22px;
      flex-shrink: 0;
    }
    .brief-title {
      font-family: 'Cinzel', serif;
      font-size: 9px;
      letter-spacing: .22em;
      text-transform: uppercase;
      color: var(--gold);
    }
    .brief-content {
      margin-left: 98px;
      font-family: 'Inter', sans-serif;
      font-size: 11.5px;
      font-weight: 400;
      line-height: 1.85;
      color: var(--cream);
      background: #0d0d0d;
      border: 1px solid var(--gold-dim);
      border-left: 2px solid var(--gold);
      padding: 22px 24px;
      white-space: pre-wrap;
    }

    /* ─── FOOTER / INPUT ─── */
    #ftr {
      flex-shrink: 0;
      display: flex;
      gap: 10px;
      align-items: flex-end;
      padding: 16px 32px;
      border-top: 1px solid rgba(201,169,97,0.1);
      background: var(--obsidian-2);
    }
    #input {
      flex: 1;
      background: var(--obsidian-3);
      border: 1px solid var(--gold-dim);
      border-radius: 2px;
      padding: 13px 16px;
      color: var(--cream);
      font-family: 'Cormorant Garamond', serif;
      font-size: 17px;
      font-weight: 300;
      line-height: 1.5;
      resize: none;
      outline: none;
      min-height: 48px;
      max-height: 140px;
      overflow-y: auto;
      transition: border-color .2s;
    }
    #input:focus { border-color: rgba(201,169,97,0.42); }
    #input::placeholder { color: rgba(245,240,232,0.18); font-style: italic; }
    #input:disabled { opacity: .3; cursor: not-allowed; }

    #send-btn {
      background: var(--gold);
      border: none;
      border-radius: 2px;
      width: 48px;
      height: 48px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: background .2s, opacity .2s;
    }
    #send-btn:hover:not(:disabled) { background: #d4b570; }
    #send-btn:disabled { opacity: .22; cursor: not-allowed; }

    /* ─── API KEY NOTICE ─── */
    #api-notice {
      display: none;
      margin-left: 98px;
      margin-top: 8px;
      font-family: 'Inter', sans-serif;
      font-size: 11px;
      color: rgba(201,97,97,0.85);
      letter-spacing: .03em;
    }
  </style>

</head>
<body>

<div id="app">
===============================================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE — The Ten Interlocking Frameworks of Reconstruction. The complete methodology behind Business Archaeology and Authority Systems.">
  <title>The Method — LEGAiSEE</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="legaisee.css">
         <link rel="stylesheet" href="legaisee-luxury.css" />

  <style>
    /* ── PAGE-SPECIFIC: METHOD.HTML ──────────────────────────────── */
 /* ─── PAGE-LEVEL VARIABLES ─── */
    :root {
      --obsidian:    #0C0C10;
      --surface:     #181818;
      --card:        #141414;
      --gold:        #C9A961;
      --gold-dim:    rgba(201, 170, 97, 0.4);
      --gold-low:    rgba(201,169,97,0.12);
      --gold-glow:   rgba(201,169,97,0.08);
      --text-primary: rgba(255,255,255,0.92);
      --text-body:    rgba(255,255,255,0.72);
      --text-muted:   rgba(255,255,255,0.62);
      --nav-height:   72px;
    }
    /* PAGE HERO */
    .method-hero {
      position: relative;
      min-height: 86vh;
      display: flex;
      align-items: center;
      padding: 140px 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .method-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/LapidaryVerticleBlue.png');
      background-size: cover;
      background-position: center 20%;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.20;
      z-index: 0;
    }
    .method-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to right, rgba(5,5,5,0.90) 0%, rgba(5,5,5,0.50) 55%, rgba(5,5,5,0.75) 100%),
        linear-gradient(to bottom, rgba(5,5,5,0.60) 0%, transparent 30%, rgba(5,5,5,0.80) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .method-hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      max-width: 1320px;
      margin: 0 auto;
      width: 100%;
    }

    /* FRAMEWORK NAVIGATOR — sticky top strip */
    .framework-nav {
      position: sticky;
      top: 72px;
      z-index: 200;
      background: rgba(5,5,5,0.97);
      border-bottom: 1px solid rgba(201,169,97,0.10);
      padding: 0 90px;
      overflow-x: auto;
      scrollbar-width: none;
      backdrop-filter: blur(10px);
    }
    .framework-nav::-webkit-scrollbar { display: none; }
    .framework-nav-inner {
      display: flex;
      gap: 0;
      max-width: 1320px;
      margin: 0 auto;
    }
    .fn-tab {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 18px 22px;
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--pewter);
      white-space: nowrap;
      text-decoration: none;
      border-bottom: 2px solid transparent;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }
    .fn-tab:hover { color: var(--gold-light); border-bottom-color: rgba(201,169,97,0.3); }
    .fn-tab.active { color: var(--gold); border-bottom-color: var(--gold); }
    .fn-roman {
      font-family: var(--font-display);
      font-size: 0.80rem;
      color: var(--gold-dim);
      flex-shrink: 0;
    }

    /* FRAMEWORK SECTIONS — anchored */
    .fw-section {
      scroll-margin-top: 120px;
    }

    /* TRUTH TIER ROWS — the Hierarchy of Truth visual */
    .tier-stack { display: flex; flex-direction: column; gap: 16px; }
    .tier-row {
      display: grid;
      grid-template-columns: 160px 1fr;
      gap: 0;
      border: 1px solid;
      overflow: hidden;
      transition: all 0.4s ease;
    }
    .tier-row:hover { transform: translateX(4px); }
    .tier-row.t1 { border-color: rgba(201,169,97,0.35); }
    .tier-row.t2 { border-color: rgba(168,168,168,0.20); }
    .tier-row.t3 { border-color: rgba(106,106,106,0.15); }
    .tier-row.t4 { border-color: rgba(106,106,106,0.08); }
    .tier-badge-col {
      padding: 28px 24px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      gap: 8px;
    }
    .tier-row.t1 .tier-badge-col { background: rgba(201,169,97,0.07); }
    .tier-row.t2 .tier-badge-col { background: rgba(168,168,168,0.04); }
    .tier-row.t3 .tier-badge-col { background: rgba(106,106,106,0.03); }
    .tier-row.t4 .tier-badge-col { background: rgba(5,5,5,0.5); }
    .tier-roman {
      font-family: var(--font-display);
      font-size: 1.6rem;
      line-height: 1;
    }
    .tier-row.t1 .tier-roman { color: var(--gold); }
    .tier-row.t2 .tier-roman { color: var(--silver); }
    .tier-row.t3 .tier-roman { color: var(--pewter); }
    .tier-row.t4 .tier-roman { color: rgba(106,106,106,0.5); }
    .tier-name {
      font-family: var(--font-ui);
      font-size: 0.54rem;
      font-weight: 600;
      letter-spacing: 0.20em;
      text-transform: uppercase;
    }
    .tier-row.t1 .tier-name { color: var(--gold-dim); }
    .tier-row.t2 .tier-name { color: var(--pewter); }
    .tier-row.t3 .tier-name { color: rgba(106,106,106,0.7); }
    .tier-row.t4 .tier-name { color: rgba(106,106,106,0.4); }
    .tier-body {
      padding: 28px 36px;
      border-left: 1px solid rgba(255,255,255,0.04);
    }
    .tier-title {
      font-family: var(--font-display);
      font-size: clamp(0.9rem, 1.3vw, 1.1rem);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 10px;
    }
    .tier-row.t1 .tier-title { color: var(--platinum); }
    .tier-row.t2 .tier-title { color: var(--silver); }
    .tier-row.t3 .tier-title { color: var(--pewter); }
    .tier-row.t4 .tier-title { color: rgba(106,106,106,0.6); }
    .tier-desc {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      line-height: 1.72;
    }
    .tier-row.t1 .tier-desc { color: var(--silver); }
    .tier-row.t2 .tier-desc { color: var(--pewter); }
    .tier-row.t3 .tier-desc { color: rgba(168,168,168,0.5); }
    .tier-row.t4 .tier-desc { color: rgba(106,106,106,0.5); }

    /* CHANNEL GRID */
    .channel-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1px;
      background: rgba(201,169,97,0.06);
      border: 1px solid rgba(201,169,97,0.08);
    }
    .channel-cell {
      background: var(--obsidian-light);
      padding: 20px 22px;
      transition: background 0.3s ease;
      cursor: default;
    }
    .channel-cell:hover { background: var(--obsidian-mid); }
    .channel-era {
      font-family: var(--font-ui);
      font-size: 0.52rem;
      font-weight: 500;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--gold-dim);
      display: block;
      margin-bottom: 6px;
    }
    .channel-name {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      color: var(--silver);
      line-height: 1.5;
    }

    /* VOICE DIMENSIONS GRID */
    .voice-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 2px;
      background: rgba(201,169,97,0.05);
      border: 1px solid rgba(201,169,97,0.10);
    }
    .voice-cell {
      background: var(--obsidian-light);
      padding: 36px 32px;
      position: relative;
      overflow: hidden;
      transition: background 0.4s ease;
    }
    .voice-cell:hover { background: var(--obsidian-mid); }
    .voice-num {
      position: absolute;
      top: 10px; right: 16px;
      font-family: var(--font-display);
      font-size: 3.5rem;
      color: rgba(201,169,97,0.06);
      line-height: 1;
      pointer-events: none;
    }
    .voice-title {
      font-family: var(--font-display);
      font-size: clamp(0.95rem, 1.3vw, 1.1rem);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--gold-light);
      margin-bottom: 12px;
      position: relative;
      z-index: 1;
    }
    .voice-desc {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      color: var(--silver);
      line-height: 1.70;
      position: relative;
      z-index: 1;
    }

    /* EVIDENCE CLASSES — Eight phase cards */
    .evidence-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }

    /* FRAMEWORKS V–X — Compact cards */
    .compact-fw-card {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.09);
      padding: 40px 36px;
      position: relative;
      overflow: hidden;
      transition: all 0.4s var(--ease-silk);
    }
    .compact-fw-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; bottom: 0;
      width: 2px;
      background: linear-gradient(to bottom, var(--gold), transparent);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .compact-fw-card:hover { border-color: rgba(201,169,97,0.22); transform: translateY(-4px); box-shadow: var(--shadow-card); }
    .compact-fw-card:hover::before { opacity: 1; }
    .cfw-roman {
      font-family: var(--font-display);
      font-size: 2.2rem;
      color: rgba(201,169,97,0.15);
      line-height: 1;
      margin-bottom: 16px;
      display: block;
      transition: color 0.4s ease;
    }
    .compact-fw-card:hover .cfw-roman { color: rgba(201,169,97,0.35); }

    /* CONFLICT BOX — Triangulation example */
    .conflict-box {
      background: var(--charcoal);
      border: 1px solid rgba(201,169,97,0.10);
      border-left: 3px solid var(--gold-dim);
      padding: 36px 40px;
    }
    .conflict-source {
      display: flex;
      gap: 16px;
      align-items: flex-start;
      padding: 16px 0;
      border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .conflict-source:last-child { border-bottom: none; }
    .conflict-badge {
      font-family: var(--font-ui);
      font-size: 0.54rem;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      padding: 5px 12px;
      border: 1px solid;
      white-space: nowrap;
      flex-shrink: 0;
      margin-top: 2px;
    }
    .conflict-badge.says   { color: var(--silver); border-color: var(--graphite); }
    .conflict-badge.contra { color: rgba(201,169,97,0.6); border-color: rgba(201,169,97,0.2); }
    .conflict-badge.proof  { color: var(--gold); border-color: var(--gold-dim); }
    .conflict-text {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      font-style: italic;
      line-height: 1.65;
    }

    @media (max-width: 1024px) {
      .method-hero { padding: 140px 48px 80px; }
      .method-hero-inner { grid-template-columns: 1fr; gap: 52px; }
      .framework-nav { padding: 0 40px; }
      .channel-grid { grid-template-columns: repeat(2, 1fr); }
      .voice-grid { grid-template-columns: 1fr; }
      .evidence-grid { grid-template-columns: 1fr; }
      .tier-row { grid-template-columns: 120px 1fr; }
    }
    @media (max-width: 768px) {
      .method-hero { padding: 140px 28px 60px; min-height: auto; }
      .framework-nav { padding: 0 20px; top: 64px; }
      .channel-grid { grid-template-columns: 1fr 1fr; }
      .tier-row { grid-template-columns: 100px 1fr; }
      .tier-badge-col { padding: 20px 12px; }
      .tier-body { padding: 20px 20px; }
    }
    @media (max-width: 480px) {
      .channel-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>

<body>

<!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method"style="color: var(--gold);">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method"style="color: var(--gold);">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>

===================================================================================================

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>The Practitioner — LEGAiSEE Business Archaeology</title>
  <meta name="description" content="John Carr. 33 years of documented operational record. Network broadcast credentials. Institutional clients. The forensic discipline of an archivist with the DNA of a master broadcaster.">

  <link rel="stylesheet" href="/legaisee.css">
      <link rel="stylesheet" href="legaisee-luxury.css" />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <style>
    /* ─── PAGE-LEVEL VARIABLES ─── */
    :root {
      --obsidian:    #0C0C10;
      --surface:     #181818;
      --card:        #141414;
      --gold:        #C9A961;
      --gold-dim:    rgba(201, 170, 97, 0.4);
      --gold-low:    rgba(201,169,97,0.12);
      --gold-glow:   rgba(201,169,97,0.08);
      --text-primary: rgba(255,255,255,0.92);
      --text-body:    rgba(255,255,255,0.72);
      --text-muted:   rgba(255,255,255,0.62);
      --nav-height:   72px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { font-size: 17px; scroll-behavior: smooth; }
    body {
      background: var(--obsidian);
      color: var(--text-body);
      font-family: 'Inter', sans-serif;
      font-weight: 400;
      line-height: 1.8;
      -webkit-font-smoothing: antialiased;
    }

    /* ─── NAV (self-contained — matches LEGAISEE-HEAD-NAV.html pattern) ─── */
    .site-nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: var(--nav-height);
      background: rgba(5,5,5,0.88);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(201,169,97,0.12);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2.5rem;
      z-index: 1000;
    }
    .nav-logo a {
      display: flex; align-items: center;
      text-decoration: none;
    }
    .nav-logo img { width: 160px; flex-shrink: 0; min-width: 120px; }

    .nav-links {
      display: flex; gap: 2rem; list-style: none;
    }
    .nav-links a {
      font-family: 'Inter', sans-serif;
      font-size: 0.68rem;
      font-weight: 500;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.2s;
    }
    .nav-links a:hover,
    .nav-links a[data-nav="practitioner"] { color: var(--gold); }
    body[data-page="practitioner"] .nav-links a[data-nav="practitioner"] { color: var(--gold); }

    .nav-cta {
      font-family: 'Inter', sans-serif;
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      font-color: var(--obsidian);
      background: var(--gold);
      border: none;
      padding: 0.55rem 1.2rem;
      text-decoration: none;
      white-space: nowrap;
      transition: opacity 0.2s;
    }
    .nav-cta:hover { opacity: 0.85; }, border-bottom: "1px solid var(--gold-low);

    .nav-hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      background: none;
      border: none;
      padding: 4px;
    }
    .nav-hamburger span {
      display: block; width: 24px; height: 2px;
      background: var(--gold);
      transition: all 0.25s;
    }

   .nav-mobile {
    display: none;
    position: fixed;
    top: var(--nav-height);
    left: 0;
    right: 0;

    background: rgba(5,5,5,.97);
    border-bottom: 1px solid var(--gold-dim);

    padding: 1.5rem 2rem;

    flex-direction: column;
    gap: 1.2rem;

    z-index: 9999;
}

.nav-mobile.is-open {
    display: flex;
}
    @media (max-width: 1024px) {
      .nav-links { display: none; }
      .nav-cta { display: none; }
      .nav-hamburger { display: flex; }
      .site-nav { position: fixed; }
    }
    @media (max-width: 768px) {
      html { font-size: 15.5px; }
      .site-nav { padding: 0 1.25rem; }
    }

    /* ─── LAYOUT ─── */
    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 2rem;
    }
    @media (max-width: 768px) { .container { padding: 0 1.25rem; } }

    /* ─── HERO ─── */
    .practitioner-hero {
      padding-top: var(--nav-height);
      min-height: 92vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      background: var(--obsidian);
    }
    .practitioner-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 60% at 70% 40%, rgba(201, 170, 97, 0.2) 0%, transparent 60%),
        radial-gradient(ellipse 40% 50% at 20% 80%, rgba(201, 170, 97, 0.02) 0%, transparent 50%);
      pointer-events: none;
    }

    .hero-inner {
      position: relative;
      z-index: 1;
      padding: 6rem 0 5rem;
      width: 100%;
    }

    .hero-eyebrow {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 2.5rem;
    }
    .hero-eyebrow-line {
      width: 48px;
      height: 1px;
      background: var(--gold);
      opacity: 0.6;
    }
    .hero-eyebrow-text {
      font-family: 'Inter', sans-serif;
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      color: var(--gold);
    }

    .hero-name {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(2.2rem, 6vw, 4.2rem);
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.1;
      margin-bottom: 1rem;
      letter-spacing: 0.02em;
    }

    .hero-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(0.75rem, 1.8vw, 1rem);
      font-weight: 400;
      color: var(--gold);
      letter-spacing: 0.2em;
      text-transform: uppercase;
      margin-bottom: 2.5rem;
    }

    .hero-statement {
      font-family: 'Inter', sans-serif;
      font-size: clamp(1.1rem, 2.2vw, 1.35rem);
      font-weight: 300;
      color: var(--text-body);
      line-height: 1.75;
      max-width: 680px;
      margin-bottom: 3rem;
    }

    .hero-credentials {
      display: flex;
      flex-wrap: wrap;
      gap: 0.75rem;
    }
    .credential-pill {
      font-family: 'Inter', sans-serif;
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--text-muted);
      border: 1px solid rgba(201,169,97,0.2);
      padding: 0.4rem 0.9rem;
    }

    /* ─── SECTION CHROME ─── */
    .section-divider {
      width: 100%;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold-dim), transparent 30%);
    }

    .section-label {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    .label-line {
      flex: 1;
      height: 1px;
      background: var(--gold-dim);
    }
    .label-text {
      font-family: 'Inter', sans-serif;
      font-size: 0.62rem;
      font-weight: 500;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold);
      white-space: nowrap;
    }

    .section-number {
      font-family: 'Cinzel Decorative', serif;
      font-size: 0.6rem;
      font-weight: 400;
      letter-spacing: 0.2em;
      color: var(--gold-dim);
      margin-bottom: 0.5rem;
    }

    /* ─── ERA SECTIONS ─── */
    .era-section {
      padding: 7rem 0;
      position: relative;
    }
    .era-section--surface {
      background: var(--surface);
    }

    .era-header {
      margin-bottom: 4rem;
    }
    .era-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(1.4rem, 3vw, 2.2rem);
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.2;
      margin-bottom: 0.6rem;
    }
    .era-subtitle {
      font-family: 'Inter', sans-serif;
      font-size: 0.75rem;
      font-weight: 500;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    /* ─── RECORD GRID ─── */
    .record-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }
    .record-grid--3col {
      grid-template-columns: 1fr 1fr 1fr;
    }
    .record-grid--wide {
      grid-template-columns: 3fr 2fr;
      gap: 3rem;
    }
    @media (max-width: 900px) {
      .record-grid,
      .record-grid--3col,
      .record-grid--wide { grid-template-columns: 1fr; }
    }

    .record-card {
      background: var(--card);
      border: 1px solid rgba(201,169,97,0.1);
      padding: 2rem;
    }
    .record-card--accented {
      border-top: 2px solid var(--gold);
    }

    .record-card-label {
      font-family: 'Inter', sans-serif;
      font-size: 0.62rem;
      font-weight: 500;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.75rem;
    }
    .record-card-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(0.85rem, 1.5vw, 1.05rem);
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.4;
      margin-bottom: 0.5rem;
    }
    .record-card-meta {
      font-family: 'Inter', sans-serif;
      font-size: 0.72rem;
      font-weight: 400;
      color: var(--text-muted);
      margin-bottom: 1rem;
    }
    .record-card-body {
      font-family: 'Inter', sans-serif;
      font-size: 0.92rem;
      font-weight: 400;
      color: var(--text-body);
      line-height: 1.8;
    }

    /* ─── PROOF BLOCK (Addy Award, etc.) ─── */
    .proof-block {
      border-left: 3px solid var(--gold);
      padding: 1.5rem 2rem;
      background: var(--gold-glow);
      margin: 2rem 0;
    }
    .proof-block-label {
      font-family: 'Inter', sans-serif;
      font-size: 0.62rem;
      font-weight: 500;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 0.5rem;
    }
    .proof-block-title {
      font-family: 'Cinzel Decorative', serif;
      font-size: 1.05rem;
      font-weight: 400;
      color: var(--text-primary);
      margin-bottom: 0.4rem;
    }
    .proof-block-body {
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      color: var(--text-body);
      line-height: 1.75;
    }

    /* ─── PULL QUOTE ─── */
    .pull-quote {
      text-align: center;
      padding: 5rem 0;
      max-width: 780px;
      margin: 0 auto;
    }
    .pull-quote__mark {
      font-family: 'Cinzel Decorative', serif;
      font-size: 4rem;
      color: var(--gold-dim);
      line-height: 0.5;
      margin-bottom: 1.5rem;
      display: block;
    }
    .pull-quote__text {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(1.1rem, 2.5vw, 1.6rem);
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.5;
      font-style: italic;
    }
    .pull-quote__rule {
      width: 48px;
      height: 1px;
      background: var(--gold);
      margin: 2rem auto 0;
    }

    /* ─── STAT STRIP ─── */
    .stats-strip {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      border-top: 1px solid var(--gold-dim);
      border-bottom: 1px solid var(--gold-dim);
      margin: 3rem 0;
    }
    .stat-cell {
      padding: 2.5rem 1.5rem;
      text-align: center;
      border-right: 1px solid var(--gold-dim);
    }
    .stat-cell:last-child { border-right: none; }
    .stat-figure {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 400;
      color: var(--gold);
      display: block;
      line-height: 1;
      margin-bottom: 0.5rem;
    }
    .stat-label {
      font-family: 'Inter', sans-serif;
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
    }
    @media (max-width: 768px) {
      .stats-strip { grid-template-columns: 1fr 1fr; }
      .stat-cell:nth-child(2) { border-right: none; }
      .stat-cell:nth-child(3) { border-top: 1px solid var(--gold-dim); }
    }

    /* ─── TIMELINE (vertical) ─── */
    .timeline {
      position: relative;
      padding-left: 2rem;
    }
    .timeline::before {
      content: '';
      position: absolute;
      left: 0; top: 0.6rem; bottom: 0;
      width: 1px;
      background: var(--gold-dim);
    }
    .timeline-item {
      position: relative;
      padding-bottom: 2.5rem;
    }
    .timeline-item::before {
      content: '';
      position: absolute;
      left: -2.3rem;
      top: 0.55rem;
      width: 7px; height: 7px;
      background: var(--gold);
      border-radius: 50%;
    }
    .timeline-year {
      font-family: 'Inter', sans-serif;
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.2em;
      color: var(--gold);
      margin-bottom: 0.25rem;
    }
    .timeline-body {
      font-family: 'Inter', sans-serif;
      font-size: 0.92rem;
      color: var(--text-body);
      line-height: 1.75;
    }
    .timeline-org {
      font-weight: 500;
      color: var(--text-primary);
    }

    /* ─── FIELD NOTE (unresolved / documented) ─── */
    .field-note {
      background: rgba(201,169,97,0.04);
      border: 1px solid rgba(201,169,97,0.12);
      padding: 1.5rem 2rem;
      margin-top: 2rem;
    }
    .field-note-label {
      font-family: 'Inter', sans-serif;
      font-size: 0.6rem;
      font-weight: 500;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 0.5rem;
    }
    .field-note-body {
      font-family: 'Inter', sans-serif;
      font-size: 0.85rem;
      color: var(--text-muted);
      font-style: italic;
      line-height: 1.7;
    }

    /* ─── ETHICAL FRAMEWORK ─── */
    .ethics-block {
      padding: 5rem 0;
      background: var(--surface);
    }
    .ethics-inner {
      max-width: 820px;
    }
    .ethics-body {
      font-size: 1.05rem;
      font-weight: 300;
      line-height: 1.9;
      color: var(--text-body);
      margin-bottom: 1.5rem;
    }

    /* ─── CLOSING INVITATION ─── */
    .closing-section {
      padding: 8rem 0 7rem;
      background: var(--obsidian);
      position: relative;
    }
    .closing-section::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 50% 60% at 50% 0%, rgba(201, 170, 97, 0.3) 0%, transparent 70%);
      pointer-events: none;
    }
    .closing-inner {
      position: relative; z-index: 1;
      max-width: 720px;
      margin: 0 auto;
      text-align: center;
    }
    .closing-headline {
      font-family: 'Cinzel Decorative', serif;
      font-size: clamp(1.3rem, 3vw, 2rem);
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.35;
      margin-bottom: 1.75rem;
    }
    .closing-body {
      font-family: 'Inter', sans-serif;
      font-size: 1.05rem;
      font-weight: 300;
      color: var(--text-body);
      line-height: 1.85;
      margin-bottom: 2.5rem;
    }
    .closing-cta {
      display: inline-block;
      font-family: 'Inter', sans-serif;
      font-size: 0.7rem;
      font-weight: 500;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--obsidian);
      background: var(--gold);
      padding: 1rem 2.5rem;
      text-decoration: none;
      transition: opacity 0.2s;
    }
    .closing-cta:hover { opacity: 0.85; }
    .closing-note {
      margin-top: 1.25rem;
      font-family: 'Inter', sans-serif;
      font-size: 0.72rem;
      color: var(--text-muted);
      letter-spacing: 0.08em;
    }
 /* Mobile section background overrides for practitioner.html */
  @media (max-width: 1024px) {
    /* The practitioner hero has a CSS radial-gradient background,
       no external image ::before. No image override needed.
       All practitioner visual alignment is in legaisee-luxury.css. */
 
    /* If you later add a hero background image, add its override here:
    .practitioner-hero::before {
      filter: brightness(0.40) blur(2px);
      opacity: 0.22;
    }
    */
  }
 
  /* Note: All visual alignment to site system is in legaisee-luxury.css.
     The standalone CSS on this page will be overridden by the luxury CSS.
     No further HTML changes are needed for visual consistency. */
 
    /* ─── FOOTER ─── */
    .site-footer {
      padding: 2.5rem 0;
      border-top: 1px solid rgba(201,169,97,0.1);
      background: var(--obsidian);
    }
    .footer-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .footer-text {
      font-family: 'Inter', sans-serif;
      font-size: 0.7rem;
      color: var(--text-muted);
      letter-spacing: 0.08em;
    }
    .footer-links {
      display: flex; gap: 2rem; list-style: none;
    }
    .footer-links a {
      font-family: 'Inter', sans-serif;
      font-size: 0.68rem;
      font-weight: 500;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--text-muted);
      text-decoration: none;
    }
    .footer-links a:hover { color: var(--gold); }

    /* ─── BODY COPY UTIL ─── */
    p { margin-bottom: 1.2rem; }
    p:last-child { margin-bottom: 0; }
    .text-gold { color: var(--gold); }
    .text-primary { color: var(--text-primary); }
  </style>

</head>

<body data-page="practitioner">

  <!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home"">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner"style="color: var(--gold)";>The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="registry">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home"style="color: var(--gold);">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner"style="color: var(--gold)";>The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>

=========================================================================================================

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="description" content="LEGAiSEE — Who We Serve. Texas Sized Businesses, generationally owned enterprises, and the $30M+ Giants of the San Antonio/Austin I-35 Corridor.">
  <title>Who We Serve — LEGAiSEE</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.23/dist/lenis.css">
    <link rel="stylesheet" href="legaisee.css">
  <style>
       <link rel="stylesheet" href="legaisee-luxury.css" />
    /* ── PAGE-SPECIFIC: SERVE.HTML ───────────────────────────────── */

    /* PAGE HERO */
    .serve-hero {
      position: relative;
      min-height: 90vh;
      display: flex;
      align-items: center;
      padding: 140px 90px 100px;
      overflow: hidden;
      background: var(--obsidian);
    }
    .serve-hero::before {
      content: '';
      position: absolute; inset: 0;
      background-image: url('http://www.legaisee.com/Images/AtelierObsidian.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed; /* mobile: scroll via CSS */
      opacity: 0.22;
      z-index: 0;
    }
    .serve-hero::after {
      content: '';
      position: absolute; inset: 0;
      background:
        linear-gradient(to right, rgba(5,5,5,0.92) 0%, rgba(5,5,5,0.55) 55%, rgba(5,5,5,0.80) 100%),
        linear-gradient(to bottom, rgba(5,5,5,0.55) 0%, transparent 30%, rgba(5,5,5,0.80) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .serve-hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      max-width: 1320px;
      margin: 0 auto;
      width: 100%;
    }

    /* CORRIDOR MAP — Visual I-35 representation */
    .corridor-visual {
      display: flex;
      flex-direction: column;
      gap: 0;
      position: relative;
    }
    .corridor-city {
      display: grid;
      grid-template-columns: 1fr 56px 1fr;
      align-items: center;
      gap: 0;
    }
    .corridor-city-name {
      font-family: var(--font-display);
      font-size: clamp(1.6rem, 3vw, 2.4rem);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--gold-light);
      padding: 32px 0;
    }
    .corridor-city-name.right { text-align: right; }
    .corridor-city-sub {
      font-family: var(--font-ui);
      font-size: 0.88rem;
      font-style: italic;
      color: var(--pewter);
      display: block;
      margin-top: 6px;
    }
    .corridor-spine {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
    }
    .corridor-dot {
      width: 14px; height: 14px;
      border-radius: 50%;
      border: 1px solid var(--gold);
      background: var(--obsidian);
      position: relative;
      z-index: 2;
      flex-shrink: 0;
    }
    .corridor-dot.active { background: rgba(201,169,97,0.2); box-shadow: 0 0 16px rgba(201,169,97,0.3); }
    .corridor-line {
      width: 1px;
      flex: 1;
      background: linear-gradient(to bottom, var(--gold-dim), rgba(201,169,97,0.2));
      min-height: 80px;
    }
    .corridor-mid {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;
      gap: 8px;
    }
    .corridor-mid-label {
      font-family: var(--font-ui);
      font-size: 0.72rem;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold-dim);
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      white-space: nowrap;
    }
    .corridor-badge {
      background: rgba(201,169,97,0.07);
      border: 1px solid rgba(201,169,97,0.20);
      padding: 10px 18px;
      font-family: var(--font-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--gold);
      white-space: nowrap;
    }

    /* CLIENT PROFILE CARDS — three archetypes */
    .archetype-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
      background: rgba(201,169,97,0.06);
      border: 1px solid rgba(201,169,97,0.10);
    }
    .archetype-card {
      background: var(--obsidian-light);
      padding: 56px 44px;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      gap: 20px;
      transition: all 0.5s var(--ease-silk);
    }
    .archetype-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .archetype-card:hover { background: var(--obsidian-mid); }
    .archetype-card:hover::before { opacity: 1; }
    .archetype-roman {
      font-family: var(--font-display);
      font-size: 4rem;
      color: rgba(201,169,97,0.08);
      line-height: 1;
      transition: color 0.4s ease;
    }
    .archetype-card:hover .archetype-roman { color: rgba(201,169,97,0.18); }
    .archetype-type {
      font-family: var(--font-display);
      font-size: clamp(1.1rem, 1.6vw, 1.35rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--gold-light);
      line-height: 1.2;
    }
    .archetype-threshold {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-family: var(--font-ui);
      font-size: 0.58rem;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--gold-dim);
      border: 1px solid rgba(201,169,97,0.18);
      padding: 6px 14px;
      align-self: flex-start;
    }
    .archetype-desc {
      font-family: var(--font-ui);
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.78;
    }
    .archetype-qualifiers {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 8px;
      padding-top: 20px;
      border-top: 1px solid rgba(255,255,255,0.04);
    }
    .archetype-qualifiers li {
      font-family: var(--font-ui);
      font-size: 0.95rem;
      color: var(--pewter);
      padding-left: 20px;
      position: relative;
      line-height: 1.6;
    }
    .archetype-qualifiers li::before {
      content: '◆';
      position: absolute;
      left: 0; top: 4px;
      color: var(--gold-dim);
      font-size: 0.5rem;
    }

    /* INDUSTRY GRID */
    .industry-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .industry-card {
      background: var(--obsidian-light);
      border: 1px solid rgba(201,169,97,0.08);
      padding: 36px 32px;
      position: relative;
      overflow: hidden;
      transition: all 0.4s var(--ease-silk);
    }
    .industry-card:hover {
      border-color: rgba(201,169,97,0.22);
      transform: translateY(-4px);
      box-shadow: var(--shadow-card);
    }
    .industry-card::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold-dim), transparent);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .industry-card:hover::after { opacity: 1; }
    .industry-icon {
      font-family: var(--font-display);
      font-size: 2.2rem;
      color: rgba(201,169,97,0.15);
      margin-bottom: 16px;
      display: block;
      line-height: 1;
    }
    .industry-name {
      font-family: var(--font-display);
      font-size: clamp(0.95rem, 1.3vw, 1.1rem);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--platinum);
      margin-bottom: 12px;
    }
    .industry-desc {
      font-family: var(--font-ui);
      font-size: 0.92rem;
      color: var(--pewter);
      line-height: 1.70;
    }
    .industry-drift {
      margin-top: 14px;
      font-family: var(--font-ui);
      font-size: 0.85rem;
      color: rgba(201,169,97,0.55);
      font-style: italic;
    }

    /* SELF-QUALIFIER — Am I a candidate? -->*/
    .qualifier-flow {
      display: flex;
      flex-direction: column;
      gap: 0;
      border: 1px solid rgba(201,169,97,0.10);
      overflow: hidden;
    }
    .qf-step {
      display: grid;
      grid-template-columns: 72px 1fr auto;
      gap: 0;
      border-bottom: 1px solid rgba(201,169,97,0.07);
      align-items: stretch;
      transition: background 0.3s ease;
    }
    .qf-step:last-child { border-bottom: none; }
    .qf-step:hover { background: rgba(201,169,97,0.02); }
    .qf-num {
      padding: 28px 20px;
      background: rgba(201,169,97,0.04);
      border-right: 1px solid rgba(201,169,97,0.08);
      font-family: var(--font-display);
      font-size: 1.1rem;
      color: var(--gold-dim);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .qf-question {
      padding: 28px 36px;
      font-family: var(--font-ui);
      font-size: 1.05rem;
      color: var(--silver);
      line-height: 1.65;
      display: flex;
      align-items: center;
    }
    .qf-answer {
      padding: 28px 32px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      border-left: 1px solid rgba(201,169,97,0.08);
      min-width: 140px;
    }
    .qf-yes {
      font-family: var(--font-ui);
      font-size: 0.58rem;
      font-weight: 600;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--gold);
      border: 1px solid var(--gold-dim);
      padding: 6px 14px;
    }
    .qf-partial {
      font-family: var(--font-ui);
      font-size: 0.58rem;
      font-weight: 600;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--pewter);
      border: 1px solid var(--graphite);
      padding: 6px 14px;
    }

    /* NOT FOR EVERYONE — exclusion box */
    .exclusion-box {
      background: var(--charcoal);
      border: 1px solid rgba(255,255,255,0.05);
      border-left: 3px solid rgba(106,106,106,0.3);
      padding: 48px 52px;
      position: relative;
    }
    .exclusion-box::before {
      content: 'NOT FOR';
      position: absolute;
      top: 22px; right: 28px;
      font-family: var(--font-display);
      font-size: 0.72rem;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: rgba(106,106,106,0.3);
    }

/* Mobile section background overrides for serve.html */
  @media (max-width: 1024px) {
    .serve-hero::before {
      filter: brightness(0.40) blur(2px);
      opacity: 0.24;
    }
    /* Section 1 inline bg (HeroLightVertical) */
    .lux-section [style*="HeroLightVertical"] {
      filter: brightness(0.35) blur(2px) !important;
    }
    /* Section 3 industries inline bg (AtelierObsidian) */
    .lux-section [style*="AtelierObsidian"] {
      filter: brightness(0.32) blur(3px) !important;
    }
    /* Closing CTA inline bg (CaseMask2) */
    .lux-section [style*="CaseMask2"] {
      filter: brightness(0.35) blur(3px) !important;
    }
  }
 
  /* Note: White section backgrounds (.section-block, .serve-capabilities etc.)
     are fixed entirely in legaisee-luxury.css — no HTML change needed. */
     
    @media (max-width: 1100px) {
      .serve-hero { padding: 140px 48px 80px; }
      .serve-hero-inner { grid-template-columns: 1fr; gap: 52px; }
      .archetype-grid { grid-template-columns: 1fr; }
      .industry-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
      .serve-hero { padding: 120px 28px 60px; min-height: auto; }
      .qf-step { grid-template-columns: 52px 1fr; }
      .qf-answer { display: none; }
      .industry-grid { grid-template-columns: 1fr; }
      .corridor-city { grid-template-columns: 1fr 40px 1fr; }
    }
  </style>
</head>

<body>

<!-- DESKTOP NAV -->
<nav class="site-nav" id="site-nav">
 
  <!-- Logo -->
  <div class="nav-logo-wrap">
    <a href="/index.html">
      <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    </a>
  </div>

  <!-- Desktop Links -->
  <div class="nav-links" id="nav-links">
    <a href="/index.html"        data-nav="home">Home</a>
    <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
    <a href="/method.html"       data-nav="method">The Method</a>
    <a href="/serve.html"        data-nav="serve"style="color: var(--gold);">Who We Serve</a>
    <a href="/architect.html"    data-nav="architect">The Architect</a>
    <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
    <a href="/commissions.html"  data-nav="commissions">Commissions</a>
    <a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>
  </div>
 
  <!-- Hamburger — visible only on mobile -->
  <button class="nav-hamburger" id="nav-hamburger" aria-label="Open navigation menu" aria-expanded="false">
    <span></span>
    <span></span>
    <span></span>
  </button>
 
</nav>
 
<!-- MOBILE DRAWER -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
  <a href="/index.html"        data-nav="home">Home</a>
  <a href="/archaeology.html"  data-nav="archaeology">The Archaeology</a>
  <a href="/method.html"       data-nav="method">The Method</a>
  <a href="/serve.html"        data-nav="serve"style="color: var(--gold);">Who We Serve</a>
  <a href="/architect.html"    data-nav="architect">The Architect</a>
  <a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
  <a href="/commissions.html"  data-nav="commissions">Commissions</a>
  <a href="/registry.html"     data-nav="registry">Enter the Registry</a>
</div>


=============================================================================================================

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
============================================================================================================================================

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

