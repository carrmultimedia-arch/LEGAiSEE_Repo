<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE — Master Section Library</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
:root{
  --black:#050505;
  --black-pure:#000000;
  --violet:#4c1d95;
  --violet-soft:#7c3aed;
  --violet-glow:rgba(124,58,237,0.12);
  --gold:#c9a227;
  --gold-soft:#fbbf24;
  --gold-dim:#a16207;
  --cream:#f5f5f0;
  --cream-dim:#a3a3a3;
  --glass:rgba(255,255,255,0.03);
  --glass-border:rgba(255,255,255,0.06);
  --sidebar-width:280px;
}

*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{
  font-family:'Inter',sans-serif;
  background:var(--black);
  color:var(--cream);
  line-height:1.6;
  overflow-x:hidden;
}

/* Radial Gradient Center Glow */
body::before{
  content:'';
  position:fixed;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  width:140vw;
  height:140vh;
  background:
    radial-gradient(ellipse at center, rgba(76,29,149,0.18) 0%, rgba(0,0,0,0) 55%),
    radial-gradient(ellipse at center, rgba(201,162,39,0.06) 0%, rgba(0,0,0,0) 45%);
  pointer-events:none;
  z-index:0;
  animation:glowPulse 8s ease-in-out infinite alternate;
}

@keyframes glowPulse{
  0%{opacity:0.8;transform:translate(-50%,-50%) scale(1);}
  100%{opacity:1;transform:translate(-50%,-50%) scale(1.08);}
}

/* Noise texture overlay */
body::after{
  content:'';
  position:fixed;
  top:0;left:0;right:0;bottom:0;
  background:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
  pointer-events:none;
  z-index:1;
  opacity:0.4;
}

/* ===== SIDEBAR NAVIGATION ===== */
.sidebar{
  position:fixed;
  top:0;left:0;bottom:0;
  width:var(--sidebar-width);
  z-index:100;
  background:linear-gradient(180deg, rgba(5,5,5,0.85) 0%, rgba(5,5,5,0.95) 100%);
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
  border-right:1px solid var(--glass-border);
  display:flex;
  flex-direction:column;
  padding:2rem 0;
  overflow-y:auto;
  overflow-x:hidden;
}

.sidebar-header{
  padding:0 1.5rem 1.5rem;
  border-bottom:1px solid var(--glass-border);
  margin-bottom:1rem;
}

.sidebar-brand{
  display:flex;
  align-items:center;
  gap:0.75rem;
  font-family:'Cinzel',serif;
  font-size:0.85rem;
  font-weight:600;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--cream);
  margin-bottom:0.5rem;
}

.orb{
  width:28px;height:28px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 50%, var(--violet-soft) 100%);
  box-shadow:0 0 20px rgba(201,162,39,0.3), inset 0 0 10px rgba(255,255,255,0.2);
  animation:orbFloat 6s ease-in-out infinite;
  position:relative;
  flex-shrink:0;
}

.orb::after{
  content:'';
  position:absolute;
  inset:2px;
  border-radius:50%;
  background:linear-gradient(135deg, rgba(255,255,255,0.4) 0%, transparent 50%);
}

@keyframes orbFloat{
  0%,100%{transform:translateY(0);}
  50%{transform:translateY(-4px);}
}

.sidebar-sub{
  font-size:0.7rem;
  color:var(--cream-dim);
  letter-spacing:0.1em;
  text-transform:uppercase;
  padding-left:2.5rem;
}

.sidebar-nav{
  flex:1;
  overflow-y:auto;
  padding:0 0.75rem;
}

.sidebar-group{
  margin-bottom:1.25rem;
}

.sidebar-group-title{
  font-family:'Inter',sans-serif;
  font-size:0.65rem;
  font-weight:600;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--gold);
  padding:0.5rem 0.75rem;
  opacity:0.8;
}

