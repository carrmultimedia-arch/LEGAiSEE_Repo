<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE — Master Section Library (Expanded)</title>
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

body::after{
  content:'';
  position:fixed;
  top:0;left:0;right:0;bottom:0;
  background:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
  pointer-events:none;
  z-index:1;
  opacity:0.4;
}

/* ===== SIDEBAR ===== */
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

.sidebar-nav{flex:1;overflow-y:auto;padding:0 0.75rem;}
.sidebar-group{margin-bottom:1.25rem;}
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

.sidebar-toggle{
  display:none;
  position:fixed;
  top:1rem;left:1rem;
  z-index:101;
  width:40px;height:40px;
  border-radius:8px;
  background:rgba(5,5,9,0.9);
  border:1px solid var(--glass-border);
  color:var(--cream);
  cursor:pointer;
  align-items:center;
  justify-content:center;
  font-size:1.2rem;
  backdrop-filter:blur(10px);
}

.main-content{
  margin-left:var(--sidebar-width);
  position:relative;
  z-index:2;
}

/* ===== BASE STYLES ===== */
section{position:relative;padding:6rem 2rem;}
.container{max-width:1200px;margin:0 auto;}

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

.divider{
  width:60px;
  height:1px;
  background:linear-gradient(90deg, transparent, var(--gold), transparent);
  margin:2rem auto;
  opacity:0.6;
}

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

/* ===== HERO ===== */
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

/* ===== TICKER ===== */
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

/* ===== SERVICES ===== */
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

/* ===== GEM STAGES ===== */
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

/* ===== STATS ===== */
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

/* ===== TESTIMONIALS ===== */
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

/* ===== NEW SECTIONS FROM REVIEW ===== */

/* FAQ Accordion */
.faq-section{}
.faq-item{
  border-bottom:1px solid var(--glass-border);
  margin-bottom:1rem;
}

.faq-question{
  width:100%;
  background:none;
  border:none;
  color:var(--cream);
  font-family:'Inter',sans-serif;
  font-size:1.1rem;
  font-weight:500;
  text-align:left;
  padding:1.5rem 0;
  cursor:pointer;
  display:flex;
  justify-content:space-between;
  align-items:center;
  transition:color 0.3s;
}

.faq-question:hover{color:var(--gold);}

.faq-question::after{
  content:'+';
  font-size:1.5rem;
  color:var(--gold);
  transition:transform 0.3s;
}

.faq-item.active .faq-question::after{transform:rotate(45deg);}

.faq-answer{
  max-height:0;
  overflow:hidden;
  transition:max-height 0.4s ease, padding 0.4s ease;
  color:var(--cream-dim);
  line-height:1.7;
}

.faq-item.active .faq-answer{
  max-height:300px;
  padding-bottom:1.5rem;
}

/* Comparison Table */
.compare-table{
  width:100%;
  border-collapse:collapse;
  margin-top:2rem;
}

.compare-table th,
.compare-table td{
  padding:1.25rem 1.5rem;
  text-align:left;
  border-bottom:1px solid var(--glass-border);
}

.compare-table th{
  font-family:'Cinzel',serif;
  font-size:0.75rem;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--gold);
  font-weight:600;
}

.compare-table td{
  color:var(--cream-dim);
  font-size:0.95rem;
}

.compare-table td:first-child{
  color:var(--cream);
  font-weight:500;
}

.compare-table tr:hover td{
  background:rgba(255,255,255,0.02);
}

/* Team Grid */
.team-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:2rem;
  margin-top:3rem;
}

.team-card{
  background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
  border:1px solid var(--glass-border);
  border-radius:12px;
  padding:2.5rem;
  text-align:center;
  transition:all 0.4s;
}

.team-card:hover{
  transform:translateY(-4px);
  border-color:rgba(201,162,39,0.2);
}

.team-avatar{
  width:80px;
  height:80px;
  border-radius:50%;
  background:linear-gradient(135deg, var(--gold) 0%, var(--violet-soft) 100%);
  margin:0 auto 1.5rem;
  display:flex;
  align-items:center;
  justify-content:center;
  font-family:'Cinzel',serif;
  font-size:1.5rem;
  color:var(--black);
  font-weight:700;
}

.team-card h4{
  font-family:'Playfair Display',serif;
  font-size:1.3rem;
  color:var(--cream);
  margin-bottom:0.5rem;
}

.team-role{
  font-size:0.8rem;
  color:var(--gold);
  letter-spacing:0.15em;
  text-transform:uppercase;
  margin-bottom:1rem;
}

.team-card p{
  color:var(--cream-dim);
  font-size:0.9rem;
  line-height:1.6;
}

/* Case Study Cards */
.case-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
  gap:2rem;
  margin-top:3rem;
}

.case-card{
  background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
  border:1px solid var(--glass-border);
  border-radius:12px;
  overflow:hidden;
  transition:all 0.4s;
}

