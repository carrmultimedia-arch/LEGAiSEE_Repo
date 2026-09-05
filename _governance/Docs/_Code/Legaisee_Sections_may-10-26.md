<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services â€” LEGAISEE Business Archaeology</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="master-truth.css">
  <link rel="stylesheet" href="prestige-additions.css">



 


/* ============================================================
   LEGAISEE MASTER TRUTH CSS
   Design System v1.0 â€” Museum-Quality Prestige
   ============================================================ */

<style>

:root {
  /* Core Palette */
  --obsidian: #050505;
  --obsidian-light: #0a0a0a;
  --obsidian-raised: #111111;
  --gold: #C9A961;
  --gold-bright: #D4B978;
  --gold-dim: #A08540;
  --platinum: #E5E5E5;
  --silver: #A0A0A0;
  --silver-dim: #6B6B6B;
  --cosmic-violet: #3b2b5f;
  --cosmic-violet-deep: #2a1f45;
  
  /* Typography Scale */
  --font-display: 'Cinzel', Georgia, serif;
  --font-heading: 'Cormorant Garamond', Georgia, serif;
  --font-body: 'Montserrat', -apple-system, sans-serif;
  --font-ui: 'Inter', -apple-system, sans-serif;
  
  --text-xs: clamp(0.75rem, 0.7vw, 0.875rem);
  --text-sm: clamp(0.875rem, 0.85vw, 1rem);
  --text-base: clamp(1rem, 1vw, 1.125rem);
  --text-lg: clamp(1.125rem, 1.2vw, 1.25rem);
  --text-xl: clamp(1.25rem, 1.5vw, 1.5rem);
  --text-2xl: clamp(1.5rem, 2vw, 2rem);
  --text-3xl: clamp(2rem, 2.5vw, 2.5rem);
  --text-4xl: clamp(2.5rem, 3vw, 3.5rem);
  --text-5xl: clamp(3rem, 4vw, 5rem);
  --text-6xl: clamp(4rem, 5vw, 7rem);
  
  /* Spacing Scale */
  --space-1: 0.25rem;
  --space-2: 0.5rem;
  --space-3: 0.75rem;
  --space-4: 1rem;
  --space-5: 1.25rem;
  --space-6: 1.5rem;
  --space-8: 2rem;
  --space-10: 2.5rem;
  --space-12: 3rem;
  --space-16: 4rem;
  --space-20: 5rem;
  --space-24: 6rem;
  --space-32: 8rem;
  --space-40: 10rem;
  
  /* Layout */
  --max-width: 1440px;
  --content-width: 1200px;
  --narrow-width: 900px;
  
  /* Effects */
  --transition-fast: 150ms ease;
  --transition-base: 300ms ease;
  --transition-slow: 500ms ease;
  --transition-prestige: 800ms cubic-bezier(0.4, 0, 0.2, 1);
  
  /* Shadows */
  --shadow-sm: 0 1px 2px rgba(0,0,0,0.3);
  --shadow-md: 0 4px 12px rgba(0,0,0,0.4);
  --shadow-lg: 0 8px 30px rgba(0,0,0,0.5);
  --shadow-prestige: 0 20px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(201,169,97,0.1);
  
  /* Borders */
  --border-hairline: 1px solid rgba(229,229,229,0.1);
  --border-subtle: 1px solid rgba(201,169,97,0.2);
  --border-gold: 1px solid var(--gold);
}

/* ============================================================
   RESET & BASE
   ============================================================ */

*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 16px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  scroll-behavior: smooth;
}

body {
  font-family: var(--font-body);
  font-size: var(--text-base);
  line-height: 1.6;
  color: var(--platinum);
  background: var(--obsidian);
  overflow-x: hidden;
}

img {
  max-width: 100%;
  height: auto;
  display: block;
}

a {
  color: var(--gold);
  text-decoration: none;
  transition: color var(--transition-base);
}

a:hover {
  color: var(--gold-bright);
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */

.font-display { font-family: var(--font-display); }
.font-heading { font-family: var(--font-heading); }
.font-body { font-family: var(--font-body); }
.font-ui { font-family: var(--font-ui); }

.text-xs { font-size: var(--text-xs); }
.text-sm { font-size: var(--text-sm); }
.text-base { font-size: var(--text-base); }
.text-lg { font-size: var(--text-lg); }
.text-xl { font-size: var(--text-xl); }
.text-2xl { font-size: var(--text-2xl); }
.text-3xl { font-size: var(--text-3xl); }
.text-4xl { font-size: var(--text-4xl); }
.text-5xl { font-size: var(--text-5xl); }
.text-6xl { font-size: var(--text-6xl); }

.leading-tight { line-height: 1.2; }
.leading-snug { line-height: 1.4; }
.leading-normal { line-height: 1.6; }
.leading-relaxed { line-height: 1.8; }

.tracking-tight { letter-spacing: -0.02em; }
.tracking-normal { letter-spacing: 0; }
.tracking-wide { letter-spacing: 0.05em; }
.tracking-wider { letter-spacing: 0.1em; }
.tracking-widest { letter-spacing: 0.2em; }

.uppercase { text-transform: uppercase; }
.lowercase { text-transform: lowercase; }
.capitalize { text-transform: capitalize; }

.text-obsidian { color: var(--obsidian); }
.text-obsidian-light { color: var(--obsidian-light); }
.text-gold { color: var(--gold); }
.text-gold-bright { color: var(--gold-bright); }
.text-platinum { color: var(--platinum); }
.text-silver { color: var(--silver); }
.text-silver-dim { color: var(--silver-dim); }
.text-violet { color: var(--cosmic-violet); }

/* ============================================================
   BACKGROUNDS & EFFECTS
   ============================================================ */

.bg-obsidian { background: var(--obsidian); }
.bg-obsidian-light { background: var(--obsidian-light); }
.bg-obsidian-raised { background: var(--obsidian-raised); }
.bg-gold { background: var(--gold); }
.bg-violet { background: var(--cosmic-violet); }
.bg-violet-deep { background: var(--cosmic-violet-deep); }

/* Flow Gradient â€” 20s infinite */
@keyframes flowGradient {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

.flow-gradient {
  background: linear-gradient(
    135deg,
    var(--obsidian) 0%,
    var(--cosmic-violet-deep) 25%,
    var(--cosmic-violet) 50%,
    var(--cosmic-violet-deep) 75%,
    var(--obsidian) 100%
  );
  background-size: 400% 400%;
  animation: flowGradient 20s ease infinite;
}

/* Sheen Sweep â€” 8s diagonal */
@keyframes sheenSweep {
  0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
  100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.sheen-sweep {
  position: relative;
  overflow: hidden;
}

.sheen-sweep::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 50%;
  height: 200%;
  background: linear-gradient(
    90deg,
    transparent 0%,
    rgba(201,169,97,0.1) 50%,
    transparent 100%
  );
  animation: sheenSweep 8s ease-in-out infinite;
  pointer-events: none;
}

/* Spotlight Sweep â€” 5s, 3000K warm, 45Â° */
@keyframes spotlightSweep {
  0% { transform: translateX(-100%) rotate(45deg); opacity: 0; }
  10% { opacity: 1; }
  90% { opacity: 1; }
  100% { transform: translateX(200%) rotate(45deg); opacity: 0; }
}

.spotlight-sweep {
  position: relative;
  overflow: hidden;
}

.spotlight-sweep::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    90deg,
    transparent 0%,
    rgba(255,200,150,0.15) 50%,
    transparent 100%
  );
  animation: spotlightSweep 5s ease-in-out infinite;
  pointer-events: none;
  z-index: 2;
}

/* ============================================================
   LAYOUT UTILITIES
   ============================================================ */

.container {
  width: 100%;
  max-width: var(--max-width);
  margin: 0 auto;
  padding: 0 var(--space-6);
}

.content-width {
  max-width: var(--content-width);
  margin: 0 auto;
}

.narrow-width {
  max-width: var(--narrow-width);
  margin: 0 auto;
}

/* Asymmetric Grids */
.grid-12 {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: var(--space-6);
}

.flex-uneven {
  display: flex;
  gap: var(--space-8);
}

.flex-uneven > :first-child {
  flex: 1.618;
}

.flex-uneven > :last-child {
  flex: 1;
}

.asymmetric-2col {
  display: grid;
  grid-template-columns: 1fr 0.618fr;
  gap: var(--space-16);
  align-items: center;
}

@media (max-width: 1024px) {
  .asymmetric-2col {
    grid-template-columns: 1fr;
    gap: var(--space-8);
  }
  
  .flex-uneven {
    flex-direction: column;
  }
}

/* ============================================================
   SPACING UTILITIES
   ============================================================ */

.p-1 { padding: var(--space-1); }
.p-2 { padding: var(--space-2); }
.p-4 { padding: var(--space-4); }
.p-6 { padding: var(--space-6); }
.p-8 { padding: var(--space-8); }
.p-12 { padding: var(--space-12); }
.p-16 { padding: var(--space-16); }
.p-20 { padding: var(--space-20); }
.p-24 { padding: var(--space-24); }
.p-32 { padding: var(--space-32); }
.p-40 { padding: var(--space-40); }

.py-8 { padding-top: var(--space-8); padding-bottom: var(--space-8); }
.py-12 { padding-top: var(--space-12); padding-bottom: var(--space-12); }
.py-16 { padding-top: var(--space-16); padding-bottom: var(--space-16); }
.py-24 { padding-top: var(--space-24); padding-bottom: var(--space-24); }
.py-32 { padding-top: var(--space-32); padding-bottom: var(--space-32); }
.py-40 { padding-top: var(--space-40); padding-bottom: var(--space-40); }

.px-4 { padding-left: var(--space-4); padding-right: var(--space-4); }
.px-6 { padding-left: var(--space-6); padding-right: var(--space-6); }
.px-8 { padding-left: var(--space-8); padding-right: var(--space-8); }

.m-0 { margin: 0; }
.mb-2 { margin-bottom: var(--space-2); }
.mb-4 { margin-bottom: var(--space-4); }
.mb-6 { margin-bottom: var(--space-6); }
.mb-8 { margin-bottom: var(--space-8); }
.mb-12 { margin-bottom: var(--space-12); }
.mb-16 { margin-bottom: var(--space-16); }
.mb-24 { margin-bottom: var(--space-24); }

/* ============================================================
   COMPONENTS
   ============================================================ */

/* Catalog Number â€” Museum Label */
.catalog-number {
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--gold-dim);
  margin-bottom: var(--space-4);
}

/* Specimen Card */
.specimen-card {
  background: var(--obsidian-raised);
  border: var(--border-subtle);
  padding: var(--space-8);
  position: relative;
  transition: transform var(--transition-prestige), box-shadow var(--transition-prestige);
}

.specimen-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-prestige);
}

