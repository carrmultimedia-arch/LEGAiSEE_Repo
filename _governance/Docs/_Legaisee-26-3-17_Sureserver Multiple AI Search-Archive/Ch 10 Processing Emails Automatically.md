CHAPTER 10: Processing Emails Automatically
10.1 What IMAP Is (Plain English)
What this is:
IMAP (Internet Message Access Protocol) is the standard method for email programs to connect to mail servers, read messages, and manage mailboxes. Unlike older POP3 protocol which downloads and deletes, IMAP leaves messages on the server and synchronizes state.
Where this exists in the real world:
Think of IMAP like a library card catalog system. The books (emails) stay in the library (server). Your card catalog (IMAP connection) tells you what is available, lets you read summaries, and marks which you have seen. You do not take the books home—you browse them in place.
How you encounter this:
Your PHP script will use IMAP functions to connect to your SureServer mailbox, check for new (unseen) messages, read their content, extract the AI conversation text, and then mark them as processed. The emails remain on the server until your script deletes them after successful archiving.
What this controls or affects:
IMAP is the bridge between the email system and your archive system. Without it, your PHP script cannot access the mailbox. With it, your script can process emails automatically without user intervention.
What goes wrong when this is misunderstood:
Confusing IMAP with SMTP → SMTP sends mail, IMAP reads mail
Thinking IMAP requires special software → PHP has built-in IMAP functions
Not understanding "unseen" vs "unread" → IMAP flags are complex
Expecting instant synchronization → IMAP has caching delays
Concept Lock-In:
IMAP maintains server-side state. When you mark a message as "seen" via IMAP, that status persists for all clients. Your PHP script must explicitly fetch unseen messages, process them, and mark them seen (or delete them) to avoid reprocessing the same emails infinitely.

10.2 Connecting to Your Email Server
What this is:
The technical process of establishing an authenticated connection between your PHP script and your SureServer mailbox using the IMAP protocol over an encrypted SSL connection.
Where this exists in the real world:
Think of connecting to a secure vault. You need: (1) the vault's address (server), (2) the correct port (door number), (3) your credentials (key card), and (4) the vault room (mailbox name). IMAP connection strings bundle all this information into one format.
How you encounter this:
You will use PHP's imap_open() function with a connection string that specifies SSL encryption, the mail server hostname, port 993, and your archive email credentials. This creates a connection resource that subsequent IMAP functions use.
CLICK-BY-CLICK: Creating the IMAP Connection Script
Step 1: Verify IMAP Extension is Available
Create a test file check-imap.php in your archaeology/api/ folder:
phpCopy
<?php
// Check if IMAP extension is installed
if (extension_loaded('imap')) {
    echo "✅ IMAP extension is available\n";
    echo "Version: " . phpversion('imap') . "\n";
} else {
    echo "❌ IMAP extension is NOT available\n";
    echo "Contact SureServer support to enable PHP IMAP extension\n";
}
?>
Upload to server and access via browser. If IMAP is not available, contact SureServer support—most hosts enable it by default.
Step 2: Create Email Configuration File
Create config/email.php (outside web root if possible, or secured):
phpCopy
<?php
/**
 * Email Configuration
 * Store sensitive credentials outside version control
 */

// IMAP Connection Settings
define('IMAP_SERVER', 'mail.your-domain.com'); // Or your-domain.com
define('IMAP_PORT', 993);
define('IMAP_MAILBOX', 'archive@your-domain.com');
define('IMAP_PASSWORD', 'your-secure-password-here');
define('IMAP_FOLDER', 'INBOX');

// Archive Settings
define('STORAGE_PATH', realpath(__DIR__ . '/../storage/') . '/');
define('PROCESSED_FOLDER', STORAGE_PATH . 'chats/email/');

// Ensure processed folder exists
if (!is_dir(PROCESSED_FOLDER)) {
    mkdir(PROCESSED_FOLDER, 0755, true);
}
SECURITY NOTE: This file contains your password. Protect it:
Set file permissions to 640 (not readable by others)
Place outside web root if your hosting allows
Add to .gitignore if using version control
Consider using environment variables in production
Step 3: Create IMAP Connection Function
Create lib/imap-connection.php:
phpCopy
<?php
/**
 * IMAP Connection Handler
 * Chapter 10.2
 */

