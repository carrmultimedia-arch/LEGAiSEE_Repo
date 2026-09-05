<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="LEGAiSEE — Business Archaeology & Authority Systems. Forensic excavation of institutional memory for $30M+ enterprises in the San Antonio/Austin I-35 corridor.">
  <title>LEGAiSEE — Business Archaeology & Authority Systems</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="claude-style.css">


  <style>
    /* ── PAGE-SPECIFIC: INDEX.HTML ──────────────────────────────── */


    /* HERO — Full-screen vault entrance */
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
      background-image: url('http://www.legaisee.com/Images/HeroLightsWide.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
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
      font-size: 0.60rem;
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
      font-family: var(--font-body);
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
      font-size: 0.60rem;
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
      font-size: 0.55rem;
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
      background-attachment: fixed;
      opacity: 0.10;
      z-index: 0;
    }
    .velvet-content {
      position: relative;
      z-index: 1;
      max-width: 1320px;
      margin: 0 auto;
    }
    .opening-paragraph {
      font-family: var(--font-body);
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
      background-attachment: fixed;
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
      font-size: 0.55rem;
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
      font-family: var(--font-body);
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
      font-family: var(--font-body);
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
      font-family: var(--font-body);
      font-size: clamp(1.1rem, 1.9vw, 1.45rem);
      font-style: italic;
      color: var(--gold-bright);
      line-height: 1.88;
      margin-bottom: 36px;
    }
    .pledge-attribution {
      font-family: var(--font-ui);
      font-size: 0.62rem;
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
      font-size: 0.58rem;
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
      font-family: var(--font-body);
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
      background-attachment: fixed;
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
      font-family: var(--font-body);
      font-size: clamp(1.3rem, 2.4vw, 1.9rem);
      font-style: italic;
      color: var(--gold-bright);
      max-width: 780px;
      margin: 0 auto 52px;
      line-height: 1.85;
    }
  </style>
</head>


<body>


<!-- ═══════════════════════════════════════════════
     NAVIGATION
     ═══════════════════════════════════════════════ -->
<nav class="site-nav" id="site-nav">
  <div class="nav-logo-wrap">
    <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="nav-logo-img">
    <div class="nav-logo-text"></div>
  </div>


  <div class="nav-links" id="nav-links">
    <a href="index.html">Home</a>
    <a href="archaeology.html">The Archaeology</a>
    <a href="method.html">The Method</a>
    <a href="serve.html">Who We Serve</a>
    <a href="architect.html">The Architect</a>
    <a href="commissions.html">Commissions</a>
    <a href="registry.html" class="nav-cta">Enter the Registry</a>
  </div>


  <button class="nav-toggle" id="nav-toggle" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>




<!-- ═══════════════════════════════════════════════
     SECTION 1: HERO — The Vault Entrance
     Background: HeroLightsWide.png (parallax)
     ═══════════════════════════════════════════════ -->
<section class="hero-vault">


  <div class="hero-content">
    <div class="vault-seal-ring">
      <span class="vault-seal-inner">L</span>
    </div>


    <div class="hero-eyebrow">Business Archaeology &nbsp;·&nbsp; Authority Systems</div>


    <h1 class="hero-headline reveal">
      The Restoration of<br>
      <span class="gold-word">Asymmetric Authority</span>
    </h1>


    <div class="hero-divider"></div>


    <p class="hero-tagline reveal reveal-d1">
      Forensic excavation of the strategic structure that once made you unmistakable —
      and the disciplined reconstruction of that signal for the market that exists today.
    </p>


    <div class="btn-group reveal reveal-d2" style="justify-content: center;">
      <a href="registry.html" class="btn btn-gold">Enter the Registry</a>
      <a href="archaeology.html" class="btn btn-outline-gold">The Archaeology</a>
    </div>


    <div class="hero-meta reveal reveal-d3">
      <span>San Antonio</span>
      <span class="hero-meta-dot"></span>
      <span>Austin</span>
      <span class="hero-meta-dot"></span>
      <span>The I-35 Corridor</span>
      <span class="hero-meta-dot"></span>
      <span>By Invitation Only</span>
    </div>
  </div>


  <div class="scroll-hint">
    <span>Descend</span>
    <div class="scroll-line"></div>
  </div>


</section><!-- /hero-vault -->




<!-- ═══════════════════════════════════════════════
     SECTION 2: THE VELVET ROPE
     Speakeasy entry copy — the opening invitation
     Background: HeroLightsWide.png fades in (parallax)
     ═══════════════════════════════════════════════ -->