.sidebar-link{
  display:block;
  padding:0.45rem 0.75rem;
  font-size:0.8rem;
  color:var(--cream-dim);
  text-decoration:none;
  border-radius:6px;
  transition:all 0.2s;
  border-left:2px solid transparent;
  margin-bottom:1px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.sidebar-link:hover{
  background:rgba(255,255,255,0.04);
  color:var(--cream);
  border-left-color:var(--gold-dim);
}

.sidebar-link.active{
  background:rgba(201,162,39,0.08);
  color:var(--gold);
  border-left-color:var(--gold);
  font-weight:500;
}

.sidebar-footer{
  padding:1rem 1.5rem 0;
  border-top:1px solid var(--glass-border);
  margin-top:auto;
}

.sidebar-footer p{
  font-size:0.7rem;
  color:var(--cream-dim);
  line-height:1.5;
}

/* Mobile sidebar toggle */
.sidebar-toggle{
  display:none;
  position:fixed;
  top:1rem;left:1rem;
  z-index:101;
  width:40px;height:40px;
  border-radius:8px;
  background:rgba(5,5,5,0.9);
  border:1px solid var(--glass-border);
  color:var(--cream);
  cursor:pointer;
  align-items:center;
  justify-content:center;
  font-size:1.2rem;
  backdrop-filter:blur(10px);
}

/* Main content offset */
.main-content{
  margin-left:var(--sidebar-width);
  position:relative;
  z-index:2;
}

/* ===== SECTIONS ===== */
section{position:relative;padding:6rem 2rem;}
.container{max-width:1200px;margin:0 auto;}

/* Typography */
h1,h2,h3{font-family:'Playfair Display',serif;font-weight:400;line-height:1.1;}
.eyebrow{
  font-family:'Inter',sans-serif;
  font-size:0.75rem;
  font-weight:600;
  letter-spacing:0.25em;
  text-transform:uppercase;
  color:var(--gold);
  margin-bottom:1.25rem;
  display:block;
}

/* Hero */
.hero{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  text-align:center;
  padding-top:4rem;
}

.hero-content{max-width:800px;}

.hero h1{
  font-size:clamp(2.5rem,6vw,4.5rem);
  margin-bottom:1.5rem;
  background:linear-gradient(180deg, var(--cream) 0%, var(--cream-dim) 100%);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-clip:text;
}

.hero h1 em{
  font-style:italic;
  color:var(--gold);
  -webkit-text-fill-color:var(--gold);
}

.hero p{
  font-size:1.15rem;
  color:var(--cream-dim);
  max-width:600px;
  margin:0 auto 2.5rem;
  line-height:1.7;
}

.hero-tags{
  display:flex;
  gap:1.5rem;
  justify-content:center;
  flex-wrap:wrap;
  margin-top:2rem;
}

.hero-tag{
  font-size:0.75rem;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--cream-dim);
  padding:0.5rem 1.25rem;
  border:1px solid var(--glass-border);
  background:var(--glass);
  border-radius:100px;
  backdrop-filter:blur(10px);
}

/* Buttons */
.btn{
  display:inline-flex;
  align-items:center;
  gap:0.5rem;
  padding:1rem 2.5rem;
  font-family:'Inter',sans-serif;
  font-size:0.8rem;
  font-weight:600;
  letter-spacing:0.15em;
  text-transform:uppercase;
  text-decoration:none;
  border-radius:4px;
  transition:all 0.3s;
  cursor:pointer;
  border:none;
}

.btn-primary{
  background:linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 100%);
  color:var(--black);
  box-shadow:0 4px 20px rgba(201,162,39,0.2);
}

.btn-primary:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 30px rgba(201,162,39,0.3);
}

.btn-outline{
  background:transparent;
  color:var(--cream);
  border:1px solid var(--glass-border);
}

.btn-outline:hover{
  border-color:var(--gold);
  color:var(--gold);
}

/* Services Grid */
.services-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
  gap:2rem;
  margin-top:3rem;
}

.service-card{
  background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
  border:1px solid var(--glass-border);
  border-radius:12px;
  padding:2.5rem;
  position:relative;
  overflow:hidden;
  transition:all 0.4s;
}

.service-card::before{
  content:'';
  position:absolute;
  top:0;left:0;right:0;
  height:1px;
  background:linear-gradient(90deg, transparent, var(--gold), transparent);
  opacity:0;
  transition:opacity 0.4s;
}

.service-card:hover{
  transform:translateY(-4px);
  border-color:rgba(201,162,39,0.2);
  box-shadow:0 20px 40px rgba(0,0,0,0.4);
}

.service-card:hover::before{opacity:1;}

.service-card h3{
  font-size:1.4rem;
  margin-bottom:0.75rem;
  color:var(--cream);
}

.service-card p{
  color:var(--cream-dim);
  font-size:0.95rem;
  margin-bottom:1.5rem;
}

.service-meta{
  list-style:none;
  margin-bottom:1.5rem;
}

.service-meta li{
  padding:0.35rem 0;
  font-size:0.85rem;
  color:var(--cream-dim);
  display:flex;
  align-items:center;
  gap:0.5rem;
}

.service-meta li::before{
  content:'—';
  color:var(--gold);
  font-weight:600;
}

.service-link{
  color:var(--gold);
  text-decoration:none;
  font-size:0.8rem;
  font-weight:600;
  letter-spacing:0.1em;
  text-transform:uppercase;
  display:inline-flex;
  align-items:center;
  gap:0.5rem;
  transition:gap 0.3s;
}

.service-link:hover{gap:0.75rem;}

/* Gem Stages */
.gem-stage{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:3rem;
  align-items:center;
  margin:3rem 0;
}

.gem-stage.reverse{direction:rtl;}
.gem-stage.reverse > *{direction:ltr;}

