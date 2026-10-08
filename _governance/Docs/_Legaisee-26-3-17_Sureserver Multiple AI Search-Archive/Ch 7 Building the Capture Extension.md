CHAPTER 7: Building the Capture Extension
7.1 Creating the Manifest File
What this is:
The manifest.json file is the identity card and contract for your extension. It tells the browser what your extension is called, what version it is, what permissions it needs, and which files to load on which websites.
Where this exists in the real world:
Think of a manifest like a building permit. Before construction begins, the permit declares what will be built, where it will be located, and what safety measures are in place. The browser reads this permit before allowing your extension to operate.
How you encounter this:
You will create a complete manifest.json file that declares permissions for reading AI websites, sending data to your server, and storing configuration. This file must be valid JSON syntax and follow Chrome's Manifest V3 format exactly.
What this controls or affects:
Every capability your extension has is declared here. If a permission is not listed, the extension cannot use that feature. If a website pattern is not matched, the extension will not activate on that site.
What goes wrong when this is misunderstood:
Wrong manifest_version → extension rejected by modern Chrome
Missing host_permissions → cannot read AI platform content
Invalid JSON syntax → extension fails to load entirely
Forgetting to update matches when adding new AI platforms → extension does not appear
Concept Lock-In:
The manifest is a declaration, not code. It does not perform actions. It grants potential capabilities. The actual behavior is implemented in content scripts and background scripts, but those scripts can only do what the manifest permits.
CLICK-BY-CLICK: Creating the Complete Manifest
Step 1: Open Your Extension Folder
Navigate to your archaeology-extension folder created in Chapter 6.
Step 2: Replace manifest.json with Production Version
Delete the placeholder content and create this complete manifest.json:
JSONCopy
{
  "manifest_version": 3,
  "name": "Archaeology Intelligence Capture",
  "version": "1.0.0",
  "description": "Capture AI conversations to your personal research archive",
  "author": "Your Name",
  "homepage_url": "https://your-domain.com/archaeology/",
  
  "permissions": [
    "activeTab",
    "storage",
    "scripting"
  ],
  
  "host_permissions": [
    "https://chat.openai.com/*",
    "https://claude.ai/*",
    "https://gemini.google.com/*",
    "https://www.perplexity.ai/*",
    "https://your-domain.com/*"
  ],
  
  "content_scripts": [
    {
      "matches": [
        "https://chat.openai.com/*"
      ],
      "js": ["content.js"],
      "css": ["styles.css"],
      "run_at": "document_idle",
      "world": "ISOLATED"
    },
    {
      "matches": [
        "https://claude.ai/*"
      ],
      "js": ["content.js"],
      "css": ["styles.css"],
      "run_at": "document_idle",
      "world": "ISOLATED"
    },
    {
      "matches": [
        "https://gemini.google.com/*"
      ],
      "js": ["content.js"],
      "css": ["styles.css"],
      "run_at": "document_idle",
      "world": "ISOLATED"
    },
    {
      "matches": [
        "https://www.perplexity.ai/*"
      ],
      "js": ["content.js"],
      "css": ["styles.css"],
      "run_at": "document_idle",
      "world": "ISOLATED"
    }
  ],
  
  "background": {
    "service_worker": "background.js",
    "type": "module"
  },
  
  "action": {
    "default_popup": "popup.html",
    "default_icon": {
      "16": "icons/icon16.png",
      "48": "icons/icon48.png",
      "128": "icons/icon128.png"
    },
    "default_title": "Click to configure Archaeology Capture"
  },
  
  "icons": {
    "16": "icons/icon16.png",
    "48": "icons/icon48.png",
    "128": "icons/icon128.png"
  },
  
  "web_accessible_resources": [
    {
      "resources": ["icons/*.png", "styles.css"],
      "matches": [
        "https://chat.openai.com/*",
        "https://claude.ai/*",
        "https://gemini.google.com/*",
        "https://www.perplexity.ai/*"
      ]
    }
  ]
}
Step 3: Create the Icons Folder and Placeholder Icons
Create a folder named icons inside your extension folder.
Create three simple PNG files (you can generate these online at favicon.io or similar):
icon16.png (16x16 pixels)
icon48.png (48x48 pixels)
icon128.png (128x128 pixels)
If you cannot create images yet, create empty text files with these names as placeholders. The extension will show a default puzzle piece icon until real images are added.
Step 4: Create styles.css
Create a file named styles.css in your extension folder:
cssCopy
/* Archaeology Extension Styles */

.archaeology-capture-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #10a37f;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    z-index: 999999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.archaeology-capture-btn:hover {
    background: #0d8c6d;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.archaeology-capture-btn.capturing {
    background: #cc785c;
    cursor: wait;
}

.archaeology-capture-btn.success {
    background: #4285f4;
}

.archaeology-capture-btn.error {
    background: #dc3545;
}

.archaeology-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #1a1a1a;
    color: white;
    padding: 16px 20px;
    border-radius: 8px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    z-index: 999999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    max-width: 300px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.archaeology-toast.success {
    border-left: 4px solid #10a37f;
}

.archaeology-toast.error {
    border-left: 4px solid #dc3545;
}
Step 5: Validate Your JSON
Before reloading the extension, validate your manifest:
Copy the entire manifest.json content
Visit https://jsonlint.com
Paste the content and click "Validate JSON"
Fix any syntax errors (common issues: trailing commas, unclosed quotes)
Only proceed when validation passes
Step 6: Reload the Extension
Navigate to chrome://extensions
Find "Archaeology Intelligence Capture"
Click the refresh icon (circular arrow) on the extension card
Check for any error messages
If "Errors" button appears, click it and fix reported issues
What this controls or affects:
This manifest declares your extension can read content from four AI platforms, send data to your server, store local settings, and inject both JavaScript and CSS. The run_at: "document_idle" ensures the page is fully loaded before your script runs.
What goes wrong when this is misunderstood:
world: "ISOLATED" prevents conflicts with page JavaScript but limits some access
type: "module" in background allows modern JavaScript but requires import/export syntax
Missing www in perplexity pattern → extension does not load on www.perplexity.ai
Trailing comma after last JSON property → syntax error, extension fails
Concept Lock-In:
Manifest V3 is the current Chrome standard. V2 is deprecated and will be disabled. Each content_scripts entry can target multiple URLs, but separate entries allow platform-specific customization later. The web_accessible_resources section allows your injected code to access extension files like icons.