.specimen-card::before {
  content: attr(data-catalog);
  position: absolute;
  top: var(--space-4);
  right: var(--space-4);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.1em;
  color: var(--gold-dim);
}

.specimen-card .era {
  font-family: var(--font-ui);
  font-size: var(--text-sm);
  color: var(--silver);
  margin-top: var(--space-4);
}

.specimen-card .provenance {
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  color: var(--silver-dim);
  margin-top: var(--space-2);
}

/* Gemstone Placeholder */
.gem-placeholder {
  position: relative;
  width: 100%;
  aspect-ratio: 1;
  background: var(--obsidian-light);
  border: var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.gem-placeholder::before {
  content: attr(data-dimensions);
  position: absolute;
  bottom: var(--space-4);
  left: var(--space-4);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.1em;
  color: var(--silver-dim);
  z-index: 3;
}

.gem-placeholder canvas,
.gem-placeholder img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* Invitation Lock */
.invitation-lock {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--gold);
  padding: var(--space-2) var(--space-4);
  border: var(--border-subtle);
}

.invitation-lock::before {
  content: 'â—†';
  color: var(--gold);
}

/* Button â€” Prestige */
.btn-prestige {
  display: inline-flex;
  align-items: center;
  gap: var(--space-3);
  font-family: var(--font-ui);
  font-size: var(--text-sm);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--obsidian);
  background: var(--gold);
  padding: var(--space-4) var(--space-8);
  border: none;
  cursor: pointer;
  transition: all var(--transition-base);
}

.btn-prestige:hover {
  background: var(--gold-bright);
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.btn-prestige::after {
  content: 'â†’';
  transition: transform var(--transition-base);
}

.btn-prestige:hover::after {
  transform: translateX(4px);
}

/* Button â€” Ghost */
.btn-ghost {
  display: inline-flex;
  align-items: center;
  gap: var(--space-3);
  font-family: var(--font-ui);
  font-size: var(--text-sm);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--gold);
  background: transparent;
  padding: var(--space-4) var(--space-8);
  border: var(--border-subtle);
  cursor: pointer;
  transition: all var(--transition-base);
}

.btn-ghost:hover {
  background: rgba(201,169,97,0.1);
  border-color: var(--gold);
}

/* Divider â€” Ornamental */
.divider-ornamental {
  display: flex;
  align-items: center;
  gap: var(--space-4);
  color: var(--gold-dim);
  font-size: var(--text-xs);
  letter-spacing: 0.2em;
}

.divider-ornamental::before,
.divider-ornamental::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(
    90deg,
    transparent 0%,
    var(--gold-dim) 50%,
    transparent 100%
  );
}

/* ============================================================
   SECTIONS â€” 26 Types
   ============================================================ */

/* Section Base */
.section {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.section-prestige {
  padding: var(--space-32) 0;
  background: var(--obsidian);
}

.section-content {
  padding: var(--space-24) 0;
}

/* 1. prestige-hero */
.prestige-hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: var(--obsidian);
}

.prestige-hero .hero-content {
  max-width: 60%;
}

.prestige-hero .hero-visual {
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 35%;
  max-width: 500px;
}

@media (max-width: 1024px) {
  .prestige-hero .hero-content {
    max-width: 100%;
  }
  .prestige-hero .hero-visual {
    position: relative;
    width: 100%;
    transform: none;
    margin-top: var(--space-12);
  }
}

/* 2. prestige-manifesto */
.prestige-manifesto {
  text-align: left;
  padding: var(--space-40) 0;
}

.prestige-manifesto .statement {
  font-family: var(--font-heading);
  font-size: var(--text-5xl);
  line-height: 1.2;
  color: var(--platinum);
  max-width: 900px;
}

.prestige-manifesto .statement em {
  color: var(--gold);
  font-style: italic;
}

/* 3. prestige-services */
.prestige-services .service-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-8);
}

.prestige-services .service-item {
  padding: var(--space-8);
  border: var(--border-hairline);
  transition: all var(--transition-base);
}

.prestige-services .service-item:hover {
  border-color: var(--gold-dim);
  background: var(--obsidian-raised);
}

.prestige-services .service-detail {
  max-height: 0;
  overflow: hidden;
  transition: max-height var(--transition-slow);
}

.prestige-services .service-item.active .service-detail {
  max-height: 500px;
}

@media (max-width: 768px) {
  .prestige-services .service-grid {
    grid-template-columns: 1fr;
  }
}

/* 4. prestige-process */
.prestige-process .process-phases {
  display: flex;
  gap: var(--space-8);
  counter-reset: phase;
}

.prestige-process .phase {
  flex: 1;
  position: relative;
  padding-left: var(--space-12);
}

.prestige-process .phase::before {
  counter-increment: phase;
  content: counter(phase, upper-roman);
  position: absolute;
  left: 0;
  top: 0;
  font-family: var(--font-display);
  font-size: var(--text-3xl);
  color: var(--gold-dim);
  line-height: 1;
}

@media (max-width: 768px) {
  .prestige-process .process-phases {
    flex-direction: column;
  }
}

/* 5. prestige-specimen */
.prestige-specimen .specimen-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
}

@media (max-width: 1024px) {
  .prestige-specimen .specimen-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .prestige-specimen .specimen-grid {
    grid-template-columns: 1fr;
  }
}

/* 6. prestige-testimonial */
.prestige-testimonial {
  background: var(--cosmic-violet-deep);
}

.prestige-testimonial .testimonial-slider {
  position: relative;
  overflow: hidden;
}

.prestige-testimonial .testimonial-slide {
  opacity: 0;
  position: absolute;
  transition: opacity var(--transition-slow);
}

.prestige-testimonial .testimonial-slide.active {
  opacity: 1;
  position: relative;
}

.prestige-testimonial .quote {
  font-family: var(--font-heading);
  font-size: var(--text-3xl);
  line-height: 1.4;
  color: var(--platinum);
  margin-bottom: var(--space-8);
}

.prestige-testimonial .attribution {
  font-family: var(--font-ui);
  font-size: var(--text-sm);
  color: var(--silver);
}

/* 7. prestige-cta */
.prestige-cta {
  text-align: center;
  padding: var(--space-32) 0;
  background: var(--cosmic-violet);
}

.prestige-cta .invitation-text {
  font-family: var(--font-heading);
  font-size: var(--text-4xl);
  color: var(--platinum);
  margin-bottom: var(--space-8);
}

/* 8. prestige-footer */
.prestige-footer {
  padding: var(--space-16) 0;
  background: var(--obsidian);
  border-top: var(--border-hairline);
}

.prestige-footer .footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr;
  gap: var(--space-12);
}

@media (max-width: 768px) {
  .prestige-footer .footer-grid {
    grid-template-columns: 1fr;
  }
}

/* 9-26. Content Sections (abbreviated for space) */
.content-hero { padding: var(--space-24) 0; }
.content-split { padding: var(--space-24) 0; }
.content-feature { padding: var(--space-24) 0; }
.content-pricing { padding: var(--space-24) 0; }
.content-team { padding: var(--space-24) 0; }
.content-faq { padding: var(--space-24) 0; }
.content-blog { padding: var(--space-24) 0; }
.content-contact { padding: var(--space-24) 0; }
.content-gallery { padding: var(--space-24) 0; }
.content-timeline { padding: var(--space-24) 0; }
.content-stats { padding: var(--space-24) 0; }
.content-logos { padding: var(--space-16) 0; }
.content-newsletter { padding: var(--space-24) 0; }
.content-video { padding: 0; position: relative; min-height: 80vh; }
.content-map { padding: var(--space-24) 0; }
.content-download { padding: var(--space-24) 0; }
.content-social { padding: var(--space-16) 0; }
.content-simple { padding: var(--space-16) 0; }

/* ============================================================
   UTILITY CLASSES
   ============================================================ */

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.hidden { display: none; }
.block { display: block; }
.inline-block { display: inline-block; }
.flex { display: flex; }
.inline-flex { display: inline-flex; }
.grid { display: grid; }

.items-center { align-items: center; }
.items-start { align-items: flex-start; }
.items-end { align-items: flex-end; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }

.relative { position: relative; }
.absolute { position: absolute; }
.fixed { position: fixed; }

.z-10 { z-index: 10; }
.z-20 { z-index: 20; }
.z-30 { z-index: 30; }

.overflow-hidden { overflow: hidden; }

.w-full { width: 100%; }
.h-full { height: 100%; }

.border-hairline { border: var(--border-hairline); }
.border-subtle { border: var(--border-subtle); }
.border-gold { border: var(--border-gold); }

/* ============================================================
   LEGAISEE PRESTIGE ADDITIONS
   Speak-easy, Invitation-only, Museum-Quality Enhancements
   ============================================================ */

/* ============================================================
   SPEAK-EASY ELEMENTS
   ============================================================ */

/* Hidden/Reveal Interaction */
.reveal-container {
  position: relative;
  overflow: hidden;
}

.reveal-content {
  opacity: 0;
  transform: translateY(20px);
  transition: all var(--transition-prestige);
  filter: blur(4px);
}

.reveal-container:hover .reveal-content,
.reveal-container.active .reveal-content {
  opacity: 1;
  transform: translateY(0);
  filter: blur(0);
}

.reveal-trigger {
  cursor: pointer;
  position: relative;
  padding-right: var(--space-8);
}

.reveal-trigger::after {
  content: 'â—†';
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  color: var(--gold);
  transition: transform var(--transition-base);
}

.reveal-container:hover .reveal-trigger::after,
.reveal-container.active .reveal-trigger::after {
  transform: translateY(-50%) rotate(45deg);
}

/* Password-Protected Visual Styling */
.vault-section {
  position: relative;
  background: var(--obsidian-raised);
  border: 2px solid var(--gold-dim);
}

.vault-section::before {
  content: 'â—† â—† â—†';
  position: absolute;
  top: var(--space-4);
  right: var(--space-4);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.5em;
  color: var(--gold-dim);
}

.vault-lock {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-4);
  padding: var(--space-8);
  border-bottom: var(--border-subtle);
}

.vault-lock .lock-icon {
  width: 24px;
  height: 24px;
  border: 2px solid var(--gold);
  border-radius: 50%;
  position: relative;
}

.vault-lock .lock-icon::after {
  content: '';
  position: absolute;
  top: -8px;
  left: 50%;
  transform: translateX(-50%);
  width: 12px;
  height: 12px;
  border: 2px solid var(--gold);
  border-bottom: none;
  border-radius: 50% 50% 0 0;
}

/* Member Since Stamp */
.member-stamp {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  padding: var(--space-4) var(--space-6);
  border: var(--border-subtle);
  position: relative;
}

.member-stamp::before {
  content: 'MEMBER';
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.3em;
  color: var(--gold-dim);
  margin-bottom: var(--space-1);
}

.member-stamp .since-date {
  font-family: var(--font-display);
  font-size: var(--text-lg);
  color: var(--gold);
}