.gem-visual{
  position:relative;
  border-radius:12px;
  overflow:hidden;
  background:linear-gradient(135deg, rgba(124,58,237,0.08), rgba(201,162,39,0.04));
  border:1px solid var(--glass-border);
}

.gem-visual img{
  width:100%;
  height:auto;
  display:block;
  opacity:0.9;
  transition:opacity 0.4s, transform 0.6s;
}

.gem-visual:hover img{
  opacity:1;
  transform:scale(1.03);
}

.gem-badge{
  position:absolute;
  top:1rem;left:1rem;
  background:rgba(0,0,0,0.7);
  backdrop-filter:blur(10px);
  padding:0.5rem 1rem;
  border-radius:4px;
  font-size:0.7rem;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--gold);
  border:1px solid var(--glass-border);
}

.gem-info h3{
  font-size:1.8rem;
  margin-bottom:0.75rem;
}

.gem-info .stage-label{
  font-family:'Cinzel',serif;
  font-size:0.75rem;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--gold);
  margin-bottom:1rem;
  display:block;
}

.process-list{
  list-style:none;
  margin-top:1rem;
}

.process-list li{
  padding:0.6rem 0;
  padding-left:1.5rem;
  position:relative;
  color:var(--cream-dim);
  font-size:0.95rem;
}

.process-list li::before{
  content:'';
  position:absolute;
  left:0;top:50%;
  transform:translateY(-50%);
  width:6px;height:6px;
  border-radius:50%;
  background:var(--gold);
  box-shadow:0 0 8px rgba(201,162,39,0.4);
}

/* Stats */
.stats-row{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:2rem;
  margin:4rem 0;
  text-align:center;
}

.stat-item h4{
  font-family:'Playfair Display',serif;
  font-size:3rem;
  font-weight:400;
  color:var(--gold);
  line-height:1;
  margin-bottom:0.5rem;
}

.stat-item p{
  font-size:0.85rem;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--cream-dim);
}

/* Testimonial */
.testimonial{
  max-width:800px;
  margin:0 auto;
  text-align:center;
  padding:4rem 2rem;
  position:relative;
}

.testimonial::before{
  content:'"';
  font-family:'Playfair Display',serif;
  font-size:8rem;
  color:var(--gold);
  opacity:0.15;
  position:absolute;
  top:-1rem;left:50%;
  transform:translateX(-50%);
  line-height:1;
}

.testimonial blockquote{
  font-family:'Playfair Display',serif;
  font-size:1.4rem;
  line-height:1.7;
  color:var(--cream);
  font-style:italic;
  margin-bottom:2rem;
}

.testimonial cite{
  font-style:normal;
  font-family:'Inter',sans-serif;
  font-size:0.9rem;
  color:var(--cream-dim);
}

.testimonial cite strong{
  display:block;
  color:var(--cream);
  font-weight:600;
  margin-bottom:0.25rem;
}

/* Ticker */
.ticker-wrap{
  width:100%;
  overflow:hidden;
  background:linear-gradient(90deg, transparent, rgba(201,162,39,0.05), transparent);
  border-top:1px solid var(--glass-border);
  border-bottom:1px solid var(--glass-border);
  padding:1.25rem 0;
  position:relative;
}

.ticker{
  display:flex;
  width:max-content;
  animation:tickerScroll 30s linear infinite;
}

.ticker-item{
  font-family:'Cinzel',serif;
  font-size:0.8rem;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--cream-dim);
  padding:0 3rem;
  white-space:nowrap;
  position:relative;
}

.ticker-item::after{
  content:'◆';
  position:absolute;
  right:0;top:50%;
  transform:translateY(-50%);
  color:var(--gold);
  opacity:0.4;
  font-size:0.5rem;
}

@keyframes tickerScroll{
  0%{transform:translateX(0);}
  100%{transform:translateX(-50%);}
}

/* Section Headers */
.section-header{
  text-align:center;
  max-width:600px;
  margin:0 auto 3rem;
}

.section-header h2{
  font-size:clamp(2rem,4vw,3rem);
  margin-bottom:1rem;
  color:var(--cream);
}

.section-header p{
  color:var(--cream-dim);
  font-size:1.05rem;
}

/* Divider */
.divider{
  width:60px;
  height:1px;
  background:linear-gradient(90deg, transparent, var(--gold), transparent);
  margin:2rem auto;
  opacity:0.6;
}

/* Footer */
.footer{
  border-top:1px solid var(--glass-border);
  padding:3rem 2rem;
  text-align:center;
}

.footer p{
  font-size:0.8rem;
  color:var(--cream-dim);
  letter-spacing:0.1em;
}

/* Scroll Reveal */
.reveal{
  opacity:0;
  transform:translateY(30px);
  transition:opacity 0.8s ease, transform 0.8s ease;
}

