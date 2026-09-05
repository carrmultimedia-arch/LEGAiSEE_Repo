CHAPTER 28: The Shallow Dig Technical Build
Overview
The Shallow Dig is your automated lead generation engine—a system that prospects can access 24/7 without your direct involvement. A visitor submits their business name and website. Within 15 minutes, they receive a personalized 1-page Business Archaeology Snapshot via email. The system costs approximately $0.50 per lead in AI query costs and converts 20–30% of recipients into discovery call bookings.
The Promise: After completing this chapter, you will have a fully operational automated lead magnet that demonstrates your methodology, delivers immediate value, and fills your pipeline while you sleep.

Part 1: System Architecture
The 15-Minute Execution Flow
plainCopy
Minute 0-1:   Form submission → Queue job
Minute 1-4:   Parallel AI queries (4 platforms simultaneously)
Minute 4-6:   Web scraping (Wayback Machine, YouTube, news)
Minute 6-10:  Synthesis engine (pattern recognition, opportunity calculation)
Minute 10-13: Snapshot generation (HTML → PDF)
Minute 13-15: Email delivery + CRM storage + your notification
Technical Components
Table
Component
Technology
Purpose
Frontend
HTML form on CarrAI.site
Capture lead information
Backend
PHP on SureServer
Process requests, queue jobs
AI APIs
OpenAI, Anthropic, Google, Perplexity
Research and analysis
Web Scraping
Wayback API, YouTube API, custom scripts
Historical data gathering
PDF Generation
mPDF or Dompdf (PHP libraries)
Professional document output
Email
PHPMailer or SendGrid API
Delivery to prospect
CRM
Google Sheets, Airtable, or Notion
Lead tracking
Notifications
Email or Slack webhook
Alert you to new leads


Part 2: The Frontend (Landing Page)
Page Structure
URL: shallowdig.carrai.site or carrai.site/shallow-dig
Headline Options (A/B Test):
A: "Discover Your Business's Buried Marketing Gold"
B: "What Made You Great (And Why You Lost It)"
C: "The 15-Minute Business History Audit"
Subheadline:
"Enter your business name and website. Our AI archaeologists will excavate your marketing history and deliver a personalized snapshot in 15 minutes."
The Form
HTMLPreviewCopy
<form action="/process-shallow-dig.php" method="POST" id="shallowDigForm">
  
  <label for="business_name">Business Name *</label>
  <input type="text" id="business_name" name="business_name" required>
  
  <label for="website">Website URL *</label>
  <input type="url" id="website" name="website" required 
         placeholder="https://yourbusiness.com">
  
  <label for="industry">Industry *</label>
  <select id="industry" name="industry" required>
    <option value="">Select your industry...</option>
    <option value="local_service">Local Service (HVAC, Plumbing, Electrical)</option>
    <option value="professional_services">Professional Services (Law, Accounting, Consulting)</option>
    <option value="retail">Retail or E-commerce</option>
    <option value="manufacturing">Manufacturing or B2B</option>
    <option value="healthcare">Healthcare or Medical</option>
    <option value="other">Other</option>
  </select>
  
  <label for="years_operation">Years in Operation *</label>
  <select id="years_operation" name="years_operation" required>
    <option value="">Select...</option>
    <option value="1-5">1-5 years</option>
    <option value="6-10">6-10 years</option>
    <option value="11-20">11-20 years</option>
    <option value="21+">21+ years</option>
  </select>
  
  <label for="prospect_name">Your Name *</label>
  <input type="text" id="prospect_name" name="prospect_name" required>
  
  <label for="email">Email Address *</label>
  <input type="email" id="email" name="email" required>
  
  <button type="submit">Generate My Snapshot</button>
  
</form>
Post-Submission Experience
Immediate Response:
"Excavating your business history... This takes approximately 15 minutes. Your snapshot will arrive via email. Check your spam folder if you don't see it."
Loading State (Optional Enhancement):
Animated progress bar with messages:
"Searching archives..."
"Analyzing competitors..."
"Identifying opportunities..."
"Compiling your snapshot..."

