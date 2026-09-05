CHAPTER 11: File Organization System
11.1 How Files Will Be Named
What this is:
A standardized naming convention for archive files that ensures uniqueness, chronological sorting, human readability, and machine parseability while preventing filename collisions and encoding issues.
Where this exists in the real world:
Think of library call numbers or legal document Bates stamping. Each file gets a unique identifier that encodes metadata (when it was created, what it contains) and guarantees no two files will have the same name even if captured simultaneously.
How you encounter this:
You will implement a filename generation system that combines: (1) ISO date (YYYY-MM-DD) for chronological sorting, (2) time (HH-MM-SS) for intraday uniqueness, (3) sanitized title snippet for human recognition, and (4) optional sequence numbers for collision handling.
What this controls or affects:
Consistent naming enables reliable file listing, search, and sorting. Without it, files overwrite each other, sort randomly, or become unfindable. The naming system must work across all capture methods (extension, email, manual upload).
What goes wrong when this is misunderstood:
Colons in filenames → invalid on Windows, breaks cross-platform compatibility
Special characters → shell injection risks, URL encoding issues
Too long filenames → filesystem limits (255 chars), truncation
No timestamp → collisions when same query captured twice
Case sensitivity → "Chat" vs "chat" treated differently on Linux vs Mac
Concept Lock-In:
Filenames are metadata carriers and unique identifiers. They must be filesystem-safe (no / \ : * ? " < > |), URL-safe (no spaces or special chars), and human-readable. Date-first format (YYYY-MM-DD) sorts chronologically by default in all file browsers.
CLICK-BY-CLICK: Implementing Filename Standards
Step 1: Create Filename Generator Function
Create lib/file-naming.php:
phpCopy
<?php
/**
 * File Naming Standards
 * Chapter 11.1
 */

/**
 * Generate standardized filename for archive
 * @param string $title Original title/query
 * @param string $platform Source platform
 * @param string $timestamp ISO timestamp
 * @param int $sequence Optional sequence number for collisions
 * @return string Safe filename
 */
function generateArchiveFilename($title, $platform, $timestamp, $sequence = 0) {
    // Parse timestamp components
    $date = date('Y-m-d', strtotime($timestamp));
    $time = date('H-i-s', strtotime($timestamp));
    
    // Sanitize title
    $safeTitle = sanitizeFilename($title);
    
    // Truncate title to reasonable length (leave room for date/time/ext)
    $maxTitleLength = 50;
    $safeTitle = substr($safeTitle, 0, $maxTitleLength);
    
    // Build base filename
    $filename = "{$date}_{$time}_{$safeTitle}";
    
    // Add sequence if needed
    if ($sequence > 0) {
        $filename .= "_{$sequence}";
    }
    
    // Add extension
    $filename .= '.md';
    
    return $filename;
}

/**
 * Sanitize string for safe filename use
 * @param string $input Raw title
 * @return string Safe filename component
 */
function sanitizeFilename($input) {
    // Decode HTML entities
    $input = html_entity_decode($input, ENT_QUOTES, 'UTF-8');
    
    // Convert to ASCII (transliterate accents)
    $input = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $input);
    
    // Replace spaces and separators with underscores
    $input = preg_replace('/[\s\-]+/', '_', $input);
    
    // Remove filesystem-illegal characters
    $input = preg_replace('/[^a-zA-Z0-9_]/', '', $input);
    
    // Collapse multiple underscores
    $input = preg_replace('/_+/', '_', $input);
    
    // Trim underscores from ends
    $input = trim($input, '_');
    
    // Ensure not empty
    if (empty($input)) {
        $input = 'untitled';
    }
    
    // Lowercase for consistency
    $input = strtolower($input);
    
    return $input;
}

/**
 * Check if filename exists and generate unique variant
 * @param string $folder Target folder path
 * @param string $baseFilename Desired filename
 * @return string Unique filename (may have _N suffix)
 */
function ensureUniqueFilename($folder, $baseFilename) {
    $filepath = $folder . $baseFilename;
    
    if (!file_exists($filepath)) {
        return $baseFilename;
    }
    
    // File exists, add sequence number
    $info = pathinfo($baseFilename);
    $name = $info['filename'];
    $ext = isset($info['extension']) ? '.' . $info['extension'] : '';
    
    $sequence = 1;
    do {
        $newFilename = "{$name}_{$sequence}{$ext}";
        $filepath = $folder . $newFilename;
        $sequence++;
    } while (file_exists($filepath));
    
    return $newFilename;
}

/**
 * Parse filename to extract metadata
 * @param string $filename Filename to parse
 * @return array|false Parsed components or false
 */