.reveal.active{
  opacity:1;
  transform:translateY(0);
}

/* Section label (for library view) */
.section-label{
  position:absolute;
  top:1.5rem;right:2rem;
  font-family:'Inter',sans-serif;
  font-size:0.65rem;
  font-weight:600;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--cream-dim);
  opacity:0.5;
  border:1px solid var(--glass-border);
  padding:0.35rem 0.75rem;
  border-radius:4px;
  background:var(--glass);
  backdrop-filter:blur(10px);
  z-index:10;
}

/* ===== MOBILE ===== */
@media(max-width:1024px){
  .sidebar{
    transform:translateX(-100%);
    transition:transform 0.3s;
    box-shadow:4px 0 30px rgba(0,0,0,0.5);
  }
  .sidebar.open{transform:translateX(0);}
  .sidebar-toggle{display:flex;}
  .main-content{margin-left:0;}
  .gem-stage,
  .gem-stage.reverse{grid-template-columns:1fr;direction:ltr;}
  .gem-stage.reverse > *{direction:ltr;}
}

@media(max-width:768px){
  .hero-tags{flex-direction:column;align-items:center;}
  section{padding:4rem 1.5rem;}
  .section-label{top:1rem;right:1rem;}
}

/* Scrollbar */
::-webkit-scrollbar{width:6px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:var(--gold-dim);border-radius:4px;}
::-webkit-scrollbar-thumb:hover{background:var(--gold);}

.sidebar-nav::-webkit-scrollbar{width:4px;}
.sidebar-nav::-webkit-scrollbar-thumb{background:rgba(201,162,39,0.3);}
</style>
</head>
<body>

<!-- Mobile Toggle -->
<button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle navigation">☰</button>

<!-- Sidebar Navigation -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="sidebar-brand">
      <div class="orb"></div>
      <span>LEGAiSEE</span>
    </div>
    <div class="sidebar-sub">Master Section Library</div>
  </div>
  
  <nav class="sidebar-nav">
    <div class="sidebar-group">
      <div class="sidebar-group-title">Navigation</div>
      <a href="#nav-02" class="sidebar-link" data-section="nav-02">NAV-02 — Frosted Glass + Orb</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Hero Sections</div>
      <a href="#hero-01" class="sidebar-link" data-section="hero-01">HERO-01 — Centered Simple</a>
      <a href="#hero-02" class="sidebar-link" data-section="hero-02">HERO-02 — 2-Col + Stat Card</a>
      <a href="#hero-03" class="sidebar-link" data-section="hero-03">HERO-03 — Asymmetric + Museum</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Tickers</div>
      <a href="#ticker" class="sidebar-link" data-section="ticker">TICKER — Archive Scroll</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Services</div>
      <a href="#svc-01" class="sidebar-link" data-section="svc-01">SVC-01 — 3-Col Floating Cards</a>
      <a href="#svc-02" class="sidebar-link" data-section="svc-02">SVC-02 — Service Detail + List</a>
      <a href="#svc-03" class="sidebar-link" data-section="svc-03">SVC-03 — Feature Stack + Sticky</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Process</div>
      <a href="#proc-01" class="sidebar-link" data-section="proc-01">PROC-01 — Gem Stage Left</a>
      <a href="#proc-02" class="sidebar-link" data-section="proc-02">PROC-02 — Gem Stage Right</a>
      <a href="#proc-03" class="sidebar-link" data-section="proc-03">PROC-03 — Gem Stage Final</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Stats</div>
      <a href="#stat-01" class="sidebar-link" data-section="stat-01">STAT-01 — 4-Col Stats Row</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Testimonials</div>
      <a href="#test-01" class="sidebar-link" data-section="test-01">TEST-01 — Large Quote Block</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Call to Action</div>
      <a href="#cta-01" class="sidebar-link" data-section="cta-01">CTA-01 — Invitation Close</a>
    </div>
  </nav>
  
  <div class="sidebar-footer">
    <p>32 chapters documented.<br>Section pool v1.0</p>
  </div>
</aside>

<!-- Main Content -->
<main class="main-content">

<!-- HERO-01 -->
<section id="hero-01" class="hero">
  <span class="section-label">HERO-01</span>
  <div class="hero-content reveal">
    <span class="eyebrow">Business Archaeology & Authority Systems</span>
    <h1>Excavate your buried <em>marketing gold</em></h1>
    <p>We dig through 40+ years of your business history to find the proven tactics you've abandoned—then transform them into modern authority systems.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="#svc-01" class="btn btn-primary">Request Audit</a>
      <a href="#proc-01" class="btn btn-outline">View Process</a>
    </div>
    <div class="hero-tags">
      <span class="hero-tag">Deep historical research</span>
      <span class="hero-tag">AI-powered modernization</span>
      <span class="hero-tag">Authority positioning</span>
    </div>
  </div>
