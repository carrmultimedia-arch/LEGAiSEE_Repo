CHAPTER 14: Adding Business Profiles
14.1 Understanding Business Context in Research
What this is:
A system for tagging, organizing, and retrieving AI research captures based on the business purpose they serve, rather than just the technical platform they came from.
Where this exists in the real world:
Think of a law firm's filing system. They don't just organize by "received via email" or "received via mail"—they organize by client and case. The delivery method is metadata; the client relationship is the primary structure. Your business profiles do the same for research.
How you encounter this:
You will implement a tagging and folder system where every capture can be associated with a business entity (client name, project code, department), enabling you to answer questions like: "Show me all research I did for Acme Corp" or "What did I learn about blockchain for the fintech project?"
What this controls or affects:
Without business context, your archive is a chronological stream. With it, your archive becomes a client-serviceable knowledge base. You can bill accurately, find relevant past research, and demonstrate value to specific stakeholders.
What goes wrong when this is misunderstood:
Tagging everything "General" → no organizational value added
Inconsistent naming → "Acme" vs "acme corp" vs "Acme Corporation" become separate profiles
No tagging at capture time → retroactive tagging is labor-intensive, often skipped
Over-tagging → every capture in 15 profiles → organizational noise
Concept Lock-In:
Business context is orthogonal to technical context. A single ChatGPT capture can live in chats/chatgpt/ (technical) AND business-profiles/acme-corp/ (business). The technical path preserves source fidelity; the business path enables service delivery. Neither replaces the other.

14.2 Creating and Managing Business Profiles
What this is:
The administrative interface and backend logic for creating new business entities, configuring their metadata, and establishing rules for automatic or manual association with captures.
Where this exists in the real world:
Think of setting up a new client in a CRM system. You enter company details, assign a category, set billing rates, and establish folder structures. Your business profile creation follows similar steps.
How you encounter this:
You will extend your dashboard with business management panels, create API endpoints for CRUD operations (Create, Read, Update, Delete), and implement storage structures that maintain indexes and cross-references.
CLICK-BY-CLICK: Building Business Profile Management
Step 1: Create Business Profile Data Structure
Create lib/business-manager.php:
phpCopy
<?php
/**
 * Business Profile Manager
 * Chapter 14.2
 */

define('BUSINESS_ROOT', STORAGE_ROOT . 'business-profiles/');
define('BUSINESS_INDEX', BUSINESS_ROOT . 'index.json');

/**
 * Initialize business profiles system
 */
function initializeBusinessSystem() {
    if (!is_dir(BUSINESS_ROOT)) {
        mkdir(BUSINESS_ROOT, 0755, true);
    }
    
    if (!file_exists(BUSINESS_INDEX)) {
        file_put_contents(BUSINESS_INDEX, json_encode([
            'version' => '1.0',
            'created' => date('c'),
            'profiles' => []
        ], JSON_PRETTY_PRINT));
    }
}

/**
 * Create new business profile
 * @param array $data Profile data (name, description, category, etc.)
 * @return array Created profile with ID
 */
function createBusinessProfile($data) {
    // Validate required fields
    if (empty($data['name'])) {
        return ['success' => false, 'error' => 'Name is required'];
    }
    
    // Generate safe ID from name
    $profileId = sanitizeFilename($data['name']);
    
    // Check for duplicates
    $existing = getBusinessProfile($profileId);
    if ($existing['success']) {
        return ['success' => false, 'error' => 'Profile already exists'];
    }
    
    // Create profile structure
    $profile = [
        'id' => $profileId,
        'name' => $data['name'],
        'description' => $data['description'] ?? '',
        'category' => $data['category'] ?? 'client',
        'created' => date('c'),
        'updated' => date('c'),
        'settings' => [
            'auto_tag' => $data['auto_tag'] ?? false,
            'keywords' => $data['keywords'] ?? [],
            'default_platforms' => $data['default_platforms'] ?? ['chatgpt', 'claude']
        ],
        'stats' => [
            'capture_count' => 0,
            'last_capture' => null
        ]
    ];
    
    // Create folder structure
    $profilePath = BUSINESS_ROOT . $profileId . '/';
    if (!mkdir($profilePath, 0755, true)) {
        return ['success' => false, 'error' => 'Failed to create profile folder'];
    }
    
    // Save profile metadata
    file_put_contents(
        $profilePath . 'profile.json',
        json_encode($profile, JSON_PRETTY_PRINT)
    );
    
    // Create dated subfolder structure
    $year = date('Y');
    mkdir($profilePath . $year . '/', 0755, true);
    
    // Update master index
    updateBusinessIndex($profile);
    
    return ['success' => true, 'profile' => $profile];
}

/**
 * Get business profile by ID
 * @param string $profileId Profile identifier
 * @return array Profile data or error
 */
function getBusinessProfile($profileId) {
    $profilePath = BUSINESS_ROOT . $profileId . '/profile.json';
    
    if (!file_exists($profilePath)) {
        return ['success' => false, 'error' => 'Profile not found'];
    }
    
    $profile = json_decode(file_get_contents($profilePath), true);
    
    // Load capture index if exists
    $indexPath = BUSINESS_ROOT . $profileId . '/index.json';
    if (file_exists($indexPath)) {
        $profile['captures'] = json_decode(file_get_contents($indexPath), true) ?: [];
    } else {
        $profile['captures'] = [];
    }
    
    return ['success' => true, 'profile' => $profile];
}

/**
 * Update existing business profile
 * @param string $profileId Profile identifier
 * @param array $updates Fields to update
 * @return array Updated profile or error
 */