.case-card:hover{
  transform:translateY(-4px);
  border-color:rgba(201,162,39,0.2);
  box-shadow:0 20px 40px rgba(0,0,0,0.4);
}

.case-header{
  padding:2rem;
  border-bottom:1px solid var(--glass-border);
}

.case-meta{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:1rem;
}

.case-industry{
  font-size:0.75rem;
  letter-spacing:0.15em;
  text-transform:uppercase;
  color:var(--gold);
}

.case-result{
  font-family:'Playfair Display',serif;
  font-size:2rem;
  color:var(--gold);
}

.case-card h4{
  font-family:'Playfair Display',serif;
  font-size:1.3rem;
  color:var(--cream);
}

.case-body{
  padding:2rem;
  color:var(--cream-dim);
  font-size:0.95rem;
  line-height:1.7;
}

.case-tags{
  display:flex;
  gap:0.5rem;
  flex-wrap:wrap;
  margin-top:1.5rem;
}

.case-tag{
  font-size:0.7rem;
  padding:0.35rem 0.75rem;
  border-radius:100px;
  border:1px solid var(--glass-border);
  color:var(--cream-dim);
  letter-spacing:0.05em;
}

/* Newsletter */
.newsletter-section{
  text-align:center;
  max-width:600px;
  margin:0 auto;
}

.newsletter-form{
  display:flex;
  gap:1rem;
  margin-top:2rem;
  justify-content:center;
  flex-wrap:wrap;
}

.newsletter-input{
  flex:1;
  min-width:250px;
  padding:1rem 1.5rem;
  background:var(--glass);
  border:1px solid var(--glass-border);
  border-radius:4px;
  color:var(--cream);
  font-family:'Inter',sans-serif;
  font-size:0.9rem;
  outline:none;
  transition:border-color 0.3s;
}

.newsletter-input:focus{
  border-color:var(--gold);
}

.newsletter-input::placeholder{color:var(--cream-dim);}

/* Guarantee Box */
.guarantee-box{
  background:linear-gradient(135deg, rgba(201,162,39,0.08), rgba(124,58,237,0.04));
  border:1px solid rgba(201,162,39,0.2);
  border-radius:12px;
  padding:2rem;
  margin-top:2rem;
  display:flex;
  gap:1.5rem;
  align-items:flex-start;
}

.guarantee-icon{
  width:48px;
  height:48px;
  border-radius:50%;
  background:rgba(201,162,39,0.1);
  border:1px solid var(--gold);
  display:flex;
  align-items:center;
  justify-content:center;
  color:var(--gold);
  font-size:1.5rem;
  flex-shrink:0;
}

.guarantee-content h4{
  font-family:'Playfair Display',serif;
  color:var(--gold);
  margin-bottom:0.5rem;
}

.guarantee-content p{
  color:var(--cream-dim);
  font-size:0.9rem;
  line-height:1.6;
}

/* Gallery Grid */
.gallery-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:1.5rem;
  margin-top:3rem;
}

.gallery-item{
  aspect-ratio:1;
  border-radius:12px;
  overflow:hidden;
  border:1px solid var(--glass-border);
  position:relative;
}

.gallery-item img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:transform 0.6s;
}

.gallery-item:hover img{transform:scale(1.08);}

/* Industry Nav */
.industry-nav{
  display:flex;
  gap:1rem;
  flex-wrap:wrap;
  justify-content:center;
  margin-top:2rem;
}

.industry-pill{
  padding:0.75rem 1.5rem;
  border-radius:100px;
  border:1px solid var(--glass-border);
  background:var(--glass);
  color:var(--cream-dim);
  text-decoration:none;
  font-size:0.85rem;
  transition:all 0.3s;
}

.industry-pill:hover{
  border-color:var(--gold);
  color:var(--gold);
  background:rgba(201,162,39,0.05);
}

/* Pricing Cards Horizontal */
.pricing-horizontal{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:1.5rem;
  margin-top:3rem;
}

.pricing-card{
  background:linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
  border:1px solid var(--glass-border);
  border-radius:12px;
  padding:2.5rem;
  position:relative;
  transition:all 0.4s;
}

.pricing-card.featured{
  border-color:rgba(201,162,39,0.3);
  background:linear-gradient(180deg, rgba(201,162,39,0.05) 0%, rgba(255,255,255,0.01) 100%);
}

.pricing-card.featured::before{
  content:'';
  position:absolute;
  top:0;left:0;right:0;
  height:2px;
  background:linear-gradient(90deg, transparent, var(--gold), transparent);
}

.pricing-stage{
  font-family:'Cinzel',serif;
  font-size:0.7rem;
  letter-spacing:0.2em;
  text-transform:uppercase;
  color:var(--gold);
  margin-bottom:1rem;
}

.pricing-card h3{
  font-size:1.4rem;
  margin-bottom:0.5rem;
  color:var(--cream);
}

