VARIABLES & RESET
   ============================================ */
:root {
  --obsidian: #050505;
  --obsidian-light: #0a0a0a;
  --violet: #3b2b5f;
  --violet-mid: #2a1f45;
  --gold: #c9a961;
  --gold-dim: #a0844a;
  --platinum: #e8e6e3;
  --silver: #b0aba5;
  --border-gold: rgba(201,169,97,0.3);
  
  --font-cinzel: 'Cinzel', serif;
  --font-cormorant: 'Cormorant Garamond', serif;
  --font-inter: 'Inter', sans-serif;
  --font-montserrat: 'Montserrat', sans-serif;
}

* { 
  margin: 0; 
  padding: 0; 
  box-sizing: border-box; 
}

html {
  scroll-behavior: smooth;
  background: var(--obsidian);
}

body {
  font-family: var(--font-inter);
  background: var(--obsidian);
  color: var(--platinum);
  line-height: 1.6;
  overflow-x: hidden;
}

/* ============================================
   NAVIGATION
   ============================================ */
.nav-prestige {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 80px;
  background: rgba(5,5,5,0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--border-gold);
}

.nav-prestige .brand {
  font-family: var(--font-cinzel);
  font-size: 1.4rem;
  color: var(--platinum);
  letter-spacing: 0.15em;
  text-transform: uppercase;
}

.nav-prestige .brand small {
  display: block;
  font-family: var(--font-inter);
  font-size: 0.5rem;
  color: var(--silver);
  letter-spacing: 0.2em;
  margin-top: 2px;
}

.nav-prestige .links {
  display: flex;
  gap: 40px;
}

.nav-prestige .links a {
  font-family: var(--font-inter);
  font-size: 0.75rem;
  color: var(--silver);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  transition: color 0.3s;
}

.nav-prestige .links a:hover { 
  color: var(--gold); 
}

.nav-prestige .nav-right {
  display: flex;
  align-items: center;
  gap: 24px;
}

.nav-prestige .availability {
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
}

.mobile-menu-btn {
  display: none;
  background: none;
  border: none;
  color: var(--gold);
  font-size: 1.5rem;
  cursor: pointer;
}

/* ============================================
   BUTTONS
   ============================================ */
.btn-gold {
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%);
  color: var(--obsidian);
  font-family: var(--font-inter);
  font-size: 0.7rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  padding: 16px 32px;
  border: none;
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
}

.btn-gold:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(201,169,97,0.3);
}

.btn-outline-gold {
  background: transparent;
  color: var(--gold);
  font-family: var(--font-inter);
  font-size: 0.65rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  padding: 14px 28px;
  border: 1px solid var(--gold);
  cursor: pointer;
  transition: all 0.3s;
}

.btn-outline-gold:hover {
  background: var(--gold);
  color: var(--obsidian);
}

.btn-row {
  display: flex;
  gap: 20px;
  margin-top: 32px;
}

/* ============================================
   SECTIONS BASE
   ============================================ */
section {
  width: 100%;
  position: relative;
}

.sec-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 80px;
  position: relative;
  z-index: 2;
}

/* Background Colors with Center Spheres */
.bg-black { 
  background-color: var(--obsidian); 
}

.bg-violet-sphere {
  background-color: var(--obsidian);
  background-image: radial-gradient(circle at 50% 50%, rgba(59,43,95,0.4) 0%, rgba(59,43,95,0.15) 35%, transparent 65%);
}

.bg-gold-sphere {
  background-color: var(--obsidian);
  background-image: radial-gradient(circle at 50% 50%, rgba(201,169,97,0.12) 0%, rgba(201,169,97,0.05) 30%, transparent 60%);
  border-top: 1px solid var(--border-gold);
  border-bottom: 1px solid var(--border-gold);
}

/* ============================================
   HERO SECTION
   ============================================ */
.hero-centered {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 160px 0 140px;
}

.prestige-label {
  display: inline-block;
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.25em;
  margin-bottom: 24px;
  border-bottom: 1px solid var(--border-gold);
  padding-bottom: 8px;
}

.hero-centered h1 {
  font-family: var(--font-cinzel);
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  line-height: 1.1;
  color: var(--platinum);
  margin-bottom: 24px;
}

.hero-centered h1 em {
  color: var(--gold);
  font-style: italic;
  text-shadow: 0 0 40px rgba(201,169,97,0.3);
}

.hero-centered .sub {
  font-family: var(--font-cormorant);
  font-size: 1.25rem;
  color: var(--silver);
  line-height: 1.8;
  max-width: 600px;
  margin: 0 auto;
  font-style: italic;
}

/* ============================================
   MANIFESTO SECTION
   ============================================ */
.manifesto-section {
  padding: 140px 0;
}

.manifesto-inner {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
}

.manifesto-number {
  font-family: var(--font-cinzel);
  font-size: 0.9rem;
  color: var(--gold);
  letter-spacing: 0.2em;
  margin-bottom: 20px;
  opacity: 0.6;
}

.manifesto-heading {
  font-family: var(--font-cinzel);
  font-size: clamp(1.8rem, 3vw, 2.8rem);
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  line-height: 1.2;
  margin-bottom: 40px;
}

.manifesto-heading em {
  color: var(--gold);
  font-style: italic;
}

.manifesto-body {
  margin-bottom: 40px;
}

.manifesto-body p {
  font-family: var(--font-cormorant);
  font-size: 1.2rem;
  color: var(--silver);
  line-height: 1.9;
  margin-bottom: 20px;
  font-style: italic;
}

.manifesto-signature {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  margin-top: 40px;
}

.sig-line {
  width: 60px;
  height: 1px;
  background: var(--gold);
}

.sig-text {
  font-family: var(--font-cinzel);
  font-size: 0.75rem;
  color: var(--platinum);
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.sig-role {
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--silver);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  margin-top: 4px;
}

/* ============================================
   PROCESS ALTERNATING
   ============================================ */
.process-section {
  padding: 140px 0;
}

.process-alt-item {
  display: flex;
  align-items: center;
  gap: 80px;
  margin-bottom: 120px;
}

.process-alt-item:last-child { 
  margin-bottom: 0; 
}

/* First item: Text LEFT, Image RIGHT */
.process-alt-item:nth-child(1) { 
  flex-direction: row; 
}

/* Second item: Image LEFT, Text RIGHT */
.process-alt-item:nth-child(2) { 
  flex-direction: row-reverse; 
}

.process-alt-item .text-side { 
  flex: 1; 
}

.process-alt-item .img-side { 
  flex: 1; 
  position: relative; 
}

.micro-label {
  display: block;
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.2em;
  margin-bottom: 16px;
}

.process-alt-item h3 {
  font-family: var(--font-cinzel);
  font-size: 1.6rem;
  color: var(--platinum);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 20px;
  line-height: 1.3;
}

.process-alt-item p {
  font-size: 1rem;
  color: var(--silver);
  line-height: 1.9;
  margin-bottom: 16px;
}

.image-frame {
  position: relative;
  border: 1px solid var(--border-gold);
  padding: 12px;
  background: rgba(201,169,97,0.05);
}

.prestige-image {
  position: relative;
  overflow: hidden;
}

.prestige-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.catalog-tag {
  position: absolute;
  bottom: -15px;
  right: 20px;
  background: var(--obsidian);
  border: 1px solid var(--border-gold);
  padding: 12px 20px;
  text-align: center;
}

.catalog-tag.left {
  right: auto;
  left: 20px;
}

.catalog-tag span {
  display: block;
  font-family: var(--font-inter);
  font-size: 0.55rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  margin-bottom: 4px;
}

.catalog-tag p {
  font-family: var(--font-cinzel);
  font-size: 0.75rem;
  color: var(--platinum);
  margin: 0;
}

/* ============================================
   GEM SECTION (THE EVIDENCE)
   ============================================ */
.gem-section {
  padding: 140px 0;
}

.gem-panels {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 60px;
}

.gem-text-left {
  flex: 0 0 280px;
  text-align: left;
}

.gem-text-left h2 {
  font-family: var(--font-cinzel);
  font-size: 1.8rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--platinum);
  line-height: 1.2;
  margin: 20px 0;
}

.gem-text-left p {
  font-family: var(--font-cormorant);
  font-size: 1.15rem;
  color: var(--silver);
  line-height: 1.8;
  font-style: italic;
}

.gem-stage {
  flex: 0 0 400px;
  text-align: center;
}

.squircle-frame {
  width: 400px;
  height: 400px;
  border-radius: 48px;
  overflow: hidden;
  border: 2px solid var(--gold);
  box-shadow: 0 0 60px rgba(201,169,97,0.25);
  position: relative;
  margin: 0 auto;
}

.squircle-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.squircle-shine {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 40%, transparent 60%, rgba(201,169,97,0.2) 100%);
  pointer-events: none;
}

.gem-caption-bar {
  margin-top: 24px;
}

.gem-caption-bar h4 {
  font-family: var(--font-cinzel);
  font-size: 0.85rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 8px;
}

.gem-caption-bar p {
  font-size: 0.9rem;
  color: var(--silver);
}

.gem-text-right {
  flex: 0 0 200px;
  text-align: right;
}

.stats-bar {
  display: flex;
  flex-direction: column;
  gap: 24px;
  align-items: flex-end;
}

.stat-item {
  text-align: right;
}

.stat-number {
  display: block;
  font-family: var(--font-cinzel);
  font-size: 2.5rem;
  color: var(--gold);
  line-height: 1;
  margin-bottom: 4px;
}

.stat-label {
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--silver);
  text-transform: uppercase;
  letter-spacing: 0.15em;
}

/* ============================================
   VAULT SECTION
   ============================================ */
.vault-section {
  padding: 160px 0;
  text-align: center;
}

.vault-door-frame {
  max-width: 700px;
  margin: 0 auto;
  border: 1px solid var(--border-gold);
  padding: 60px;
  background: rgba(201,169,97,0.03);
  position: relative;
}

.vault-door-frame::before {
  content: '';
  position: absolute;
  inset: 10px;
  border: 1px solid rgba(201,169,97,0.1);
  pointer-events: none;
}

.vault-seal {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 2px solid var(--gold);
  margin: 0 auto 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
  box-shadow: 0 0 40px rgba(201,169,97,0.2);
}

.vault-seal img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.vault-title {
  font-family: var(--font-cinzel);
  font-size: 2rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--platinum);
  margin-bottom: 20px;
}

.vault-subtitle {
  font-family: var(--font-cormorant);
  font-size: 1.2rem;
  color: var(--silver);
  font-style: italic;
  line-height: 1.6;
  margin-bottom: 16px;
}

.vault-copy {
  font-size: 0.95rem;
  color: var(--silver);
  max-width: 500px;
  margin: 0 auto 32px;
  line-height: 1.8;
}

.vault-lock-line {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 1px solid var(--border-gold);
}

.vault-lock-line span {
  font-family: var(--font-inter);
  font-size: 0.65rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
}

/* ============================================
   FOOTER
   ============================================ */
.footer-prestige {
  background: var(--obsidian-light);
  border-top: 1px solid var(--border-gold);
  padding: 80px 0 40px;
}

.footer-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 80px;
  display: flex;
  justify-content: space-between;
  gap: 60px;
  margin-bottom: 60px;
}

.brand-block h4 {
  font-family: var(--font-cinzel);
  font-size: 1.2rem;
  color: var(--platinum);
  letter-spacing: 0.1em;
  margin-bottom: 16px;
}

.brand-block > p {
  font-size: 0.9rem;
  color: var(--silver);
  line-height: 1.7;
  max-width: 300px;
  margin-bottom: 24px;
}

.avail p {
  font-family: var(--font-inter);
  font-size: 0.7rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 4px;
}

.nav-cols {
  display: flex;
  gap: 80px;
}

.nav-col h5 {
  font-family: var(--font-inter);
  font-size: 0.7rem;
  color: var(--platinum);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  margin-bottom: 20px;
}

.nav-col ul {
  list-style: none;
}

.nav-col li {
  margin-bottom: 12px;
}

.nav-col a {
  font-size: 0.85rem;
  color: var(--silver);
  text-decoration: none;
  transition: color 0.3s;
}

.nav-col a:hover { 
  color: var(--gold); 
}