function updateBusinessProfile($profileId, $updates) {
    $result = getBusinessProfile($profileId);
    if (!$result['success']) {
        return $result;
    }
    
    $profile = $result['profile'];
    
    // Update allowed fields
    $allowed = ['name', 'description', 'category', 'settings'];
    foreach ($allowed as $field) {
        if (isset($updates[$field])) {
            $profile[$field] = $updates[$field];
        }
    }
    
    $profile['updated'] = date('c');
    
    // Save updated profile
    $profilePath = BUSINESS_ROOT . $profileId . '/profile.json';
    file_put_contents($profilePath, json_encode($profile, JSON_PRETTY_PRINT));
    
    // Update master index
    updateBusinessIndex($profile);
    
    return ['success' => true, 'profile' => $profile];
}

/**
 * Delete business profile
 * @param string $profileId Profile identifier
 * @param bool $keepCaptures Move captures to 'general' or delete
 * @return array Result
 */
function deleteBusinessProfile($profileId, $keepCaptures = true) {
    $profilePath = BUSINESS_ROOT . $profileId . '/';
    
    if (!is_dir($profilePath)) {
        return ['success' => false, 'error' => 'Profile not found'];
    }
    
    if ($keepCaptures) {
        // Move captures to general business profile
        $generalPath = BUSINESS_ROOT . 'general/';
        if (!is_dir($generalPath)) {
            createBusinessProfile(['name' => 'General', 'category' => 'system']);
        }
        
        // Move all files
        $files = glob($profilePath . '*/*/*.md');
        foreach ($files as $file) {
            $filename = basename($file);
            $year = date('Y', filemtime($file));
            $targetDir = $generalPath . $year . '/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
            rename($file, $targetDir . $filename);
        }
    }
    
    // Remove profile folder
    rrmdir($profilePath);
    
    // Remove from index
    removeFromBusinessIndex($profileId);
    
    return ['success' => true, 'message' => 'Profile deleted'];
}

/**
 * List all business profiles
 * @param string $category Optional filter by category
 * @return array List of profiles
 */
function listBusinessProfiles($category = null) {
    if (!file_exists(BUSINESS_INDEX)) {
        initializeBusinessSystem();
    }
    
    $index = json_decode(file_get_contents(BUSINESS_INDEX), true);
    $profiles = $index['profiles'] ?? [];
    
    if ($category) {
        $profiles = array_filter($profiles, function($p) use ($category) {
            return $p['category'] === $category;
        });
    }
    
    // Sort by last capture date (recent first)
    usort($profiles, function($a, $b) {
        $aTime = $a['stats']['last_capture'] ? strtotime($a['stats']['last_capture']) : 0;
        $bTime = $b['stats']['last_capture'] ? strtotime($b['stats']['last_capture']) : 0;
        return $bTime - $aTime;
    });
    
    return $profiles;
}

/**
 * Update master business index
 * @param array $profile Profile data
 */