/* Limited Availability Counter */
.availability-indicator {
  display: inline-flex;
  align-items: center;
  gap: var(--space-3);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--silver);
}

.availability-indicator .slots {
  display: flex;
  gap: var(--space-1);
}

.availability-indicator .slot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--gold);
}

.availability-indicator .slot.taken {
  background: var(--obsidian-raised);
  border: 1px solid var(--gold-dim);
}

/* ============================================================
   MUSEUM-QUALITY ENHANCEMENTS
   ============================================================ */

/* Display Case Effect */
.display-case {
  position: relative;
  background: var(--obsidian-light);
  border: var(--border-subtle);
  box-shadow: 
    inset 0 0 60px rgba(0,0,0,0.5),
    0 4px 20px rgba(0,0,0,0.3);
}

.display-case::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 30%;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.03) 0%,
    transparent 100%
  );
  pointer-events: none;
}

/* Glass Reflection */
.glass-reflection {
  position: relative;
  overflow: hidden;
}

.glass-reflection::after {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: linear-gradient(
    45deg,
    transparent 40%,
    rgba(255,255,255,0.03) 50%,
    transparent 60%
  );
  pointer-events: none;
}

/* Conservation Status Indicators */
.conservation-status {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  padding: var(--space-1) var(--space-3);
  border-radius: 2px;
}

.conservation-status.preserved {
  color: var(--gold);
  border: 1px solid var(--gold);
}

.conservation-status.restored {
  color: #7EB8A2;
  border: 1px solid #7EB8A2;
}

.conservation-status.fragment {
  color: var(--silver-dim);
  border: 1px solid var(--silver-dim);
}

.conservation-status::before {
  content: '';
  width: 6px;
  height: 6px;
  border-radius: 50%;
}

.conservation-status.preserved::before { background: var(--gold); }
.conservation-status.restored::before { background: #7EB8A2; }
.conservation-status.fragment::before { background: var(--silver-dim); }

/* On Loan From Attribution */
.on-loan {
  display: flex;
  align-items: baseline;
  gap: var(--space-2);
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  color: var(--silver-dim);
}

.on-loan::before {
  content: 'On loan from';
  font-style: italic;
}

/* Label Typography â€” Small Caps */
.label-small-caps {
  font-family: var(--font-ui);
  font-size: var(--text-xs);
  letter-spacing: 0.15em;
  text-transform: uppercase;
  font-variant: small-caps;
  color: var(--silver);
}

/* ============================================================
   GEMSTONE DISPLAY CASE
   ============================================================ */

.gem-case {
  position: relative;
  width: 100%;
  max-width: 1024px;
  margin: 0 auto;
  background: var(--obsidian-raised);
  border-radius: 4px;
  overflow: hidden;
}

.gem-case-frame {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border: 50px solid transparent;
  border-image: linear-gradient(
    135deg,
    #C0C0C0 0%,
    #E8E8E8 25%,
    #A0A0A0 50%,
    #D0D0D0 75%,
    #909090 100%
  ) 1;
  pointer-events: none;
  z-index: 10;
}

.gem-case-frame.gold {
  border-image: linear-gradient(
    135deg,
    var(--gold-dim) 0%,
    var(--gold) 25%,
    var(--gold-bright) 50%,
    var(--gold) 75%,
    var(--gold-dim) 100%
  ) 1;
}

.gem-case-frame.rose-gold {
  border-image: linear-gradient(
    135deg,
    #B76E79 0%,
    #E8B4B4 25%,
    #C9878E 50%,
    #E8B4B4 75%,
    #B76E79 100%
  ) 1;
}

.gem-case-frame.platinum {
  border-image: linear-gradient(
    135deg,
    #A0A0A0 0%,
    #E5E5E5 25%,
    #B8B8B8 50%,
    #F0F0F0 75%,
    #909090 100%
  ) 1;
}

.gem-case-interior {
  position: relative;
  width: 100%;
  aspect-ratio: 1;
  background: 
    radial-gradient(ellipse at 30% 20%, rgba(255,255,255,0.05) 0%, transparent 50%),
    radial-gradient(ellipse at 70% 80%, rgba(201,169,97,0.03) 0%, transparent 50%),
    var(--obsidian);
  margin: 50px;
  width: calc(100% - 100px);
  height: calc(100% - 100px);
}

.gem-case-glass {
  position: absolute;
  top: 50px;
  left: 50px;
  right: 50px;
  bottom: 50px;
  background: linear-gradient(
    135deg,
    rgba(255,255,255,0.03) 0%,
    transparent 30%,
    transparent 70%,
    rgba(255,255,255,0.02) 100%
  );
  z-index: 5;
  pointer-events: none;
}

/* ============================================================
   SEAMLESS SECTION TRANSITIONS
   ============================================================ */

/* Black â†’ Violet */
.section-to-violet {
  background: linear-gradient(
    180deg,
    var(--obsidian) 0%,
    var(--obsidian) 80%,
    var(--cosmic-violet-deep) 100%
  );
}

/* Violet â†’ Black */
.section-to-black {
  background: linear-gradient(
    180deg,
    var(--cosmic-violet) 0%,
    var(--cosmic-violet-deep) 80%,
    var(--obsidian) 100%
  );
}

/* Black â†’ Gold */
.section-to-gold {
  background: linear-gradient(
    180deg,
    var(--obsidian) 0%,
    var(--obsidian) 80%,
    rgba(201,169,97,0.1) 100%
  );
}

/* Gold â†’ Black */
.section-from-gold {
  background: linear-gradient(
    180deg,
    rgba(201,169,97,0.1) 0%,
    var(--obsidian) 20%,
    var(--obsidian) 100%
  );
}

/* Pure Black Buffer */
.section-black-buffer {
  background: var(--obsidian);
  padding: var(--space-16) 0;
}

/* ============================================================
   INTERACTION STATES
   ============================================================ */

/* Hover Lift with Shadow */
.hover-lift {
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}

.hover-lift:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-prestige);
}

/* Magnetic Button Effect */
.magnetic-btn {
  position: relative;
  transition: transform 0.3s ease;
}

/* Text Reveal on Scroll */
.text-reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.text-reveal.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Stagger Children */
.stagger-children > * {
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.6s ease;
}

.stagger-children.visible > *:nth-child(1) { transition-delay: 0.1s; opacity: 1; transform: translateY(0); }
.stagger-children.visible > *:nth-child(2) { transition-delay: 0.2s; opacity: 1; transform: translateY(0); }
.stagger-children.visible > *:nth-child(3) { transition-delay: 0.3s; opacity: 1; transform: translateY(0); }
.stagger-children.visible > *:nth-child(4) { transition-delay: 0.4s; opacity: 1; transform: translateY(0); }

/* ============================================================
   LOADING & TRANSITION STATES
   ============================================================ */

/* Skeleton Loading */
.skeleton {
  background: linear-gradient(
    90deg,
    var(--obsidian-raised) 0%,
    var(--obsidian-light) 50%,
    var(--obsidian-raised) 100%
  );
  background-size: 200% 100%;
  animation: skeleton 1.5s infinite;
}