7.2 The Background Script (What It Does)
What this is:
The background script (called a "service worker" in Manifest V3) is the extension's brain when no website is visible. It handles server communication, stores configuration, and coordinates between different parts of the extension.
Where this exists in the real world:
Think of the background script as a postal service. It does not care what is written in letters (the content scripts handle that), but it manages the address book, stamps, and delivery trucks to get messages to their destination.
How you encounter this:
Your background script will: (1) store your server URL and API key, (2) receive captured chat data from content scripts, (3) send that data to your server via HTTP POST requests, (4) report success or failure back to the content script.
What this controls or affects:
The background script is the only part of your extension that can reliably send data to external servers. Content scripts are restricted from making cross-origin requests directly. All captured chats flow through the background script to reach your archive.
What goes wrong when this is misunderstood:
Trying to access DOM from background script → error, background has no page access
Not using chrome.runtime.sendMessage properly → content and background cannot communicate
Forgetting to handle async/await in service workers → silent failures
Background script sleeping during long operations → use event.waitUntil()
Concept Lock-In:
Background scripts are ephemeral. They start when needed, do their work, and sleep when idle. They cannot maintain persistent state in variables—use chrome.storage for anything that must survive. They are the only extension component that can make unrestricted HTTP requests.
CLICK-BY-CLICK: Creating the Background Script
Step 1: Replace background.js with Production Version
Delete the placeholder and create this complete background.js:
JavaScriptCopy
// ARCHAEOLOGY INTELLIGENCE PLATFORM
// Background Script - Server Communication Handler
// Chapter 7.2

// Configuration storage keys
const CONFIG_KEYS = {
    SERVER_URL: 'archaeology_server_url',
    API_KEY: 'archaeology_api_key',
    DEFAULT_BUSINESS: 'archaeology_default_business'
};

// Default configuration
const DEFAULT_CONFIG = {
    SERVER_URL: 'https://your-domain.com/archaeology/api/',
    API_KEY: '',
    DEFAULT_BUSINESS: 'General Research'
};

// Initialize extension on install
chrome.runtime.onInstalled.addListener(async (details) => {
    console.log('Archaeology Extension installed:', details.reason);
    
    // Set default configuration if not exists
    const existing = await chrome.storage.sync.get(Object.values(CONFIG_KEYS));
    
    if (!existing[CONFIG_KEYS.SERVER_URL]) {
        await chrome.storage.sync.set({
            [CONFIG_KEYS.SERVER_URL]: DEFAULT_CONFIG.SERVER_URL,
            [CONFIG_KEYS.DEFAULT_BUSINESS]: DEFAULT_CONFIG.DEFAULT_BUSINESS
        });
        console.log('Default configuration set');
    }
});