.pricing-price{
  font-family:'Playfair Display',serif;
  font-size:2.5rem;
  color:var(--gold);
  margin:1rem 0;
}

.pricing-price span{
  font-size:1rem;
  color:var(--cream-dim);
}

.pricing-features{
  list-style:none;
  margin:1.5rem 0;
}

.pricing-features li{
  padding:0.5rem 0;
  color:var(--cream-dim);
  font-size:0.9rem;
  display:flex;
  align-items:center;
  gap:0.5rem;
}

.pricing-features li::before{
  content:'✓';
  color:var(--gold);
  font-weight:700;
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

/* Mobile */
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
  .guarantee-box{flex-direction:column;}
}

@media(max-width:768px){
  .hero-tags{flex-direction:column;align-items:center;}
  section{padding:4rem 1.5rem;}
  .section-label{top:1rem;right:1rem;}
  .pricing-horizontal{grid-template-columns:1fr;}
  .case-grid{grid-template-columns:1fr;}
}

::-webkit-scrollbar{width:6px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:var(--gold-dim);border-radius:4px;}
::-webkit-scrollbar-thumb:hover{background:var(--gold);}

.sidebar-nav::-webkit-scrollbar{width:4px;}
.sidebar-nav::-webkit-scrollbar-thumb{background:rgba(201,162,39,0.3);}
</style>
</head>
<body>

<button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle navigation">☰</button>

<!-- Sidebar -->
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
      <a href="#hero-04" class="sidebar-link" data-section="hero-04">HERO-04 — Cinematic Full-bleed</a>
      <a href="#hero-05" class="sidebar-link" data-section="hero-05">HERO-05 — The Vault</a>
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
      <a href="#svc-04" class="sidebar-link" data-section="svc-04">SVC-04 — 12-Column Mosaic</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Process</div>
      <a href="#proc-01" class="sidebar-link" data-section="proc-01">PROC-01 — Gem Stage Left</a>
      <a href="#proc-02" class="sidebar-link" data-section="proc-02">PROC-02 — Gem Stage Right</a>
      <a href="#proc-03" class="sidebar-link" data-section="proc-03">PROC-03 — Gem Stage Final</a>
      <a href="#proc-04" class="sidebar-link" data-section="proc-04">PROC-04 — Vertical Timeline</a>
      <a href="#proc-05" class="sidebar-link" data-section="proc-05">PROC-05 — Timeline Grid</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Pricing</div>
      <a href="#prc-01" class="sidebar-link" data-section="prc-01">PRC-01 — Investment Tiers</a>
      <a href="#prc-02" class="sidebar-link" data-section="prc-02">PRC-02 — Service Ladder</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Stats</div>
      <a href="#stat-01" class="sidebar-link" data-section="stat-01">STAT-01 — 4-Col Stats Row</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Testimonials</div>
      <a href="#test-01" class="sidebar-link" data-section="test-01">TEST-01 — Large Quote</a>
      <a href="#test-02" class="sidebar-link" data-section="test-02">TEST-02 — Prestige Quote</a>
      <a href="#test-03" class="sidebar-link" data-section="test-03">TEST-03 — Case Study Half</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">New Additions</div>
      <a href="#faq-01" class="sidebar-link" data-section="faq-01">FAQ-01 — Accordion</a>
      <a href="#cmp-01" class="sidebar-link" data-section="cmp-01">CMP-01 — Comparison Table</a>
      <a href="#team-01" class="sidebar-link" data-section="team-01">TEAM-01 — Team Grid</a>
      <a href="#case-01" class="sidebar-link" data-section="case-01">CASE-01 — Results Grid</a>
      <a href="#nws-01" class="sidebar-link" data-section="nws-01">NWS-01 — Newsletter</a>
      <a href="#gar-01" class="sidebar-link" data-section="gar-01">GAR-01 — Guarantee Box</a>
      <a href="#gal-01" class="sidebar-link" data-section="gal-01">GAL-01 — Gallery Grid</a>
      <a href="#ind-01" class="sidebar-link" data-section="ind-01">IND-01 — Industry Nav</a>
    </div>
    
    <div class="sidebar-group">
      <div class="sidebar-group-title">Call to Action</div>
      <a href="#cta-01" class="sidebar-link" data-section="cta-01">CTA-01 — Invitation Close</a>
    </div>
  </nav>
  
  <div class="sidebar-footer">
    <p>32 chapters documented.<br>Section pool v2.0</p>
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

<!-- HERO-02 -->
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

<!-- HERO-03 -->
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