@keyframes skeleton {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Page Transition */
.page-transition {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: var(--obsidian);
  z-index: 9999;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.5s ease;
}

.page-transition.active {
  opacity: 1;
  pointer-events: all;
}

/* ============================================================
   PRINT STYLES
   ============================================================ */

@media print {
  .section {
    background: white !important;
    color: black !important;
  }
  
  .gem-placeholder,
  .spotlight-sweep::before,
  .sheen-sweep::after,
  .flow-gradient {
    display: none;
  }
  
  .btn-prestige,
  .btn-ghost {
    border: 1px solid black;
    color: black;
    background: transparent;
  }
}

/**
 * LEGAISEE Gemstone Display System
 * 3D gemstone rendering with swappable materials
 * Canvas 1024Ã—1024px, stone 700Ã—880px interior, 50px chrome border
 */

class GemstoneDisplay {
  constructor(canvasId, options = {}) {
    this.canvas = document.getElementById(canvasId);
    if (!this.canvas) return;
    
    this.ctx = this.canvas.getContext('2d');
    this.width = 1024;
    this.height = 1024;
    this.stoneWidth = 700;
    this.stoneHeight = 880;
    this.borderWidth = 50;
    
    // Options
    this.stoneHue = options.hue || 280; // Violet default
    this.caseMaterial = options.caseMaterial || 'chrome'; // chrome, gold, rose-gold, platinum
    this.viewAngle = options.viewAngle || 0; // 0, -45, 45 degrees
    
    // Initialize
    this.init();
  }
  
  init() {
    this.canvas.width = this.width;
    this.canvas.height = this.height;
    this.render();
  }
  
  // Color utilities
  hsl(h, s, l) {
    return `hsl(${h}, ${s}%, ${l}%)`;
  }
  
  // Case material gradients
  getCaseGradient(material, x, y, w, h) {
    const gradients = {
      chrome: () => {
        const g = this.ctx.createLinearGradient(x, y, x + w, y + h);
        g.addColorStop(0, '#A0A0A0');
        g.addColorStop(0.25, '#E8E8E8');
        g.addColorStop(0.5, '#C0C0C0');
        g.addColorStop(0.75, '#F5F5F5');
        g.addColorStop(1, '#909090');
        return g;
      },
      gold: () => {
        const g = this.ctx.createLinearGradient(x, y, x + w, y + h);
        g.addColorStop(0, '#A08540');
        g.addColorStop(0.25, '#D4B978');
        g.addColorStop(0.5, '#C9A961');
        g.addColorStop(0.75, '#E8D4A0');
        g.addColorStop(1, '#8B7340');
        return g;
      },
      'rose-gold': () => {
        const g = this.ctx.createLinearGradient(x, y, x + w, y + h);
        g.addColorStop(0, '#B76E79');
        g.addColorStop(0.25, '#E8B4B4');
        g.addColorStop(0.5, '#C9878E');
        g.addColorStop(0.75, '#F0C8C8');
        g.addColorStop(1, '#A0606B');
        return g;
      },
      platinum: () => {
        const g = this.ctx.createLinearGradient(x, y, x + w, y + h);
        g.addColorStop(0, '#909090');
        g.addColorStop(0.25, '#E5E5E5');
        g.addColorStop(0.5, '#B8B8B8');
        g.addColorStop(0.75, '#F0F0F0');
        g.addColorStop(1, '#808080');
        return g;
      }
    };
    
    return (gradients[material] || gradients.chrome)();
  }
  
  // Draw faceted gemstone
  drawStone(hue) {
    const ctx = this.ctx;
    const cx = this.width / 2;
    const cy = this.height / 2;
    const w = this.stoneWidth / 2;
    const h = this.stoneHeight / 2;
    
    // Apply rotation for view angle
    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate((this.viewAngle * Math.PI) / 180);
    
    // Stone shadow
    ctx.fillStyle = 'rgba(0,0,0,0.3)';
    ctx.beginPath();
    ctx.ellipse(10, 20, w * 0.9, h * 0.15, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Main stone body (oval cut)
    const stoneGradient = ctx.createRadialGradient(-w*0.3, -h*0.3, 0, 0, 0, w);
    stoneGradient.addColorStop(0, this.hsl(hue, 60, 70));
    stoneGradient.addColorStop(0.3, this.hsl(hue, 50, 50));
    stoneGradient.addColorStop(0.7, this.hsl(hue, 70, 35));
    stoneGradient.addColorStop(1, this.hsl(hue, 80, 20));
    
    ctx.fillStyle = stoneGradient;
    ctx.beginPath();
    ctx.ellipse(0, 0, w, h, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Facets (simplified oval cut pattern)
    const facets = [
      // Table (top center)
      { x: 0, y: -h * 0.4, w: w * 0.4, h: h * 0.25, l: 75 },
      // Crown facets
      { x: -w * 0

      { x: -w * 0.3, y: -h * 0.2, w: w * 0.25, h: h * 0.2, l: 65 },
      { x: w * 0.3, y: -h * 0.2, w: w * 0.25, h: h * 0.2, l: 65 },
      { x: -w * 0.5, y: 0, w: w * 0.2, h: h * 0.3, l: 55 },
      { x: w * 0.5, y: 0, w: w * 0.2, h: h * 0.3, l: 55 },
      // Pavilion facets
      { x: -w * 0.25, y: h * 0.3, w: w * 0.3, h: h * 0.25, l: 45 },
      { x: w * 0.25, y: h * 0.3, w: w * 0.3, h: h * 0.25, l: 45 },
      { x: 0, y: h * 0.6, w: w * 0.2, h: h * 0.15, l: 35 }
    ];
    
    facets.forEach(facet => {
      const fg = ctx.createLinearGradient(
        facet.x - facet.w, facet.y - facet.h,
        facet.x + facet.w, facet.y + facet.h
      );
      fg.addColorStop(0, this.hsl(hue, 60, facet.l + 10));
      fg.addColorStop(0.5, this.hsl(hue, 50, facet.l));
      fg.addColorStop(1, this.hsl(hue, 70, facet.l - 10));
      
      ctx.fillStyle = fg;
      ctx.beginPath();
      ctx.ellipse(facet.x, facet.y, facet.w, facet.h, 0, 0, Math.PI * 2);
      ctx.fill();
      
      // Facet edge highlight
      ctx.strokeStyle = `hsla(${hue}, 80%, 80%, 0.3)`;
      ctx.lineWidth = 1;
      ctx.stroke();
    });
    
    // Center highlight (table reflection)
    const highlight = ctx.createRadialGradient(-w*0.2, -h*0.2, 0, 0, 0, w*0.5);
    highlight.addColorStop(0, `hsla(${hue}, 30%, 95%, 0.8)`);
    highlight.addColorStop(0.5, `hsla(${hue}, 50%, 70%, 0.2)`);
    highlight.addColorStop(1, 'transparent');
    
    ctx.fillStyle = highlight;
    ctx.beginPath();
    ctx.ellipse(0, 0, w*0.6, h*0.6, 0, 0, Math.PI*2);
    ctx.fill();
    
    ctx.restore();
  }
  
  // Draw case walls
  drawCase() {
    const ctx = this.ctx;
    const b = this.borderWidth;
    const w = this.width;
    const h = this.height;
    
    // Side walls (3D effect)
    const wallGradient = this.ctx.createLinearGradient(0, 0, b, 0);
    wallGradient.addColorStop(0, 'rgba(0,0,0,0.5)');
    wallGradient.addColorStop(0.5, this.getCaseGradient(this.caseMaterial, 0, 0, b, h));
    wallGradient.addColorStop(1, 'rgba(255,255,255,0.1)');
    
    // Left wall
    ctx.fillStyle = wallGradient;
    ctx.fillRect(0, 0, b, h);
    
    // Right wall
    const rightGrad = this.ctx.createLinearGradient(w-b, 0, w, 0);
    rightGrad.addColorStop(0, 'rgba(255,255,255,0.1)');
    rightGrad.addColorStop(0.5, this.getCaseGradient(this.caseMaterial, w-b, 0, b, h));
    rightGrad.addColorStop(1, 'rgba(0,0,0,0.5)');
    ctx.fillStyle = rightGrad;
    ctx.fillRect(w-b, 0, b, h);
    
    // Top wall
    const topGrad = this.ctx.createLinearGradient(0, 0, 0, b);
    topGrad.addColorStop(0, 'rgba(0,0,0,0.5)');
    topGrad.addColorStop(0.5, this.getCaseGradient(this.caseMaterial, 0, 0, w, b));
    topGrad.addColorStop(1, 'rgba(255,255,255,0.1)');
    ctx.fillStyle = topGrad;
    ctx.fillRect(0, 0, w, b);
    
    // Bottom wall
    const botGrad = this.ctx.createLinearGradient(0, h-b, 0, h);
    botGrad.addColorStop(0, 'rgba(255,255,255,0.1)');
    botGrad.addColorStop(0.5, this.getCaseGradient(this.caseMaterial, 0, h-b, w, b));
    botGrad.addColorStop(1, 'rgba(0,0,0,0.5)');
    ctx.fillStyle = botGrad;
    ctx.fillRect(0, h-b, w, b);
  }
  
  // Draw case rim
  drawRim() {
    const ctx = this.ctx;
    const b = this.borderWidth;
    const w = this.width;
    const h = this.height;
    
    // Outer rim
    ctx.strokeStyle = this.getCaseGradient(this.caseMaterial, 0, 0, w, h);
    ctx.lineWidth = 3;
    ctx.strokeRect(b-2, b-2, w-b*2+4, h-b*2+4);
    
    // Inner rim
    ctx.strokeStyle = 'rgba(255,255,255,0.3)';
    ctx.lineWidth = 1;
    ctx.strokeRect(b+2, b+2, w-b*2-4, h-b*2-4);
  }
  
  // Draw glass reflection
  drawGlass() {
    const ctx = this.ctx;
    const b = this.borderWidth;
    const w = this.width;
    const h = this.height;
    
    // Glass surface gradient
    const glassGrad = ctx.createLinearGradient(b, b, w-b, h-b);
    glassGrad.addColorStop(0, 'rgba(255,255,255,0.05)');
    glassGrad.addColorStop(0.3, 'transparent');
    glassGrad.addColorStop(0.7, 'transparent');
    glassGrad.addColorStop(1, 'rgba(255,255,255,0.03)');
    
    ctx.fillStyle = glassGrad;
    ctx.fillRect(b, b, w-b*2, h-b*2);
    
    // Corner reflections
    const cornerSize = 100;
    const cornerGrad = ctx.createRadialGradient(b, b, 0, b, b, cornerSize);
    cornerGrad.addColorStop(0, 'rgba(255,255,255,0.15)');
    cornerGrad.addColorStop(1, 'transparent');
    ctx.fillStyle = cornerGrad;
    ctx.fillRect(b, b, cornerSize, cornerSize);
  }
  
  // Main render
  render() {
    const ctx = this.ctx;
    
    // Clear
    ctx.clearRect(0, 0, this.width, this.height);
    
    // Background
    ctx.fillStyle = '#050505';
    ctx.fillRect(0, 0, this.width, this.height);
    
    // Draw in order: side walls â†’ back wall â†’ stone â†’ rim â†’ glass
    this.drawCase();
    
    // Interior shadow/depth
    const b = this.borderWidth;
    const interiorGrad = ctx.createRadialGradient(
      this.width/2, this.height/2, 0,
      this.width/2, this.height/2, this.stoneWidth
    );
    interiorGrad.addColorStop(0, 'rgba(0,0,0,0)');
    interiorGrad.addColorStop(1, 'rgba(0,0,0,0.4)');
    ctx.fillStyle = interiorGrad;
    ctx.fillRect(b, b, this.width-b*2, this.height-b*2);
    
    // Draw stone
    this.drawStone(this.stoneHue);
    
    // Draw rim
    this.drawRim();
    
    // Draw glass
    this.drawGlass();
  }
  
  // Update methods
  setHue(hue) {
    this.stoneHue = hue;
    this.render();
  }
  
  setCaseMaterial(material) {
    this.caseMaterial = material;
    this.render();
  }
  
  setViewAngle(angle) {
    this.viewAngle = angle;
    this.render();
  }
}

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  // Find all gem canvases
  document.querySelectorAll('canvas[id^="gem-"]').forEach(canvas => {
    const id = canvas.id;
    
    // Parse options from data attributes
    const hue = parseInt(canvas.dataset.hue) || 280;
    const material = canvas.dataset.case || 'chrome';
    const angle = parseInt(canvas.dataset.angle) || 0;
    
    // Create display
    const display = new GemstoneDisplay(id, {
      hue,
      caseMaterial: material,
      viewAngle: angle
    });
    
    // Store reference for external control
    canvas.gemDisplay = display;
  });
});

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
  module.exports = GemstoneDisplay;
}


/* ============================================================
   RESPONSIVE BREAKPOINTS
   ============================================================ */

@media (max-width: 1440px) {
  .container { max-width: 100%; }
}

@media (max-width: 768px) {
  :root {
    --space-32: 6rem;
    --space-40: 8rem;
  }
  
  .text-6xl { font-size: clamp(2.5rem, 8vw, 4rem); }
  .text-5xl { font-size: clamp(2rem, 6vw, 3rem); }
}



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LEGAISEE Master Section Pool</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="master-truth.css">
</head>
<body>

<!-- SECTION 1: HERO â€” Gem Metaphor, Spotlight Sweep -->
<section class="section prestige-hero spotlight-sweep" id="hero">
  <div class="container">
    <div class="asymmetric-2col">
      <div class="hero-content">
        <div class="catalog-number">Cat. No. BA-2026-001</div>
        <h1 class="font-display text-6xl leading-tight mb-8">
          Your Business<br>
          Has a <em class="text-gold">Buried Past</em>
        </h1>
        <p class="font-heading text-2xl text-silver leading-relaxed mb-8 max-w-lg">
          Every company has a golden eraâ€”when marketing worked, customers 
          responded, and growth felt inevitable. We excavate what made that 
          era golden, and restore it for the present.
        </p>
        <div class="flex gap-4 mb-12">
          <button class="btn-prestige">Request Excavation</button>
          <button class="btn-ghost">View Methodology</button>
        </div>
        <div class="availability-indicator">
          <span class="text-silver-dim">2026 Openings:</span>
          <div class="slots">
            <div class="slot taken"></div>
            <div class="slot taken"></div>
            <div class="slot"></div>
          </div>
          <span class="text-gold">1 Remaining</span>
        </div>
      </div>
      <div class="hero-visual">
        <div class="gem-case">
          <div class="gem-case-interior">
            <canvas id="gem-hero" data-hue="280" data-case="gold" data-angle="0"></canvas>
          </div>
          <div class="gem-case-glass"></div>
          <div class="gem-case-frame gold"></div>
        </div>
        <p class="font-ui text-xs text-silver-dim mt-4 tracking-wider text-center">
          Specimen: Unexcavated Potential Â· Era: Unknown Â· Provenance: Your History
        </p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 2: MANIFESTO â€” Violet Deep, Flow Gradient -->
<section class="section prestige-manifesto flow-gradient" id="manifesto">
  <div class="container">
    <div class="catalog-number">Statement of Purpose</div>
    <p class="statement">
      The best marketing your business ever ran is probably 
      <em>behind you</em>â€”not ahead. Buried in abandoned campaigns, 
      forgotten positioning, and tactics discarded before their time.
    </p>
    <p class="font-heading text-2xl text-silver mt-12 max-w-3xl leading-relaxed">
      We don't invent. We <em class="text-gold">excavate</em>. We recover the 
      proven assets your competitors have forgotten, modernize them for 
      today's platforms, and build systems to deploy them at scale.
    </p>
    <div class="divider-ornamental mt-16">
      <span>EST. 2026 Â· AUSTIN, TEXAS</span>
    </div>
  </div>
</section>

<!-- SECTION 3: BLACK BUFFER -->
<section class="section section-black-buffer"></section>

<!-- SECTION 4: SPECIMEN SHOWCASE â€” Three Gems -->
<section class="section prestige-specimen section-prestige" id="showcase">
  <div class="container">
    <div class="catalog-number">Recent Excavations</div>
    <h2 class="font-display text-4xl mb-6">Recovered Assets</h2>
    <p class="font-heading text-xl text-silver mb-12 max-w-2xl">
      Each specimen represents a proven marketing asset, excavated from 
      private archives and public records, restored to museum quality.
    </p>
    
    <div class="specimen-grid">
      <!-- Specimen 1 -->
      <div class="specimen-card hover-lift" data-catalog="BA-2025-042">
        <div class="gem-case mb-6" style="max-width: 100%;">
          <div class="gem-case-interior" style="margin: 30px; width: calc(100% - 60px); height: calc(100% - 60px);">
            <canvas id="gem-1" data-hue="45" data-case="rose-gold" data-angle="-45"></canvas>
          </div>
          <div class="gem-case-glass" style="top: 30px; left: 30px; right: 30px; bottom: 30px;"></div>
          <div class="gem-case-frame rose-gold" style="border-width: 30px;"></div>
        </div>
        <div class="conservation-status preserved mb-4">Preserved</div>
        <h3 class="font-heading text-xl mb-2">Direct Mail Campaign</h3>
        <p class="text-silver text-sm mb-4">HVAC seasonal maintenance, 1987-1992</p>
        <div class="era">Era: 1980s</div>
        <div class="provenance">Source: Private archive recovery</div>
      </div>
      
      <!-- Specimen 2 -->
      <div class="specimen-card hover-lift" data-catalog="BA-2025-043">
        <div class="gem-case mb-6" style="max-width: 100%;">
          <div class="gem-case-interior" style="margin: 30px; width: calc(100% - 60px); height: calc(100% - 60px);">
            <canvas id="gem-2" data-hue="200" data-case="platinum" data-angle="0"></canvas>
          </div>
          <div class="gem-case-glass" style="top: 30px; left: 30px; right: 30px; bottom: 30px;"></div>
          <div class="gem-case-frame platinum" style="border-width: 30px;"></div>
        </div>
        <div class="conservation-status restored mb-4">Restored</div>
        <h3 class="font-heading text-xl mb-2">Radio Sponsorship</h3>
        <p class="text-silver text-sm mb-4">Legal advice program, 1995-2001</p>
        <div class="era">Era: 1990s</div>
        <div class="provenance">Source: FCC archive + oral history</div>
      </div>
      
      <!-- Specimen 3 -->
      <div class="specimen-card hover-lift" data-catalog="BA-2025-044">
        <div class="gem-case mb-6" style="max-width: 100%;">
          <div class="gem-case-interior" style="margin: 30px; width: calc(100% - 60px); height: calc(100% - 60px);">
            <canvas id="gem-3" data-hue="320" data-case="chrome" data-angle="45"></canvas>
          </div>
          <div class="gem-case-glass" style="top: 30px; left: 30px; right: 30px; bottom: 30px;"></div>
          <div class="gem-case-frame" style="border-width: 30px;"></div>
        </div>
        <div class="conservation-status fragment mb-4">Fragment</div>
        <h3 class="font-heading text-xl mb-2">TV Commercial Series</h3>
        <p class="text-silver text-sm mb-4">Manufacturing tours, 2003-2007</p>
        <div class="era">Era: 2000s</div>
        <div class="provenance">Source: YouTube + Wayback Machine</div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 5: PROCESS â€” Gold Accent -->
<section class="section prestige-process section-prestige section-to-gold" id="process">
  <div class="container">
    <div class="catalog-number">Methodology</div>
    <h2 class="font-display text-4xl mb-16">The Excavation Process</h2>
    
    <div class="process-phases">
      <div class="phase reveal-container">
        <h3 class="font-heading text-xl mb-4 text-gold reveal-trigger">Excavation</h3>
        <div class="reveal-content">
          <p class="text-silver text-sm leading-relaxed">
            Multi-AI research across 40+ channels. Public archives, private artifacts, 
            human interviews. Nothing stays buried.
          </p>
          <div class="on-loan mt-4">
            <span>Multi-source triangulation</span>
          </div>
        </div>
      </div>
      
      <div class="phase reveal-container">
        <h3 class="font-heading text-xl mb-4 text-gold reveal-trigger">Classification</h3>
        <div class="reveal-content">
          <p class="text-silver text-sm leading-relaxed">
            Tag by era, channel, asset type. Build the taxonomy. Understand what 
            worked, when, and why.
          </p>
          <div class="on-loan mt-4">
            <span>8-dimension voice extraction</span>
          </div>
        </div>
      </div>
      
      <div class="phase reveal-container">
        <h3 class="font-heading text-xl mb-4 text-gold reveal-trigger">Analysis</h3>
        <div class="reveal-content">
          <p class="text-silver text-sm leading-relaxed">
            Extract the psychology. What made it work then? Why was it abandoned? 
            What replaced it?
          </p>
          <div class="on-loan mt-4">
            <span>Competitive gap mapping</span>
          </div>
        </div>
      </div>
      
      <div class="phase reveal-container">
        <h3 class="font-heading text-xl mb-4 text-gold reveal-trigger">Transformation</h3>
        <div class="reveal-content">
          <p class="text-silver text-sm leading-relaxed">
            Modernize for current platforms. Preserve the psychology, update the 
            execution. Build the system.
          </p>
          <div class="on-loan mt-4">
            <span>AI-powered workflows</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: TESTIMONIAL â€” Violet -->
<section class="section prestige-testimonial section-prestige" id="testimonials">
  <div class="container narrow-width">
    <div class="catalog-number">Client Testimonials</div>
    
    <div class="testimonial-slider" id="testimonial-slider">
      <div class="testimonial-slide active">
        <p class="quote">
          "I had no idea we used to run the most sophisticated direct mail 
          program in the state. John found campaigns from 1987 that generated 
          40% response rates."
        </p>
        <div class="attribution">
          <strong class="text-platinum">Marcus Chen</strong><br>
          <span class="text-silver-dim">CEO, Heritage HVAC</span>
          <div class="member-stamp mt-4 inline-flex">
            <span class="since-date">2024</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 7: CTA â€” Invitation -->
<section class="section prestige-cta flow-gradient" id="cta">
  <div class="container">
    <div class="vault-section max-w-3xl mx-auto p-12">
      <div class="vault-lock mb-8">
        <div class="lock-icon"></div>
        <span class="font-ui text-xs tracking-widest text-gold">PRIVATE COLLECTION</span>
      </div>
      
      <h2 class="invitation-text">
        Admission by<br>
        <em class="text-gold">Application Only</em>
      </h2>
      
      <p class="font-heading text-xl text-silver mb-8">
        We accept <strong class="text-platinum">three clients annually</strong>. 
        Each engagement begins with a 15-minute fit conversation to determine 
        if your business history warrants full excavation.
      </p>
      
      <button class="btn-prestige text-lg px-12 py-6">
        Request Assessment
      </button>
      
      <p class="font-ui text-xs text-silver-dim mt-8 tracking-wider">
        Current wait time: 6 weeks Â· All inquiries held in strict confidence
      </p>
    </div>
  </div>
</section>

<!-- SECTION 8: FOOTER -->
<footer class="section prestige-footer" id="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="font-display text-xl text-gold mb-4">LEGAISEE</div>
        <p class="text-silver-dim text-sm leading-relaxed max-w-xs">
          Business Archaeology & Authority Systems. Excavating proven assets, 
          restoring what made you great.
        </p>
        <div class="member-stamp mt-6 inline-flex">
          <span class="since-date">MMXXVI</span>
        </div>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Contact</div>
        <p class="text-silver text-sm">john@legaisee.com</p>
        <p class="text-silver-dim text-sm mt-2">Austin, Texas</p>
        <p class="text-silver-dim text-sm mt-4">By appointment only</p>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Legal</div>
        <p class="text-silver-dim text-sm">Â© 2026 CarrAI.site</p>
        <p class="text-silver-dim text-sm mt-2">All rights reserved.</p>
        <p class="text-silver-dim text-sm mt-4">Proprietary methodology</p>
      </div>
    </div>
  </div>
</footer>
===================================================
<script src="gemstone-display.js"></script>
<script>
// Testimonial slider
const slides = document.querySelectorAll('.testimonial-slide');
let currentSlide = 0;

function showSlide(n) {
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === n);
  });
}