<section class="velvet-rope-section lux-section" style="background: var(--obsidian); padding-top: 140px; padding-bottom: 140px;">


  <div class="velvet-content">


    <div class="prestige-label reveal" style="justify-content: flex-start; margin-bottom: 56px;">
      The Private Record
    </div>


    <p class="opening-paragraph reveal" style="margin-bottom: 44px;">
      Sit down. Let the door close behind you. Pour a glass of something that took twenty years to reach its peak.
    </p>


    <p class="opening-paragraph reveal reveal-d1" style="color: var(--silver);">
      You and I are here because you have built an enterprise that has stood the test of time.
      Not a startup. Not a venture. A real business — one that has employed people, served markets,
      and accumulated the kind of history that most organizations never acquire.
    </p>


    <div style="max-width: 900px; margin: 64px 0 0;" class="reveal reveal-d2">
      <div class="signal-block">
        <div class="signal-label">The Condition</div>
        <p style="font-family: var(--font-body); font-size: clamp(1.1rem, 1.8vw, 1.45rem); font-style: italic; color: var(--gold-bright); line-height: 1.85;">
          And yet, somewhere along the way, the signal that once made you unmistakable began to fade.
          Not dramatically. Not catastrophically. But quietly. The kind of quiet that only reveals itself
          when you look back at what you used to be and realize you cannot quite name what changed.
        </p>
      </div>
    </div>


  </div>
</section><!-- /velvet-rope -->




<!-- ═══════════════════════════════════════════════
     AUTHORITY STRIP — Five key credentials
     ═══════════════════════════════════════════════ -->
<div class="authority-strip">
  <div class="authority-item reveal">
    <div class="authority-value">40+</div>
    <div class="authority-label">Channels Excavated</div>
  </div>
  <div class="authority-item reveal reveal-d1">
    <div class="authority-value">10</div>
    <div class="authority-label">Interlocking Frameworks</div>
  </div>
  <div class="authority-item reveal reveal-d2">
    <div class="authority-value">30</div>
    <div class="authority-label">Years of Signal Craft</div>
  </div>
  <div class="authority-item reveal reveal-d3">
    <div class="authority-value">3</div>
    <div class="authority-label">Clients at a Time</div>
  </div>
  <div class="authority-item reveal reveal-d4">
    <div class="authority-value">130+</div>
    <div class="authority-label">Years of History Mapped</div>
  </div>
</div><!-- /authority-strip -->




<!-- ═══════════════════════════════════════════════
     SECTION 3: THE RESTORATION THESIS
     What was lost — and why it matters
     Background: DigWfloor1.png (parallax reveal)
     ═══════════════════════════════════════════════ -->
<section class="lux-section thesis-reveal" style="padding-top: 160px; padding-bottom: 160px; background: var(--obsidian-light);">
  <div class="section-inner">


    <div class="asym-grid-a" style="align-items: start;">


      <!-- LEFT — The narrative -->
      <div>
        <div class="prestige-label reveal" style="justify-content: flex-start;">
          The Philosophy of Strategic Continuity
        </div>


        <h2 class="d-lg reveal" style="margin-bottom: 36px;">
          What Was Lost,<br>and Why It Matters
        </h2>


        <div class="divider-gold short reveal" style="margin-left: 0; margin-right: auto; margin-bottom: 44px;"></div>


        <p class="b-xl reveal" style="color: var(--platinum); margin-bottom: 28px;">
          Every enterprise that has operated for more than a decade carries within it the residue of a
          <strong class="text-gold">precise strategic structure</strong> — a configuration of messaging,
          positioning, and market presence that once produced what we call
          <strong class="text-gold">quiet, persistent recognition</strong>.
        </p>


        <p class="b-lg reveal reveal-d1" style="margin-bottom: 24px;">
          It was not loud. It was not trendy. It was simply effective in a way that compound interest is effective:
          slowly, reliably, and with <strong class="text-gold">unreplicable weight</strong>.
        </p>


        <p class="b-lg reveal reveal-d2" style="margin-bottom: 24px;">
          Then something happened. A generational shift in leadership. A pivot toward digital that discarded
          the analog wisdom. A rebrand that smoothed away the edges that made you distinct. A series of
          personnel changes that broke the chain of institutional memory. Or simply the slow erosion of
          attention — the <strong class="text-gold">drift</strong> that happens when no one is assigned
          to protect the narrative.
        </p>


        <p class="b-lg reveal reveal-d2" style="margin-bottom: 44px;">
          We call this <strong class="text-gold">Narrative Drift</strong>. It is not a marketing problem.
          It is a structural blind spot. And like all structural blind spots, it will
          <strong class="text-gold">leak revenue</strong> and
          <strong class="text-gold">erode your pricing power</strong> until someone with forensic
          discipline maps the gap and closes it.
        </p>


        <div class="signal-block reveal reveal-d3">
          <div class="signal-label">The Lindy Effect</div>
          <p style="font-family: var(--font-body); font-size: 1.12rem; font-style: italic; color: var(--gold-bright); line-height: 1.82;">
            What has survived longest is most likely to survive into the future. Your oldest, most durable
            competitive advantages are not obsolete — they are <strong>quietly forgotten</strong>.
            This is an archaeological dig worth millions.
          </p>
        </div>
      </div>


      <!-- RIGHT — Gemstone image + card (asymmetric, intentionally misaligned) -->
      <div style="padding-top: 80px;">


        <!-- GEMSTONE PLACEHOLDER: Stage 0 — Natural Habitat -->
        <div class="gem-frame reveal reveal-right" style="margin-bottom: 0; aspect-ratio: 3/4; position: relative;">
          <div class="gem-placeholder-box" style="min-height: 460px;">
            <span class="gem-catalog">CAT-HAB-001</span>
            <div class="gem-stage-name">Natural Habitat</div>
            <div class="gem-stage-desc">Where the stone sleeps before discovery — the geological formation of your earliest competitive advantage</div>
          </div>
          <div class="gem-caption-bar">
            <div class="gem-caption-title">Stage 0 — Formation</div>
            <div class="gem-caption-sub">The gem in earth · uncut · undiscovered · irreplaceable</div>
          </div>
        </div>


        <div class="museum-card reveal reveal-d1" style="margin-top: -32px; margin-left: 32px; position: relative; z-index: 2;">
          <div class="micro-label" style="margin-bottom: 16px;">The Diagnosis</div>
          <ul class="feature-list">
            <li>Quiet, persistent recognition — lost</li>
            <li>Absolute clarity it once possessed — faded</li>
            <li>Decisions landed cleaner back then</li>
            <li>Unreplicable weight — now invisible</li>
            <li>Narrative Drift — structural, not tactical</li>
            <li>Legacy files disappeared</li>
            <li>Texas Sized Business · Texas Sized blind spots</li>
          </ul>
        </div>


      </div>
    </div><!-- /asym-grid-a -->


  </div>
