-<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE — Business Archaeology & Authority Systems</title>
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

/* Navigation */
.nav{
  position:fixed;
  top:0;left:0;right:0;
  z-index:100;
  padding:1.25rem 2.5rem;
  display:flex;
  align-items:center;
  justify-content:space-between;
  background:linear-gradient(180deg, rgba(5,5,5,0.8) 0%, rgba(5,5,5,0) 100%);
  backdrop-filter:blur(12px);
  -webkit-backdrop-filter:blur(12px);
  border-bottom:1px solid var(--glass-border);
}

.nav-brand{
  display:flex;
  align-items:center;
  gap:0.75rem;
  font-family:'Cinzel',serif;
  font-size:0.9rem;
  font-weight:600;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--cream);
}

.orb{
  width:32px;height:32px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--gold) 0%, var(--gold-dim) 50%, var(--violet-soft) 100%);
  box-shadow:0 0 20px rgba(201,162,39,0.3), inset 0 0 10px rgba(255,255,255,0.2);
  animation:orbFloat 6s ease-in-out infinite;
  position:relative;
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

.nav-links{
  display:flex;
  gap:2.5rem;
  list-style:none;
}

.nav-links a{
  color:var(--cream-dim);
  text-decoration:none;
  font-size:0.8rem;
  font-weight:500;
  letter-spacing:0.1em;
  text-transform:uppercase;
  transition:color 0.3s;
  position:relative;
}

.nav-links a::after{
  content:'';
  position:absolute;
  bottom:-4px;left:0;
  width:0;height:1px;
  background:var(--gold);
  transition:width 0.3s;
}

.nav-links a:hover{color:var(--gold);}
.nav-links a:hover::after{width:100%;}

/* Layout */
section{position:relative;z-index:2;padding:6rem 2rem;}
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
  position:relative;
  padding-top:6rem;
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

/* Process / Gem Stages */
.process-section{
  position:relative;
  overflow:hidden;
}

.process-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:4rem;
  align-items:center;
  margin:4rem 0;
}

.process-grid.reverse{direction:rtl;}
.process-grid.reverse > *{direction:ltr;}

.process-image{
  position:relative;
  border-radius:8px;
  overflow:hidden;
  aspect-ratio:4/3;
  background:linear-gradient(135deg, rgba(124,58,237,0.1), rgba(201,162,39,0.05));
}

.process-image img{
  width:100%;
  height:100%;
  object-fit:cover;
  opacity:0.85;
  transition:opacity 0.4s, transform 0.6s;
}

.process-image:hover img{
  opacity:1;
  transform:scale(1.03);
}

.process-image .img-label{
  position:absolute;
  bottom:1.5rem;left:1.5rem;
  font-family:'Cinzel',serif;
  font-size:0.7rem;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--gold);
  background:rgba(0,0,0,0.6);
  padding:0.5rem 1rem;
  border-radius:4px;
  backdrop-filter:blur(10px);
}

.process-content h3{
  font-size:2rem;
  margin-bottom:1rem;
  color:var(--cream);
}

.process-content p{
  color:var(--cream-dim);
  margin-bottom:1.5rem;
  line-height:1.7;
}

.process-list{
  list-style:none;
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

/* Gem Stage Cards */
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
  position:relative;
  z-index:2;
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

/* Mobile */
@media(max-width:768px){
  .nav-links{display:none;}
  .process-grid,
  .gem-stage{grid-template-columns:1fr;gap:2rem;}
  .process-grid.reverse,
  .gem-stage.reverse{direction:ltr;}
  .hero-tags{flex-direction:column;align-items:center;}
  section{padding:4rem 1.5rem;}
}

/* Scrollbar */
::-webkit-scrollbar{width:8px;}
::-webkit-scrollbar-track{background:var(--black);}
::-webkit-scrollbar-thumb{background:var(--gold-dim);border-radius:4px;}
::-webkit-scrollbar-thumb:hover{background:var(--gold);}
</style>
</head>
<body>

<!-- Navigation -->
<nav class="nav">
  <div class="nav-brand">
    <div class="orb"></div>
    <span>LEGAiSEE</span>
  </div>
  <ul class="nav-links">
    <li><a href="#excavation">Excavation</a></li>
    <li><a href="#alchemy">Alchemy</a></li>
    <li><a href="#prestige">Prestige</a></li>
    <li><a href="#authority">Authority</a></li>
  </ul>
</nav>

<!-- Hero -->
<section class="hero">
  <div class="hero-content reveal">
    <span class="eyebrow">Business Archaeology & Authority Systems</span>
    <h1>Excavate your buried <em>marketing gold</em></h1>
    <p>We dig through 40+ years of your business history to find the proven tactics you've abandoned—then transform them into modern authority systems.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="#audit" class="btn btn-primary">Request Audit</a>
      <a href="#process" class="btn btn-outline">View Process</a>
    </div>
    <div class="hero-tags">
      <span class="hero-tag">Deep historical research</span>
      <span class="hero-tag">AI-powered modernization</span>
      <span class="hero-tag">Authority positioning</span>
    </div>
  </div>
</section>

<!-- Ticker -->
<div class="ticker-wrap">
  <div class="ticker" id="ticker">
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
    <!-- duplicate for seamless loop -->
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

<!-- Services -->
<section id="audit">
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

<!-- Stats -->
<section>
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

<!-- Process: Archaeology -->
<section id="excavation" class="process-section">
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">The Process</span>
      <h2>From Raw to Refined</h2>
      <div class="divider"></div>
    </div>
    
    <div class="gem-stage reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&auto=format&fit=crop&q=80" alt="Raw emerald in rock matrix">
        <div class="gem-badge">IMG-01 &mdash; 800 × 600 PX</div>
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

    <div class="gem-stage reverse reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=800&auto=format&fit=crop&q=80" alt="Cut and faceted emerald">
        <div class="gem-badge">IMG-02 &mdash; 600 × 600 PX</div>
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

    <div class="gem-stage reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800&auto=format&fit=crop&q=80" alt="Polished gemstone in setting">
        <div class="gem-badge">IMG-03 &mdash; 500 × 500 PX</div>
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

<!-- Camera Authority -->
<section id="authority" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.04), transparent);">
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Experience</span>
      <h2>Camera Authority</h2>
      <p>On-camera presence for the authority economy. From script to screen, we build your video confidence and production quality.</p>
      <div class="divider"></div>
    </div>
    <div class="services-grid">
      <div class="service-card reveal">
        <h3>On-Camera Training</h3>
        <p>Posture, framing, lighting, and delivery naturalization. From script anxiety to screen confidence.</p>
      </div>
      <div class="service-card reveal" style="transition-delay:0.1s;">
        <h3>Production Excellence</h3>
        <p>Audio, background, multi-camera setups. Technical mastery that matches your expertise.</p>
      </div>
      <div class="service-card reveal" style="transition-delay:0.2s;">
        <h3>Channel Optimization</h3>
        <p>Platform-specific skills for maximum reach. YouTube, LinkedIn, TikTok, and podcast.</p>
      </div>
    </div>
  </div>
</section>

<!-- Testimonial -->
<section>
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

<!-- CTA -->
<section id="process" style="text-align:center;">
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

// Smooth scroll for nav links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Parallax glow effect on mouse move
document.addEventListener('mousemove', (e) => {
  const x = (e.clientX / window.innerWidth - 0.5) * 20;
  const y = (e.clientY / window.innerHeight - 0.5) * 20;
  document.body.style.setProperty('--glow-x', x + 'px');
  document.body.style.setProperty('--glow-y', y + 'px');
});
</script>

</body>
</html>