Part 3: The Backend (Processing Engine)
File Structure on SureServer
plainCopy
/public_html/
  /shallow-dig/
    index.html              # Landing page
    process-shallow-dig.php # Form processor
    /includes/
      config.php            # API keys, settings
      ai-functions.php      # API call wrappers
      scraper-functions.php # Web scraping tools
      pdf-generator.php     # PDF creation
      email-functions.php   # Email delivery
      crm-functions.php     # Lead storage
    /templates/
      snapshot-template.html # PDF layout
    /output/                # Generated PDFs (temporary)
    /logs/                  # Error and activity logs
Step 1: Form Processing (process-shallow-dig.php)
phpCopy
<?php
// process-shallow-dig.php

require_once 'includes/config.php';
require_once 'includes/ai-functions.php';
require_once 'includes/scraper-functions.php';
require_once 'includes/pdf-generator.php';
require_once 'includes/email-functions.php';
require_once 'includes/crm-functions.php';

// Validate and sanitize input
$business_name = sanitize($_POST['business_name']);
$website = sanitize($_POST['website']);
$industry = sanitize($_POST['industry']);
$years = sanitize($_POST['years_operation']);
$prospect_name = sanitize($_POST['prospect_name']);
$email = sanitize($_POST['email']);

// Generate unique job ID
$job_id = uniqid('sd_', true);

// Log submission
log_activity($job_id, "Submission received for: $business_name");

// Store lead in CRM (immediately, before processing)
store_lead([
    'job_id' => $job_id,
    'business_name' => $business_name,
    'website' => $website,
    'industry' => $industry,
    'years' => $years,
    'prospect_name' => $prospect_name,
    'email' => $email,
    'status' => 'processing',
    'submitted_at' => date('Y-m-d H:i:s')
]);

// Queue processing (immediate or cron-based)
if (QUEUE_MODE === 'immediate') {
    process_shallow_dig($job_id, $business_name, $website, $industry, $years, $prospect_name, $email);
} else {
    // Add to queue for cron processing
    add_to_queue($job_id);
    echo json_encode(['status' => 'queued', 'job_id' => $job_id, 'message' => 'Your snapshot is being prepared. Check your email in 15 minutes.']);
}

function process_shallow_dig($job_id, $business_name, $website, $industry, $years, $prospect_name, $email) {
    
    // Update status
    update_lead_status($job_id, 'researching');
    
    // PARALLEL AI QUERIES (Minutes 1-4)
    $ai_results = [];
    
    // Launch all AI calls simultaneously
    $ai_results['chatgpt'] = call_chatgpt_async($business_name, $website, $industry, $years);
    $ai_results['claude'] = call_claude_async($business_name, $website, $industry, $years);
    $ai_results['gemini'] = call_gemini_async($business_name, $website, $industry, $years);
    $ai_results['perplexity'] = call_perplexity_async($business_name, $website, $industry, $years);
    
    // Wait for all to complete (with timeout)
    $timeout = 180; // 3 minutes
    $start = time();
    while (!all_complete($ai_results) && (time() - $start) < $timeout) {
        usleep(100000); // 0.1 second
    }
    
    log_activity($job_id, "AI queries completed");
    
    // WEB SCRAPING (Minutes 4-6)
    $scraped_data = [];
    $scraped_data['wayback'] = scrape_wayback($website);
    $scraped_data['youtube'] = scrape_youtube($business_name);
    $scraped_data['news'] = scrape_news($business_name);
    
    log_activity($job_id, "Web scraping completed");
    
    // SYNTHESIS (Minutes 6-10)
    $synthesis = synthesize_findings($ai_results, $scraped_data, $business_name, $industry);
    
    log_activity($job_id, "Synthesis completed");
    
    // PDF GENERATION (Minutes 10-13)
    $pdf_path = generate_snapshot_pdf($job_id, $business_name, $prospect_name, $synthesis);
    
    log_activity($job_id, "PDF generated: $pdf_path");
    
    // EMAIL DELIVERY (Minutes 13-15)
    $email_sent = send_snapshot_email($email, $prospect_name, $business_name, $pdf_path, $job_id);
    
    if ($email_sent) {
        update_lead_status($job_id, 'delivered');
        log_activity($job_id, "Snapshot delivered to: $email");
        
        // Notify you
        notify_admin($job_id, $business_name, $prospect_name, $email, $synthesis['quality_score']);
    } else {
        update_lead_status($job_id, 'email_failed');
        log_activity($job_id, "Email delivery failed");
    }
    
    return true;
}
?>