</section><!-- /thesis -->




<!-- ═══════════════════════════════════════════════
     SECTION 4: BUSINESS ARCHAEOLOGY — What We Do
     ═══════════════════════════════════════════════ -->
<section class="lux-section" style="background: var(--obsidian); padding-top: 160px; padding-bottom: 100px;">
  <div class="section-inner">


    <div class="two-col" style="align-items: center; gap: 90px;">


      <!-- LEFT: Gemstone Stage 1 + Stage 2 stacked -->
      <div style="display: flex; flex-direction: column; gap: 20px;">


        <!-- GEMSTONE PLACEHOLDER: Stage 1 — Raw Stone -->
        <div class="gem-frame reveal reveal-left" style="aspect-ratio: 4/3; position: relative;">
          <div class="gem-placeholder-box" style="min-height: 280px;">
            <span class="gem-catalog">CAT-RAW-001</span>
            <div class="gem-stage-name">Raw Stone from Earth</div>
            <div class="gem-stage-desc">The uncut mineral specimen — pulled from the earth in its natural state</div>
          </div>
          <div class="gem-caption-bar">
            <div class="gem-caption-title">Stage 1 — Discovery</div>
            <div class="gem-caption-sub">Recovered · Classified · Catalogued</div>
          </div>
        </div>


        <!-- GEMSTONE PLACEHOLDER: Stage 2 — Cut / Shaped -->
        <div class="gem-frame reveal reveal-d1 reveal-left" style="aspect-ratio: 16/9; position: relative;">
          <div class="gem-placeholder-box" style="min-height: 200px;">
            <span class="gem-catalog">CAT-CUT-001</span>
            <div class="gem-stage-name">Cut &amp; Shaped</div>
            <div class="gem-stage-desc">The lapidary phase — raw findings faceted into strategic instruments</div>
          </div>
          <div class="gem-caption-bar">
            <div class="gem-caption-title">Stage 2 — Refinement</div>
            <div class="gem-caption-sub">Faceted · Verified · Precision-formed</div>
          </div>
        </div>


      </div>


      <!-- RIGHT: The Business Archaeology copy -->
      <div>
        <div class="prestige-label reveal" style="justify-content: flex-start;">
          The Practice
        </div>


        <h2 class="d-lg reveal" style="margin-bottom: 36px;">
          We Do Not<br>"Create" Marketing Here
        </h2>


        <div class="divider-gold short reveal" style="margin-left: 0; margin-right: auto; margin-bottom: 44px;"></div>


        <p class="b-xl reveal" style="color: var(--platinum); margin-bottom: 28px;">
          We practice <strong class="text-gold">Business Archaeology</strong> — the forensic excavation
          of the precise strategic structure that once produced your most profitable era, and the
          disciplined reconstruction of that signal for the present market.
        </p>


        <p class="b-lg reveal reveal-d1" style="margin-bottom: 24px;">
          Scaling an unstable narrative only accelerates failure.
          We do not build on sand. <strong class="text-gold">We bedrock.</strong>
        </p>


        <p class="b-lg reveal reveal-d2" style="margin-bottom: 44px;">
          The Architect does not sell. The Architect excavates. The Architect listens to the silence
          between what you say and what your market hears. The Architect maps the
          <strong class="text-gold">structural blind spots</strong> that your competitors are exploiting.
          The Architect builds systems that produce <strong class="text-gold">Signal</strong> — the kind
          of signal that does not require explanation because it carries its own
          <strong class="text-gold">Unavoidable Logic</strong>.
        </p>


        <div class="signal-block reveal reveal-d3">
          <div class="signal-label">The Operating Principle</div>
          <p style="font-family: var(--font-body); font-size: 1.18rem; font-style: italic; color: var(--gold-bright); line-height: 1.82;">
            "We do not dig where there is no stone. We do not promise what we cannot prove.
            And we do not build on anything less than bedrock."
          </p>
        </div>


        <div class="btn-group" style="margin-top: 48px;">
          <a href="archaeology.html" class="btn btn-gold reveal reveal-d4">Explore the Archaeology</a>
          <a href="architect.html" class="btn btn-outline-gold reveal reveal-d4">Meet the Architect</a>
        </div>
      </div>


    </div><!-- /two-col -->


  </div>