</section>

<!-- TICKER -->
<div id="ticker" class="ticker-wrap">
  <span class="section-label" style="top:50%;transform:translateY(-50%);">TICKER</span>
  <div class="ticker">
    <span class="ticker-item">Web Archives</span>
    <span class="ticker-item">Social Media History</span>
    <span class="ticker-item">Radio Transcripts</span>
    <span class="ticker-item">Print Advertising</span>
    <span class="ticker-item">YouTube Commercials</span>
    <span class="ticker-item">Old Hard Drives</span>
    <span class="ticker-item">Email Campaigns</span>
    <span class="ticker-item">CRM Exports</span>
    <span class="ticker-item">Trade Show Records</span>
    <span class="ticker-item">Employee Interviews</span>
    <span class="ticker-item">News Archives</span>
    <span class="ticker-item">Competitive Intelligence</span>
    <span class="ticker-item">Web Archives</span>
    <span class="ticker-item">Social Media History</span>
    <span class="ticker-item">Radio Transcripts</span>
    <span class="ticker-item">Print Advertising</span>
    <span class="ticker-item">YouTube Commercials</span>
    <span class="ticker-item">Old Hard Drives</span>
    <span class="ticker-item">Email Campaigns</span>
    <span class="ticker-item">CRM Exports</span>
    <span class="ticker-item">Trade Show Records</span>
    <span class="ticker-item">Employee Interviews</span>
    <span class="ticker-item">News Archives</span>
    <span class="ticker-item">Competitive Intelligence</span>
  </div>
</div>

<!-- HERO-02: 2-Col + Stats -->
<section id="hero-02">
  <span class="section-label">HERO-02</span>
  <div class="container">
    <div class="gem-stage reveal">
      <div class="gem-info">
        <span class="eyebrow">Est. 2024</span>
        <h2 style="font-size:clamp(2rem,4vw,3.2rem);margin-bottom:1rem;">Excavate Your <em style="color:var(--gold);font-style:italic;">Buried Gold</em></h2>
        <p style="color:var(--cream-dim);margin-bottom:2rem;">We conduct deep archaeological research across 40+ channels of your business history to recover proven marketing tactics you've abandoned.</p>
        <div style="display:flex;flex-direction:column;gap:1rem;">
          <div style="display:flex;align-items:center;gap:1rem;">
            <span style="width:40px;height:40px;border-radius:50%;background:rgba(201,162,39,0.1);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:0.8rem;">01</span>
            <div>
              <strong style="color:var(--cream);display:block;">Deep historical research</strong>
              <span style="font-size:0.85rem;color:var(--cream-dim);">40+ channels excavated</span>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:1rem;">
            <span style="width:40px;height:40px;border-radius:50%;background:rgba(201,162,39,0.1);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:0.8rem;">02</span>
            <div>
              <strong style="color:var(--cream);display:block;">AI-powered modernization</strong>
              <span style="font-size:0.85rem;color:var(--cream-dim);">Voice extraction & channel translation</span>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:1rem;">
            <span style="width:40px;height:40px;border-radius:50%;background:rgba(201,162,39,0.1);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:0.8rem;">03</span>
            <div>
              <strong style="color:var(--cream);display:block;">Authority positioning</strong>
              <span style="font-size:0.85rem;color:var(--cream-dim);">Platform dominance & social proof</span>
            </div>
          </div>
        </div>
      </div>
      <div style="background:linear-gradient(135deg, rgba(124,58,237,0.08), rgba(201,162,39,0.04));border:1px solid var(--glass-border);border-radius:12px;padding:2.5rem;">
        <span class="eyebrow" style="display:block;text-align:center;margin-bottom:1.5rem;">The Transformation</span>
        <div style="text-align:center;font-family:'Cinzel',serif;font-size:1.1rem;color:var(--cream);margin-bottom:2rem;">
          Raw <span style="color:var(--gold);">→</span> Cut <span style="color:var(--gold);">→</span> Polished <span style="color:var(--gold);">→</span> Displayed
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
          <div style="text-align:center;padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);">
            <strong style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);display:block;">40+</strong>
            <span style="font-size:0.75rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Channels</span>
          </div>
          <div style="text-align:center;padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);">
            <strong style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);display:block;">15-25</strong>
            <span style="font-size:0.75rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Assets</span>
          </div>
          <div style="text-align:center;padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);">
            <strong style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);display:block;">3</strong>
            <span style="font-size:0.75rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Stages</span>
          </div>
          <div style="text-align:center;padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);">
            <strong style="font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--gold);display:block;">1</strong>
            <span style="font-size:0.75rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">System</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HERO-03: Asymmetric -->