function parseArchiveFilename($filename) {
    // Remove extension
    $basename = pathinfo($filename, PATHINFO_FILENAME);
    
    // Pattern: YYYY-MM-DD_HH-MM-SS_title_sequence
    $pattern = '/^(\d{4}-\d{2}-\d{2})_(\d{2}-\d{2}-\d{2})_(.+?)(?:_(\d+))?$/';
    
    if (preg_match($pattern, $basename, $matches)) {
        return [
            'date' => $matches[1],
            'time' => str_replace('-', ':', $matches[2]),
            'title' => str_replace('_', ' ', $matches[3]),
            'sequence' => isset($matches[4]) ? intval($matches[4]) : 0,
            'timestamp' => $matches[1] . ' ' . str_replace('-', ':', $matches[2])
        ];
    }
    
    return false;
}
Step 2: Update Save Functions to Use Naming Standard
Modify saveParsedEmail() in lib/imap-connection.php:
phpCopy
require_once __DIR__ . '/file-naming.php';

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
    
    // Generate filename using standard
    $baseFilename = generateArchiveFilename(
        $parsed['title'],
        $parsed['platform'],
        $parsed['date']
    );
    
    // Ensure uniqueness
    $filename = ensureUniqueFilename($folderPath, $baseFilename);
    $filepath = $folderPath . $filename;
    
    // ... rest of save logic ...
    
    echo "✅ Saved to: $filepath\n";
    return true;
}
Step 3: Create Naming Test Script
Create test-naming.php:
phpCopy
<?php
require_once __DIR__ . '/lib/file-naming.php';

header('Content-Type: text/plain');

echo "=== Filename Generation Tests ===\n\n";

$testCases = [
    [
        'title' => 'Explain quantum computing in simple terms',
        'platform' => 'chatgpt',
        'timestamp' => '2026-03-16 14:30:45'
    ],
    [
        'title' => 'What are the implications of AGI?',
        'platform' => 'claude',
        'timestamp' => '2026-03-16 14:35:12'
    ],
    [
        'title' => 'Café & Résumé: Special Chars Test!!!',
        'platform' => 'email',
        'timestamp' => '2026-03-16 14:40:00'
    ],
    [
        'title' => 'A very long title that exceeds the character limit and should be truncated properly',
        'platform' => 'gemini',
        'timestamp' => '2026-03-16 14:45:30'
    ]
];

foreach ($testCases as $i => $test) {
    echo "Test " . ($i + 1) . ":\n";
    echo "  Title: {$test['title']}\n";
    
    $filename = generateArchiveFilename(
        $test['title'],
        $test['platform'],
        $test['timestamp']
    );
    
    echo "  Filename: $filename\n";
    
    // Verify parseability
    $parsed = parseArchiveFilename($filename);
    if ($parsed) {
        echo "  Parsed back: {$parsed['date']} {$parsed['time']} - {$parsed['title']}\n";
    }
    
    echo "\n";
}

// Test collision handling
echo "=== Collision Test ===\n";
$folder = __DIR__ . '/test-output/';
if (!is_dir($folder)) mkdir($folder);

$baseName = generateArchiveFilename('Test Title', 'chatgpt', '2026-03-16 10:00:00');
echo "Base filename: $baseName\n";

// Create dummy files to force collision
touch($folder . $baseName);
$unique1 = ensureUniqueFilename($folder, $baseName);
echo "After collision 1: $unique1\n";

touch($folder . $unique1);
$unique2 = ensureUniqueFilename($folder, $baseName);
echo "After collision 2: $unique2\n";

// Cleanup
array_map('unlink', glob("$folder/*"));
rmdir($folder);

echo "\nAll tests complete.\n";
What this controls or affects:
All archive files now follow a consistent, parseable naming convention. Files sort chronologically by default. Collisions are handled automatically. Special characters are safely transliterated or removed.
What goes wrong when this is misunderstood:
iconv() not available on server → use fallback regex replacement
pathinfo() behavior varies by PHP version → test on your server
Empty title after sanitization → always provide fallback
Timezone confusion → store all timestamps in UTC, convert for display
Concept Lock-In:
Filename generation must be idempotent—same inputs always produce same output. Uniqueness is ensured by checking filesystem, not by randomness. Parsing must be the inverse of generation—round-trip should preserve essential metadata.

11.2 The Folder Structure by Platform
What this is:
A hierarchical directory organization that separates captures by source platform, then by date, enabling efficient browsing, permission management, and storage scaling.
Where this exists in the real world:
Think of a large office filing system. Top level: departments (platforms). Second level: years. Third level: months or projects. You can navigate to any document quickly, and each department controls their own space.
How you encounter this:
You will implement a three-level structure: storage/chats/{platform}/{date}/{files}. This keeps each platform's captures together, prevents one platform from overwhelming others, and allows date-based archiving or cleanup.
CLICK-BY-CLICK: Implementing Hierarchical Storage
Step 1: Create Folder Structure Manager
Create lib/storage-manager.php:
phpCopy
<?php
/**
 * Storage Manager - Folder Structure & Organization
 * Chapter 11.2
 */

