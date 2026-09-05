
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEGAiSEE — Business Archaeology</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --obsidian: #050505;
            --obsidian-light: #0a0a0a;
            --obsidian-lighter: #111111;
            --charcoal: #1a1a1a;
            --graphite: #242424;
            --gold: #C9A961;
            --gold-light: #D4B978;
            --gold-bright: #E8D5A3;
            --gold-dim: #8B7355;
            --platinum: #E5E5E5;
            --silver: #A0A0A0;
            --bronze: #B87333;
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
            content: '—';
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
    </style>
</head>

    <!-- BLOCK 1: Hero — Asymmetric with Nested Content -->
    <section class="section flow-gradient">
        <div class="asymmetric-2col">
            <div class="content-block" style="padding-top: 40px;">
                <span class="prestige-label prestige-label-solo">Est. 2024</span>
                <h1 style="margin-bottom: 32px;">Excavate Your<br><span class="text-gold">Buried Gold</span></h1>
                <p style="font-size: 1.2rem; line-height: 1.9; margin-bottom: 32px;">
                    We conduct deep archaeological research across 40+ channels of your business history—public records, private archives, and human intelligence—to recover proven marketing tactics you've abandoned.
                </p>
                <p style="color: var(--silver); margin-bottom: 40px;">
                    Then we transform them into modern authority systems: content engines, publishing rhythms, and on-camera presence that compounds over time.
                </p>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <a href="#" class="btn-prestige btn-gold">Begin Excavation</a>
                    <a href="#" class="btn-prestige btn-outline">The Methodology</a>
                </div>
            </div>
            <div class="prestige-flex-column">
                <div class="museum-card sheen" style="padding: 48px;">
                    <span class="micro-label">Current Availability</span>
                    <h3 style="color: var(--gold); margin-bottom: 16px;">Limited to 3 Clients</h3>
                    <p style="color: var(--silver); font-size: 1rem; margin-bottom: 24px;">
                        This constraint ensures museum-quality research and bespoke system architecture for every engagement.
                    </p>
                    <div class="nested-content" style="border-left-color: rgba(201, 169, 97, 0.3);">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span style="color: var(--platinum);">Next opening: Q3 2026</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span style="color: var(--platinum);">Current waitlist: 6 weeks</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span style="color: var(--platinum);">Average engagement: 14 months</span>
                        </div>
                    </div>
                </div>
                <div class="image-frame" style="margin-top: 20px;">
                    <div class="prestige-image" style="aspect-ratio: 16/10;">
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=900&h=600&fit=crop" alt="Raw specimen">
                    </div>
                    <div class="image-caption">Raw emerald in matrix — Stage 1: Archaeology</div>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 2: The Three Stages — Horizontal Museum Display -->
    <section class="section-compact">
        <div style="text-align: center; margin-bottom: 80px;">
            <span class="prestige-label">The Process</span>
            <h2>From Raw to <span class="text-gold">Refined</span></h2>
        </div>
        
        <div class="asymmetric-3col">
            <!-- Stage 1 -->
            <div class="specimen-card" data-catalog="CAT-001-ARCH">
                <div class="specimen-header">
                    <span class="micro-label">Phase I</span>
                    <h3 style="color: var(--gold);">Archaeology</h3>
                </div>
                <div class="content-block">
                    <p>Deep excavation across public and private channels to recover abandoned marketing assets.</p>
                    <div class="nested-content">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Web archives & social history</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Private hard drives & CRM data</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Employee & founder interviews</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Competitive intelligence</span>
                        </div>
                    </div>
                </div>
                <div class="image-frame" style="margin-top: 32px;">
                    <div class="prestige-image" style="aspect-ratio: 4/3;">
                        <img src="https://images.unsplash.com/photo-1599707367072-cd6ada2bc375?w=400&h=300&fit=crop" alt="Excavation">
                    </div>
                </div>
            </div>
            
            <!-- Stage 2 -->
            <div class="specimen-card sheen" data-catalog="CAT-002-ALCH" style="transform: translateY(-20px);">
                <div class="specimen-header">
                    <span class="micro-label">Phase II</span>
                    <h3 style="color: var(--gold);">Alchemy</h3>
                </div>
                <div class="content-block">
                    <p>Transformation of historical assets into modern authority systems through voice extraction and channel translation.</p>
                    <div class="nested-content">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>8-dimension voice profiling</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Channel translation protocols</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>AI workflow architecture</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Content engine construction</span>
                        </div>
                    </div>
                </div>
                <div class="image-frame" style="margin-top: 32px;">
                    <div class="prestige-image" style="aspect-ratio: 4/3;">
                        <img src="https://images.unsplash.com/photo-1612817288484-6f916006741a?w=400&h=300&fit=crop" alt="Cut gem">
                    </div>
                </div>
            </div>
            
            <!-- Stage 3 -->
            <div class="specimen-card" data-catalog="CAT-003-PRST">
                <div class="specimen-header">
                    <span class="micro-label">Phase III</span>
                    <h3 style="color: var(--gold);">Prestige</h3>
                </div>
                <div class="content-block">
                    <p>Museum-quality presentation of your authority. Platform dominance, social proof systems, and conversion architecture.</p>
                    <div class="nested-content">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Platform authority establishment</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Social proof & case study systems</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Authority funnel engineering</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Ongoing amplification</span>
                        </div>
                    </div>
                </div>
                <div class="image-frame" style="margin-top: 32px;">
                    <div class="prestige-image" style="aspect-ratio: 4/3;">
                        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=400&h=300&fit=crop" alt="Polished">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 3: Services — Asymmetric with Feature Stacks -->
    <section class="section flow-gradient">
        <div class="flex-uneven">
            <div class="flex-major">
                <span class="prestige-label prestige-label-solo">Services</span>
                <h2 style="margin-bottom: 48px;">The Service <span class="text-gold">Ladder</span></h2>
                
                <div class="feature-stack">
                    <div class="feature-item">
                        <span class="feature-number">I</span>
                        <div class="feature-content">
                            <h4>Business History Audit</h4>
                            <p>5-7 day deep excavation. 40+ channels analyzed. 15-25 assets recovered. 10-page strategic report with video walkthrough. The foundation of all transformation.</p>
                            <div class="nested-content" style="margin-top: 16px;">
                                <div class="nested-item">
                                    <span class="nested-bullet"></span>
                                    <span style="color: var(--gold);">$2,000</span>
                                    <span style="color: var(--silver); margin-left: 8px;">one-time investment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-number">II</span>
                        <div class="feature-content">
                            <h4>Authority Systems Build</h4>
                            <p>21-day implementation. Four integrated content systems. AI workflow library. 20-30 page strategy documentation. Team training workshop. 90-day launch plan.</p>
                            <div class="nested-content" style="margin-top: 16px;">
                                <div class="nested-item">
                                    <span class="nested-bullet"></span>
                                    <span style="color: var(--gold);">$5,500</span>
                                    <span style="color: var(--silver); margin-left: 8px;">one-time investment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-number">III</span>
                        <div class="feature-content">
                            <h4>Amplification Partnership</h4>
                            <p>8 hours monthly. Weekly content review. Monthly strategy call. Performance optimization. Template updates. Quarterly refinement sessions. Priority access.</p>
                            <div class="nested-content" style="margin-top: 16px;">
                                <div class="nested-item">
                                    <span class="nested-bullet"></span>
                                    <span style="color: var(--gold);">$2,750</span>
                                    <span style="color: var(--silver); margin-left: 8px;">per month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feature-item" style="border-bottom: none;">
                        <span class="feature-number">IV</span>
                        <div class="feature-content">
                            <h4>Camera Authority Training</h4>
                            <p>16-hour intensive. On-camera foundations. Delivery naturalization. Technical excellence. Platform-specific optimization. From script anxiety to screen confidence.</p>
                            <div class="nested-content" style="margin-top: 16px;">
                                <div class="nested-item">
                                    <span class="nested-bullet"></span>
                                    <span style="color: var(--gold);">$3,750</span>
                                    <span style="color: var(--silver); margin-left: 8px;">one-time investment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-minor">
                <div class="museum-card sheen" style="padding: 48px; position: sticky; top: 40px;">
                    <span class="micro-label">Engagement Flow</span>
                    <h4 style="color: var(--gold); margin-bottom: 24px;">Typical Client Journey</h4>
                    <div class="content-block" style="gap: 32px;">
                        <div>
                            <span style="color: var(--gold-dim); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em;">Month 1</span>
                            <p style="margin-top: 8px; color: var(--platinum);">Audit delivery. Asset recovery. Strategy presentation.</p>
                        </div>
                        <div>
                            <span style="color: var(--gold-dim); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em;">Months 2-3</span>
                            <p style="margin-top: 8px; color: var(--platinum);">Systems build. Team training. Soft launch.</p>
                        </div>
                        <div>
                            <span style="color: var(--gold-dim); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em;">Months 4-14</span>
                            <p style="margin-top: 8px; color: var(--platinum);">Retainer partnership. Optimization. Scaling.</p>
                        </div>
                        <div>
                            <span style="color: var(--gold-dim); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em;">Month 15+</span>
                            <p style="margin-top: 8px; color: var(--platinum);">Graduation or renewal. System self-sufficiency.</p>
                        </div>
                    </div>
                    <div style="margin-top: 40px; padding-top: 32px; border-top: 1px solid rgba(201, 169, 97, 0.15);">
                        <p style="font-size: 0.95rem; color: var(--silver); font-style: italic;">
                            "80% of audit clients proceed to Systems Build. 90% of Build clients retain for 12+ months."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

 