<!-- HERO-04: Cinematic -->
<section id="hero-04" style="min-height:80vh;display:flex;align-items:flex-end;padding-bottom:4rem;background:linear-gradient(0deg, rgba(5,5,5,0.95) 0%, rgba(5,5,5,0.3) 50%, rgba(5,5,5,0.1) 100%), url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=1600&auto=format&fit=crop&q=80') center/cover no-repeat;">
  <span class="section-label">HERO-04</span>
  <div class="container reveal">
    <span class="eyebrow">Est. MMXXIV</span>
    <h2 style="font-size:clamp(2.5rem,6vw,4rem);max-width:700px;margin-bottom:1.5rem;">We Excavate <em style="color:var(--gold);">Buried Gold</em></h2>
    <p style="color:var(--cream-dim);max-width:500px;margin-bottom:2rem;font-size:1.1rem;">Business Archaeology & Authority Systems. Deep research across 40+ channels to recover proven marketing tactics you've abandoned.</p>
    <div style="display:flex;gap:2rem;flex-wrap:wrap;">
      <div>
        <strong style="font-family:'Playfair Display',serif;font-size:2.5rem;color:var(--gold);display:block;">3</strong>
        <span style="font-size:0.8rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Client Maximum</span>
      </div>
      <div>
        <strong style="font-family:'Playfair Display',serif;font-size:2.5rem;color:var(--gold);display:block;">40+</strong>
        <span style="font-size:0.8rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Channels</span>
      </div>
      <div>
        <strong style="font-family:'Playfair Display',serif;font-size:2.5rem;color:var(--gold);display:block;">6</strong>
        <span style="font-size:0.8rem;color:var(--cream-dim);text-transform:uppercase;letter-spacing:0.1em;">Week Waitlist</span>
      </div>
    </div>
  </div>
</section>

<!-- HERO-05: The Vault -->
<section id="hero-05" style="text-align:center;padding:8rem 2rem;">
  <span class="section-label">HERO-05</span>
  <div class="container reveal">
    <span class="eyebrow">Est. MMXXIV — By Invitation Only</span>
    <h2 style="font-size:clamp(1.8rem,4vw,2.8rem);max-width:700px;margin:0 auto 1.5rem;">The rarest intelligence is not what competitors are doing now—it is what you yourself once did perfectly, then forgot.</h2>
    <div class="divider"></div>
    <p style="color:var(--cream-dim);font-size:1.1rem;max-width:500px;margin:0 auto 2rem;">Limited to three engagements per quarter.</p>
    <a href="#" class="btn btn-primary">Request Invitation</a>
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

<!-- SVC-02 -->
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

<!-- SVC-03 -->
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

<!-- SVC-04: Mosaic -->
<section id="svc-04" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.03), transparent);">
  <span class="section-label">SVC-04</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Services</span>
      <h2>The Service Collection</h2>
      <div class="divider"></div>
    </div>
    <div class="services-grid">
      <div class="service-card reveal">
        <span class="eyebrow" style="font-size:0.65rem;">Stage I</span>
        <h3>Business History Audit</h3>
        <p>5-7 day deep excavation. 40+ channels analyzed. 15-25 assets recovered. 10-page strategic report with video walkthrough.</p>
      </div>
      <div class="service-card reveal" style="transition-delay:0.1s;">
        <span class="eyebrow" style="font-size:0.65rem;">Stage II</span>
        <h3>Authority Systems Build</h3>
        <p>21-day implementation. Four integrated content systems. AI workflow library. Team training workshop. 90-day launch plan.</p>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:1rem;">
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Content Production</span>
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Publishing Rhythm</span>
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Feedback Loops</span>
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Asset Library</span>
        </div>
      </div>
      <div class="service-card reveal" style="transition-delay:0.2s;">
        <span class="eyebrow" style="font-size:0.65rem;">Stage III</span>
        <h3>Amplification Partnership</h3>
        <p>8 hours monthly. Weekly content review. Monthly strategy call. Quarterly refinement. Priority access for evolving needs.</p>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:1rem;">
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Weekly Reviews</span>
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">Monthly Strategy</span>
          <span class="hero-tag" style="font-size:0.65rem;padding:0.25rem 0.75rem;">24H Response</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROC-01 -->
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

<!-- PROC-02 -->
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

<!-- PROC-03 -->
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