define('STORAGE_ROOT', realpath(__DIR__ . '/../storage') . '/');

/**
 * Get platform storage path
 * @param string $platform Platform name
 * @return string Full path to platform folder
 */
function getPlatformPath($platform) {
    $safePlatform = preg_replace('/[^a-z0-9]/', '', strtolower($platform));
    $path = STORAGE_ROOT . 'chats/' . $safePlatform . '/';
    
    ensureDirectoryExists($path);
    return $path;
}

/**
 * Get dated storage path (platform/date hierarchy)
 * @param string $platform Platform name
 * @param string $date Date string (Y-m-d)
 * @return string Full path to dated folder
 */
function getDatedPath($platform, $date) {
    $platformPath = getPlatformPath($platform);
    
    // Parse date components
    $dateObj = new DateTime($date);
    $year = $dateObj->format('Y');
    $month = $dateObj->format('m');
    $day = $dateObj->format('d');
    
    // Build hierarchy: platform/YYYY/MM/DD/
    $path = $platformPath . $year . '/' . $month . '/' . $day . '/';
    
    ensureDirectoryExists($path);
    return $path;
}

/**
 * Ensure directory exists (create with permissions if not)
 * @param string $path Directory path
 * @return bool Success
 */
function ensureDirectoryExists($path) {
    if (is_dir($path)) {
        return true;
    }
    
    // Create with 0755, recursive
    return mkdir($path, 0755, true);
}

/**
 * Get all platform folders
 * @return array List of platform names
 */
function getAllPlatforms() {
    $chatsPath = STORAGE_ROOT . 'chats/';
    
    if (!is_dir($chatsPath)) {
        return [];
    }
    
    $platforms = [];
    $items = scandir($chatsPath);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        if (is_dir($chatsPath . $item)) {
            $platforms[] = $item;
        }
    }
    
    return $platforms;
}

/**
 * Get storage statistics
 * @return array Statistics by platform
 */
function getStorageStats() {
    $stats = [];
    $platforms = getAllPlatforms();
    
    foreach ($platforms as $platform) {
        $path = getPlatformPath($platform);
        $stats[$platform] = [
            'file_count' => 0,
            'total_size' => 0,
            'oldest_file' => null,
            'newest_file' => null
        ];
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'md') {
                $stats[$platform]['file_count']++;
                $stats[$platform]['total_size'] += $file->getSize();
                
                $mtime = $file->getMTime();
                if (!$stats[$platform]['oldest_file'] || $mtime < $stats[$platform]['oldest_file']) {
                    $stats[$platform]['oldest_file'] = $mtime;
                }
                if (!$stats[$platform]['newest_file'] || $mtime > $stats[$platform]['newest_file']) {
                    $stats[$platform]['newest_file'] = $mtime;
                }
            }
        }
    }
    
    return $stats;
}
Step 2: Update Save Functions to Use Structure
Modify save functions to use dated paths:
phpCopy
function saveParsedEmail($parsed) {
    // Use dated path for organization
    $folderPath = getDatedPath($parsed['platform'], $parsed['date']);
    
    // Generate and ensure unique filename
    $baseFilename = generateArchiveFilename(
        $parsed['title'],
        $parsed['platform'],
        $parsed['date']
    );
    
    $filename = ensureUniqueFilename($folderPath, $baseFilename);
    $filepath = $folderPath . $filename;
    
    // ... write file logic ...
    
    return $filepath;
}
Step 3: Create Folder Structure Visualization
Create view-structure.php:
phpCopy
<?php
require_once __DIR__ . '/lib/storage-manager.php';

header('Content-Type: text/plain');

echo "=== Storage Structure ===\n\n";

function displayTree($path, $prefix = '') {
    $items = scandir($path);
    $items = array_diff($items, ['.', '..']);
    
    // Sort: directories first, then files
    $dirs = [];
    $files = [];
    
    foreach ($items as $item) {
        if (is_dir($path . $item)) {
            $dirs[] = $item;
        } else {
            $files[] = $item;
        }
    }
    
    sort($dirs);
    sort($files);
    
    $all = array_merge($dirs, $files);
    $count = count($all);
    
    foreach ($all as $i => $item) {
        $isLast = ($i === $count - 1);
        $connector = $isLast ? '└── ' : '├── ';
        
        echo $prefix . $connector . $item . "\n";
        
        if (is_dir($path . $item)) {
            $extension = $isLast ? '    ' : '│   ';
            displayTree($path . $item . '/', $prefix . $extension);
        }
    }
}