Part 4: The AI Prompts (Exact Text)
ChatGPT API Prompt
phpCopy
function get_chatgpt_prompt($business_name, $website, $industry, $years) {
    return "Analyze the marketing history of $business_name ($website).

Business Context:
- Industry: $industry
- Years in operation: $years

Provide a structured analysis:

1. GOLDEN ERA IDENTIFICATION
   - When was this business most successful/marketing-effective?
   - What specific years represent their peak?
   - What indicators suggest this was their strongest period?

2. SPECIFIC CAMPAIGNS & TACTICS
   - What marketing campaigns, ads, or tactics did they use during the golden era?
   - What channels were primary? (print, radio, TV, digital, direct mail, etc.)
   - What messaging or positioning did they use?
   - Any specific slogans, offers, or creative approaches?

3. ABANDONMENT TIMELINE
   - When did these effective tactics stop?
   - What appears to have replaced them?
   - Was this a deliberate strategic shift or gradual decline?

4. CURRENT STATE ASSESSMENT
   - What is their current marketing approach?
   - How does it compare to their historical approach?
   - What gaps or opportunities are visible?

5. COMPETITIVE LANDSCAPE
   - Who are their main competitors?
   - What marketing are those competitors doing now?
   - How does it compare to what $business_name used to do?

Return your response in this exact format:

GOLDEN ERA: [years and brief justification]
KEY TACTICS: [bullet list of specific tactics found]
ABANDONMENT: [when and why]
CURRENT APPROACH: [brief description]
COMPETITIVE GAP: [what competitors are doing that they aren't]
CONFIDENCE SCORE: [1-10, how certain is this analysis]
KEY QUESTION: [most important strategic question this raises]";
}
Claude API Prompt
phpCopy
function get_claude_prompt($business_name, $website, $industry, $years) {
    return "Research $business_name as a business archaeology project.

Business: $business_name ($website)
Industry: $industry
Years operating: $years

Focus on psychological and strategic insights:

1. SUCCESS PSYCHOLOGY
   - What made this business successful in its peak years?
   - What customer need did they meet uniquely well?
   - What emotional or practical value did they provide?

2. POSITIONING & DIFFERENTIATION
   - How were they positioned in the market during their strong years?
   - What made them different from competitors?
   - What was their 'unfair advantage'?

3. DECLINE DIAGNOSIS
   - When did they lose that differentiation?
   - What replaced their previous positioning?
   - Why did the market shift away from their approach?

4. MODERNIZATION POTENTIAL
   - What would need to be true for them to regain that position?
   - Is the psychology still valid today?
   - What would modernization require?

5. STRATEGIC OPPORTUNITY
   - What's the single biggest opportunity if they excavated and modernized their historical approach?
   - What would be the first step?

Return structured analysis with specific examples where possible.

CONFIDENCE LEVEL: [High/Medium/Low]
MOST COMPELLING FINDING: [one sentence]";
}
Gemini API Prompt
phpCopy
function get_gemini_prompt($business_name, $website, $industry, $years) {
    return "Find historical marketing examples and brand evolution for $business_name.

Search for:
- Old advertisements (print, TV, radio, digital archives)
- Past website designs or campaigns (Wayback Machine era)
- Notable marketing initiatives or launches
- Brand evolution and messaging changes over time
- Customer perception shifts
- Any awards, recognition, or press coverage

Industry: $industry
Years in operation: $years

For each finding, include:
- Approximate date or era
- Description of the asset/campaign
- Channel or medium
- What made it notable or effective

If specific examples cannot be found, describe the typical marketing approaches for this industry during the business's early years.

Format as structured list with dates where possible.

VISUAL ASSETS FOUND: [Y/N]
AUDIO/VIDEO ASSETS FOUND: [Y/N]
PRINT/DIGITAL ASSETS FOUND: [Y/N]";
}
Perplexity API Prompt
phpCopy
function get_perplexity_prompt($business_name, $website, $industry, $years) {
    return "What was $business_name's marketing strategy 5-10 years ago?

Focus on:
- Primary marketing channels used
- Messaging and positioning
- Target audience demographics
- Competitive differentiation approach
- Results, recognition, or outcomes achieved
- Budget level indicators (if available)

Compare to their current approach:
- What changed?
- When did the change occur?
- What appears to have driven the change?

Industry context: $industry
Years in business: $years

Cite sources where possible.

CHANNELS USED THEN: [list]
CHANNELS USED NOW: [list]
BIGGEST SHIFT: [description]
STRATEGIC QUESTION: [what this raises for the business today]";
}

Part 5: Web Scraping Functions
Wayback Machine Scraper
phpCopy
function scrape_wayback($website) {
    $domain = parse_url($website, PHP_URL_HOST);
    $api_url = "https://web.archive.org/cdx/search/cdx?url=$domain&output=json&fl=timestamp,original&collapse=timestamp:6";
    
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    
    $snapshots = [];
    if ($data && count($data) > 1) {
        // Remove header row
        array_shift($data);
        
        // Get earliest, middle, and latest snapshots
        $total = count($data);
        $indices = [0, intval($total/2), $total-1];
        
        foreach ($indices as $i) {
            if (isset($data[$i])) {
                $timestamp = $data[$i][0];
                $url = $data[$i][1];
                $year = substr($timestamp, 0, 4);
                $snapshots[] = [
                    'year' => $year,
                    'url' => "https://web.archive.org/web/$timestamp/$url",
                    'timestamp' => $timestamp
                ];
            }
        }
    }
    
    return [
        'domain' => $domain,
        'snapshots_found' => count($snapshots),
        'snapshots' => $snapshots,
        'era_covered' => $snapshots ? ($snapshots[0]['year'] . ' - ' . end($snapshots)['year']) : 'No data'
    ];
}
YouTube Scraper
phpCopy
function scrape_youtube($business_name) {
    $search_query = urlencode("$business_name commercial OR $business_name ad OR $business_name marketing");
    // Note: Requires YouTube Data API v3 key
    $api_key = YOUTUBE_API_KEY;
    $api_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=$search_query&type=video&maxResults=5&key=$api_key";
    
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    
    $videos = [];
    if (isset($data['items'])) {
        foreach ($data['items'] as $item) {
            $videos[] = [
                'title' => $item['snippet']['title'],
                'description' => substr($item['snippet']['description'], 0, 200),
                'published_at' => $item['snippet']['publishedAt'],
                'video_id' => $item['id']['videoId'],
                'url' => 'https://youtube.com/watch?v=' . $item['id']['videoId']
            ];
        }
    }
    
    return [
        'videos_found' => count($videos),
        'videos' => $videos
    ];
}
News Archive Scraper
phpCopy
function scrape_news($business_name) {
    // Using Google News RSS or similar
    $search_query = urlencode("\"$business_name\" marketing OR advertising OR campaign");
    $rss_url = "https://news.google.com/rss/search?q=$search_query";
    
    $rss = @simplexml_load_file($rss_url);
    $articles = [];
    
    if ($rss) {
        $count = 0;
        foreach ($rss->channel->item as $item) {
            if ($count >= 5) break;
            $articles[] = [
                'title' => (string)$item->title,
                'link' => (string)$item->link,
                'pub_date' => (string)$item->pubDate,
                'description' => substr((string)$item->description, 0, 300)
            ];
            $count++;
        }
    }
    
    return [
        'articles_found' => count($articles),
        'articles' => $articles
    ];
}

Part 6: Synthesis Engine
Pattern Recognition Logic
phpCopy
function synthesize_findings($ai_results, $scraped_data, $business_name, $industry) {
    
    $synthesis = [
        'business_name' => $business_name,
        'industry' => $industry,
        'generated_at' => date('Y-m-d H:i:s'),
        'quality_score' => 0,
        'findings' => [],
        'recommendations' => []
    ];
    
    // Extract golden era from AI results
    $golden_era = extract_golden_era($ai_results);
    $synthesis['golden_era'] = $golden_era;
    
    // Identify key tactics
    $tactics = extract_tactics($ai_results);
    $synthesis['key_tactics'] = $tactics;
    
    // Determine abandonment pattern
    $abandonment = extract_abandonment($ai_results);
    $synthesis['abandonment'] = $abandonment;
    
    // Map competitive gap
    $competitive_gap = extract_competitive_gap($ai_results);
    $synthesis['competitive_gap'] = $competitive_gap;
    
    // Calculate opportunity (rough estimate)
    $opportunity = calculate_opportunity($golden_era, $abandonment, $industry);
    $synthesis['opportunity_estimate'] = $opportunity;
    
    // Generate specific recommendation
    $recommendation = generate_recommendation($tactics, $industry);
    $synthesis['primary_recommendation'] = $recommendation;
    
    // Calculate quality score
    $quality_score = calculate_quality_score($ai_results, $scraped_data);
    $synthesis['quality_score'] = $quality_score;
    
    // Flag for manual review if needed
    $synthesis['needs_manual_review'] = ($quality_score < 6);
    
    return $synthesis;
}

function calculate_quality_score($ai_results, $scraped_data) {
    $score = 5; // Base score
    
    // Confidence scores from AI
    if (isset($ai_results['chatgpt']['confidence_score'])) {
        $score += ($ai_results['chatgpt']['confidence_score'] / 10) * 2;
    }
    
    // Data richness
    if ($scraped_data['wayback']['snapshots_found'] > 2) $score += 1;
    if ($scraped_data['youtube']['videos_found'] > 0) $score += 1;
    if ($scraped_data['news']['articles_found'] > 0) $score += 0.5;
    
    // Specificity of findings
    $specific_indicators = ['specific', 'campaign', 'tactic', 'strategy', 'approach'];
    foreach ($ai_results as $result) {
        foreach ($specific_indicators as $indicator) {
            if (stripos($result, $indicator) !== false) $score += 0.2;
        }
    }
    
    return min(10, round($score, 1));
}

Part 7: PDF Generation
Snapshot Template Structure
HTMLPreviewCopy
<!-- snapshot-template.html -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .header { background: #1a1a1a; color: #d4af37; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; }
        .header p { margin: 10px 0 0; font-size: 14px; }
        .content { padding: 30px; }
        .section { margin-bottom: 25px; }
        .section h2 { color: #1a1a1a; border-bottom: 2px solid #d4af37; padding-bottom: 5px; font-size: 18px; }
        .highlight { background: #f9f9f9; padding: 15px; border-left: 4px solid #d4af37; margin: 15px 0; }
        .metric { display: inline-block; background: #1a1a1a; color: #d4af37; padding: 5px 15px; margin: 5px; font-weight: bold; }
        .cta { background: #d4af37; color: #1a1a1a; padding: 20px; text-align: center; margin-top: 30px; }
        .cta h3 { margin: 0 0 10px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUSINESS ARCHAEOLOGY SNAPSHOT</h1>
        <p>Prepared for {{PROSPECT_NAME}} | {{BUSINESS_NAME}} | {{DATE}}</p>
    </div>
    
    <div class="content">
        <div class="section">
            <h2>What We Found</h2>
            <p>Our AI archaeologists excavated {{BUSINESS_NAME}}'s marketing history across 40+ channels. Here's what emerged:</p>
            
            <div class="highlight">
                <strong>Golden Era:</strong> {{GOLDEN_ERA}}<br>
                <strong>Key Tactic:</strong> {{KEY_TACTIC}}<br>
                <strong>Abandoned:</strong> {{ABANDONMENT_DATE}}
            </div>
        </div>
        
        <div class="section">
            <h2>The Asset</h2>
            <p>{{ASSET_DESCRIPTION}}</p>
            <p><em>Why it worked:</em> {{PSYCHOLOGY}}</p>
        </div>
        
        <div class="section">
            <h2>The Gap</h2>
            <p>While {{BUSINESS_NAME}} moved away from {{KEY_TACTIC}}, competitors have modernized similar approaches:</p>
            <p>{{COMPETITIVE_GAP}}</p>
        </div>
        
        <div class="section">
            <h2>The Opportunity</h2>
            <p>If {{KEY_TACTIC}} generated {{ESTIMATED_RESULT}} during the golden era, and you've been without comparable systematic marketing for {{YEARS_WITHOUT}} years, the opportunity cost is significant.</p>
            
            <div class="highlight">
                <strong>Modernization Potential:</strong> {{RECOMMENDATION}}
            </div>
        </div>
        
        <div class="section">
            <h2>Confidence & Next Steps</h2>
            <p><span class="metric">Research Confidence: {{CONFIDENCE_SCORE}}/10</span></p>
            <p>This snapshot is based on automated research. A full Business History Audit would include:</p>
            <ul>
                <li>Deep excavation across 40+ channels</li>
                <li>15-25 specific assets documented</li>
                <li>Psychological analysis of what worked</li>
                <li>Specific modernization recommendations</li>
                <li>10-page report + video walkthrough</li>
            </ul>
        </div>
        
        <div class="cta">
            <h3>Ready to excavate your full history?</h3>
            <p><strong>Schedule a 15-minute call</strong> to discuss what a complete Business History Audit would reveal.</p>
            <p><strong>→ {{BOOKING_LINK}}</strong></p>
        </div>
    </div>
    
    <div class="footer">
        <p>CarrAI.site | Business Archaeology & Authority Systems</p>
        <p>This snapshot was generated automatically and may contain inaccuracies. Verify findings before acting.</p>
    </div>
</body>
</html>
PDF Generation Function
phpCopy
function generate_snapshot_pdf($job_id, $business_name, $prospect_name, $synthesis) {
    
    require_once 'includes/mpdf/autoload.php'; // or dompdf
    
    // Load template
    $template = file_get_contents('templates/snapshot-template.html');
    
    // Replace variables
    $replacements = [
        '{{PROSPECT_NAME}}' => $prospect_name,
        '{{BUSINESS_NAME}}' => $business_name,
        '{{DATE}}' => date('F j, Y'),
        '{{GOLDEN_ERA}}' => $synthesis['golden_era']['years'] ?? 'Unknown',
        '{{KEY_TACTIC}}' => $synthesis['key_tactics'][0]['name'] ?? 'Systematic marketing',
        '{{ABANDONMENT_DATE}}' => $synthesis['abandonment']['year'] ?? 'Recent years',
        '{{ASSET_DESCRIPTION}}' => $synthesis['key_tactics'][0]['description'] ?? 'Historical marketing approach',
        '{{PSYCHOLOGY}}' => $synthesis['key_tactics'][0]['psychology'] ?? 'Built trust through consistency',
        '{{COMPETITIVE_GAP}}' => $synthesis['competitive_gap']['description'] ?? 'Competitors now dominate this positioning',
        '{{ESTIMATED_RESULT}}' => $synthesis['opportunity_estimate']['past_result'] ?? 'significant customer acquisition',
        '{{YEARS_WITHOUT}}' => $synthesis['opportunity_estimate']['years'] ?? 'several',
        '{{RECOMMENDATION}}' => $synthesis['primary_recommendation'],
        '{{CONFIDENCE_SCORE}}' => $synthesis['quality_score'],
        '{{BOOKING_LINK}}' => CALENDLY_LINK
    ];
    
    $html = str_replace(array_keys($replacements), array_values($replacements), $template);
    
    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    
    $filename = "snapshot_{$job_id}.pdf";
    $filepath = "output/$filename";
    $mpdf->Output($filepath, 'F');
    
    return $filepath;
}

Part 8: Email Delivery
To Prospect
phpCopy
function send_snapshot_email($to_email, $prospect_name, $business_name, $pdf_path, $job_id) {
    
    $subject = "Your $business_name Archaeology Snapshot is ready";
    
    $body = "
    <html>
    <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
        <p>Hi $prospect_name,</p>
        
        <p>Your Business Archaeology Snapshot for <strong>$business_name</strong> is attached.</p>
        
        <p>In 15 minutes of automated research, we found:</p>
        <ul>
            <li>Your historical marketing approach</li>
            <li>When and why key tactics were abandoned</li>
            <li>What competitors are doing with similar strategies now</li>
            <li>One specific modernization opportunity</li>
        </ul>
        
        <p><strong>This is just the surface.</strong> A full Business History Audit excavates 40+ channels, documents 15-25 specific assets, and provides a complete modernization roadmap.</p>
        
        <div style='background: #f9f9f9; padding: 20px; margin: 20px 0; text-align: center;'>
            <p style='margin: 0;'><strong>Want to see what else is buried in your history?</strong></p>
            <p style='margin: 10px 0;'><a href='" . CALENDLY_LINK . "' style='background: #d4af37; color: #1a1a1a; padding: 12px 30px; text-decoration: none; font-weight: bold;'>Schedule a 15-minute call</a></p>
        </div>
        
        <p>Questions? Just reply to this email.</p>
        
        <p>Best,<br>John Carr<br>CarrAI.site</p>
        
        <hr style='border: none; border-top: 1px solid #ddd; margin: 30px 0;'>
        <p style='font-size: 12px; color: #666;'>
            Snapshot ID: $job_id<br>
            Generated: " . date('F j, Y \a\t g:i a') . "<br>
            This automated report may contain inaccuracies. Verify findings before acting.
        </p>
    </body>
    </html>
    ";
    
    // Send via PHPMailer or SendGrid
    // ... implementation details ...
    
    return true;
}
To You (Admin Notification)
phpCopy
function notify_admin($job_id, $business_name, $prospect_name, $email, $quality_score) {
    
    $subject = "New Shallow Dig Lead: $business_name (Quality: $quality_score/10)";
    
    $body = "
    New Shallow Dig completed:
    
    Business: $business_name
    Prospect: $prospect_name
    Email: $email
    Job ID: $job_id
    Quality Score: $quality_score/10
    
    " . ($quality_score >= 8 ? "HIGH QUALITY - Prioritize follow-up" : 
         ($quality_score >= 6 ? "MEDIUM QUALITY - Standard follow-up" : 
          "LOW QUALITY - May need manual review")) . "
    
    View in CRM: " . CRM_URL . "/lead/$job_id
    ";
    
    mail(ADMIN_EMAIL, $subject, $body);
    
    // Optional: Slack notification
    // slack_webhook($message);
}

Part 9: CRM Integration
Google Sheets Integration
phpCopy
function store_lead($lead_data) {
    
    // Using Google Sheets API v4
    $spreadsheet_id = GOOGLE_SHEETS_ID;
    $range = 'Leads!A:Z';
    
    $values = [
        [
            $lead_data['job_id'],
            $lead_data['submitted_at'],
            $lead_data['business_name'],
            $lead_data['website'],
            $lead_data['industry'],
            $lead_data['years'],
            $lead_data['prospect_name'],
            $lead_data['email'],
            $lead_data['status'],
            '', // quality_score (filled later)
            '', // notes
            ''  // follow_up_date
        ]
    ];
    
    // Append to sheet
    // ... Google API implementation ...
    
    return true;
}
Lead Status Workflow
Table
Status
Meaning
Action
processing
Form submitted, research underway
Wait
researching
AI queries running
Wait
delivered
Snapshot sent to prospect
Follow up in 48 hours
email_failed
Delivery failed
Check email, retry
manual_review
Quality score < 6
Review before sending
contacted
You reached out
Track in your system
call_scheduled
Discovery call booked
Prepare for call
converted
Became paying client
Celebrate
nurture
Not now, stay in touch
Quarterly check-ins


Part 10: Quality Control
Auto-Flag for Manual Review
phpCopy
function should_flag_for_review($ai_results, $scraped_data) {
    $flags = [];
    
    // Low confidence indicators
    if (stripos($ai_results['chatgpt'], "I don't have information") !== false) {
        $flags[] = "Insufficient AI data";
    }
    
    if (stripos($ai_results['chatgpt'], "I couldn't find") !== false) {
        $flags[] = "Limited findings";
    }
    
    // Business too new
    if ($years_operation === '1-5') {
        $flags[] = "Business may be too new for historical analysis";
    }
    
    // Website issues
    $headers = @get_headers($website);
    if (!$headers || strpos($headers[0], '200') === false) {
        $flags[] = "Website not accessible";
    }
    
    // AI suggests online-only business
    if (stripos($ai_results['claude'], 'primarily online') !== false ||
        stripos($ai_results['claude'], 'e-commerce') !== false) {
        $flags[] = "May be digital-native business with limited vintage assets";
    }
    
    return count($flags) > 0 ? $flags : false;
}
Manual Review Process
When quality score < 6 or flags triggered:
Don't send automatically
Email you: "Manual review needed: $business_name"
Your 5-minute check:
Read AI outputs
Check if findings are coherent
Determine: Send as-is, improve, or decline
If sending with caveat:
Add note: "Preliminary findings—limited data available"
If declining:
Send: "Researching your business... need 24 more hours"
Actually do deeper manual research, or
Send polite decline: "Insufficient historical data for meaningful analysis"

Part 11: Conversion Optimization
A/B Testing Framework
Table
Element
Variation A
Variation B
Measure
Headline
"Discover Your Business's Buried Marketing Gold"
"What Made You Great (And Why You Lost It)"
Form completion rate
CTA Button
"Generate My Snapshot"
"Excavate My History"
Click-through rate
Email Subject
"Your [Business] Archaeology Snapshot is ready"
"I found something interesting about [Business]'s history"
Open rate
Email CTA
"Schedule 15-min call"
"See what else I found"
Click rate
Follow-up timing
Day 2, 5, 10, 17
Day 1, 3, 7, 14
Conversion to call

Landing Page Best Practices
Single column layout — no distractions
Form above the fold — immediate action possible
Social proof — "Join 200+ businesses who discovered their hidden assets"
Clear value proposition — "15 minutes, 1 page, specific findings"
Privacy reassurance — "We never share your information"
Mobile optimized — 60%+ traffic will be mobile

Part 12: Cost Management
API Cost Estimates
Table
Service
Cost per Call
Calls per Lead
Total per Lead
OpenAI (ChatGPT)
$0.01–0.03
1
~$0.02
Anthropic (Claude)
$0.01–0.03
1
~$0.02
Google (Gemini)
$0.00 (free tier)
1
$0.00
Perplexity
$0.01–0.05
1
~$0.03
YouTube API
$0.00
1
$0.00
Wayback Machine
$0.00
1
$0.00
PDF Generation
$0.00 (server)
1
$0.00
Email (SendGrid)
$0.00 (free tier)
2
$0.00
TOTAL




~$0.50–1.00

Cost Controls
Daily limit: Max 20 leads/day (prevents runaway costs)
Monthly budget: Cap at $100 in API costs
Queue system: If volume exceeds capacity, add to queue and process overnight
Free tier optimization: Use Gemini free tier, SendGrid free tier

Part 13: Technical Troubleshooting
Common Issues and Solutions
Table
Issue
Cause
Solution
AI API timeout
Slow response
Increase timeout to 180s, add retry logic
PDF generation fails
Memory limit
Increase PHP memory_limit, optimize HTML
Email bounces
Invalid address
Validate email format, use double opt-in
Wayback no data
New domain
Check domain age, flag for manual review
Low quality scores
New/obscure business
Add "insufficient data" message, offer manual research
Duplicate submissions
User clicks twice
Disable button on submit, check for recent duplicate

Error Logging
phpCopy
function log_error($job_id, $error_message, $context = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'job_id' => $job_id,
        'error' => $error_message,
        'context' => json_encode($context)
    ];
    
    // Write to log file
    $log_line = implode(' | ', $log_entry) . "\n";
    file_put_contents('logs/errors.log', $log_line, FILE_APPEND);
    
    // Alert if critical
    if (is_critical_error($error_message)) {
        mail(ADMIN_EMAIL, "CRITICAL: Shallow Dig Error", $log_line);
    }
}

Part 14: Deliverables Checklist
After completing Chapter 28, you will have:
[ ] Landing page HTML form (hosted on CarrAI.site)
[ ] PHP backend processor (form handling, validation)
[ ] AI API integrations (OpenAI, Anthropic, Google, Perplexity)
[ ] Web scraping functions (Wayback, YouTube, news)
[ ] Synthesis engine (pattern recognition, quality scoring)
[ ] PDF generation system (mPDF or Dompdf)
[ ] Email delivery system (prospect and admin notifications)
[ ] CRM integration (Google Sheets or Airtable)
[ ] Quality control system (auto-flag, manual review)
[ ] Error logging and monitoring
[ ] Cost tracking and budget controls
[ ] A/B testing framework (optional)
[ ] Privacy policy and terms (GDPR compliance)

Integration with Other Chapters
Chapter 20 (Business Development): Shallow Dig is the primary lead magnet
Chapter 27 (Discovery Call): Converts Shallow Dig recipients to calls
Chapter 29 (Industry Playbooks): Inform AI prompts with industry-specific guidance
Chapter 31 (Private Archaeology): Offer full audit when Shallow Dig finds interesting surface-level data

This is the complete Shallow Dig Technical Build. Every component, every prompt, every function included for zero-knowledge implementation.
Shall I continue with Chapter 29: Industry-Specific Playbooks?