<!-- PROC-04: Vertical Timeline -->
<section id="proc-04" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.03), transparent);">
  <span class="section-label">PROC-04</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">The Journey</span>
      <h2>From Excavation to Authority</h2>
      <div class="divider"></div>
    </div>
    <div style="max-width:800px;margin:0 auto;position:relative;">
      <div style="position:absolute;left:24px;top:0;bottom:0;width:1px;background:linear-gradient(180deg, var(--gold), transparent);"></div>
      
      <div class="reveal" style="display:flex;gap:2rem;margin-bottom:3rem;position:relative;">
        <div style="width:48px;height:48px;border-radius:50%;background:var(--black);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:2;">
          <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:var(--gold);">W1</span>
        </div>
        <div>
          <h4 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--cream);margin-bottom:0.5rem;">The Audit Begins</h4>
          <p style="color:var(--cream-dim);line-height:1.7;">Multi-AI excavation across public and private channels. We interview stakeholders, recover lost assets, and map your competitive history across 40+ channels.</p>
        </div>
      </div>
      
      <div class="reveal" style="display:flex;gap:2rem;margin-bottom:3rem;position:relative;transition-delay:0.1s;">
        <div style="width:48px;height:48px;border-radius:50%;background:var(--black);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:2;">
          <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:var(--gold);">W2</span>
        </div>
        <div>
          <h4 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--cream);margin-bottom:0.5rem;">The Reveal</h4>
          <p style="color:var(--cream-dim);line-height:1.7;">10-page report delivered with video walkthrough. Your golden era identified. Abandonment diagnosed. Competitive gap mapped. Modernization roadmap presented.</p>
        </div>
      </div>
      
      <div class="reveal" style="display:flex;gap:2rem;margin-bottom:3rem;position:relative;transition-delay:0.2s;">
        <div style="width:48px;height:48px;border-radius:50%;background:var(--black);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:2;">
          <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:var(--gold);">W3</span>
        </div>
        <div>
          <h4 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--cream);margin-bottom:0.5rem;">Systems Build</h4>
          <p style="color:var(--cream-dim);line-height:1.7;">Four integrated systems deployed: Content Production Engine, Publishing Rhythm, Performance Feedback Loop, and Asset Library. Team trained and operational.</p>
        </div>
      </div>
      
      <div class="reveal" style="display:flex;gap:2rem;position:relative;transition-delay:0.3s;">
        <div style="width:48px;height:48px;border-radius:50%;background:var(--black);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:2;">
          <span style="font-family:'Cinzel',serif;font-size:0.8rem;color:var(--gold);">O1</span>
        </div>
        <div>
          <h4 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--cream);margin-bottom:0.5rem;">Ongoing Partnership</h4>
          <p style="color:var(--cream-dim);line-height:1.7;">Weekly content review, monthly strategy calls, quarterly refinement. Your authority compounds month after month with consistent execution.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROC-05: Timeline Grid -->
<section id="proc-05">
  <span class="section-label">PROC-05</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">The Journey</span>
      <h2>Three Phases of Transformation</h2>
      <div class="divider"></div>
    </div>
    <div class="services-grid">
      <div class="service-card reveal">
        <span class="eyebrow" style="font-size:0.65rem;">Phase 1</span>
        <h3>Excavation</h3>
        <p>Deep forensic research across 40+ channels. Public archives, private collections, and human intelligence combined to reconstruct your marketing history.</p>
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--glass-border);">
          <span style="font-family:'Cinzel',serif;font-size:0.7rem;color:var(--gold);letter-spacing:0.15em;text-transform:uppercase;">5-7 Days</span>
        </div>
      </div>
      <div class="service-card reveal" style="transition-delay:0.1s;">
        <span class="eyebrow" style="font-size:0.65rem;">Phase 2</span>
        <h3>Modernization</h3>
        <p>Transform proven historical tactics for today's platforms. Voice extraction, channel translation, and AI-powered content system architecture.</p>
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--glass-border);">
          <span style="font-family:'Cinzel',serif;font-size:0.7rem;color:var(--gold);letter-spacing:0.15em;text-transform:uppercase;">21 Days</span>
        </div>
      </div>
      <div class="service-card reveal" style="transition-delay:0.2s;">
        <span class="eyebrow" style="font-size:0.65rem;">Phase 3</span>
        <h3>Amplification</h3>
        <p>Ongoing partnership to compound your authority. Weekly reviews, monthly strategy, quarterly refinement. Limited to three clients for quality.</p>
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--glass-border);">
          <span style="font-family:'Cinzel',serif;font-size:0.7rem;color:var(--gold);letter-spacing:0.15em;text-transform:uppercase;">Ongoing</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRC-01: Investment Tiers -->
<section id="prc-01" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.03), transparent);">
  <span class="section-label">PRC-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Investment</span>
      <h2>The Service Tiers</h2>
      <div class="divider"></div>
    </div>
    <div class="pricing-horizontal">
      <div class="pricing-card reveal">
        <span class="pricing-stage">Foundation</span>
        <h3>Business History Audit</h3>
        <div class="pricing-price">$2,000 <span>one-time</span></div>
        <ul class="pricing-features">
          <li>40+ channel analysis</li>
          <li>15-25 assets recovered</li>
          <li>10-page strategic report</li>
          <li>Video walkthrough</li>
          <li>Asset portfolio</li>
        </ul>
        <a href="#" class="btn btn-outline" style="width:100%;justify-content:center;">Select</a>
      </div>
      <div class="pricing-card featured reveal" style="transition-delay:0.1s;">
        <span class="pricing-stage">Transformation</span>
        <h3>Authority Systems Build</h3>
        <div class="pricing-price">$5,500 <span>one-time</span></div>
        <ul class="pricing-features">
          <li>Everything in Foundation</li>
          <li>4 integrated content systems</li>
          <li>AI workflow library</li>
          <li>Team training workshop</li>
          <li>90-day launch plan</li>
        </ul>
        <a href="#" class="btn btn-primary" style="width:100%;justify-content:center;">Select</a>
      </div>
      <div class="pricing-card reveal" style="transition-delay:0.2s;">
        <span class="pricing-stage">Partnership</span>
        <h3>Amplification Retainer</h3>
        <div class="pricing-price">$2,750 <span>/month</span></div>
        <ul class="pricing-features">
          <li>8 hours monthly</li>
          <li>Weekly content review</li>
          <li>Monthly strategy call</li>
          <li>Quarterly refinement</li>
          <li>Priority access</li>
        </ul>
        <a href="#" class="btn btn-outline" style="width:100%;justify-content:center;">Select</a>
      </div>
    </div>
  </div>