setInterval(() => {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
}, 6000);

// Reveal containers
document.querySelectorAll('.reveal-container').forEach(container => {
  container.addEventListener('mouseenter', () => {
    container.classList.add('active');
  });
  container.addEventListener('mouseleave', () => {
    container.classList.remove('active');
  });
});
</script>

</body>
</html>


*/â€”â€”â€”â€”-serviceâ€”â€”â€”-*/

</head>
<body>

<!-- SECTION 1: HERO â€” Services Landing -->
<section class="section prestige-hero" id="services-hero">
  <div class="container">
    <div class="asymmetric-2col">
      <div class="hero-content">
        <div class="catalog-number">Service Catalog</div>
        <h1 class="font-display text-5xl leading-tight mb-8">
          Four Stages of<br>
          <em class="text-gold">Restoration</em>
        </h1>
        <p class="font-heading text-xl text-silver leading-relaxed mb-8 max-w-lg">
          From initial excavation to ongoing amplification. Each stage builds 
          upon the last, creating a complete system for sustainable authority.
        </p>
        <div class="flex gap-4">
          <button class="btn-prestige">Begin Stage 1</button>
          <button class="btn-ghost">Compare Tiers</button>
        </div>
      </div>
      <div class="hero-visual">
        <div class="gem-case">
          <div class="gem-case-interior">
            <canvas id="gem-services" data-hue="45" data-case="platinum" data-angle="0"></canvas>
          </div>
          <div class="gem-case-glass"></div>
          <div class="gem-case-frame platinum"></div>
        </div>
        <p class="font-ui text-xs text-silver-dim mt-4 tracking-wider text-center">
          Service Architecture Â· 4 Stages Â· 94 Hours Total
        </p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 2: STAGE 1 DEEP DIVE â€” Audit -->