require_once __DIR__ . '/../config/email.php';

/**
 * Open IMAP connection to archive mailbox
 * @return resource|false IMAP stream or false on failure
 */
function openArchiveMailbox() {
    // Build IMAP connection string
    // Format: {server:port/flags}folder
    $connectionString = '{' . IMAP_SERVER . ':' . IMAP_PORT . '/imap/ssl/novalidate-cert}INBOX';
    
    echo "Connecting to: " . IMAP_SERVER . "\n";
    
    // Open connection
    $imap = @imap_open(
        $connectionString,
        IMAP_MAILBOX,
        IMAP_PASSWORD,
        NULL, // Options
        1,    // Retries
        []    // Parameters
    );
    
    if (!$imap) {
        echo "❌ Connection failed: " . imap_last_error() . "\n";
        return false;
    }
    
    echo "✅ Connected successfully\n";
    return $imap;
}

/**
 * Close IMAP connection cleanly
 * @param resource $imap IMAP stream
 */
function closeArchiveMailbox($imap) {
    if ($imap) {
        imap_close($imap);
        echo "Connection closed\n";
    }
}

/**
 * Test IMAP connection (for diagnostics)
 */
function testIMAPConnection() {
    echo "=== IMAP Connection Test ===\n";
    
    $imap = openArchiveMailbox();
    
    if (!$imap) {
        return false;
    }
    
    // Get mailbox info
    $check = imap_check($imap);
    echo "Mailbox: " . $check->Mailbox . "\n";
    echo "Messages: " . $check->Nmsgs . "\n";
    echo "Recent: " . $check->Recent . "\n";
    
    closeArchiveMailbox($imap);
    
    return true;
}
Step 4: Test the Connection
Create test-imap.php:
phpCopy
<?php
require_once __DIR__ . '/lib/imap-connection.php';

header('Content-Type: text/plain');

testIMAPConnection();
Upload and access via browser. You should see:
plainCopy
=== IMAP Connection Test ===
Connecting to: mail.your-domain.com
✅ Connected successfully
Mailbox: {mail.your-domain.com:993/imap/ssl/novalidate-cert}INBOX
Messages: 1
Recent: 0
Connection closed
What this controls or affects:
Your PHP script can now connect to the mailbox. The connection string format tells PHP to use SSL on port 993, validate the certificate (or skip validation with novalidate-cert if using self-signed), and access the INBOX folder.
What goes wrong when this is misunderstood:
Wrong server hostname → connection timeout or "Certificate failure"
Port 143 without /ssl/ → connection refused or plaintext (insecure)
Wrong password → "Authentication failed"
Missing curly braces in connection string → syntax error, connection fails
Using imap.gmail.com format for cPanel → cPanel uses your domain, not Gmail
Concept Lock-In:
IMAP connection strings have a specific format: {hostname:port/protocol/flags}folder. The curly braces are literal. The flags (/ssl/novalidate-cert) modify connection behavior. The folder at the end (INBOX) is your starting point—other folders use dot notation like INBOX.Processed.

10.3 Reading Unseen Messages
What this is:
Querying the mailbox for messages that have not been previously seen (marked as read), retrieving their headers and content, and preparing them for processing.
Where this exists in the real world:
Think of a doctor's office checking for new patients. The receptionist looks at the waiting room (mailbox), identifies who has not been called (unseen), pulls their chart (headers), and brings them to the examination room (processing). Seen patients are skipped.
How you encounter this:
You will use imap_search() with the "UNSEEN" criterion to find new emails, then imap_fetch_overview() to get headers (subject, from, date), and imap_fetchbody() to get the actual message content.
CLICK-BY-CLICK: Implementing Message Reading
Step 1: Create Message Retrieval Functions
Add to lib/imap-connection.php:
phpCopy
<?php
// ... previous code ...

/**
 * Get all unseen (new) message IDs
 * @param resource $imap IMAP stream
 * @return array Array of message IDs
 */
function getUnseenMessages($imap) {
    // Search for unseen messages
    $messageIds = imap_search($imap, 'UNSEEN');
    
    if ($messageIds === false) {
        // No unseen messages or error
        return [];
    }
    
    return $messageIds;
}

/**
 * Get message headers and metadata
 * @param resource $imap IMAP stream
 * @param int $msgId Message ID
 * @return object|false Message overview or false
 */