</section><!-- /archaeology intro -->




<!-- ═══════════════════════════════════════════════
     TICKER — Archive Scroll
     ═══════════════════════════════════════════════ -->
<div class="ticker-wrap">
  <div class="ticker-track">
    <span class="ticker-item"><span class="ticker-gold">Business Archaeology</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Authority Systems<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Narrative Drift</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Forensic Excavation<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Signal Restoration</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Institutional Memory<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">40+ Channels Mapped</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Lapidary Phase<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Unavoidable Logic</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">The Bedrock Pledge<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">The I-35 Corridor</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Asymmetric Authority<span class="ticker-dot"></span></span>
    <!-- Duplicate for seamless loop -->
    <span class="ticker-item"><span class="ticker-gold">Business Archaeology</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Authority Systems<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Narrative Drift</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Forensic Excavation<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Signal Restoration</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Institutional Memory<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">40+ Channels Mapped</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Lapidary Phase<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">Unavoidable Logic</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">The Bedrock Pledge<span class="ticker-dot"></span></span>
    <span class="ticker-item"><span class="ticker-gold">The I-35 Corridor</span><span class="ticker-dot"></span></span>
    <span class="ticker-item">Asymmetric Authority<span class="ticker-dot"></span></span>
  </div>
</div>




<!-- ═══════════════════════════════════════════════
     SECTION 5: THE GEMSTONE JOURNEY
     Five stages of transformation
     Background: Library2Diamond.png (parallax)
     ═══════════════════════════════════════════════ -->
<section class="lux-section" style="background: var(--obsidian-mid); padding-top: 140px; padding-bottom: 80px; position: relative; overflow: hidden;">
  <div style="position: absolute; inset: 0; background-image: url('http://www.legaisee.com/Images/Library2Diamond.png'); background-size: cover; background-position: center; background-attachment: fixed; opacity: 0.09; z-index: 0;"></div>


  <div class="section-inner" style="position: relative; z-index: 1;">


    <div style="text-align: center; max-width: 780px; margin: 0 auto 80px;">
      <div class="prestige-label reveal" style="justify-content: center;">The Transformation Metaphor</div>
      <h2 class="d-lg reveal" style="margin-bottom: 28px;">Five Stages of Restoration</h2>
      <p class="b-lg reveal reveal-d1">
        Every engagement follows the natural arc of the gemologist's art — from the stone in the earth
        to the specimen under museum light. What we excavate from your history follows the same journey.
      </p>
    </div>


    <!-- Five-stage journey: placeholder images to be swapped with metaphor stone photos -->
    <div class="gem-journey-grid reveal reveal-d2">


      <!-- Stage 0: Habitat -->
      <div class="gem-journey-card">
        <div class="gem-placeholder-box" style="min-height: 480px; background: linear-gradient(180deg, #0d1a0a 0%, #050505 100%);">
          <span class="gem-catalog">CAT-HAB-00</span>
          <div class="gem-stage-name" style="color: var(--pewter);">Photo Here</div>
        </div>
        <div class="gem-journey-overlay">
          <div class="gem-journey-number">Stage 00</div>
          <div class="gem-journey-stage">Natural Habitat</div>
          <div class="gem-journey-desc">The gem in earth — your institutional memory in its natural, unexcavated state</div>
        </div>
      </div>


      <!-- Stage 1: Raw / Discovery -->
      <div class="gem-journey-card">
        <div class="gem-placeholder-box" style="min-height: 480px; background: linear-gradient(180deg, #1a1005 0%, #050505 100%);">
          <span class="gem-catalog">CAT-RAW-00</span>
          <div class="gem-stage-name" style="color: var(--pewter);">Photo Here</div>
        </div>
        <div class="gem-journey-overlay">
          <div class="gem-journey-number">Stage 01</div>
          <div class="gem-journey-stage">Raw Stone</div>
          <div class="gem-journey-desc">Excavated from your archives — uncut, unpolished, and potentially priceless</div>
        </div>
      </div>


      <!-- Stage 2: Cut / Lapidary -->
      <div class="gem-journey-card">
        <div class="gem-placeholder-box" style="min-height: 480px; background: linear-gradient(180deg, #0a0a1a 0%, #050505 100%);">
          <span class="gem-catalog">CAT-CUT-00</span>
          <div class="gem-stage-name" style="color: var(--pewter);">Photo Here</div>
        </div>
        <div class="gem-journey-overlay">
          <div class="gem-journey-number">Stage 02</div>
          <div class="gem-journey-stage">Cut &amp; Shaped</div>
          <div class="gem-journey-desc">The Lapidary phase — raw findings faceted into strategic instruments of precision</div>
        </div>
      </div>


      <!-- Stage 3: Mounted -->
      <div class="gem-journey-card">
        <div class="gem-placeholder-box" style="min-height: 480px; background: linear-gradient(180deg, #1a1200 0%, #050505 100%);">
          <span class="gem-catalog">CAT-MNT-00</span>
          <div class="gem-stage-name" style="color: var(--pewter);">Photo Here</div>
        </div>
        <div class="gem-journey-overlay">
          <div class="gem-journey-number">Stage 03</div>
          <div class="gem-journey-stage">Mounted</div>
          <div class="gem-journey-desc">Set in the squircle case of authority — your signal mounted for deployment</div>
        </div>
      </div>


      <!-- Stage 4: Display -->
      <div class="gem-journey-card">
        <div class="gem-placeholder-box" style="min-height: 480px; background: linear-gradient(180deg, #0a0a0a 0%, #050505 100%);">
          <span class="gem-catalog">CAT-DSP-00</span>
          <div class="gem-stage-name" style="color: var(--pewter);">Photo Here</div>
        </div>
        <div class="gem-journey-overlay">
          <div class="gem-journey-number">Stage 04</div>
          <div class="gem-journey-stage">Museum Display</div>
          <div class="gem-journey-desc">Presented under museum light — your restored authority, undeniable and visible</div>
        </div>
      </div>


    </div><!-- /gem-journey-grid -->


  </div>
