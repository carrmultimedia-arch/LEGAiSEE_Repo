<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>John Carr · Career Portfolio</title>

  <!-- Fonts -->

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- Config (paste your URLs in here) -->

  <script src="career-config.js"></script>

  <style>
    /* ═══════════════════════════════════════════════════════
       TOKENS
    ═══════════════════════════════════════════════════════ */
    :root {
      --ob:          #050505;
      --ob-1:        #0d0d0d;
      --ob-2:        #111111;
      --ob-3:        #181818;
      --gold:        #C9A961;
      --gold-hi:     #E2C27A;
      --gold-lo:     #8A6E3A;
      --pearl:       #F0EAD8;
      --mist:        rgba(201,169,97,0.08);
      --mist-2:      rgba(201,169,97,0.15);
      --seam-gold:   rgba(201,169,97,0.22);

      --f-display:   'Cinzel', serif;
      --f-body:      'Cormorant Garamond', serif;
      --f-ui:        'Inter', sans-serif;

      --max:         1280px;
      --ease-gold:   cubic-bezier(0.22, 0.61, 0.36, 1);
    }

    /* ═══════════════════════════════════════════════════════
       RESET / BASE
    ═══════════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html {
      scroll-behavior: smooth;
      -webkit-font-smoothing: antialiased;
    }

    body {
      background: var(--ob);
      color: var(--pearl);
      font-family: var(--f-body);
      font-size: 18px;
      line-height: 1.65;
      overflow-x: hidden;
    }

    a { color: var(--gold); text-decoration: none; }
    a:hover { color: var(--gold-hi); }

    img { display: block; max-width: 100%; }

    /* ═══════════════════════════════════════════════════════
       NAV
    ═══════════════════════════════════════════════════════ */
    .site-nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 900;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2.5rem;
      height: 64px;
      background: rgba(5,5,5,0.92);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--seam-gold);
    }

    .nav-brand {
      font-family: var(--f-display);
      font-size: 0.85rem;
      letter-spacing: 0.18em;
      color: var(--gold);
      text-transform: uppercase;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a {
      font-family: var(--f-ui);
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--pearl);
      opacity: 0.7;
      transition: opacity 0.2s, color 0.2s;
    }

    .nav-links a:hover { opacity: 1; color: var(--gold); }

    .nav-cta {
      font-family: var(--f-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--ob) !important;
      background: var(--gold);
      padding: 0.45rem 1.2rem;
      border-radius: 2px;
      opacity: 1 !important;
      transition: background 0.2s;
    }

    .nav-cta:hover { background: var(--gold-hi) !important; color: var(--ob) !important; }

    /* ═══════════════════════════════════════════════════════
       HERO
    ═══════════════════════════════════════════════════════ */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 8rem 2rem 5rem;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 55% at 50% 0%, rgba(201,169,97,0.13) 0%, transparent 70%),
        radial-gradient(ellipse 40% 40% at 80% 80%, rgba(201,169,97,0.05) 0%, transparent 60%);
      pointer-events: none;
    }

    .hero-eyebrow {
      font-family: var(--f-ui);
      font-size: 0.7rem;
      font-weight: 500;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.5rem;
      opacity: 0.85;
    }

    .hero-name {
      font-family: var(--f-display);
      font-size: clamp(2.8rem, 7vw, 6rem);
      font-weight: 400;
      letter-spacing: 0.06em;
      line-height: 1.05;
      color: var(--pearl);
      margin-bottom: 0.6rem;
    }

    .hero-title {
      font-family: var(--f-body);
      font-size: clamp(1.1rem, 2.5vw, 1.5rem);
      font-weight: 300;
      font-style: italic;
      color: var(--gold);
      letter-spacing: 0.04em;
      margin-bottom: 1.8rem;
    }

    .hero-rule {
      width: 80px;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      margin: 0 auto 1.8rem;
    }

    .hero-tagline {
      font-family: var(--f-body);
      font-size: clamp(1rem, 2vw, 1.25rem);
      font-weight: 300;
      color: var(--pearl);
      opacity: 0.75;
      max-width: 560px;
      margin: 0 auto 2.8rem;
      line-height: 1.7;
    }

    /* Credential pills */
    .cred-pills {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 0.6rem;
      max-width: 720px;
      margin: 0 auto 3rem;
    }

    .cred-pill {
      font-family: var(--f-ui);
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--gold);
      border: 1px solid var(--seam-gold);
      border-radius: 2px;
      padding: 0.35rem 0.9rem;
      background: rgba(201,169,97,0.06);
      white-space: nowrap;
    }

    /* Stats strip */
    .stats-strip {
      display: flex;
      gap: 3rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .stat-block {
      text-align: center;
    }

    .stat-value {
      font-family: var(--f-display);
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 400;
      color: var(--gold);
      line-height: 1;
      margin-bottom: 0.3rem;
    }

    .stat-label {
      font-family: var(--f-ui);
      font-size: 0.65rem;
      font-weight: 400;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--pearl);
      opacity: 0.55;
    }

    /* ═══════════════════════════════════════════════════════
       SECTION UTILITY
    ═══════════════════════════════════════════════════════ */
    .section {
      padding: 5rem 2rem;
      position: relative;
    }

    .section--alt {
      background: var(--ob-1);
    }

    .section--alt2 {
      background: var(--ob-2);
    }

    .section-inner {
      max-width: var(--max);
      margin: 0 auto;
    }

    .section-label {
      font-family: var(--f-ui);
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.28em;
      text-transform: uppercase;
      color: var(--gold);
      opacity: 0.75;
      margin-bottom: 0.6rem;
    }

    .section-heading {
      font-family: var(--f-display);
      font-size: clamp(1.5rem, 3vw, 2.4rem);
      font-weight: 400;
      letter-spacing: 0.04em;
      color: var(--pearl);
      margin-bottom: 0.6rem;
    }

    .section-sub {
      font-family: var(--f-body);
      font-size: 1.1rem;
      font-weight: 300;
      font-style: italic;
      color: var(--pearl);
      opacity: 0.6;
      margin-bottom: 3rem;
      max-width: 540px;
    }

    .gold-rule {
      width: 48px;
      height: 1px;
      background: var(--gold);
      margin-bottom: 2rem;
      opacity: 0.5;
    }

    /* ═══════════════════════════════════════════════════════
       ERA TIMELINE BANDS
    ═══════════════════════════════════════════════════════ */
    .era-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1px;
      border: 1px solid var(--seam-gold);
      background: var(--seam-gold);
      margin-bottom: 4rem;
    }

    .era-card {
      background: var(--ob-1);
      padding: 2.5rem 2rem;
      position: relative;
      overflow: hidden;
    }

    .era-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      opacity: 0;
      transition: opacity 0.4s;
    }

    .era-card:hover::before { opacity: 1; }

    .era-number {
      font-family: var(--f-display);
      font-size: 3.5rem;
      font-weight: 400;
      color: var(--gold);
      opacity: 0.12;
      line-height: 1;
      position: absolute;
      top: 1.2rem;
      right: 1.5rem;
    }

    .era-span {
      font-family: var(--f-ui);
      font-size: 0.62rem;
      font-weight: 500;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--gold);
      opacity: 0.7;
      margin-bottom: 0.5rem;
    }

    .era-name {
      font-family: var(--f-display);
      font-size: 1.1rem;
      font-weight: 500;
      letter-spacing: 0.06em;
      color: var(--pearl);
      margin-bottom: 0.8rem;
    }

    .era-desc {
      font-family: var(--f-body);
      font-size: 1rem;
      font-weight: 300;
      color: var(--pearl);
      opacity: 0.65;
      line-height: 1.6;
    }

    .era-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem;
      margin-top: 1.2rem;
    }

    .era-tag {
      font-family: var(--f-ui);
      font-size: 0.58rem;
      font-weight: 500;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--gold);
      border: 1px solid rgba(201,169,97,0.25);
      border-radius: 2px;
      padding: 0.2rem 0.55rem;
    }

    /* ═══════════════════════════════════════════════════════
       PORTFOLIO FILTER TABS
    ═══════════════════════════════════════════════════════ */
    .filter-bar {
      display: flex;
      gap: 0.4rem;
      flex-wrap: wrap;
      margin-bottom: 2.5rem;
    }

    .filter-btn {
      font-family: var(--f-ui);
      font-size: 0.65rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--pearl);
      background: transparent;
      border: 1px solid rgba(240,234,216,0.18);
      border-radius: 2px;
      padding: 0.45rem 1rem;
      cursor: pointer;
      transition: all 0.2s var(--ease-gold);
      opacity: 0.6;
    }

    .filter-btn:hover,
    .filter-btn.active {
      background: var(--mist-2);
      border-color: var(--gold);
      color: var(--gold);
      opacity: 1;
    }

    /* ═══════════════════════════════════════════════════════
       PORTFOLIO GRID
    ═══════════════════════════════════════════════════════ */
    .portfolio-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
      gap: 1.5rem;
    }

    .portfolio-card {
      position: relative;
      background: var(--ob-2);
      border: 1px solid var(--seam-gold);
      border-radius: 3px;
      overflow: hidden;
      cursor: pointer;
      transition: border-color 0.3s, transform 0.3s var(--ease-gold), box-shadow 0.3s;
    }

    .portfolio-card:hover {
      border-color: var(--gold);
      transform: translateY(-3px);
      box-shadow: 0 12px 40px rgba(201,169,97,0.12);
    }

    /* Thumbnail area */
    .card-thumb {
      position: relative;
      width: 100%;
      padding-top: 56.25%; /* 16:9 */
      background: var(--ob-3);
      overflow: hidden;
    }

    .card-thumb img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s var(--ease-gold);
    }

    .portfolio-card:hover .card-thumb img {
      transform: scale(1.04);
    }

    /* Play icon overlay for videos */
    .card-play {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(5,5,5,0.35);
      transition: background 0.3s;
    }

    .portfolio-card:hover .card-play {
      background: rgba(5,5,5,0.15);
    }

    .play-ring {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      border: 1.5px solid var(--gold);
      background: rgba(5,5,5,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s, transform 0.3s;
    }

    .portfolio-card:hover .play-ring {
      background: var(--gold);
      transform: scale(1.08);
    }

    .play-arrow {
      width: 0;
      height: 0;
      border-top: 9px solid transparent;
      border-bottom: 9px solid transparent;
      border-left: 16px solid var(--gold);
      margin-left: 4px;
      transition: border-left-color 0.3s;
    }

    .portfolio-card:hover .play-arrow {
      border-left-color: var(--ob);
    }

    /* Zoom icon for photos */
    .card-zoom {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(5,5,5,0.25);
      opacity: 0;
      transition: opacity 0.3s, background 0.3s;
    }

    .portfolio-card:hover .card-zoom {
      opacity: 1;
      background: rgba(5,5,5,0.45);
    }

    .zoom-icon {
      width: 48px;
      height: 48px;
      border: 1.5px solid var(--gold);
      border-radius: 50%;
      background: rgba(5,5,5,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .zoom-icon svg {
      width: 20px;
      height: 20px;
      stroke: var(--gold);
      fill: none;
      stroke-width: 2;
    }

    /* Slot number badge */
    .slot-badge {
      position: absolute;
      top: 0.75rem;
      left: 0.75rem;
      font-family: var(--f-display);
      font-size: 0.6rem;
      font-weight: 400;
      letter-spacing: 0.12em;
      color: var(--gold);
      background: rgba(5,5,5,0.75);
      border: 1px solid rgba(201,169,97,0.35);
      border-radius: 2px;
      padding: 0.15rem 0.45rem;
      backdrop-filter: blur(4px);
    }

    /* Category badge */
    .cat-badge {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      font-family: var(--f-ui);
      font-size: 0.56rem;
      font-weight: 500;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--ob);
      background: var(--gold);
      border-radius: 2px;
      padding: 0.2rem 0.5rem;
    }

    /* Card body */
    .card-body {
      padding: 1.2rem 1.4rem 1.4rem;
    }

    .card-title {
      font-family: var(--f-display);
      font-size: 0.88rem;
      font-weight: 400;
      letter-spacing: 0.05em;
      color: var(--pearl);
      margin-bottom: 0.35rem;
      line-height: 1.35;
    }

    .card-desc {
      font-family: var(--f-body);
      font-size: 0.9rem;
      font-weight: 300;
      font-style: italic;
      color: var(--pearl);
      opacity: 0.5;
      line-height: 1.5;
    }

    .card-era {
      font-family: var(--f-ui);
      font-size: 0.58rem;
      font-weight: 400;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold);
      opacity: 0.55;
      margin-top: 0.6rem;
    }

    /* Empty slot placeholder */
    .card-empty {
      opacity: 0.25;
      pointer-events: none;
    }

    .card-empty .card-thumb {
      background: repeating-linear-gradient(
        45deg,
        var(--ob-2),
        var(--ob-2) 10px,
        var(--ob-3) 10px,
        var(--ob-3) 20px
      );
    }

    .empty-label {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: var(--f-ui);
      font-size: 0.65rem;
      font-weight: 400;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--pearl);
      opacity: 0.4;
    }

    /* ═══════════════════════════════════════════════════════
       LIGHTBOX
    ═══════════════════════════════════════════════════════ */
    .lightbox {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(5,5,5,0.97);
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      animation: lb-in 0.25s ease;
    }

    .lightbox.open { display: flex; }

    @keyframes lb-in {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    /* Gold frame */
    .lb-frame {
      position: relative;
      width: 100%;
      max-width: 1100px;
      border: 1px solid var(--seam-gold);
      background: #000;
      box-shadow: 0 0 0 1px rgba(201,169,97,0.08),
                  0 40px 80px rgba(0,0,0,0.8),
                  inset 0 0 0 1px rgba(201,169,97,0.04);
    }

    /* Corner accents */
    .lb-frame::before,
    .lb-frame::after {
      content: '';
      position: absolute;
      width: 18px;
      height: 18px;
    }

    .lb-frame::before {
      top: -1px; left: -1px;
      border-top: 2px solid var(--gold);
      border-left: 2px solid var(--gold);
    }

    .lb-frame::after {
      bottom: -1px; right: -1px;
      border-bottom: 2px solid var(--gold);
      border-right: 2px solid var(--gold);
    }

    /* Video wrapper 16:9 */
    .lb-video-wrap {
      position: relative;
      padding-top: 56.25%;
      width: 100%;
    }

    .lb-video-wrap iframe {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      border: none;
    }

    /* Photo display */
    .lb-photo-wrap {
      width: 100%;
      max-height: 75vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #000;
    }

    .lb-photo-wrap img {
      max-width: 100%;
      max-height: 75vh;
      object-fit: contain;
    }

    /* Info bar below frame */
    .lb-info {
      width: 100%;
      max-width: 1100px;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-top: 1.2rem;
      gap: 1rem;
    }

    .lb-text { flex: 1; }

    .lb-title {
      font-family: var(--f-display);
      font-size: 1rem;
      font-weight: 400;
      letter-spacing: 0.06em;
      color: var(--pearl);
      margin-bottom: 0.25rem;
    }

    .lb-desc {
      font-family: var(--f-body);
      font-size: 0.95rem;
      font-style: italic;
      color: var(--pearl);
      opacity: 0.5;
    }

    .lb-counter {
      font-family: var(--f-ui);
      font-size: 0.65rem;
      letter-spacing: 0.14em;
      color: var(--gold);
      opacity: 0.6;
      white-space: nowrap;
      padding-top: 0.2rem;
    }

    /* Controls */
    .lb-controls {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      pointer-events: none;
      padding: 0 -2rem;
    }

    .lb-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 44px;
      height: 44px;
      border: 1px solid var(--seam-gold);
      border-radius: 50%;
      background: rgba(5,5,5,0.8);
      color: var(--gold);
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      pointer-events: all;
      transition: background 0.2s, border-color 0.2s;
      backdrop-filter: blur(4px);
    }

    .lb-btn:hover {
      background: rgba(201,169,97,0.15);
      border-color: var(--gold);
    }

    .lb-btn.prev { left: -22px; }
    .lb-btn.next { right: -22px; }

    /* Close + fullscreen */
    .lb-top-controls {
      position: absolute;
      top: -44px;
      right: 0;
      display: flex;
      gap: 0.6rem;
    }

    .lb-icon-btn {
      width: 36px;
      height: 36px;
      border: 1px solid var(--seam-gold);
      border-radius: 50%;
      background: rgba(5,5,5,0.8);
      color: var(--gold);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s, border-color 0.2s;
    }

    .lb-icon-btn:hover {
      background: rgba(201,169,97,0.15);
      border-color: var(--gold);
    }

    .lb-icon-btn svg {
      width: 16px;
      height: 16px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
    }

    /* ═══════════════════════════════════════════════════════
       CONTACT / CTA
    ═══════════════════════════════════════════════════════ */
    .cta-section {
      background: var(--ob-1);
      border-top: 1px solid var(--seam-gold);
      text-align: center;
      padding: 5rem 2rem;
      position: relative;
    }

    .cta-section::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 50% 70% at 50% 0%, rgba(201,169,97,0.07) 0%, transparent 70%);
      pointer-events: none;
    }

    .cta-heading {
      font-family: var(--f-display);
      font-size: clamp(1.6rem, 3.5vw, 2.8rem);
      font-weight: 400;
      letter-spacing: 0.05em;
      color: var(--pearl);
      margin-bottom: 1rem;
    }

    .cta-sub {
      font-family: var(--f-body);
      font-size: 1.15rem;
      font-weight: 300;
      font-style: italic;
      color: var(--pearl);
      opacity: 0.6;
      max-width: 480px;
      margin: 0 auto 2.5rem;
    }

    .cta-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-primary {
      font-family: var(--f-ui);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--ob);
      background: var(--gold);
      border: none;
      padding: 0.9rem 2.2rem;
      border-radius: 2px;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-primary:hover { background: var(--gold-hi); color: var(--ob); }

    .btn-ghost {
      font-family: var(--f-ui);
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--gold);
      background: transparent;
      border: 1px solid var(--seam-gold);
      padding: 0.9rem 2.2rem;
      border-radius: 2px;
      cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-ghost:hover {
      border-color: var(--gold);
      background: var(--mist);
      color: var(--gold-hi);
    }

    /* ═══════════════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════════════ */
    .site-footer {
      border-top: 1px solid rgba(201,169,97,0.12);
      padding: 2rem;
      text-align: center;
      font-family: var(--f-ui);
      font-size: 0.65rem;
      letter-spacing: 0.1em;
      color: var(--pearl);
      opacity: 0.35;
    }

    /* ═══════════════════════════════════════════════════════
       EMPTY STATE MESSAGE
    ═══════════════════════════════════════════════════════ */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      border: 1px dashed var(--seam-gold);
      border-radius: 3px;
    }

    .empty-state-title {
      font-family: var(--f-display);
      font-size: 1.1rem;
      color: var(--gold);
      opacity: 0.5;
      letter-spacing: 0.08em;
      margin-bottom: 0.6rem;
    }

    .empty-state-msg {
      font-family: var(--f-ui);
      font-size: 0.75rem;
      color: var(--pearl);
      opacity: 0.35;
      letter-spacing: 0.08em;
    }

    /* ═══════════════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════════════ */
    @media (max-width: 900px) {
      .era-grid { grid-template-columns: 1fr; }
      .portfolio-grid { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
      .lb-btn.prev { left: 0.5rem; }
      .lb-btn.next { right: 0.5rem; }
    }

    @media (max-width: 600px) {
      .site-nav { padding: 0 1.2rem; }
      .nav-links { display: none; }
      .portfolio-grid { grid-template-columns: 1fr; }
      .stats-strip { gap: 1.5rem; }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { transition: none !important; animation: none !important; }
    }
  </style>

</head>
<body>

  <!-- NAV -->

  <nav class="site-nav">
    <span class="nav-brand" id="nav-brand">Carr Multimedia</span>
    <ul class="nav-links" id="nav-links">
      <li><a href="#portfolio">Portfolio</a></li>
      <li><a href="#about">Career</a></li>
      <li><a href="#contact">Contact</a></li>
      <li><a href="https://legaisee.com" target="_blank">LEGAiSEE</a></li>
    </ul>
    <a href="#contact" class="nav-cta">Available for Work</a>
  </nav>

  <!-- HERO -->

  <section class="hero" id="top">
    <div class="hero-eyebrow" id="hero-eyebrow">Portfolio · New Braunfels, TX</div>
    <h1 class="hero-name" id="hero-name">John Carr</h1>
    <p class="hero-title" id="hero-title">Loading…</p>
    <div class="hero-rule"></div>
    <p class="hero-tagline" id="hero-tagline">Loading…</p>
    <div class="cred-pills" id="cred-pills"></div>
    <div class="stats-strip" id="stats-strip"></div>
  </section>

  <!-- CAREER ERAS -->

  <section class="section section--alt" id="about">
    <div class="section-inner">
      <div class="section-label">The Record</div>
      <h2 class="section-heading">Three Decades. One Standard.</h2>
      <p class="section-sub">A documented career across broadcast, institutional, and independent production.</p>
      <div class="gold-rule"></div>

```
  <div class="era-grid">
    <div class="era-card">
      <div class="era-number">I</div>
      <div class="era-span">1992 – 2006</div>
      <div class="era-name">The Broadcast Years</div>
      <p class="era-desc">Live network television direction at KPLC NBC and KVHP FOX 29 in Lake Charles, Louisiana. Technical director, broadcast director, and Addy Award recipient — all before digital production became the norm.</p>
      <div class="era-tags">
        <span class="era-tag">KPLC NBC</span>
        <span class="era-tag">KVHP FOX 29</span>
        <span class="era-tag">Addy Award</span>
        <span class="era-tag">Live Direction</span>
      </div>
    </div>

    <div class="era-card">
      <div class="era-number">II</div>
      <div class="era-span">2006 – 2020</div>
      <div class="era-name">The Production Build</div>
      <p class="era-desc">Institutional and corporate production at scale — including Houston Methodist Hospital — and expansion into aerial cinematography. FAA Part 107 certified operator since the pre-regulation era.</p>
      <div class="era-tags">
        <span class="era-tag">Institutional</span>
        <span class="era-tag">Houston Methodist</span>
        <span class="era-tag">FAA Part 107</span>
        <span class="era-tag">Aerial / Drone</span>
      </div>
    </div>

    <div class="era-card">
      <div class="era-number">III</div>
      <div class="era-span">2020 – Present</div>
      <div class="era-name">The Methodology Era</div>
      <p class="era-desc">Founder of LEGAiSEE, a business archaeology and authority reconstruction consultancy built on 30+ years of firsthand production intelligence. Strategic synthesis of everything earned across the prior two eras.</p>
      <div class="era-tags">
        <span class="era-tag">LEGAiSEE</span>
        <span class="era-tag">Carr Multimedia</span>
        <span class="era-tag">Authority Systems</span>
        <span class="era-tag">AI Integration</span>
      </div>
    </div>
  </div>
</div>
```

  </section>

  <!-- PORTFOLIO -->

  <section class="section" id="portfolio">
    <div class="section-inner">
      <div class="section-label">Work Samples</div>
      <h2 class="section-heading">Portfolio</h2>
      <p class="section-sub">Selected work across three decades of production.</p>
      <div class="gold-rule"></div>

```
  <!-- Filter tabs (built by JS) -->
  <div class="filter-bar" id="filter-bar"></div>

  <!-- Grid (built by JS) -->
  <div class="portfolio-grid" id="portfolio-grid"></div>
</div>
```

  </section>

  <!-- CONTACT / CTA -->

  <section class="cta-section" id="contact">
    <div class="section-inner">
      <div class="section-label">Available for Engagement</div>
      <h2 class="cta-heading" id="cta-heading">Ready to contribute from day one.</h2>
      <p class="cta-sub" id="cta-sub">Broadcast-grade experience. Thirty-year production record. No learning curve required.</p>
      <div class="cta-buttons" id="cta-buttons"></div>
    </div>
  </section>

  <!-- FOOTER -->

  <footer class="site-footer">
    <span id="footer-text"></span>
  </footer>

  <!-- LIGHTBOX -->

  <div class="lightbox" id="lightbox" role="dialog" aria-modal="true">
    <div style="position:relative; width:100%; max-width:1100px;">
      <!-- Top controls -->
      <div class="lb-top-controls">
        <button class="lb-icon-btn" id="lb-fullscreen" title="Fullscreen" aria-label="Toggle fullscreen">
          <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
        </button>
        <button class="lb-icon-btn" id="lb-close" title="Close" aria-label="Close lightbox">
          <svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
      </div>

```
  <!-- Gold frame with prev/next -->
  <div class="lb-frame" id="lb-frame">
    <div id="lb-content"></div>
    <button class="lb-btn prev" id="lb-prev" aria-label="Previous">&#8592;</button>
    <button class="lb-btn next" id="lb-next" aria-label="Next">&#8594;</button>
  </div>

  <!-- Info bar -->
  <div class="lb-info">
    <div class="lb-text">
      <div class="lb-title" id="lb-title"></div>
      <div class="lb-desc"  id="lb-desc"></div>
    </div>
    <div class="lb-counter" id="lb-counter"></div>
  </div>
</div>
```

  </div>

  <!-- ═══════════════════════════════════════════════════════
       JAVASCRIPT
  ═══════════════════════════════════════════════════════ -->

  <script>
  (function () {
    'use strict';

    /* ── HELPERS ──────────────────────────────────────────── */

    /**
     * Convert any YouTube URL to a clean embed URL.
     * Handles: watch?v=, youtu.be/, shorts/
     */
    function ytEmbed(rawUrl) {
      if (!rawUrl) return '';
      let id = '';
      try {
        const u = new URL(rawUrl);
        if (u.hostname === 'youtu.be') {
          id = u.pathname.replace('/', '');
        } else if (u.pathname.includes('/shorts/')) {
          id = u.pathname.split('/shorts/')[1];
        } else {
          id = u.searchParams.get('v') || '';
        }
      } catch (_) {
        // fallback: grab last segment
        const m = rawUrl.match(/(?:v=|youtu\.be\/|shorts\/)([A-Za-z0-9_-]{11})/);
        if (m) id = m[1];
      }
      if (!id) return '';
      return `https://www.youtube-nocookie.com/embed/${id}?rel=0&modestbranding=1&iv_load_policy=3&color=white&autoplay=1`;
    }

    /**
     * Get YouTube thumbnail.
     */
    function ytThumb(rawUrl) {
      const embed = ytEmbed(rawUrl);
      if (!embed) return '';
      const m = embed.match(/embed\/([A-Za-z0-9_-]{11})/);
      if (!m) return '';
      return `https://i.ytimg.com/vi/${m[1]}/hqdefault.jpg`;
    }

    /** Build active portfolio items (enabled + has url). */
    function activeItems() {
      return (CAREER_CONFIG.portfolio || []).filter(
        item => item.enabled !== false && (item.url || '').trim() !== ''
      );
    }

    /* ── RENDER HERO ──────────────────────────────────────── */
    function renderHero() {
      const m = CAREER_CONFIG.meta || {};
      document.title = (m.name || 'Portfolio') + ' · Career Portfolio';
      document.getElementById('nav-brand').textContent  = m.name  || '';
      document.getElementById('hero-title').textContent = m.title || '';
      document.getElementById('hero-tagline').textContent = m.tagline || '';
      document.getElementById('hero-eyebrow').textContent =
        'Portfolio · ' + (m.location || '');

      // Cred pills
      const pillsEl = document.getElementById('cred-pills');
      pillsEl.innerHTML = '';
      (CAREER_CONFIG.credentials || []).forEach(c => {
        const span = document.createElement('span');
        span.className = 'cred-pill';
        span.textContent = c;
        pillsEl.appendChild(span);
      });

      // Stats
      const statsEl = document.getElementById('stats-strip');
      statsEl.innerHTML = '';
      (CAREER_CONFIG.stats || []).forEach(s => {
        const div = document.createElement('div');
        div.className = 'stat-block';
        div.innerHTML = `<div class="stat-value">${s.value}</div><div class="stat-label">${s.label}</div>`;
        statsEl.appendChild(div);
      });
    }

    /* ── RENDER CTA ───────────────────────────────────────── */
    function renderCTA() {
      const m = CAREER_CONFIG.meta || {};

      const btns = document.getElementById('cta-buttons');
      btns.innerHTML = '';

      if (m.email) {
        const a = document.createElement('a');
        a.href = 'mailto:' + m.email;
        a.className = 'btn-primary';
        a.textContent = 'Send a Message';
        btns.appendChild(a);
      }

      if (m.resume_url) {
        const a = document.createElement('a');
        a.href = m.resume_url;
        a.target = '_blank';
        a.className = 'btn-ghost';
        a.textContent = 'Download Résumé';
        btns.appendChild(a);
      }

      if (m.linkedin) {
        const a = document.createElement('a');
        a.href = m.linkedin;
        a.target = '_blank';
        a.className = 'btn-ghost';
        a.textContent = 'LinkedIn Profile';
        btns.appendChild(a);
      }

      // Footer
      document.getElementById('footer-text').textContent =
        '© ' + new Date().getFullYear() + ' ' + (m.name || '') +
        ' · ' + (m.location || '') + ' · Carr Multimedia';
    }

    /* ── RENDER PORTFOLIO ─────────────────────────────────── */
    let allItems   = [];
    let activeFilter = 'All';

    function buildFilterBar(items) {
      const cats = ['All', ...new Set(items.map(i => i.category).filter(Boolean))];
      const bar  = document.getElementById('filter-bar');
      bar.innerHTML = '';
      cats.forEach(cat => {
        const btn = document.createElement('button');
        btn.className = 'filter-btn' + (cat === activeFilter ? ' active' : '');
        btn.textContent = cat;
        btn.addEventListener('click', () => {
          activeFilter = cat;
          document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          renderGrid();
        });
        bar.appendChild(btn);
      });
    }

    function renderGrid() {
      const grid = document.getElementById('portfolio-grid');
      grid.innerHTML = '';

      const filtered = activeFilter === 'All'
        ? allItems
        : allItems.filter(i => i.category === activeFilter);

      if (filtered.length === 0) {
        const empty = document.createElement('div');
        empty.className = 'empty-state';
        empty.style.gridColumn = '1 / -1';
        empty.innerHTML = `
          <div class="empty-state-title">No Items Yet</div>
          <div class="empty-state-msg">Open career-config.js and paste URLs into the numbered slots.</div>
        `;
        grid.appendChild(empty);
        return;
      }

      filtered.forEach((item, idx) => {
        const card = buildCard(item, idx, filtered);
        grid.appendChild(card);
      });
    }

    function buildCard(item, idx, contextList) {
      const card = document.createElement('div');
      card.className = 'portfolio-card';
      card.setAttribute('tabindex', '0');
      card.setAttribute('role', 'button');
      card.setAttribute('aria-label', 'Open ' + (item.title || 'portfolio item'));

      // Slot badge
      const slotBadge = `<div class="slot-badge">${String(item.slot || '').padStart(2, '0')}</div>`;

      // Category badge
      const catBadge = item.category
        ? `<div class="cat-badge">${item.category}</div>`
        : '';

      if (item.type === 'video') {
        const thumb = ytThumb(item.url);
        card.innerHTML = `
          <div class="card-thumb">
            ${thumb ? `<img src="${thumb}" alt="${item.title || ''}" loading="lazy" />` : ''}
            <div class="card-play">
              <div class="play-ring"><div class="play-arrow"></div></div>
            </div>
            ${slotBadge}${catBadge}
          </div>
          <div class="card-body">
            <div class="card-title">${item.title || 'Untitled'}</div>
            ${item.description ? `<div class="card-desc">${item.description}</div>` : ''}
            ${item.era ? `<div class="card-era">${item.era}</div>` : ''}
          </div>
        `;
      } else {
        card.innerHTML = `
          <div class="card-thumb">
            <img src="${item.url}" alt="${item.title || ''}" loading="lazy" />
            <div class="card-zoom">
              <div class="zoom-icon">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M11 8v6M8 11h6"/></svg>
              </div>
            </div>
            ${slotBadge}${catBadge}
          </div>
          <div class="card-body">
            <div class="card-title">${item.title || 'Untitled'}</div>
            ${item.description ? `<div class="card-desc">${item.description}</div>` : ''}
            ${item.era ? `<div class="card-era">${item.era}</div>` : ''}
          </div>
        `;
      }

      // Open lightbox on click / enter
      const open = () => openLightbox(contextList, idx);
      card.addEventListener('click', open);
      card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') open(); });

      return card;
    }

    /* ── LIGHTBOX ─────────────────────────────────────────── */
    let lbItems   = [];
    let lbCurrent = 0;

    function openLightbox(items, startIdx) {
      lbItems   = items;
      lbCurrent = startIdx;
      document.getElementById('lightbox').classList.add('open');
      document.body.style.overflow = 'hidden';
      renderLB();
    }

    function closeLightbox() {
      document.getElementById('lightbox').classList.remove('open');
      document.body.style.overflow = '';
      // Stop video
      document.getElementById('lb-content').innerHTML = '';
    }

    function renderLB() {
      const item = lbItems[lbCurrent];
      if (!item) return;

      const content = document.getElementById('lb-content');
      content.innerHTML = '';

      if (item.type === 'video') {
        const embed = ytEmbed(item.url);
        const wrap  = document.createElement('div');
        wrap.className = 'lb-video-wrap';
        wrap.innerHTML = `<iframe src="${embed}" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
        content.appendChild(wrap);
      } else {
        const wrap = document.createElement('div');
        wrap.className = 'lb-photo-wrap';
        wrap.innerHTML = `<img src="${item.url}" alt="${item.title || ''}" />`;
        content.appendChild(wrap);
      }

      document.getElementById('lb-title').textContent   = item.title || '';
      document.getElementById('lb-desc').textContent    = item.description || '';
      document.getElementById('lb-counter').textContent =
        (lbCurrent + 1) + ' / ' + lbItems.length;

      // Show/hide prev+next
      document.getElementById('lb-prev').style.visibility = lbCurrent > 0 ? 'visible' : 'hidden';
      document.getElementById('lb-next').style.visibility = lbCurrent < lbItems.length - 1 ? 'visible' : 'hidden';
    }

    function lbPrev() {
      if (lbCurrent > 0) { lbCurrent--; renderLB(); }
    }

    function lbNext() {
      if (lbCurrent < lbItems.length - 1) { lbCurrent++; renderLB(); }
    }

    /* ── FULLSCREEN ───────────────────────────────────────── */
    document.getElementById('lb-fullscreen').addEventListener('click', () => {
      const el = document.getElementById('lb-frame');
      if (!document.fullscreenElement) {
        el.requestFullscreen && el.requestFullscreen();
      } else {
        document.exitFullscreen && document.exitFullscreen();
      }
    });

    /* ── KEYBOARD NAVIGATION ──────────────────────────────── */
    document.addEventListener('keydown', e => {
      const lb = document.getElementById('lightbox');
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape')      closeLightbox();
      if (e.key === 'ArrowLeft')   lbPrev();
      if (e.key === 'ArrowRight')  lbNext();
    });

    document.getElementById('lb-close').addEventListener('click', closeLightbox);
    document.getElementById('lb-prev').addEventListener('click',  lbPrev);
    document.getElementById('lb-next').addEventListener('click',  lbNext);

    // Click outside frame to close
    document.getElementById('lightbox').addEventListener('click', function(e) {
      if (e.target === this) closeLightbox();
    });

    /* ── BOOT ─────────────────────────────────────────────── */
    function init() {
      renderHero();
      renderCTA();

      allItems = activeItems();

      if (allItems.length > 0) {
        buildFilterBar(allItems);
      }

      renderGrid();
    }

    // Wait for DOM
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
    } else {
      init();
    }

  }());
  </script>

</body>
</html>