function getMessageInfo($imap, $msgId) {
    $overview = imap_fetch_overview($imap, $msgId, 0);
    
    if (!$overview || empty($overview)) {
        return false;
    }
    
    return $overview[0];
}

/**
 * Get full message body
 * @param resource $imap IMAP stream
 * @param int $msgId Message ID
 * @return string Message body
 */
function getMessageBody($imap, $msgId) {
    // Try to get plain text first
    $body = imap_fetchbody($imap, $msgId, '1');
    
    // If empty, try alternative parts
    if (empty($body)) {
        $body = imap_fetchbody($imap, $msgId, '2');
    }
    
    // Decode if base64 encoded
    $structure = imap_fetchstructure($imap, $msgId);
    
    if ($structure && isset($structure->encoding)) {
        switch ($structure->encoding) {
            case 3: // BASE64
                $body = base64_decode($body);
                break;
            case 4: // QUOTED-PRINTABLE
                $body = quoted_printable_decode($body);
                break;
        }
    }
    
    return $body;
}

/**
 * Mark message as seen (read)
 * @param resource $imap IMAP stream
 * @param int $msgId Message ID
 */
function markMessageSeen($imap, $msgId) {
    imap_setflag_full($imap, $msgId, "\\Seen");
}

/**
 * Delete message after processing
 * @param resource $imap IMAP stream
 * @param int $msgId Message ID
 */
function deleteMessage($imap, $msgId) {
    imap_delete($imap, $msgId);
    imap_expunge($imap);
}

/**
 * Process all unseen messages
 * @param resource $imap IMAP stream
 * @return array Processing results
 */
function processUnseenMessages($imap) {
    $results = [];
    $messageIds = getUnseenMessages($imap);
    
    echo "Found " . count($messageIds) . " unseen messages\n";
    
    foreach ($messageIds as $msgId) {
        echo "\n--- Processing message $msgId ---\n";
        
        // Get message info
        $info = getMessageInfo($imap, $msgId);
        if (!$info) {
            echo "Failed to get message info\n";
            continue;
        }
        
        echo "Subject: " . $info->subject . "\n";
        echo "From: " . $info->from . "\n";
        echo "Date: " . $info->date . "\n";
        
        // Get body
        $body = getMessageBody($imap, $msgId);
        echo "Body length: " . strlen($body) . " chars\n";
        
        // Here we would parse and save (Chapter 10.4-10.5)
        // For now, just mark as seen
        markMessageSeen($imap, $msgId);
        
        $results[] = [
            'id' => $msgId,
            'subject' => $info->subject,
            'from' => $info->from,
            'size' => strlen($body),
            'processed' => true
        ];
    }
    
    return $results;
}
Step 2: Create Test Script
Create test-read.php:
phpCopy
<?php
require_once __DIR__ . '/lib/imap-connection.php';

header('Content-Type: text/plain');

echo "=== Email Reading Test ===\n\n";

$imap = openArchiveMailbox();
if (!$imap) {
    exit(1);
}

// Process unseen messages
$results = processUnseenMessages($imap);

echo "\n=== Summary ===\n";
echo "Processed: " . count($results) . " messages\n";

closeArchiveMailbox($imap);
Step 3: Send Test Email and Verify
Send a test email to archive@your-domain.com
Wait 1-2 minutes
Run test-read.php in browser
You should see:
plainCopy
=== Email Reading Test ===

Connecting to: mail.your-domain.com
✅ Connected successfully
Found 1 unseen messages

--- Processing message 1 ---
Subject: Test: Archaeology Email Pipe
From: you@gmail.com
Date: Mon, 16 Mar 2026 14:30:00 +0000
Body length: 247 chars

=== Summary ===
Processed: 1 messages
Run the script again—it should show "Found 0 unseen messages" because the first run marked it seen
What this controls or affects:
Your script can now identify new emails, read their content, and mark them processed. The UNSEEN flag prevents reprocessing the same email twice.
What goes wrong when this is misunderstood:
Not marking messages seen → infinite reprocessing loop
imap_search() returning false vs empty array → must check with === false
Encoding not handled → garbled text in body
Not calling imap_expunge() after delete → messages not actually removed
Concept Lock-In:
IMAP flags are persistent. When your script marks a message \Seen, that flag stays on the server. Other email clients will also see it as read. This is the mechanism that prevents duplicate processing—but it also means test emails disappear from "unseen" after first run.