</section><!-- /gem journey -->




<!-- ═══════════════════════════════════════════════
     SECTION 6: THE BEDROCK PLEDGE
     Three pillars — foundational commitments
     ═══════════════════════════════════════════════ -->
<section class="lux-section" style="background: var(--obsidian); padding-top: 140px; padding-bottom: 140px;">
  <div class="section-inner">


    <div style="text-align: center; max-width: 820px; margin: 0 auto 80px;">
      <div class="prestige-label reveal" style="justify-content: center;">The Foundation</div>
      <h2 class="d-lg reveal" style="margin-bottom: 24px;">The Bedrock of Forensic Truth</h2>
      <p class="b-lg reveal reveal-d1">
        Before any excavation begins, we establish the ground upon which all findings rest.
        These are not preferences. These are the non-negotiable pillars of every engagement.
      </p>
    </div>


    <!-- Three pillars — classic 3-column with slight center offset -->
    <div class="bedrock-grid three-col" style="margin-bottom: 80px;">


      <div class="museum-card reveal">
        <div class="pillar-icon">I</div>
        <div class="pillar-title">Every Word Is Sacred</div>
        <div class="pillar-desc">
          No copy is generated. No claims are invented. Every word that appears in your restoration
          is either excavated from your own historical record or synthesized through rigorous
          triangulation from verified sources. We do not "find" information; we grade it.
        </div>
      </div>


      <div class="museum-card reveal reveal-d2" style="margin-top: 32px;">
        <div class="pillar-icon">II</div>
        <div class="pillar-title">The 3-Source Rule</div>
        <div class="pillar-desc">
          No significant claim enters your report without a minimum of two independent sources,
          ideally three or more converging. Tier 1 sources — contemporaneous documents, financial
          records, third-party verification — carry the highest confidence. We label everything else.
        </div>
      </div>


      <div class="museum-card reveal reveal-d3">
        <div class="pillar-icon">III</div>
        <div class="pillar-title">Continuous Verification</div>
        <div class="pillar-desc">
          The excavation does not end at delivery. New artifacts emerge. Old sources are challenged.
          Our Continuous Verification Model allows for addendums, revisions, and the graceful
          incorporation of new evidence without compromising what has already been established.
        </div>
      </div>


    </div><!-- /bedrock-grid -->


    <!-- The Pledge Statement — centered prestige box -->
    <div class="pledge-box reveal">
      <p class="pledge-text">
        "We do not 'create' marketing here. We practice Business Archaeology. The forensic excavation
        of what once worked, the disciplined documentation of why it worked, and the precise
        reconstruction of that signal for the market that exists today — not the market you wish existed."
      </p>
      <div class="divider-gold short" style="margin: 0 auto 28px;"></div>
      <div class="pledge-attribution">The Bedrock Pledge — Binding on Every Engagement</div>
    </div>


  </div>
</section><!-- /bedrock -->




<!-- ═══════════════════════════════════════════════
     SECTION 7: TEN FRAMEWORKS OVERVIEW
     Background: LapidaryVerticleBlue.png (parallax)
     ═══════════════════════════════════════════════ -->