<section id="hero-03">
  <span class="section-label">HERO-03</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Current Availability</span>
      <h2>Limited to 3 Clients</h2>
      <p>This constraint ensures museum-quality research and bespoke system architecture for every engagement.</p>
      <div class="divider"></div>
    </div>
    <div class="stats-row reveal">
      <div class="stat-item">
        <h4>Q3</h4>
        <p>Next Opening</p>
      </div>
      <div class="stat-item">
        <h4>6</h4>
        <p>Week Waitlist</p>
      </div>
      <div class="stat-item">
        <h4>14</h4>
        <p>Avg. Months</p>
      </div>
    </div>
  </div>
</section>

<!-- SVC-01 -->
<section id="svc-01">
  <span class="section-label">SVC-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Services</span>
      <h2>Signature Services</h2>
      <div class="divider"></div>
    </div>
    <div class="services-grid">
      <div class="service-card reveal">
        <h3>Business Archaeology Audit</h3>
        <p>Deep excavation across 40+ channels to find your abandoned marketing gold. Public records, private archives, and human intelligence.</p>
        <ul class="service-meta">
          <li>40+ channel analysis</li>
          <li>Historical asset recovery</li>
          <li>Competitive gap mapping</li>
          <li>10-page strategic report</li>
        </ul>
        <a href="#" class="service-link">Explore Audit →</a>
      </div>
      <div class="service-card reveal" style="transition-delay:0.1s;">
        <h3>Authority Systems Build</h3>
        <p>Transform historical assets into modern content engines and publishing rhythms. Four integrated systems that compound over time.</p>
        <ul class="service-meta">
          <li>Content production engine</li>
          <li>Publishing rhythm design</li>
          <li>Performance feedback loops</li>
          <li>Asset library architecture</li>
        </ul>
        <a href="#" class="service-link">Explore Systems →</a>
      </div>
      <div class="service-card reveal" style="transition-delay:0.2s;">
        <h3>Camera Authority Training</h3>
        <p>On-camera presence for the authority economy. From script to screen, we build your video confidence and production quality.</p>
        <ul class="service-meta">
          <li>On-camera foundations</li>
          <li>Delivery naturalization</li>
          <li>Technical excellence</li>
          <li>Platform optimization</li>
        </ul>
        <a href="#" class="service-link">Explore Training →</a>
      </div>
    </div>
  </div>
</section>

<!-- SVC-02: Service Detail -->
<section id="svc-02" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.03), transparent);">
  <span class="section-label">SVC-02</span>
  <div class="container">
    <div class="gem-stage reveal">
      <div class="gem-info">
        <span class="eyebrow">Stage 01 — 5-7 Days</span>
        <h2>Business History Audit</h2>
        <p style="color:var(--cream-dim);margin-bottom:1.5rem;">Forensic excavation of your marketing history across 40+ channels. We reconstruct what made you successful, when you stopped, and what it would take to restore that advantage.</p>
        <ul class="process-list">
          <li>Multi-source research (public archives, private collections, human interviews)</li>
          <li>15-25 documented assets with provenance and dating</li>
          <li>Competitive gap analysis (who took your space, how)</li>
          <li>10-page report + video walkthrough + asset portfolio</li>
        </ul>
        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--glass-border);">
          <span style="font-family:'Playfair Display',serif;font-size:2rem;color:var(--gold);display:block;">$2,000</span>
          <span style="font-size:0.8rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Foundation Tier — Single Payment or 50/50 Split</span>
        </div>
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <div style="background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);border:1px solid var(--glass-border);border-radius:12px;padding:1.5rem;display:flex;align-items:flex-start;gap:1rem;">
          <span style="font-family:'Cinzel',serif;font-size:1.2rem;color:var(--gold);font-weight:600;">01</span>
          <div>
            <strong style="color:var(--cream);display:block;margin-bottom:0.25rem;">Multi-Source Excavation</strong>
            <span style="font-size:0.85rem;color:var(--cream-dim);">Public archaeology combined with private artifact recovery.</span>
          </div>
        </div>
        <div style="background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);border:1px solid var(--glass-border);border-radius:12px;padding:1.5rem;display:flex;align-items:flex-start;gap:1rem;">
          <span style="font-family:'Cinzel',serif;font-size:1.2rem;color:var(--gold);font-weight:600;">02</span>
          <div>
            <strong style="color:var(--cream);display:block;margin-bottom:0.25rem;">Triangulation & Verification</strong>
            <span style="font-size:0.85rem;color:var(--cream-dim);">Cross-reference findings across sources. Resolve conflicts.</span>
          </div>
        </div>
        <div style="background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);border:1px solid var(--glass-border);border-radius:12px;padding:1.5rem;display:flex;align-items:flex-start;gap:1rem;">
          <span style="font-family:'Cinzel',serif;font-size:1.2rem;color:var(--gold);font-weight:600;">03</span>
          <div>
            <strong style="color:var(--cream);display:block;margin-bottom:0.25rem;">Synthesis & Analysis</strong>
            <span style="font-size:0.85rem;color:var(--cream-dim);">Identify golden era, map abandonment timeline, diagnose gap.</span>
          </div>
        </div>
        <div style="background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);border:1px solid var(--glass-border);border-radius:12px;padding:1.5rem;display:flex;align-items:flex-start;gap:1rem;">
          <span style="font-family:'Cinzel',serif;font-size:1.2rem;color:var(--gold);font-weight:600;">04</span>
          <div>
            <strong style="color:var(--cream);display:block;margin-bottom:0.25rem;">Documentation & Delivery</strong>
            <span style="font-size:0.85rem;color:var(--cream-dim);">Report, digital asset museum, timeline visualization.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SVC-03: Service Ladder -->