function updateBusinessIndex($profile) {
    if (!file_exists(BUSINESS_INDEX)) {
        initializeBusinessSystem();
    }
    
    $index = json_decode(file_get_contents(BUSINESS_INDEX), true);
    
    // Find and update or append
    $found = false;
    foreach ($index['profiles'] as &$p) {
        if ($p['id'] === $profile['id']) {
            $p = [
                'id' => $profile['id'],
                'name' => $profile['name'],
                'category' => $profile['category'],
                'stats' => $profile['stats'],
                'updated' => $profile['updated']
            ];
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        $index['profiles'][] = [
            'id' => $profile['id'],
            'name' => $profile['name'],
            'category' => $profile['category'],
            'stats' => $profile['stats'],
            'updated' => $profile['updated']
        ];
    }
    
    file_put_contents(BUSINESS_INDEX, json_encode($index, JSON_PRETTY_PRINT));
}

/**
 * Remove from business index
 * @param string $profileId Profile ID
 */
function removeFromBusinessIndex($profileId) {
    if (!file_exists(BUSINESS_INDEX)) return;
    
    $index = json_decode(file_get_contents(BUSINESS_INDEX), true);
    $index['profiles'] = array_filter($index['profiles'], function($p) use ($profileId) {
        return $p['id'] !== $profileId;
    });
    
    file_put_contents(BUSINESS_INDEX, json_encode($index, JSON_PRETTY_PRINT));
}

/**
 * Recursive directory removal
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}
Step 2: Create Business Profile API
Create api/business-profiles.php:
phpCopy
<?php
/**
 * Business Profile API
 * Chapter 14.2
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../lib/business-manager.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? 'client',
            'auto_tag' => isset($_POST['auto_tag']),
            'keywords' => explode(',', $_POST['keywords'] ?? ''),
            'default_platforms' => $_POST['platforms'] ?? ['chatgpt', 'claude']
        ];
        
        $result = createBusinessProfile($data);
        echo json_encode($result);
        break;
        
    case 'get':
        $id = $_GET['id'] ?? '';
        echo json_encode(getBusinessProfile($id));
        break;
        
    case 'update':
        $id = $_POST['id'] ?? '';
        $updates = [
            'name' => $_POST['name'] ?? null,
            'description' => $_POST['description'] ?? null,
            'category' => $_POST['category'] ?? null,
            'settings' => [
                'auto_tag' => isset($_POST['auto_tag']),
                'keywords' => explode(',', $_POST['keywords'] ?? '')
            ]
        ];
        // Remove null values
        $updates = array_filter($updates, function($v) { return $v !== null; });
        
        echo json_encode(updateBusinessProfile($id, $updates));
        break;
        
    case 'delete':
        $id = $_POST['id'] ?? '';
        $keep = !isset($_POST['delete_captures']);
        echo json_encode(deleteBusinessProfile($id, $keep));
        break;
        
    case 'list':
        $category = $_GET['category'] ?? null;
        $profiles = listBusinessProfiles($category);
        echo json_encode([
            'success' => true,
            'profiles' => $profiles,
            'count' => count($profiles)
        ]);
        break;
        
    case 'stats':
        $stats = [
            'total_profiles' => count(listBusinessProfiles()),
            'by_category' => []
        ];
        
        $categories = ['client', 'project', 'research', 'personal', 'system'];
        foreach ($categories as $cat) {
            $stats['by_category'][$cat] = count(listBusinessProfiles($cat));
        }
        
        echo json_encode(['success' => true, 'stats' => $stats]);
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
Step 3: Build Dashboard Management UI
Add to your dashboard HTML:
HTMLPreviewCopy
<!-- Business Profiles Panel -->
<section id="business-panel" class="panel">
    <header class="panel-header">
        <h2>🏢 Business Profiles</h2>
        <p class="subtitle">Organize captures by client and project</p>
    </header>
    
    <div class="business-layout">
        <!-- Sidebar: Profile List -->
        <div class="business-sidebar">
            <div class="business-actions">
                <button onclick="showCreateProfileModal()" class="btn-primary">
                    + New Profile
                </button>
                <select id="category-filter" onchange="loadProfiles()">
                    <option value="">All Categories</option>
                    <option value="client">Clients</option>
                    <option value="project">Projects</option>
                    <option value="research">Research Areas</option>
                    <option value="personal">Personal</option>
                </select>
            </div>
            
            <div id="profile-list" class="profile-list">
                <!-- Populated by JavaScript -->
                <div class="loading">Loading profiles...</div>
            </div>
        </div>
        
        <!-- Main: Profile Detail -->
        <div id="profile-detail" class="profile-detail">
            <div class="empty-state">
                <span class="empty-icon">🏢</span>
                <p>Select a business profile to view details</p>
            </div>
        </div>
    </div>
</section>

<!-- Create Profile Modal -->
<div id="create-profile-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Create Business Profile</h3>
        
        <div class="form-group">
            <label>Profile Name</label>
            <input type="text" id="new-profile-name" placeholder="Acme Corporation">
        </div>
        
        <div class="form-group">
            <label>Category</label>
            <select id="new-profile-category">
                <option value="client">Client</option>
                <option value="project">Project</option>
                <option value="research">Research Area</option>
                <option value="personal">Personal</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea id="new-profile-description" rows="3"></textarea>
        </div>
        
        <div class="form-group">
            <label>Auto-tag Keywords (comma-separated)</label>
            <input type="text" id="new-profile-keywords" placeholder="acme, acme corp, client-a">
            <p class="help-text">Captures containing these terms will auto-tag to this profile</p>
        </div>
        
        <div class="form-actions">
            <button onclick="hideCreateProfileModal()" class="btn-secondary">Cancel</button>
            <button onclick="createProfile()" class="btn-primary">Create Profile</button>
        </div>
    </div>
</div>
Add CSS:
cssCopy
/* Business Profiles Styles */

.business-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    height: calc(100vh - 200px);
}

.business-sidebar {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px;
    overflow-y: auto;
}

.business-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}

.profile-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.profile-card {
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.profile-card:hover {
    background: var(--bg-secondary);
    border-color: var(--border);
}

.profile-card.active {
    background: rgba(16, 163, 127, 0.1);
    border-color: #10a37f;
}

.profile-card h4 {
    margin: 0 0 4px 0;
    font-size: 15px;
}

.profile-card .meta {
    font-size: 12px;
    color: var(--text-muted);
}

.profile-card .stats {
    font-size: 12px;
    color: var(--text-secondary);
    margin-top: 6px;
}

.profile-detail {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px;
    overflow-y: auto;
}

.profile-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}

.profile-header h2 {
    margin: 0 0 8px 0;
}

.profile-header .category-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    text-transform: uppercase;
    background: var(--bg-secondary);
}

.captures-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: var(--bg-primary);
    padding: 24px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}
Step 4: Add Dashboard JavaScript
Add to your dashboard JS:
JavaScriptCopy
// Business Profile Management

let currentProfiles = [];
let selectedProfile = null;

async function loadProfiles(category = '') {
    const listEl = document.getElementById('profile-list');
    listEl.innerHTML = '<div class="loading">Loading...</div>';
    
    try {
        const url = `api/business-profiles.php?action=list${category ? '&category=' + category : ''}`;
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success) {
            currentProfiles = data.profiles;
            renderProfileList(data.profiles);
        } else {
            listEl.innerHTML = '<div class="error">Failed to load profiles</div>';
        }
    } catch (error) {
        listEl.innerHTML = '<div class="error">' + error.message + '</div>';
    }
}

function renderProfileList(profiles) {
    const listEl = document.getElementById('profile-list');
    
    if (profiles.length === 0) {
        listEl.innerHTML = '<div class="empty-state">No profiles yet. Create one!</div>';
        return;
    }
    
    listEl.innerHTML = profiles.map(p => `
        <div class="profile-card ${selectedProfile?.id === p.id ? 'active' : ''}" 
             onclick="selectProfile('${p.id}')">
            <h4>${escapeHtml(p.name)}</h4>
            <div class="meta">${p.category} • Updated ${formatDate(p.updated)}</div>
            <div class="stats">
                ${p.stats.capture_count} captures
                ${p.stats.last_capture ? '• Last: ' + formatDate(p.stats.last_capture) : ''}
            </div>
        </div>
    `).join('');
}

