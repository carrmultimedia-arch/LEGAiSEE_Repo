
<!DOCTYPE html>
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
            content: "—";
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
            content: "—";
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
    </style>
</head>
<body>

    <!-- BLOCK 1: Hero Section -->
    <section class="section">
        <div class="container text-center">
            <span class="label">Business Archaeology & Authority Systems</span>
            <h1 style="margin-bottom: 24px;">Excavate your buried<br><span class="text-gold">marketing gold</span></h1>
            <p style="font-size: 1.25rem; color: var(--gray); max-width: 700px; margin: 0 auto 40px;">
                We dig through 40+ years of your business history to find the <strong style="color: var(--white);">proven tactics</strong> 
                you've abandoned—then transform them into modern authority systems.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="#" class="btn btn-primary">Begin Excavation</a>
                <a href="#" class="btn btn-outline">View Methodology</a>
            </div>
        </div>
    </section>

    <!-- BLOCK 2: Service Cards (3-Column) -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="grid-3">
                <div class="service-card" data-label="Flagship">
                    <h3 style="margin-bottom: 16px;">Business Archaeology Audit</h3>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        Deep excavation across 40+ channels to find your abandoned marketing gold. 
                        Public records, private archives, and human intelligence.
                    </p>
                    <ul class="feature-list">
                        <li>40+ channel analysis</li>
                        <li>Historical asset recovery</li>
                        <li>Competitive gap mapping</li>
                        <li>10-page strategic report</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="margin-top: 24px; width: 100%; justify-content: center;">Explore Audit</a>
                </div>
                
                <div class="service-card" data-label="Advisory">
                    <h3 style="margin-bottom: 16px;">Authority Systems Build</h3>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        Transform historical assets into modern content engines and publishing rhythms. 
                        Four integrated systems that compound over time.
                    </p>
                    <ul class="feature-list">
                        <li>Content production engine</li>
                        <li>Publishing rhythm design</li>
                        <li>Performance feedback loops</li>
                        <li>Asset library architecture</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="margin-top: 24px; width: 100%; justify-content: center;">Explore Systems</a>
                </div>
                
                <div class="service-card" data-label="Experience">
                    <h3 style="margin-bottom: 16px;">Camera Authority Training</h3>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        On-camera presence for the authority economy. From script to screen, 
                        we build your video confidence and production quality.
                    </p>
                    <ul class="feature-list">
                        <li>On-camera foundations</li>
                        <li>Delivery naturalization</li>
                        <li>Technical excellence</li>
                        <li>Platform optimization</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="margin-top: 24px; width: 100%; justify-content: center;">Explore Training</a>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 3: Split Layout with Image -->
    <section class="section">
        <div class="container">
            <div class="split-layout">
                <div class="split-content">
                    <span class="label">Stage 1: Raw</span>
                    <h2 style="margin-bottom: 24px;">The <span class="text-gold">Archaeology</span> Process</h2>
                    <p style="color: var(--gray-light); margin-bottom: 24px; font-size: 1.1rem;">
                        We dig deeper than any agency. Public records, private archives, employee interviews, 
                        and competitor intelligence to reconstruct what actually worked.
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <span style="color: var(--gold); font-weight: 600;">01</span>
                            <div>
                                <h4 style="margin-bottom: 8px;">Public Excavation</h4>
                                <p style="color: var(--gray); font-size: 0.9rem;">Web archives, social media history, YouTube commercials, print ads, news coverage.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <span style="color: var(--gold); font-weight: 600;">02</span>
                            <div>
                                <h4 style="margin-bottom: 8px;">Private Archives</h4>
                                <p style="color: var(--gray); font-size: 0.9rem;">Old hard drives, email campaigns, CRM exports, design files from previous eras.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <span style="color: var(--gold); font-weight: 600;">03</span>
                            <div>
                                <h4 style="margin-bottom: 8px;">Human Intelligence</h4>
                                <p style="color: var(--gray); font-size: 0.9rem;">Interviews with former employees, founders, and customers who experienced your golden era.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="split-media">
                    <div class="img-container" style="aspect-ratio: 4/3;">
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&h=600&fit=crop" alt="Raw Emerald in Rock Matrix">
                    </div>
                    <div style="text-align: center; margin-top: 16px;">
                        <span class="text-gray" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em;">Raw Emerald in Rock Matrix</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 4: Process Phase Cards -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">The Transformation</span>
                <h2>The <span class="text-gold">Alchemy</span> of Modernization</h2>
            </div>
            <div class="grid-3">
                <div class="phase-card">
                    <span class="phase-number">01</span>
                    <span class="label">Modernization</span>
                    <h3 style="margin-bottom: 16px;">Channel Translation</h3>
                    <p style="color: var(--gray-light);">
                        Print ads become Instagram carousels. Radio spots become podcast host reads. 
                        Direct mail becomes email sequences. Same psychology, modern execution.
                    </p>
                </div>
                
                <div class="phase-card">
                    <span class="phase-number">02</span>
                    <span class="label">Voice</span>
                    <h3 style="margin-bottom: 16px;">Authority Replication</h3>
                    <p style="color: var(--gray-light);">
                        Extract your unique communication DNA across 8 dimensions—vocabulary, sentence structure, 
                        humor, perspective—and encode it for AI-powered content systems.
                    </p>
                </div>
                
                <div class="phase-card">
                    <span class="phase-number">03</span>
                    <span class="label">Systems</span>
                    <h3 style="margin-bottom: 16px;">Content Engines</h3>
                    <p style="color: var(--gray-light);">
                        Four integrated systems that compound over time: production, publishing, 
                        feedback loops, and asset libraries working in harmony.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 5: Stats Row -->
    <section class="section-sm">
        <div class="container">
            <div class="grid-4" style="border-top: 1px solid rgba(212, 175, 55, 0.1); border-bottom: 1px solid rgba(212, 175, 55, 0.1); padding: 40px 0;">
                <div class="stat-item">
                    <span class="stat-number">40+</span>
                    <span class="stat-label">Channels Excavated</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">15-25</span>
                    <span class="stat-label">Assets Recovered</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3</span>
                    <span class="stat-label">Client Maximum</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">6</span>
                    <span class="stat-label">Week Waitlist</span>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 6: Testimonial -->
    <section class="section">
        <div class="container" style="max-width: 900px;">
            <div class="testimonial">
                <p class="testimonial-text">
                    "I had no idea we used to run such sophisticated campaigns. The Business Archaeology Audit 
                    uncovered $6M in lost opportunity from tactics we abandoned in 2012. Within 90 days of 
                    implementing the modernized version, we saw a 40% increase in qualified leads."
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">SR</div>
                    <div class="author-info">
                        <h4>Sarah Richardson</h4>
                        <p>CEO, Richardson Manufacturing • Third Generation</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 7: Pricing Cards -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Investment</span>
                <h2>The <span class="text-gold">Service</span> Ladder</h2>
                <p style="color: var(--gray); margin-top: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">
                    Each stage builds upon the last. Most clients begin with the Audit, 
                    proceed to Systems Build, then retain for ongoing amplification.
                </p>
            </div>
            <div class="grid-3" style="align-items: start;">
                <div class="pricing-card">
                    <span class="label">Stage 1</span>
                    <h3>Business History Audit</h3>
                    <div class="price">$2,000<span> / one-time</span></div>
                    <ul class="feature-list" style="text-align: left;">
                        <li>5-7 day delivery</li>
                        <li>40+ channel excavation</li>
                        <li>15-25 asset documentation</li>
                        <li>10-page strategic report</li>
                        <li>Video walkthrough</li>
                        <li>Asset portfolio</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="margin-top: 24px; width: 100%; justify-content: center;">Select Audit</a>
                </div>
                
                <div class="pricing-card featured">
                    <span class="label">Stage 2</span>
                    <h3>Authority Systems Build</h3>
                    <div class="price">$5,500<span> / one-time</span></div>
                    <ul class="feature-list" style="text-align: left;">
                        <li>21-day implementation</li>
                        <li>4 core content systems</li>
                        <li>AI workflow library</li>
                        <li>20-30 page strategy doc</li>
                        <li>15-20 templates</li>
                        <li>Team training workshop</li>
                        <li>90-day launch plan</li>
                    </ul>
                    <a href="#" class="btn btn-primary" style="margin-top: 24px; width: 100%; justify-content: center;">Select Build</a>
                </div>
                
                <div class="pricing-card">
                    <span class="label">Stage 3</span>
                    <h3>Amplification Partnership</h3>
                    <div class="price">$2,750<span> / month</span></div>
                    <ul class="feature-list" style="text-align: left;">
                        <li>8 hours monthly</li>
                        <li>Weekly content review</li>
                        <li>Monthly strategy call</li>
                        <li>Performance optimization</li>
                        <li>Template updates</li>
                        <li>Trend intelligence</li>
                        <li>Quarterly refinement</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="margin-top: 24px; width: 100%; justify-content: center;">Select Retainer</a>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 8: Comparison Table -->
    <section class="section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Why Business Archaeology</span>
                <h2>Traditional Agency <span class="text-gold">vs</span> Our Method</h2>
            </div>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Approach</th>
                        <th style="width: 30%;">Traditional Marketing</th>
                        <th style="width: 30%; color: var(--gold);">Business Archaeology</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Starting Point</td>
                        <td>"What should you do?"</td>
                        <td class="check">"What made you great?"</td>
                    </tr>
                    <tr>
                        <td>Research Depth</td>
                        <td>Competitor analysis, trends</td>
                        <td class="check">40+ historical channels, private archives</td>
                    </tr>
                    <tr>
                        <td>Strategy Source</td>
                        <td>Generic best practices</td>
                        <td class="check">Your proven historical assets</td>
                    </tr>
                    <tr>
                        <td>Voice & Style</td>
                        <td>Template-based content</td>
                        <td class="check">8-dimension voice extraction</td>
                    </tr>
                    <tr>
                        <td>Systems</td>
                        <td>Ad-hoc campaigns</td>
                        <td class="check">4 integrated content engines</td>
                    </tr>
                    <tr>
                        <td>Results Timeline</td>
                        <td>6-12 months to validate</td>
                        <td class="check">Proven tactics, faster execution</td>
                    </tr>
                    <tr>
                        <td>Client Load</td>
                        <td>20-50 clients per account</td>
                        <td class="check">Maximum 3 clients</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- BLOCK 9: Timeline -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">The Journey</span>
                <h2>From <span class="text-gold">Excavation</span> to Authority</h2>
            </div>
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">Week 1</div>
                        <h4 style="margin-bottom: 8px;">The Audit Begins</h4>
                        <p style="color: var(--gray-light);">Multi-AI excavation across public and private channels. 
                        We interview stakeholders, recover lost assets, and map your competitive history.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">Week 2</div>
                        <h4 style="margin-bottom: 8px;">Analysis & Strategy</h4>
                        <p style="color: var(--gray-light);">Synthesis of findings, voice extraction, and modernization roadmap. 
                        You receive the 10-page report and asset portfolio.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">Weeks 3-5</div>
                        <h4 style="margin-bottom: 8px;">Systems Architecture</h4>
                        <p style="color: var(--gray-light);">Build the four core systems: production engine, publishing rhythm, 
                        feedback loops, and asset library. Train your team on workflows.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">Week 6</div>
                        <h4 style="margin-bottom: 8px;">Launch & Handoff</h4>
                        <p style="color: var(--gray-light);">Soft launch with first content cycle. Documentation finalized. 
                        Transition to retainer partnership or self-sufficient operation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 10: FAQ Accordion -->
    <section class="section">
        <div class="container" style="max-width: 800px;">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Common Questions</span>
                <h2>Frequently <span class="text-gold">Asked</span></h2>
            </div>
            <div class="faq-item active">
                <div class="faq-question">What exactly is Business Archaeology?</div>
                <div class="faq-answer">
                    Business Archaeology is the systematic excavation of your company's marketing history 
                    to find proven tactics you've abandoned. We research 40+ channels—public records, 
                    private archives, employee interviews—to reconstruct what actually worked during 
                    your golden era, then modernize those tactics for today's platforms.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">How is this different from a marketing audit?</div>
                <div class="faq-answer">
                    Traditional audits analyze your current marketing and competitors. Business Archaeology 
                    digs into your past to find assets you've forgotten or abandoned. We don't guess what 
                    might work—we find what already worked and transform it for modern execution.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">What if we don't have old marketing materials?</div>
                <div class="faq-answer">
                    Most businesses have more than they realize. We access web archives, interview former 
                    employees, search YouTube for old commercials, and dig into public records. Even 
                    without physical archives, we can reconstruct your history through competitive 
                    intelligence and industry context.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">Why are you limited to 3 clients?</div>
                <div class="faq-answer">
                    Business Archaeology requires deep research—20-40 hours per audit. To maintain 
                    quality and deliver results, I limit concurrent engagements. This also creates 
                    scarcity that benefits clients: you receive priority attention and faster turnaround.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">Do you work with startups or new businesses?</div>
                <div class="faq-answer">
                    No. Business Archaeology requires historical depth. I work with established businesses 
                    (5+ years, $500K+ revenue) that have abandoned proven tactics while chasing trends. 
                    Startups benefit more from traditional strategy work.
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 11: Navigation Pills -->
    <section class="section-sm" style="background-color: var(--black-light);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 40px;">
                <span class="label">Explore</span>
                <h3 style="margin-top: 16px;">Navigate by <span class="text-gold">Industry</span></h3>
            </div>
            <div class="nav-pills">
                <a href="#" class="nav-pill active">Manufacturing</a>
                <a href="#" class="nav-pill">Professional Services</a>
                <a href="#" class="nav-pill">Healthcare</a>
                <a href="#" class="nav-pill">Retail & E-commerce</a>
                <a href="#" class="nav-pill">Local Services</a>
                <a href="#" class="nav-pill">B2B Technology</a>
            </div>
        </div>
    </section>

    <!-- BLOCK 12: Feature Grid with Icons -->
    <section class="section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Capabilities</span>
                <h2>What We <span class="text-gold">Excavate</span></h2>
            </div>
            <div class="grid-4">
                <div class="card text-center">
                    <div style="width: 60px; height: 60px; margin: 0 auto 20px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📺</div>
                    <h4 style="margin-bottom: 12px;">Broadcast</h4>
                    <p style="color: var(--gray); font-size: 0.9rem;">TV commercials, radio spots, cable advertising history</p>
                </div>
                <div class="card text-center">
                    <div style="width: 60px; height: 60px; margin: 0 auto 20px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📰</div>
                    <h4 style="margin-bottom: 12px;">Print</h4>
                    <p style="color: var(--gray); font-size: 0.9rem;">Newspaper ads, magazine placements, direct mail</p>
                </div>
                <div class="card text-center">
                    <div style="width: 60px; height: 60px; margin: 0 auto 20px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💻</div>
                    <h4 style="margin-bottom: 12px;">Digital</h4>
                    <p style="color: var(--gray); font-size: 0.9rem;">Website archives, email campaigns, early social</p>
                </div>
                <div class="card text-center">
                    <div style="width: 60px; height: 60px; margin: 0 auto 20px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📁</div>
                    <h4 style="margin-bottom: 12px;">Private</h4>
                    <p style="color: var(--gray); font-size: 0.9rem;">CRM data, internal files, employee interviews</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 13: CTA Section -->
    <section class="section">
        <div class="container">
            <div class="cta-section">
                <span class="label">Limited Availability</span>
                <h2 style="margin: 24px 0; position: relative; z-index: 1;">Ready to excavate your <span class="text-gold">buried gold</span>?</h2>
                <p style="color: var(--gray-light); max-width: 600px; margin: 0 auto 32px; position: relative; z-index: 1;">
                    Currently serving 3 clients. Next opening: Q3 2026. 
                    Join the waitlist or schedule a 15-minute fit conversation.
                </p>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1;">
                    <a href="#" class="btn btn-primary">Schedule Consultation</a>
                    <a href="#" class="btn btn-outline">Join Waitlist</a>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 14: Split Layout Reversed -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="split-layout">
                <div class="split-media">
                    <div class="img-container" style="aspect-ratio: 1/1;">
                        <img src="https://images.unsplash.com/photo-1612817288484-6f916006741a?w=600&h=600&fit=crop" alt="Polished Gemstone">
                    </div>
                    <div style="text-align: center; margin-top: 16px;">
                        <span class="text-gray" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em;">Cut & Faceted Emerald</span>
                    </div>
                </div>
                <div class="split-content">
                    <span class="label">Stage 2: Cut</span>
                    <h2 style="margin-bottom: 24px;">The <span class="text-gold">Alchemy</span> Process</h2>
                    <p style="color: var(--gray-light); margin-bottom: 32px; font-size: 1.1rem;">
                        Raw historical assets are worthless without modern transformation. 
                        We cut and polish proven tactics for today's platforms.
                    </p>
                    <div class="badge">
                        <span>Channel Translation</span>
                    </div>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        Print ads become Instagram carousels. Radio spots become podcast host reads. 
                        Direct mail becomes email sequences. Same psychology, modern execution.
                    </p>
                    <div class="badge">
                        <span>Voice Extraction</span>
                    </div>
                    <p style="color: var(--gray-light);">
                        We analyze your best content across 8 dimensions—vocabulary, sentence structure, 
                        humor, perspective—and encode it for AI-powered replication.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 15: Team/People Grid -->
    <section class="section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Who We Are</span>
                <h2>The <span class="text-gold">Principles</span></h2>
            </div>
            <div class="grid-3">
                <div class="card text-center">
                    <div style="width: 120px; height: 120px; margin: 0 auto 24px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-dark), var(--gold)); display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--black);">JC</div>
                    <h3 style="margin-bottom: 8px;">John Carr</h3>
                    <p style="color: var(--gold); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">Chief Archaeologist</p>
                    <p style="color: var(--gray); font-size: 0.9rem;">
                        15 years excavating business history. Former agency strategist, 
                        now focused entirely on the archaeology of proven marketing.
                    </p>
                </div>
                <div class="card text-center">
                    <div style="width: 120px; height: 120px; margin: 0 auto 24px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-dark), var(--gold)); display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--black);">MA</div>
                    <h3 style="margin-bottom: 8px;">Maya Anderson</h3>
                    <p style="color: var(--gold); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">Systems Architect</p>
                    <p style="color: var(--gray); font-size: 0.9rem;">
                        Builds the content engines and publishing rhythms that transform 
                        historical assets into modern authority systems.
                    </p>
                </div>
                <div class="card text-center">
                    <div style="width: 120px; height: 120px; margin: 0 auto 24px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-dark), var(--gold)); display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--black);">DK</div>
                    <h3 style="margin-bottom: 8px;">David Kim</h3>
                    <p style="color: var(--gold); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 16px;">Camera Authority</p>
                    <p style="color: var(--gray); font-size: 0.9rem;">
                        On-camera coach and production specialist. Transforms executives 
                        into confident video authorities for the modern economy.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 16: Case Study Preview -->
    <section class="section" style="background-color: var(--black-light);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="label">Results</span>
                <h2>Recent <span class="text-gold">Excavations</span></h2>
            </div>
            <div class="grid-2">
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 24px;">
                        <div>
                            <span class="label" style="margin-bottom: 8px;">Manufacturing</span>
                            <h3>Richardson Manufacturing</h3>
                        </div>
                        <span style="color: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.5rem;">+40%</span>
                    </div>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        Uncovered abandoned trade show strategy from 2008. Modernized as 
                        webinar series and LinkedIn authority campaign. 40% increase in 
                        qualified leads within 90 days.
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">Trade Shows</span>
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">Webinars</span>
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">LinkedIn</span>
                    </div>
                </div>
                
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 24px;">
                        <div>
                            <span class="label" style="margin-bottom: 8px;">Legal Services</span>
                            <h3>Hartwell & Associates</h3>
                        </div>
                        <span style="color: var(--gold); font-family: 'Playfair Display', serif; font-size: 1.5rem;">3x</span>
                    </div>
                    <p style="color: var(--gray-light); margin-bottom: 24px;">
                        Recovered 1990s educational seminar model. Transformed into 
                        YouTube authority channel and automated email sequences. 
                        Tripled consultation bookings in 6 months.
                    </p>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">Seminars</span>
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">YouTube</span>
                        <span style="padding: 6px 12px; background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.2); font-size: 0.75rem; color: var(--gold);">Email</span>
                    </div>
                </div>
            </div>
            <div class="text-center" style="margin-top: 40px;">
                <a href="#" class="btn btn-outline">View All Case Studies</a>
            </div>
        </div>
    </section>

    <!-- BLOCK 17: Newsletter/Email Capture -->
    <section class="section-sm">
        <div class="container">
            <div style="background-color: var(--black-light); border: 1px solid rgba(212, 175, 55, 0.1); padding: 60px;">
                <div class="grid-2" style="align-items: center; gap: 60px;">
                    <div>
                        <span class="label">Stay Informed</span>
                        <h3 style="margin: 16px 0;">The <span class="text-gold">Archaeology</span> Dispatch</h3>
                        <p style="color: var(--gray-light);">
                            Monthly insights on excavating business history, modernizing proven tactics, 
                            and building authority systems. No trends, no fluff—just proven methodology.
                        </p>
                    </div>
                    <div>
                        <form style="display: flex; flex-direction: column; gap: 16px;">
                            <input type="email" placeholder="Enter your email" style="padding: 16px; background-color: var(--black); border: 1px solid rgba(212, 175, 55, 0.2); color: var(--white); font-family: 'Inter', sans-serif; font-size: 0.9rem;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Subscribe</button>
                        </form>
                        <p style="color: var(--gray); font-size: 0.75rem; margin-top: 16px; text-align: center;">
                            Unsubscribe anytime. We respect your privacy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOCK 18: Footer -->
    <footer class="section" style="background-color: var(--black-light); border-top: 1px solid rgba(212, 175, 55, 0.1);">
        <div class="container">
            <div class="grid-4" style="margin-bottom: 60px;">
                <div>
                    <h4 style="margin-bottom: 24px; color: var(--gold);">CarrAI.site</h4>
                    <p style="color: var(--gray); font-size: 0.9rem; line-height: 1.8;">
                        Business Archaeology & Authority Systems.<br>
                        Excavating buried marketing gold since 2024.
                    </p>
                </div>
                <div>
                    <h4 style="margin-bottom: 24px; font-size: 1rem;">Services</h4>
                    <ul style="list-style: none; color: var(--gray); font-size: 0.9rem; line-height: 2;">
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Business History Audit</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Authority Systems Build</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Camera Authority Training</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Ongoing Partnership</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 24px; font-size: 1rem;">Resources</h4>
                    <ul style="list-style: none; color: var(--gray); font-size: 0.9rem; line-height: 2;">
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Case Studies</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Methodology</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">Industry Playbooks</a></li>
                        <li><a href="#" style="color: var(--gray); text-decoration: none;">The Dispatch</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 24px; font-size: 1rem;">Contact</h4>
                    <ul style="list-style: none; color: var(--gray); font-size: 0.9rem; line-height: 2;">
                        <li>john@carrai.site</li>
                        <li>Schedule a Call</li>
                        <li style="margin-top: 16px; color: var(--gold);">Limited to 3 clients</li>
                        <li style="color: var(--gold);">Current wait: 6 weeks</li>
                    </ul>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <p style="color: var(--gray); font-size: 0.8rem;">
                    © 2026 CarrAI.site. All rights reserved.
                </p>
                <div style="display: flex; gap: 24px;">
                    <a href="#" style="color: var(--gray); font-size: 0.8rem; text-decoration: none;">Privacy</a>
                    <a href="#" style="color: var(--gray); font-size: 0.8rem; text-decoration: none;">Terms</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>



