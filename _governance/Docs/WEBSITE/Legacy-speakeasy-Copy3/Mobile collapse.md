CSS
===================================================

/* ============================================
   RESPONSIVE BREAKPOINTS
   ============================================ */

/* Tablet and below (768px) */
@media (max-width: 768px) {
  
  /* Navigation - Convert to hamburger */
  .nav-prestige {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    padding: 16px 20px;
    background: rgba(5,5,5,0.98);
    backdrop-filter: blur(10px);
  }
  
  .nav-prestige .links,
  .nav-prestige .availability {
    display: none; /* Hide desktop menu */
  }
  
  .nav-prestige .brand {
    font-size: 1.2rem;
  }
  
  .nav-prestige .brand small {
    display: none; /* Hide tagline on mobile */
  }
  
  /* Add hamburger menu button */
  .nav-prestige::after {
    content: "☰";
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gold);
    font-size: 1.5rem;
    cursor: pointer;
  }
  
  /* Main content spacing for fixed nav */
  #content {
    margin-top: 70px;
  }
  
  /* Section padding reduction */
  .sec-wrap {
    padding: 0 20px !important;
    max-width: 100%;
  }
  
  /* Hero adjustments */
  .hero-centered {
    padding: 100px 0 80px !important;
    min-height: auto;
  }
  
  .hero-centered h1 {
    font-size: 2rem !important;
    line-height: 1.2;
  }
  
  .hero-centered .sub {
    font-size: 1rem !important;
    max-width: 100%;
  }
  
  /* Process sections - stack vertically */
  .process-alt-item,
  .process-alt-item.reversed {
    flex-direction: column !important;
    gap: 40px !important;
    margin-bottom: 80px !important;
  }
  
  .process-alt-item .img-side,
  .process-alt-item .text-side {
    flex: none !important;
    width: 100%;
  }
  
  .process-alt-item .image-frame {
    transform: none !important; /* Remove rotation on mobile */
    max-width: 100%;
  }
  
  /* Gem section - stack vertically */
  .gem-panels {
    flex-direction: column !important;
    gap: 40px !important;
  }
  
  .gem-stage {
    flex: none !important;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
  }
  
  .gem-stage > div {
    width: 100% !important;
    height: auto !important;
    aspect-ratio: 1/1;
  }
  
  .gem-text-left,
  .gem-text-right {
    text-align: center !important;
  }
  
  .gem-text-right .stats-bar {
    text-align: center;
    align-items: center !important;
  }
  
  /* Manifesto adjustments */
  .manifesto-section {
    padding: 80px 0 !important;
  }
  
  .manifesto-heading {
    font-size: 1.8rem !important;
  }
  
  .manifesto-body p {
    font-size: 1rem !important;
  }
  
  /* Hide side image on mobile */
  .manifesto-inner .image-frame {
    display: none;
  }
  
  /* Vault section */
  .vault-section {
    padding: 80px 0 !important;
  }
  
  .vault-door-frame {
    max-width: 100% !important;
  }
  
  .vault-title {
    font-size: 1.5rem !important;
  }
  
  /* Footer adjustments */
  .footer-prestige .inner {
    flex-direction: column;
    gap: 40px;
  }
  
  .footer-prestige .nav-cols {
    flex-direction: column;
    gap: 30px;
  }
}

/* Small mobile (480px) */
@media (max-width: 480px) {
  
  .hero-centered h1 {
    font-size: 1.6rem !important;
  }
  
  .btn-row {
    flex-direction: column;
    gap: 16px;
  }
  
  .btn-row button {
    width: 100%;
  }
  
  .prestige-label {
    font-size: 0.6rem !important;
  }
  
  .process-alt-item h3 {
    font-size: 1.3rem !important;
  }
  
  .stats-bar {
    flex-direction: column !important;
    gap: 20px;
  }
  
  .stat-item {
    min-width: auto !important;
  }
}


=========================================================
Page script
==============================================================
// Mobile menu toggle
(function() {
  const nav = document.querySelector('.nav-prestige');
  let menuOpen = false;
  
  // Create mobile menu overlay
  const mobileMenu = document.createElement('div');
  mobileMenu.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(5,5,5,0.98);
    z-index: 999;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
  `;
  
  // Clone links for mobile menu
  const links = nav.querySelectorAll('.links a');
  links.forEach(link => {
    const clone = link.cloneNode(true);
    clone.style.cssText = `
      font-family: var(--font-cinzel);
      font-size: 1.5rem;
      color: var(--platinum);
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    `;
    mobileMenu.appendChild(clone);
  });
  
  // Close button
  const closeBtn = document.createElement('div');
  closeBtn.innerHTML = '✕';
  closeBtn.style.cssText = `
    position: absolute;
    top: 20px;
    right: 20px;
    color: var(--gold);
    font-size: 1.5rem;
    cursor: pointer;
  `;
  closeBtn.onclick = () => {
    mobileMenu.style.display = 'none';
    menuOpen = false;
  };
  mobileMenu.appendChild(closeBtn);
  
  document.body.appendChild(mobileMenu);
  
  // Toggle on hamburger click
  nav.addEventListener('click', (e) => {
    if (window.innerWidth <= 768 && e.target === nav) {
      menuOpen = !menuOpen;
      mobileMenu.style.display = menuOpen ? 'flex' : 'none';
    }
  });
  
  // Close on link click
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      mobileMenu.style.display = 'none';
      menuOpen = false;
    });
  });
})();