</section>

<!-- PRC-02: Service Ladder -->
<section id="prc-02">
  <span class="section-label">PRC-02</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Investment</span>
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

<!-- TEST-02: Prestige Quote -->
<section id="test-02" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.04), transparent);">
  <span class="section-label">TEST-02</span>
  <div class="container">
    <div class="testimonial reveal">
      <blockquote style="font-size:1.6rem;">
        "The rarest intelligence is not what competitors are doing now—it is what you yourself once did perfectly, then forgot."
      </blockquote>
      <cite>
        <strong>John Carr</strong>
        Founder, LEGAiSEE Business Archaeology
      </cite>
    </div>
  </div>
</section>

<!-- TEST-03: Case Study Half -->
<section id="test-03">
  <span class="section-label">TEST-03</span>
  <div class="container">
    <div class="gem-stage reveal">
      <div class="gem-visual">
        <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=800&auto=format&fit=crop&q=80" alt="Case study">
        <div class="gem-badge">CASE-01</div>
      </div>
      <div class="gem-info">
        <span class="stage-label">Manufacturing</span>
        <h3>Richardson Manufacturing</h3>
        <p style="color:var(--cream-dim);margin-bottom:1.5rem;">Third-generation family business. Abandoned their dominant Yellow Pages and trade show presence in 2012, never transitioned to digital authority. We excavated 23 assets, modernized their voice, and built a LinkedIn-first authority system.</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
          <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);text-align:center;">
            <strong style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">40%</strong>
            <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">Lead Increase</span>
          </div>
          <div style="padding:1rem;background:rgba(0,0,0,0.2);border-radius:8px;border:1px solid var(--glass-border);text-align:center;">
            <strong style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold);display:block;">$6M</strong>
            <span style="font-size:0.7rem;color:var(--cream-dim);text-transform:uppercase;">Opportunity Found</span>
          </div>
        </div>
        <a href="#" class="service-link">Read Full Case Study →</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== NEW SECTIONS FROM PAGE REVIEW ===== -->

<!-- FAQ-01: Accordion -->
<section id="faq-01" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.03), transparent);">
  <span class="section-label">FAQ-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Questions</span>
      <h2>Frequently Asked</h2>
      <div class="divider"></div>
    </div>
    <div style="max-width:800px;margin:0 auto;">
      <div class="faq-item reveal">
        <button class="faq-question">What exactly is Business Archaeology?</button>
        <div class="faq-answer">
          <p>Business Archaeology is forensic research into your company's marketing history. We excavate across 40+ channels—public archives, private collections, and human memory—to reconstruct what made you successful, when you stopped, and how to restore that advantage with modern execution.</p>
        </div>
      </div>
      <div class="faq-item reveal" style="transition-delay:0.1s;">
        <button class="faq-question">How long does the audit take?</button>
        <div class="faq-answer">
          <p>The Business History Audit takes 5-7 business days from kickoff. This includes multi-source research, asset documentation, competitive analysis, and delivery of your 10-page report with video walkthrough.</p>
        </div>
      </div>
      <div class="faq-item reveal" style="transition-delay:0.2s;">
        <button class="faq-question">Why are you limited to 3 clients?</button>
        <div class="faq-answer">
          <p>Museum-quality research requires deep focus. Each audit demands 20+ hours of concentrated excavation. Limiting to three clients ensures every engagement receives the obsessive attention your business history deserves.</p>
        </div>
      </div>
      <div class="faq-item reveal" style="transition-delay:0.3s;">
        <button class="faq-question">What if we don't have old marketing materials?</button>
        <div class="faq-answer">
          <p>Most businesses have more than they realize. We recover assets from web archives, social media history, employee interviews, industry publications, and competitor intelligence. Even fragmented evidence reveals patterns.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CMP-01: Comparison Table -->