$root = STORAGE_ROOT;
echo $root . "\n";
displayTree($root);

echo "\n=== Statistics ===\n";
$stats = getStorageStats();

foreach ($stats as $platform => $data) {
    echo "\n$platform:\n";
    echo "  Files: " . $data['file_count'] . "\n";
    echo "  Size: " . formatBytes($data['total_size']) . "\n";
    if ($data['oldest_file']) {
        echo "  Range: " . date('Y-m-d', $data['oldest_file']) . 
             " to " . date('Y-m-d', $data['newest_file']) . "\n";
    }
}

function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $unit = 0;
    while ($bytes >= 1024 && $unit < count($units) - 1) {
        $bytes /= 1024;
        $unit++;
    }
    return round($bytes, 2) . ' ' . $units[$unit];
}
Step 4: Initialize Complete Structure
Run this to create all platform folders:
phpCopy
<?php
require_once __DIR__ . '/lib/storage-manager.php';

$platforms = ['chatgpt', 'claude', 'gemini', 'perplexity', 'email', 'manual'];

foreach ($platforms as $platform) {
    $path = getPlatformPath($platform);
    echo "Created: $path\n";
}

// Create dated folder for today
$today = date('Y-m-d');
foreach ($platforms as $platform) {
    $path = getDatedPath($platform, $today);
    echo "Created: $path\n";
}

echo "\nStructure initialized.\n";
What this controls or affects:
Your storage now scales efficiently. Each platform isolated. Date hierarchy prevents any single folder from accumulating thousands of files (which slows file browsers). Easy to archive old years or delete specific date ranges.
What goes wrong when this is misunderstood:
Too deep hierarchy → excessive path length, navigation fatigue
No platform separation → impossible to browse by source
Flat structure → folders with 10,000+ files, performance degradation
Wrong date format → March sorts after April (must use YYYY-MM-DD)
Concept Lock-In:
Filesystem hierarchy is access optimization. Humans navigate by platform and date. Scripts access by full path. The structure serves both. Depth (3 levels) balances granularity with navigation overhead. ISO date format (YYYY-MM-DD) sorts correctly as strings.

11.3 Creating Business Profile Folders
What this is:
An orthogonal folder structure that organizes captures by business context or project, separate from platform organization, enabling cross-platform project views.
Where this exists in the real world:
Think of a matrix organization. You have departments (platforms) and projects (business contexts). Each employee (capture) belongs to both. You need to find all work on Project X regardless of department, or all work in Department Y regardless of project.
How you encounter this:
You will create a parallel structure under storage/business-profiles/{business-name}/ containing symlinks or copies of relevant captures. Each capture can be tagged with a business context during capture, and the system ensures it appears in both platform and business views.
CLICK-BY-CLICK: Implementing Business Context Organization
Step 1: Create Business Profile Manager
Add to lib/storage-manager.php:
phpCopy
<?php
// ... existing code ...

define('BUSINESS_ROOT', STORAGE_ROOT . 'business-profiles/');

/**
 * Get business profile path
 * @param string $businessName Business or project name
 * @return string Full path to business folder
 */
function getBusinessPath($businessName) {
    $safeName = sanitizeFilename($businessName);
    $path = BUSINESS_ROOT . $safeName . '/';
    
    ensureDirectoryExists($path);
    return $path;
}

/**
 * Save capture with business context
 * @param array $data Capture data
 * @param string $businessName Business context
 * @return array Paths where file was saved
 */
function saveWithBusinessContext($data, $businessName = 'General') {
    $savedPaths = [];
    
    // 1. Save to platform location (primary)
    $platformPath = getDatedPath($data['platform'], $data['date']);
    $filename = ensureUniqueFilename(
        $platformPath,
        generateArchiveFilename($data['title'], $data['platform'], $data['date'])
    );
    
    $filepath = $platformPath . $filename;
    // ... write file to $filepath ...
    $savedPaths['platform'] = $filepath;
    
    // 2. Create business profile entry
    if ($businessName && $businessName !== 'General') {
        $businessPath = getBusinessPath($businessName);
        
        // Create dated subfolder in business profile
        $dateObj = new DateTime($data['date']);
        $businessDatedPath = $businessPath . $dateObj->format('Y/m/');
        ensureDirectoryExists($businessDatedPath);
        
        // Create symlink or copy
        $businessFilename = $data['platform'] . '_' . $filename;
        $businessFilepath = $businessDatedPath . $businessFilename;
        
        // Use copy (more portable than symlink)
        copy($filepath, $businessFilepath);
        $savedPaths['business'] = $businessFilepath;
        
        // Update business index
        updateBusinessIndex($businessName, $filepath, $data);
    }
    
    return $savedPaths;
}