.footer-bottom {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px 80px 0;
  border-top: 1px solid rgba(255,255,255,0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.footer-bottom p {
  font-size: 0.75rem;
  color: var(--silver);
}

.legal-links {
  display: flex;
  gap: 24px;
}

.legal-links a {
  font-size: 0.75rem;
  color: var(--silver);
  text-decoration: none;
}

/* ============================================
   ANIMATIONS
   ============================================ */
.reveal {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 1s ease, transform 1s ease;
}

.reveal.visible {
  opacity: 1;
  transform: translateY(0);
}

/* ============================================
   MOBILE RESPONSIVE
   ============================================ */
@media (max-width: 968px) {
  .nav-prestige {
    padding: 16px 24px;
  }
  
  .nav-prestige .links,
  .nav-prestige .availability,
  .nav-prestige .nav-right .btn-outline-gold {
    display: none;
  }
  
  .mobile-menu-btn {
    display: block;
  }
  
  .sec-wrap {
    padding: 0 24px;
  }
  
  .hero-centered {
    min-height: auto;
    padding: 140px 0 100px;
  }
  
  .hero-centered h1 {
    font-size: 2rem;
  }
  
  .btn-row {
    flex-direction: column;
    align-items: center;
  }
  
  .process-alt-item,
  .process-alt-item:nth-child(1),
  .process-alt-item:nth-child(2) {
    flex-direction: column !important;
    gap: 40px;
  }
  
  .process-alt-item .img-side {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
  }
  
  .catalog-tag {
    position: relative;
    bottom: auto;
    right: auto;
    margin-top: 16px;
    display: inline-block;
  }
  
  .gem-panels {
    flex-direction: column;
    text-align: center;
  }
  
  .gem-text-left,
  .gem-text-right {
    flex: none;
    width: 100%;
    text-align: center;
  }
  
  .gem-stage {
    flex: none;
    width: 100%;
    max-width: 400px;
  }
  
  .squircle-frame {
    width: 100%;
    max-width: 350px;
    height: auto;
    aspect-ratio: 1/1;
    margin: 0 auto;
  }
  
  .stats-bar {
    align-items: center;
  }
  
  .stat-item {
    text-align: center;
  }
  
  .vault-door-frame {
    margin: 0 24px;
    padding: 40px 24px;
  }
  
  .footer-inner {
    flex-direction: column;
    padding: 0 24px;
    text-align: center;
  }
  
  .brand-block > p {
    max-width: 100%;
  }
  
  .nav-cols {
    justify-content: center;
    gap: 40px;
  }
  
  .footer-bottom {
    flex-direction: column;
    gap: 16px;
    text-align: center;
    padding: 20px 24px;
  }
}

/* ============================================
   MOBILE MENU OVERLAY
   ============================================ */
.mobile-menu {
  position: fixed;
  inset: 0;
  background: rgba(5,5,5,0.98);
  z-index: 999;
  display: none;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 30px;
}

.mobile-menu.active {
  display: flex;
}

.mobile-menu a {
  font-family: var(--font-cinzel);
  font-size: 1.5rem;
  color: var(--platinum);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.mobile-menu a:hover {
  color: var(--gold);
}

.mobile-menu .close-btn {
  position: absolute;
  top: 20px;
  right: 24px;
  background: none;
  border: none;
  color: var(--gold);
  font-size: 2rem;
  cursor: pointer;
}

        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--obsidian);
            color: var(--platinum);
            line-height: 1.7;
            font-size: 18px;
            font-weight: 400;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }
        
        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }
        
        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }
        
        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }
        
        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }
        
        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }
        
        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }
        
        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }
        
        .prestige-label-solo::before {
            width: 60px;
        }
        
        .prestige-label-solo::after {
            display: none;
        }
        
        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes flow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        
        /* Sheen Effect */
        .sheen {
            position: relative;
            overflow: hidden;
        }
        
        .sheen::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 80%;
            height: 300%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(201, 169, 97, 0.1) 25%,
                rgba(232, 213, 163, 0.2) 05%,
                rgba(201, 169, 97, 0.1) 25%,
                transparent 100%
            );
            transform: rotate(0deg);
            animation: sheen 35s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes sheen {
            0%, 80%, 100% { left: -100%; }
            40% { left: 150%; }
        }
        
        /* Museum Card */
        .museum-card {
            background: linear-gradient(145deg, var(--obsidian-lighter) 0%, var(--obsidian) 100%);
            border: 1px solid rgba(201, 169, 97, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .museum-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.3), transparent 40%, transparent 60%, rgba(201, 169, 97, 0.1)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        /* Etched Border */
        .etched {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.5),
                0 1px 0 rgba(255, 255, 255, 0.02);
        }
        
        /* Section Layouts */
        .section {
            padding: 140px 80px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .section-compact {
            padding: 100px 80px;
        }
        
        /* Asymmetric Grid */
        .asymmetric-2col {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }
        
        .asymmetric-2col-reverse {
            grid-template-columns: 1.2fr 1fr;
        }
        
        .asymmetric-3col {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 60px;
        }
        
        /* Prestige Flex Layouts */
        .prestige-flex {
            display: flex;
            gap: 60px;
        }
        
        .prestige-flex-column {
            flex-direction: column;
            gap: 40px;
        }
        
        .prestige-flex-row {
            flex-direction: row;
            align-items: flex-start;
        }
        
        .flex-uneven {
            display: flex;
            gap: 80px;
        }
        
        .flex-uneven .flex-major {
            flex: 1.5;
        }
        
        .flex-uneven .flex-minor {
            flex: 1;
        }
        
        /* Content Blocks */
        .content-block {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .content-block p {
            color: var(--silver);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 90%;
        }
        
        /* Feature Stack */
        .feature-stack {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        .feature-item {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 24px 0;
            border-bottom: 1px solid rgba(201, 169, 97, 0.08);
        }
        
        .feature-number {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--gold-dim);
            letter-spacing: 0.2em;
            min-width: 40px;
            padding-top: 4px;
        }
        
        .feature-content h4 {
            margin-bottom: 8px;
            color: var(--gold-light);
        }
        
        .feature-content p {
            color: var(--silver);
            font-size: 1rem;
            line-height: 1.7;
        }
        
        /* Nested Content */
        .nested-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-left: 24px;
            border-left: 1px solid rgba(201, 169, 97, 0.15);
            margin-top: 8px;
        }
        
        .nested-item {
            display: flex;
            gap: 16px;
            align-items: baseline;
        }
        
        .nested-bullet {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        /* Image Treatments */
        .prestige-image {
            position: relative;
            overflow: hidden;
        }
        
        .prestige-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.8) contrast(1.05);
        }
        
        .prestige-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5, 5, 5, 0.4) 0%,
                transparent 40%,
                transparent 60%,
                rgba(5, 5, 5, 0.3) 100%
            );
            pointer-events: none;
        }
        
        .image-frame {
            border: 1px solid rgba(201, 169, 97, 0.2);
            padding: 12px;
            background: var(--obsidian-lighter);
        }
        
        .image-caption {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold-dim);
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Specimen Card (Museum Style) */
        .specimen-card {
            background: var(--obsidian-lighter);
            border: 1px solid rgba(201, 169, 97, 0.12);
            padding: 40px;
            position: relative;
        }
        
        .specimen-card::before {
            content: attr(data-catalog);
            position: absolute;
            top: 16px;
            right: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            color: var(--gold-dim);
            opacity: 0.6;
        }
        
        .specimen-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Quote Block */
        .prestige-quote {
            position: relative;
            padding: 40px 0 40px 60px;
            border-left: 2px solid var(--gold);
            margin: 40px 0;
        }
        
        .prestige-quote::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .prestige-quote p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-style: italic;
            color: var(--platinum);
            line-height: 1.6;
        }
        
        .quote-attribution {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .attribution-line {
            width: 40px;
            height: 1px;
            background: var(--gold-dim);
        }
        
        .attribution-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
        }
        
        /* Buttons */
        .btn-prestige {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 18px 36px;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gold {
            background: var(--gold);
            color: var(--obsidian);
        }
        
        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-gold:hover::before {
            left: 100%;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background: rgba(201, 169, 97, 0.08);
        }
        
        /* Divider */
        .prestige-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 169, 97, 0.3), transparent);
            margin: 100px 0;
        }
        
        /* Micro Label */
        .micro-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--gold-dim);
            margin-bottom: 12px;
        }
        
        /* Value List */
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .value-list li {
            display: flex;
            align-items: baseline;
            gap: 16px;
            font-size: 1.05rem;
            color: var(--silver);
        }
        
        .value-list li::before {
            content: 'â€”';
            color: var(--gold);
            font-weight: 300;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .section {
                padding: 100px 40px;
            }
            
            .asymmetric-2col,
            .asymmetric-2col-reverse {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            
            .asymmetric-3col {
                grid-template-columns: 1fr;
            }
            
            .flex-uneven {
                flex-direction: column;
                gap: 40px;
            }
            
            .prestige-flex-row {
                flex-direction: column;
            }
        }
        
        @media (max-width: 768px) {
            .section {
                padding: 80px 24px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        /* Spacing */
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        /* Labels */
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        /* Cards */
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        /* Image containers */
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        /* Grid layouts */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        /* Service cards specific */
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        /* Feature list */
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        /* Phase/Process cards */
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        /* Stats */
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        /* Testimonial */
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        /* Pricing table */
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        /* Comparison table */
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        /* FAQ */
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        /* Navigation pills */
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        /* Split layout */
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        /* Responsive */
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }
    </style>
</head>
<body>


html_content = '''<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Content Blocks - Business Archaeology</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #0a0a0a;
            --black-light: #111111;
            --black-lighter: #1a1a1a;
            --gold: #D4AF37;
            --gold-light: #E5C158;
            --gold-dark: #B8960C;
            --white: #ffffff;
            --gray: #888888;
            --gray-light: #cccccc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--obsidian);
            color: var(--platinum);
            line-height: 1.7;
            font-size: 18px;
            font-weight: 400;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }
        
        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }
        
        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }
        
        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }
        
        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }
        
        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }
        
        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }
        
        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }
        
        .prestige-label-solo::before {
            width: 60px;
        }
        
        .prestige-label-solo::after {
            display: none;
        }
        
        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes flow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        
        /* Sheen Effect */
        .sheen {
            position: relative;
            overflow: hidden;
        }
        
        .sheen::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 80%;
            height: 300%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(201, 169, 97, 0.1) 25%,
                rgba(232, 213, 163, 0.2) 05%,
                rgba(201, 169, 97, 0.1) 25%,
                transparent 100%
            );
            transform: rotate(0deg);
            animation: sheen 35s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes sheen {
            0%, 80%, 100% { left: -100%; }
            40% { left: 150%; }
        }
        
        /* Museum Card */
        .museum-card {
            background: linear-gradient(145deg, var(--obsidian-lighter) 0%, var(--obsidian) 100%);
            border: 1px solid rgba(201, 169, 97, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .museum-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.3), transparent 40%, transparent 60%, rgba(201, 169, 97, 0.1)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        /* Etched Border */
        .etched {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.5),
                0 1px 0 rgba(255, 255, 255, 0.02);
        }
        
        /* Section Layouts */
        .section {
            padding: 140px 80px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .section-compact {
            padding: 100px 80px;
        }
        
        /* Asymmetric Grid */
        .asymmetric-2col {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }
        
        .asymmetric-2col-reverse {
            grid-template-columns: 1.2fr 1fr;
        }
        
        .asymmetric-3col {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 60px;
        }
        
        /* Prestige Flex Layouts */
        .prestige-flex {
            display: flex;
            gap: 60px;
        }
        
        .prestige-flex-column {
            flex-direction: column;
            gap: 40px;
        }
        
        .prestige-flex-row {
            flex-direction: row;
            align-items: flex-start;
        }
        
        .flex-uneven {
            display: flex;
            gap: 80px;
        }
        
        .flex-uneven .flex-major {
            flex: 1.5;
        }
        
        .flex-uneven .flex-minor {
            flex: 1;
        }
        
        /* Content Blocks */
        .content-block {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .content-block p {
            color: var(--silver);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 90%;
        }
        
        /* Feature Stack */
        .feature-stack {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        .feature-item {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 24px 0;
            border-bottom: 1px solid rgba(201, 169, 97, 0.08);
        }
        
        .feature-number {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--gold-dim);
            letter-spacing: 0.2em;
            min-width: 40px;
            padding-top: 4px;
        }
        
        .feature-content h4 {
            margin-bottom: 8px;
            color: var(--gold-light);
        }
        
        .feature-content p {
            color: var(--silver);
            font-size: 1rem;
            line-height: 1.7;
        }
        
        /* Nested Content */
        .nested-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-left: 24px;
            border-left: 1px solid rgba(201, 169, 97, 0.15);
            margin-top: 8px;
        }
        
        .nested-item {
            display: flex;
            gap: 16px;
            align-items: baseline;
        }
        
        .nested-bullet {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        /* Image Treatments */
        .prestige-image {
            position: relative;
            overflow: hidden;
        }
        
        .prestige-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.8) contrast(1.05);
        }
        
        .prestige-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5, 5, 5, 0.4) 0%,
                transparent 40%,
                transparent 60%,
                rgba(5, 5, 5, 0.3) 100%
            );
            pointer-events: none;
        }
        
        .image-frame {
            border: 1px solid rgba(201, 169, 97, 0.2);
            padding: 12px;
            background: var(--obsidian-lighter);
        }
        
        .image-caption {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold-dim);
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Specimen Card (Museum Style) */
        .specimen-card {
            background: var(--obsidian-lighter);
            border: 1px solid rgba(201, 169, 97, 0.12);
            padding: 40px;
            position: relative;
        }
        
        .specimen-card::before {
            content: attr(data-catalog);
            position: absolute;
            top: 16px;
            right: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            color: var(--gold-dim);
            opacity: 0.6;
        }
        
        .specimen-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Quote Block */
        .prestige-quote {
            position: relative;
            padding: 40px 0 40px 60px;
            border-left: 2px solid var(--gold);
            margin: 40px 0;
        }
        
        .prestige-quote::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .prestige-quote p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-style: italic;
            color: var(--platinum);
            line-height: 1.6;
        }
        
        .quote-attribution {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .attribution-line {
            width: 40px;
            height: 1px;
            background: var(--gold-dim);
        }
        
        .attribution-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
        }
        
        /* Buttons */
        .btn-prestige {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 18px 36px;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gold {
            background: var(--gold);
            color: var(--obsidian);
        }
        
        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-gold:hover::before {
            left: 100%;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background: rgba(201, 169, 97, 0.08);
        }
        
        /* Divider */
        .prestige-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 169, 97, 0.3), transparent);
            margin: 100px 0;
        }
        
        /* Micro Label */
        .micro-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--gold-dim);
            margin-bottom: 12px;
        }
        
        /* Value List */
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .value-list li {
            display: flex;
            align-items: baseline;
            gap: 16px;
            font-size: 1.05rem;
            color: var(--silver);
        }
        
        .value-list li::before {
            content: 'â€”';
            color: var(--gold);
            font-weight: 300;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .section {
                padding: 100px 40px;
            }
            
            .asymmetric-2col,
            .asymmetric-2col-reverse {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            
            .asymmetric-3col {
                grid-template-columns: 1fr;
            }
            
            .flex-uneven {
                flex-direction: column;
                gap: 40px;
            }
            
            .prestige-flex-row {
                flex-direction: column;
            }
        }
        ========================

       /* LEGAiSEE MASTER STYLE SYSTEM
 * Version: 1.0.0
 * Purpose: Universal stylesheet for all Legaissee section combinations
 * Philosophy: Museum-quality presentation, speakeasy millionaire voice
 * Color Flow: Black â†’ Violet â†’ Black â†’ Gold â†’ Black â†’ Violet â†’ Black â†’ Gold
 */

/* ============================================
   CSS VARIABLES - THE DESIGN DNA
   ============================================ */
:root {
  /* Core Palette - The Legaissee Identity */
  --color-black: #0a0a0a;
  --color-black-pure: #000000;
  --color-violet: #1a0a2e;
  --color-violet-deep: #2d1b4e;
  --color-gold: #d4af37;
  --color-gold-bright: #f4d03f;
  --color-gold-muted: #b8860b;
  --color-white: #ffffff;
  --color-cream: #f5f5dc;
  --color-gray-light: #e0e0e0;
  --color-gray: #888888;
  --color-gray-dark: #333333;
  
  /* Typography - Speakeasy Elegance */
  --font-display: 'Cinzel', 'Playfair Display', Georgia, serif;
  --font-body: 'Montserrat', 'Lato', -apple-system, sans-serif;
  --font-accent: 'Cormorant Garamond', serif;
  
  /* Spacing - Generous, Museum-Quality */
  --space-xs: 0.5rem;
  --space-sm: 1rem;
  --space-md: 2rem;
  --space-lg: 4rem;
  --space-xl: 6rem;
  --space-xxl: 8rem;
  
  /* Transitions - Refined Movement */
  --transition-fast: 0.2s ease;
  --transition-medium: 0.4s ease;
  --transition-slow: 0.8s ease;
  
  /* Shadows - Depth Without Cheapness */
  --shadow-subtle: 0 4px 20px rgba(0,0,0,0.3);
  --shadow-dramatic: 0 20px 60px rgba(0,0,0,0.5);
  --shadow-gold: 0 0 30px rgba(212,175,55,0.2);
  
  /* Layout */
  --max-width: 1400px;
  --sidebar-width: 280px;
  --section-padding: 6rem 2rem;
}

/* ============================================
   RESET & BASE
   ============================================ */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  scroll-behavior: smooth;
  font-size: 16px;
}

body {
  font-family: var(--font-body);
  background: var(--color-black);
  color: var(--color-white);
  line-height: 1.6;
  overflow-x: hidden;
}

/* ============================================================
   LAYOUT SYSTEM - FLEXBOX BASED
   ============================================================ */
.app-container {
  display: flex;
  min-height: 100vh;
  width: 100%;
}

/* Sidebar - Flexible width, not fixed */
.sidebar {
  width: 260px;
  min-width: 260px;
  max-width: 260px;
  background: linear-gradient(180deg, var(--obsidian) 0%, #0f0f0f 100%);
  border-right: 1px solid var(--border-gold);
  display: flex;
  flex-direction: column;
  position: sticky;
  top: 0;
  height: 100vh;
  overflow-y: auto;
  overflow-x: hidden;
  z-index: 1000;
  transition: transform 0.3s ease;
}

.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: var(--gold-dim); border-radius: 2px; }

.sidebar-header {
  padding: 24px 20px;
  border-bottom: 1px solid var(--border-gold);
  flex-shrink: 0;
}

.sidebar-title {
  font-family: var(--font-display);
  font-size: 0.9rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--gold);
}

.sidebar-sub {
  font-family: var(--font-ui);
  font-size: 0.65rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--silver);
  margin-top: 4px;
  opacity: 0.7;
}

.nav-group {
  padding: 16px 0;
}

.nav-group-label {
  font-family: var(--font-ui);
  font-size: 0.6rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.25em;
  color: var(--gold-dim);
  padding: 0 20px 8px;
  margin-bottom: 4px;
}

.nav-link {
  display: block;
  padding: 8px 20px;
  font-family: var(--font-ui);
  font-size: 0.75rem;
  color: var(--silver);
  text-decoration: none;
  transition: all 0.2s ease;
  border-left: 2px solid transparent;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.nav-link:hover, .nav-link.active {
  color: var(--gold);
  border-left-color: var(--gold);
  background: rgba(201,169,97,0.05);
}

.nav-badge {
  display: inline-block;
  font-size: 0.55rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  background: rgba(201,169,97,0.15);
  color: var(--gold);
  padding: 2px 6px;
  border-radius: 2px;
  margin-left: 6px;
  vertical-align: middle;
}

/* Mobile Menu Toggle */
.mobile-menu-toggle {
  display: none;
  position: fixed;
  top: 16px;
  left: 16px;
  z-index: 1100;
  width: 44px;
  height: 44px;
  background: rgba(5,5,5,0.9);
  border: 1px solid var(--gold);
  border-radius: 4px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 5px;
  cursor: pointer;
}

.mobile-menu-toggle span {
  display: block;
  width: 20px;
  height: 2px;
  background: var(--gold);
  transition: all 0.3s ease;
}

.mobile-menu-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.mobile-menu-toggle.active span:nth-child(2) { opacity: 0; }
.mobile-menu-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

/* Overlay for mobile */
.sidebar-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  z-index: 999;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
  display: block;
  opacity: 1;
}

/* Main Content - Flexible */
.main-content {
  flex: 1;
  min-width: 0; /* Critical for flex child to shrink */
  display: flex;
  flex-direction: column;
}

/* ============================================================
   SECTION BASE
   ============================================================ */
.section {
  position: relative;
  width: 100%;
  padding: 80px 24px;
}

.section-tag {
  position: absolute;
  top: 16px;
  right: 16px;
  font-family: var(--font-ui);
  font-size: 0.6rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold-dim);
  background: rgba(5,5,5,0.8);
  border: 1px solid var(--border-gold);
  padding: 6px 12px;
  border-radius: 3px;
  z-index: 10;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 16px;
}

.container-narrow {
  max-width: 800px;
}

/* ============================================================
   TYPOGRAPHY
   ============================================================ */
.eyebrow {
  font-family: var(--font-ui);
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.25em;
  color: var(--gold);
  margin-bottom: 16px;
  display: block;
}

h1, h2, h3, h4 {
  font-family: var(--font-display);
  font-weight: 400;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  line-height: 1.2;
}

h1 { font-size: clamp(2rem, 5vw, 3.5rem); }
h2 { font-size: clamp(1.5rem, 4vw, 2.5rem); }
h3 { font-size: clamp(1.2rem, 3vw, 1.8rem); }

.text-gold { color: var(--gold); }
.text-silver { color: var(--silver); }

.body-lg {
  font-size: clamp(1.1rem, 2vw, 1.3rem);
  line-height: 1.8;
  color: var(--platinum);
}

.body-md {
  font-size: 1rem;
  line-height: 1.7;
  color: var(--silver);
}

.body-sm {
  font-family: var(--font-ui);
  font-size: 0.85rem;
  line-height: 1.6;
  color: var(--silver);
}

/* ============================================================
   COMPONENTS
   ============================================================ */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-family: var(--font-ui);
  font-size: 0.7rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  padding: 14px 28px;
  text-decoration: none;
  transition: all 0.3s ease;
  cursor: pointer;
  border: none;
  white-space: nowrap;
}

.btn-gold {
  background: var(--gold);
  color: var(--obsidian);
}

.btn-gold:hover {
  background: var(--gold-light);
  transform: translateY(-2px);
}

.btn-outline {
  background: transparent;
  color: var(--gold);
  border: 1px solid var(--gold);
}

.btn-outline:hover {
  background: rgba(201,169,97,0.1);
}

/* Cards */
.card {
  background: rgba(255,255,255,0.02);
  border: 1px solid var(--border-gold);
  padding: 32px;
  transition: all 0.3s ease;
}

.card:hover {
  border-color: rgba(201,169,97,0.4);
}

/* Grid System - Responsive */
.grid {
  display: grid;
  gap: 24px;
}

.grid-2 { grid-template-columns: repeat(2, 1fr); }
.grid-3 { grid-template-columns: repeat(3, 1fr); }
.grid-4 { grid-template-columns: repeat(4, 1fr); }

/* Flex utilities */
.flex { display: flex; }
.flex-col { flex-direction: column; }
.flex-wrap { flex-wrap: wrap; }
.items-center { align-items: center; }
.justify-center { justify-content: center; }
.justify-between { justify-content: space-between; }
.gap-4 { gap: 16px; }
.gap-8 { gap: 32px; }

/* Spacing */
.mb-4 { margin-bottom: 16px; }
.mb-6 { margin-bottom: 24px; }
.mb-8 { margin-bottom: 32px; }
.mt-4 { margin-top: 16px; }
.mt-8 { margin-top: 32px; }

.text-center { text-align: center; }

/* ============================================================
   BACKGROUNDS
   ============================================================ */
.bg-obsidian { background: var(--obsidian); }
.bg-violet {
  background: linear-gradient(180deg, var(--obsidian) 0%, var(--violet) 50%, var(--obsidian) 100%);
}

/* ============================================================
   RESPONSIVE BREAKPOINTS
   ============================================================ */
@media (max-width: 1024px) {
  .grid-4 { grid-template-columns: repeat(2, 1fr); }
  .section { padding: 60px 20px; }
}

@media (max-width: 768px) {
  /* Mobile: Hide sidebar, show hamburger */
  .mobile-menu-toggle {
    display: flex;
  }
  
  .sidebar {
    position: fixed;
    transform: translateX(-100%);
    width: 280px;
    min-width: 280px;
  }
  
  .sidebar.open {
    transform: translateX(0);
  }
  
  .main-content {
    margin-left: 0;
  }
  
  /* Grids collapse to single column */
  .grid-2,
  .grid-3,
  .grid-4 {
    grid-template-columns: 1fr;
  }
  
  /* Typography scales down */
  h1 { font-size: 2rem; }
  h2 { font-size: 1.5rem; }
  
  .section {
    padding: 48px 16px;
  }
  
  .section-tag {
    position: relative;
    top: auto;
    right: auto;
    display: inline-block;
    margin-bottom: 16px;
  }
  
  .card {
    padding: 24px;
  }
  
  /* Stack flex layouts */
  .flex {
    flex-direction: column;
  }
  
  .btn {
    width: 100%;
  }
}

@media (max-width: 480px) {
  html { font-size: 14px; }
  .container { padding: 0 12px; }
  .section { padding: 40px 12px; }
}

/* ============================================================
   ANIMATIONS
   ============================================================ */
@keyframes flow {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

@keyframes ticker {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

.animate-flow {
  background-size: 200% 200%;
  animation: flow 20s ease infinite;
}

/* ============================================================
   SPECIFIC SECTION STYLES
   ============================================================ */
.hero-centered {
  min-height: 60vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.ticker-wrap {
  overflow: hidden;
  white-space: nowrap;
  padding: 20px 0;
  border-top: 1px solid var(--border-gold);
  border-bottom: 1px solid var(--border-gold);
}

.ticker-content {
  display: inline-flex;
  animation: ticker 30s linear infinite;
}

.ticker-item {
  font-family: var(--font-display);
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: var(--gold);
  padding: 0 40px;
  opacity: 0.7;
}

.specimen-card {
  background: rgba(255,255,255,0.02);
  border: 1px solid var(--border-gold);
  padding: 32px;
  position: relative;
}

.specimen-card::after {
  content: attr(data-catalog);
  position: absolute;
  top: 16px;
  right: 16px;
  font-family: var(--font-ui);
  font-size: 0.6rem;
  letter-spacing: 0.15em;
  color: var(--gold-dim);
  opacity: 0.5;
}

.process-card {
  border-left: 2px solid var(--gold);
  padding: 24px 24px 24px 32px;
  background: linear-gradient(135deg, rgba(201,169,97,0.05) 0%, transparent 100%);
}

.stat-number {
  font-family: var(--font-display);
  font-size: clamp(2rem, 4vw, 3rem);
  color: var(--gold);
  display: block;
}

.stat-label {
  font-family: var(--font-ui);
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: var(--silver);
}

.testimonial-block {
  background: rgba(255,255,255,0.03);
  border: 1px solid var(--border-gold);
  padding: 48px;
  position: relative;
}

.quote-mark {
  font-size: 6rem;
  color: rgba(201,169,97,0.1);
  position: absolute;
  top: 20px;
  left: 24px;
  font-family: Georgia, serif;
  line-height: 1;
}

.faq-item {
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.faq-question {
  padding: 20px 0;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-family: var(--font-body);
  font-size: 1.1rem;
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
}

.faq-item.open .faq-answer {
  max-height: 500px;
  padding-bottom: 20px;
}

.footer-minimal {
  padding: 24px;
  border-top: 1px solid var(--border-gold);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  font-family: var(--font-ui);
  font-size: 0.75rem;
  color: var(--silver);
}

/* Copy button */
.copy-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: rgba(201,169,97,0.1);
  border: 1px solid var(--gold);
  color: var(--gold);
  padding: 8px 16px;
  font-family: var(--font-ui);
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 20;
}

.copy-btn:hover {
  background: var(--gold);
  color: var(--obsidian);
}

@media (max-width: 768px) {
  .copy-btn {
    position: relative;
    top: auto;
    right: auto;
    display: inline-block;
    margin-bottom: 16px;
  }
}

img {
  max-width: 100%;
  height: auto;
  display: block;
}

a {
  color: var(--color-gold);
  text-decoration: none;
  transition: var(--transition-fast);
}

a:hover {
  color: var(--color-gold-bright);
}

/* ============================================
   TYPOGRAPHY SYSTEM
   ============================================ */
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-display);
  font-weight: 400;
  line-height: 1.2;
  margin-bottom: var(--space-md);
}

h1 {
  font-size: clamp(2.5rem, 5vw, 4rem);
  letter-spacing: 0.02em;
}

h2 {
  font-size: clamp(2rem, 4vw, 3rem);
  letter-spacing: 0.01em;
}

h3 {
  font-size: clamp(1.5rem, 3vw, 2rem);
}

h4 {
  font-size: 1.25rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

p {
  margin-bottom: var(--space-sm);
  max-width: 65ch;
}

.text-gold { color: var(--color-gold); }
.text-muted { color: var(--color-gray); }
.text-cream { color: var(--color-cream); }

.font-display { font-family: var(--font-display); }
.font-accent { font-family: var(--font-accent); }

/* ============================================
   SECTION BACKGROUNDS - SEAMLESS FLOW
   ============================================ */
.section {
  position: relative;
  padding: var(--section-padding);
  width: 100%;
}

.section-black {
  background: var(--color-black);
  color: var(--color-white);
}

.section-violet {
  background: linear-gradient(180deg, var(--color-violet) 0%, var(--color-violet-deep) 100%);
  color: var(--color-white);
}

.section-gold {
  background: linear-gradient(180deg, #1a1505 0%, #0f0c02 100%);
  color: var(--color-gold);
  border-top: 1px solid var(--color-gold-muted);
  border-bottom: 1px solid var(--color-gold-muted);
}

.section-cream {
  background: var(--color-cream);
  color: var(--color-black);
}

/* ============================================
   CONTAINER SYSTEM
   ============================================ */
.container {
  max-width: var(--max-width);
  margin: 0 auto;
  padding: 0 var(--space-md);
}

.container-narrow {
  max-width: 1000px;
}

.container-wide {
  max-width: 1600px;
}

/* ============================================
   SIDEBAR NAVIGATION - LIBRARY INTERFACE
   ============================================ */
.library-wrapper {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: var(--sidebar-width);
  background: var(--color-black-pure);
  border-right: 1px solid var(--color-gray-dark);
  position: fixed;
  height: 100vh;
  overflow-y: auto;
  z-index: 1000;
  padding: var(--space-md);
}

.sidebar-header {
  padding-bottom: var(--space-md);
  border-bottom: 1px solid var(--color-gold-muted);
  margin-bottom: var(--space-md);
}

.sidebar-logo {
  font-family: var(--font-display);
  font-size: 1.5rem;
  color: var(--color-gold);
  letter-spacing: 0.05em;
}

.sidebar-subtitle {
  font-size: 0.75rem;
  color: var(--color-gray);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-top: var(--space-xs);
}

.sidebar-nav {
  list-style: none;
}

.sidebar-category {
  font-family: var(--font-display);
  font-size: 0.875rem;
  color: var(--color-gold);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin: var(--space-md) 0 var(--space-sm);
  padding-bottom: var(--space-xs);
  border-bottom: 1px solid var(--color-gray-dark);
}

.sidebar-link {
  display: block;
  padding: var(--space-xs) 0;
  color: var(--color-gray-light);
  font-size: 0.9rem;
  transition: var(--transition-fast);
  border-left: 2px solid transparent;
  padding-left: var(--space-sm);
}

.sidebar-link:hover,
.sidebar-link.active {
  color: var(--color-gold);
  border-left-color: var(--color-gold);
  padding-left: var(--space-md);
}

.main-content {
  margin-left: var(--sidebar-width);
  flex: 1;
  min-height: 100vh;
}

/* ============================================
   HERO SECTION - THE EXCAVATION
   ============================================ */
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  opacity: 0.4;
  filter: grayscale(30%);
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, 
    rgba(10,10,10,0.8) 0%, 
    rgba(10,10,10,0.4) 50%, 
    rgba(10,10,10,0.9) 100%);
}

.hero-content {
  position: relative;
  z-index: 2;
  max-width: 900px;
  padding: var(--space-lg);
}

.hero-eyebrow {
  font-family: var(--font-display);
  font-size: 0.875rem;
  color: var(--color-gold);
  text-transform: uppercase;
  letter-spacing: 0.2em;
  margin-bottom: var(--space-md);
}

.hero-title {
  font-size: clamp(3rem, 6vw, 5rem);
  line-height: 1.1;
  margin-bottom: var(--space-md);
}

.hero-title em {
  color: var(--color-gold);
  font-style: italic;
}

.hero-subtitle {
  font-size: 1.25rem;
  color: var(--color-gray-light);
  max-width: 600px;
  margin: 0 auto var(--space-lg);
}

.hero-cta {
  display: inline-flex;
  align-items: center;
  gap: var(--space-sm);
  padding: var(--space-sm) var(--space-lg);
  background: transparent;
  border: 1px solid var(--color-gold);
  color: var(--color-gold);
  font-family: var(--font-display);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  transition: var(--transition-medium);
}

.hero-cta:hover {
  background: var(--color-gold);
  color: var(--color-black);
}

/* ============================================
   PROCESS SECTION - 4 STAGE DISPLAY
   ============================================ */
.process-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: var(--space-lg);
  margin-top: var(--space-xl);
}

.process-card {
  position: relative;
  padding: var(--space-lg);
  background: rgba(255,255,255,0.02);
  border: 1px solid var(--color-gray-dark);
  transition: var(--transition-medium);
}

.process-card:hover {
  border-color: var(--color-gold-muted);
  transform: translateY(-5px);
  box-shadow: var(--shadow-gold);
}

.process-number {
  font-family: var(--font-display);
  font-size: 3rem;
  color: var(--color-gold);
  opacity: 0.3;
  line-height: 1;
  margin-bottom: var(--space-sm);
}

.process-image {
  width: 100%;
  aspect-ratio: 4/3;
  object-fit: cover;
  margin-bottom: var(--space-md);
  filter: grayscale(20%);
  transition: var(--transition-medium);
}

.process-card:hover .process-image {
  filter: grayscale(0%);
}

.process-label {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.15em;
  color: var(--color-gold);
  margin-bottom: var(--space-xs);
}

/* ============================================
   SERVICES/PRICING - THE SERVICE LADDER
   ============================================ */
.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: var(--space-lg);
  margin-top: var(--space-xl);
}

.service-card {
  position: relative;
  padding: var(--space-lg);
  background: linear-gradient(145deg, rgba(26,10,46,0.6) 0%, rgba(10,10,10,0.8) 100%);
  border: 1px solid var(--color-gray-dark);
  transition: var(--transition-medium);
}

.service-card.featured {
  border-color: var(--color-gold);
  background: linear-gradient(145deg, rgba(212,175,55,0.05) 0%, rgba(10,10,10,0.9) 100%);
}

.service-tier {
  display: inline-block;
  padding: var(--space-xs) var(--space-sm);
  background: var(--color-gold);
  color: var(--color-black);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: var(--space-md);
}

.service-price {
  font-family: var(--font-display);
  font-size: 2.5rem;
  color: var(--color-gold);
  margin: var(--space-sm) 0;
}

.service-price span {
  font-size: 1rem;
  color: var(--color-gray);
}

.service-features {
  list-style: none;
  margin: var(--space-md) 0;
}

.service-features li {
  padding: var(--space-xs) 0;
  border-bottom: 1px solid var(--color-gray-dark);
  font-size: 0.9rem;
}

.service-features li::before {
  content: "â€”";
  color: var(--color-gold);
  margin-right: var(--space-sm);
}

/* ============================================
   TESTIMONIAL/CASE STUDY
   ============================================ */
.testimonial {
  max-width: 800px;
  margin: 0 auto;
  text-align: center;
  padding: var(--space-xl) var(--space-md);
}

.testimonial-quote {
  font-family: var(--font-accent);
  font-size: clamp(1.25rem, 3vw, 1.75rem);
  font-style: italic;
  line-height: 1.6;
  color: var(--color-cream);
  margin-bottom: var(--space-lg);
  position: relative;
}

.testimonial-quote::before,
.testimonial-quote::after {
  content: """;
  font-family: var(--font-display);
  font-size: 4rem;
  color: var(--color-gold);
  opacity: 0.3;
  position: absolute;
}

.testimonial-quote::before {
  top: -2rem;
  left: -2rem;
}

.testimonial-quote::after {
  content: """;
  bottom: -3rem;
  right: -2rem;
}

.testimonial-author {
  font-family: var(--font-display);
  color: var(--color-gold);
}

.testimonial-role {
  font-size: 0.875rem;
  color: var(--color-gray);
}

/* ============================================
   COMPARISON TABLE
   ============================================ */
.comparison {
  overflow-x: auto;
  margin: var(--space-xl) 0;
}

.comparison-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 600px;
}

.comparison-table th {
  font-family: var(--font-display);
  text-align: left;
  padding: var(--space-md);
  border-bottom: 2px solid var(--color-gold);
  color: var(--color-gold);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-size: 0.9rem;
}

.comparison-table td {
  padding: var(--space-md);
  border-bottom: 1px solid var(--color-gray-dark);
  vertical-align: top;
}

.comparison-table tr:hover td {
  background: rgba(212,175,55,0.05);
}

/* ============================================
   TEAM SECTION
   ============================================ */
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--space-lg);
  margin-top: var(--space-xl);
}

.team-member {
  text-align: center;
  padding: var(--space-lg);
}

.team-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  margin: 0 auto var(--space-md);
  border: 2px solid var(--color-gold);
  object-fit: cover;
}

.team-name {
  font-family: var(--font-display);
  color: var(--color-gold);
  margin-bottom: var(--space-xs);
}

.team-role {
  font-size: 0.875rem;
  color: var(--color-gray);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: var(--space-sm);
}

/* ============================================
   CTA SECTION
   ============================================ */
.cta-section {
  text-align: center;
  padding: var(--space-xxl) var(--space-md);
}

.cta-title {
  font-size: clamp(2rem, 4vw, 3rem);
  margin-bottom: var(--space-md);
}

.cta-subtitle {
  color: var(--color-gray);
  margin-bottom: var(--space-lg);
}

.cta-button {
  display: inline-block;
  padding: var(--space-sm) var(--space-xl);
  background: var(--color-gold);
  color: var(--color-black);
  font-family: var(--font-display);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  transition: var(--transition-medium);
  border: 1px solid var(--color-gold);
}

.cta-button:hover {
  background: transparent;
  color: var(--color-gold);
}

/* ============================================
   FAQ/ACCORDION
   ============================================ */
.faq-list {
  max-width: 800px;
  margin: var(--space-xl) auto;
}

.faq-item {
  border-bottom: 1px solid var(--color-gray-dark);
  padding: var(--space-md) 0;
}

.faq-question {
  font-family: var(--font-display);
  font-size: 1.125rem;
  color: var(--color-gold);
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: var(--space-sm) 0;
}

.faq-answer {
  color: var(--color-gray-light);
  padding-top: var(--space-sm);
  line-height: 1.8;
}

/* ============================================
   FOOTER
   ============================================ */
.footer {
  background: var(--color-black-pure);
  border-top: 1px solid var(--color-gray-dark);
  padding: var(--space-xl) var(--space-md);
  text-align: center;
}

.footer-logo {
  font-family: var(--font-display);
  font-size: 1.5rem;
  color: var(--color-gold);
  margin-bottom: var(--space-md);
}

.footer-tagline {
  color: var(--color-gray);
  font-size: 0.875rem;
  margin-bottom: var(--space-lg);
}

.footer-links {
  display: flex;
  justify-content: center;
  gap: var(--space-lg);
  margin-bottom: var(--space-lg);
}

.footer-links a {
  color: var(--color-gray);
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
}

.footer-links a:hover {
  color: var(--color-gold);
}

.footer-copy {
  font-size: 0.75rem;
  color: var(--color-gray-dark);
}

/* ============================================
   GEMSTONE PLACEHOLDERS
   ============================================ */
.gem-placeholder {
  background: linear-gradient(135deg, var(--color-violet) 0%, var(--color-black) 100%);
  border: 1px solid var(--color-gold-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.gem-placeholder::before {
  content: attr(data-label);
  font-family: var(--font-display);
  color: var(--color-gold);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  font-size: 0.875rem;
  z-index: 2;
}

.gem-placeholder::after {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at 30% 30%, rgba(212,175,55,0.1) 0%, transparent 50%);
}

/* ============================================
   UTILITY CLASSES
   ============================================ */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.mb-0 { margin-bottom: 0; }
.mb-sm { margin-bottom: var(--space-sm); }
.mb-md { margin-bottom: var(--space-md); }
.mb-lg { margin-bottom: var(--space-lg); }
.mb-xl { margin-bottom: var(--space-xl); }

.mt-0 { margin-top: 0; }
.mt-sm { margin-top: var(--space-sm); }
.mt-md { margin-top: var(--space-md); }
.mt-lg { margin-top: var(--space-lg); }
.mt-xl { margin-top: var(--space-xl); }

.hidden { display: none !important; }
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0,0,0,0);
  border: 0;
}

/* ============================================
   RESPONSIVE BREAKPOINTS
   ============================================ */
@media (max-width: 1024px) {
  .sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sidebar.open {
    transform: translateX(0);
  }
  
  .main-content {
    margin-left: 0;
  }
  
  .process-grid,
  .services-grid,
  .team-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  :root {
    --section-padding: 4rem 1rem;
  }
  
  .hero-title {
    font-size: 2.5rem;
  }
  
  .comparison-table {
    font-size: 0.875rem;
  }
}

        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--obsidian);
            color: var(--platinum);
            line-height: 1.7;
            font-size: 18px;
            font-weight: 400;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }
        
        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }
        
        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }
        
        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }
        
        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }
        
        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }
        
        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }
        
        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }
        
        .prestige-label-solo::before {
            width: 60px;
        }
        
        .prestige-label-solo::after {
            display: none;
        }
        
        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes flow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        
        /* Sheen Effect */
        .sheen {
            position: relative;
            overflow: hidden;
        }
        
        .sheen::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 80%;
            height: 300%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(201, 169, 97, 0.1) 25%,
                rgba(232, 213, 163, 0.2) 05%,
                rgba(201, 169, 97, 0.1) 25%,
                transparent 100%
            );
            transform: rotate(0deg);
            animation: sheen 35s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes sheen {
            0%, 80%, 100% { left: -100%; }
            40% { left: 150%; }
        }
        
        /* Museum Card */
        .museum-card {
            background: linear-gradient(145deg, var(--obsidian-lighter) 0%, var(--obsidian) 100%);
            border: 1px solid rgba(201, 169, 97, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .museum-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.3), transparent 40%, transparent 60%, rgba(201, 169, 97, 0.1)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        /* Etched Border */
        .etched {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.5),
                0 1px 0 rgba(255, 255, 255, 0.02);
        }
        
        /* Section Layouts */
        .section {
            padding: 140px 80px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .section-compact {
            padding: 100px 80px;
        }
        
        /* Asymmetric Grid */
        .asymmetric-2col {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }
        
        .asymmetric-2col-reverse {
            grid-template-columns: 1.2fr 1fr;
        }
        
        .asymmetric-3col {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 60px;
        }
        
        /* Prestige Flex Layouts */
        .prestige-flex {
            display: flex;
            gap: 60px;
        }
        
        .prestige-flex-column {
            flex-direction: column;
            gap: 40px;
        }
        
        .prestige-flex-row {
            flex-direction: row;
            align-items: flex-start;
        }
        
        .flex-uneven {
            display: flex;
            gap: 80px;
        }
        
        .flex-uneven .flex-major {
            flex: 1.5;
        }
        
        .flex-uneven .flex-minor {
            flex: 1;
        }
        
        /* Content Blocks */
        .content-block {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .content-block p {
            color: var(--silver);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 90%;
        }
        
        /* Feature Stack */
        .feature-stack {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        .feature-item {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 24px 0;
            border-bottom: 1px solid rgba(201, 169, 97, 0.08);
        }
        
        .feature-number {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--gold-dim);
            letter-spacing: 0.2em;
            min-width: 40px;
            padding-top: 4px;
        }
        
        .feature-content h4 {
            margin-bottom: 8px;
            color: var(--gold-light);
        }
        
        .feature-content p {
            color: var(--silver);
            font-size: 1rem;
            line-height: 1.7;
        }
        
        /* Nested Content */
        .nested-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-left: 24px;
            border-left: 1px solid rgba(201, 169, 97, 0.15);
            margin-top: 8px;
        }
        
        .nested-item {
            display: flex;
            gap: 16px;
            align-items: baseline;
        }
        
        .nested-bullet {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        /* Image Treatments */
        .prestige-image {
            position: relative;
            overflow: hidden;
        }
        
        .prestige-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.8) contrast(1.05);
        }
        
        .prestige-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5, 5, 5, 0.4) 0%,
                transparent 40%,
                transparent 60%,
                rgba(5, 5, 5, 0.3) 100%
            );
            pointer-events: none;
        }
        
        .image-frame {
            border: 1px solid rgba(201, 169, 97, 0.2);
            padding: 12px;
            background: var(--obsidian-lighter);
        }
        
        .image-caption {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold-dim);
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Specimen Card (Museum Style) */
        .specimen-card {
            background: var(--obsidian-lighter);
            border: 1px solid rgba(201, 169, 97, 0.12);
            padding: 40px;
            position: relative;
        }
        
        .specimen-card::before {
            content: attr(data-catalog);
            position: absolute;
            top: 16px;
            right: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            color: var(--gold-dim);
            opacity: 0.6;
        }
        
        .specimen-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Quote Block */
        .prestige-quote {
            position: relative;
            padding: 40px 0 40px 60px;
            border-left: 2px solid var(--gold);
            margin: 40px 0;
        }
        
        .prestige-quote::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .prestige-quote p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-style: italic;
            color: var(--platinum);
            line-height: 1.6;
        }
        
        .quote-attribution {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .attribution-line {
            width: 40px;
            height: 1px;
            background: var(--gold-dim);
        }
        
        .attribution-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
        }
        
        /* Buttons */
        .btn-prestige {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 18px 36px;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gold {
            background: var(--gold);
            color: var(--obsidian);
        }
        
        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-gold:hover::before {
            left: 100%;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background: rgba(201, 169, 97, 0.08);
        }
        
        /* Divider */
        .prestige-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 169, 97, 0.3), transparent);
            margin: 100px 0;
        }
        
        /* Micro Label */
        .micro-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--gold-dim);
            margin-bottom: 12px;
        }
        
        /* Value List */
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .value-list li {
            display: flex;
            align-items: baseline;
            gap: 16px;
            font-size: 1.05rem;
            color: var(--silver);
        }
        
        .value-list li::before {
            content: 'â€”';
            color: var(--gold);
            font-weight: 300;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .section {
                padding: 100px 40px;
            }
            
            .asymmetric-2col,
            .asymmetric-2col-reverse {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            
            .asymmetric-3col {
                grid-template-columns: 1fr;
            }
            
            .flex-uneven {
                flex-direction: column;
                gap: 40px;
            }
            
            .prestige-flex-row {
                flex-direction: column;
            }
        }
        
        @media (max-width: 768px) {
            .section {
                padding: 80px 24px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
        }
 /* SEAMLESS BACKGROUND SYSTEM - Matched Seams */
        /* Section 1: Origin Story - Black top to Violet bottom */
        section.origin-story {
            background: linear-gradient(180deg, #050505 0%, #08080c 50%, #121020 100%);
            position: relative;
        }
        
        section.origin-story::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: radial-gradient(ellipse at center bottom, rgba(59, 43, 95, 0.4) 0%, transparent 70%);
            pointer-events: none;
        }
        
        /* Section 2: Timeline - Violet top to Black bottom */
        section.timeline {
            background: linear-gradient(180deg, #121020 0%, #0a0a0f 50%, #050505 100%);
            position: relative;
            border-top: 1px solid rgba(245, 199, 106, 0.06);
        }
        
        section.timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: radial-gradient(ellipse at center top, rgba(59, 43, 95, 0.35) 0%, transparent 65%);
            pointer-events: none;
        }
        
        /* Section 3: Closing - Black top to Gold bottom */
        section.closing {
            background: linear-gradient(180deg, #050505 0%, #080805 50%, #0f0d08 100%);
            position: relative;
            border-top: 1px solid rgba(245, 199, 106, 0.06);
        }
        
        section.closing::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: radial-gradient(ellipse at center bottom, rgba(245, 199, 106, 0.18) 0%, transparent 60%);
            pointer-events: none;
        }
        
        /* Manifesto text styling */
        .manifesto-text {
            max-width: 800px;
            margin: 0 auto;
            font-family: var(--font-cormorant);
            font-size: 1.15rem;
            line-height: 2;
            color: var(--silver);
            position: relative;
            z-index: 1;
        }
        
        .manifesto-text p {
            margin-bottom: 1.8rem;
        }
        
        .manifesto-text strong {
            color: var(--gold-light);
            font-weight: 500;
        }
        
        .manifesto-text em {
            color: var(--gold);
            font-style: italic;
        }
        
        /* Timeline grid */
        .timeline-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
            position: relative;
            z-index: 1;
        }
        
        .timeline-item {
            transition: transform 0.4s ease;
        }
        
        .timeline-item:hover {
            transform: translateY(-5px);
        }
        
        /* Signature block */
        .signature-block {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid var(--border-gold);
            display: flex;
            align-items: center;
            gap: 24px;
            position: relative;
            z-index: 1;
        }
        
        .signature-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold-dim), transparent);
        }
        
        .signature-text {
            font-family: var(--font-cinzel);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold);
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Content layer for z-index */
        .content-layer {
            position: relative;
            z-index: 2;
        }
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
            font-weight: 300;
            letter-spacing: 0.02em;
        }
        
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: linear-gradient(to bottom, var(--black) 0%, transparent 100%);
            padding: 40px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-brand {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--white);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 50px;
            align-items: center;
        }
        
        .nav-links a {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--white);
            text-decoration: none;
            transition: color 0.3s ease;
            position: relative;
        }
        
        .nav-links a:hover {
            color: var(--gold);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .nav-cta {
            border: 1px solid var(--gold);
            padding: 12px 24px;
            color: var(--gold);
            transition: all 0.3s ease;
        }
        
        .nav-cta:hover {
            background: var(--gold);
            color: var(--black);
        }
        
        .page-header {
            padding: 200px 60px 100px;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .page-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 30px;
            display: block;
        }
        
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(42px, 6vw, 72px);
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 30px;
        }
        
        .page-subtitle {
            font-size: 14px;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.8;
        }
        
        section {
            padding: 100px 60px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-divider {
            height: 1px;
            background: var(--border-subtle);
            margin: 0 60px;
        }
        
        .service-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: start;
        }
        
        .service-info h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 300;
            margin-bottom: 20px;
        }
        
        .service-meta {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gray);
        }
        
        .service-meta span {
            color: var(--gold);
            font-weight: 500;
        }
        
        .service-description {
            font-size: 14px;
            line-height: 1.8;
            color: var(--gray-light);
            margin-bottom: 30px;
        }
        
        .service-features {
            list-style: none;
            margin-bottom: 40px;
        }
        
        .service-features li {
            font-size: 13px;
            color: var(--gray);
            padding: 12px 0;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .service-features li::before {
            content: 'â—†';
            color: var(--gold);
            font-size: 10px;
        }
        
        .price-tag {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 300;
            color: var(--gold);
            margin-bottom: 10px;
        }
        
        .price-note {
            font-size: 11px;
            color: var(--gray);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        
        .btn-primary {
            background: var(--gold);
            color: var(--black);
            padding: 18px 40px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background: var(--white);
            transform: translateY(-2px);
        }
        
        .process-list {
            border: 1px solid var(--border-subtle);
            padding: 40px;
        }
        
        .process-item {
            display: flex;
            gap: 30px;
            padding: 30px 0;
            border-bottom: 1px solid var(--border-subtle);
        }
        
        .process-item:last-child {
            border-bottom: none;
        }
        
        .process-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 300;
            color: var(--gold);
            min-width: 60px;
        }
        
        .process-content h4 {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        
        .process-content p {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.6;
        }
        
        .guarantee-box {
            border: 1px solid var(--gold);
            padding: 40px;
            text-align: center;
            margin-top: 60px;
        }
        
        .guarantee-box h4 {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 15px;
        }
        
        .guarantee-box p {
            font-size: 13px;
            color: var(--gray);
            max-width: 500px;
            margin: 0 auto;
        }
        
        footer {
            border-top: 1px solid var(--border-subtle);
            padding: 60px;
            text-align: center;
            margin-top: 100px;
        }
        
        .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 300;
            letter-spacing: 0.2em;
            margin-bottom: 20px;
        }
        
        .footer-tagline {
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 40px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-links a {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--gold);
        }
        
        .footer-copyright {
            font-size: 11px;
            color: var(--gray-dark);
        }
        
        @media (max-width: 768px) {
            nav {
                padding: 20px 30px;
                flex-direction: column;
                gap: 20px;
            }
            
            .nav-links {
                gap: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .page-header {
                padding: 150px 30px 60px;
            }
            
            section {
                padding: 60px 30px;
            }
            
            .service-detail {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .service-meta {
                flex-direction: column;
                gap: 15px;
            }
            
            .section-divider {
                margin: 0 30px;
            }
        }
      body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--obsidian);
            color: var(--platinum);
            line-height: 1.7;
            font-size: 18px;
            font-weight: 400;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }
        
        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }
        
        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }
        
        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }
        
        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }
        
        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }
        
        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }
        
        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }
        
        .prestige-label-solo::before {
            width: 60px;
        }
        
        .prestige-label-solo::after {
            display: none;
        }
        
        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes flow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }
        
        /* Sheen Effect */
        .sheen {
            position: relative;
            overflow: hidden;
        }
        
        .sheen::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 50%;
            height: 300%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(201, 169, 97, 0.1) 45%,
                rgba(232, 213, 163, 0.2) 50%,
                rgba(201, 169, 97, 0.1) 55%,
                transparent 100%
            );
            transform: rotate(25deg);
            animation: sheen 8s ease-in-out infinite;
            pointer-events: none;
        }
        
        @keyframes sheen {
            0%, 80%, 100% { left: -100%; }
            40% { left: 150%; }
        }
        
        /* Museum Card */
        .museum-card {
            background: linear-gradient(145deg, var(--obsidian-lighter) 0%, var(--obsidian) 100%);
            border: 1px solid rgba(201, 169, 97, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .museum-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.3), transparent 40%, transparent 60%, rgba(201, 169, 97, 0.1)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        /* Etched Border */
        .etched {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.5),
                0 1px 0 rgba(255, 255, 255, 0.02);
        }
        
        /* Section Layouts */
        .section {
            padding: 140px 80px;
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .section-compact {
            padding: 100px 80px;
        }
        
        /* Asymmetric Grid */
        .asymmetric-2col {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }
        
        .asymmetric-2col-reverse {
            grid-template-columns: 1.2fr 1fr;
        }
        
        .asymmetric-3col {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 60px;
        }
        
        /* Prestige Flex Layouts */
        .prestige-flex {
            display: flex;
            gap: 60px;
        }
        
        .prestige-flex-column {
            flex-direction: column;
            gap: 40px;
        }
        
        .prestige-flex-row {
            flex-direction: row;
            align-items: flex-start;
        }
        
        .flex-uneven {
            display: flex;
            gap: 80px;
        }
        
        .flex-uneven .flex-major {
            flex: 1.5;
        }
        
        .flex-uneven .flex-minor {
            flex: 1;
        }
        
        /* Content Blocks */
        .content-block {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .content-block p {
            color: var(--silver);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 90%;
        }
        
        /* Feature Stack */
        .feature-stack {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        
        .feature-item {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 24px 0;
            border-bottom: 1px solid rgba(201, 169, 97, 0.08);
        }
        
        .feature-number {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--gold-dim);
            letter-spacing: 0.2em;
            min-width: 40px;
            padding-top: 4px;
        }
        
        .feature-content h4 {
            margin-bottom: 8px;
            color: var(--gold-light);
        }
        
        .feature-content p {
            color: var(--silver);
            font-size: 1rem;
            line-height: 1.7;
        }
        
        /* Nested Content */
        .nested-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-left: 24px;
            border-left: 1px solid rgba(201, 169, 97, 0.15);
            margin-top: 8px;
        }
        
        .nested-item {
            display: flex;
            gap: 16px;
            align-items: baseline;
        }
        
        .nested-bullet {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        /* Image Treatments */
        .prestige-image {
            position: relative;
            overflow: hidden;
        }
        
        .prestige-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.8) contrast(1.05);
        }
        
        .prestige-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5, 5, 5, 0.4) 0%,
                transparent 40%,
                transparent 60%,
                rgba(5, 5, 5, 0.3) 100%
            );
            pointer-events: none;
        }
        
        .image-frame {
            border: 1px solid rgba(201, 169, 97, 0.2);
            padding: 12px;
            background: var(--obsidian-lighter);
        }
        
        .image-caption {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold-dim);
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Specimen Card (Museum Style) */
        .specimen-card {
            background: var(--obsidian-lighter);
            border: 1px solid rgba(201, 169, 97, 0.12);
            padding: 40px;
            position: relative;
        }
        
        .specimen-card::before {
            content: attr(data-catalog);
            position: absolute;
            top: 16px;
            right: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            color: var(--gold-dim);
            opacity: 0.6;
        }
        
        .specimen-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(201, 169, 97, 0.1);
        }
        
        /* Quote Block */
        .prestige-quote {
            position: relative;
            padding: 40px 0 40px 60px;
            border-left: 2px solid var(--gold);
            margin: 40px 0;
        }
        
        .prestige-quote::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .prestige-quote p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-style: italic;
            color: var(--platinum);
            line-height: 1.6;
        }
        
        .quote-attribution {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .attribution-line {
            width: 40px;
            height: 1px;
            background: var(--gold-dim);
        }
        
        .attribution-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
        }
        
        /* Buttons */
        .btn-prestige {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 18px 36px;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gold {
            background: var(--gold);
            color: var(--obsidian);
        }
        
        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-gold:hover::before {
            left: 100%;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background: rgba(201, 169, 97, 0.08);
        }
        
        /* Divider */
        .prestige-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 169, 97, 0.3), transparent);
            margin: 100px 0;
        }
        
        /* Micro Label */
        .micro-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--gold-dim);
            margin-bottom: 12px;
        }
        
        /* Value List */
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .value-list li {
            display: flex;
            align-items: baseline;
            gap: 16px;
            font-size: 1.05rem;
            color: var(--silver);
        }
        
        .value-list li::before {
            content: 'â€”';
            color: var(--gold);
            font-weight: 300;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .section {
                padding: 100px 40px;
            }
            
            .asymmetric-2col,
            .asymmetric-2col-reverse {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            
            .asymmetric-3col {
                grid-template-columns: 1fr;
            }
            
            .flex-uneven {
                flex-direction: column;
                gap: 40px;
            }
            
            .prestige-flex-row {
                flex-direction: column;
            }
        }
        
        @media (max-width: 768px) {
            .section {
                padding: 80px 24px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
        }
        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: var(--obsidian);
            color: var(--platinum);
            line-height: 1.7;
            font-size: 18px;
            font-weight: 400;
        }

        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }

        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }

        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }

        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }

        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }

        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }

        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }

        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }

        .prestige-label-solo::before {
            width: 60px;
        }

        .prestige-label-solo::after {
            display: none;
        }

        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }

        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes flow {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, 2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }

        /* Sheen Effect */
        .sheen {
            position: relative;
            overflow: hidden;
        }

        .sheen::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 50%;
            height: 300%;
            background: linear-gradient(
                to right,
                transparent 0%,
                rgba(201, 169, 97, 0.1) 45%,
                rgba(232, 213, 163, 0.2) 50%,
                rgba(201, 169, 97, 0.1) 55%,
                transparent 100%
            );
            transform: rotate(25deg);
            animation: sheen 8s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes sheen {
            0%, 80%, 100% { left: -100%; }
            40% { left: 150%; }
        }

        /* Museum Card */
        .museum-card {
            background: linear-gradient(145deg, var(--obsidian-lighter) 0%, var(--obsidian) 100%);
            border: 1px solid rgba(201, 169, 97, 0.15);
            position: relative;
            overflow: hidden;
        }

        .museum-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid transparent;
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.3), transparent 40%, transparent 60%, rgba(201, 169, 97, 0.1)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Etched Border */
        .etched {
            box-shadow: 
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.5),
                0 1px 0 rgba(255, 255, 255, 0.02);
        }

        /* Section Layouts */
        .section {
            padding: 140px 80px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .section-compact {
            padding: 100px 80px;
        }

        /* Asymmetric Grid */
        .asymmetric-2col {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }

        .asymmetric-2col-reverse {
            grid-template-columns: 1.2fr 1fr;
        }

        .asymmetric-3col {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 60px;
        }

        /* Prestige Flex Layouts */
        .prestige-flex {
            display: flex;
            gap: 60px;
        }

        .prestige-flex-column {
            flex-direction: column;
            gap: 40px;
        }

        .prestige-flex-row {
            flex-direction: row;
            align-items: flex-start;
        }

        .flex-uneven {
            display: flex;
            gap: 80px;
        }

        .flex-uneven .flex-major {
            flex: 1.5;
        }

        .flex-uneven .flex-minor {
            flex: 1;
        }

        /* Content Blocks */
        .content-block {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .content-block p {
            color: var(--silver);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 90%;
        }

        /* Feature Stack */
        .feature-stack {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .feature-item {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            padding: 24px 0;
            border-bottom: 1px solid rgba(201, 169, 97, 0.08);
        }

        .feature-number {
            font-family: 'Cinzel', serif;
            font-size: 0.85rem;
            color: var(--gold-dim);
            letter-spacing: 0.2em;
            min-width: 40px;
            padding-top: 4px;
        }

        .feature-content h4 {
            margin-bottom: 8px;
            color: var(--gold-light);
        }

        .feature-content p {
            color: var(--silver);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Nested Content */
        .nested-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding-left: 24px;
            border-left: 1px solid rgba(201, 169, 97, 0.15);
            margin-top: 8px;
        }

        .nested-item {
            display: flex;
            gap: 16px;
            align-items: baseline;
        }

        .nested-bullet {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Image Treatments */
        .prestige-image {
            position: relative;
            overflow: hidden;
        }

        .prestige-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(0.8) contrast(1.05);
        }

        .prestige-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(5, 5, 5, 0.4) 0%,
                transparent 40%,
                transparent 60%,
                rgba(5, 5, 5, 0.3) 100%
            );
            pointer-events: none;
        }

        .image-frame {
            border: 1px solid rgba(201, 169, 97, 0.2);
            padding: 12px;
            background: var(--obsidian-lighter);
        }

        .image-caption {
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold-dim);
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(201, 169, 97, 0.1);
        }

        /* Specimen Card (Museum Style) */
        .specimen-card {
            background: var(--obsidian-lighter);
            border: 1px solid rgba(201, 169, 97, 0.12);
            padding: 40px;
            position: relative;
        }

        .specimen-card::before {
            content: attr(data-catalog);
            position: absolute;
            top: 16px;
            right: 20px;
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            color: var(--gold-dim);
            opacity: 0.6;
        }

        .specimen-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(201, 169, 97, 0.1);
        }

        /* Quote Block */
        .prestige-quote {
            position: relative;
            padding: 40px 0 40px 60px;
            border-left: 2px solid var(--gold);
            margin: 40px 0;
        }

        .prestige-quote::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 60px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }

        .prestige-quote p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-style: italic;
            color: var(--platinum);
            line-height: 1.6;
        }

        .quote-attribution {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .attribution-line {
            width: 40px;
            height: 1px;
            background: var(--gold-dim);
        }

        .attribution-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
        }

        /* Buttons */
        .btn-prestige {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 18px 36px;
            font-family: 'Cinzel', serif;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            text-decoration: none;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-gold {
            background: var(--gold);
            color: var(--obsidian);
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-outline {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }

        .btn-outline:hover {
            background: rgba(201, 169, 97, 0.08);
        }

        /* Divider */
        .prestige-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(201, 169, 97, 0.3), transparent);
            margin: 100px 0;
        }

        /* Micro Label */
        .micro-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--gold-dim);
            margin-bottom: 12px;
        }

        /* Value List */
        .value-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .value-list li {
            display: flex;
            align-items: baseline;
            gap: 16px;
            font-size: 1.05rem;
            color: var(--silver);
        }

        .value-list li::before {
            content: 'â€”';
            color: var(--gold);
            font-weight: 300;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .section {
                padding: 100px 40px;
            }

            .asymmetric-2col,
            .asymmetric-2col-reverse {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .asymmetric-3col {
                grid-template-columns: 1fr;
            }

            .flex-uneven {
                flex-direction: column;
                gap: 40px;
            }

            .prestige-flex-row {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .section {
                padding: 80px 24px;
            }

            h1 {
                font-size: 2.2rem;
            }
        }

    
    /* ============================================
       NAVIGATION
       ============================================ */
    .nav-prestige {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 80px;
      background: rgba(5,5,5,0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--border-gold);
    }
    
    .nav-prestige .brand {
      font-family: var(--font-cinzel);
      font-size: 1.4rem;
      color: var(--platinum);
      letter-spacing: 0.15em;
      text-transform: uppercase;
    }
    
    .nav-prestige .brand small {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.5rem;
      color: var(--silver);
      letter-spacing: 0.2em;
      margin-top: 2px;
    }
    
    .nav-prestige .links {
      display: flex;
      gap: 40px;
    }
    
    .nav-prestige .links a {
      font-family: var(--font-inter);
      font-size: 0.75rem;
      color: var(--silver);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      transition: color 0.3s;
    }
    
    .nav-prestige .links a:hover { color: var(--gold); }
    
    .nav-prestige .nav-right {
      display: flex;
      align-items: center;
      gap: 24px;
    }
    
    .nav-prestige .availability {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      color: var(--gold);
      font-size: 1.5rem;
      cursor: pointer;
    }
    
    /* ============================================
       BUTTONS
       ============================================ */
    .btn-gold {
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%);
      color: var(--obsidian);
      font-family: var(--font-inter);
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      padding: 16px 32px;
      border: none;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .btn-gold:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(201,169,97,0.3);
    }
    
    .btn-outline-gold {
      background: transparent;
      color: var(--gold);
      font-family: var(--font-inter);
      font-size: 0.65rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      padding: 14px 28px;
      border: 1px solid var(--gold);
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .btn-outline-gold:hover {
      background: var(--gold);
      color: var(--obsidian);
    }
    
    .btn-row {
      display: flex;
      gap: 20px;
      margin-top: 32px;
    }
    
    /* ============================================
       SECTIONS BASE
       ============================================ */
    section {
      width: 100%;
      position: relative;
    }
    
    .sec-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 80px;
      position: relative;
      z-index: 2;
    }
    
    /* Background Colors with Center Spheres */
    .bg-black { background-color: var(--obsidian); }
    
    .bg-violet-sphere {
      background-color: var(--obsidian);
      background-image: radial-gradient(circle at 50% 50%, rgba(59,43,95,0.4) 0%, rgba(59,43,95,0.15) 35%, transparent 65%);
    }
    
    .bg-gold-sphere {
      background-color: var(--obsidian);
      background-image: radial-gradient(circle at 50% 50%, rgba(201,169,97,0.12) 0%, rgba(201,169,97,0.05) 30%, transparent 60%);
      border-top: 1px solid var(--border-gold);
      border-bottom: 1px solid var(--border-gold);
    }
    
    /* ============================================
       HERO SECTION
       ============================================ */
    .hero-centered {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 160px 0 140px;
    }
    
    .prestige-label {
      display: inline-block;
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.25em;
      margin-bottom: 24px;
      border-bottom: 1px solid var(--border-gold);
      padding-bottom: 8px;
    }
    
    .hero-centered h1 {
      font-family: var(--font-cinzel);
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      line-height: 1.1;
      color: var(--platinum);
      margin-bottom: 24px;
    }
    
    .hero-centered h1 em {
      color: var(--gold);
      font-style: italic;
      text-shadow: 0 0 40px rgba(201,169,97,0.3);
    }
    
    .hero-centered .sub {
      font-family: var(--font-cormorant);
      font-size: 1.25rem;
      color: var(--silver);
      line-height: 1.8;
      max-width: 600px;
      margin: 0 auto;
      font-style: italic;
    }
    
    /* ============================================
       MANIFESTO SECTION
       ============================================ */
    .manifesto-section {
      padding: 140px 0;
    }
    
    .manifesto-inner {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }
    
    .manifesto-number {
      font-family: var(--font-cinzel);
      font-size: 0.9rem;
      color: var(--gold);
      letter-spacing: 0.2em;
      margin-bottom: 20px;
      opacity: 0.6;
    }
    
    .manifesto-heading {
      font-family: var(--font-cinzel);
      font-size: clamp(1.8rem, 3vw, 2.8rem);
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      line-height: 1.2;
      margin-bottom: 40px;
    }
    
    .manifesto-heading em {
      color: var(--gold);
      font-style: italic;
    }
    
    .manifesto-body {
      margin-bottom: 40px;
    }
    
    .manifesto-body p {
      font-family: var(--font-cormorant);
      font-size: 1.2rem;
      color: var(--silver);
      line-height: 1.9;
      margin-bottom: 20px;
      font-style: italic;
    }
    
    .manifesto-signature {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
    }
    
    .sig-line {
      width: 60px;
      height: 1px;
      background: var(--gold);
    }
    
    .sig-text {
      font-family: var(--font-cinzel);
      font-size: 0.75rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    
    .sig-role {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--silver);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-top: 4px;
    }
    
    /* ============================================
       PROCESS ALTERNATING
       ============================================ */
    .process-section {
      padding: 140px 0;
    }
    
    .process-alt-item {
      display: flex;
      align-items: center;
      gap: 80px;
      margin-bottom: 120px;
    }
    
    .process-alt-item:last-child { margin-bottom: 0; }
    
    /* First item: Text LEFT, Image RIGHT */
    .process-alt-item:nth-child(1) { flex-direction: row; }
    
    /* Second item: Image LEFT, Text RIGHT */
    .process-alt-item:nth-child(2) { flex-direction: row-reverse; }
    
    .process-alt-item .text-side { flex: 1; }
    .process-alt-item .img-side { flex: 1; position: relative; }
    
    .micro-label {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.2em;
      margin-bottom: 16px;
    }
    
    .process-alt-item h3 {
      font-family: var(--font-cinzel);
      font-size: 1.6rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 20px;
      line-height: 1.3;
    }
    
    .process-alt-item p {
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.9;
      margin-bottom: 16px;
    }
    
    .image-frame {
      position: relative;
      border: 1px solid var(--border-gold);
      padding: 12px;
      background: rgba(201,169,97,0.05);
    }
    
    .prestige-image {
      position: relative;
      overflow: hidden;
    }
    
    .prestige-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    
    .catalog-tag {
      position: absolute;
      bottom: -15px;
      right: 20px;
      background: var(--obsidian);
      border: 1px solid var(--border-gold);
      padding: 12px 20px;
      text-align: center;
    }
    
    .catalog-tag.left {
      right: auto;
      left: 20px;
    }
    
    .catalog-tag span {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.55rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-bottom: 4px;
    }
    
    .catalog-tag p {
      font-family: var(--font-cinzel);
      font-size: 0.75rem;
      color: var(--platinum);
      margin: 0;
    }
    
    /* ============================================
       GEM SECTION (THE EVIDENCE)
       ============================================ */
    .gem-section {
      padding: 140px 0;
    }
    
    .gem-panels {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }
    
    .gem-text-left {
      flex: 0 0 280px;
      text-align: left;
    }
    
    .gem-text-left h2 {
      font-family: var(--font-cinzel);
      font-size: 1.8rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--platinum);
      line-height: 1.2;
      margin: 20px 0;
    }
    
    .gem-text-left p {
      font-family: var(--font-cormorant);
      font-size: 1.15rem;
      color: var(--silver);
      line-height: 1.8;
      font-style: italic;
    }
    
    .gem-stage {
      flex: 0 0 400px;
      text-align: center;
    }
    
    .squircle-frame {
      width: 400px;
      height: 400px;
      border-radius: 48px;
      overflow: hidden;
      border: 2px solid var(--gold);
      box-shadow: 0 0 60px rgba(201,169,97,0.25);
      position: relative;
      margin: 0 auto;
    }
    
    .squircle-frame img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .squircle-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 40%, transparent 60%, rgba(201,169,97,0.2) 100%);
      pointer-events: none;
    }
    
    .gem-caption-bar {
      margin-top: 24px;
    }
    
    .gem-caption-bar h4 {
      font-family: var(--font-cinzel);
      font-size: 0.85rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 8px;
    }
    
    .gem-caption-bar p {
      font-size: 0.9rem;
      color: var(--silver);
    }
    
    .gem-text-right {
      flex: 0 0 200px;
      text-align: right;
    }
    
    .stats-bar {
      display: flex;
      flex-direction: column;
      gap: 24px;
      align-items: flex-end;
    }
    
    .stat-item {
      text-align: right;
    }
    
    .stat-number {
      display: block;
      font-family: var(--font-cinzel);
      font-size: 2.5rem;
      color: var(--gold);
      line-height: 1;
      margin-bottom: 4px;
    }
    
    .stat-label {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--silver);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    /* ============================================
       VAULT SECTION
       ============================================ */

SECTION
       ============================================ */
    .vault-section {
      padding: 160px 0;
      text-align: center;
    }
    
    .vault-door-frame {
      max-width: 700px;
      margin: 0 auto;
      border: 1px solid var(--border-gold);
      padding: 60px;
      background: rgba(201,169,97,0.03);
      position: relative;
    }
    
    .vault-door-frame::before {
      content: '';
      position: absolute;
      inset: 10px;
      border: 1px solid rgba(201,169,97,0.1);
      pointer-events: none;
    }
    
    .vault-seal {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 2px solid var(--gold);
      margin: 0 auto 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 40px rgba(201,169,97,0.2);
    }
    
    .vault-seal img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .vault-title {
      font-family: var(--font-cinzel);
      font-size: 2rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--platinum);
      margin-bottom: 20px;
    }
    
    .vault-subtitle {
      font-family: var(--font-cormorant);
      font-size: 1.2rem;
      color: var(--silver);
      font-style: italic;
      line-height: 1.6;
      margin-bottom: 16px;
    }
    
    .vault-copy {
      font-size: 0.95rem;
      color: var(--silver);
      max-width: 500px;
      margin: 0 auto 32px;
      line-height: 1.8;
    }
    
    .vault-lock-line {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid var(--border-gold);
    }
    
    .vault-lock-line span {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    /* ============================================
       FOOTER
       ============================================ */
    .footer-prestige {
      background: var(--obsidian-light);
      border-top: 1px solid var(--border-gold);
      padding: 80px 0 40px;
    }
    
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 80px;
      display: flex;
      justify-content: space-between;
      gap: 60px;
      margin-bottom: 60px;
    }
    
    .brand-block h4 {
      font-family: var(--font-cinzel);
      font-size: 1.2rem;
      color: var(--platinum);
      letter-spacing: 0.1em;
      margin-bottom: 16px;
    }
    
    .brand-block > p {
      font-size: 0.9rem;
      color: var(--silver);
      line-height: 1.7;
      max-width: 300px;
      margin-bottom: 24px;
    }
    
    .avail p {
      font-family: var(--font-inter);
      font-size: 0.7rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 4px;
    }
    
    .nav-cols {
      display: flex;
      gap: 80px;
    }
    
    .nav-col h5 {
      font-family: var(--font-inter);
      font-size: 0.7rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-bottom: 20px;
    }
    
    .nav-col ul {
      list-style: none;
    }
    
    .nav-col li {
      margin-bottom: 12px;
    }
    
    .nav-col a {
      font-size: 0.85rem;
      color: var(--silver);
      text-decoration: none;
      transition: color 0.3s;
    }
    
    .nav-col a:hover { color: var(--gold); }
    
    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 80px 0;
      border-top: 1px solid rgba(255,255,255,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .footer-bottom p {
      font-size: 0.75rem;
      color: var(--silver);
    }
    
    .legal-links {
      display: flex;
      gap: 24px;
    }
    
    .legal-links a {
      font-size: 0.75rem;
      color: var(--silver);
      text-decoration: none;
    }
    
    /* ============================================
       MOBILE RESPONSIVE
       ============================================ */
    @media (max-width: 968px) {
      .nav-prestige {
        padding: 16px 24px;
      }
      
      .nav-prestige .links,
      .nav-prestige .availability,
      .nav-prestige .nav-right .btn-outline-gold {
        display: none;
      }
      
      .mobile-menu-btn {
        display: block;
      }
      
      .sec-wrap {
        padding: 0 24px;
      }
      
      .hero-centered {
        min-height: auto;
        padding: 140px 0 100px;
      }
      
      .hero-centered h1 {
        font-size: 2rem;
      }
      
      .btn-row {
        flex-direction: column;
        align-items: center;
      }
      
      .process-alt-item,
      .process-alt-item:nth-child(1),
      .process-alt-item:nth-child(2) {
        flex-direction: column !important;
        gap: 40px;
      }
      
      .process-alt-item .img-side {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }
      
      .catalog-tag {
        position: relative;
        bottom: auto;
        right: auto;
        margin-top: 16px;
        display: inline-block;
      }
      
      .gem-panels {
        flex-direction: column;
        text-align: center;
      }
      
      .gem-text-left,
      .gem-text-right {
        flex: none;
        width: 100%;
        text-align: center;
      }
      
      .gem-stage {
        flex: none;
        width: 100%;
        max-width: 400px;
      }
      
      .squircle-frame {
        width: 100%;
        max-width: 350px;
        height: auto;
        aspect-ratio: 1/1;
        margin: 0 auto;
      }
      
      .stats-bar {
        align-items: center;
      }
      
      .stat-item {
        text-align: center;
      }
      
      .vault-door-frame {
        margin: 0 24px;
        padding: 40px 24px;
      }
      
      .footer-inner {
        flex-direction: column;
        padding: 0 24px;
        text-align: center;
      }
      
      .brand-block > p {
        max-width: 100%;
      }
      
      .nav-cols {
        justify-content: center;
        gap: 40px;
      }
      
      .footer-bottom {
        flex-direction: column;
        gap: 16px;
        text-align: center;
        padding: 20px 24px;
      }
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 1s ease, transform 1s ease;
    }
    
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Mobile Menu Overlay */
    .mobile-menu {
      position: fixed;
      inset: 0;
      background: rgba(5,5,5,0.98);
      z-index: 999;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 30px;
    }
    
    .mobile-menu.active {
      display: flex;
    }
    
    .mobile-menu a {
      font-family: var(--font-cinzel);
      font-size: 1.5rem;
      color: var(--platinum);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    
    .mobile-menu a:hover {
      color: var(--gold);
    }
    
    .mobile-menu .close-btn {
      position: absolute;
      top: 20px;
      right: 24px;
      background: none;
      border: none;
      color: var(--gold);
      font-size: 2rem;
      cursor: pointer;
    }
 /* ============================================
       NAVIGATION
       ============================================ */
    .nav-prestige {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 80px;
      background: rgba(5,5,5,0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--border-gold);
    }
    
    .nav-prestige .brand {
      font-family: var(--font-cinzel);
      font-size: 1.4rem;
      color: var(--platinum);
      letter-spacing: 0.15em;
      text-transform: uppercase;
    }
    
    .nav-prestige .brand small {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.5rem;
      color: var(--silver);
      letter-spacing: 0.2em;
      margin-top: 2px;
    }
    
    .nav-prestige .links {
      display: flex;
      gap: 40px;
    }
    
    .nav-prestige .links a {
      font-family: var(--font-inter);
      font-size: 0.75rem;
      color: var(--silver);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      transition: color 0.3s;
    }
    
    .nav-prestige .links a:hover { color: var(--gold); }
    
    .nav-prestige .nav-right {
      display: flex;
      align-items: center;
      gap: 24px;
    }
    
    .nav-prestige .availability {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      color: var(--gold);
      font-size: 1.5rem;
      cursor: pointer;
    }
    
    /* ============================================
       BUTTONS
       ============================================ */
    .btn-gold {
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%);
      color: var(--obsidian);
      font-family: var(--font-inter);
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      padding: 16px 32px;
      border: none;
      cursor: pointer;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .btn-gold:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(201,169,97,0.3);
    }
    
    .btn-outline-gold {
      background: transparent;
      color: var(--gold);
      font-family: var(--font-inter);
      font-size: 0.65rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      padding: 14px 28px;
      border: 1px solid var(--gold);
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .btn-outline-gold:hover {
      background: var(--gold);
      color: var(--obsidian);
    }
    
    .btn-row {
      display: flex;
      gap: 20px;
      margin-top: 32px;
    }
    
    /* ============================================
       SECTIONS BASE
       ============================================ */
    section {
      width: 100%;
      position: relative;
    }
    
    .sec-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 80px;
      position: relative;
      z-index: 2;
    }
    
    /* Background Colors with Center Spheres */
    .bg-black { background-color: var(--obsidian); }
    
    .bg-violet-sphere {
      background-color: var(--obsidian);
      background-image: radial-gradient(circle at 50% 50%, rgba(59,43,95,0.4) 0%, rgba(59,43,95,0.15) 35%, transparent 65%);
    }
    
    .bg-gold-sphere {
      background-color: var(--obsidian);
      background-image: radial-gradient(circle at 50% 50%, rgba(201,169,97,0.12) 0%, rgba(201,169,97,0.05) 30%, transparent 60%);
      border-top: 1px solid var(--border-gold);
      border-bottom: 1px solid var(--border-gold);
    }
    
    /* ============================================
       HERO SECTION
       ============================================ */
    .hero-centered {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 160px 0 140px;
    }
    
    .prestige-label {
      display: inline-block;
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.25em;
      margin-bottom: 24px;
      border-bottom: 1px solid var(--border-gold);
      padding-bottom: 8px;
    }
    
    .hero-centered h1 {
      font-family: var(--font-cinzel);
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      line-height: 1.1;
      color: var(--platinum);
      margin-bottom: 24px;
    }
    
    .hero-centered h1 em {
      color: var(--gold);
      font-style: italic;
      text-shadow: 0 0 40px rgba(201,169,97,0.3);
    }
    
    .hero-centered .sub {
      font-family: var(--font-cormorant);
      font-size: 1.25rem;
      color: var(--silver);
      line-height: 1.8;
      max-width: 600px;
      margin: 0 auto;
      font-style: italic;
    }
    
    /* ============================================
       MANIFESTO SECTION
       ============================================ */
    .manifesto-section {
      padding: 140px 0;
    }
    
    .manifesto-inner {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }
    
    .manifesto-number {
      font-family: var(--font-cinzel);
      font-size: 0.9rem;
      color: var(--gold);
      letter-spacing: 0.2em;
      margin-bottom: 20px;
      opacity: 0.6;
    }
    
    .manifesto-heading {
      font-family: var(--font-cinzel);
      font-size: clamp(1.8rem, 3vw, 2.8rem);
      font-weight: 400;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      line-height: 1.2;
      margin-bottom: 40px;
    }
    
    .manifesto-heading em {
      color: var(--gold);
      font-style: italic;
    }
    
    .manifesto-body {
      margin-bottom: 40px;
    }
    
    .manifesto-body p {
      font-family: var(--font-cormorant);
      font-size: 1.2rem;
      color: var(--silver);
      line-height: 1.9;
      margin-bottom: 20px;
      font-style: italic;
    }
    
    .manifesto-signature {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
    }
    
    .sig-line {
      width: 60px;
      height: 1px;
      background: var(--gold);
    }
    
    .sig-text {
      font-family: var(--font-cinzel);
      font-size: 0.75rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    
    .sig-role {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--silver);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-top: 4px;
    }
    
    /* ============================================
       PROCESS ALTERNATING
       ============================================ */
    .process-section {
      padding: 140px 0;
    }
    
    .process-alt-item {
      display: flex;
      align-items: center;
      gap: 80px;
      margin-bottom: 120px;
    }
    
    .process-alt-item:last-child { margin-bottom: 0; }
    
    /* First item: Text LEFT, Image RIGHT */
    .process-alt-item:nth-child(1) { flex-direction: row; }
    
    /* Second item: Image LEFT, Text RIGHT */
    .process-alt-item:nth-child(2) { flex-direction: row-reverse; }
    
    .process-alt-item .text-side { flex: 1; }
    .process-alt-item .img-side { flex: 1; position: relative; }
    
    .micro-label {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.2em;
      margin-bottom: 16px;
    }
    
    .process-alt-item h3 {
      font-family: var(--font-cinzel);
      font-size: 1.6rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 20px;
      line-height: 1.3;
    }
    
    .process-alt-item p {
      font-size: 1rem;
      color: var(--silver);
      line-height: 1.9;
      margin-bottom: 16px;
    }
    
    .image-frame {
      position: relative;
      border: 1px solid var(--border-gold);
      padding: 12px;
      background: rgba(201,169,97,0.05);
    }
    
    .prestige-image {
      position: relative;
      overflow: hidden;
    }
    
    .prestige-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    
    .catalog-tag {
      position: absolute;
      bottom: -15px;
      right: 20px;
      background: var(--obsidian);
      border: 1px solid var(--border-gold);
      padding: 12px 20px;
      text-align: center;
    }
    
    .catalog-tag.left {
      right: auto;
      left: 20px;
    }
    
    .catalog-tag span {
      display: block;
      font-family: var(--font-inter);
      font-size: 0.55rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-bottom: 4px;
    }
    
    .catalog-tag p {
      font-family: var(--font-cinzel);
      font-size: 0.75rem;
      color: var(--platinum);
      margin: 0;
    }
    
    /* ============================================
       GEM SECTION (THE EVIDENCE)
       ============================================ */
    .gem-section {
      padding: 140px 0;
    }
    
    .gem-panels {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 60px;
    }
    
    .gem-text-left {
      flex: 0 0 280px;
      text-align: left;
    }
    
    .gem-text-left h2 {
      font-family: var(--font-cinzel);
      font-size: 1.8rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--platinum);
      line-height: 1.2;
      margin: 20px 0;
    }
    
    .gem-text-left p {
      font-family: var(--font-cormorant);
      font-size: 1.15rem;
      color: var(--silver);
      line-height: 1.8;
      font-style: italic;
    }
    
    .gem-stage {
      flex: 0 0 400px;
      text-align: center;
    }
    
    .squircle-frame {
      width: 400px;
      height: 400px;
      border-radius: 48px;
      overflow: hidden;
      border: 2px solid var(--gold);
      box-shadow: 0 0 60px rgba(201,169,97,0.25);
      position: relative;
      margin: 0 auto;
    }
    
    .squircle-frame img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .squircle-shine {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 40%, transparent 60%, rgba(201,169,97,0.2) 100%);
      pointer-events: none;
    }
    
    .gem-caption-bar {
      margin-top: 24px;
    }
    
    .gem-caption-bar h4 {
      font-family: var(--font-cinzel);
      font-size: 0.85rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 8px;
    }
    
    .gem-caption-bar p {
      font-size: 0.9rem;
      color: var(--silver);
    }
    
    .gem-text-right {
      flex: 0 0 200px;
      text-align: right;
    }
    
    .stats-bar {
      display: flex;
      flex-direction: column;
      gap: 24px;
      align-items: flex-end;
    }
    
    .stat-item {
      text-align: right;
    }
    
    .stat-number {
      display: block;
      font-family: var(--font-cinzel);
      font-size: 2.5rem;
      color: var(--gold);
      line-height: 1;
      margin-bottom: 4px;
    }
    
    .stat-label {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--silver);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    /* ============================================
       VAULT SECTION
       ============================================ */
    .vault-section {
      padding: 160px 0;
      text-align: center;
    }
    
    .vault-door-frame {
      max-width: 700px;
      margin: 0 auto;
      border: 1px solid var(--border-gold);
      padding: 60px;
      background: rgba(201,169,97,0.03);
      position: relative;
    }
    
    .vault-door-frame::before {
      content: '';
      position: absolute;
      inset: 10px;
      border: 1px solid rgba(201,169,97,0.1);
      pointer-events: none;
    }
    
    .vault-seal {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 2px solid var(--gold);
      margin: 0 auto 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 40px rgba(201,169,97,0.2);
    }
    
    .vault-seal img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .vault-title {
      font-family: var(--font-cinzel);
      font-size: 2rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--platinum);
      margin-bottom: 20px;
    }
    
    .vault-subtitle {
      font-family: var(--font-cormorant);
      font-size: 1.2rem;
      color: var(--silver);
      font-style: italic;
      line-height: 1.6;
      margin-bottom: 16px;
    }
    
    .vault-copy {
      font-size: 0.95rem;
      color: var(--silver);
      max-width: 500px;
      margin: 0 auto 32px;
      line-height: 1.8;
    }
    
    .vault-lock-line {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px solid var(--border-gold);
    }
    
    .vault-lock-line span {
      font-family: var(--font-inter);
      font-size: 0.65rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.15em;
    }
    
    /* ============================================
       FOOTER
       ============================================ */
    .footer-prestige {
      background: var(--obsidian-light);
      border-top: 1px solid var(--border-gold);
      padding: 80px 0 40px;
    }
    
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 80px;
      display: flex;
      justify-content: space-between;
      gap: 60px;
      margin-bottom: 60px;
    }
    
    .brand-block h4 {
      font-family: var(--font-cinzel);
      font-size: 1.2rem;
      color: var(--platinum);
      letter-spacing: 0.1em;
      margin-bottom: 16px;
    }
    
    .brand-block > p {
      font-size: 0.9rem;
      color: var(--silver);
      line-height: 1.7;
      max-width: 300px;
      margin-bottom: 24px;
    }
    
    .avail p {
      font-family: var(--font-inter);
      font-size: 0.7rem;
      color: var(--gold);
      text-transform: uppercase;
      letter-spacing: 0.1em;
      margin-bottom: 4px;
    }
    
    .nav-cols {
      display: flex;
      gap: 80px;
    }
    
    .nav-col h5 {
      font-family: var(--font-inter);
      font-size: 0.7rem;
      color: var(--platinum);
      text-transform: uppercase;
      letter-spacing: 0.15em;
      margin-bottom: 20px;
    }
    
    .nav-col ul {
      list-style: none;
    }
    
    .nav-col li {
      margin-bottom: 12px;
    }
    
    .nav-col a {
      font-size: 0.85rem;
      color: var(--silver);
      text-decoration: none;
      transition: color 0.3s;
    }
    
    .nav-col a:hover { color: var(--gold); }
    
    .footer-bottom {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 80px 0;
      border-top: 1px solid rgba(255,255,255,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .footer-bottom p {
      font-size: 0.75rem;
      color: var(--silver);
    }
    
    .legal-links {
      display: flex;
      gap: 24px;
    }
    
    .legal-links a {
      font-size: 0.75rem;
      color: var(--silver);
      text-decoration: none;
    }
    
    /* ============================================
       MOBILE RESPONSIVE
       ============================================ */
    @media (max-width: 968px) {
      .nav-prestige {
        padding: 16px 24px;
      }
      
      .nav-prestige .links,
      .nav-prestige .availability,
      .nav-prestige .nav-right .btn-outline-gold {
        display: none;
      }
      
      .mobile-menu-btn {
        display: block;
      }
      
      .sec-wrap {
        padding: 0 24px;
      }
      
      .hero-centered {
        min-height: auto;
        padding: 140px 0 100px;
      }
      
      .hero-centered h1 {
        font-size: 2rem;
      }
      
      .btn-row {
        flex-direction: column;
        align-items: center;
      }
      
      .process-alt-item,
      .process-alt-item:nth-child(1),
      .process-alt-item:nth-child(2) {
        flex-direction: column !important;
        gap: 40px;
      }
      
      .process-alt-item .img-side {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }
      
      .catalog-tag {
        position: relative;
        bottom: auto;
        right: auto;
        margin-top: 16px;
        display: inline-block;
      }
      
      .gem-panels {
        flex-direction: column;
        text-align: center;
      }
      
      .gem-text-left,
      .gem-text-right {
        flex: none;
        width: 100%;
        text-align: center;
      }
      
      .gem-stage {
        flex: none;
        width: 100%;
        max-width: 400px;
      }
      
      .squircle-frame {
        width: 100%;
        max-width: 350px;
        height: auto;
        aspect-ratio: 1/1;
        margin: 0 auto;
      }
      
      .stats-bar {
        align-items: center;
      }
      
      .stat-item {
        text-align: center;
      }
      
      .vault-door-frame {
        margin: 0 24px;
        padding: 40px 24px;
      }
      
      .footer-inner {
        flex-direction: column;
        padding: 0 24px;
        text-align: center;
      }
      
      .brand-block > p {
        max-width: 100%;
      }
      
      .nav-cols {
        justify-content: center;
        gap: 40px;
      }
      
      .footer-bottom {
        flex-direction: column;
        gap: 16px;
        text-align: center;
        padding: 20px 24px;
      }
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    .reveal {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 1s ease, transform 1s ease;
    }
    
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Mobile Menu Overlay */
    .mobile-menu {
      position: fixed;
      inset: 0;
      background: rgba(5,5,5,0.98);
      z-index: 999;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 30px;
    }
    
    .mobile-menu.active {
      display: flex;
    }
    
    .mobile-menu a {
      font-family: var(--font-cinzel);
      font-size: 1.5rem;
      color: var(--platinum);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    
    .mobile-menu a:hover {
      color: var(--gold);
    }
    
    .mobile-menu .close-btn {
      position: absolute;
      top: 20px;
      right: 24px;
      background: none;
      border: none;
      color: var(--gold);
      font-size: 2rem;
      cursor: pointer;
    }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }

        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        /* Spacing */
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        /* Labels */
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        /* Cards */
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        /* Image containers */
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        /* Grid layouts */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        /* Service cards specific */
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        /* Feature list */
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        /* Phase/Process cards */
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        /* Stats */
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        /* Testimonial */
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        /* Pricing table */
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        /* Comparison table */
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        /* FAQ */
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        /* Navigation pills */
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        /* Split layout */
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        /* Responsive */
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; }
        h2 { font-size: clamp(2rem, 4vw, 3rem); line-height: 1.2; }
        h3 { font-size: clamp(1.5rem, 3vw, 2rem); }
        h4 { font-size: 1.25rem; }
        
        .text-gold { color: var(--gold); }
        .text-gray { color: var(--gray); }
        .text-center { text-align: center; }
        
        .section { padding: 100px 0; }
        .section-sm { padding: 60px 0; }
        
        .label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gold);
            margin-bottom: 16px;
        }
        
        .label-outline {
            border: 1px solid var(--gold);
            padding: 6px 12px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .btn-primary:hover {
            background-color: var(--gold-light);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--black);
        }
        
        .card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 40px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-4px);
        }
        
        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--black-lighter);
        }
        
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        .service-card {
            position: relative;
            padding: 48px 40px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
        }
        
        .service-card::before {
            content: attr(data-label);
            position: absolute;
            top: 0;
            left: 40px;
            transform: translateY(-50%);
            background-color: var(--black);
            padding: 0 12px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--gold);
        }
        
        .feature-list {
            list-style: none;
            margin-top: 24px;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: var(--gray-light);
        }
        
        .feature-list li::before {
            content: "â€”";
            color: var(--gold);
            font-weight: 600;
        }
        
        .phase-card {
            position: relative;
            padding: 40px;
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 100%);
            border-left: 2px solid var(--gold);
        }
        
        .phase-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: rgba(212, 175, 55, 0.2);
            position: absolute;
            top: 20px;
            right: 30px;
            font-weight: 700;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            display: block;
            line-height: 1;
        }
        
        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--gray);
            margin-top: 8px;
        }
        
        .testimonial {
            background-color: var(--black-light);
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.15);
            position: relative;
        }
        
        .testimonial::before {
            content: """;
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            color: rgba(212, 175, 55, 0.1);
            position: absolute;
            top: 20px;
            left: 30px;
            line-height: 1;
        }
        
        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            margin-top: 30px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--black);
        }
        
        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 4px;
        }
        
        .author-info p {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .pricing-card {
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.1);
            padding: 48px 40px;
            text-align: center;
            position: relative;
        }
        
        .pricing-card.featured {
            border-color: var(--gold);
            transform: scale(1.05);
        }
        
        .pricing-card.featured::before {
            content: "Most Popular";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--gold);
            color: var(--black);
            padding: 6px 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        
        .price {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--gold);
            margin: 24px 0;
        }
        
        .price span {
            font-size: 1rem;
            color: var(--gray);
        }
        
        .timeline {
            position: relative;
            padding-left: 40px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--gold), transparent);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 40px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -44px;
            top: 8px;
            width: 9px;
            height: 9px;
            background-color: var(--gold);
            border-radius: 50%;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
        }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .comparison-table th,
        .comparison-table td {
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .comparison-table th {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            color: var(--gold);
            font-size: 1.1rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        }
        
        .comparison-table td:first-child {
            font-weight: 500;
        }
        
        .check {
            color: var(--gold);
            font-weight: 600;
        }
        
        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 0;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
        }
        
        .faq-question::after {
            content: '+';
            color: var(--gold);
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .faq-answer {
            margin-top: 16px;
            color: var(--gray-light);
            line-height: 1.8;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--black-light) 0%, var(--black) 50%, var(--black-light) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .nav-pills {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            padding: 12px 24px;
            background-color: var(--black-light);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill:hover,
        .nav-pill.active {
            background-color: var(--gold);
            color: var(--black);
            border-color: var(--gold);
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        
        .split-content {
            padding: 40px 0;
        }
        
        .split-media {
            position: relative;
        }
        
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 8px 16px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gold);
            margin-bottom: 24px;
        }
        
        @media (max-width: 968px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .split-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .testimonial {
                padding: 40px 24px;
            }
            
            .cta-section {
                padding: 60px 24px;
            }
        }

        }
        
        /* Typography */
        h1, h2, h3, h4 {
            font-family: 'Cinzel', serif;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        
        h1 {
            font-size: clamp(2.8rem, 5vw, 4.5rem);
            line-height: 1.15;
            letter-spacing: 0.12em;
        }
        
        h2 {
            font-size: clamp(2rem, 3.5vw, 3rem);
            line-height: 1.2;
        }
        
        h3 {
            font-size: clamp(1.4rem, 2.5vw, 1.8rem);
        }
        
        h4 {
            font-size: 1.1rem;
            letter-spacing: 0.1em;
        }
        
        .text-gold { color: var(--gold); }
        .text-silver { color: var(--silver); }
        .text-bronze { color: var(--bronze); }
        
        /* Prestige Label */
        .prestige-label {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--gold-dim);
            margin-bottom: 24px;
        }
        
        .prestige-label::before {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold));
        }
        
        .prestige-label::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(to left, transparent, var(--gold));
        }
        
        .prestige-label-solo::before {
            width: 60px;
        }
        
        .prestige-label-solo::after {
            display: none;
        }
        
        /* Flowing Gradient Background */
        .flow-gradient {
            position: relative;
            overflow: hidden;
        }
        
        .flow-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(ellipse at 20% 30%, rgba(201, 169, 97, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 70%, rgba(201, 169, 97, 0.05) 0%, transparent 40%),
                radial-gradient(ellipse at 50% 50%, rgba(139, 115, 85, 0.03) 0%, transparent 60%);
            animation: flow 20s ease-in-out infinite;
            pointer-events: none;
        }