10.4 Parsing Archive Emails
What this is:
Analyzing email content to extract structured data: which AI platform sent it, what the research query was, and the actual response content to be archived.
Where this exists in the real world:
Think of a mailroom sorting incoming letters. The sorter reads the return address (From:), checks the subject line, opens the envelope, and extracts the relevant document inside. Your parser does this digitally.
How you encounter this:
You will implement parsing logic that examines email headers to identify the source platform, extracts the subject as the query/title, and processes the body to remove email boilerplate (signatures, footers) and extract the actual AI response.
CLICK-BY-CLICK: Building the Email Parser
Step 1: Create Email Parser Class
Create lib/email-parser.php:
phpCopy
<?php
/**
 * Email Parser for AI Platform Messages
 * Chapter 10.4
 */

class EmailParser {
    
    // Known AI platform email patterns
    private $platformPatterns = [
        'chatgpt' => [
            'from_patterns' => ['@openai.com', 'noreply@chatgpt.com'],
            'subject_clean' => '/^ChatGPT:?\s*/i'
        ],
        'claude' => [
            'from_patterns' => ['@anthropic.com', 'claude@anthropic.com'],
            'subject_clean' => '/^Claude:?\s*/i'
        ],
        'gemini' => [
            'from_patterns' => ['@google.com', 'gemini@google.com'],
            'subject_clean' => '/^Gemini:?\s*/i'
        ],
        'perplexity' => [
            'from_patterns' => ['@perplexity.ai', 'hello@perplexity.ai'],
            'subject_clean' => '/^Perplexity:?\s*/i'
        ]
    ];
    
    /**
     * Parse email and extract archive data
     * @param object $headers IMAP overview object
     * @param string $body Email body
     * @return array Parsed data
     */
    public function parse($headers, $body) {
        $from = $this->decodeHeader($headers->from);
        $subject = $this->decodeHeader($headers->subject);
        $date = $headers->date;
        
        // Detect platform
        $platform = $this->detectPlatform($from, $subject);
        
        // Clean subject to get title
        $title = $this->extractTitle($subject, $platform);
        
        // Clean body
        $content = $this->cleanBody($body);
        
        // Extract query if present in body
        $query = $this->extractQuery($content);
        
        return [
            'platform' => $platform,
            'title' => $title,
            'query' => $query,
            'content' => $content,
            'date' => $this->parseDate($date),
            'source_email' => $from,
            'original_subject' => $subject,
            'parsed_at' => date('c')
        ];
    }
    
    /**
     * Detect AI platform from sender address
     */
    private function detectPlatform($from, $subject) {
        $fromLower = strtolower($from);
        
        foreach ($this->platformPatterns as $platform => $patterns) {
            // Check from patterns
            foreach ($patterns['from_patterns'] as $pattern) {
                if (strpos($fromLower, $pattern) !== false) {
                    return $platform;
                }
            }
        }
        
        // Check subject line hints
        if (preg_match('/chatgpt/i', $subject)) return 'chatgpt';
        if (preg_match('/claude/i', $subject)) return 'claude';
        if (preg_match('/gemini/i', $subject)) return 'gemini';
        if (preg_match('/perplexity/i', $subject)) return 'perplexity';
        
        // Default to email source
        return 'email';
    }
    
    /**
     * Extract clean title from subject line
     */
    private function extractTitle($subject, $platform) {
        $patterns = $this->platformPatterns[$platform]['subject_clean'] ?? null;
        
        if ($patterns) {
            $title = preg_replace($patterns, '', $subject);
        } else {
            $title = $subject;
        }
        
        return trim($title);
    }
    
    /**
     * Clean email body by removing signatures, footers, etc.
     */
    private function cleanBody($body) {
        // Convert HTML to text if needed
        if (strpos($body, '<html') !== false || strpos($body, '<body') !== false) {
            $body = strip_tags($body);
        }
        
        // Remove common email footers
        $footerPatterns = [
            '/\n--\s*\n.*/s',  // Standard signature delimiter
            '/\n_{10,}.*/s',   // Underscore lines
            '/\nSent from my.*/i',
            '/\nThis email was sent.*/i',
            '/\nYou received this message because.*/i',
            '/\n\[.*Unsubscribe.*\].*/i',
            '/\nTo stop receiving these emails.*/i'
        ];
        
        foreach ($footerPatterns as $pattern) {
            $body = preg_replace($pattern, '', $body);
        }
        
        // Normalize whitespace
        $body = preg_replace('/\n{3,}/', "\n\n", $body);
        $body = trim($body);
        
        return $body;
    }
    