/**
 * Update business profile index
 * @param string $businessName Business name
 * @param string $filepath Path to capture file
 * @param array $data Capture metadata
 */
function updateBusinessIndex($businessName, $filepath, $data) {
    $indexPath = getBusinessPath($businessName) . 'index.json';
    
    $entry = [
        'file' => $filepath,
        'title' => $data['title'],
        'platform' => $data['platform'],
        'date' => $data['date'],
        'added' => date('c')
    ];
    
    // Read existing index
    $index = [];
    if (file_exists($indexPath)) {
        $index = json_decode(file_get_contents($indexPath), true) ?: [];
    }
    
    // Add entry
    $index[] = $entry;
    
    // Save index
    file_put_contents($indexPath, json_encode($index, JSON_PRETTY_PRINT));
}

/**
 * Get all business profiles
 * @return array List of business names
 */
function getAllBusinessProfiles() {
    if (!is_dir(BUSINESS_ROOT)) {
        return [];
    }
    
    $profiles = [];
    $items = scandir(BUSINESS_ROOT);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || $item === 'index.json') continue;
        if (is_dir(BUSINESS_ROOT . $item)) {
            $profiles[] = str_replace('_', ' ', $item);
        }
    }
    
    return $profiles;
}

/**
 * Get captures for specific business
 * @param string $businessName Business name
 * @param int $limit Max results
 * @return array Capture files
 */
