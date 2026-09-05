
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Legaisee – Business Archaeology & Authority Systems</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --black: #050509;
      --black-soft: #0b0b12;
      --gold: #f5c76a;
      --gold-bright: #ffe4a1;
      --gold-deep: #c89a3c;
      --diamond: #f9f9ff;
      --cosmic-violet: #3b2b5f;
      --accent-gold: #ffe4a1;
      --max-width: 1200px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Montserrat', system-ui, sans-serif;
      background: var(--black);
      color: var(--diamond);
      line-height: 1.6;
    }

    a { color: inherit; text-decoration: none; }

    .container {
      max-width: var(--max-width);
      margin: 0 auto;
      padding: 0 1.5rem;
    }

    /* HEADER */
    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 90;
      backdrop-filter: blur(18px);
      background: linear-gradient(to bottom, rgba(5, 5, 9, 0.95), rgba(5, 5, 9, 0.75), transparent);
      border-bottom: 1px solid rgba(245, 199, 106, 0.12);
    }

    .nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 0;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-family: 'Cinzel', serif;
      font-weight: 600;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      font-size: 0.85rem;
      color: var(--gold);
    }

    .logo-mark {
      width: 26px;
      height: 26px;
      border-radius: 999px;
      background: conic-gradient(from 210deg, var(--gold), var(--gold-deep), #fff7d6, var(--gold));
      box-shadow: 0 0 18px rgba(245, 199, 106, 0.7), 0 0 40px rgba(0, 0, 0, 0.9);
      border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .nav-links {
      display: flex;
      gap: 1.75rem;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.16em;
    }

    .nav-links a {
      position: relative;
      padding-bottom: 0.2rem;
      color: rgba(249, 249, 255, 0.78);
    }

    .nav-links a::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(to right, var(--gold), var(--accent-gold));
      transition: width 0.25s ease;
    }

    .nav-links a:hover::after { width: 100%; }

    .nav-cta {
      padding: 0.55rem 1.4rem;
      border-radius: 999px;
      border: 1px solid rgba(245, 199, 106, 0.7);
      background: radial-gradient(circle at top left, rgba(245, 199, 106, 0.25), transparent 55%);
      box-shadow: 0 0 18px rgba(245, 199, 106, 0.35), 0 0 40px rgba(0, 0, 0, 0.9);
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: var(--gold);
      transition: all 0.3s ease;
    }

    .nav-cta:hover {
      background: radial-gradient(circle at top left, rgba(245, 199, 106, 0.4), transparent 55%);
      box-shadow: 0 0 25px rgba(245, 199, 106, 0.5), 0 0 50px rgba(0, 0, 0, 0.9);
      transform: translateY(-2px);
    }

    /* HERO */
    .hero {
      position: relative;
      min-height: 90vh;
      display: flex;
      align-items: center;
      padding: 8rem 0 5rem;
      overflow: hidden;
      background: radial-gradient(circle at top, #141428 0, var(--black) 45%, #000 100%);
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: -10%;
      background-image: url("YOUR-ABSTRACT-BLACK-GOLD-BG.jpg");
      background-size: cover;
      background-position: center;
      opacity: 0.35;
      filter: saturate(1.2) contrast(1.1);
      z-index: 0;
    }

    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at top left, rgba(245, 199, 106, 0.25), transparent 55%),
        radial-gradient(circle at bottom right, rgba(59, 43, 95, 0.6), transparent 55%),
        linear-gradient(to bottom, rgba(5, 5, 9, 0.9), rgba(5, 5, 9, 0.4), rgba(5, 5, 9, 0.95));
      mix-blend-mode: soft-light;
      z-index: 1;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: minmax(0, 3fr) minmax(0, 2.4fr);
      gap: 3.5rem;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    @media (max-width: 900px) {
      .hero-grid { grid-template-columns: 1fr; }
      .hero { padding-top: 6rem; }
    }

    .eyebrow {
      text-transform: uppercase;
      letter-spacing: 0.22em;
      font-size: 0.75rem;
      color: rgba(245, 199, 106, 0.85);
      margin-bottom: 0.9rem;
    }

    .hero h1 {
      font-family: 'Cinzel', serif;
      font-size: clamp(2.6rem, 4vw, 3.6rem);
      line-height: 1.1;
      margin-bottom: 1.1rem;
      text-shadow: 0 0 18px rgba(0, 0, 0, 0.9), 0 0 40px rgba(0, 0, 0, 0.9);
    }

    /* REMOVED: No highlighter yellow. Subtle gold only. */
    .hero h1 span.highlight {
      background: linear-gradient(to right, var(--gold), var(--gold-bright));
      -webkit-background-clip: text;
      color: transparent;
    }

    .hero-sub {
      max-width: 32rem;
      color: rgba(249, 249, 255, 0.78);
      font-size: 0.98rem;
      margin-bottom: 1.8rem;
    }

    .hero-sub strong { color: var(--diamond); }

    .hero-cta-row {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: center;
      margin-bottom: 1.8rem;
    }

    .btn-primary {
      padding: 0.9rem 1.9rem;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      background: linear-gradient(135deg, var(--gold), var(--gold-deep));
      color: #1a1305;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      font-size: 0.78rem;
      box-shadow: 0 0 18px rgba(245, 199, 106, 0.7), 0 0 40px rgba(0, 0, 0, 0.9);
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 0 30px rgba(245, 199, 106, 0.9), 0 0 60px rgba(0, 0, 0, 0.9);
    }

    .btn-ghost {
      padding: 0.9rem 1.6rem;
      border-radius: 999px;
      border: 1px solid rgba(249, 249, 255, 0.35);
      background: rgba(5, 5, 9, 0.7);
      color: rgba(249, 249, 255, 0.85);
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-ghost:hover {
      border-color: rgba(245, 199, 106, 0.7);
      background: rgba(245, 199, 106, 0.1);
      color: var(--gold);
    }

    .hero-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(249, 249, 255, 0.6);
    }

    .hero-meta span {
      position: relative;
      padding-left: 1.1rem;
    }

    .hero-meta span::before {
      content: "";
      position: absolute;
      left: 0;
      top: 50%;
      width: 6px;
      height: 6px;
      border-radius: 999px;
      background: radial-gradient(circle, #ffffff, var(--gold));
      transform: translateY(-50%);
      box-shadow: 0 0 10px rgba(245, 199, 106, 0.9);
    }

    .hero-card {
      background: radial-gradient(circle at top, rgba(245, 199, 106, 0.16), rgba(5, 5, 9, 0.96));
      border-radius: 26px;
      border: 1px solid rgba(245, 199, 106, 0.4);
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.95), 0 0 60px rgba(245, 199, 106, 0.18);
      padding: 1.8rem 1.7rem 1.6rem;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    /* SLOW SPOTLIGHT SWEEP: 3000K warm, 5 seconds, 1 second delay */
    .hero-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: -30%;
      width: 30%;
      height: 100%;
      /* 3000K warm spotlight color - rounded/soft edges */
      background: radial-gradient(
        ellipse 80% 100% at center,
        rgba(255, 180, 100, 0.15) 0%,
        rgba(255, 160, 80, 0.08) 40%,
        transparent 70%
      );
      filter: blur(8px);
      opacity: 0;
      pointer-events: none;
    }

    .hero-card:hover::before {
      animation: spotlight-sweep 5s ease-in-out forwards;
      animation-delay: 1s;
      opacity: 1;
    }

    @keyframes spotlight-sweep {
      0% {
        left: -30%;
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        left: 130%;
        opacity: 0;
      }
    }

    .hero-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 50px rgba(245, 199, 106, 0.25), 0 0 80px rgba(0, 0, 0, 0.95);
      border-color: rgba(245, 199, 106, 0.5);
    }

    .hero-card-inner { position: relative; z-index: 1; }

    .hero-card-label {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.22em;
      color: rgba(249, 249, 255, 0.7);
      margin-bottom: 0.7rem;
    }

    .hero-card-title {
      font-size: 1.1rem;
      margin-bottom: 1.2rem;
    }

    .hero-card-title span { color: var(--gold); }

    .hero-stats {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1.1rem;
      margin-bottom: 1.4rem;
    }

    .hero-stat {
      padding: 0.7rem 0.8rem;
      border-radius: 14px;
      background: rgba(5, 5, 9, 0.85);
      border: 1px solid rgba(249, 249, 255, 0.08);
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
    }

    /* SLOW SPOTLIGHT SWEEP on stats */
    .hero-stat::before {
      content: "";
      position: absolute;
      top: 0;
      left: -30%;
      width: 30%;
      height: 100%;
      background: radial-gradient(
        ellipse 80% 100% at center,
        rgba(255, 180, 100, 0.2) 0%,
        rgba(255, 160, 80, 0.1) 40%,
        transparent 70%
      );
      filter: blur(6px);
      opacity: 0;
      pointer-events: none;
    }

    .hero-stat:hover::before {
      animation: spotlight-sweep 5s ease-in-out forwards;
      animation-delay: 1s;
      opacity: 1;
    }

    .hero-stat:hover {
      background: rgba(245, 199, 106, 0.1);
      border-color: rgba(245, 199, 106, 0.3);
      transform: translateY(-3px);
    }

    .hero-stat strong {
      display: block;
      font-size: 1.1rem;
      margin-bottom: 0.2rem;
      color: var(--diamond);
    }

    .hero-stat span {
      font-size: 0.75rem;
      color: rgba(249, 249, 255, 0.65);
    }

    .hero-card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.75rem;
      color: rgba(249, 249, 255, 0.7);
    }

    .hero-card-tag {
      padding: 0.25rem 0.7rem;
      border-radius: 999px;
      border: 1px solid rgba(245, 199, 106, 0.7);
      background: rgba(5, 5, 9, 0.8);
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
    }

    /* SECTIONS */
    section {
      padding: 5rem 0;
      position: relative;
    }

    .section-header {
      text-align: center;
      margin-bottom: 3rem;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    /* SIMPLIFIED HEADERS - No 3D, museum quality */
    .stage-heading-container {
      position: relative;
      display: inline-block;
      margin-bottom: 2rem;
    }

    .stage-heading {
      position: relative;
      display: inline-block;
      font-family: 'Cinzel', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      line-height: 1.2;
      color: var(--gold);
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5), 0 0 30px rgba(245, 199, 106, 0.2);
      letter-spacing: 0.05em;
    }

    /* SECTION BACKGROUNDS */
    section.services {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at top, rgba(59, 43, 95, 0.25), transparent 55%);
    }

    section.archaeology {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at bottom, rgba(245, 199, 106, 0.12), transparent 55%);
    }

    section.alchemy {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at top, rgba(245, 199, 106, 0.12), transparent 55%);
    }

    section.prestige {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at bottom, rgba(245, 199, 106, 0.12), transparent 55%);
    }

    section.authority {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at top, rgba(59, 43, 95, 0.25), transparent 55%);
    }

    section.contact {
      border-top: 1px solid rgba(245, 199, 106, 0.08);
      background: radial-gradient(circle at bottom, rgba(59, 43, 95, 0.25), transparent 55%);
    }

    /* INLINE GEM CARDS */
    .section-with-gem {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      align-items: start;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem;
    }

    .section-with-gem.gem-left {
      grid-template-columns: 0.8fr 1.2fr;
    }

    .section-with-gem.gem-right {
      grid-template-columns: 1.2fr 0.8fr;
    }

    .gem-inline {
      width: 100%;
      max-width: 450px;
      position: relative;
      transition: all 0.4s ease;
    }

    .gem-inline .gem-stage {
      aspect-ratio: 4/3;
      background: radial-gradient(ellipse at center, rgba(59, 43, 95, 0.3) 0%, rgba(5, 5, 9, 0.9) 70%);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 16px 16px 0 0;
      min-height: 280px;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    /* SLOW SPOTLIGHT SWEEP on gem stage */
    .gem-inline .gem-stage::before {
      content: '';
      position: absolute;
      top: 0;
      left: -30%;
      width: 30%;
      height: 100%;
      background: radial-gradient(
        ellipse 80% 100% at center,
        rgba(255, 180, 100, 0.12) 0%,
        rgba(255, 160, 80, 0.06) 40%,
        transparent 70%
      );
      filter: blur(8px);
      opacity: 0;
      pointer-events: none;
      z-index: 2;
    }

    .gem-inline:hover .gem-stage::before {
      animation: spotlight-sweep 5s ease-in-out forwards;
      animation-delay: 1s;
      opacity: 1;
    }

    .gem-inline:hover .gem-stage {
      box-shadow: 0 0 40px rgba(245, 199, 106, 0.15);
    }

    .gem-inline.gem-square .gem-stage {
      aspect-ratio: 1/1;
    }

    .gem-placeholder {
      text-align: center;
      padding: 2rem;
    }

    .gem-label {
      font-family: 'Cinzel', serif;
      font-size: 2rem;
      color: var(--gold);
      text-shadow: 0 0 20px rgba(245, 199, 106, 0.3);
      display: block;
      margin-bottom: 0.5rem;
    }

    .gem-dims {
      font-size: 0.75rem;
      color: var(--cosmic-violet);
      letter-spacing: 0.2em;
      display: block;
      margin-bottom: 0.5rem;
    }

    .gem-desc {
      font-size: 0.7rem;
      color: rgba(249, 249, 255, 0.5);
      font-style: italic;
      display: block;
      margin-bottom: 1rem;
    }

    .gem-stage-label {
      font-size: 0.65rem;
      letter-spacing: 0.2em;
      color: var(--gold);
      border: 1px solid rgba(245, 199, 106, 0.3);
      padding: 0.4rem 0.8rem;
      border-radius: 20px;
      text-transform: uppercase;
    }

    .gem-image {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .gem-image.loaded { opacity: 1; }

    .gem-caption {
      padding: 1.5rem;
      background: rgba(5, 5, 9, 0.95);
      border: 1px solid rgba(245, 199, 106, 0.1);
      border-top: none;
      border-radius: 0 0 16px 16px;
      transition: all 0.4s ease;
    }

    .gem-inline:hover .gem-caption {
      border-color: rgba(245, 199, 106, 0.25);
      background: rgba(5, 5, 9, 0.98);
    }

    .gem-caption h3 {
      font-family: 'Cinzel', serif;
      font-size: 1rem;
      color: var(--gold);
      margin: 0 0 0.5rem 0;
    }

    .gem-caption p {
      font-size: 0.85rem;
      color: rgba(249, 249, 255, 0.6);
      margin: 0;
    }

    .gem-content h2 {
      font-family: 'Cinzel', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      color: var(--gold);
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .gem-content > p {
      font-size: 1.1rem;
      color: rgba(249, 249, 255, 0.7);
      line-height: 1.6;
      margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
      .section-with-gem { gap: 2rem; }
      .gem-inline { max-width: 350px; }
    }

    @media (max-width: 768px) {
      .section-with-gem,
      .section-with-gem.gem-left,
      .section-with-gem.gem-right {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .gem-inline {
        max-width: 400px;
        margin: 0 auto;
        order: -1;
      }
      .gem-content > p { font-size: 1rem; }
    }

    /* Services grid */
    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.8rem;
      margin-top: 3rem;
    }

    @media (max-width: 900px) {
      .services-grid { grid-template-columns: 1fr; }
    }

    .service-card {
      background: rgba(5, 5, 9, 0.9);
      border-radius: 20px;
      padding: 1.6rem 1.5rem;
      border: 1px solid rgba(245, 199, 106, 0.25);
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.9);
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
    }

    /* SLOW SPOTLIGHT SWEEP on service cards */
    .service-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: -30%;
      width: 30%;
      height: 100%;
      background: radial-gradient(
        ellipse 80% 100% at center,
        rgba(255, 180, 100, 0.12) 0%,
        rgba(255, 160, 80, 0.06) 40%,
        transparent 70%
      );
      filter: blur(8px);
      opacity: 0;
      pointer-events: none;
      z-index: 1;
    }

    .service-card:hover::before {
      animation: spotlight-sweep 5s ease-in-out forwards;
      animation-delay: 1s;
      opacity: 1;
    }

    .service-card:hover {
      transform: translateY(-5px);
      border-color: rgba(245, 199, 106, 0.45);
      box-shadow: 0 0 40px rgba(245, 199, 106, 0.15), 0 0 60px rgba(0, 0, 0, 0.95);
    }

    .service-card h3 {
      font-size: 1rem;
      margin-bottom: 0.5rem;
      color: var(--diamond);
      position: relative;
      z-index: 2;
    }

    .service-card p {
      font-size: 0.9rem;
      color: rgba(249, 249, 255, 0.7);
      margin-bottom: 0.9rem;
      position: relative;
      z-index: 2;
    }

    .service-tag {
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.18em;
      color: rgba(245, 199, 106, 0.85);
      margin-bottom: 0.5rem;
      position: relative;
      z-index: 2;
    }

    /* FOOTER */
    footer {
      padding: 2.5rem 0 2rem;
      background: #020207;
      border-top: 1px solid rgba(245, 199, 106, 0.2);
      color: rgba(249, 249, 255, 0.6);
      font-size: 0.8rem;
    }

    .footer-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .footer-inner span { opacity: 0.8; }

<Style>
.timeline-section {
  position: relative;
  padding: 5rem 0;
  background: radial-gradient(circle at top, rgba(59,43,95,0.2), transparent 60%);
}

.timeline-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
}