<section class="lux-section" style="background: var(--obsidian-light); padding-top: 140px; padding-bottom: 100px; position: relative; overflow: hidden;">
  <div style="position: absolute; inset: 0; background-image: url('http://www.legaisee.com/Images/LapidaryVerticleBlue.png'); background-size: cover; background-position: center; background-attachment: fixed; opacity: 0.11; z-index: 0;"></div>


  <div class="section-inner" style="position: relative; z-index: 1;">


    <div style="text-align: center; max-width: 820px; margin: 0 auto 80px;">
      <div class="prestige-label reveal" style="justify-content: center;">The Methodology</div>
      <h2 class="d-lg reveal" style="margin-bottom: 24px;">
        The Ten Interlocking Frameworks<br>of Reconstruction
      </h2>
      <p class="b-lg reveal reveal-d1">
        No single lens is sufficient to see what has been lost. We deploy ten distinct frameworks,
        each examining your enterprise from a different angle, each cross-referencing the others
        until the full picture emerges from the noise.
      </p>
    </div>


    <!-- Five-column framework tile grid -->
    <div class="five-col reveal reveal-d2" style="margin-bottom: 80px;">
      <div class="framework-tile">
        <div class="framework-roman">I</div>
        <div class="framework-name">40+ Channel Taxonomy</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">II</div>
        <div class="framework-name">Hierarchy of Truth</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">III</div>
        <div class="framework-name">Triangulation Protocol</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">IV</div>
        <div class="framework-name">Eight Classes of Evidence</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">V</div>
        <div class="framework-name">8-Dimension Voice Profile</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">VI</div>
        <div class="framework-name">ROI Trigger Mapping</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">VII</div>
        <div class="framework-name">Competitive Asymmetry</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">VIII</div>
        <div class="framework-name">Private Archaeology Protocol</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">IX</div>
        <div class="framework-name">Master Operations Doctrine</div>
      </div>
      <div class="framework-tile">
        <div class="framework-roman">X</div>
        <div class="framework-name">The CAMERA Authority Framework</div>
      </div>
    </div><!-- /five-col -->


    <!-- Framework preview — text + gemstone image -->
    <div class="two-col two-col-4060 reveal" style="align-items: center; gap: 72px;">


      <!-- GEMSTONE PLACEHOLDER: Stage 2 — The Cut Stone for methodology -->
      <div>
        <div class="gem-frame" style="aspect-ratio: 4/5; position: relative;">
          <div class="gem-placeholder-box" style="min-height: 420px;">
            <span class="gem-catalog">CAT-CUT-002</span>
            <div class="gem-stage-name">Cut Stone</div>
            <div class="gem-stage-desc">The Lapidary process — where raw findings are faceted into strategic instruments of precision and clarity</div>
          </div>
          <div class="gem-caption-bar">
            <div class="gem-caption-title">Stage 2 — The Lapidary</div>
            <div class="gem-caption-sub">Ten lenses. One truth.</div>
          </div>
        </div>
      </div>


      <!-- Framework prose -->
      <div>
        <p class="b-lg reveal-d1" style="margin-bottom: 28px;">
          The work unfolds in a natural order, for every attempt to shortcut this sequence leads to the
          same failure. First, we map the terrain. Then we excavate the artifacts. Then we classify,
          verify, and triangulate. Only then do we begin the work of reconstruction — the
          <strong class="text-gold">Lapidary phase</strong>, where raw findings are cut and shaped
          into strategic instruments.
        </p>


        <p class="b-lg reveal-d2" style="margin-bottom: 28px;">
          Look through the lens of <strong class="text-gold">Competitive Asymmetry</strong> and you
          will see not merely what your competitors are doing, but what they have forgotten — the
          abandoned tactics that once built their market position, now left dormant and available
          for reclamation.
        </p>


        <p class="b-lg reveal-d3" style="margin-bottom: 44px;">
          Look through the lens of the <strong class="text-gold">Private Archaeology Protocol</strong>
          and you will see the human artifacts — the memories, the stories, the oral histories — that
          no database can capture but that no accurate reconstruction can afford to ignore.
        </p>


        <a href="method.html" class="btn btn-outline-gold reveal reveal-d4">
          Study the Full Methodology
        </a>
      </div>


    </div><!-- /two-col preview -->


  </div>
</section><!-- /frameworks -->




<!-- ═══════════════════════════════════════════════
     GEOGRAPHY STRIP — The Corridor Context
     ═══════════════════════════════════════════════ -->
<div class="geography-strip">
  <div class="geography-inner">
    <div class="geography-label">Service Territory</div>
    <div class="geography-divider"></div>
    <div class="geography-text">
      San Antonio · Austin · The I-35 Corridor
      <em>Serving enterprises with 5–10+ years of operating history, generationally owned businesses,
      and the $30M+ giants who built this corridor</em>
    </div>
    <div class="geography-divider"></div>
    <a href="serve.html" class="btn btn-outline-gold" style="flex-shrink: 0; font-size: 0.58rem; padding: 12px 24px;">
      Who We Serve
    </a>
  </div>