function getBusinessCaptures($businessName, $limit = 50) {
    $path = getBusinessPath($businessName);
    $indexPath = $path . 'index.json';
    
    if (!file_exists($indexPath)) {
        return [];
    }
    
    $index = json_decode(file_get_contents($indexPath), true) ?: [];
    
    // Sort by date descending
    usort($index, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    return array_slice($index, 0, $limit);
}
Step 2: Update Capture Functions to Support Business Context
Modify your capture functions to accept and use business context:
phpCopy
// In email processor
function saveParsedEmail($parsed) {
    $business = $parsed['business'] ?? 'General';
    return saveWithBusinessContext($parsed, $business);
}

// In extension background script (update payload)
// Add to capture payload in Chapter 7:
// business: data.business || config.defaultBusiness
Step 3: Create Business Profile Dashboard API
Create api/business.php:
phpCopy
<?php
/**
 * Business Profile API
 * Chapter 11.3
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../lib/storage-manager.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        echo json_encode([
            'success' => true,
            'profiles' => getAllBusinessProfiles()
        ]);
        break;
        
    case 'captures':
        $business = $_GET['name'] ?? '';
        if (!$business) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Business name required']);
            break;
        }
        
        $captures = getBusinessCaptures($business, $_GET['limit'] ?? 50);
        echo json_encode([
            'success' => true,
            'business' => $business,
            'captures' => $captures
        ]);
        break;
        
    case 'create':
        $name = $_POST['name'] ?? '';
        if (!$name) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Name required']);
            break;
        }
        
        $path = getBusinessPath($name);
        echo json_encode([
            'success' => true,
            'name' => $name,
            'path' => $path
        ]);
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
What this controls or affects:
You can now organize captures by project/client alongside platform organization. A capture from ChatGPT about "Project Alpha" appears in both chats/chatgpt/ and business-profiles/project_alpha/. The index.json enables fast listing without filesystem scanning.
What goes wrong when this is misunderstood:
Copy vs symlink → copies use double storage, symlinks break if primary moves
Index out of sync → filesystem and JSON mismatch, need rebuild function
Business name sanitization → "Client A" and "client_a" become different folders
Circular references → business profile containing its own index recursively
Concept Lock-In:
Business context is metadata tagging, not physical relocation. The primary file lives in platform/date hierarchy. Business folders contain references (copies or links). This preserves the canonical location while enabling alternate views. The index.json is a denormalized cache—rebuildable from filesystem if corrupted.

11.4 Moving from "Raw" to "Processed" to "Polished"
What this is:
A workflow state system that tracks the maturity level of archived content: Raw (automatically captured), Processed (reviewed and tagged), and Polished (edited and finalized for presentation).
Where this exists in the real world:
Think of a manufacturing line. Raw materials (captured chats) enter. They are processed (reviewed, tagged with business context). Finally, polished products (finished research summaries) exit. Each stage has different storage, permissions, and access patterns.
How you encounter this:
You will implement three storage areas: storage/raw/ (automatic captures), storage/processed/ (reviewed and organized), and storage/polished/ (final outputs). Files move between stages via API calls or dashboard actions, with metadata tracking their state history.
CLICK-BY-CLICK: Implementing State Workflow
Step 1: Create State Management System
Create lib/workflow-manager.php:
phpCopy
<?php
/**
 * Workflow State Manager
 * Chapter 11.4
 */

define('STAGE_RAW', 'raw');
define('STAGE_PROCESSED', 'processed');
define('STAGE_POLISHED', 'polished');

define('STAGE_PATHS', [
    STAGE_RAW => STORAGE_ROOT . 'raw/',
    STAGE_PROCESSED => STORAGE_ROOT . 'processed/',
    STAGE_POLISHED => STORAGE_ROOT . 'polished/'
]);

/**
 * Initialize stage folders
 */
function initializeWorkflowStages() {
    foreach (STAGE_PATHS as $stage => $path) {
        ensureDirectoryExists($path);
        
        // Create platform subfolders in each stage
        $platforms = ['chatgpt', 'claude', 'gemini', 'perplexity', 'email', 'manual'];
        foreach ($platforms as $platform) {
            ensureDirectoryExists($path . $platform . '/');
        }
    }
}

/**
 * Get file's current stage
 * @param string $filepath File path
 * @return string|false Stage name or false if not in workflow
 */
function getFileStage($filepath) {
    foreach (STAGE_PATHS as $stage => $basePath) {
        if (strpos($filepath, $basePath) === 0) {
            return $stage;
        }
    }
    return false;
}

/**
 * Move file to different stage
 * @param string $filepath Current file path
 * @param string $targetStage Target stage (raw/processed/polished)
 * @param array $metadata Updates to apply
 * @return string|false New filepath or false on failure
 */
function moveToStage($filepath, $targetStage, $metadata = []) {
    if (!isset(STAGE_PATHS[$targetStage])) {
        return false;
    }
    
    if (!file_exists($filepath)) {
        return false;
    }
    
    // Determine platform from current path
    $currentStage = getFileStage($filepath);
    $platform = 'unknown';
    
    foreach (['chatgpt', 'claude', 'gemini', 'perplexity', 'email', 'manual'] as $p) {
        if (strpos($filepath, "/$p/") !== false) {
            $platform = $p;
            break;
        }
    }
    
    // Build target path
    $targetBase = STAGE_PATHS[$targetStage] . $platform . '/';
    $filename = basename($filepath);
    
    // If metadata updates provided, rewrite file content
    if (!empty($metadata)) {
        $content = file_get_contents($filepath);
        
        // Update metadata section
        foreach ($metadata as $key => $value) {
            $pattern = "/\\*\\*$key:\\*\\* .*/m";
            $replacement = "**$key:** $value";
            
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            } else {
                // Add to metadata section (after first ---)
                $content = preg_replace(
                    '/^(---\n\n)/m',
                    "---\n**$key:** $value  \n\n",
                    $content,
                    1
                );
            }
        }
        
        // Add stage transition note
        $transitionNote = "\n\n---\n\n*Moved to $targetStage stage on " . date('c') . "*";
        $content .= $transitionNote;
        
        // Write to new location
        ensureDirectoryExists($targetBase);
        $newPath = ensureUniqueFilename($targetBase, $filename);
        
        if (file_put_contents($newPath, $content)) {
            // Remove from old location if different stage
            if ($currentStage && $currentStage !== $targetStage) {
                unlink($filepath);
            }
            return $newPath;
        }
    } else {
        // Simple move, no content change
        ensureDirectoryExists($targetBase);
        $newPath = ensureUniqueFilename($targetBase, $filename);
        
        if (rename($filepath, $newPath)) {
            return $newPath;
        }
    }
    
    return false;
}

/**
 * Get all files in a stage
 * @param string $stage Stage name
 * @param string $platform Optional platform filter
 * @return array File list with metadata
 */
function getFilesByStage($stage, $platform = null) {
    if (!isset(STAGE_PATHS[$stage])) {
        return [];
    }
    
    $basePath = STAGE_PATHS[$stage];
    
    if ($platform) {
        $basePath .= $platform . '/';
    }
    
    if (!is_dir($basePath)) {
        return [];
    }
    
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'md') {
            $parsed = parseArchiveFilename($file->getFilename());
            
            $files[] = [
                'path' => $file->getPathname(),
                'filename' => $file->getFilename(),
                'platform' => $platform ?: detectPlatformFromPath($file->getPathname()),
                'size' => $file->getSize(),
                'modified' => $file->getMTime(),
                'parsed' => $parsed
            ];
        }
    }
    
    // Sort by date descending
    usort($files, function($a, $b) {
        return strtotime($b['parsed']['timestamp'] ?? 0) - strtotime($a['parsed']['timestamp'] ?? 0);
    });
    
    return $files;
}

/**
 * Detect platform from file path
 */