<section class="section section-prestige bg-violet-deep" id="stage-1">
  <div class="container">
    <div class="flex-uneven">
      <div>
        <div class="catalog-number">Stage I</div>
        <h2 class="font-display text-4xl mb-6">Business History Audit</h2>
        <div class="font-display text-3xl text-gold mb-8">$2,000</div>
        
        <p class="font-heading text-xl text-silver leading-relaxed mb-8">
          Deep excavation across 40+ channels. We research your marketing 
          history through multi-AI queries, Wayback Machine archaeology, 
          private artifact recovery, and human interviews.
        </p>
        
        <div class="space-y-6 mb-12">
          <div class="flex gap-4">
            <div class="text-gold font-display text-2xl">01</div>
            <div>
              <h4 class="font-heading text-lg text-platinum">Multi-AI Excavation</h4>
              <p class="text-silver text-sm">Parallel queries across ChatGPT, Claude, Gemini, Perplexity</p>
            </div>
          </div>
          <div class="flex gap-4">
            <div class="text-gold font-display text-2xl">02</div>
            <div>
              <h4 class="font-heading text-lg text-platinum">Digital Archaeology</h4>
              <p class="text-silver text-sm">Wayback Machine, YouTube, news archives, social history</p>
            </div>
          </div>
          <div class="flex gap-4">
            <div class="text-gold font-display text-2xl">03</div>
            <div>
              <h4 class="font-heading text-lg text-platinum">Private Archive Recovery</h4>
              <p class="text-silver text-sm">Hard drives, email archives, physical filing systems</p>
            </div>
          </div>
          <div class="flex gap-4">
            <div class="text-gold font-display text-2xl">04</div>
            <div>
              <h4 class="font-heading text-lg text-platinum">Human Interviews</h4>
              <p class="text-silver text-sm">Previous owners, longtime employees, customer oral histories</p>
            </div>
          </div>
        </div>
        
        <div class="border-t border-hairline pt-8">
          <div class="flex justify-between items-center mb-4">
            <span class="font-ui text-xs text-silver-dim tracking-wider">DELIVERABLES</span>
            <span class="font-ui text-xs text-gold tracking-wider">5-DAY DELIVERY</span>
          </div>
          <ul class="text-silver text-sm space-y-2">
            <li>â€¢ 10-page leather-bound report</li>
            <li>â€¢ 15-25 asset portfolio with catalog numbers</li>
            <li>â€¢ Video walkthrough (Loom, 30 min)</li>
            <li>â€¢ Competitive gap analysis</li>
            <li>â€¢ Modernization recommendations</li>
          </ul>
        </div>
      </div>
      
      <div>
        <div class="gem-case mb-8" style="max-width: 400px;">
          <div class="gem-case-interior" style="margin: 40px; width: calc(100% - 80px); height: calc(100% - 80px);">
            <canvas id="gem-audit" data-hue="280" data-case="gold" data-angle="-30"></canvas>
          </div>
          <div class="gem-case-glass" style="top: 40px; left: 40px; right: 40px; bottom: 40px;"></div>
          <div class="gem-case-frame gold" style="border-width: 40px;"></div>
        </div>
        
        <div class="specimen-card" data-catalog="BA-S1-001">
          <div class="conservation-status preserved mb-4">Core Service</div>
          <p class="text-silver text-sm mb-4">
            The audit is the foundation. Without understanding what made you 
            great, modernization is guesswork.
          </p>
          <div class="on-loan">
            <span>Prerequisite for all subsequent stages</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 3: BLACK BUFFER -->
<section class="section section-black-buffer"></section>

<!-- SECTION 4: STAGE 2 â€” Build -->
<section class="section section-prestige" id="stage-2">
  <div class="container">
    <div class="flex-uneven" style="flex-direction: row-reverse;">
      <div>
        <div class="catalog-number">Stage II</div>
        <h2 class="font-display text-4xl mb-6">Authority Systems Build</h2>
        <div class="font-display text-3xl text-gold mb-8">$5,500</div>
        
        <p class="font-heading text-xl text-silver leading-relaxed mb-8">
          Transform excavated assets into modern marketing systems. Four core 
          systems: Content Production Engine, Publishing Rhythm, Performance 
          Feedback Loop, Asset Library.
        </p>
        
        <div class="grid-12 gap-6 mb-12">
          <div class="col-span-6">
            <h4 class="font-heading text-lg text-platinum mb-2">Voice Extraction</h4>
            <p class="text-silver text-sm">8-dimension analysis for AI replication of your unique communication style</p>
          </div>
          <div class="col-span-6">
            <h4 class="font-heading text-lg text-platinum mb-2">AI Workflows</h4>
            <p class="text-silver text-sm">Script generators, hook testers, repurposing engines, title optimizers</p>
          </div>
          <div class="col-span-6">
            <h4 class="font-heading text-lg text-platinum mb-2">Publishing System</h4>
            <p class="text-silver text-sm">Editorial calendars, batch scheduling, approval workflows</p>
          </div>
          <div class="col-span-6">
            <h4 class="font-heading text-lg text-platinum mb-2">Performance Analytics</h4>
            <p class="text-silver text-sm">Dashboards, weekly review rituals, optimization triggers</p>
          </div>
        </div>
        
        <div class="border-t border-hairline pt-8">
          <div class="flex justify-between items-center mb-4">
            <span class="font-ui text-xs text-silver-dim tracking-wider">DELIVERABLES</span>
            <span class="font-ui text-xs text-gold tracking-wider">21-DAY DELIVERY</span>
          </div>
          <ul class="text-silver text-sm space-y-2">
            <li>â€¢ 4 operational AI systems</li>
            <li>â€¢ 20-30 page strategy documentation</li>
            <li>â€¢ 15-20 prompt templates</li>
            <li>â€¢ Team training (4 hours, 2 sessions)</li>
            <li>â€¢ 90-day launch plan</li>
          </ul>
        </div>
      </div>
      
      <div>
        <div class="gem-case mb-8" style="max-width: 400px;">
          <div class="gem-case-interior" style="margin: 40px; width: calc(100% - 80px); height: calc(100% - 80px);">
            <canvas id="gem-build" data-hue="200" data-case="rose-gold" data-angle="30"></canvas>
          </div>
          <div class="gem-case-glass" style="top: 40px; left: 40px; right: 40px; bottom: 40px;"></div>
          <div class="gem-case-frame rose-gold" style="border-width: 40px;"></div>
        </div>
        
        <div class="vault-section p-6">
          <div class="vault-lock mb-4">
            <div class="lock-icon"></div>
            <span class="font-ui text-xs tracking-widest text-gold">REQUIRES STAGE I</span>
          </div>
          <p class="text-silver text-sm">
            Systems built without audit foundation are generic. We build 
            from your proven assets, not industry templates.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 5: STAGE 3 & 4 â€” Retainer & Coaching -->
<section class="section section-prestige bg-obsidian-light" id="stages-3-4">
  <div class="container">
    <div class="catalog-number">Ongoing Partnership</div>
    <h2 class="font-display text-4xl mb-12">Stages III & IV</h2>
    
    <div class="grid-12 gap-8">
      <!-- Stage 3 -->
      <div class="col-span-6">
        <div class="specimen-card h-full" data-catalog="BA-S3-001">
          <div class="font-ui text-xs text-gold tracking-wider mb-4">STAGE III</div>
          <h3 class="font-heading text-2xl mb-2">Amplification Partnership</h3>
          <div class="font-display text-3xl text-gold mb-6">$2,750<span class="text-lg">/mo</span></div>
          
          <ul class="text-silver text-sm space-y-3 mb-8">
            <li>â€¢ 8 hours monthly strategic guidance</li>
            <li>â€¢ Weekly content review & feedback</li>
            <li>â€¢ Monthly performance reporting</li>
            <li>â€¢ Template updates & optimization</li>
            <li>â€¢ Quarterly strategy refinement</li>
            <li>â€¢ Emergency support (24hr response)</li>
          </ul>
          
          <div class="pt-6 border-t border-hairline">
            <span class="conservation-status preserved">Retainer Relationship</span>
          </div>
        </div>
      </div>
      
      <!-- Stage 4 -->
      <div class="col-span-6">
        <div class="specimen-card h-full" data-catalog="BA-S4-001">
          <div class="font-ui text-xs text-gold tracking-wider mb-4">STAGE IV</div>
          <h3 class="font-heading text-2xl mb-2">Camera Coaching</h3>
          <div class="font-display text-3xl text-gold mb-6">$3,750</div>
          
          <ul class="text-silver text-sm space-y-3 mb-8">
            <li>â€¢ 5-module intensive (16 hours)</li>
            <li>â€¢ On-camera foundations</li>
            <li>â€¢ Delivery naturalization</li>
            <li>â€¢ Technical excellence</li>
            <li>â€¢ Platform-specific skills</li>
            <li>â€¢ Crisis management protocols</li>
          </ul>
          
          <div class="pt-6 border-t border-hairline">
            <span class="conservation-status restored">Stand-alone or Add-on</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Gem visual -->
    <div class="flex justify-center mt-16">
      <div class="gem-case" style="max-width: 300px;">
        <div class="gem-case-interior" style="margin: 30px; width: calc(100% - 60px); height: calc(100% - 60px);">
          <canvas id="gem-retainer" data-hue="160" data-case="chrome" data-angle="0"></canvas>
        </div>
        <div class="gem-case-glass" style="top: 30px; left: 30px; right: 30px; bottom: 30px;"></div>
        <div class="gem-case-frame" style="border-width: 30px;"></div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: COMPARISON â€” Pricing Table -->