async function selectProfile(id) {
    selectedProfile = currentProfiles.find(p => p.id === id);
    renderProfileList(currentProfiles); // Update active state
    
    try {
        const response = await fetch(`api/business-profiles.php?action=get&id=${id}`);
        const data = await response.json();
        
        if (data.success) {
            renderProfileDetail(data.profile);
        }
    } catch (error) {
        console.error('Failed to load profile:', error);
    }
}

function renderProfileDetail(profile) {
    const detailEl = document.getElementById('profile-detail');
    
    detailEl.innerHTML = `
        <div class="profile-header">
            <h2>${escapeHtml(profile.name)}</h2>
            <span class="category-badge">${profile.category}</span>
            <p>${escapeHtml(profile.description || 'No description')}</p>
            <div class="profile-actions">
                <button onclick="editProfile('${profile.id}')" class="btn-secondary">Edit</button>
                <button onclick="deleteProfile('${profile.id}')" class="btn-danger">Delete</button>
            </div>
        </div>
        
        <div class="profile-stats">
            <h3>Statistics</h3>
            <div class="stat-grid">
                <div class="stat-box">
                    <div class="stat-number">${profile.stats.capture_count}</div>
                    <div class="stat-label">Total Captures</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">${profile.captures?.length || 0}</div>
                    <div class="stat-label">Indexed</div>
                </div>
            </div>
        </div>
        
        <div class="profile-captures">
            <h3>Recent Captures</h3>
            <div class="captures-list">
                ${(profile.captures || []).slice(0, 6).map(c => `
                    <div class="capture-card" onclick="viewCapture('${c.file}')">
                        <div class="platform-badge ${c.platform}">${c.platform}</div>
                        <h4>${escapeHtml(c.title)}</h4>
                        <div class="meta">${formatDate(c.date)}</div>
                    </div>
                `).join('') || '<p>No captures yet</p>'}
            </div>
        </div>
        
        <div class="profile-settings">
            <h3>Settings</h3>
            <p><strong>Auto-tag:</strong> ${profile.settings?.auto_tag ? 'Enabled' : 'Disabled'}</p>
            <p><strong>Keywords:</strong> ${(profile.settings?.keywords || []).join(', ') || 'None'}</p>
            <p><strong>Default Platforms:</strong> ${(profile.settings?.default_platforms || []).join(', ')}</p>
        </div>
    `;
}

function showCreateProfileModal() {
    document.getElementById('create-profile-modal').style.display = 'flex';
}

function hideCreateProfileModal() {
    document.getElementById('create-profile-modal').style.display = 'none';
    // Clear form
    document.getElementById('new-profile-name').value = '';
    document.getElementById('new-profile-description').value = '';
    document.getElementById('new-profile-keywords').value = '';
}