body_content_4 = '''
    <!-- BLOCK 16: Cinematic Hero with Expansive Imagery -->
    <section class="section" style="padding: 0; position: relative; min-height: 100vh; display: flex; align-items: center;">
        <div style="position: absolute; inset: 0; z-index: 0;">
            <img src="https://images.unsplash.com/photo-1561214115-f2f134cc4912?w=1920&h=1080&fit=crop" 
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.4; filter: saturate(0.6) contrast(1.1);" 
                 alt="Museum interior">
            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, var(--obsidian) 0%, transparent 30%, transparent 70%, var(--obsidian) 100%);"></div>
        </div>
        <div class="container" style="position: relative; z-index: 1; max-width: 1400px;">
            <div style="display: flex; flex-direction: column; gap: 32px; max-width: 800px;">
                <span class="prestige-label prestige-label-solo" style="color: var(--gold-light);">Est. MMXXIV</span>
                <h1 style="font-size: clamp(3rem, 6vw, 5.5rem); letter-spacing: 0.15em;">
                    We Excavate<br>
                    <span style="color: var(--gold);">Buried Gold</span>
                </h1>
                <p style="font-size: 1.4rem; line-height: 1.9; color: var(--platinum); max-width: 600px;">
                    Business Archaeology & Authority Systems. Deep research across 40+ channels to recover proven marketing tactics you've abandoned—transformed into modern content engines.
                </p>
                <div style="display: flex; gap: 24px; margin-top: 24px; flex-wrap: wrap;">
                    <a href="#" class="btn-prestige btn-gold" style="padding: 20px 48px;">Begin Excavation</a>
                    <a href="#" class="btn-prestige btn-outline" style="padding: 20px 48px;">The Methodology</a>
                </div>
                <div style="display: flex; gap: 60px; margin-top: 60px; padding-top: 40px; border-top: 1px solid rgba(201, 169, 97, 0.2);">
                    <div>
                        <span style="font-family: 'Cinzel', serif; font-size: 2.5rem; color: var(--gold);">3</span>
                        <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--silver); margin-top: 8px;">Client Maximum</p>
                    </div>
                    <div>
                        <span style="font-family: 'Cinzel', serif; font-size: 2.5rem; color: var(--gold);">40+</span>
                        <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--silver); margin-top: 8px;">Channels</p>
                    </div>
                    <div>
                        <span style="font-family: 'Cinzel', serif; font-size: 2.5rem; color: var(--gold);">6</span>
                        <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--silver); margin-top: 8px;">Week Waitlist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 17: Fluid Asymmetric Process -->
    <section class="section flow-gradient">
        <div style="margin-bottom: 80px;">
            <span class="prestige-label">The Process</span>
            <h2 style="margin-top: 24px;">From Raw to <span style="color: var(--gold);">Refined</span></h2>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 100px;">
            <!-- Stage 1: Asymmetric Left -->
            <div style="display: flex; gap: 80px; align-items: center;">
                <div style="flex: 1.2; position: relative;">
                    <div class="image-frame" style="transform: rotate(-2deg);">
                        <div class="prestige-image sheen" style="aspect-ratio: 4/3;">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&h=600&fit=crop" alt="Raw specimen">
                        </div>
                    </div>
                    <div style="position: absolute; bottom: -30px; right: 40px; background: var(--obsidian); padding: 20px 30px; border: 1px solid rgba(201, 169, 97, 0.3);">
                        <span style="font-family: 'Inter', sans-serif; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--gold-dim);">Catalog</span>
                        <p style="font-family: 'Cinzel', serif; color: var(--gold); margin-top: 4px;">RAW-001</p>
                    </div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; gap: 24px;">
                    <div>
                        <span class="micro-label">Phase I</span>
                        <h3 style="color: var(--gold); margin-top: 12px;">Archaeology</h3>
                    </div>
                    <p style="color: var(--silver); line-height: 1.9; font-size: 1.1rem;">
                        Deep excavation across public and private channels. We recover abandoned marketing assets from web archives, old hard drives, and human memory.
                    </p>
                    <div class="nested-content" style="border-left-color: rgba(201, 169, 97, 0.2); margin-top: 8px;">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>40+ channel analysis</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Private archive recovery</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Stakeholder interviews</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Competitive intelligence</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stage 2: Asymmetric Right -->
            <div style="display: flex; gap: 80px; align-items: center; flex-direction: row-reverse;">
                <div style="flex: 1.2; position: relative;">
                    <div class="image-frame" style="transform: rotate(2deg);">
                        <div class="prestige-image sheen" style="aspect-ratio: 4/3;">
                            <img src="https://images.unsplash.com/photo-1612817288484-6f916006741a?w=800&h=600&fit=crop" alt="Cut gem">
                        </div>
                    </div>
                    <div style="position: absolute; bottom: -30px; left: 40px; background: var(--obsidian); padding: 20px 30px; border: 1px solid rgba(201, 169, 97, 0.3);">
                        <span style="font-family: 'Inter', sans-serif; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--gold-dim);">Catalog</span>
                        <p style="font-family: 'Cinzel', serif; color: var(--gold); margin-top: 4px;">CUT-002</p>
                    </div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; gap: 24px;">
                    <div>
                        <span class="micro-label">Phase II</span>
                        <h3 style="color: var(--gold); margin-top: 12px;">Alchemy</h3>
                    </div>
                    <p style="color: var(--silver); line-height: 1.9; font-size: 1.1rem;">
                        Transformation of historical assets into modern authority systems. Voice extraction, channel translation, and AI workflow architecture.
                    </p>
                    <div class="nested-content" style="border-left-color: rgba(201, 169, 97, 0.2); margin-top: 8px;">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>8-dimension voice profiling</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Channel translation protocols</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>AI workflow engineering</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Content engine construction</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stage 3: Asymmetric Left -->
            <div style="display: flex; gap: 80px; align-items: center;">
                <div style="flex: 1.2; position: relative;">
                    <div class="image-frame" style="transform: rotate(-1deg);">
                        <div class="prestige-image sheen" style="aspect-ratio: 4/3;">
                            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800&h=600&fit=crop" alt="Polished">
                        </div>
                    </div>
                    <div style="position: absolute; bottom: -30px; right: 40px; background: var(--obsidian); padding: 20px 30px; border: 1px solid rgba(201, 169, 97, 0.3);">
                        <span style="font-family: 'Inter', sans-serif; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--gold-dim);">Catalog</span>
                        <p style="font-family: 'Cinzel', serif; color: var(--gold); margin-top: 4px;">POL-003</p>
                    </div>
                </div>
                <div style="flex: 1; display: flex; flex-direction: column; gap: 24px;">
                    <div>
                        <span class="micro-label">Phase III</span>
                        <h3 style="color: var(--gold); margin-top: 12px;">Prestige</h3>
                    </div>
                    <p style="color: var(--silver); line-height: 1.9; font-size: 1.1rem;">
                        Museum-quality presentation of your authority. Platform dominance, social proof systems, and conversion architecture.
                    </p>
                    <div class="nested-content" style="border-left-color: rgba(201, 169, 97, 0.2); margin-top: 8px;">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Platform authority establishment</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Social proof & case study systems</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Authority funnel engineering</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Ongoing amplification</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 18: Museum Specimen Services -->
    <section class="section">
        <div style="margin-bottom: 80px;">
            <span class="prestige-label">Services</span>
            <h2 style="margin-top: 24px;">The Service <span style="color: var(--gold);">Collection</span></h2>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(12, 1fr); gap: 30px;">
            <!-- Service 1: Spans 5 columns -->
            <div class="specimen-card sheen" data-catalog="SVC-AUD-001" style="grid-column: span 5; display: flex; flex-direction: column;">
                <div class="specimen-header">
                    <span class="micro-label">Stage I</span>
                    <h3 style="color: var(--gold);">Business History Audit</h3>
                </div>
                <p style="color: var(--silver); line-height: 1.8; margin-bottom: 32px; flex-grow: 1;">
                    5-7 day deep excavation. 40+ channels analyzed. 15-25 assets recovered. 10-page strategic report with video walkthrough. The foundation of all transformation.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid rgba(201, 169, 97, 0.1);">
                    <span style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--gold);">$2,000</span>
                    <a href="#" class="btn-prestige btn-outline" style="padding: 12px 24px; font-size: 0.7rem;">Inquire</a>
                </div>
            </div>
            
            <!-- Service 2: Spans 7 columns -->
            <div class="specimen-card sheen" data-catalog="SVC-BLD-002" style="grid-column: span 7; display: flex; flex-direction: column; background: linear-gradient(135deg, rgba(201, 169, 97, 0.05) 0%, transparent 100%);">
                <div class="specimen-header">
                    <span class="micro-label">Stage II</span>
                    <h3 style="color: var(--gold);">Authority Systems Build</h3>
                </div>
                <div style="display: flex; gap: 60px; flex-grow: 1;">
                    <p style="color: var(--silver); line-height: 1.8; flex: 1;">
                        21-day implementation. Four integrated content systems. AI workflow library. 20-30 page strategy documentation. Team training workshop. 90-day launch plan.
                    </p>
                    <div class="nested-content" style="flex: 0.8; border-left-color: rgba(201, 169, 97, 0.15);">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Content Production Engine</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Publishing Rhythm Design</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Performance Feedback Loops</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Asset Library Architecture</span>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid rgba(201, 169, 97, 0.1); margin-top: 32px;">
                    <span style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--gold);">$5,500</span>
                    <a href="#" class="btn-prestige btn-gold" style="padding: 12px 24px; font-size: 0.7rem;">Inquire</a>
                </div>
            </div>
            
            <!-- Service 3: Spans 7 columns -->
            <div class="specimen-card sheen" data-catalog="SVC-RET-003" style="grid-column: span 7; display: flex; flex-direction: column;">
                <div class="specimen-header">
                    <span class="micro-label">Stage III</span>
                    <h3 style="color: var(--gold);">Amplification Partnership</h3>
                </div>
                <div style="display: flex; gap: 60px; flex-grow: 1;">
                    <p style="color: var(--silver); line-height: 1.8; flex: 1;">
                        8 hours monthly. Weekly content review. Monthly strategy call. Performance optimization. Template updates. Quarterly refinement. Priority access for evolving needs.
                    </p>
                    <div class="nested-content" style="flex: 0.8; border-left-color: rgba(201, 169, 97, 0.15);">
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Weekly Async Reviews</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Monthly Strategy Sessions</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>Quarterly Refinement</span>
                        </div>
                        <div class="nested-item">
                            <span class="nested-bullet"></span>
                            <span>24-Hour Response Guarantee</span>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid rgba(201, 169, 97, 0.1); margin-top: 32px;">
                    <span style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--gold);">$2,750<span style="font-size: 0.9rem; color: var(--silver);">/mo</span></span>
                    <a href="#" class="btn-prestige btn-outline" style="padding: 12px 24px; font-size: 0.7rem;">Inquire</a>
                </div>
            </div>
            
            <!-- Service 4: Spans 5 columns -->
            <div class="specimen-card sheen" data-catalog="SVC-CAM-004" style="grid-column: span 5; display: flex; flex-direction: column;">
                <div class="specimen-header">
                    <span class="micro-label">Specialized</span>
                    <h3 style="color: var(--gold);">Camera Authority</h3>
                </div>
                <p style="color: var(--silver); line-height: 1.8; margin-bottom: 32px; flex-grow: 1;">
                    16-hour intensive. On-camera foundations. Delivery naturalization. Technical excellence. Platform-specific optimization. From script anxiety to screen confidence.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid rgba(201, 169, 97, 0.1);">
                    <span style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: var(--gold);">$3,750</span>
                    <a href="#" class="btn-prestige btn-outline" style="padding: 12px 24px; font-size: 0.7rem;">Inquire</a>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 19: Immersive Case Study with Full-bleed Image -->
    <section class="section" style="padding: 0;">
        <div style="display: flex; min-height: 90vh;">
            <div style="flex: 1; position: relative; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200&h=900&fit=crop" 
                     style="width: 100%; height: 100%; object-fit: cover; filter: saturate(0.7) contrast(1.05);" 
                     alt="Manufacturing facility">
                <div style="position: absolute; inset: 0; background: linear-gradient(to right, transparent 0%, var(--obsidian) 100%);"></div>
            </div>
            <div style="flex: 1; padding: 100px 80px; display: flex; flex-direction: column; justify-content: center;">
                <span class="prestige-label">Case Study</span>
                <h2 style="margin-top: 24px; margin-bottom: 32px;">Richardson<br><span style="color: var(--gold);">Manufacturing</span></h2>
                <div class="prestige-quote" style="margin: 0; padding: 32px 0 32px 40px; border-left: 2px solid var(--gold);">
                    <p style="font-size: 1.3rem;">
                        "We had no idea we ran such sophisticated campaigns in 2008. The audit uncovered $6M in lost opportunity from tactics we abandoned. Within 90 days of implementing the modernized version, we saw a 40% increase in qualified leads."
                    </p>
                </div>
                <div style="margin-top: 40px; display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <span style="width: 60px; height: 1px; background: var(--gold);"></span>
                        <span style="color: var(--silver); font-size: 0.9rem;">Third-generation family business</span>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <span style="width: 60px; height: 1px; background: var(--gold);"></span>
                        <span style="color: var(--silver); font-size: 0.9rem;">$12M annual revenue</span>
                    </div>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <span style="width: 60px; height: 1px; background: var(--gold);"></span>
                        <span style="color: var(--silver); font-size: 0.9rem;">Abandoned trade show strategy recovered</span>
                    </div>
                </div>
                <div style="margin-top: 48px;">
                    <a href="#" class="btn-prestige btn-outline">Read Full Case Study</a>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 20: Interactive Comparison with Hover States -->
    <section class="section flow-gradient">
        <div style="margin-bottom: 80px;">
            <span class="prestige-label">Differentiation</span>
            <h2 style="margin-top: 24px;">Traditional vs <span style="color: var(--gold);">Archaeology</span></h2>
        </div>
        
        <div style="display: flex; gap: 0; border: 1px solid rgba(201, 169, 97, 0.15);">
            <div style="flex: 1; padding: 60px; background: var(--obsidian-lighter); border-right: 1px solid rgba(201, 169, 97, 0.1);">
                <span class="micro-label" style="color: var(--silver);">Conventional Approach</span>
                <h4 style="margin-top: 16px; margin-bottom: 40px; color: var(--silver);">Traditional Marketing</h4>
                <div class="feature-stack" style="gap: 24px;">
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--silver); font-size: 0.9rem;">Competitor analysis and trend chasing</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--silver); font-size: 0.9rem;">Generic best practices applied uniformly</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--silver); font-size: 0.9rem;">Template-based content production</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--silver); font-size: 0.9rem;">Ad-hoc campaign management</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--silver); font-size: 0.9rem;">20-50 clients per account manager</span>
                    </div>
                </div>
            </div>
            <div style="flex: 1; padding: 60px; background: linear-gradient(135deg, rgba(201, 169, 97, 0.03) 0%, transparent 100%); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(201, 169, 97, 0.05) 0%, transparent 50%); animation: flow 15s ease-in-out infinite;"></div>
                <span class="micro-label">Our Method</span>
                <h4 style="margin-top: 16px; margin-bottom: 40px; color: var(--gold);">Business Archaeology</h4>
                <div class="feature-stack" style="gap: 24px; position: relative; z-index: 1;">
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--platinum); font-size: 0.9rem;">Historical excavation across 40+ channels</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--platinum); font-size: 0.9rem;">Proven tactics from your golden era</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--platinum); font-size: 0.9rem;">8-dimension voice extraction & replication</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--platinum); font-size: 0.9rem;">4 integrated systems that compound</span>
                    </div>
                    <div class="feature-item" style="padding: 0; border: none;">
                        <span style="color: var(--platinum); font-size: 0.9rem;">Maximum 3 clients for true partnership</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="prestige-divider"></div>

    <!-- BLOCK 21: CTA with Expansive Background -->
    <section class="section" style="padding: 0; position: relative; min-height: 70vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <div style="position: absolute; inset: 0;">
            <img src="https://images.unsplash.com/photo-1554907984-15263bfd63bd?w=1920&h=1080&fit=crop" 
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.25; filter: saturate(0.5);" 
                 alt="Museum gallery">
            <div style="position: absolute; inset: 0; background: radial-gradient(circle at center, transparent 0%, var(--obsidian) 70%);"></div>
        </div>
        <div style="position: relative; z-index: 1; text-align: center; max-width: 800px; padding: 80px;">
            <span class="prestige-label" style="justify-content: center;">Limited Availability</span>
            <h2 style="margin: 32px 0; font-size: clamp(2rem, 4vw, 3rem);">
                Ready to Excavate Your<br><span style="color: var(--gold);">Buried Gold?</span>
            </h2>
            <p style="color: var(--silver); font-size: 1.2rem; line-height: 1.8; margin-bottom: 40px;">
                Currently serving 3 clients. Next opening: Q3 2026.<br>
                Join the waitlist or schedule a 15-minute fit conversation.
            </p>
            <div style="display: flex; gap: 24px; justify-content: center; flex-wrap: wrap;">
                <a href="#" class="btn-prestige btn-gold" style="padding: 20px 48px;">Schedule Consultation</a>
                <a href="#" class="btn-prestige btn-outline" style="padding: 20px 48px;">Join Waitlist</a>
            </div>
        </div>
    </section>

    <!-- BLOCK 22: Footer -->
    <footer style="background-color: var(--obsidian-light); border-top: 1px solid rgba(201, 169, 97, 0.1); padding: 80px;">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 60px;">
            <div style="flex: 1; min-width: 300px;">
                <h4 style="color: var(--gold); margin-bottom: 24px; font-size: 1.2rem;">CarrAI.site</h4>
                <p style="color: var(--silver); line-height: 1.8; font-size: 1rem;">
                    Business Archaeology & Authority Systems.<br>
                    Excavating buried marketing gold since 2024.
                </p>
                <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid rgba(201, 169, 97, 0.1);">
                    <p style="color: var(--gold); font-size: 0.85rem; letter-spacing: 0.1em;">Limited to 3 clients</p>
                    <p style="color: var(--gold-dim); font-size: 0.85rem; margin-top: 4px;">Current wait: 6 weeks</p>
                </div>
            </div>
            <div style="display: flex; gap: 80px; flex-wrap: wrap;">
                <div>
                    <h5 style="color: var(--platinum); margin-bottom: 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.15em;">Services</h5>
                    <ul style="list-style: none; color: var(--silver); font-size: 0.95rem; line-height: 2.2;">
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Business History Audit</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Authority Systems Build</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Amplification Partnership</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Camera Authority</a></li>
                    </ul>
                </div>
                <div>
                    <h5 style="color: var(--platinum); margin-bottom: 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.15em;">Resources</h5>
                    <ul style="list-style: none; color: var(--silver); font-size: 0.95rem; line-height: 2.2;">
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Case Studies</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Methodology</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">Industry Playbooks</a></li>
                        <li><a href="#" style="color: var(--silver); text-decoration: none;">The Dispatch</a></li>
                    </ul>
                </div>
                <div>
                    <h5 style="color: var(--platinum); margin-bottom: 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.15em;">Contact</h5>
                    <ul style="list-style: none; color: var(--silver); font-size: 0.95rem; line-height: 2.2;">
                        <li>john@carrai.site</li>
                        <li>Schedule a Call</li>
                    </ul>
                </div>
            </div>
        </div>
        <div style="max-width: 1400px; margin: 80px auto 0; padding-top: 40px; border-top: 1px solid rgba(201, 169, 97, 0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <p style="color: var(--silver); font-size: 0.8rem;">© MMXXVI CarrAI.site. All rights reserved.</p>
            <div style="display: flex; gap: 32px;">
                <a href="#" style="color: var(--silver); font-size: 0.8rem; text-decoration: none;">Privacy</a>
                <a href="#" style="color: var(--silver); font-size: 0.8rem; text-decoration: none;">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>

  