<section id="cmp-01">
  <span class="section-label">CMP-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Comparison</span>
      <h2>Traditional Agency vs. Business Archaeology</h2>
      <div class="divider"></div>
    </div>
    <div style="overflow-x:auto;">
      <table class="compare-table reveal">
        <thead>
          <tr>
            <th>Approach</th>
            <th>Traditional Agency</th>
            <th>LEGAiSEE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Starting Point</td>
            <td>"What should you do?"</td>
            <td>"What made you great?"</td>
          </tr>
          <tr>
            <td>Research Depth</td>
            <td>Competitor scan (current)</td>
            <td>40+ channel excavation (historical)</td>
          </tr>
          <tr>
            <td>Asset Recovery</td>
            <td>None</td>
            <td>15-25 documented assets</td>
          </tr>
          <tr>
            <td>Voice Authenticity</td>
            <td>Generic best practices</td>
            <td>Your unique communication DNA</td>
          </tr>
          <tr>
            <td>Deliverable</td>
            <td>Strategy deck</td>
            <td>10-page report + asset museum + systems</td>
          </tr>
          <tr>
            <td>Client Limit</td>
            <td>20+ accounts per strategist</td>
            <td>3 maximum</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- TEAM-01: Team Grid -->
<section id="team-01" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.03), transparent);">
  <span class="section-label">TEAM-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">People</span>
      <h2>The Archaeologists</h2>
      <div class="divider"></div>
    </div>
    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-avatar">JC</div>
        <h4>John Carr</h4>
        <span class="team-role">Founder & Lead Archaeologist</span>
        <p>Former agency strategist turned business historian. 15 years excavating what makes companies truly great.</p>
      </div>
      <div class="team-card reveal" style="transition-delay:0.1s;">
        <div class="team-avatar" style="background:linear-gradient(135deg, var(--violet-soft), var(--gold));">MK</div>
        <h4>Maya Kowalski</h4>
        <span class="team-role">Senior Research Analyst</span>
        <p>Digital forensics specialist. Recovers assets from the deepest corners of the web and forgotten hard drives.</p>
      </div>
      <div class="team-card reveal" style="transition-delay:0.2s;">
        <div class="team-avatar" style="background:linear-gradient(135deg, var(--gold-dim), var(--violet));">DR</div>
        <h4>David Reyes</h4>
        <span class="team-role">Systems Architect</span>
        <p>Builds the AI-powered content engines that transform historical gold into modern authority systems.</p>
      </div>
    </div>
  </div>
</section>

<!-- CASE-01: Results Grid -->
<section id="case-01">
  <span class="section-label">CASE-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Proof</span>
      <h2>Excavation Results</h2>
      <div class="divider"></div>
    </div>
    <div class="case-grid">
      <div class="case-card reveal">
        <div class="case-header">
          <div class="case-meta">
            <span class="case-industry">Manufacturing</span>
            <span class="case-result">40%</span>
          </div>
          <h4>Richardson Manufacturing</h4>
        </div>
        <div class="case-body">
          <p>Recovered abandoned trade show dominance from 2008-2012. Modernized into LinkedIn authority system. 40% increase in qualified leads within 90 days.</p>
          <div class="case-tags">
            <span class="case-tag">B2B</span>
            <span class="case-tag">Third Generation</span>
            <span class="case-tag">LinkedIn</span>
          </div>
        </div>
      </div>
      <div class="case-card reveal" style="transition-delay:0.1s;">
        <div class="case-header">
          <div class="case-meta">
            <span class="case-industry">Professional Services</span>
            <span class="case-result">3x</span>
          </div>
          <h4>Westlake Legal Group</h4>
        </div>
        <div class="case-body">
          <p>Excavated 1980s-90s community seminar strategy. Transformed into webinar series and local SEO dominance. Tripled consultation bookings.</p>
          <div class="case-tags">
            <span class="case-tag">Law</span>
            <span class="case-tag">Local SEO</span>
            <span class="case-tag">Webinars</span>
          </div>
        </div>
      </div>
      <div class="case-card reveal" style="transition-delay:0.2s;">
        <div class="case-header">
          <div class="case-meta">
            <span class="case-industry">Retail</span>
            <span class="case-result">$2.1M</span>
          </div>
          <h4>Heritage Home Furnishings</h4>
        </div>
        <div class="case-body">
          <p>Found catalog-era customer loyalty systems. Rebuilt as email automation and VIP community. $2.1M in attributed revenue Year 1.</p>
          <div class="case-tags">
            <span class="case-tag">E-commerce</span>
            <span class="case-tag">Email</span>
            <span class="case-tag">Retention</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- NWS-01: Newsletter -->
<section id="nws-01" style="background:linear-gradient(180deg, transparent, rgba(124,58,237,0.03), transparent);">
  <span class="section-label">NWS-01</span>
  <div class="container">
    <div class="newsletter-section reveal">
      <span class="eyebrow">Intelligence Briefing</span>
      <h2 style="font-size:clamp(1.8rem,4vw,2.5rem);margin-bottom:1rem;">The Archaeology Dispatch</h2>
      <p style="color:var(--cream-dim);margin-bottom:2rem;">Monthly insights on recovered business tactics, modernization strategies, and authority-building frameworks. No noise. Only signal.</p>
      <form class="newsletter-form" onsubmit="event.preventDefault();">
        <input type="email" class="newsletter-input" placeholder="your@email.com" required>
        <button type="submit" class="btn btn-primary">Subscribe</button>
      </form>
      <p style="font-size:0.75rem;color:var(--cream-dim);margin-top:1rem;opacity:0.6;">Unsubscribe anytime. We respect your attention.</p>
    </div>
  </div>