.timeline-item {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  position: relative;
}

.timeline-date {
  flex: 0 0 80px;
  font-family: 'Cinzel', serif;
  font-weight: 600;
  font-size: 0.85rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  position: relative;
}

.timeline-date::after {
  content: "";
  position: absolute;
  left: 50%;
  top: 100%;
  width: 2px;
  height: 100%;
  background: var(--gold);
  transform: translateX(-50%);
}

.timeline-card {
  background: rgba(5,5,9,0.85);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid rgba(245,199,106,0.25);
  box-shadow: 0 0 20px rgba(0,0,0,0.9), 0 0 30px rgba(245,199,106,0.1);
  transition: all 0.3s ease;
}

.timeline-card h3 {
  font-family: 'Cinzel', serif;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  color: var(--diamond);
}

.timeline-card p {
  font-size: 0.9rem;
  color: rgba(249,249,255,0.75);
  line-height: 1.5;
}

.timeline-card:hover {
  transform: translateY(-3px);
  border-color: rgba(245,199,106,0.5);
  box-shadow: 0 0 40px rgba(245,199,106,0.2), 0 0 60px rgba(0,0,0,0.95);
}

@media (min-width: 768px) {
  .timeline-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1200px) {
  .timeline-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>



  </style>
<base target="_blank">
<base target="_blank">
</head>
<body>
  <header>
    <div class="container nav">
      <div class="logo">
        <div class="logo-mark"></div>
        <span>LEGAISEE</span>
      </div>
      <nav class="nav-links">
        <a href="#services">Services</a>
        <a href="#archaeology">Archaeology</a>
        <a href="#alchemy">Alchemy</a>
        <a href="#contact">Contact</a>
      </nav>
      <a href="#contact" class="nav-cta">Book Consult</a>
    </div>
  </header>

  <main>
    <!-- HERO -->
    <section class="hero">
      <div class="container hero-grid">
        <div>
          <div class="eyebrow">Business Archaeology & Authority Systems</div>
          <h1>
            Excavate your buried<br />
            <span class="highlight">marketing gold</span>
          </h1>
          <p class="hero-sub">
            We dig through 40+ years of your business history to find the <strong>proven tactics</strong> 
            you've abandoned—then transform them into modern authority systems.
          </p>
          <div class="hero-cta-row">
            <!-- REMOVED: No highlighter yellow. Just subtle gold text. -->
            <button class="btn-primary">Request Archaeology Audit</button>
            <button class="btn-ghost">View Transformation Process</button>
          </div>
          <div class="hero-meta">
            <span>Deep historical research</span>
            <span>AI-powered modernization</span>
            <span>Authority positioning</span>
          </div>
        </div>

        <aside class="hero-card">
          <div class="hero-card-inner">
            <div class="hero-card-label">The Transformation Process</div>
            <div class="hero-card-title">
              <span>Raw</span> → Cut → <span>Polished</span> → Displayed
            </div>
            <div class="hero-stats">
              <div class="hero-stat"><strong>40+</strong><span>Channels excavated</span></div>
              <div class="hero-stat"><strong>15-25</strong><span>Assets recovered</span></div>
              <div class="hero-stat"><strong>3</strong><span>Transformation stages</span></div>
              <div class="hero-stat"><strong>1</strong><span>Authority system</span></div>
            </div>
            <div class="hero-card-footer">
              <span>From buried history to visible authority</span>
              <span class="hero-card-tag">By application</span>
            </div>
          </div>
        </aside>
      </div>
    </section>

    <!-- SERVICES -->
    <section class="services" id="services">
      <div class="container">
        <div class="section-header">
          <div class="stage-heading-container">
            <h2 class="stage-heading">Signature Services</h2>
          </div>
          <p>Bespoke, high‑impact engagements engineered for clients who measure value in decades.</p>
        </div>
        <div class="services-grid">
          <article class="service-card">
            <div class="service-tag">Flagship</div>
            <h3>Business Archaeology Audit</h3>
            <p>Deep excavation across 40+ channels to find your abandoned marketing gold.</p>
          </article>
          <article class="service-card">
            <div class="service-tag">Advisory</div>
            <h3>Authority Systems Build</h3>
            <p>Transform historical assets into modern content engines and publishing rhythms.</p>
          </article>
          <article class="service-card">
            <div class="service-tag">Experience</div>
            <h3>Camera Authority Training</h3>
            <p>On-camera presence for the authority economy—from script to screen.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- ARCHAEOLOGY -->
    <section class="archaeology" id="archaeology">
      <div class="section-with-gem gem-left">
        <div class="gem-inline">
          <div class="gem-stage">
            <div class="gem-placeholder">
              <span class="gem-label">IMG-01</span>
              <span class="gem-dims">800 × 600 PX</span>
              <span class="gem-desc">Raw Emerald in Rock Matrix</span>
              <span class="gem-stage-label">Stage 1: Raw</span>
            </div>
            <img src="" alt="Raw emerald" class="gem-image" data-replace="assets/gems/emerald-raw-800x600.jpg">
          </div>
          <div class="gem-caption">
            <h3>ARCHAEOLOGY</h3>
            <p>Excavating buried assets from your business history.</p>
          </div>
        </div>

        <div class="gem-content">
          <div class="stage-heading-container">
            <h2 class="stage-heading">The Archaeology Process</h2>
          </div>
          <p>We dig deeper than any agency. Public records, private archives, employee interviews, and competitor intelligence to reconstruct what actually worked.</p>

          <div class="services-grid" style="margin-top: 2rem;">
            <article class="service-card">
              <div class="service-tag">Phase 1</div>
              <h3>Public Excavation</h3>
              <p>Web archives, social media history, YouTube commercials, print ads, news coverage.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Phase 2</div>
              <h3>Private Archives</h3>
              <p>Old hard drives, email campaigns, CRM exports, design files.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Phase 3</div>
              <h3>Human Intelligence</h3>
              <p>Interviews with former employees, founders, and customers.</p>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- ALCHEMY -->
    <section class="alchemy" id="alchemy">
      <div class="section-with-gem gem-right">
        <div class="gem-content">
          <div class="stage-heading-container">
            <h2 class="stage-heading">The Alchemy of Transformation</h2>
          </div>
          <p>Raw historical assets are worthless without modern transformation. We cut and polish proven tactics for today's platforms.</p>

          <div class="services-grid" style="margin-top: 2rem;">
            <article class="service-card">
              <div class="service-tag">Modernization</div>
              <h3>Channel Translation</h3>
              <p>Print ads become Instagram carousels. Radio spots become podcast host reads.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Voice</div>
              <h3>Authority Replication</h3>
              <p>Extract your unique communication DNA and encode it for AI-powered systems.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Systems</div>
              <h3>Content Engines</h3>
              <p>Four integrated systems that compound over time.</p>
            </article>
          </div>
        </div>

        <div class="gem-inline gem-square">
          <div class="gem-stage" style="aspect-ratio: 1/1;">
            <div class="gem-placeholder">
              <span class="gem-label" style="font-size: 1.6rem;">IMG-02</span>
              <span class="gem-dims">600 × 600 PX</span>
              <span class="gem-desc">Cut & Faceted Emerald</span>
              <span class="gem-stage-label">Stage 2: Cut</span>
            </div>
            <img src="" alt="Cut emerald" class="gem-image" data-replace="assets/gems/emerald-cut-600x600.jpg">
          </div>
          <div class="gem-caption">
            <h3>ALCHEMY</h3>
            <p>Transforming raw assets into modern authority systems.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PRESTIGE -->
    <section class="prestige" id="prestige">
      <div class="section-with-gem gem-left">
        <div class="gem-inline gem-square">
          <div class="gem-stage" style="aspect-ratio: 1/1; border-radius: 60px; margin: 1rem;">
            <div class="gem-placeholder">
              <span class="gem-label" style="font-size: 1.4rem;">IMG-03</span>
              <span class="gem-dims">500 × 500 PX</span>
              <span class="gem-desc">Polished & Set in Precious Metal</span>
              <span class="gem-stage-label">Stage 3: Polished</span>
            </div>
            <img src="" alt="Polished emerald" class="gem-image" data-replace="assets/gems/emerald-set-500x500.jpg">
          </div>
          <div class="gem-caption">
            <h3>PRESTIGE</h3>
            <p>Your authority, displayed for the world to see.</p>
          </div>
        </div>

        <div class="gem-content">
          <div class="stage-heading-container">
            <h2 class="stage-heading">The Prestige of Display</h2>
          </div>
          <p>Polished authority deserves museum-quality presentation. Your expertise, displayed for the world to see.</p>

          <div class="services-grid" style="margin-top: 2rem;">
            <article class="service-card">
              <div class="service-tag">Visibility</div>
              <h3>Platform Authority</h3>
              <p>Consistent presence across LinkedIn, YouTube, podcast, and press.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Trust</div>
              <h3>Social Proof Systems</h3>
              <p>Case studies and testimonials that convert skeptics.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Conversion</div>
              <h3>Authority Funnels</h3>
              <p>Every touchpoint engineered to convert attention to revenue.</p>
            </article>
          </div>
        </div>
      </div>
    </section>

    <!-- AUTHORITY -->
    <section class="authority" id="authority">
      <div class="section-with-gem gem-right">
        <div class="gem-content">
          <div class="stage-heading-container">
            <h2 class="stage-heading">Camera Authority</h2>
          </div>
          <p>On-camera presence for the authority economy. From script to screen, we build your video confidence and production quality.</p>

          <div class="services-grid" style="margin-top: 2rem;">
            <article class="service-card">
              <div class="service-tag">Foundation</div>
              <h3>On-Camera Training</h3>
              <p>Posture, framing, lighting, and delivery naturalization.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Technical</div>
              <h3>Production Excellence</h3>
              <p>Audio, background, multi-camera setups.</p>
            </article>
            <article class="service-card">
              <div class="service-tag">Platform</div>
              <h3>Channel Optimization</h3>
              <p>Platform-specific skills for maximum reach.</p>
            </article>
          </div>
        </div>

        <div class="gem-inline">
          <div class="gem-stage">
            <div class="gem-placeholder">
              <span class="gem-label" style="font-size: 1.4rem;">IMG-04</span>
              <span class="gem-dims">400 × 400 PX</span>
              <span class="gem-desc">Camera Authority Display</span>
              <span class="gem-stage-label">Display</span>
            </div>
            <img src="" alt="Camera authority" class="gem-image" data-replace="assets/gems/camera-display-400x400.jpg">
          </div>
          <div class="gem-caption">
            <h3>CAM AUTHORITY</h3>
            <p>On-camera presence excavation and refinement.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section class="contact" id="contact">
      <div class="container">
        <div class="section-header">
          <div class="stage-heading-container">
            <h2 class="stage-heading">Request a Private Conversation</h2>
          </div>
          <p>Share a few details. If there's a fit, you'll hear from us with next steps.</p>
        </div>
        <div style="text-align: center;">
          <button class="btn-primary" style="margin: 2rem 0;">Begin Application</button>
          <p style="font-size: 0.8rem; color: rgba(249, 249, 255, 0.4);">
            Limited to 3 new clients per quarter. Current wait: 6 weeks.
          </p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container footer-inner">
      <span>LEGAISEE — Business Archaeology & Authority Systems</span>
      <span>Discreet. Invitation‑only. Outcome‑obsessed.</span>
    </div>
  </footer>

  <script>
    const gemImages = document.querySelectorAll('.gem-image[data-replace]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          const src = img.getAttribute('data-replace');
          if (src) {
            img.src = src;
            img.onload = () => img.classList.add('loaded');
          }
          observer.unobserve(img);
        }
      });
    }, { threshold: 0.1 });

    gemImages.forEach(img => imageObserver.observe(img));
  </script>

</body>
</html>