<section id="svc-03">
  <span class="section-label">SVC-03</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Services</span>
      <h2>The Service Ladder</h2>
      <div class="divider"></div>
    </div>
    <div style="display:flex;flex-direction:column;gap:1.5rem;max-width:800px;margin:0 auto;">
      <div class="service-card reveal" style="display:grid;grid-template-columns:auto 1fr auto;gap:2rem;align-items:center;">
        <span style="font-family:'Cinzel',serif;font-size:1.5rem;color:var(--gold);">I</span>
        <div>
          <h3 style="margin-bottom:0.25rem;">Business History Audit</h3>
          <p style="font-size:0.9rem;margin:0;">5-7 day deep excavation. 40+ channels analyzed. 15-25 assets recovered.</p>
        </div>
        <div style="text-align:right;">
          <span style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">$2,000</span>
          <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">one-time</span>
        </div>
      </div>
      <div class="service-card reveal" style="display:grid;grid-template-columns:auto 1fr auto;gap:2rem;align-items:center;transition-delay:0.1s;">
        <span style="font-family:'Cinzel',serif;font-size:1.5rem;color:var(--gold);">II</span>
        <div>
          <h3 style="margin-bottom:0.25rem;">Authority Systems Build</h3>
          <p style="font-size:0.9rem;margin:0;">21-day implementation. Four integrated content systems. AI workflow library.</p>
        </div>
        <div style="text-align:right;">
          <span style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">$5,500</span>
          <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">one-time</span>
        </div>
      </div>
      <div class="service-card reveal" style="display:grid;grid-template-columns:auto 1fr auto;gap:2rem;align-items:center;transition-delay:0.2s;">
        <span style="font-family:'Cinzel',serif;font-size:1.5rem;color:var(--gold);">III</span>
        <div>
          <h3 style="margin-bottom:0.25rem;">Amplification Partnership</h3>
          <p style="font-size:0.9rem;margin:0;">8 hours monthly. Weekly content review. Monthly strategy call.</p>
        </div>
        <div style="text-align:right;">
          <span style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">$2,750</span>
          <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">per month</span>
        </div>
      </div>
      <div class="service-card reveal" style="display:grid;grid-template-columns:auto 1fr auto;gap:2rem;align-items:center;transition-delay:0.3s;">
        <span style="font-family:'Cinzel',serif;font-size:1.5rem;color:var(--gold);">IV</span>
        <div>
          <h3 style="margin-bottom:0.25rem;">Camera Authority Training</h3>
          <p style="font-size:0.9rem;margin:0;">16-hour intensive. On-camera foundations. Delivery naturalization.</p>
        </div>
        <div style="text-align:right;">
          <span style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">$3,750</span>
          <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">one-time</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROC-01: Gem Stage Left -->
<section id="proc-01">
  <span class="section-label">PROC-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">The Process</span>
      <h2>From Raw to Refined</h2>
      <div class="divider"></div>
    </div>
    <div class="gem-stage reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&auto=format&fit=crop&q=80" alt="Raw emerald in rock matrix">
        <div class="gem-badge">IMG-01 — 800 × 600 PX</div>
      </div>
      <div class="gem-info">
        <span class="stage-label">Stage 1: Raw</span>
        <h3>Archaeology</h3>
        <p>Excavating buried assets from your business history. We dig deeper than any agency—public records, private archives, employee interviews, and competitor intelligence to reconstruct what actually worked.</p>
        <ul class="process-list">
          <li>Public Excavation — Web archives, social media, YouTube, print ads</li>
          <li>Private Archives — Hard drives, email archives, CRM exports</li>
          <li>Human Intel — Founder, employee, and customer interviews</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- PROC-02: Gem Stage Right -->
