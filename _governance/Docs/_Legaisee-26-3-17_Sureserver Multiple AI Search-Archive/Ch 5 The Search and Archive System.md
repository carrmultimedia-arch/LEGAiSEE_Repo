CHAPTER 5: The Search and Archive System
5.1 Understanding How Search Will Work
What this is:
A system for finding captured chats across all platforms, dates, and business contexts. Search scans file contents, names, and metadata to surface relevant conversations.
Where this exists in the real world:
Every content management system has search. The pattern: user enters query → system scans index → returns ranked results with context snippets.
How you encounter this:
You will build: (1) search input interface with filters, (2) PHP backend that scans files, (3) results display with highlighting, (4) click-to-view functionality.
What this controls or affects:
Retrieval of your accumulated knowledge. Without search, archives become unnavigable as they grow. With search, any past insight is findable in seconds.
What goes wrong when this is misunderstood:
Scanning files synchronously → timeout on large archives
No result limiting → browser crash on 10,000 results
Missing context snippets → can't identify which result is right
Case-sensitive matching → misses valid results
No filtering → overwhelmed by irrelevant results
Concept Lock-In:
Search is a pipeline: Query → Filter → Scan → Rank → Format → Display. Each stage transforms data. Breakage at any stage breaks the whole system.

5.2 Creating the Search Interface
CLICK-BY-CLICK: Updating index.html with Working Search
Replace the placeholder search section in index.html with this working version:
HTMLPreviewCopy
   <!-- PANEL 1: SEARCH (Working Version) -->
    <section id="search-panel" class="panel active">
        <header class="panel-header">
            <h2>🔍 Search Archives</h2>
            <p class="subtitle">Find insights across all captured conversations</p>
        </header>
        
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search all chats, summaries, business profiles...">
                <button class="btn-primary" onclick="searchArchives()">Search</button>
            </div>
            
            <div class="filters">
                <select id="filterPlatform">
                    <option value="all">All Platforms</option>
                    <option value="chatgpt">ChatGPT</option>
                    <option value="claude">Claude</option>
                    <option value="gemini">Gemini</option>
                    <option value="perplexity">Perplexity</option>
                </select>
                
                <select id="filterDate">
                    <option value="all">Any Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                
                <select id="filterStage">
                    <option value="all">All Stages</option>
                    <option value="raw">🪨 Raw</option>
                    <option value="processed">💠 Processed</option>
                </select>
            </div>
        </div>
        
        <div id="searchResults" class="results-container">
            <div class="empty-state">
                <span class="empty-icon">🔍</span>
                <p>Enter a search term to find archived conversations</p>
            </div>
        </div>
    </section>
Step 2: Add Search CSS to style.css
Add to bottom of style.css:
cssCopy
/* ==========================================
   CHAPTER 5: SEARCH STYLES
   ========================================== */

.search-container {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}