function detectPlatformFromPath($path) {
    foreach (['chatgpt', 'claude', 'gemini', 'perplexity', 'email', 'manual'] as $platform) {
        if (strpos($path, "/$platform/") !== false) {
            return $platform;
        }
    }
    return 'unknown';
}

/**
 * Get workflow statistics
 * @return array Counts by stage
 */
function getWorkflowStats() {
    $stats = [];
    
    foreach (STAGE_PATHS as $stage => $path) {
        $stats[$stage] = [
            'count' => 0,
            'size' => 0
        ];
        
        if (!is_dir($path)) continue;
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $stats[$stage]['count']++;
                $stats[$stage]['size'] += $file->getSize();
            }
        }
    }
    
    return $stats;
}
Step 2: Create Workflow API
Create api/workflow.php:
phpCopy
<?php
/**
 * Workflow State API
 * Chapter 11.4
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../lib/workflow-manager.php';
require_once __DIR__ . '/../lib/file-naming.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'stats':
        echo json_encode([
            'success' => true,
            'stats' => getWorkflowStats()
        ]);
        break;
        
    case 'list':
        $stage = $_GET['stage'] ?? STAGE_RAW;
        $platform = $_GET['platform'] ?? null;
        
        $files = getFilesByStage($stage, $platform);
        
        echo json_encode([
            'success' => true,
            'stage' => $stage,
            'platform' => $platform,
            'count' => count($files),
            'files' => $files
        ]);
        break;
        
    case 'move':
        $filepath = $_POST['filepath'] ?? '';
        $targetStage = $_POST['target_stage'] ?? '';
        $metadata = $_POST['metadata'] ?? [];
        
        if (!$filepath || !$targetStage) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'filepath and target_stage required']);
            break;
        }
        
        // Security: ensure path is within storage
        $realPath = realpath($filepath);
        if (!$realPath || strpos($realPath, STORAGE_ROOT) !== 0) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Invalid path']);
            break;
        }
        
        $newPath = moveToStage($realPath, $targetStage, $metadata);
        
        if ($newPath) {
            echo json_encode([
                'success' => true,
                'new_path' => $newPath,
                'stage' => $targetStage
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Move failed']);
        }
        break;
        
    case 'init':
        initializeWorkflowStages();
        echo json_encode(['success' => true, 'message' => 'Workflow stages initialized']);
        break;
        
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
Step 3: Update Dashboard to Show Stage Filters
Modify your dashboard JavaScript to support stage filtering:
JavaScriptCopy
// Add to dashboard panel HTML
<div class="stage-filters">
    <button onclick="filterByStage('raw')" class="stage-btn active">🪨 Raw</button>
    <button onclick="filterByStage('processed')" class="stage-btn">💠 Processed</button>
    <button onclick="filterByStage('polished')" class="stage-btn">✨ Polished</button>
</div>

// Add to dashboard JS
async function filterByStage(stage) {
    const response = await fetch(`api/workflow.php?action=list&stage=${stage}`);
    const data = await response.json();
    
    // Update UI with files from selected stage
    displayFiles(data.files, stage);
}

async function moveToStage(filepath, targetStage) {
    const response = await fetch('api/workflow.php?action=move', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `filepath=${encodeURIComponent(filepath)}&target_stage=${targetStage}`
    });
    
    const result = await response.json();
    if (result.success) {
        showToast(`Moved to ${targetStage}`);
        refreshFileList();
    }
}
Step 4: Initialize and Test Workflow
Run initialization:
phpCopy
<?php
require_once __DIR__ . '/lib/workflow-manager.php';

initializeWorkflowStages();

echo "Workflow stages initialized:\n";
foreach (STAGE_PATHS as $stage => $path) {
    echo "- $stage: $path\n";
}

$stats = getWorkflowStats();
echo "\nCurrent stats:\n";
print_r($stats);
What this controls or affects:
Your archive now has a maturity workflow. Raw captures arrive automatically. You review and move to Processed when tagged with business context. You edit and move to Polished when finalized. Each stage can have different access permissions, backup schedules, or retention policies.
What goes wrong when this is misunderstood:
Moving without copying → data loss if target write fails mid-move
Stage paths overlapping → file appears in multiple stages incorrectly
No rollback mechanism → accidental moves hard to undo
Metadata updates corrupting file format → must preserve markdown structure
Concept Lock-In:
Workflow stages are organizational, not operational. The same file content moves through stages, gaining metadata and context. Raw = unverified (automatic). Processed = verified (human-reviewed). Polished = finalized (edited). This maps to data quality levels: bronze, silver, gold.

WORKBOOK EXERCISES
Exercise 11.1: Filename Round-Trip
Take this title: "What's the difference between AI and ML? (2026 Edition)"
Run it through generateArchiveFilename()
Verify output is filesystem-safe
Run output through parseArchiveFilename()
Verify you can reconstruct the original intent
Exercise 11.2: Storage Math
Calculate storage requirements for:
100 captures per day
Average 10 KB per capture
3 stages (raw, processed, polished—assume 20% of raw moves to each)
365 days retention
What is total storage needed? What if retention is 3 years?
Exercise 11.3: Business Profile Design
Design a business profile structure for these clients:
"Acme Corp"
"Smith & Associates"
"2026 Marketing Campaign"
What are the folder names? What happens with the & character?
Exercise 11.4: Workflow State Machine
Draw the state transitions:
Can a file move from Raw → Polished directly?
What happens if you try to move Polished → Raw?
Should transitions be reversible? Why or why not?
Exercise 11.5: Cross-Platform Query
You need to find all captures about "quantum computing" from March 2026, regardless of platform or stage. Write the search algorithm using the structures from this chapter.

CHAPTER 11 MEMORY DUMP / RESTORE POINT
COPY EVERYTHING BELOW THIS LINE TO SAVE YOUR PROGRESS:
plainCopy
ARCHAEOLOGY INTELLIGENCE PLATFORM - CHAPTER 11 COMPLETE
Date: [CURRENT DATE]
Status: File organization system fully implemented

FILES CREATED:
- lib/file-naming.php (filename generation, sanitization, parsing)
- lib/storage-manager.php (folder paths, hierarchy, business profiles)
- lib/workflow-manager.php (stage management, state transitions)
- api/business.php (business profile API)
- api/workflow.php (workflow stage API)

CONCEPTS LOCKED IN:
- Filename format: YYYY-MM-DD_HH-MM-SS_sanitized_title_sequence.md
- Sanitization: transliterate → replace spaces → remove illegal chars → lowercase
- Hierarchy: storage/chats/{platform}/{YYYY}/{MM}/{DD}/{files}
- Business profiles: storage/business-profiles/{name}/ with index.json
- Workflow stages: raw/ → processed/ → polished/
- Stage transitions update metadata and preserve history
- Copies in business folders, moves between stages
- Index files are denormalized caches (rebuildable)

STORAGE STRUCTURE FINALIZED:
storage/
  raw/
    chatgpt/YYYY/MM/DD/*.md
    claude/YYYY/MM/DD/*.md
    gemini/YYYY/MM/DD/*.md
    perplexity/YYYY/MM/DD/*.md
    email/YYYY/MM/DD/*.md
    manual/YYYY/MM/DD/*.md
  processed/
    [same platform/date hierarchy]
  polished/
    [same platform/date hierarchy]
  business-profiles/
    {business-name}/
      YYYY/MM/*.md (copies with platform_ prefix)
      index.json

WORKFLOW RULES:
- Raw: Automatic captures (extension, email, manual upload)
- Processed: Human-reviewed, tagged with business context
- Polished: Edited, finalized, presentation-ready
- Transitions: raw→processed→polished (can skip, no reverse)
- Metadata tracks stage history in file footer

NEXT CHAPTER: Chapter 12 - Connecting Everything Together
- Will integrate all components into unified system
- Will implement end-to-end testing procedures
- Will create troubleshooting guides
- Will establish backup strategies

RESTORE INSTRUCTIONS:
To restore this state in a new chat, paste this memory dump and say:
"I am restoring Chapter 11 of the Archaeology Intelligence Platform manual.
I have implemented complete file organization with standardized naming,
platform/date hierarchy, business profile cross-referencing,
and raw/processed/polished workflow stages.
All storage structures are created and API endpoints functional.
Please continue with Chapter 12: Connecting Everything Together."

CHAPTER 11 COMPLETE
What Chapter 11 Contains (Per TOC):
✅ 11.1 How Files Will Be Named - Standardized filename generation
✅ 11.2 The Folder Structure by Platform - Hierarchical storage organization
✅ 11.3 Creating Business Profile Folders - Cross-platform business context
✅ 11.4 Moving from "Raw" to "Processed" to "Polished" - Workflow state management
Files Created:
lib/file-naming.php - Filename standards
lib/storage-manager.php - Storage hierarchy
lib/workflow-manager.php - Stage workflow
api/business.php - Business profile API
api/workflow.php - Workflow API
Storage System Features:
ISO date-first filenames (chronological sorting)
3-level hierarchy (platform/year/month/day)
Business profile cross-referencing
Raw/Processed/Polished workflow stages
Metadata preservation through transitions
Ready for Chapter 12: Connecting Everything Together (system integration, testing, troubleshooting, backup strategies)

Should I proceed with Chapter 12, or do you need any adjustments to Chapter 11?