</div>




<!-- ═══════════════════════════════════════════════
     SECTION 8: GEM MOUNT + DISPLAY
     Squircle case — the mounted specimen
     ═══════════════════════════════════════════════ -->
<section class="lux-section" style="background: var(--obsidian); padding-top: 140px; padding-bottom: 100px;">
  <div class="section-inner">


    <div class="asym-grid-b" style="align-items: center; gap: 80px;">


      <!-- LEFT: Copy -->
      <div>
        <div class="prestige-label reveal" style="justify-content: flex-start;">
          The Mounted Specimen
        </div>


        <h2 class="d-lg reveal" style="margin-bottom: 36px;">
          The Signal,<br>Restored
        </h2>


        <div class="divider-gold short reveal" style="margin-left: 0; margin-right: auto; margin-bottom: 44px;"></div>


        <p class="b-xl reveal" style="color: var(--platinum); margin-bottom: 28px;">
          These ten frameworks interlock. They cross-reference. They create a web of verification
          so dense that by the time we present our findings, there is no room for doubt. Only clarity.
          Only the <strong class="text-gold">absolute clarity it once possessed</strong>.
          Only the signal, restored.
        </p>


        <p class="b-lg reveal reveal-d1" style="margin-bottom: 24px;">
          You will not find case studies on a public website. You will not find a portfolio page.
          The work is private. The results are documented in boardrooms, not blog posts.
          The only evidence that exists is the testimony of those who have sat where you are sitting now.
        </p>


        <p class="b-lg reveal reveal-d1" style="margin-bottom: 44px;">
          And who will tell you, if you ask them, that what was restored was not merely a marketing
          strategy. It was the <strong class="text-gold">absolute clarity it once possessed</strong>.
          It was the reason they built the company in the first place.
        </p>


        <div class="btn-group">
          <a href="commissions.html" class="btn btn-gold reveal reveal-d2">View Commissions</a>
          <a href="architect.html" class="btn btn-outline-gold reveal reveal-d2">The Architect</a>
        </div>
      </div>


      <!-- RIGHT: Mounted gem placeholder — squircle case style -->
      <div class="reveal reveal-right" style="display: flex; flex-direction: column; gap: 0;">
        <div class="gem-frame" style="position: relative; aspect-ratio: 1; border-radius: 28px; overflow: hidden;">
          <div class="gem-placeholder-box" style="min-height: 440px; border-radius: 28px; border: none;">
            <span class="gem-catalog">CAT-MNT-002</span>
            <div class="gem-stage-name">Mounted Specimen</div>
            <div class="gem-stage-desc">Set in precious metal case — squircle form similar to Apple Watch face shape</div>
          </div>
          <div class="gem-caption-bar">
            <div class="gem-caption-title">Stage 3 — The Setting</div>
            <div class="gem-caption-sub">Authority secured in its case · ready for public view</div>
          </div>
        </div>


        <div class="speakeasy-frame reveal reveal-d1" style="padding: 28px 32px; margin-top: 16px;">
          <p style="font-family: var(--font-body); font-size: 1rem; font-style: italic; color: var(--silver); line-height: 1.75; position: relative; z-index: 1;">
            The work is private. The results are documented in boardrooms, not blog posts.
          </p>
          <div class="micro-label" style="margin-top: 14px; position: relative; z-index: 1;">
            Private Archaeology Protocol · Confidential by Design
          </div>
        </div>
      </div>


    </div><!-- /asym-grid-b -->


  </div>
</section><!-- /mounted -->




<!-- ═══════════════════════════════════════════════
     SECTION 9: FINAL CTA — The Invitation
     Background: PolishCaseMask.png (parallax)
     ═══════════════════════════════════════════════ -->
<section class="final-cta lux-section" style="padding-top: 160px; padding-bottom: 160px;">
  <div style="max-width: 860px; margin: 0 auto;">


    <div class="prestige-label reveal" style="justify-content: center; margin-bottom: 48px;">
      The Private Registry
    </div>


    <p class="final-cta-quote reveal reveal-d1">
      "There is a version of your business that worked better than this one.
      It is not gone. It is buried. And we know exactly where to dig."
    </p>


    <!-- Museum Display placeholder — the final gem -->
    <div class="gem-frame reveal reveal-d2" style="max-width: 560px; margin: 0 auto 60px; aspect-ratio: 16/9; position: relative;">
      <div class="gem-placeholder-box" style="min-height: 280px;">
        <span class="gem-catalog">CAT-DSP-001</span>
        <div class="gem-stage-name">Museum Display</div>
        <div class="gem-stage-desc">Prestige museum lighting · your restored authority presented for public recognition</div>
      </div>
      <div class="gem-caption-bar">
        <div class="gem-caption-title">Stage 4 — The Exhibition</div>
        <div class="gem-caption-sub">Authority · Restored · Undeniable</div>
      </div>
    </div>


    <div class="btn-group reveal reveal-d3" style="justify-content: center; margin-bottom: 48px;">
      <a href="registry.html" class="btn btn-gold">Enter the Private Registry</a>
      <a href="commissions.html" class="btn btn-outline-gold">View Commissions</a>
    </div>


    <div class="gate-seal reveal reveal-d4" style="margin: 0 auto; display: inline-flex;">
      <span class="seal-line">Invitation Only</span>
      <span class="seal-line">No Public Registry</span>
      <span class="seal-line">San Antonio · Austin · I-35 Corridor</span>
    </div>


  </div>