.search-box {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

.search-box input {
    flex: 1;
    padding: 14px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 16px;
    background: var(--bg-secondary);
}

.search-box input:focus {
    outline: none;
    border-color: var(--accent-cut);
    background: var(--bg-primary);
}

.btn-primary {
    padding: 14px 28px;
    background: var(--text-primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary:hover {
    background: #000;
}

.filters {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filters select {
    padding: 10px 14px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background: var(--bg-primary);
    color: var(--text-secondary);
    font-size: 14px;
}

.results-container {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    min-height: 300px;
}

.results-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.results-count {
    font-weight: 600;
}

.results-scanned {
    font-size: 13px;
    color: var(--text-muted);
}

.search-result-card {
    padding: 20px;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    transition: all 0.2s;
}

.search-result-card:hover {
    background: var(--bg-secondary);
}

.search-result-card:last-child {
    border-bottom: none;
}

.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.platform-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}

.platform-badge.chatgpt { background: rgba(16, 163, 127, 0.1); color: #10a37f; }
.platform-badge.claude { background: rgba(204, 120, 92, 0.1); color: #cc785c; }
.platform-badge.gemini { background: rgba(66, 133, 244, 0.1); color: #4285f4; }
.platform-badge.perplexity { background: rgba(31, 184, 205, 0.1); color: #1fb8cd; }

.result-date {
    font-size: 13px;
    color: var(--text-muted);
}

.result-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.result-context {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.5;
    background: rgba(255, 215, 0, 0.1);
    padding: 12px;
    border-radius: 8px;
    border-left: 3px solid var(--accent-polished);
}

.result-context mark {
    background: var(--accent-polished);
    color: var(--text-primary);
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: 500;
}

.result-path {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 8px;
    font-family: monospace;
}

.searching-state {
    padding: 40px;
    text-align: center;
    color: var(--accent-raw);
}

.spinner {
    display: inline-block;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

5.3 Building the Archive Browser
CLICK-BY-CLICK: Updating Archives Panel
Replace the placeholder archives section in index.html:
HTMLPreviewCopy
   <!-- PANEL 3: ARCHIVES (Working Browser) -->
    <section id="archives-panel" class="panel">
        <header class="panel-header">
            <h2>🏛️ Browse Archives</h2>
            <p class="subtitle">Organized by platform, date, and business context</p>
        </header>
        
        <div class="archive-browser">
            <div class="folder-tree" id="folderTree">
                <!-- Populated by JavaScript -->
            </div>
            
            <div class="file-preview" id="filePreview">
                <div class="preview-placeholder">
                    <span class="preview-icon">📄</span>
                    <p>Select a file from the folder tree to preview</p>
                </div>
            </div>
        </div>
    </section>
Add Archive Browser CSS to style.css:
cssCopy
/* Archive Browser Styles */

.archive-browser {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    min-height: 500px;
}

.folder-tree {
    padding: 20px;
    border-right: 1px solid var(--border);
    overflow-y: auto;
}

.folder {
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--text-secondary);
}

.folder:hover {
    background: var(--bg-hover);
}

.folder.open {
    color: var(--text-primary);
    font-weight: 500;
}

.folder-toggle {
    font-size: 10px;
    width: 16px;
    text-align: center;
}

.folder-children {
    margin-left: 24px;
    border-left: 1px solid var(--border);
    padding-left: 8px;
}

.file-preview {
    padding: 24px;
    overflow-y: auto;
}

.preview-content {
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

.preview-content h1 {
    font-size: 24px;
    margin-bottom: 16px;
}

.preview-content pre {
    background: var(--bg-secondary);
    padding: 16px;
    border-radius: 8px;
    overflow-x: auto;
}

5.4 The "Recent Captures" Panel
CLICK-BY-CLICK: Updating Recent Panel
Replace placeholder recent section:
HTMLPreviewCopy
   <!-- PANEL 2: RECENT (Working) -->
    <section id="recent-panel" class="panel">
        <header class="panel-header">
            <h2>📄 Recently Captured</h2>
            <p class="subtitle">Latest chats from all platforms</p>
        </header>
        
        <div id="recentChats" class="chats-grid">
            <!-- Populated by JavaScript -->
        </div>
    </section>
Add Recent Panel CSS:
cssCopy
/* Recent Captures Styles */

.chats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}

.chat-card {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.chat-card:hover {
    border-color: var(--border-hover);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.chat-card .platform-badge {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.chat-info {
    flex: 1;
}

.chat-title {
    font-weight: 600;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-meta {
    font-size: 13px;
    color: var(--text-muted);
}

5.5 Connecting Panels to Each Other (JavaScript Implementation)
CLICK-BY-CLICK: Updating app.js with Search, Archive, and Recent Functionality
Replace entire app.js with this Chapter 5 complete version:
JavaScriptCopy
// ARCHAEOLOGY INTELLIGENCE PLATFORM
// Chapter 5: Search and Archive System

// ==========================================
// PANEL NAVIGATION (from Chapter 4)
// ==========================================

function showPanel(panelName) {
    // Hide all panels
    document.querySelectorAll('.panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // Show target panel
    const targetPanel = document.getElementById(panelName + '-panel');
    if (targetPanel) {
        targetPanel.classList.add('active');
    }
    
    // Update sidebar
    document.querySelectorAll('.nav-menu li').forEach(item => {
        item.classList.remove('active');
    });
    
    const clickedItem = event.target.closest('li');
    if (clickedItem) {
        clickedItem.classList.add('active');
    }
    
    // Load panel-specific data
    if (panelName === 'recent') {
        loadRecentChats();
    } else if (panelName === 'archives') {
        loadArchiveTree();
    }
}

// ==========================================
// SEARCH FUNCTIONALITY (5.2)
// ==========================================

async function searchArchives() {
    const query = document.getElementById('searchInput').value.trim();
    const platform = document.getElementById('filterPlatform').value;
    const dateRange = document.getElementById('filterDate').value;
    const stage = document.getElementById('filterStage').value;
    
    const resultsContainer = document.getElementById('searchResults');
    
    // Show searching state
    resultsContainer.innerHTML = `
        <div class="searching-state">
            <span class="spinner">⛏️</span>
            <p>Excavating archives...</p>
        </div>
    `;
    
    try {
        // Build API URL
        const params = new URLSearchParams({
            q: query,
            platform: platform,
            date: dateRange,
            stage: stage
        });
        
        const response = await fetch(`api/search.php?${params.toString()}`);
        const data = await response.json();
        
        displaySearchResults(data);
        
    } catch (error) {
        resultsContainer.innerHTML = `
            <div class="empty-state error">
                <span class="empty-icon">⚠️</span>
                <p>Search failed: ${error.message}</p>
            </div>
        `;
    }
}

function displaySearchResults(data) {
    const container = document.getElementById('searchResults');
    
    if (!data.success || data.total === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <span class="empty-icon">🔍</span>
                <p>${data.message || 'No results found'}</p>
                ${data.scanned ? `<p class="subtext">Searched ${data.scanned} files</p>` : ''}
            </div>
        `;
        return;
    }
    
    const resultsHtml = data.results.map(result => `
        <div class="search-result-card" onclick="viewChat('${result.path}')">
            <div class="result-header">
                <span class="platform-badge ${result.platform}">${result.platform}</span>
                <span class="result-date">${formatDate(result.date)}</span>
            </div>
            <h4 class="result-title">${escapeHtml(result.title)}</h4>
            ${result.context ? `
                <div class="result-context">
                    ${result.context}
                </div>
            ` : ''}
            <div class="result-path">${result.path}</div>
        </div>
    `).join('');
    
    container.innerHTML = `
        <div class="results-header">
            <span class="results-count">${data.total} result${data.total !== 1 ? 's' : ''}</span>
            <span class="results-scanned">(scanned ${data.scanned} files in ${data.executionTimeMs}ms)</span>
        </div>
        ${resultsHtml}
    `;
}

// ==========================================
// RECENT CAPTURES (5.4)
// ==========================================

async function loadRecentChats() {
    const container = document.getElementById('recentChats');
    
    container.innerHTML = `
        <div class="searching-state">
            <span class="spinner">⛏️</span>
            <p>Loading recent captures...</p>
        </div>
    `;
    
    try {
        const response = await fetch('api/search.php?date=all&limit=12&sortBy=date');
        const data = await response.json();
        
        if (!data.success || data.total === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <span class="empty-icon">📭</span>
                    <p>No captures yet</p>
                    <p class="subtext">Complete Chapter 6-8 to enable capture extension</p>
                </div>
            `;
            return;
        }
        
        // Update sidebar badge
        document.querySelector('.badge')?.remove(); // Remove if exists
        const recentNav = document.querySelector('.nav-menu li:nth-child(2)');
        if (recentNav && data.total > 0) {
            const badge = document.createElement('span');
            badge.className = 'badge';
            badge.textContent = Math.min(data.total, 99);
            recentNav.appendChild(badge);
        }
        
        container.innerHTML = data.results.map(chat => `
            <div class="chat-card" onclick="viewChat('${chat.path}')">
                <div class="platform-badge ${chat.platform}">
                    ${getPlatformIcon(chat.platform)}
                </div>
                <div class="chat-info">
                    <div class="chat-title">${escapeHtml(chat.title)}</div>
                    <div class="chat-meta">
                        ${formatDate(chat.date)} • ${formatSize(chat.size)}
                    </div>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        container.innerHTML = `
            <div class="empty-state error">
                <span class="empty-icon">⚠️</span>
                <p>Failed to load recent chats</p>
            </div>
        `;
    }
}

// ==========================================
// ARCHIVE BROWSER (5.3)
// ==========================================

async function loadArchiveTree() {
    const container = document.getElementById('folderTree');
    
    try {
        const response = await fetch('api/tree.php');
        const data = await response.json();
        
        if (!data.success) {
            container.innerHTML = '<p>Error loading archive tree</p>';
            return;
        }
        
        renderTree(container, data.tree);
        
    } catch (error) {
        container.innerHTML = '<p>Failed to load folder tree</p>';
    }
}

function renderTree(container, tree, level = 0) {
    let html = '';
    
    for (const [name, item] of Object.entries(tree)) {
        const isFolder = typeof item === 'object' && !item.path;
        const indent = level * 20;
        
        if (isFolder) {
            html += `
                <div class="folder" style="padding-left: ${indent}px" onclick="toggleFolder(this)">
                    <span class="folder-toggle">▶</span>
                    <span class="folder-icon">📁</span>
                    <span>${name}</span>
                </div>
                <div class="folder-children" style="display: none;">
                    ${renderTree(document.createElement('div'), item, level + 1)}
                </div>
            `;
        } else {
            html += `
                <div class="folder file" style="padding-left: ${indent + 20}px" 
                     onclick="previewFile('${item.path}')">
                    <span class="folder-icon">📄</span>
                    <span>${name}</span>
                </div>
            `;
        }
    }
    
    container.innerHTML = html;
}

function toggleFolder(folderEl) {
    const children = folderEl.nextElementSibling;
    const toggle = folderEl.querySelector('.folder-toggle');
    
    if (children.style.display === 'none') {
        children.style.display = 'block';
        toggle.textContent = '▼';
        folderEl.classList.add('open');
    } else {
        children.style.display = 'none';
        toggle.textContent = '▶';
        folderEl.classList.remove('open');
    }
}

async function previewFile(path) {
    const previewEl = document.getElementById('filePreview');
    
    previewEl.innerHTML = '<p>Loading...</p>';
    
    try {
        const response = await fetch(`api/view.php?path=${encodeURIComponent(path)}`);
        const data = await response.json();
        
        if (data.success) {
            previewEl.innerHTML = `
                <div class="preview-content">
                    <pre>${escapeHtml(data.content)}</pre>
                </div>
            `;
        } else {
            previewEl.innerHTML = `<p>Error: ${data.message}</p>`;
        }
    } catch (error) {
        previewEl.innerHTML = '<p>Failed to load file</p>';
    }
}

// ==========================================
// HELPER FUNCTIONS
// ==========================================

function getPlatformIcon(platform) {
    const icons = {
        'chatgpt': '🟢',
        'claude': '🟠',
        'gemini': '🔵',
        'perplexity': '⚪'
    };
    return icons[platform] || '📄';
}

function formatDate(dateStr) {
    if (!dateStr || dateStr === 'Unknown') return 'Unknown date';
    const date = new Date(dateStr);
    const now = new Date();
    const diff = Math.floor((now - date) / (1000 * 60 * 60 * 24));
    
    if (diff === 0) return 'Today';
    if (diff === 1) return 'Yesterday';
    if (diff < 7) return `${diff} days ago`;
    if (diff < 30) return `${Math.floor(diff / 7)} weeks ago`;
    
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function formatSize(bytes) {
    if (!bytes) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

async function viewChat(path) {
    // For now, just log. In full app, would open modal or navigate
    console.log('View chat:', path);
    alert(`Opening: ${path}\n\n(Full viewer in Chapter 12)`);
}

// ==========================================
// KEYBOARD SHORTCUTS
// ==========================================

document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        // Ctrl+1-5 for panels
        const key = parseInt(e.key);
        if (key >= 1 && key <= 5) {
            e.preventDefault();
            const panels = ['search', 'recent', 'archives', 'excavation', 'businesses'];
            const navItems = document.querySelectorAll('.nav-menu li');
            if (navItems[key - 1]) {
                navItems[key - 1].click();
            }
        }
        
        // Ctrl+Enter to search
        if (e.key === 'Enter' && document.activeElement.id === 'searchInput') {
            searchArchives();
        }
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Chapter 5: Search and Archive System loaded');
});

5.5 Creating Server-Side APIs for Chapter 5
CLICK-BY-CLICK: Creating search.php
phpCopy
<?php
/**
 * ARCHAEOLOGY INTELLIGENCE PLATFORM
 * Chapter 5: Search API
 * File: api/search.php
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('STORAGE_PATH', realpath(__DIR__ . '/../storage/') . '/');

$query = strtolower(trim($_GET['q'] ?? ''));
$platform = $_GET['platform'] ?? 'all';
$dateRange = $_GET['date'] ?? 'all';
$stage = $_GET['stage'] ?? 'all';
$sortBy = $_GET['sortBy'] ?? 'date';
$limit = min(intval($_GET['limit'] ?? 50), 100);

$results = [];
$totalScanned = 0;
$startTime = microtime(true);

// Determine search paths
$searchPaths = [];
if ($stage === 'all' || $stage === 'raw') {
    $searchPaths[] = STORAGE_PATH . 'chats/';
}
if ($stage === 'all' || $stage === 'processed') {
    $searchPaths[] = STORAGE_PATH . 'processed/';
}

// Execute search
foreach ($searchPaths as $basePath) {
    if (!is_dir($basePath)) continue;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if (!$file->isFile() || $file->getExtension() !== 'md') continue;
        
        $totalScanned++;
        
        $metadata = extractMetadata($file->getPathname());
        
        // Apply filters
        if ($platform !== 'all' && $metadata['platform'] !== $platform) continue;
        if (!matchesDateFilter($metadata['date'], $dateRange)) continue;
        
        // Search content
        $match = searchInFile($file->getPathname(), $query);
        
        if (!$match['found'] && !empty($query)) continue;
        
        $metadata['context'] = $match['context'];
        $metadata['relevanceScore'] = $match['score'];
        
        $results[] = $metadata;
        
        if (count($results) >= $limit) break 2;
    }
}

// Sort
usort($results, function($a, $b) use ($sortBy) {
    if ($sortBy === 'date') {
        return strtotime($b['date']) <=> strtotime($a['date']);
    }
    return ($b['relevanceScore'] ?? 0) <=> ($a['relevanceScore'] ?? 0);
});

$executionTime = round((microtime(true) - $startTime) * 1000, 2);

echo json_encode([
    'success' => true,
    'query' => $query,
    'total' => count($results),
    'scanned' => $totalScanned,
    'executionTimeMs' => $executionTime,
    'results' => $results
]);

// Helper functions
function extractMetadata($filepath) {
    $info = pathinfo($filepath);
    $filename = $info['filename'];
    
    // Parse date
    $date = 'Unknown';
    if (preg_match('/^(\d{4}-\d{2}-\d{2})/', $filename, $m)) {
        $date = $m[1];
    }
    
    // Platform from path
    $platform = 'unknown';
    if (strpos($filepath, '/chatgpt/') !== false) $platform = 'chatgpt';
    elseif (strpos($filepath, '/claude/') !== false) $platform = 'claude';
    elseif (strpos($filepath, '/gemini/') !== false) $platform = 'gemini';
    elseif (strpos($filepath, '/perplexity/') !== false) $platform = 'perplexity';
    
    // Title from first line
    $firstLine = '';
    $handle = fopen($filepath, 'r');
    if ($handle) {
        $firstLine = fgets($handle);
        fclose($handle);
    }
    $title = trim(str_replace('#', '', $firstLine)) ?: 'Untitled';
    
    $stats = stat($filepath);
    
    return [
        'filename' => $info['basename'],
        'title' => $title,
        'path' => str_replace(STORAGE_PATH, '', $filepath),
        'platform' => $platform,
        'date' => $date,
        'size' => $stats['size'],
        'modified' => date('c', $stats['mtime'])
    ];
}

function matchesDateFilter($fileDate, $filter) {
    if ($filter === 'all') return true;
    $fileTime = strtotime($fileDate);
    $now = time();
    
    switch($filter) {
        case 'today': return date('Y-m-d', $fileTime) === date('Y-m-d', $now);
        case 'week': return $fileTime > strtotime('-7 days');
        case 'month': return $fileTime > strtotime('-30 days');
        default: return true;
    }
}

function searchInFile($filepath, $query) {
    if (empty($query)) {
        return ['found' => true, 'score' => 0, 'context' => ''];
    }
    
    $content = file_get_contents($filepath);
    $lowerContent = strtolower($content);
    $lowerQuery = strtolower($query);
    
    $count = substr_count($lowerContent, $lowerQuery);
    
    if ($count === 0) {
        return ['found' => false, 'score' => 0, 'context' => ''];
    }
    
    // Extract context
    $pos = strpos($lowerContent, $lowerQuery);
    $start = max(0, $pos - 100);
    $context = substr($content, $start, 250);
    $context = preg_replace('/\s+/', ' ', $context);
    
    // Highlight
    $context = preg_replace(
        '/(' . preg_quote($query, '/') . ')/i',
        '<mark>$1</mark>',
        '...' . $context . '...'
    );
    
    return [
        'found' => true,
        'score' => $count * 10,
        'context' => $context
    ];
}
Create tree.php for archive browser:
phpCopy
<?php
/**
 * Archive Tree API
 * File: api/tree.php
 */

header('Content-Type: application/json');

define('STORAGE_PATH', realpath(__DIR__ . '/../storage/') . '/');

function scanDirectory($dir) {
    $result = [];
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            $result[$item] = scanDirectory($path);
        } else {
            if (pathinfo($item, PATHINFO_EXTENSION) === 'md') {
                $result[$item] = [
                    'path' => str_replace(STORAGE_PATH, '', $path),
                    'size' => filesize($path)
                ];
            }
        }
    }
    
    return $result;
}

$tree = [
    'chats' => is_dir(STORAGE_PATH . 'chats/') ? scanDirectory(STORAGE_PATH . 'chats/') : [],
    'processed' => is_dir(STORAGE_PATH . 'processed/') ? scanDirectory(STORAGE_PATH . 'processed/') : [],
    'business-profiles' => is_dir(STORAGE_PATH . 'business-profiles/') ? scanDirectory(STORAGE_PATH . 'business-profiles/') : []
];

echo json_encode(['success' => true, 'tree' => $tree]);
Create view.php for file preview:
phpCopy
<?php
/**
 * File View API
 * File: api/view.php
 */

header('Content-Type: application/json');

define('STORAGE_PATH', realpath(__DIR__ . '/../storage/') . '/');

$path = $_GET['path'] ?? '';

// Security: ensure path is within storage
$fullPath = realpath(STORAGE_PATH . $path);

if (!$fullPath || strpos($fullPath, STORAGE_PATH) !== 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid path']);
    exit;
}

if (!file_exists($fullPath)) {
    echo json_encode(['success' => false, 'message' => 'File not found']);
    exit;
}

$content = file_get_contents($fullPath);

echo json_encode([
    'success' => true,
    'path' => $path,
    'content' => $content,
    'size' => strlen($content)
]);

CHAPTER 5 COMPLETE
What Chapter 5 Contains (Per TOC):
✅ 5.1 Understanding How Search Will Work
✅ 5.2 Creating the Search Interface (working search with filters)
✅ 5.3 Building the Archive Browser (folder tree + preview)
✅ 5.4 The "Recent Captures" Panel (latest chats with badges)
✅ 5.5 Connecting Panels to Each Other (JavaScript integration)
Files Created/Updated:
index.html - Updated with working search, archive browser, recent panel
style.css - Added all Chapter 5 styles
app.js - Complete rewrite with search, recent, archive functionality
api/search.php - Search backend
api/tree.php - Archive tree backend
api/view.php - File preview backend
Test Data Needed: Create a sample chat file in storage/chats/chatgpt/2026-03-16-sample.md to verify search works.

Proceed to Chapter 6: Understanding Browser Extensions?