    /**
     * Try to extract original query from content
     */
    private function extractQuery($content) {
        // Look for "Query:" or similar patterns
        if (preg_match('/(?:Query|Question|Prompt):\s*(.+?)(?:\n|$)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        // First line might be the query
        $lines = explode("\n", $content);
        $firstLine = trim($lines[0]);
        
        if (strlen($firstLine) > 10 && strlen($firstLine) < 200) {
            return $firstLine;
        }
        
        return null;
    }
    
    /**
     * Decode MIME header encoding
     */
    private function decodeHeader($header) {
        $decoded = '';
        $elements = imap_mime_header_decode($header);
        
        foreach ($elements as $element) {
            $decoded .= $element->text;
        }
        
        return $decoded;
    }
    
    /**
     * Parse date string to ISO format
     */
    private function parseDate($dateStr) {
        $timestamp = strtotime($dateStr);
        return $timestamp ? date('c', $timestamp) : date('c');
    }
}
Step 2: Update Processing Function
Modify processUnseenMessages() in lib/imap-connection.php:
phpCopy
require_once __DIR__ . '/email-parser.php';

function processUnseenMessages($imap) {
    $results = [];
    $messageIds = getUnseenMessages($imap);
    $parser = new EmailParser();
    
    echo "Found " . count($messageIds) . " unseen messages\n";
    
    foreach ($messageIds as $msgId) {
        echo "\n--- Processing message $msgId ---\n";
        
        // Get message info
        $info = getMessageInfo($imap, $msgId);
        if (!$info) {
            echo "Failed to get message info\n";
            continue;
        }
        
        // Get body
        $body = getMessageBody($imap, $msgId);
        
        // Parse email
        $parsed = $parser->parse($info, $body);
        
        echo "Platform: " . $parsed['platform'] . "\n";
        echo "Title: " . $parsed['title'] . "\n";
        echo "Query: " . ($parsed['query'] ?: 'Not detected') . "\n";
        echo "Content preview: " . substr($parsed['content'], 0, 100) . "...\n";
        
        // Save to archive (Chapter 10.5)
        $saved = saveParsedEmail($parsed);
        
        if ($saved) {
            markMessageSeen($imap, $msgId);
            // Optionally delete: deleteMessage($imap, $msgId);
            
            $results[] = [
                'id' => $msgId,
                'platform' => $parsed['platform'],
                'title' => $parsed['title'],
                'saved' => true
            ];
        } else {
            echo "Failed to save, leaving message unseen for retry\n";
        }
    }
    
    return $results;
}
Step 3: Create Test with Parsing
Create test-parse.php:
phpCopy
<?php
require_once __DIR__ . '/lib/imap-connection.php';
require_once __DIR__ . '/lib/email-parser.php';

header('Content-Type: text/plain');

echo "=== Email Parsing Test ===\n\n";

// Test parser with sample data
$parser = new EmailParser();

$testHeaders = (object)[
    'from' => 'noreply@openai.com',
    'subject' => 'ChatGPT: Explain quantum computing',
    'date' => date('r')
];

$testBody = "Explain quantum computing in simple terms.\n\n" .
            "Quantum computing is a type of computation that harnesses " .
            "the collective properties of quantum states...\n\n" .
            "--\nSent from ChatGPT";

$parsed = $parser->parse($testHeaders, $testBody);

echo "Test Parse Result:\n";
print_r($parsed);

// Now test with real email
echo "\n=== Real Email Test ===\n";

$imap = openArchiveMailbox();
if ($imap) {
    processUnseenMessages($imap);
    closeArchiveMailbox($imap);
}
What this controls or affects:
Your script now understands the structure of incoming emails. It can identify which AI platform sent each message, clean up the formatting, and prepare the content for archival.
What goes wrong when this is misunderstood:
Character encoding issues → imap_mime_header_decode() required for subjects
HTML emails not handled → strip_tags() or HTML parser needed
False platform detection → patterns too broad, need refinement
Query extraction failing → pattern matching too rigid
Concept Lock-In:
Email parsing is heuristic, not deterministic. Senders change formats. Your patterns will need updating over time. Build flexible detection that degrades gracefully—if uncertain, default to "email" platform and preserve all content for manual review.

10.5 Saving Chats to the Right Folder
What this is:
Converting parsed email data into properly formatted markdown files and saving them to the appropriate platform-specific folder in your storage structure.
Where this exists in the real world:
Think of a filing clerk receiving documents, stamping them with date and category, and placing them in the correct filing cabinet drawer. Your script is the clerk; the storage folders are the filing cabinets.
How you encounter this:
You will implement a save function that takes the parsed email data, generates a filename with timestamp, formats the content as markdown with metadata headers, and writes it to storage/chats/{platform}/.
CLICK-BY-CLICK: Implementing Archive Saving
Step 1: Create Save Function
Add to lib/imap-connection.php:
phpCopy
/**
 * Save parsed email to archive
 * @param array $parsed Parsed email data
 * @return bool Success status
 */
function saveParsedEmail($parsed) {
    // Determine folder path
    $platform = preg_replace('/[^a-z]/', '', strtolower($parsed['platform']));
    $folderPath = PROCESSED_FOLDER . $platform . '/';
    
    // Ensure folder exists
    if (!is_dir($folderPath)) {
        if (!mkdir($folderPath, 0755, true)) {
            echo "Failed to create folder: $folderPath\n";
            return false;
        }
    }
    
    // Generate filename
    $date = date('Y-m-d', strtotime($parsed['date']));
    $time = date('H-i-s', strtotime($parsed['date']));
    $safeTitle = preg_replace('/[^a-zA-Z0-9\-_\s]/', '', $parsed['title']);
    $safeTitle = substr($safeTitle, 0, 40);
    $filename = "{$date}_{$time}_{$safeTitle}.md";
    
    // Build markdown content
    $markdown = "# {$parsed['title']}\n\n";
    $markdown .= "**Platform:** {$parsed['platform']}  \n";
    $markdown .= "**Date:** {$parsed['date']}  \n";
    $markdown .= "**Source:** Email ({$parsed['source_email']})  \n";
    
    if ($parsed['query']) {
        $markdown .= "**Query:** {$parsed['query']}  \n";
    }
    
    $markdown .= "**Original Subject:** {$parsed['original_subject']}  \n";
    $markdown .= "**Parsed At:** {$parsed['parsed_at']}  \n";
    $markdown .= "\n---\n\n";
    $markdown .= $parsed['content'];
    $markdown .= "\n\n---\n\n";
    $markdown .= "*Captured via Email Pipe - Archaeology Intelligence Platform*";
    
    // Write file
    $filepath = $folderPath . $filename;
    
    if (file_put_contents($filepath, $markdown) === false) {
        echo "Failed to write file: $filepath\n";
        return false;
    }
    
    echo "✅ Saved to: $filepath\n";
    return true;
}
Step 2: Verify Folder Structure
After running the processor, verify your storage structure:
plainCopy
storage/
  chats/
    email/
      chatgpt/
        2026-03-16_14-30-00_Explain_quantum_computing.md
      claude/
        2026-03-16_14-35-00_Explain_quantum_computing.md
      email/  (for unknown platforms)
Step 3: Test End-to-End
Send email to archive@your-domain.com with subject "Test: My Research Query"
Run test-read.php (or wait for cron in 10.6)
Check that file appears in storage/chats/email/ folder
Open the .md file and verify content is correct
What this controls or affects:
Emails now become first-class archive citizens alongside extension captures. They use the same folder structure, same markdown format, and same metadata approach.
What goes wrong when this is misunderstood:
Filename collisions → add microtime or random suffix if needed
Permission denied on folder → check 755 permissions, ownership
Disk full → check available space, implement rotation
Concurrent writes → file locking if high volume expected
Concept Lock-In:
File storage is not transactional. If your script crashes between writing the file and marking email seen, you may get duplicates. This is acceptable for this use case—duplicates can be detected by filename or content hash and removed later.

10.6 Setting Up Cron (Automatic Processing)
What this is:
Configuring your server to run the email processing script automatically at scheduled intervals without manual intervention.
Where this exists in the real world:
Think of an alarm clock that triggers an action at set times. Cron is the server's alarm clock—it wakes up your script every N minutes to check for new emails.
How you encounter this:
You will use cPanel's "Cron Jobs" interface to schedule your PHP script to run every 5 minutes. This provides near-real-time processing without requiring you to manually trigger the script.
CLICK-BY-CLICK: Configuring Cron Job
Step 1: Create Processing Script
Create process-emails.php in archaeology/ folder:
phpCopy
<?php
/**
 * Email Processing Script - Run via Cron
 * Chapter 10.6
 */

// Prevent browser access (optional security)
if (php_sapi_name() !== 'cli' && !isset($_GET['key'])) {
    // Allow if run from command line OR with secret key
    if (!isset($_GET['key']) || $_GET['key'] !== 'your-secret-key-here') {
        http_response_code(403);
        exit('Forbidden');
    }
}

require_once __DIR__ . '/lib/imap-connection.php';

// Log start
$startTime = microtime(true);
echo "=== Email Processing Started: " . date('c') . " ===\n";

// Connect and process
$imap = openArchiveMailbox();

if ($imap) {
    $results = processUnseenMessages($imap);
    closeArchiveMailbox($imap);
    
    echo "\n=== Summary ===\n";
    echo "Processed: " . count($results) . " messages\n";
    foreach ($results as $r) {
        echo "- {$r['platform']}: {$r['title']}\n";
    }
} else {
    echo "Failed to connect to mailbox\n";
    exit(1);
}

// Log completion
$duration = round(microtime(true) - $startTime, 2);
echo "Completed in {$duration}s\n";

// Optional: Log to file for monitoring
$logEntry = date('c') . " | Processed: " . count($results) . " | Duration: {$duration}s\n";
file_put_contents(__DIR__ . '/logs/email-processor.log', $logEntry, FILE_APPEND);
Create the logs folder:
bashCopy
mkdir -p /path/to/archaeology/logs
chmod 755 /path/to/archaeology/logs
Step 2: Find Cron Jobs in cPanel
Log into cPanel
Scroll to "Advanced" section
Click "Cron Jobs" icon
Step 3: Add New Cron Job
Under "Add New Cron Job", set:
Common Settings: Select "Every 5 minutes" from dropdown (or custom)
Command: Enter the full path to PHP and your script:
bashCopy
/usr/bin/php /home/yourusername/public_html/archaeology/process-emails.php >/dev/null 2>&1
Note: The exact PHP path may vary. Common locations:
/usr/bin/php
/usr/local/bin/php
/opt/php74/bin/php
Check with SureServer support or find via SSH: which php
Click "Add New Cron Job"
Step 4: Test Cron Command
Before waiting for the schedule, test the command manually:
In cPanel Cron Jobs, click "Run" next to your new job (if available)
Or use cPanel Terminal (if available):
bashCopy
/usr/bin/php /home/yourusername/public_html/archaeology/process-emails.php
Check that emails are processed
Step 5: Verify Automation
Send a test email to archive@your-domain.com
Wait 5-10 minutes (cron runs every 5 min)
Check your storage folder—email should be processed
Check logs/email-processor.log for execution record
Step 6: Monitor and Adjust
Common cron adjustments:
Too frequent: If mailbox empty most of the time, change to "Every 15 minutes"
Too slow: If emails pile up, change to "Every 2 minutes"
Specific times: Use "Once per hour" during business hours only
What this controls or affects:
Your email pipe is now fully automated. Emails sent to your archive address appear in your storage folder within minutes, without any manual action required.
What goes wrong when this is misunderstood:
Wrong PHP path → "command not found" in cron logs
Permission denied → script cannot write to storage folder
Output not redirected → cron emails you every 5 minutes with results
Script errors → cron continues running broken script, should check logs
Concept Lock-In:
Cron runs in a minimal environment. No web server variables, no browser context. Paths must be absolute. Output should be redirected (>/dev/null 2>&1 means "discard all output"). Always test commands in terminal before adding to cron.

WORKBOOK EXERCISES
Exercise 10.1: IMAP Connection String
Explain each part of this connection string:
plainCopy
{mail.your-domain.com:993/imap/ssl/novalidate-cert}INBOX
What happens if you change:
993 to 143?
ssl to tls?
novalidate-cert to validate-cert?
Exercise 10.2: Flag Management
Design a system to handle this scenario:
Script starts processing message #5
Script crashes halfway through
Cron restarts script 5 minutes later
Message #5 should be reprocessed (not lost), but not duplicated in archive
How would you modify the code?
Exercise 10.3: Email Volume Math
If you receive:
20 emails per hour during business hours (9am-5pm)
2 emails per hour overnight
Average 50 KB per email
Calculate:
Daily email volume
Weekly storage growth
Appropriate cron frequency
When to archive/delete old emails
Exercise 10.4: Security Audit
Your config/email.php contains a password. List three ways to improve security:



Exercise 10.5: Parse Testing
Write a test email that would trigger each platform detection:
ChatGPT: From=?, Subject=?
Claude: From=?, Subject=?
Unknown: From=?, Subject=?

CHAPTER 10 MEMORY DUMP / RESTORE POINT
COPY EVERYTHING BELOW THIS LINE TO SAVE YOUR PROGRESS:
plainCopy
ARCHAEOLOGY INTELLIGENCE PLATFORM - CHAPTER 10 COMPLETE
Date: [CURRENT DATE]
Status: Email processing fully automated

FILES CREATED:
- config/email.php (IMAP credentials - secure this file)
- lib/imap-connection.php (connection, reading, processing functions)
- lib/email-parser.php (EmailParser class for content extraction)
- process-emails.php (cron executable script)
- logs/email-processor.log (execution log)

CONCEPTS LOCKED IN:
- IMAP is for reading, SMTP is for sending
- Connection string format: {host:port/protocol/flags}folder
- UNSEEN flag prevents duplicate processing
- Mark messages seen after successful processing
- Email parsing is heuristic (patterns may need updates)
- Platform detection from From: address and Subject:
- Cron runs in minimal environment (absolute paths required)
- >/dev/null 2>&1 prevents cron from emailing output
- PHP IMAP extension required (verify with phpinfo)

AUTOMATION ESTABLISHED:
✅ IMAP connection to archive@your-domain.com
✅ Unseen message detection and reading
✅ Platform detection (chatgpt, claude, gemini, perplexity, email)
✅ Content cleaning and markdown formatting
✅ File saving to storage/chats/{platform}/
✅ Cron job running every 5 minutes
✅ Logging for monitoring

EMAIL PIPE WORKFLOW:
Email sent to archive@your-domain.com → sits in mailbox → 
cron triggers process-emails.php every 5 min → IMAP connects → 
finds UNSEEN messages → parses content → detects platform → 
saves as .md file → marks message SEEN → repeats

NEXT CHAPTER: Chapter 11 - File Organization System
- Will formalize folder structure standards
- Will implement file naming conventions
- Will create business profile folders
- Will handle "Raw" to "Processed" to "Polished" workflow

RESTORE INSTRUCTIONS:
To restore this state in a new chat, paste this memory dump and say:
"I am restoring Chapter 10 of the Archaeology Intelligence Platform manual.
I have automated email processing via IMAP and cron.
The script connects to archive@your-domain.com, reads unseen messages,
parses them for AI platform content, and saves to storage folders.
Cron runs every 5 minutes. All components tested and working.
Please continue with Chapter 11: File Organization System."

CHAPTER 10 COMPLETE
What Chapter 10 Contains (Per TOC):
✅ 10.1 What IMAP Is (Plain English) - Protocol concepts
✅ 10.2 Connecting to Your Email Server - IMAP connection setup
✅ 10.3 Reading Unseen Messages - Message retrieval and flag management
✅ 10.4 Parsing Archive Emails - Content extraction and platform detection
✅ 10.5 Saving Chats to the Right Folder - File writing and organization
✅ 10.6 Setting Up Cron (Automatic Processing) - Scheduled automation
Files Created:
config/email.php - Secure credentials storage
lib/imap-connection.php - IMAP functions
lib/email-parser.php - Email parsing class
process-emails.php - Cron executable
logs/email-processor.log - Execution logging
Automation Active:
Cron job checking mailbox every 5 minutes
Automatic parsing and filing of email captures
Integrated with existing storage structure
Ready for Chapter 11: File Organization System (formalizing folder structures, naming conventions, business profiles)

Should I proceed with Chapter 11, or do you need any adjustments to Chapter 10?

