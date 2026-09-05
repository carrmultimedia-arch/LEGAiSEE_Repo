
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services — LEGAISEE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #0a0a0a;
            --gold: #C9A961;
            --gold-bright: #D4AF37;
            --white: #FFFFFF;
            --gray-light: #E5E5E5;
            --gray: #888888;
            --gray-dark: #333333;
            --border: rgba(201, 169, 97, 0.3);
            --border-subtle: rgba(255, 255, 255, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            content: '◆';
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
    </style>
</head>
<body>
    <nav>
        <a href="index.html" class="nav-brand">LEGAISEE</a>
        <div class="nav-links">
            <a href="audit.html">SERVICES</a>
            <a href="about.html">ABOUT</a>
            <a href="contact.html">CONTACT</a>
            <a href="contact.html" class="nav-cta">BOOK CONSULT</a>
        </div>
    </nav>

    <div class="page-header">
        <span class="page-label">Signature Services</span>
        <h1 class="page-title">Three Stages of<br>Archaeological Restoration</h1>
        <p class="page-subtitle">
            Each engagement is bespoke, documented, and engineered for clients who measure value in decades—not quarters.
        </p>
    </div>

    <div class="section-divider"></div>

    <!-- Stage 1: Audit -->
    <section id="audit">
        <div class="service-detail">
            <div class="service-info">
                <h2>Business History Audit</h2>
                <div class="service-meta">
                    <span>STAGE 01</span>
                    <span>5-7 DAYS</span>
                    <span>DOCUMENTARY RIGOR</span>
                </div>
                <p class="service-description">
                    Forensic excavation of your marketing history across 40+ channels. We reconstruct what made you successful, when you stopped, and what it would take to restore that advantage. Every finding is confidence-rated: [Verified], [Probable], [Plausible], or [Uncertain].
                </p>
                <ul class="service-features">
                    <li>Multi-source research (public archives, private collections, human interviews)</li>
                    <li>15-25 documented assets with provenance and dating</li>
                    <li>Competitive gap analysis (who took your space, how)</li>
                    <li>Abandonment diagnosis (why working tactics stopped)</li>
                    <li>10-page report + video walkthrough + asset portfolio</li>
                    <li>60-minute presentation call</li>
                </ul>
                <div class="price-tag">$2,000</div>
                <div class="price-note">Foundation Tier — Single Payment or 50/50 Split</div>
                <a href="contact.html" class="btn-primary">REQUEST AUDIT</a>
            </div>
            <div class="process-list">
                <div class="process-item">
                    <div class="process-number">01</div>
                    <div class="process-content">
                        <h4>Multi-Source Excavation</h4>
                        <p>Public archaeology (web archives, social history, YouTube, news databases) combined with private artifact recovery (hard drives, email archives, filing cabinets, employee interviews).</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">02</div>
                    <div class="process-content">
                        <h4>Triangulation & Verification</h4>
                        <p>Cross-reference findings across sources. Resolve conflicts using source quality hierarchy. Label every claim with confidence rating.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">03</div>
                    <div class="process-content">
                        <h4>Synthesis & Analysis</h4>
                        <p>Identify golden era, map abandonment timeline, diagnose competitive gap, and specify modernization opportunities with highest ROI potential.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">04</div>
                    <div class="process-content">
                        <h4>Documentation & Delivery</h4>
                        <p>10-page Business History Report, digital asset museum (organized, tagged, searchable), timeline visualization, and 60-minute presentation.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="guarantee-box">
            <h4>The Legaisee Guarantee</h4>
            <p>If we cannot document at least 10 assets with [Probable] or higher confidence, we refund 50% of your investment. We document uncertainty—we don't hide it.</p>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Stage 2: Build -->
    <section id="build">
        <div class="service-detail">
            <div class="service-info">
                <h2>Authority System Build</h2>
                <div class="service-meta">
                    <span>STAGE 02</span>
                    <span>21 DAYS</span>
                    <span>4 INTEGRATED SYSTEMS</span>
                </div>
                <p class="service-description">
                    Transform excavated assets into modern, AI-powered content systems. We build four integrated workflows trained on your authentic voice—producing authority material at scale without your constant involvement.
                </p>
                <ul class="service-features">
                    <li>8-dimension voice profile extraction and encoding</li>
                    <li>Content Production Engine (script generator, hook tester, repurposing)</li>
                    <li>Publishing Rhythm (calendar, scheduling, approval workflows)</li>
                    <li>Performance Feedback Loop (dashboard, review rituals, optimization triggers)</li>
                    <li>Asset Library & Reuse System (organization, retrieval, refresh protocols)</li>
                    <li>Team training (2 sessions, 4 hours each) + Video library</li>
                </ul>
                <div class="price-tag">$5,500</div>
                <div class="price-note">Foundation Tier — 50% to Begin, 50% on Delivery</div>
                <a href="contact.html" class="btn-primary">INQUIRE ABOUT BUILD</a>
            </div>
            <div class="process-list">
                <div class="process-item">
                    <div class="process-number">01</div>
                    <div class="process-content">
                        <h4>Voice Extraction Protocol</h4>
                        <p>Analyze your best content across 8 dimensions (vocabulary, sentence architecture, humor, perspective, transitions, CTAs, evidence, visual language). Create AI-ready voice profile.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">02</div>
                    <div class="process-content">
                        <h4>AI Workflow Engineering</h4>
                        <p>Build 4 core systems: Script Generator, Hook Tester, Repurposing Engine, Title Optimizer. Each trained on your voice, tested for authenticity.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">03</div>
                    <div class="process-content">
                        <h4>Publishing Infrastructure</h4>
                        <p>Editorial calendar architecture, scheduling tool integration, approval workflows, batch production training (4 hours = 2 weeks of content).</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">04</div>
                    <div class="process-content">
                        <h4>Performance & Library Systems</h4>
                        <p>Metrics dashboard, weekly review ritual, decision frameworks (persist/pivot/test), asset library structure with retrieval protocols.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Stage 3: Partnership -->
    <section id="partnership">
        <div class="service-detail">
            <div class="service-info">
                <h2>Amplification Partnership</h2>
                <div class="service-meta">
                    <span>STAGE 03</span>
                    <span>ONGOING</span>
                    <span>MONTH-TO-MONTH</span>
                </div>
                <p class="service-description">
                    Strategic partnership for continuous optimization. We maintain your authority system, conduct ongoing competitive intelligence, and provide quarterly strategy retreats to keep your advantage sharp.
                </p>
                <ul class="service-features">
                    <li>Weekly content review & async video feedback (Loom)</li>
                    <li>Monthly 60-minute strategy call + performance report</li>
                    <li>Quarterly 2-hour deep-dive + competitive archaeology update</li>
                    <li>System maintenance & prompt optimization</li>
                    <li>Trend alerts & platform change notifications</li>
                    <li>Emergency support (48-hour response guarantee)</li>
                </ul>
                <div class="price-tag">$2,750<span style="font-size: 24px;">/mo</span></div>
                <div class="price-note">Foundation Tier — 8 Hours Direct Service Monthly</div>
                <a href="contact.html" class="btn-primary">APPLY FOR PARTNERSHIP</a>
            </div>
            <div class="process-list">
                <div class="process-item">
                    <div class="process-number">W1</div>
                    <div class="process-content">
                        <h4>Weekly Optimization</h4>
                        <p>Content review with async video feedback. Optimization recommendations based on performance data. Trend alerts for platform or industry shifts.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">M1</div>
                    <div class="process-content">
                        <h4>Monthly Strategy</h4>
                        <p>60-minute strategy call. Performance report with metrics analysis. Content calendar refinement. System updates and prompt improvements.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">Q1</div>
                    <div class="process-content">
                        <h4>Quarterly Intelligence</h4>
                        <p>2-hour strategic deep-dive. Competitive archaeology update (what's changed in your market). Asset refresh (update evergreen content). Strategy pivot recommendations.</p>
                    </div>
                </div>
                <div class="process-item">
                    <div class="process-number">24H</div>
                    <div class="process-content">
                        <h4>Emergency Protocol</h4>
                        <p>48-hour response guarantee for urgent issues. Crisis management support. Direct access for time-sensitive decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-brand">LEGAISEE</div>
        <div class="footer-tagline">Excavate What Made You Great. Modernize It. Make It Work Again.</div>
        <div class="footer-links">
            <a href="index.html">HOME</a>
            <a href="audit.html">SERVICES</a>
            <a href="about.html">ABOUT</a>
            <a href="contact.html">CONTACT</a>
        </div>
        <div class="footer-copyright">© 2026 LEGAISEE — Business Archaeology & Authority Systems</div>
    </footer>
</body>
</html>