</section><!-- /final-cta -->




<!-- ═══════════════════════════════════════════════
     FOOTER
     ═══════════════════════════════════════════════ -->
<footer class="site-footer">
  <div class="footer-grid">


    <!-- Brand Column -->
    <div>
      <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 4px;">
        <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" style="height: 32px; width: auto;">
        <div style="font-family: var(--font-display); font-size: 0.78rem; letter-spacing: 0.26em; text-transform: uppercase; color: var(--gold);"></div>
      </div>
      <p class="footer-brand-tagline">
        Business Archaeology &amp; Authority Systems.<br>
        We excavate the signal. We restore the clarity.<br>
        We do not build on sand. We bedrock.
      </p>
      <div class="micro-label">San Antonio · Austin · The I-35 Corridor</div>
    </div>


    <!-- Navigation Column -->
    <div>
      <div class="footer-col-title">The Practice</div>
      <ul class="footer-links">
        <li><a href="archaeology.html">The Archaeology</a></li>
        <li><a href="method.html">The Ten Frameworks</a></li>
        <li><a href="serve.html">Who We Serve</a></li>
        <li><a href="architect.html">The Architect</a></li>
      </ul>
    </div>


    <!-- Services Column -->
    <div>
      <div class="footer-col-title">Commissions</div>
      <ul class="footer-links">
        <li><a href="commissions.html">The Excavation</a></li>
        <li><a href="commissions.html">Authority Systems</a></li>
        <li><a href="commissions.html">The Bedrock Pledge</a></li>
        <li><a href="commissions.html">Access Tiers</a></li>
      </ul>
    </div>


    <!-- Registry Column -->
    <div>
      <div class="footer-col-title">The Registry</div>
      <ul class="footer-links">
        <li><a href="registry.html">Request Entry</a></li>
        <li><a href="registry.html">Confidentiality Protocol</a></li>
        <li><a href="registry.html">Current Availability</a></li>
      </ul>
      <div class="gate-seal" style="display: inline-flex; margin-top: 28px; padding: 16px 24px;">
        <span class="seal-line">3 Clients Maximum</span>
        <span class="seal-line">By Appointment Only</span>
      </div>
    </div>


  </div><!-- /footer-grid -->


  <div class="footer-bottom">
    <div class="footer-copy">
      © LEGAiSEE · Business Archaeology &amp; Authority Systems · All Rights Reserved
    </div>
    <div class="footer-seal">
      The Signal, Restored
    </div>
  </div>


</footer><!-- /site-footer -->




<!-- ═══════════════════════════════════════════════
     JAVASCRIPT
     ═══════════════════════════════════════════════ -->
<script>
  /* ── Scroll reveal ─────────────────────────────── */
  (function () {
    const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.10,
      rootMargin: '0px 0px -44px 0px'
    });
    reveals.forEach(el => observer.observe(el));
  })();


  /* ── Nav scroll behavior ────────────────────────── */
  (function () {
    const nav = document.getElementById('site-nav');
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          nav.classList.toggle('scrolled', window.scrollY > 60);
          ticking = false;
        });
        ticking = true;
      }
    });
  })();


  /* ── Mobile nav toggle ─────────────────────────── */
  (function () {
    const toggle = document.getElementById('nav-toggle');
    const links  = document.getElementById('nav-links');
    if (!toggle || !links) return;
    toggle.addEventListener('click', () => {
      links.classList.toggle('open');
      document.body.style.overflow = links.classList.contains('open') ? 'hidden' : '';
    });
    links.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        links.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  })();


  /* ── FAQ accordion (reusable across all pages) ─── */
  document.querySelectorAll('.faq-item').forEach(item => {
    const q = item.querySelector('.faq-q');
    if (!q) return;
    q.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(o => o.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    });
  });


  /* ── Subtle parallax tilt on gem frames (desktop only) ─ */
  if (window.innerWidth > 1024) {
    document.querySelectorAll('.gem-frame, .museum-card').forEach(el => {
      el.addEventListener('mousemove', (e) => {
        const rect = el.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width - 0.5) * 6;
        const y = ((e.clientY - rect.top)  / rect.height - 0.5) * 6;
        el.style.transform = `perspective(800px) rotateY(${x}deg) rotateX(${-y}deg) translateY(-4px)`;
      });
      el.addEventListener('mouseleave', () => {
        el.style.transform = '';
      });
    });
  }
</script>


</body>
</html>