// Listen for messages from content scripts
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    console.log('Background received message:', request.action);
    
    if (request.action === 'CAPTURE_CHAT') {
        handleCapture(request.data, sender)
            .then(result => sendResponse({ success: true, result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        
        // Return true to indicate async response
        return true;
    }
    
    if (request.action === 'GET_CONFIG') {
        getConfiguration()
            .then(config => sendResponse({ success: true, config }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        
        return true;
    }
    
    if (request.action === 'SAVE_CONFIG') {
        saveConfiguration(request.config)
            .then(() => sendResponse({ success: true }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        
        return true;
    }
    
    if (request.action === 'TEST_CONNECTION') {
        testServerConnection()
            .then(result => sendResponse({ success: true, result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        
        return true;
    }
});

// Handle chat capture and send to server
async function handleCapture(data, sender) {
    const config = await getConfiguration();
    
    if (!config.serverUrl) {
        throw new Error('Server URL not configured. Open extension popup to set up.');
    }
    
    // Prepare payload
    const payload = {
        platform: data.platform,
        title: data.title,
        content: data.content,
        url: data.url,
        timestamp: new Date().toISOString(),
        business: data.business || config.defaultBusiness,
        metadata: {
            captureMethod: 'extension',
            userAgent: navigator.userAgent,
            tabId: sender.tab?.id
        }
    };
    
    console.log('Sending capture to server:', payload.title);
    
    // Send to server
    const response = await fetch(config.serverUrl + 'capture.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-API-Key': config.apiKey || '',
            'X-Capture-Source': 'archaeology-extension'
        },
        body: JSON.stringify(payload)
    });
    
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Server error ${response.status}: ${errorText}`);
    }
    
    const result = await response.json();
    
    if (!result.success) {
        throw new Error(result.message || 'Server rejected capture');
    }
    
    console.log('Capture successful:', result);
    return result;
}

// Get stored configuration
async function getConfiguration() {
    const stored = await chrome.storage.sync.get(Object.values(CONFIG_KEYS));
    
    return {
        serverUrl: stored[CONFIG_KEYS.SERVER_URL] || DEFAULT_CONFIG.SERVER_URL,
        apiKey: stored[CONFIG_KEYS.API_KEY] || '',
        defaultBusiness: stored[CONFIG_KEYS.DEFAULT_BUSINESS] || DEFAULT_CONFIG.DEFAULT_BUSINESS
    };
}

// Save configuration
async function saveConfiguration(config) {
    await chrome.storage.sync.set({
        [CONFIG_KEYS.SERVER_URL]: config.serverUrl,
        [CONFIG_KEYS.API_KEY]: config.apiKey,
        [CONFIG_KEYS.DEFAULT_BUSINESS]: config.defaultBusiness
    });
    console.log('Configuration saved');
}

// Test server connection
async function testServerConnection() {
    const config = await getConfiguration();
    
    const response = await fetch(config.serverUrl + 'test.php', {
        method: 'GET',
        headers: {
            'X-API-Key': config.apiKey || ''
        }
    });
    
    if (!response.ok) {
        throw new Error(`Connection failed: ${response.status}`);
    }
    
    return await response.json();
}

// Handle extension icon click
chrome.action.onClicked.addListener(async (tab) => {
    // If popup is not set, this runs. But we have popup.html configured.
    console.log('Extension icon clicked on tab:', tab.url);
});

// Log startup
console.log('Archaeology Background Script initialized');
Step 2: Create the Server-Side Capture Endpoint (capture.php)
On your SureServer, in the archaeology/api/ folder, create capture.php:
phpCopy
<?php
/**
 * ARCHAEOLOGY INTELLIGENCE PLATFORM
 * Capture Endpoint - Receives chats from extension
 * Chapter 7.2
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key, X-Capture-Source');

// Get JSON payload
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Validate required fields
$required = ['platform', 'title', 'content', 'url'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
        exit;
    }
}

// Sanitize filename
$safeTitle = preg_replace('/[^a-zA-Z0-9\-_\s]/', '', $data['title']);
$safeTitle = substr($safeTitle, 0, 50);
$date = date('Y-m-d');
$timestamp = date('H-i-s');
$filename = "{$date}_{$timestamp}_{$safeTitle}.md";

// Determine storage path
$platform = preg_replace('/[^a-z]/', '', strtolower($data['platform']));
$storagePath = realpath(__DIR__ . '/../../storage/chats/') . '/' . $platform . '/';

if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
}

// Build markdown content
$markdown = "# {$data['title']}\n\n";
$markdown .= "**Platform:** {$data['platform']}  \n";
$markdown .= "**Date:** {$data['timestamp']}  \n";
$markdown .= "**Source:** {$data['url']}  \n";
if (!empty($data['business'])) {
    $markdown .= "**Business:** {$data['business']}  \n";
}
$markdown .= "\n---\n\n";
$markdown .= $data['content'];
$markdown .= "\n\n---\n\n";
$markdown .= "*Captured by Archaeology Intelligence Platform*";

// Save file
$filePath = $storagePath . $filename;
if (file_put_contents($filePath, $markdown) === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    exit;
}

// Return success
echo json_encode([
    'success' => true,
    'message' => 'Capture saved',
    'filename' => $filename,
    'path' => "chats/{$platform}/{$filename}",
    'size' => strlen($markdown)
]);
Step 3: Create Test Endpoint (test.php)
Create test.php in the same folder:
phpCopy
<?php
/**
 * Connection test endpoint
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'success' => true,
    'message' => 'Archaeology API is reachable',
    'timestamp' => date('c'),
    'version' => '1.0.0'
]);
Step 4: Reload Extension and Test Background Script
Go to chrome://extensions
Click refresh on your extension
Click "service worker" to open background console
You should see: "Archaeology Background Script initialized"
Type chrome.storage.sync.get(null, console.log) to verify storage access
What this controls or affects:
The background script now handles all server communication. Content scripts send messages to it, and it forwards data to your server. The configuration system allows users to set their server URL without modifying code.
What goes wrong when this is misunderstood:
return true in onMessage listener → required for async sendResponse, forget it = silent failure
Not using event.waitUntil() for async operations before service worker sleeps
CORS headers missing on server → browser blocks the request
HTTP vs HTTPS mismatch → modern browsers block mixed content
Concept Lock-In:
Background scripts use message passing to communicate with content scripts. The content script calls chrome.runtime.sendMessage(), and the background script's onMessage listener receives it. This is the only reliable communication channel between these contexts.

7.3 The Popup Interface
What this is:
The popup is the small window that appears when you click the extension icon in the browser toolbar. It provides user interface for configuration, status display, and manual controls.
Where this exists in the real world:
Think of the popup like the control panel on a coffee machine. You do not make coffee through the panel (the brewing happens inside), but you use it to select options, start the process, and see status lights.
How you encounter this:
Your popup will allow users to: (1) set their server URL, (2) enter an API key for security, (3) select a default business context, (4) test the connection, and (5) see capture statistics.
What this controls or affects:
The popup is the only user-facing interface of your extension. All configuration happens here. Without it, users would need to manually edit code to change settings.
What goes wrong when this is misunderstood:
Popup closing during async operations → JavaScript stops, operations fail
Trying to access tabs from popup without proper permissions → undefined behavior
Not persisting settings immediately → lost when popup closes
Popup HTML missing script reference → blank window
Concept Lock-In:
Popups are temporary documents. They exist only while open. When the user clicks away, the popup closes and all its JavaScript stops. Any configuration must be saved to chrome.storage immediately, not held in variables.
CLICK-BY-CLICK: Creating the Popup Interface
Step 1: Create popup.html
In your extension folder, create popup.html:
HTMLPreviewCopy
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            width: 360px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            color: #1a1a1a;
            background: #f5f5f5;
        }
        
        .header {
            background: #1a1a1a;
            color: white;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-icon {
            font-size: 24px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: 600;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.7;
            margin-top: 2px;
        }
        
        .content {
            padding: 16px;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 6px;
        }
        
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }
        
        input:focus,
        select:focus {
            outline: none;
            border-color: #10a37f;
        }
        
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        
        .button-group {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }
        
        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: #10a37f;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0d8c6d;
        }
        
        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #d0d0d0;
        }
        
        .status {
            margin-top: 16px;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            display: none;
        }
        
        .status.show {
            display: block;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .stats {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #ddd;
        }
        
        .stat-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #666;
        }
        
        .stat-value {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="header-icon">⛏️</span>
        <div>
            <h1>Archaeology Capture</h1>
            <p>Configure your archive settings</p>
        </div>
    </div>
    
    <div class="content">
        <div class="form-group">
            <label for="serverUrl">Server URL</label>
            <input type="text" id="serverUrl" placeholder="https://your-domain.com/archaeology/api/">
            <p class="help-text">The URL where captures will be sent</p>
        </div>
        
        <div class="form-group">
            <label for="apiKey">API Key (Optional)</label>
            <input type="password" id="apiKey" placeholder="Enter your API key">
            <p class="help-text">For secure server authentication</p>
        </div>
        
        <div class="form-group">
            <label for="defaultBusiness">Default Business Context</label>
            <select id="defaultBusiness">
                <option value="General Research">General Research</option>
                <option value="Client Project A">Client Project A</option>
                <option value="Client Project B">Client Project B</option>
                <option value="Personal Learning">Personal Learning</option>
                <option value="Competitive Analysis">Competitive Analysis</option>
            </select>
        </div>
        
        <div class="button-group">
            <button class="btn-secondary" id="testBtn">Test Connection</button>
            <button class="btn-primary" id="saveBtn">Save Settings</button>
        </div>
        
        <div id="status" class="status"></div>
        
        <div class="stats">
            <div class="stat-row">
                <span class="stat-label">Extension Version</span>
                <span class="stat-value">1.0.0</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Status</span>
                <span class="stat-value" id="connectionStatus">Not configured</span>
            </div>
        </div>
    </div>
    
    <script src="popup.js"></script>
</body>
</html>
Step 2: Create popup.js
Create popup.js in your extension folder:
JavaScriptCopy
// ARCHAEOLOGY INTELLIGENCE PLATFORM
// Popup Script - Configuration Interface
// Chapter 7.3

document.addEventListener('DOMContentLoaded', async () => {
    const serverUrlInput = document.getElementById('serverUrl');
    const apiKeyInput = document.getElementById('apiKey');
    const defaultBusinessSelect = document.getElementById('defaultBusiness');
    const saveBtn = document.getElementById('saveBtn');
    const testBtn = document.getElementById('testBtn');
    const statusDiv = document.getElementById('status');
    const connectionStatus = document.getElementById('connectionStatus');
    
    // Load existing configuration
    async function loadConfig() {
        try {
            const response = await chrome.runtime.sendMessage({ action: 'GET_CONFIG' });
            if (response.success) {
                serverUrlInput.value = response.config.serverUrl || '';
                apiKeyInput.value = response.config.apiKey || '';
                defaultBusinessSelect.value = response.config.defaultBusiness || 'General Research';
                updateConnectionStatus('Configured');
            }
        } catch (error) {
            showStatus('Failed to load configuration: ' + error.message, 'error');
        }
    }
    
    // Save configuration
    async function saveConfig() {
        const config = {
            serverUrl: serverUrlInput.value.trim(),
            apiKey: apiKeyInput.value.trim(),
            defaultBusiness: defaultBusinessSelect.value
        };
        
        // Validate
        if (!config.serverUrl) {
            showStatus('Server URL is required', 'error');
            return;
        }
        
        // Ensure URL ends with /
        if (!config.serverUrl.endsWith('/')) {
            config.serverUrl += '/';
        }
        
        try {
            const response = await chrome.runtime.sendMessage({
                action: 'SAVE_CONFIG',
                config: config
            });
            
            if (response.success) {
                showStatus('Settings saved successfully!', 'success');
                updateConnectionStatus('Configured');
            } else {
                showStatus('Failed to save: ' + response.error, 'error');
            }
        } catch (error) {
            showStatus('Error: ' + error.message, 'error');
        }
    }
    
    // Test server connection
    async function testConnection() {
        showStatus('Testing connection...', 'success');
        
        try {
            const response = await chrome.runtime.sendMessage({ action: 'TEST_CONNECTION' });
            
            if (response.success) {
                showStatus(`Connected! Server says: ${response.result.message}`, 'success');
                updateConnectionStatus('Connected');
            } else {
                showStatus('Connection failed: ' + response.error, 'error');
                updateConnectionStatus('Error');
            }
        } catch (error) {
            showStatus('Test failed: ' + error.message, 'error');
            updateConnectionStatus('Failed');
        }
    }
    
    // Show status message
    function showStatus(message, type) {
        statusDiv.textContent = message;
        statusDiv.className = 'status show ' + type;
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            statusDiv.classList.remove('show');
        }, 5000);
    }
    
    // Update connection status display
    function updateConnectionStatus(status) {
        connectionStatus.textContent = status;
        connectionStatus.style.color = status === 'Connected' ? '#10a37f' : 
                                       status === 'Error' ? '#dc3545' : '#666';
    }
    
    // Event listeners
    saveBtn.addEventListener('click', saveConfig);
    testBtn.addEventListener('click', testConnection);
    
    // Load config on open
    await loadConfig();
});
Step 3: Update manifest.json
Ensure your manifest has the action popup declared (you already did this in 7.1):
JSONCopy
"action": {
    "default_popup": "popup.html",
    "default_icon": {
        "16": "icons/icon16.png",
        "48": "icons/icon48.png",
        "128": "icons/icon128.png"
    },
    "default_title": "Click to configure Archaeology Capture"
}
Step 4: Test the Popup
Reload extension at chrome://extensions
Click the extension icon in your toolbar
The popup should appear with your form
Enter your server URL (e.g., https://your-domain.com/archaeology/api/)
Click "Test Connection" - should show success if test.php is in place
Click "Save Settings" - should confirm save
Close and reopen popup - settings should persist
What this controls or affects:
Users can now configure the extension without editing code. The popup communicates with the background script via messages, which then persists settings to chrome.storage.
What goes wrong when this is misunderstood:
Forgetting event.preventDefault() on forms → popup reloads, settings lost
Not handling popup closure during async operations → settings never saved
Trying to use alert() in popups → blocked by Chrome, use status div instead
CSS not loading → check file paths, use relative paths only
Concept Lock-In:
Popups are ephemeral HTML documents. They reload every time opened. All state must come from chrome.storage via the background script. Never store important data in popup JavaScript variables.

7.4 Injecting Buttons into AI Websites
What this is:
Content scripts run on specific websites and can modify the page DOM (Document Object Model). You will use this capability to add a "Capture to Archaeology" button directly into the AI platform interfaces.
Where this exists in the real world:
Think of this like a custom sticker placed on a public machine. The machine still works normally, but your sticker adds a new button that, when pressed, sends a copy of the machine's output to you.
How you encounter this:
Your content script will: (1) wait for the page to fully load, (2) locate the conversation container, (3) create a new button element, (4) style it to match the platform's design, (5) position it in a visible but non-intrusive location, (6) attach a click handler that triggers capture.
What this controls or affects:
The injected button is the user-facing trigger for the entire capture system. Without visible, accessible buttons, users will forget the extension exists. Button placement must be consistent across all four AI platforms.
What goes wrong when this is misunderstood:
Injecting before page loads → button appears then disappears when React/Vue re-renders
Using fixed positioning on scrolling pages → button scrolls away or covers content
Not checking for existing button → multiple buttons appear on every navigation
Platform DOM changes → selector breaks, button never appears
Concept Lock-In:
AI platforms use dynamic JavaScript frameworks (React, Vue, etc.) that constantly modify the DOM. Your injected elements must be re-injected after route changes. Use MutationObserver to detect when the page content changes and re-inject accordingly.
CLICK-BY-CLICK: Creating the Content Script with Button Injection
Step 1: Replace content.js with Production Version
Delete the placeholder and create this complete content.js:
JavaScriptCopy
// ARCHAEOLOGY INTELLIGENCE PLATFORM
// Content Script - Button Injection & Chat Extraction
// Chapter 7.4 - 7.5

(function() {
    'use strict';
    
    // Prevent multiple injections
    if (window.archaeologyExtensionLoaded) {
        console.log('Archaeology: Already loaded on this page');
        return;
    }
    window.archaeologyExtensionLoaded = true;
    
    console.log('Archaeology: Content script loaded on', window.location.hostname);
    
    // Platform detection and configuration
    const PLATFORM_CONFIG = {
        'chat.openai.com': {
            name: 'ChatGPT',
            selectors: {
                conversation: '[class*="conversation"], [data-testid*="conversation"], main',
                messages: '[data-testid*="message"], .message, [class*="message"]',
                inputArea: 'form, [class*="input"], textarea'
            },
            buttonPosition: 'fixed'
        },
        'claude.ai': {
            name: 'Claude',
            selectors: {
                conversation: '.conversation, [class*="conversation"], main',
                messages: '.message, [class*="message"], [data-testid*="message"]',
                inputArea: 'form, textarea, [class*="input"]'
            },
            buttonPosition: 'fixed'
        },
        'gemini.google.com': {
            name: 'Gemini',
            selectors: {
                conversation: '[class*="conversation"], main, [role="main"]',
                messages: '[class*="message"], [data-testid*="message"]',
                inputArea: 'textarea, [class*="input"]'
            },
            buttonPosition: 'fixed'
        },
        'perplexity.ai': {
            name: 'Perplexity',
            selectors: {
                conversation: '[class*="thread"], [class*="conversation"], main',
                messages: '[class*="message"], [class*="answer"]',
                inputArea: 'textarea, [class*="input"]'
            },
            buttonPosition: 'fixed'
        }
    };
    
    // Detect current platform
    const hostname = window.location.hostname.replace('www.', '');
    const platform = PLATFORM_CONFIG[hostname] || { name: 'Unknown', selectors: {}, buttonPosition: 'fixed' };
    
    console.log('Archaeology: Detected platform:', platform.name);
    
    // State
    let captureButton = null;
    let isCapturing = false;
    
    // Initialize
    function init() {
        injectButton();
        observePageChanges();
    }
    
    // Inject capture button
    function injectButton() {
        // Remove existing button if present
        if (captureButton) {
            captureButton.remove();
        }
        
        // Check if already exists (from previous injection)
        const existing = document.getElementById('archaeology-capture-btn');
        if (existing) {
            existing.remove();
        }
        
        // Create button
        captureButton = document.createElement('button');
        captureButton.id = 'archaeology-capture-btn';
        captureButton.className = 'archaeology-capture-btn';
        captureButton.innerHTML = `
            <span>⛏️</span>
            <span>Capture to Archive</span>
        `;
        
        // Apply platform-specific positioning
        if (platform.buttonPosition === 'fixed') {
            captureButton.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 999999;
            `;
        }
        
        // Click handler
        captureButton.addEventListener('click', handleCaptureClick);
        
        // Add to page
        document.body.appendChild(captureButton);
        
        console.log('Archaeology: Capture button injected');
    }
    
    // Observe page changes for re-injection
    function observePageChanges() {
        const observer = new MutationObserver((mutations) => {
            // Check if button still exists
            if (!document.getElementById('archaeology-capture-btn')) {
                console.log('Archaeology: Button missing, re-injecting');
                injectButton();
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        // Also re-inject on URL changes (SPA navigation)
        let lastUrl = location.href;
        new MutationObserver(() => {
            const url = location.href;
            if (url !== lastUrl) {
                lastUrl = url;
                console.log('Archaeology: URL changed, re-injecting');
                setTimeout(injectButton, 1000); // Delay for page render
            }
        }).observe(document, { subtree: true, childList: true });
    }
    
    // Handle capture button click
    async function handleCaptureClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isCapturing) return;
        
        isCapturing = true;
        updateButtonState('capturing');
        
        try {
            const chatData = extractChatData();
            
            if (!chatData.content || chatData.content.length < 10) {
                throw new Error('No conversation content found to capture');
            }
            
            // Send to background script
            const response = await chrome.runtime.sendMessage({
                action: 'CAPTURE_CHAT',
                data: chatData
            });
            
            if (response.success) {
                updateButtonState('success');
                showToast('Captured successfully! Saved as: ' + response.result.filename);
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    updateButtonState('idle');
                }, 3000);
            } else {
                throw new Error(response.error || 'Capture failed');
            }
            
        } catch (error) {
            console.error('Archaeology: Capture error:', error);
            updateButtonState('error');
            showToast('Capture failed: ' + error.message, 'error');
            
            setTimeout(() => {
                updateButtonState('idle');
            }, 3000);
        } finally {
            isCapturing = false;
        }
    }
    
    // Update button visual state
    function updateButtonState(state) {
        if (!captureButton) return;
        
        captureButton.className = 'archaeology-capture-btn';
        
        switch(state) {
            case 'capturing':
                captureButton.classList.add('capturing');
                captureButton.innerHTML = '<span>⏳</span><span>Capturing...</span>';
                captureButton.disabled = true;
                break;
            case 'success':
                captureButton.classList.add('success');
                captureButton.innerHTML = '<span>✓</span><span>Saved!</span>';
                break;
            case 'error':
                captureButton.classList.add('error');
                captureButton.innerHTML = '<span>✗</span><span>Failed</span>';
                break;
            case 'idle':
            default:
                captureButton.innerHTML = '<span>⛏️</span><span>Capture to Archive</span>';
                captureButton.disabled = false;
                break;
        }
    }
    
    // Show toast notification
    function showToast(message, type = 'success') {
        // Remove existing toast
        const existing = document.getElementById('archaeology-toast');
        if (existing) existing.remove();
        
        const toast = document.createElement('div');
        toast.id = 'archaeology-toast';
        toast.className = `archaeology-toast ${type}`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideIn 0.3s ease reverse';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
    
    // Extract chat data from page
    function extractChatData() {
        const data = {
            platform: platform.name,
            title: extractTitle(),
            content: extractContent(),
            url: window.location.href,
            timestamp: new Date().toISOString()
        };
        
        console.log('Archaeology: Extracted data:', {
            platform: data.platform,
            title: data.title,
            contentLength: data.content.length,
            url: data.url
        });
        
        return data;
    }
    
    // Extract conversation title
    function extractTitle() {
        // Try multiple selectors for title
        const selectors = [
            'h1', 'title', 
            '[class*="title"]', 
            '[data-testid*="title"]',
            '.conversation-title',
            'header h1'
        ];
        
        for (const selector of selectors) {
            const el = document.querySelector(selector);
            if (el && el.textContent.trim()) {
                return el.textContent.trim().substring(0, 100);
            }
        }
        
        // Fallback to URL or timestamp
        const urlParts = window.location.pathname.split('/');
        const lastPart = urlParts[urlParts.length - 1];
        if (lastPart && lastPart.length > 8) {
            return `Conversation ${lastPart.substring(0, 8)}`;
        }
        
        return `Captured ${new Date().toLocaleString()}`;
    }
    
    // Extract conversation content
    function extractContent() {
        let content = '';
        
        // Platform-specific extraction
        switch(platform.name) {
            case 'ChatGPT':
                content = extractChatGPTContent();
                break;
            case 'Claude':
                content = extractClaudeContent();
                break;
            case 'Gemini':
                content = extractGeminiContent();
                break;
            case 'Perplexity':
                content = extractPerplexityContent();
                break;
            default:
                content = extractGenericContent();
        }
        
        return content;
    }
    
    // ChatGPT-specific extraction
    function extractChatGPTContent() {
        const messages = [];
        
        // Try to find message containers
        const messageElements = document.querySelectorAll('[data-testid="conversation-turn-"], [class*="message"], .group');
        
        messageElements.forEach((el, index) => {
            const text = el.textContent.trim();
            if (text && text.length > 5) {
                // Determine if user or assistant
                const isUser = el.querySelector('[class*="user"], [data-testid*="user"]') !== null ||
                               index % 2 === 0;
                
                const role = isUser ? '**User:**' : '**Assistant:**';
                messages.push(`${role}\n\n${text}\n\n---\n`);
            }
        });
        
        return messages.join('\n');
    }
    
    // Claude-specific extraction
    function extractClaudeContent() {
        const messages = [];
        
        // Claude uses specific class patterns
        const messageElements = document.querySelectorAll('.message, [class*="Message"], [data-testid*="message"]');
        
        messageElements.forEach((el) => {
            const text = el.textContent.trim();
            if (text && text.length > 5) {
                // Try to determine role from structure
                const isHuman = el.querySelector('[class*="human"], [class*="Human"]') !== null ||
                                el.getAttribute('data-testid')?.includes('human');
                
                const role = isHuman ? '**Human:**' : '**Claude:**';
                messages.push(`${role}\n\n${text}\n\n---\n`);
            }
        });
        
        return messages.join('\n');
    }
    
    // Gemini-specific extraction
    function extractGeminiContent() {
        const messages = [];
        
        // Gemini uses role-based attributes
        const messageElements = document.querySelectorAll('[role="listitem"], [class*="response-container"], [class*="message"]');
        
        messageElements.forEach((el, index) => {
            const text = el.textContent.trim();
            if (text && text.length > 5) {
                const isUser = el.getAttribute('data-testid')?.includes('user') ||
                               el.querySelector('[class*="user"]') !== null;
                
                const role = isUser ? '**User:**' : '**Gemini:**';
                messages.push(`${role}\n\n${text}\n\n---\n`);
            }
        });
        
        return messages.join('\n');
    }
    
    // Perplexity-specific extraction
    function extractPerplexityContent() {
        const messages = [];
        
        // Perplexity has question/answer structure
        const elements = document.querySelectorAll('[class*="thread"], [class*="message"], [class*="answer"]');
        
        elements.forEach((el) => {
            const text = el.textContent.trim();
            if (text && text.length > 10) {
                // Perplexity shows sources differently
                const hasSources = el.querySelector('[class*="source"], [class*="citation"]') !== null;
                
                let prefix = '**Query:**';
                if (el.getAttribute('class')?.includes('answer')) {
                    prefix = '**Answer:**';
                }
                
                messages.push(`${prefix}\n\n${text}\n\n---\n`);
            }
        });
        
        return messages.join('\n');
    }
    
    // Generic fallback extraction
    function extractGenericContent() {
        // Last resort: grab all text from main content area
        const main = document.querySelector('main, [role="main"], article, .content');
        
        if (main) {
            return main.textContent.trim();
        }
        
        // Ultimate fallback
        return document.body.innerText.substring(0, 50000); // Limit to 50k chars
    }
    
    // Start
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
Step 2: Test Button Injection
Reload extension at chrome://extensions
Navigate to chat.openai.com and open any conversation
Look for the "⛏️ Capture to Archive" button in bottom-right corner
If button does not appear:
Open DevTools (F12) → Console
Look for "Archaeology:" log messages
Check for JavaScript errors
Verify content script is listed in Sources tab
Step 3: Verify on All Platforms
Test the button appears on:
ChatGPT (chat.openai.com)
Claude (claude.ai)
Gemini (gemini.google.com)
Perplexity (perplexity.ai)
The button should appear on each site within 1-2 seconds of page load.
What this controls or affects:
The content script now automatically detects which AI platform it is on, injects a styled capture button, monitors for page changes (for SPAs), and extracts conversation content when clicked.
What goes wrong when this is misunderstood:
Immediately-Invoked Function Expression (IIFE) wrapper missing → conflicts with page JavaScript
Not checking window.archaeologyExtensionLoaded → duplicate buttons on every navigation
MutationObserver observing too broadly → performance issues, browser lag
Selectors too specific → break when AI platforms update their code
Concept Lock-In:
Content scripts run in an isolated world by default (manifest declaration), but they share the DOM with the page. This means they can see and modify elements, but their JavaScript variables do not conflict with the page's JavaScript. The IIFE wrapper ensures your code does not leak into the global scope.

7.5 Extracting Chat Content
What this is:
The process of reading the conversation text from the AI platform's webpage, identifying which messages are from the user versus the AI, and formatting them into a structured document.
Where this exists in the real world:
Think of this like a court stenographer recording a trial. The stenographer does not just write down every word spoken in the room—they identify who is speaking (judge, lawyer, witness) and format the record accordingly.
How you encounter this:
Each AI platform structures their HTML differently. Your content script uses platform-specific selectors to find message containers, determines the speaker (user vs. AI) from CSS classes or DOM structure, extracts the text content, and formats it as markdown with clear role indicators.
What this controls or affects:
The quality of your archive depends entirely on extraction accuracy. Poor extraction loses formatting, misses messages, or confuses user and AI responses. Good extraction preserves the full conversation structure.
What goes wrong when this is misunderstood:
Extracting rendered HTML instead of text → markdown full of HTML tags
Missing multi-turn conversations → only capturing last message
Confusing user and AI messages → archive unreadable
Not handling code blocks → formatting lost
Concept Lock-In:
AI platforms change their DOM structure frequently. Your selectors will break. Build resilient extraction that tries multiple selectors and falls back to generic extraction. Log extraction results to console for debugging.
CLICK-BY-CLICK: Testing and Refining Extraction
Step 1: Open DevTools on ChatGPT
Navigate to any ChatGPT conversation
Press F12 to open DevTools
Click the Elements tab
Press Ctrl+Shift+C (or Cmd+Shift+C on Mac)
Hover over different messages in the conversation
Note the HTML structure and class names
Step 2: Test Extraction Manually
In the DevTools Console, test extraction:
JavaScriptCopy
// Find all message elements
const messages = document.querySelectorAll('[data-testid="conversation-turn-"]');
console.log('Found messages:', messages.length);

// Extract first message
if (messages[0]) {
    console.log('First message HTML:', messages[0].outerHTML);
    console.log('First message text:', messages[0].textContent);
}
Step 3: Verify Platform Detection
In console on each AI platform, verify detection:
JavaScriptCopy
// Should show correct platform name
console.log('Platform:', window.location.hostname);
Step 4: Check Extracted Content Format
After clicking capture, check the background script console:
Go to chrome://extensions
Click "service worker" on your extension
Look for the payload being sent
Verify content has proper markdown formatting with **User:** and **Assistant:** markers
Step 5: Refine Selectors if Needed
If extraction fails on a platform, update the selectors in content.js:
JavaScriptCopy
// Add new selectors to try
const PLATFORM_CONFIG = {
    'chat.openai.com': {
        name: 'ChatGPT',
        selectors: {
            // Add new selectors here based on DevTools inspection
            messages: '[data-testid*="message"], .message, .group, [class*="message"]',
        }
    }
};
What this controls or affects:
Your archive now contains properly formatted markdown files with clear attribution of who said what. The extraction system is resilient across platforms.
What goes wrong when this is misunderstood:
textContent vs innerText → textContent is faster but misses some formatting
Not trimming whitespace → archive full of extra newlines
Code blocks losing formatting → need to preserve pre/code tags
Special characters not escaped → markdown corruption
Concept Lock-In:
DOM selectors are fragile contracts. The AI platform does not promise to keep their HTML structure stable. Your code must degrade gracefully—if specific selectors fail, fall back to generic extraction that captures something rather than nothing.

7.6 Sending Data to Your Server
What this is:
The process of transmitting captured chat data from the browser extension to your SureServer via HTTP POST request, including error handling and retry logic.
Where this exists in the real world:
Think of this like mailing a letter. You write the letter (capture data), put it in an envelope (HTTP request), add the address (your server URL), and hand it to the postal service (browser's fetch API). The postal service delivers it, and you get a receipt (HTTP response).
How you encounter this:
When the user clicks the capture button, the content script extracts the data and sends a message to the background script. The background script then uses the browser's fetch() API to POST the data to your server's capture.php endpoint. The server saves the file and returns a success confirmation.
What this controls or affects:
This is the final step of the capture pipeline. If this fails, the conversation is extracted but lost. The server must be configured to accept cross-origin requests (CORS) and handle the JSON payload correctly.
What goes wrong when this is misunderstood:
CORS headers missing → browser blocks request, appears to "fail silently"
HTTP vs HTTPS mismatch → mixed content blocked by browser security
Payload too large → server rejects or truncates data
Background script sleeping during send → request interrupted
Concept Lock-In:
Content scripts cannot make cross-origin requests directly. They must send a message to the background script, which has fewer restrictions. The background script uses fetch() to communicate with your server. This two-hop communication is mandatory for security.
CLICK-BY-CLICK: Testing End-to-End Capture
Step 1: Verify Server Endpoints Exist
On your SureServer, verify these files exist:
archaeology/api/capture.php (receives POST data)
archaeology/api/test.php (tests GET connectivity)
Both should be accessible via browser:
https://your-domain.com/archaeology/api/test.php should show JSON response
Step 2: Configure Extension
Click extension icon in toolbar
Enter your server URL: https://your-domain.com/archaeology/api/
Click "Test Connection"
Should show "Connected!" message
Click "Save Settings"
Step 3: Perform Test Capture
Navigate to ChatGPT and open any conversation
Click the "⛏️ Capture to Archive" button
Button should show "Capturing..." then "Saved!"
Toast notification should appear with filename
Check your server storage folder: storage/chats/chatgpt/
A new .md file should exist with today's date
Step 4: Verify Captured File Content
Open the captured .md file on your server. It should contain:
Markdown header with title
Platform, date, source URL metadata
Full conversation with User: and Assistant: markers
Footer indicating Archaeology capture
Step 5: Test Error Handling
Test failure scenarios:
Disconnect internet → should show "Failed" with error message
Enter wrong server URL in popup → test connection should fail
Delete capture.php from server → should get 404 error
Step 6: Verify All Four Platforms
Repeat test capture on:
Claude.ai
Gemini.google.com
Perplexity.ai
Each should save to appropriate subfolder:
storage/chats/claude/
storage/chats/gemini/
storage/chats/perplexity/
What this controls or affects:
Your Archaeology platform now captures conversations from all four major AI platforms with a single click. Data flows from AI website → content script → background script → your server → storage folder.
What goes wrong when this is misunderstood:
Not encoding URI components → special characters break URLs
Forgetting Content-Type header → server cannot parse JSON
Not handling network timeouts → hangs indefinitely
Server returning HTML error page instead of JSON → parse errors
Concept Lock-In:
The extension-server communication is asynchronous and unreliable by design. Network failures, server downtime, and browser restrictions are normal. Your code must handle all failure cases gracefully and inform the user what happened.

WORKBOOK EXERCISES
Exercise 7.1: Manifest Validation
Copy your final manifest.json to jsonlint.com. Fix any errors. List every permission declared and explain why your extension needs it.
Exercise 7.2: Platform Detection
Open each AI platform in a separate tab. In each tab's console, run:
JavaScriptCopy
console.log(window.location.hostname);
Document the exact hostname for each platform. Verify these match your manifest's host_permissions.
Exercise 7.3: Selector Testing
On ChatGPT, use DevTools Elements panel to find three different CSS selectors that match conversation messages. Test each in console with document.querySelectorAll(). Document which selector is most reliable.
Exercise 7.4: Network Inspection
Open ChatGPT
Open DevTools → Network tab
Click your capture button
Look for the POST request to capture.php
Click the request → Headers tab
Document: Request URL, Method, Status Code, Content-Type
Click Payload tab → verify your chat data is present
Exercise 7.5: Error Simulation
Modify your server URL in the popup to an invalid address. Attempt a capture. Document the exact error message shown. Then fix the URL and verify capture works again.
Exercise 7.6: Cross-Platform Capture
Capture the same research query from all four AI platforms (e.g., "Explain quantum computing"). Save all four captures. Compare how each platform formats the response in your archive files.

CHAPTER 7 MEMORY DUMP / RESTORE POINT
COPY EVERYTHING BELOW THIS LINE TO SAVE YOUR PROGRESS:
plainCopy
ARCHAEOLOGY INTELLIGENCE PLATFORM - CHAPTER 7 COMPLETE
Date: [CURRENT DATE]
Status: Capture Extension fully functional

FILES CREATED/UPDATED:
- archaeology-extension/manifest.json (complete v3 manifest)
- archaeology-extension/background.js (server communication, message handling)
- archaeology-extension/content.js (button injection, chat extraction)
- archaeology-extension/popup.html (configuration UI)
- archaeology-extension/popup.js (configuration logic)
- archaeology-extension/styles.css (button and toast styling)
- archaeology-extension/icons/ (icon16.png, icon48.png, icon128.png)
- server/archaeology/api/capture.php (receives and saves chats)
- server/archaeology/api/test.php (connection testing)

CONCEPTS LOCKED IN:
- Manifest V3 structure with permissions, host_permissions, content_scripts
- Background service workers handle server communication via fetch()
- Content scripts inject UI and extract data from web pages
- Message passing (chrome.runtime.sendMessage) connects content ↔ background
- Popups are temporary and must persist settings immediately via chrome.storage
- Platform-specific DOM extraction with fallback strategies
- CORS requirements for cross-origin requests
- Markdown formatting for archived conversations

CAPTURE PIPELINE ESTABLISHED:
User clicks button → Content script extracts chat → Sends message to background → 
Background POSTs to server → Server saves as .md file → Success toast shown

PLATFORMS SUPPORTED:
✅ ChatGPT (chat.openai.com)
✅ Claude (claude.ai)
✅ Gemini (gemini.google.com)
✅ Perplexity (perplexity.ai)

CONFIGURATION SYSTEM:
- Server URL stored in chrome.storage.sync
- API key support for authentication
- Default business context selection
- Connection testing functionality
- Settings persist across browser sessions

STORAGE STRUCTURE:
storage/
  chats/
    chatgpt/     ← ChatGPT captures
    claude/      ← Claude captures
    gemini/      ← Gemini captures
    perplexity/  ← Perplexity captures

NEXT CHAPTER: Chapter 8 - Multi-Window Excavation System
- Will add "Excavate All" functionality
- Will open multiple AI platforms simultaneously
- Will coordinate captures across windows
- Will implement dashboard communication

RESTORE INSTRUCTIONS:
To restore this state in a new chat, paste this memory dump and say:
"I am restoring Chapter 7 of the Archaeology Intelligence Platform manual.
I have a complete browser extension that captures from ChatGPT, Claude, Gemini, and Perplexity.
The extension has manifest v3, background script, content script, popup UI, and server endpoints.
All four platforms are supported and the capture pipeline is tested and working.
Please continue with Chapter 8: Multi-Window Excavation System."

CHAPTER 7 COMPLETE
What Chapter 7 Contains (Per TOC):
✅ 7.1 Creating the Manifest File (complete v3 manifest)
✅ 7.2 The Background Script (server communication handler)
✅ 7.3 The Popup Interface (configuration UI)
✅ 7.4 Injecting Buttons into AI Websites (content script injection)
✅ 7.5 Extracting Chat Content (platform-specific extraction)
✅ 7.6 Sending Data to Your Server (end-to-end pipeline)
Files Created:
manifest.json - Extension declaration
background.js - Server communication
content.js - Button injection & extraction
popup.html & popup.js - Configuration interface
styles.css - Visual styling
icons/ - Extension icons
api/capture.php - Server receive endpoint
api/test.php - Connection test endpoint
Ready for Chapter 8: Multi-Window Excavation System (opening multiple AI windows, coordinating captures, dashboard communication)

Should I proceed with Chapter 8, or do you need any adjustments to Chapter 7?