async function createProfile() {
    const data = {
        name: document.getElementById('new-profile-name').value,
        category: document.getElementById('new-profile-category').value,
        description: document.getElementById('new-profile-description').value,
        keywords: document.getElementById('new-profile-keywords').value,
        auto_tag: true
    };
    
    if (!data.name) {
        alert('Name is required');
        return;
    }
    
    try {
        const response = await fetch('api/business-profiles.php?action=create', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            hideCreateProfileModal();
            loadProfiles();
            selectProfile(result.profile.id);
        } else {
            alert('Failed: ' + result.error);
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Load profiles when business panel shown
    const observer = new MutationObserver((mutations) => {
        const businessPanel = document.getElementById('business-panel');
        if (businessPanel?.classList.contains('active')) {
            loadProfiles();
        }
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
});
What this controls or affects:
You now have a complete business profile management system. You can create profiles for clients, projects, or research areas. Each profile maintains its own capture index and statistics. The dashboard provides full CRUD interface.
What goes wrong when this is misunderstood:
Profile ID generation collisions → "acme corp" and "acme-corp" become different profiles
Index out of sync with filesystem → need rebuild function
No validation on delete → accidental deletion of client history
Case sensitivity in search → "Acme" not found when searching "acme"
Concept Lock-In:
Business profiles are organizational metadata, not access control. All profiles are visible to all users (single-user system). The value is in retrieval speed and billing accuracy, not security isolation.

14.3 Auto-Tagging Captures by Business Rules
What this is:
An automated system that examines capture content (titles, queries, responses) and automatically assigns business profile tags based on keyword matching, reducing manual tagging labor.
Where this exists in the real world:
Think of email filters that automatically sort messages into folders based on sender or subject keywords. Your auto-tagging does the same for research captures—"if capture contains 'Acme Corp', tag to Acme profile."
How you encounter this:
You will implement a processing layer that runs after capture save, scans content against all profile keyword lists, and automatically adds matching captures to appropriate business folders.
CLICK-BY-CLICK: Implementing Auto-Tagging
Step 1: Create Auto-Tag Engine
Add to lib/business-manager.php:
phpCopy
<?php
// ... existing code ...

/**
 * Auto-tag capture based on content analysis
 * @param array $captureData Capture metadata
 * @param string $content Full capture content
 * @return array Matched profile IDs
 */
function autoTagCapture($captureData, $content) {
    $matches = [];
    
    // Get all profiles with auto-tag enabled
    $profiles = listBusinessProfiles();
    
    foreach ($profiles as $profile) {
        if (empty($profile['settings']['auto_tag'])) continue;
        if (empty($profile['settings']['keywords'])) continue;
        
        $keywords = $profile['settings']['keywords'];
        $matchFound = false;
        
        foreach ($keywords as $keyword) {
            $keyword = trim(strtolower($keyword));
            if (empty($keyword)) continue;
            
            // Check in title
            if (stripos($captureData['title'], $keyword) !== false) {
                $matchFound = true;
                break;
            }
            
            // Check in content
            if (stripos($content, $keyword) !== false) {
                $matchFound = true;
                break;
            }
            
            // Check in query if present
            if (isset($captureData['query']) && stripos($captureData['query'], $keyword) !== false) {
                $matchFound = true;
                break;
            }
        }
        
        if ($matchFound) {
            $matches[] = $profile['id'];
        }
    }
    
    return $matches;
}

/**
 * Apply business tags to existing capture
 * @param string $filepath Path to capture file
 * @param array $profileIds Business profile IDs to tag
 * @return bool Success
 */
function applyBusinessTags($filepath, $profileIds) {
    if (empty($profileIds)) return false;
    
    // Read current content
    $content = file_get_contents($filepath);
    if (!$content) return false;
    
    // Extract metadata section
    $metadata = extractMetadataFromMarkdown($content);
    
    // Add business profiles to metadata
    $metadata['business_profiles'] = $profileIds;
    
    // Rebuild content with updated metadata
    $newContent = rebuildMarkdownWithMetadata($content, $metadata);
    
    // Write back
    if (!file_put_contents($filepath, $newContent)) {
        return false;
    }
    
    // Copy/link to each business profile folder
    foreach ($profileIds as $profileId) {
        addCaptureToBusinessProfile($filepath, $metadata, $profileId);
    }
    
    return true;
}

/**
 * Extract metadata from markdown content
 */
function extractMetadataFromMarkdown($content) {
    $metadata = [];
    
    // Parse YAML-style header if present
    if (preg_match('/^---\n(.*?)\n---/s', $content, $matches)) {
        $yaml = $matches[1];
        foreach (explode("\n", $yaml) as $line) {
            if (preg_match('/^(\w+):\s*(.+)$/', $line, $parts)) {
                $metadata[$parts[1]] = trim($parts[2]);
            }
        }
    }
    
    // Parse inline metadata (**Key:** Value)
    preg_match_all('/\*\*(\w+):\*\*\s*(.+?)(?:\s{2,}|\n|$)/', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $metadata[strtolower($match[1])] = trim($match[2]);
    }
    
    return $metadata;
}

/**
 * Rebuild markdown with updated metadata
 */
function rebuildMarkdownWithMetadata($content, $metadata) {
    // Extract title (first # line)
    preg_match('/^#\s*(.+)$/m', $content, $titleMatch);
    $title = $titleMatch[1] ?? 'Untitled';
    
    // Build new metadata section
    $metaLines = ["# $title", ""];
    
    foreach ($metadata as $key => $value) {
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $metaLines[] = "**$key:** $value  ";
    }
    
    $metaLines[] = "";
    $metaLines[] = "---";
    $metaLines[] = "";
    
    // Extract body (everything after first ---)
    $parts = explode("\n---\n", $content, 2);
    $body = isset($parts[1]) ? $parts[1] : '';
    
    // Remove old metadata from body if present
    $body = preg_replace('/\*\*\w+:\*\*\s*.+?\n/', '', $body);
    
    return implode("\n", $metaLines) . "\n" . trim($body);
}

/**
 * Add capture to business profile folder and index
 */
function addCaptureToBusinessProfile($filepath, $metadata, $profileId) {
    $profilePath = BUSINESS_ROOT . $profileId . '/';
    if (!is_dir($profilePath)) return false;
    
    // Determine dated subfolder
    $date = $metadata['date'] ?? date('c');
    $year = date('Y', strtotime($date));
    $month = date('m', strtotime($date));
    
    $targetDir = $profilePath . $year . '/' . $month . '/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    // Create copy with platform prefix
    $platform = $metadata['platform'] ?? 'unknown';
    $filename = $platform . '_' . basename($filepath);
    $targetPath = $targetDir . $filename;
    
    // Copy file
    copy($filepath, $targetPath);
    
    // Update profile index
    updateBusinessCaptureIndex($profileId, [
        'file' => $targetPath,
        'original_file' => $filepath,
        'title' => $metadata['title'] ?? 'Untitled',
        'platform' => $platform,
        'date' => $date,
        'added' => date('c')
    ]);
    
    // Update profile stats
    updateProfileStats($profileId);
    
    return true;
}

/**
 * Update business profile capture index
 */
function updateBusinessCaptureIndex($profileId, $captureEntry) {
    $indexPath = BUSINESS_ROOT . $profileId . '/index.json';
    
    $index = [];
    if (file_exists($indexPath)) {
        $index = json_decode(file_get_contents($indexPath), true) ?: [];
    }
    
    // Add to beginning (newest first)
    array_unshift($index, $captureEntry);
    
    // Keep only last 1000 entries (prevent bloat)
    $index = array_slice($index, 0, 1000);
    
    file_put_contents($indexPath, json_encode($index, JSON_PRETTY_PRINT));
}

/**
 * Update profile statistics
 */
function updateProfileStats($profileId) {
    $profileResult = getBusinessProfile($profileId);
    if (!$profileResult['success']) return;
    
    $profile = $profileResult['profile'];
    $index = $profile['captures'] ?? [];
    
    $profile['stats'] = [
        'capture_count' => count($index),
        'last_capture' => $index[0]['date'] ?? null
    ];
    $profile['updated'] = date('c');
    
    // Save updated profile
    $profilePath = BUSINESS_ROOT . $profileId . '/profile.json';
    file_put_contents($profilePath, json_encode($profile, JSON_PRETTY_PRINT));
    
    // Update master index
    updateBusinessIndex($profile);
}
Step 2: Integrate Auto-Tag into Capture Flow
Modify api/capture.php to run auto-tag after save:
phpCopy
<?php
// ... existing capture.php code ...

// After saving file successfully:
require_once __DIR__ . '/../lib/business-manager.php';

// Run auto-tagging
$matchedProfiles = autoTagCapture($payload, $markdown);

if (!empty($matchedProfiles)) {
    applyBusinessTags($filepath, $matchedProfiles);
    $result['auto_tagged'] = $matchedProfiles;
}

// Return success with tagging info
echo json_encode([
    'success' => true,
    'filename' => $filename,
    'path' => $relativePath,
    'size' => strlen($markdown),
    'auto_tagged' => $matchedProfiles ?? []
]);
Step 3: Create Manual Tagging Interface
Add to dashboard for retroactive tagging:
JavaScriptCopy
// Add to profile detail view
async function tagCaptureToProfile(captureFile, profileId) {
    const response = await fetch('api/business-tag.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `file=${encodeURIComponent(captureFile)}&profile=${profileId}`
    });
    
    const result = await response.json();
    if (result.success) {
        showToast('Tagged successfully');
        selectProfile(profileId); // Refresh view
    }
}
Create api/business-tag.php:
phpCopy
<?php
/**
 * Manual capture tagging API
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../lib/business-manager.php';

$file = $_POST['file'] ?? '';
$profileId = $_POST['profile'] ?? '';

if (!$file || !$profileId) {
    echo json_encode(['success' => false, 'error' => 'File and profile required']);
    exit;
}

// Security: ensure file is within storage
$realFile = realpath($file);
if (!$realFile || strpos($realFile, STORAGE_ROOT) !== 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid file path']);
    exit;
}

// Read and tag
$content = file_get_contents($realFile);
$metadata = extractMetadataFromMarkdown($content);

$result = addCaptureToBusinessProfile($realFile, $metadata, $profileId);

echo json_encode(['success' => $result]);
What this controls or affects:
Captures are now automatically organized by business context without manual effort. Keywords in your profile settings ("acme", "project-alpha") trigger automatic filing. You can still manually tag when auto-tag misses.
What goes wrong when this is misunderstood:
Overly broad keywords → "the" matches everything, chaos ensues
Case sensitivity issues → "Acme" doesn't match "acme"
No keyword maintenance → outdated keywords tag wrong captures
Performance on large archives → scanning thousands of files slows capture
Concept Lock-In:
Auto-tagging is probabilistic organization, not deterministic. It reduces manual labor but does not eliminate it. Regular review and manual correction maintain accuracy. Keywords must be maintained as business relationships evolve.

14.4 Reporting and Analytics by Business Context
What this is:
Generating summary statistics, usage reports, and analytical insights about your research activities grouped by business profile, enabling billing, productivity analysis, and value demonstration.
Where this exists in the real world:
Think of a consulting firm's time-tracking system that generates client invoices and utilization reports. Your analytics show: "For Acme Corp this month: 15 research sessions, 47 AI queries, 12 deliverables produced."
How you encounter this:
You will implement reporting functions that aggregate capture data by business profile, calculate time invested, estimate value delivered, and export formatted reports for client billing or internal review.
CLICK-BY-CLICK: Building Business Analytics
Step 1: Create Analytics Engine
Add to lib/business-manager.php:
phpCopy
<?php
// ... existing code ...

/**
 * Generate business profile analytics report
 * @param string $profileId Business profile ID
 * @param string $startDate Y-m-d
 * @param string $endDate Y-m-d
 * @return array Analytics data
 */
function generateProfileAnalytics($profileId, $startDate = null, $endDate = null) {
    $profileResult = getBusinessProfile($profileId);
    if (!$profileResult['success']) {
        return ['success' => false, 'error' => 'Profile not found'];
    }
    
    $profile = $profileResult['profile'];
    $captures = $profile['captures'] ?? [];
    
    // Filter by date if specified
    if ($startDate || $endDate) {
        $captures = array_filter($captures, function($c) use ($startDate, $endDate) {
            $captureDate = strtotime($c['date']);
            if ($startDate && $captureDate < strtotime($startDate)) return false;
            if ($endDate && $captureDate > strtotime($endDate)) return false;
            return true;
        });
    }
    
    // Calculate metrics
    $metrics = [
        'total_captures' => count($captures),
        'by_platform' => [],
        'by_date' => [],
        'by_month' => [],
        'session_count' => 0,
        'estimated_time_minutes' => 0,
        'content_stats' => [
            'total_words' => 0,
            'avg_response_length' => 0
        ]
    ];
    
    $sessions = [];
    
    foreach ($captures as $capture) {
        // Platform breakdown
        $platform = $capture['platform'] ?? 'unknown';
        $metrics['by_platform'][$platform] = ($metrics['by_platform'][$platform] ?? 0) + 1;
        
        // Date breakdown
        $date = date('Y-m-d', strtotime($capture['date']));
        $metrics['by_date'][$date] = ($metrics['by_date'][$date] ?? 0) + 1;
        
        // Month breakdown
        $month = date('Y-m', strtotime($capture['date']));
        $metrics['by_month'][$month] = ($metrics['by_month'][$month] ?? 0) + 1;
        
        // Session tracking
        if (isset($capture['session_id'])) {
            $sessions[$capture['session_id']] = true;
        }
        
        // Content analysis (if file readable)
        if (file_exists($capture['file'])) {
            $content = file_get_contents($capture['file']);
            $wordCount = str_word_count(strip_tags($content));
            $metrics['content_stats']['total_words'] += $wordCount;
        }
    }
    
    $metrics['session_count'] = count($sessions);
    $metrics['estimated_time_minutes'] = $metrics['session_count'] * 45; // 45 min per session avg
    
    if ($metrics['total_captures'] > 0) {
        $metrics['content_stats']['avg_response_length'] = 
            round($metrics['content_stats']['total_words'] / $metrics['total_captures']);
    }
    
    return [
        'success' => true,
        'profile' => [
            'id' => $profile['id'],
            'name' => $profile['name'],
            'category' => $profile['category']
        ],
        'period' => [
            'start' => $startDate,
            'end' => $endDate
        ],
        'metrics' => $metrics,
        'captures' => array_slice($captures, 0, 50) // Include recent captures
    ];
}

/**
 * Generate cross-profile summary report
 * @return array Summary of all activity
 */
function generateGlobalAnalytics() {
    $profiles = listBusinessProfiles();
    
    $summary = [
        'total_profiles' => count($profiles),
        'total_captures' => 0,
        'by_category' => [],
        'top_profiles' => [],
        'recent_activity' => []
    ];
    
    foreach ($profiles as $profile) {
        $summary['total_captures'] += $profile['stats']['capture_count'];
        
        // By category
        $cat = $profile['category'];
        $summary['by_category'][$cat] = ($summary['by_category'][$cat] ?? 0) + 1;
        
        // Top by captures
        $summary['top_profiles'][] = [
            'id' => $profile['id'],
            'name' => $profile['name'],
            'captures' => $profile['stats']['capture_count'],
            'last_active' => $profile['stats']['last_capture']
        ];
    }
    
    // Sort top profiles
    usort($summary['top_profiles'], function($a, $b) {
        return $b['captures'] - $a['captures'];
    });
    $summary['top_profiles'] = array_slice($summary['top_profiles'], 0, 10);
    
    return $summary;
}
Step 2: Create Reporting API
Create api/analytics.php:
phpCopy
<?php
/**
 * Business Analytics API
 * Chapter 14.4
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../lib/business-manager.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'profile':
        $id = $_GET['id'] ?? '';
        $start = $_GET['start'] ?? date('Y-m-01'); // This month
        $end = $_GET['end'] ?? date('Y-m-d');
        
        echo json_encode(generateProfileAnalytics($id, $start, $end));
        break;
        
    case 'summary':
        echo json_encode([
            'success' => true,
            'data' => generateGlobalAnalytics()
        ]);
        break;
        
    case 'export':
        $id = $_GET['id'] ?? '';
        $format = $_GET['format'] ?? 'json';
        
        $report = generateProfileAnalytics($id);
        
        if ($format === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="report.csv"');
            
            // Output CSV
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Platform', 'Title']);
            
            foreach ($report['metrics']['by_date'] as $date => $count) {
                fputcsv($out, [$date, '', $count]);
            }
            
            fclose($out);
            exit;
        }
        
        echo json_encode($report);
        break;
        
    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}
Step 3: Build Analytics Dashboard
Add to business panel HTML:
HTMLPreviewCopy
<div class="analytics-section">
    <h3>📊 Analytics</h3>
    
    <div class="date-range">
        <input type="date" id="analytics-start" value="<?php echo date('Y-m-01'); ?>">
        <input type="date" id="analytics-end" value="<?php echo date('Y-m-d'); ?>">
        <button onclick="loadAnalytics()" class="btn-secondary">Generate Report</button>
    </div>
    
    <div id="analytics-display" class="analytics-display">
        <!-- Populated by JS -->
    </div>
    
    <div class="export-actions">
        <button onclick="exportReport('json')" class="btn-secondary">Export JSON</button>
        <button onclick="exportReport('csv')" class="btn-secondary">Export CSV</button>
    </div>
</div>
Add JavaScript:
JavaScriptCopy
async function loadAnalytics() {
    const profileId = selectedProfile?.id;
    if (!profileId) {
        alert('Select a profile first');
        return;
    }
    
    const start = document.getElementById('analytics-start').value;
    const end = document.getElementById('analytics-end').value;
    
    const response = await fetch(
        `api/analytics.php?action=profile&id=${profileId}&start=${start}&end=${end}`
    );
    
    const data = await response.json();
    if (data.success) {
        renderAnalytics(data);
    }
}

function renderAnalytics(data) {
    const display = document.getElementById('analytics-display');
    const m = data.metrics;
    
    display.innerHTML = `
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-value">${m.total_captures}</div>
                <div class="metric-label">Total Captures</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">${m.session_count}</div>
                <div class="metric-label">Research Sessions</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">${m.estimated_time_minutes}</div>
                <div class="metric-label">Est. Minutes</div>
            </div>
            <div class="metric-card">
                <div class="metric-value">${m.content_stats.total_words.toLocaleString()}</div>
                <div class="metric-label">Total Words</div>
            </div>
        </div>
        
        <div class="platform-breakdown">
            <h4>By Platform</h4>
            ${Object.entries(m.by_platform).map(([p, c]) => `
                <div class="bar-item">
                    <span class="bar-label">${p}</span>
                    <div class="bar" style="width: ${c * 20}px"></div>
                    <span class="bar-value">${c}</span>
                </div>
            `).join('')}
        </div>
        
        <div class="month-trend">
            <h4>Monthly Activity</h4>
            ${Object.entries(m.by_month).map(([m, c]) => `
                <div class="trend-item">
                    <span>${m}</span>
                    <span>${c} captures</span>
                </div>
            `).join('')}
        </div>
    `;
}
What this controls or affects:
You can now generate professional reports showing research activity by client. This enables accurate billing, demonstrates value to stakeholders, and reveals your own productivity patterns.
What goes wrong when this is misunderstood:
Time estimates inaccurate → 45 min/session is heuristic, actual varies
Word count includes metadata → inflated numbers, need content-only count
No cost basis → cannot calculate ROI or bill rates without manual addition
Privacy concerns → client reports expose all research, may need filtering
Concept Lock-In:
Analytics are descriptive, not evaluative. They show what happened, not whether it was valuable. A profile with 100 captures may be low-value busywork; one with 10 captures may be breakthrough research. Human judgment required to interpret metrics.

WORKBOOK EXERCISES
Exercise 14.1: Profile Design
Design business profiles for this scenario:
You consult for 3 clients: Acme Corp, Beta LLC, Gamma Inc
You run 2 internal projects: "AI Research" and "Platform Modernization"
You do personal research on "Career Development"
How many profiles? What categories? What keywords for auto-tagging?
Exercise 14.2: Auto-Tag Logic
A capture contains: "Working with Acme on their blockchain project for supply chain."
Profile A keywords: "acme, supply chain"
Profile B keywords: "blockchain, supply chain"
Profile C keywords: "acme, blockchain"
Which profiles should auto-tag match? What if logic is AND vs OR?
Exercise 14.3: Analytics Interpretation
Profile "Acme Corp" analytics show:
50 captures this month (up from 10 last month)
80% ChatGPT, 15% Claude, 5% Perplexity
Average 200 words per capture (down from 500 last month)
What does this suggest? What questions would you ask?
Exercise 14.4: Reporting Ethics
A client asks: "Show me all the AI research you did for us last month."
Your archive contains:
20 captures tagged with their profile
5 captures not tagged but about their industry
3 captures tagged with their profile but actually about another client (mis-tagged)
What do you report? What are the ethical considerations?
Exercise 14.5: Keyword Maintenance
Your "Beta LLC" profile has keyword "beta". Over 6 months, you accumulate:
30 correct Beta LLC captures
15 false positives (beta software, beta testing, beta version)
How do you refine? What keyword changes prevent false positives without losing true matches?

CHAPTER 14 MEMORY DUMP / RESTORE POINT
COPY EVERYTHING BELOW THIS LINE TO SAVE YOUR PROGRESS:
plainCopy
ARCHAEOLOGY INTELLIGENCE PLATFORM - CHAPTER 14 COMPLETE
Date: [CURRENT DATE]
Status: Advanced business profile system fully implemented

FILES CREATED/UPDATED:
- lib/business-manager.php (complete CRUD, auto-tag, analytics)
- api/business-profiles.php (profile management API)
- api/business-tag.php (manual tagging API)
- api/analytics.php (reporting API)
- Dashboard UI: Business panel with management interface
- Dashboard UI: Analytics section with reporting

CONCEPTS LOCKED IN:
- Business context is orthogonal to technical context (platform)
- Profiles organize by client/project, not by source
- Auto-tagging reduces labor but doesn't eliminate manual review
- Keywords must be maintained (add, refine, remove)
- Analytics are descriptive (what happened) not evaluative (value)
- Reporting enables billing and value demonstration
- Privacy and accuracy considerations in client reporting

SYSTEM CAPABILITIES:
✅ Create/update/delete business profiles
✅ Auto-tagging by keyword matching (title, content, query)
✅ Manual tagging for corrections and additions
✅ Cross-platform capture aggregation by business context
✅ Profile-based analytics and reporting
✅ Date-range filtering
✅ Export to JSON/CSV

BUSINESS PROFILE STRUCTURE:
business-profiles/
  index.json (master profile list)
  {profile-id}/
    profile.json (metadata, settings, stats)
    index.json (capture list)
    YYYY/MM/ (dated capture copies)
    
WORKFLOW INTEGRATION:
Capture → Save to platform folder → Auto-tag scan → 
Match keywords → Copy to business folder(s) → 
Update index → Update stats → Available in dashboard

NEXT CHAPTER: Chapter 15 - Search Functionality (Advanced)
- Will implement full-text indexing
- Will add faceted search (by platform, date, business, stage)
- Will add saved searches and alerts
- Will optimize for large archives (10,000+ files)

RESTORE INSTRUCTIONS:
To restore this state in a new chat, paste this memory dump and say:
"I am restoring Chapter 14 of the Archaeology Intelligence Platform manual.
I have implemented complete business profile management including
CRUD operations, auto-tagging by keywords, manual tagging,
and analytics reporting. The system can organize captures by
client/project context and generate activity reports.
Please continue with Chapter 15: Search Functionality (Advanced)."

CHAPTER 14 COMPLETE
What Chapter 14 Contains (Per TOC):
✅ 14.1 Understanding Business Context in Research - Organizational concepts
✅ 14.2 Creating and Managing Business Profiles - CRUD implementation
✅ 14.3 Auto-Tagging Captures by Business Rules - Automated organization
✅ 14.4 Reporting and Analytics by Business Context - Value demonstration
Advanced Features Implemented:
Complete business profile lifecycle management
Keyword-based auto-tagging system
Manual tagging for corrections
Cross-platform capture aggregation
Analytics and reporting with export
Ready for Chapter 15: Search Functionality (Advanced) - full-text indexing, faceted search, saved searches, large-archive optimization

Should I proceed with Chapter 15, or do you need any adjustments to Chapter 14?