</section>

<!-- GAR-01: Guarantee Box -->
<section id="gar-01">
  <span class="section-label">GAR-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Assurance</span>
      <h2>Our Commitment</h2>
      <div class="divider"></div>
    </div>
    <div style="max-width:800px;margin:0 auto;">
      <div class="guarantee-box reveal">
        <div class="guarantee-icon">◆</div>
        <div class="guarantee-content">
          <h4>The Clarity Guarantee</h4>
          <p>If the Business History Audit does not reveal at least one actionable insight from your past that can be modernized for present growth, we will refund 100% of your investment. The diagnosis is certain. The value is guaranteed.</p>
        </div>
      </div>
      <div class="guarantee-box reveal" style="transition-delay:0.1s;">
        <div class="guarantee-icon">◆</div>
        <div class="guarantee-content">
          <h4>The Exclusivity Promise</h4>
          <p>We never serve direct competitors simultaneously. When you engage LEGAiSEE, your industry vertical is reserved for the duration of our partnership. Your advantage remains yours alone.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- GAL-01: Gallery Grid -->
<section id="gal-01" style="background:linear-gradient(180deg, transparent, rgba(201,162,39,0.03), transparent);">
  <span class="section-label">GAL-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Artifacts</span>
      <h2>Recovered Assets</h2>
      <div class="divider"></div>
    </div>
    <div class="gallery-grid">
      <div class="gallery-item reveal">
        <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=600&auto=format&fit=crop&q=80" alt="Vintage print ad">
      </div>
      <div class="gallery-item reveal" style="transition-delay:0.1s;">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600&auto=format&fit=crop&q=80" alt="Trade show booth">
      </div>
      <div class="gallery-item reveal" style="transition-delay:0.2s;">
        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&auto=format&fit=crop&q=80" alt="Direct mail piece">
      </div>
      <div class="gallery-item reveal" style="transition-delay:0.3s;">
        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=600&auto=format&fit=crop&q=80" alt="Radio script">
      </div>
    </div>
  </div>
</section>

<!-- IND-01: Industry Nav -->
<section id="ind-01">
  <span class="section-label">IND-01</span>
  <div class="container">
    <div class="section-header reveal">
      <span class="eyebrow">Specializations</span>
      <h2>Industries We Serve</h2>
      <div class="divider"></div>
    </div>
    <div class="industry-nav reveal">
      <a href="#" class="industry-pill">Manufacturing</a>
      <a href="#" class="industry-pill">Professional Services</a>
      <a href="#" class="industry-pill">Healthcare</a>
      <a href="#" class="industry-pill">Retail & E-commerce</a>
      <a href="#" class="industry-pill">Real Estate</a>
      <a href="#" class="industry-pill">Financial Services</a>
      <a href="#" class="industry-pill">Technology</a>
      <a href="#" class="industry-pill">Hospitality</a>
    </div>
    <div style="max-width:800px;margin:3rem auto 0;">
      <div class="gem-stage reveal" style="margin:0;">
        <div class="gem-info" style="text-align:center;">
          <span class="eyebrow">Deep Vertical Expertise</span>
          <p style="color:var(--cream-dim);line-height:1.7;">Each industry has unique archival patterns. Manufacturing leaves trade show records and catalog histories. Professional services generate seminar materials and referral networks. We tailor our excavation strategy to your vertical's specific artifact landscape.</p>
        </div>
      </div>
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
// Scroll reveal
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

// Scroll spy
const sections = document.querySelectorAll('section[id], div[id]');
const navLinks = document.querySelectorAll('.sidebar-link');

function updateActiveLink(){
  let current = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop;
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

// Mobile sidebar
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
}

document.querySelectorAll('.sidebar-link').forEach(link => {
  link.addEventListener('click', () => {
    if(window.innerWidth <= 1024){
      document.getElementById('sidebar').classList.remove('open');
    }
  });
});

// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(button => {
  button.addEventListener('click', () => {
    const item = button.parentElement;
    const isActive = item.classList.contains('active');
    
    // Close all
    document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
    
    // Open clicked if wasn't active
    if(!isActive){
      item.classList.add('active');
    }
  });
});

// Parallax glow
document.addEventListener('mousemove', (e) => {
  const x = (e.clientX / window.innerWidth - 0.5) * 20;
  const y = (e.clientY / window.innerHeight - 0.5) * 20;
  document.body.style.setProperty('--glow-x', x + 'px');
  document.body.style.setProperty('--glow-y', y + 'px');
});
</script>

</body>
</html>