<section id="proc-02" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.03), transparent);">
  <span class="section-label">PROC-02</span>
  <div class="container">
    <div class="gem-stage reverse reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&auto=format&fit=crop&q=80" alt="Cut and faceted emerald">
        <div class="gem-badge">IMG-02 — 600 × 600 PX</div>
      </div>
      <div class="gem-info">
        <span class="stage-label">Stage 2: Cut</span>
        <h3>Alchemy</h3>
        <p>Transforming raw assets into modern authority systems. Raw historical assets are worthless without modern transformation. We cut and polish proven tactics for today's platforms.</p>
        <ul class="process-list">
          <li>Channel Translation — Print ads become Instagram carousels</li>
          <li>Authority Replication — Extract your unique communication DNA</li>
          <li>Content Engines — Four integrated systems that compound</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- PROC-03: Gem Stage Final -->
<section id="proc-03">
  <span class="section-label">PROC-03</span>
  <div class="container">
    <div class="gem-stage reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800&auto=format&fit=crop&q=80" alt="Polished gemstone in setting">
        <div class="gem-badge">IMG-03 — 500 × 500 PX</div>
      </div>
      <div class="gem-info">
        <span class="stage-label">Stage 3: Polished</span>
        <h3>Prestige</h3>
        <p>Your authority, displayed for the world to see. Polished authority deserves museum-quality presentation. Your expertise, displayed on the channels that matter most.</p>
        <ul class="process-list">
          <li>Platform Authority — LinkedIn, YouTube, podcast, and press</li>
          <li>Social Proof — Case studies and testimonials that convert</li>
          <li>Authority Funnels — Every touchpoint engineered to convert</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- STAT-01 -->
<section id="stat-01" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.04), transparent);">
  <span class="section-label">STAT-01</span>
  <div class="container">
    <div class="stats-row reveal">
      <div class="stat-item">
        <h4>40+</h4>
        <p>Channels Excavated</p>
      </div>
      <div class="stat-item">
        <h4>15–25</h4>
        <p>Assets Recovered</p>
      </div>
      <div class="stat-item">
        <h4>3</h4>
        <p>Client Maximum</p>
      </div>
      <div class="stat-item">
        <h4>6</h4>
        <p>Week Waitlist</p>
      </div>
    </div>
  </div>
</section>

<!-- TEST-01 -->
<section id="test-01">
  <span class="section-label">TEST-01</span>
  <div class="container">
    <div class="testimonial reveal">
      <blockquote>
        "I had no idea we used to run such sophisticated campaigns. The Business Archaeology Audit uncovered $6M in lost opportunity from tactics we abandoned in 2012. Within 90 days of implementing the modernized version, we saw a 40% increase in qualified leads."
      </blockquote>
      <cite>
        <strong>Sarah Richardson</strong>
        CEO, Richardson Manufacturing &bull; Third Generation
      </cite>
    </div>
  </div>
</section>

<!-- CTA-01 -->
<section id="cta-01" style="text-align:center;">
  <span class="section-label">CTA-01</span>
  <div class="container reveal">
    <span class="eyebrow">By Invitation Only</span>
    <h2 style="font-size:clamp(1.8rem,4vw,2.8rem);margin-bottom:1rem;">Limited to 3 new clients per quarter</h2>
    <p style="color:var(--cream-dim);max-width:500px;margin:0 auto 2rem;">Current wait: 6 weeks. The rarest intelligence is not what competitors are doing now—it is what you yourself once did perfectly, then forgot.</p>
    <a href="#" class="btn btn-primary">Begin Excavation</a>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <p>LEGAiSEE &mdash; Business Archaeology & Authority Systems</p>
</footer>

</main>

<script>
// Scroll reveal observer
const observerOptions = {
  root: null,
  rootMargin: '0px',
  threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('active');
    }
  });
}, observerOptions);

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Scroll spy for sidebar
const sections = document.querySelectorAll('section[id], div[id]');
const navLinks = document.querySelectorAll('.sidebar-link');

function updateActiveLink(){
  let current = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;
    if(window.scrollY >= (sectionTop - 200)){
      current = section.getAttribute('id');
    }
  });
  
  navLinks.forEach(link => {
    link.classList.remove('active');
    if(link.getAttribute('data-section') === current){
      link.classList.add('active');
    }
  });
}

window.addEventListener('scroll', updateActiveLink);
updateActiveLink();

// Mobile sidebar toggle
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
}

// Close sidebar when clicking a link (mobile)
document.querySelectorAll('.sidebar-link').forEach(link => {
  link.addEventListener('click', () => {
    if(window.innerWidth <= 1024){
      document.getElementById('sidebar').classList.remove('open');
    }
  });
});

// Parallax glow effect
document.addEventListener('mousemove', (e) => {
  const x = (e.clientX / window.innerWidth - 0.5) * 20;
  const y = (e.clientY / window.innerHeight - 0.5) * 20;
  document.body.style.setProperty('--glow-x', x + 'px');
  document.body.style.setProperty('--glow-y', y + 'px');
});
</script>

</body>
</html>

