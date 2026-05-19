<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Visual Sandbox</title>

<style>
:root {
  --gold: #f5c76a;
  --gold-deep: #c89a3c;
  --gold-soft: rgba(245, 199, 106, 0.25);
  --gold-medium: rgba(245, 199, 106, 0.5);
  --gold-glow: rgba(245, 199, 106, 0.2);
}
body{
  margin:0;
  background:#050509;
  color:#f9f9ff;
  font-family:Arial, sans-serif;
}

/* CORE TEST WRAPPER */
.section{
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  flex-direction:column;
  padding:60px;
}

/* YOUR GRADIENT TESTS */
.section-violet-top {
  background: radial-gradient(
    circle at top,
    rgba(59, 43, 95, 0.25),
    transparent 55%
  );
}

.section-gold-bottom {
  background: radial-gradient(
    circle at bottom,
    rgba(245, 199, 106, 0.12),
    transparent 55%
  );
}

/* VISUAL DEBUG CARD */
.card{
  background:rgba(11,11,18,0.8);
  border:1px solid rgba(245,199,106,0.25);
  padding:30px;
  border-radius:10px;
  max-width:600px;
  text-align:center;
}
.service-card {
  background: rgba(5, 5, 9, 0.9);
  border-radius: 20px;
  padding: 1.6rem 1.5rem;
  border: 1px solid rgba(245, 199, 106, 0.25);
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.9);
  transition: all 0.3s ease;
}

.service-card:hover {
  border-color: rgba(245, 199, 106, 0.5);
  box-shadow:
    0 0 40px rgba(245, 199, 106, 0.2),
    0 0 60px rgba(0, 0, 0, 0.95);
  transform: translateY(-3px);
}
.timeline-card {
  background: rgba(5, 5, 9, 0.85);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid rgba(245, 199, 106, 0.25);
  box-shadow:
    0 0 20px rgba(0, 0, 0, 0.9),
    0 0 30px rgba(245, 199, 106, 0.1);
  transition: all 0.3s ease;
}

.timeline-card:hover {
  transform: translateY(-3px);
  border-color: rgba(245, 199, 106, 0.5);
  box-shadow:
    0 0 40px rgba(245, 199, 106, 0.2),
    0 0 60px rgba(0, 0, 0, 0.95);
}
.nav-links a {
  position: relative;
  padding-bottom: 0.2rem;
  color: rgba(249, 249, 255, 0.78);
  text-decoration: none;
}

.nav-links a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, var(--gold), var(--gold-medium));
  transition: width 0.25s ease;
}

.nav-links a:hover::after {
  width: 100%;
}
.hero-card {
  background:
    radial-gradient(circle at top,
      rgba(245, 199, 106, 0.16),
      rgba(5, 5, 9, 0.96));

  border-radius: 26px;
  border: 1px solid rgba(245, 199, 106, 0.4);

  box-shadow:
    0 0 40px rgba(0, 0, 0, 0.95),
    0 0 60px rgba(245, 199, 106, 0.18);
}

</style>

</head>

<body>

<div class="section section-violet-top">

  <div class="hero-card" style="padding:30px; margin-bottom:20px;">
    <h2>Hero Card</h2>
    <p>Radial top glow + prestige border system</p>
  </div>

  <div class="service-card" style="margin-bottom:20px;">
    <h3>Service Card</h3>
    <p>Primary operational module styling</p>
  </div>

  <div class="timeline-card" style="margin-bottom:20px;">
    <h3>Timeline Card</h3>
    <p>Historical / archeology narrative structure</p>
  </div>

  <div class="nav-links">
    <a href="#">Navigation Link</a>
  </div>

</div>

<div class="section section-gold-bottom">
  <div class="hero-card" style="padding:30px;">
    <h2>Bottom Gold Glow Test</h2>
    <p>Validation of gold radial separation layer</p>
  </div>
</div>

<div class="section section-violet-top">
  <div class="card">
    <h2>Violet Top Gradient Test</h2>
    <p>This tests radial glow anchored to top center.</p>
  </div>
</div>

<div class="section section-gold-bottom">
  <div class="card">
    <h2>Gold Bottom Gradient Test</h2>
    <p>This tests radial glow anchored to bottom center.</p>
  </div>
</div>

</body>
</html>