<section class="section content-pricing section-prestige section-to-violet" id="comparison">
  <div class="container">
    <div class="catalog-number">Investment Comparison</div>
    <h2 class="font-display text-4xl mb-12">Service Tiers</h2>
    
    <div class="grid-12 gap-6">
      <div class="col-span-3">
        <div class="specimen-card h-full text-center">
          <div class="font-ui text-xs text-silver-dim tracking-wider mb-4">DIAGNOSIS</div>
          <h3 class="font-heading text-xl mb-2">Stage 1</h3>
          <div class="font-display text-3xl text-gold mb-4">$2,000</div>
          <p class="text-silver text-sm mb-6">20 hours Â· 5 days</p>
          <ul class="text-silver-dim text-xs space-y-2 text-left">
            <li>â€¢ 10-page report</li>
            <li>â€¢ 15-25 assets</li>
            <li>â€¢ Video walkthrough</li>
          </ul>
        </div>
      </div>
      
      <div class="col-span-3">
        <div class="specimen-card h-full text-center border-gold">
          <div class="font-ui text-xs text-gold tracking-wider mb-4">TRANSFORMATION</div>
          <h3 class="font-heading text-xl mb-2">Stage 2</h3>
          <div class="font-display text-3xl text-gold mb-4">$5,500</div>
          <p class="text-silver text-sm mb-6">60 hours Â· 21 days</p>
          <ul class="text-silver-dim text-xs space-y-2 text-left">
            <li>â€¢ 4 AI systems</li>
            <li>â€¢ Team training</li>
            <li>â€¢ 90-day plan</li>
          </ul>
        </div>
      </div>
      
      <div class="col-span-3">
        <div class="specimen-card h-full text-center">
          <div class="font-ui text-xs text-silver-dim tracking-wider mb-4">AMPLIFICATION</div>
          <h3 class="font-heading text-xl mb-2">Stage 3</h3>
          <div class="font-display text-3xl text-gold mb-4">$2,750<span class="text-base">/mo</span></div>
          <p class="text-silver text-sm mb-6">8 hours/month Â· Ongoing</p>
          <ul class="text-silver-dim text-xs space-y-2 text-left">
            <li>â€¢ Performance optimization</li>
            <li>â€¢ Monthly reporting</li>
            <li>â€¢ Strategy refinement</li>
          </ul>
        </div>
      </div>
      
      <div class="col-span-3">
        <div class="specimen-card h-full text-center">
          <div class="font-ui text-xs text-silver-dim tracking-wider mb-4">PRESENCE</div>
          <h3 class="font-heading text-xl mb-2">Stage 4</h3>
          <div class="font-display text-3xl text-gold mb-4">$3,750</div>
          <p class="text-silver text-sm mb-6">16 hours Â· 5 modules</p>
          <ul class="text-silver-dim text-xs space-y-2 text-left">
            <li>â€¢ On-camera training</li>
            <li>â€¢ Platform mastery</li>
            <li>â€¢ Crisis protocols</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 7: CTA -->
<section class="section prestige-cta flow-gradient" id="services-cta">
  <div class="container">
    <div class="invitation-lock mb-8">
      <span>1 Opening Remaining Â· 2026</span>
    </div>
    <h2 class="invitation-text">
      Begin Your<br>
      <em class="text-gold">Excavation</em>
    </h2>
    <button class="btn-prestige text-lg px-12 py-6">
      Request Stage 1 Assessment
    </button>
  </div>
</section>

<!-- SECTION 8: FOOTER -->
<footer class="section prestige-footer" id="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="font-display text-xl text-gold mb-4">LEGAISEE</div>
        <p class="text-silver-dim text-sm leading-relaxed max-w-xs">
          Business Archaeology & Authority Systems
        </p>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Navigate</div>
        <p class="text-silver text-sm"><a href="page-home.html">Home</a></p>
        <p class="text-silver text-sm mt-2"><a href="#">Methodology</a></p>
        <p class="text-silver text-sm mt-2"><a href="#">Case Studies</a></p>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Contact</div>
        <p class="text-silver text-sm">john@legaisee.com</p>
        <p class="text-silver-dim text-sm mt-2">By appointment</p>
      </div>
    </div>
  </div>
</footer>


<!-- ============================================================
     SECTION 1: PRESTIGE HERO
     Asymmetric, left-justified, gemstone placeholder
     ============================================================ -->
<section class="section prestige-hero" id="prestige-hero">
  <div class="container">
    <div class="asymmetric-2col">
      <div class="hero-content">
        <div class="catalog-number">Cat. No. BA-2026-001</div>
        <h1 class="font-display text-6xl leading-tight mb-8">
          Business<br>
          <em class="text-gold">Archaeology</em>
        </h1>
        <p class="font-heading text-2xl text-silver leading-relaxed mb-8 max-w-lg">
          Excavating the proven assets your competitors have forgotten. 
          Restoring what made you great.
        </p>
        <div class="flex gap-4">
          <button class="btn-prestige">Begin Excavation</button>
          <button class="btn-ghost">View Collection</button>
        </div>
        <div class="invitation-lock mt-12">
          By Invitation Only
        </div>
      </div>
      <div class="hero-visual">
        <div class="gem-placeholder spotlight-sweep" data-dimensions="700Ã—880px">
          <canvas id="gem-hero" width="1024" height="1024"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2: PRESTIGE MANIFESTO
     Large statement, minimal, left-justified
     ============================================================ -->
<section class="section prestige-manifesto bg-violet-deep" id="prestige-manifesto">
  <div class="container">
    <div class="catalog-number">Statement of Purpose</div>
    <p class="statement">
      Every business has a <em>golden era</em>â€”a period when 
      marketing worked, customers responded, and growth felt 
      inevitable. Most have simply <em>forgotten</em> what 
      made that era golden.
    </p>
    <div class="divider-ornamental mt-16">
      <span>EST. 2026</span>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 3: PRESTIGE SERVICES
     Service grid with detail expansion
     ============================================================ -->
<section class="section prestige-services section-prestige" id="prestige-services">
  <div class="container">
    <div class="catalog-number">Services Archive</div>
    <h2 class="font-display text-4xl mb-12">Excavation & Restoration</h2>
    
    <div class="service-grid">
      <div class="service-item" onclick="this.classList.toggle('active')">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-heading text-2xl">Business History Audit</h3>
          <span class="text-gold text-sm">Stage 1</span>
        </div>
        <p class="text-silver mb-4">Deep excavation across 40+ channels. 15-25 specific assets documented.</p>
        <div class="service-detail">
          <p class="text-silver-dim text-sm leading-relaxed">
            We research your marketing history across print, broadcast, digital, and physical archives. 
            Multi-AI queries, Wayback Machine excavation, private artifact recovery. Delivered: 
            10-page leather-bound report, video walkthrough, asset portfolio.
          </p>
          <div class="mt-4 pt-4 border-t border-hairline">
            <span class="font-ui text-xs text-gold tracking-wider">20 HOURS Â· 5 DAYS</span>
          </div>
        </div>
      </div>
      
      <div class="service-item" onclick="this.classList.toggle('active')">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-heading text-2xl">Authority Systems Build</h3>
          <span class="text-gold text-sm">Stage 2</span>
        </div>
        <p class="text-silver mb-4">Modernize proven assets. Build AI-powered content systems.</p>
        <div class="service-detail">
          <p class="text-silver-dim text-sm leading-relaxed">
            Transform excavated assets into modern marketing systems. Voice extraction, AI workflows, 
            content production engine, publishing rhythm, performance feedback loops. Four core systems 
            deployed and team-trained.
          </p>
          <div class="mt-4 pt-4 border-t border-hairline">
            <span class="font-ui text-xs text-gold tracking-wider">60 HOURS Â· 21 DAYS</span>
          </div>
        </div>
      </div>
      
      <div class="service-item" onclick="this.classList.toggle('active')">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-heading text-2xl">Amplification Partnership</h3>
          <span class="text-gold text-sm">Stage 3</span>
        </div>
        <p class="text-silver mb-4">Ongoing optimization and strategic guidance.</p>
        <div class="service-detail">
          <p class="text-silver-dim text-sm leading-relaxed">
            Monthly performance review, template updates, trend alerts, emergency support. 
            Quarterly strategy refinement. Your outsourced Chief Archaeology Officer.
          </p>
          <div class="mt-4 pt-4 border-t border-hairline">
            <span class="font-ui text-xs text-gold tracking-wider">8 HOURS/MONTH</span>
          </div>
        </div>
      </div>
      
      <div class="service-item" onclick="this.classList.toggle('active')">
        <div class="flex justify-between items-center mb-4">
          <h3 class="font-heading text-2xl">Camera Coaching</h3>
          <span class="text-gold text-sm">Stage 4</span>
        </div>
        <p class="text-silver mb-4">On-camera presence for founders and executives.</p>
        <div class="service-detail">
          <p class="text-silver-dim text-sm leading-relaxed">
            Five-module intensive: foundations, delivery naturalization, technical excellence, 
            platform-specific skills, crisis management. Transform from reluctant to compelling.
          </p>
          <div class="mt-4 pt-4 border-t border-hairline">
            <span class="font-ui text-xs text-gold tracking-wider">16 HOURS Â· 5 MODULES</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4: PRESTIGE PROCESS
     Numbered phases, timeline
     ============================================================ -->
<section class="section prestige-process section-prestige bg-obsidian-light" id="prestige-process">
  <div class="container">
    <div class="catalog-number">Methodology</div>
    <h2 class="font-display text-4xl mb-16">The Excavation Process</h2>
    
    <div class="process-phases">
      <div class="phase">
        <h3 class="font-heading text-xl mb-4 text-gold">Excavation</h3>
        <p class="text-silver text-sm leading-relaxed">
          Multi-AI research across 40+ channels. Public archives, private artifacts, 
          human interviews. Nothing stays buried.
        </p>
      </div>
      <div class="phase">
        <h3 class="font-heading text-xl mb-4 text-gold">Classification</h3>
        <p class="text-silver text-sm leading-relaxed">
          Tag by era, channel, asset type. Build the taxonomy. Understand what 
          worked, when, and why.
        </p>
      </div>
      <div class="phase">
        <h3 class="font-heading text-xl mb-4 text-gold">Analysis</h3>
        <p class="text-silver text-sm leading-relaxed">
          Extract the psychology. What made it work then? Why was it abandoned? 
          What replaced it?
        </p>
      </div>
      <div class="phase">
        <h3 class="font-heading text-xl mb-4 text-gold">Transformation</h3>
        <p class="text-silver text-sm leading-relaxed">
          Modernize for current platforms. Preserve the psychology, update the 
          execution. Build the system.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5: PRESTIGE SPECIMEN
     Catalog-style asset display
     ============================================================ -->
<section class="section prestige-specimen section-prestige" id="prestige-specimen">
  <div class="container">
    <div class="catalog-number">Recent Acquisitions</div>
    <h2 class="font-display text-4xl mb-12">Specimen Collection</h2>
    
    <div class="specimen-grid">
      <div class="specimen-card" data-catalog="BA-2024-017">
        <div class="gem-placeholder mb-6" data-dimensions="600Ã—400px">
          <div class="flex items-center justify-center text-silver-dim font-ui text-xs">
            [Print Advertisement]
          </div>
        </div>
        <h3 class="font-heading text-xl mb-2">Direct Mail Campaign</h3>
        <p class="text-silver text-sm mb-4">HVAC seasonal maintenance program, 1987-1992</p>
        <div class="era">Era: 1980s</div>
        <div class="provenance">Source: Client private archive</div>
      </div>
      
      <div class="specimen-card" data-catalog="BA-2024-018">
        <div class="gem-placeholder mb-6" data-dimensions="480Ã—360px">
          <div class="flex items-center justify-center text-silver-dim font-ui text-xs">
            [Radio Spot]
          </div>
        </div>
        <h3 class="font-heading text-xl mb-2">Sponsored Program</h3>
        <p class="text-silver text-sm mb-4">Law firm weekly legal advice show, 1995-2001</p>
        <div class="era">Era: 1990s</div>
        <div class="provenance">Source: FCC archive + employee interview</div>
      </div>
      
      <div class="specimen-card" data-catalog="BA-2024-019">
        <div class="gem-placeholder mb-6" data-dimensions="720Ã—480px">
          <div class="flex items-center justify-center text-silver-dim font-ui text-xs">
            [TV Commercial]
          </div>
        </div>
        <h3 class="font-heading text-xl mb-2">Founder Spot Series</h3>
        <p class="text-silver text-sm mb-4">Manufacturing facility tours, 2003-2007</p>
        <div class="era">Era: 2000s</div>
        <div class="provenance">Source: YouTube + Wayback Machine</div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6: PRESTIGE TESTIMONIAL
     Quote with attribution, slider
     ============================================================ -->
<section class="section prestige-testimonial section-prestige" id="prestige-testimonial">
  <div class="container narrow-width">
    <div class="catalog-number">Client Testimonials</div>
    
    <div class="testimonial-slider" id="testimonial-slider">
      <div class="testimonial-slide active">
        <p class="quote">
          "I had no idea we used to run the most sophisticated direct mail 
          program in the state. John found campaigns from 1987 that generated 
          40% response rates. We've modernized the approachâ€”now it's email, 
          but the psychology is identical. Our Q1 leads are up 300%."
        </p>
        <div class="attribution">
          <strong class="text-platinum">Marcus Chen</strong><br>
          <span class="text-silver-dim">CEO, Heritage HVAC Â· Client since 2024</span>
        </div>
      </div>
      
      <div class="testimonial-slide">
        <p class="quote">
          "The audit revealed we abandoned our best positioning in 2009 to 
          chase 'cheap.' We've restored the authority voice, and for the first 
          time in five years, we're competing on value instead of price."
        </p>
        <div class="attribution">
          <strong class="text-platinum">Sarah Whitmore</strong><br>
          <span class="text-silver-dim">Managing Partner, Whitmore Legal Â· Client since 2024</span>
        </div>
      </div>
      
      <div class="testimonial-slide">
        <p class="quote">
          "My grandfather built this company. John excavated his marketing 
          wisdom from 1962 and showed me how to apply it to TikTok. I feel 
          like I'm honoring his legacy while building the future."
        </p>
        <div class="attribution">
          <strong class="text-platinum">Elena Rodriguez</strong><br>
          <span class="text-silver-dim">3rd Generation Owner, Rodriguez Manufacturing Â· Client since 2025</span>
        </div>
      </div>
    </div>
    
    <div class="flex justify-center gap-2 mt-12">
      <button class="w-3 h-3 rounded-full bg-gold" onclick="showSlide(0)"></button>
      <button class="w-3 h-3 rounded-full bg-silver-dim" onclick="showSlide(1)"></button>
      <button class="w-3 h-3 rounded-full bg-silver-dim" onclick="showSlide(2)"></button>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7: PRESTIGE CTA
     Invitation moment
     ============================================================ -->
<section class="section prestige-cta flow-gradient" id="prestige-cta">
  <div class="container">
    <div class="invitation-lock mb-8">
      Limited to 3 Clients Annually
    </div>
    <h2 class="invitation-text">
      Your Business History<br>
      <em class="text-gold">Deserves Preservation</em>
    </h2>
    <p class="font-heading text-xl text-silver mb-12 max-w-2xl mx-auto">
      Current excavation slots: <strong class="text-platinum">1 remaining</strong> for 2026
    </p>
    <button class="btn-prestige text-lg px-12 py-6">
      Request Assessment
    </button>
    <p class="font-ui text-xs text-silver-dim mt-8 tracking-wider">
      Response within 48 hours. All inquiries confidential.
    </p>
  </div>
</section>

<!-- ============================================================
     SECTION 8: PRESTIGE FOOTER
     Minimal, contact, legal
     ============================================================ -->
<footer class="section prestige-footer" id="prestige-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="font-display text-xl text-gold mb-4">LEGAISEE</div>
        <p class="text-silver-dim text-sm leading-relaxed max-w-xs">
          Business Archaeology & Authority Systems. Excavating proven assets, 
          restoring what made you great.
        </p>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Contact</div>
        <p class="text-silver text-sm">john@legaisee.com</p>
        <p class="text-silver-dim text-sm mt-2">Austin, Texas</p>
      </div>
      <div>
        <div class="font-ui text-xs text-silver-dim uppercase tracking-wider mb-4">Legal</div>
        <p class="text-silver-dim text-sm">Â© 2026 CarrAI.site</p>
        <p class="text-silver-dim text-sm mt-2">All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

<!-- ============================================================
     CONTENT SECTIONS 9-26 (Abbreviated for space)
     ============================================================ -->

<!-- 9. Content Hero -->
<section class="section content-hero bg-violet-deep" id="content-hero">
  <div class="container py-32">
    <div class="catalog-number">Page Header</div>
    <h1 class="font-display text-5xl mb-6">Content Hero Section</h1>
    <p class="font-heading text-xl text-silver max-w-2xl">Left-justified hero for interior pages.</p>
  </div>
</section>

<!-- 10. Content Split -->
<section class="section content-split section-content" id="content-split">
  <div class="container">
    <div class="asymmetric-2col">
      <div>
        <div class="catalog-number">Feature Detail</div>
        <h2 class="font-display text-3xl mb-6">Asymmetric Split Layout</h2>
        <p class="text-silver leading-relaxed mb-6">
          Primary content occupies the larger column (61.8%), maintaining left 
          justification throughout. The smaller column holds supporting visuals 
          or secondary information.
        </p>
        <button class="btn-ghost">Learn More</button>
      </div>
      <div class="gem-placeholder" data-dimensions="800Ã—600px">
        <div class="flex items-center justify-center text-silver-dim font-ui text-xs">
          [Supporting Visual]
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 11. Content Feature Grid -->
<section class="section content-feature section-content bg-obsidian-light" id="content-feature">
  <div class="container">
    <div class="catalog-number">Capabilities</div>
    <h2 class="font-display text-3xl mb-12">Feature Grid</h2>
    <div class="grid-12">
      <div class="col-span-4">
        <div class="text-gold text-2xl mb-4">01</div>
        <h3 class="font-heading text-xl mb-2">Multi-AI Excavation</h3>
        <p class="text-silver text-sm">Parallel queries across ChatGPT, Claude, Gemini, Perplexity.</p>
      </div>
      <div class="col-span-4">
        <div class="text-gold text-2xl mb-4">02</div>
        <h3 class="font-heading text-xl mb-2">Private Archive Recovery</h3>
        <p class="text-silver text-sm">Hard drives, email archives, physical filing systems.</p>
      </div>
      <div class="col-span-4">
        <div class="text-gold text-2xl mb-4">03</div>
        <h3 class="font-heading text-xl mb-2">Voice Extraction</h3>
        <p class="text-silver text-sm">8-dimension analysis for AI replication.</p>
      </div>
    </div>
  </div>
</section>

<!-- 12. Content Pricing -->
<section class="section content-pricing section-content" id="content-pricing">
  <div class="container">
    <div class="catalog-number">Investment</div>
    <h2 class="font-display text-3xl mb-12">Service Tiers</h2>
    <div class="grid-12">
      <div class="col-span-4 specimen-card">
        <div class="font-ui text-xs text-gold tracking-wider mb-4">STAGE 1</div>
        <h3 class="font-heading text-2xl mb-2">Audit</h3>
        <div class="font-display text-4xl text-gold mb-4">$2,000</div>
        <ul class="text-silver text-sm space-y-2 mb-8">
          <li>10-page leather-bound report</li>
          <li>15-25 asset portfolio</li>
          <li>Video walkthrough</li>
          <li>5-day delivery</li>
        </ul>
        <button class="btn-ghost w-full justify-center">Inquire</button>
      </div>
      <div class="col-span-4 specimen-card border-gold">
        <div class="font-ui text-xs text-gold tracking-wider mb-4">STAGE 2</div>
        <h3 class="font-heading text-2xl mb-2">Build</h3>
        <div class="font-display text-4xl text-gold mb-4">$5,500</div>
        <ul class="text-silver text-sm space-y-2 mb-8">
          <li>4 core AI systems</li>
          <li>Team training (4 hours)</li>
          <li>90-day launch plan</li>
          <li>21-day delivery</li>
        </ul>
        <button class="btn-prestige w-full justify-center">Inquire</button>
      </div>
      <div class="col-span-4 specimen-card">
        <div class="font-ui text-xs text-gold tracking-wider mb-4">STAGE 3</div>
        <h3 class="font-heading text-2xl mb-2">Partnership</h3>
        <div class="font-display text-4xl text-gold mb-4">$2,750<span class="text-lg">/mo</span></div>
        <ul class="text-silver text-sm space-y-2 mb-8">
          <li>8 hours monthly</li>
          <li>Performance optimization</li>
          <li>Template updates</li>
          <li>Quarterly strategy</li>
        </ul>
        <button class="btn-ghost w-full justify-center">Inquire</button>
      </div>
    </div>
  </div>
</section>

<!-- 13-26. Additional content sections (abbreviated) -->
<section class="section content-team section-content bg-obsidian-light" id="content-team"><div class="container"><div class="catalog-number">Team</div><h2 class="font-display text-3xl">Team Section</h2></div></section>
<section class="section content-faq section-content" id="content-faq"><div class="container"><div class="catalog-number">FAQ</div><h2 class="font-display text-3xl">FAQ Section</h2></div></section>
<section class="section content-blog section-content bg-violet-deep" id="content-blog"><div class="container"><div class="catalog-number">Journal</div><h2 class="font-display text-3xl">Blog Section</h2></div></section>
<section class="section content-contact section-content" id="content-contact"><div class="container"><div class="catalog-number">Contact</div><h2 class="font-display text-3xl">Contact Section</h2></div></section>

<script>
// Testimonial Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.testimonial-slide');
const dots = document.querySelectorAll('.testimonial-slider + div button');

function showSlide(n) {
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === n);
    dots[i].classList.toggle('bg-gold', i === n);
    dots[i].classList.toggle('bg-silver-dim', i !== n);
  });
  currentSlide = n;
}

// Auto-advance
setInterval(() => {
  showSlide((currentSlide + 1) % slides.length);
}, 6000);
</script>


</body>
</html>


