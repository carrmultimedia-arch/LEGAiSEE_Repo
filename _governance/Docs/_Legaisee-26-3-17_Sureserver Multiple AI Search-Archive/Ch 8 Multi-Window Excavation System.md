CHAPTER 8: Multi-Window Excavation System
8.1 Opening Multiple Windows from One Click
What this is:
A system that allows you to launch multiple AI platform websites simultaneously from a single action in your Archaeology dashboard, rather than manually opening each site.
Where this exists in the real world:
Think of a theater director calling "Places!" before a performance. One command puts every actor in position. Similarly, one click in your dashboard opens ChatGPT, Claude, Gemini, and Perplexity in separate windows, ready for your research query.
How you encounter this:
You will modify your dashboard to add an "Excavate All" button. When clicked, it communicates with your extension to open all four AI platforms at once. Each window loads with your research query ready to paste, or pre-filled if the platform supports URL parameters.
What this controls or affects:
This eliminates the manual step of opening each AI platform individually. It ensures consistent window arrangement and reduces the friction of multi-AI research. Without it, you would open four tabs manually every time.
What goes wrong when this is misunderstood:
Popup blockers preventing multiple window opens → only first window appears
Windows opening minimized or off-screen → user thinks nothing happened
Not checking if windows already open → duplicate windows pile up
URLs with special characters not encoded → broken links
Concept Lock-In:
Browsers restrict automated window opening to prevent spam. Windows can only be reliably opened in direct response to a user action (like a click). The extension must handle the window creation, not the webpage, because extensions have elevated permissions.
CLICK-BY-CLICK: Adding Multi-Window Launch to Your Extension
Step 1: Update background.js with Window Management
Add this code to your background.js file, after the existing message listener:
JavaScriptCopy
// ==========================================
// MULTI-WINDOW EXCAVATION SYSTEM (Chapter 8)
// ==========================================

// Track opened excavation windows
let excavationWindows = new Map();

// Listen for excavation commands
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    // ... existing handlers ...
    
    if (request.action === 'EXCAVATE_ALL') {
        handleExcavateAll(request.query, request.options)
            .then(result => sendResponse({ success: true, result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
    
    if (request.action === 'GET_EXCAVATION_STATUS') {
        getExcavationStatus()
            .then(status => sendResponse({ success: true, status }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
    
    if (request.action === 'CLOSE_ALL_EXCAVATION') {
        closeAllExcavationWindows()
            .then(() => sendResponse({ success: true }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
});

// Handle excavate all command
async function handleExcavateAll(query, options = {}) {
    const platforms = options.platforms || ['chatgpt', 'claude', 'gemini', 'perplexity'];
    const screenWidth = options.screenWidth || 1920;
    const screenHeight = options.screenHeight || 1080;
    
    console.log('Excavating all platforms for query:', query);
    
    // Calculate window positions for side-by-side layout
    const layout = calculateWindowLayout(platforms.length, screenWidth, screenHeight);
    
    const openedWindows = [];
    
    for (let i = 0; i < platforms.length; i++) {
        const platform = platforms[i];
        const position = layout[i];
        
        try {
            const window = await openPlatformWindow(platform, query, position);
            excavationWindows.set(platform, window.id);
            openedWindows.push({ platform, windowId: window.id });
        } catch (error) {
            console.error(`Failed to open ${platform}:`, error);
        }
    }
    
    // Store excavation session data
    await chrome.storage.session.set({
        excavationActive: true,
        excavationQuery: query,
        excavationWindows: Array.from(excavationWindows.entries()),
        excavationStartTime: Date.now()
    });
    
    return {
        opened: openedWindows.length,
        platforms: openedWindows,
        query: query
    };
}

// Calculate optimal window positions
function calculateWindowLayout(count, screenWidth, screenHeight) {
    const positions = [];
    
    if (count === 4) {
        // 2x2 grid layout
        const halfWidth = Math.floor(screenWidth / 2);
        const halfHeight = Math.floor(screenHeight / 2);
        
        positions.push({ left: 0, top: 0, width: halfWidth, height: halfHeight }); // Top-left
        positions.push({ left: halfWidth, top: 0, width: halfWidth, height: halfHeight }); // Top-right
        positions.push({ left: 0, top: halfHeight, width: halfWidth, height: halfHeight }); // Bottom-left
        positions.push({ left: halfWidth, top: halfHeight, width: halfWidth, height: halfHeight }); // Bottom-right
        
    } else if (count === 3) {
        // Three columns
        const thirdWidth = Math.floor(screenWidth / 3);
        
        positions.push({ left: 0, top: 0, width: thirdWidth, height: screenHeight });
        positions.push({ left: thirdWidth, top: 0, width: thirdWidth, height: screenHeight });
        positions.push({ left: thirdWidth * 2, top: 0, width: screenWidth - (thirdWidth * 2), height: screenHeight });
        
    } else if (count === 2) {
        // Side by side
        const halfWidth = Math.floor(screenWidth / 2);
        
        positions.push({ left: 0, top: 0, width: halfWidth, height: screenHeight });
        positions.push({ left: halfWidth, top: 0, width: halfWidth, height: screenHeight });
        
    } else {
        // Single window, centered
        const width = Math.min(1200, screenWidth - 100);
        const height = Math.min(800, screenHeight - 100);
        const left = Math.floor((screenWidth - width) / 2);
        const top = Math.floor((screenHeight - height) / 2);
        
        positions.push({ left, top, width, height });
    }
    
    return positions;
}

// Open individual platform window
async function openPlatformWindow(platform, query, position) {
    const urls = {
        'chatgpt': `https://chat.openai.com/?q=${encodeURIComponent(query)}`,
        'claude': `https://claude.ai`,
        'gemini': `https://gemini.google.com`,
        'perplexity': `https://www.perplexity.ai/?q=${encodeURIComponent(query)}`
    };
    
    const url = urls[platform];
    if (!url) throw new Error(`Unknown platform: ${platform}`);
    
    // Create window
    const window = await chrome.windows.create({
        url: url,
        type: 'normal',
        left: position.left,
        top: position.top,
        width: position.width,
        height: position.height,
        focused: false // Don't steal focus from each new window
    });
    
    // Wait a moment then focus first window
    if (platform === 'chatgpt') {
        setTimeout(() => {
            chrome.windows.update(window.id, { focused: true });
        }, 500);
    }
    
    console.log(`Opened ${platform} window:`, window.id);
    return window;
}

// Get current excavation status
async function getExcavationStatus() {
    const session = await chrome.storage.session.get([
        'excavationActive',
        'excavationQuery',
        'excavationWindows',
        'excavationStartTime'
    ]);
    
    // Check which windows are still open
    const stillOpen = [];
    if (session.excavationWindows) {
        for (const [platform, windowId] of session.excavationWindows) {
            try {
                const win = await chrome.windows.get(windowId);
                stillOpen.push({ platform, windowId, focused: win.focused });
            } catch (e) {
                // Window closed
            }
        }
    }
    
    return {
        active: session.excavationActive && stillOpen.length > 0,
        query: session.excavationQuery,
        windowsOpen: stillOpen.length,
        windows: stillOpen,
        startTime: session.excavationStartTime,
        duration: session.excavationStartTime ? Date.now() - session.excavationStartTime : 0
    };
}

// Close all excavation windows
async function closeAllExcavationWindows() {
    const session = await chrome.storage.session.get(['excavationWindows']);
    
    if (session.excavationWindows) {
        for (const [platform, windowId] of session.excavationWindows) {
            try {
                await chrome.windows.remove(windowId);
                console.log(`Closed ${platform} window:`, windowId);
            } catch (e) {
                // Already closed
            }
        }
    }
    
    excavationWindows.clear();
    
    await chrome.storage.session.set({
        excavationActive: false,
        excavationWindows: [],
        excavationQuery: null
    });
}
Step 2: Add Window Management Permissions to manifest.json
Update your manifest.json permissions section:
JSONCopy
"permissions": [
    "activeTab",
    "storage",
    "scripting",
    "windows",
    "tabs"
],
The windows and tabs permissions are required for creating and managing multiple windows.
Step 3: Reload Extension and Test
Go to chrome://extensions
Click refresh on your extension
Open background script console (click "service worker")
Test by running in console:
JavaScriptCopy
chrome.runtime.sendMessage({
    action: 'EXCAVATE_ALL',
    query: 'Explain quantum computing in simple terms',
    options: {
        platforms: ['chatgpt', 'claude'],
        screenWidth: 1920,
        screenHeight: 1080
    }
}).then(console.log);
You should see two windows open side by side.
What this controls or affects:
The extension can now create window layouts programmatically. The calculateWindowLayout function determines optimal positioning based on screen size and number of platforms.
What goes wrong when this is misunderstood:
windows permission not declared → "chrome.windows is undefined" error
focused: false on all windows → user loses context, thinks nothing happened
Not encoding query parameters → special characters break URLs
Hardcoded screen dimensions → layout breaks on different monitor sizes
Concept Lock-In:
Window creation is asynchronous and permission-gated. The windows permission must be declared in manifest. Created windows return IDs that must be stored to manage them later. Windows can be closed by the user at any time—your tracking must handle this gracefully.

8.2 Positioning Windows Side-by-Side
What this is:
The algorithm and implementation for arranging multiple browser windows on screen so they do not overlap, allowing simultaneous viewing of all AI platforms.
Where this exists in the real world:
Think of a security guard monitoring multiple camera feeds on a video wall. Each feed has its designated position so the guard can see all at once. Your screen is the video wall; each AI platform is a camera feed.
How you encounter this:
You will implement responsive layout algorithms that calculate window dimensions and positions based on: (1) number of platforms to display, (2) available screen real estate, (3) minimum readable window size. The system will handle 1, 2, 3, or 4 platform layouts.
What this controls or affects:
Proper window positioning enables true multi-AI comparison. Without it, windows overlap and you must alt-tab between them, defeating the purpose of simultaneous excavation.
What goes wrong when this is misunderstood:
Not accounting for taskbar height → windows extend below visible screen
Ignoring window borders and chrome → actual content area smaller than specified
Single-monitor assumption → layout breaks on multi-monitor setups
Not handling high-DPI displays → windows appear in wrong positions
Concept Lock-In:
Browser windows include chrome (title bar, borders, toolbars) that consume pixels. The content area is smaller than the window dimensions you specify. Screen coordinates start at (0,0) top-left. Multi-monitor setups have coordinates extending across physical displays.
CLICK-BY-CLICK: Implementing Responsive Window Layouts
Step 1: Enhance Layout Calculator
Replace the calculateWindowLayout function in background.js with this enhanced version:
JavaScriptCopy
// Enhanced window layout calculator with screen detection
async function calculateOptimalLayout(count) {
    // Get primary display info
    const displays = await new Promise((resolve) => {
        // Note: chrome.system.display requires additional permission
        // Fallback to window.screen for basic info
        resolve([{
            bounds: {
                left: 0,
                top: 0,
                width: window.screen.availWidth,
                height: window.screen.availHeight
            },
            workArea: {
                left: 0,
                top: 0,
                width: window.screen.availWidth,
                height: window.screen.availHeight
            }
        }]);
    });
    
    const primaryDisplay = displays[0];
    const workArea = primaryDisplay.workArea;
    
    console.log('Available screen area:', workArea);
    
    // Account for window chrome (title bar, borders)
    const CHROME_HORIZONTAL = 16; // Left + right borders
    const CHROME_VERTICAL = 88;   // Title bar + bottom border + taskbar margin
    
    const availableWidth = workArea.width - CHROME_HORIZONTAL;
    const availableHeight = workArea.height - CHROME_VERTICAL;
    
    const positions = [];
    
    switch(count) {
        case 4:
            // 2x2 Grid (Quad View)
            const quadWidth = Math.floor(availableWidth / 2);
            const quadHeight = Math.floor(availableHeight / 2);
            
            positions.push({
                left: workArea.left,
                top: workArea.top,
                width: quadWidth + CHROME_HORIZONTAL,
                height: quadHeight + CHROME_VERTICAL,
                platform: 'chatgpt'
            });
            positions.push({
                left: workArea.left + quadWidth,
                top: workArea.top,
                width: quadWidth + CHROME_HORIZONTAL,
                height: quadHeight + CHROME_VERTICAL,
                platform: 'claude'
            });
            positions.push({
                left: workArea.left,
                top: workArea.top + quadHeight,
                width: quadWidth + CHROME_HORIZONTAL,
                height: quadHeight + CHROME_VERTICAL,
                platform: 'gemini'
            });
            positions.push({
                left: workArea.left + quadWidth,
                top: workArea.top + quadHeight,
                width: quadWidth + CHROME_HORIZONTAL,
                height: quadHeight + CHROME_VERTICAL,
                platform: 'perplexity'
            });
            break;
            
        case 3:
            // Three columns (Triptych)
            const triWidth = Math.floor(availableWidth / 3);
            
            ['chatgpt', 'claude', 'gemini'].forEach((platform, i) => {
                positions.push({
                    left: workArea.left + (triWidth * i),
                    top: workArea.top,
                    width: triWidth + CHROME_HORIZONTAL,
                    height: availableHeight + CHROME_VERTICAL,
                    platform: platform
                });
            });
            break;
            
        case 2:
            // Side by side (Split View)
            const halfWidth = Math.floor(availableWidth / 2);
            
            positions.push({
                left: workArea.left,
                top: workArea.top,
                width: halfWidth + CHROME_HORIZONTAL,
                height: availableHeight + CHROME_VERTICAL,
                platform: 'chatgpt'
            });
            positions.push({
                left: workArea.left + halfWidth,
                top: workArea.top,
                width: halfWidth + CHROME_HORIZONTAL,
                height: availableHeight + CHROME_VERTICAL,
                platform: 'claude'
            });
            break;
            
        case 1:
        default:
            // Single centered window
            const singleWidth = Math.min(1400, availableWidth - 100);
            const singleHeight = Math.min(900, availableHeight - 100);
            
            positions.push({
                left: workArea.left + Math.floor((availableWidth - singleWidth) / 2),
                top: workArea.top + Math.floor((availableHeight - singleHeight) / 2),
                width: singleWidth + CHROME_HORIZONTAL,
                height: singleHeight + CHROME_VERTICAL,
                platform: 'chatgpt'
            });
    }
    
    return positions;
}
Step 2: Update handleExcavateAll to Use Enhanced Layout
Modify the handleExcavateAll function:
JavaScriptCopy
async function handleExcavateAll(query, options = {}) {
    const platforms = options.platforms || ['chatgpt', 'claude', 'gemini', 'perplexity'];
    
    console.log('Excavating all platforms for query:', query);
    
    // Get optimal layout
    const layout = await calculateOptimalLayout(platforms.length);
    
    const openedWindows = [];
    
    for (let i = 0; i < platforms.length; i++) {
        const platform = platforms[i];
        const position = layout[i];
        
        try {
            const window = await chrome.windows.create({
                url: getPlatformUrl(platform, query),
                type: 'normal',
                left: position.left,
                top: position.top,
                width: position.width,
                height: position.height,
                focused: i === 0 // Focus first window only
            });
            
            excavationWindows.set(platform, {
                windowId: window.id,
                tabId: window.tabs[0].id
            });
            
            openedWindows.push({ platform, windowId: window.id });
            
            // Small delay between window opens to prevent overwhelming the system
            if (i < platforms.length - 1) {
                await new Promise(resolve => setTimeout(resolve, 300));
            }
            
        } catch (error) {
            console.error(`Failed to open ${platform}:`, error);
        }
    }
    
    // Store session
    await chrome.storage.session.set({
        excavationActive: true,
        excavationQuery: query,
        excavationWindows: Array.from(excavationWindows.entries()),
        excavationStartTime: Date.now(),
        layout: layout
    });
    
    return {
        opened: openedWindows.length,
        platforms: openedWindows,
        query: query,
        layout: layout
    };
}
Step 3: Add Platform URL Helper
Add this function to background.js:
JavaScriptCopy
// Get platform URL with query if supported
function getPlatformUrl(platform, query) {
    const encodedQuery = encodeURIComponent(query);
    
    switch(platform) {
        case 'chatgpt':
            // ChatGPT supports ?q= parameter
            return `https://chat.openai.com/?q=${encodedQuery}`;
            
        case 'claude':
            // Claude doesn't support query parameters, open main page
            return 'https://claude.ai';
            
        case 'gemini':
            // Gemini may support query in future
            return `https://gemini.google.com`;
            
        case 'perplexity':
            // Perplexity supports ?q= parameter
            return `https://www.perplexity.ai/?q=${encodedQuery}`;
            
        default:
            return `https://${platform}.com`;
    }
}
Step 4: Test Different Layouts
Test each layout configuration:
JavaScriptCopy
// Test 4-up layout
chrome.runtime.sendMessage({
    action: 'EXCAVATE_ALL',
    query: 'Compare renewable energy sources',
    options: { platforms: ['chatgpt', 'claude', 'gemini', 'perplexity'] }
});

// Test 2-up layout
chrome.runtime.sendMessage({
    action: 'EXCAVATE_ALL',
    query: 'Explain blockchain',
    options: { platforms: ['chatgpt', 'claude'] }
});
What this controls or affects:
Windows now open in precise, non-overlapping arrangements. The layout adapts to the number of platforms selected. Chrome compensation values ensure content area matches intended dimensions.
What goes wrong when this is misunderstood:
availWidth vs width → availWidth accounts for taskbar, width does not
Integer division rounding → gaps or overlaps between windows
Not awaiting window creation → race conditions, tracking errors
Windows opening on wrong monitor → multi-monitor coordinate complexity
Concept Lock-In:
Screen coordinates are absolute across all monitors. If you have two 1920x1080 monitors side by side, the right monitor starts at x=1920. The browser extension cannot easily determine which monitor is "primary" without the system.display permission. Using window.screen provides basic info but may not reflect the actual monitor the browser is on.

8.3 Tracking Which Windows Are Open
What this is:
A state management system that monitors which excavation windows are currently open, closed, or focused, allowing the dashboard to show real-time status and prevent duplicate window creation.
Where this exists in the real world:
Think of an air traffic control radar screen. Each plane has a blip that shows its current position and status. When a plane lands, its blip disappears. Your window tracking is the radar for your excavation windows.
How you encounter this:
You will implement a window monitoring system that: (1) stores window IDs when created, (2) listens for window close events, (3) checks window status before operations, (4) updates the dashboard with current state.
What this controls or affects:
Without tracking, you cannot implement "Capture All" (which requires knowing which windows have content) or prevent duplicate excavations. The dashboard needs this data to show status indicators.
What goes wrong when this is misunderstood:
Not listening for window close events → ghost entries in tracking
Window ID reuse by browser → confusion between old and new windows
Not validating window exists before messaging → "Error: No window with id: 123"
Memory leaks from accumulating window data → extension slows over time
Concept Lock-In:
Window IDs are ephemeral integers assigned by the browser. When a window closes, its ID becomes invalid. When a new window opens, it may reuse an old ID. You must validate window existence before every operation and clean up tracking data when windows close.
CLICK-BY-CLICK: Implementing Window Tracking
Step 1: Add Window Event Listeners to background.js
Add this code to your background.js:
JavaScriptCopy
// ==========================================
// WINDOW MONITORING (Chapter 8.3)
// ==========================================

// Listen for window closes
chrome.windows.onRemoved.addListener(async (windowId) => {
    // Check if this was an excavation window
    const session = await chrome.storage.session.get(['excavationWindows']);
    if (!session.excavationWindows) return;
    
    const windows = new Map(session.excavationWindows);
    let closedPlatform = null;
    
    for (const [platform, data] of windows) {
        if (data.windowId === windowId || data === windowId) {
            closedPlatform = platform;
            windows.delete(platform);
            break;
        }
    }
    
    if (closedPlatform) {
        console.log(`Excavation window closed: ${closedPlatform}`);
        
        // Update storage
        await chrome.storage.session.set({
            excavationWindows: Array.from(windows.entries())
        });
        
        // Check if all windows closed
        if (windows.size === 0) {
            await chrome.storage.session.set({
                excavationActive: false,
                excavationQuery: null
            });
            console.log('All excavation windows closed, session ended');
        }
        
        // Notify dashboard if connected
        notifyDashboard({
            type: 'WINDOW_CLOSED',
            platform: closedPlatform,
            remainingWindows: windows.size
        });
    }
});

// Listen for window focus changes
chrome.windows.onFocusChanged.addListener(async (windowId) => {
    if (windowId === chrome.windows.WINDOW_ID_NONE) return;
    
    const session = await chrome.storage.session.get(['excavationWindows']);
    if (!session.excavationWindows) return;
    
    const windows = new Map(session.excavationWindows);
    
    for (const [platform, data] of windows) {
        const trackedId = typeof data === 'object' ? data.windowId : data;
        if (trackedId === windowId) {
            console.log(`Excavation window focused: ${platform}`);
            
            notifyDashboard({
                type: 'WINDOW_FOCUSED',
                platform: platform,
                windowId: windowId
            });
            break;
        }
    }
});

// Validate all tracked windows still exist
async function validateExcavationWindows() {
    const session = await chrome.storage.session.get(['excavationWindows']);
    if (!session.excavationWindows) return { valid: [], invalid: [] };
    
    const windows = new Map(session.excavationWindows);
    const valid = [];
    const invalid = [];
    
    for (const [platform, data] of windows) {
        const windowId = typeof data === 'object' ? data.windowId : data;
        
        try {
            const win = await chrome.windows.get(windowId);
            valid.push({ platform, windowId: win.id, focused: win.focused });
        } catch (error) {
            invalid.push({ platform, windowId });
            windows.delete(platform);
        }
    }
    
    // Clean up invalid entries
    if (invalid.length > 0) {
        await chrome.storage.session.set({
            excavationWindows: Array.from(windows.entries())
        });
    }
    
    return { valid, invalid };
}

// Get detailed window status
async function getDetailedExcavationStatus() {
    const { valid, invalid } = await validateExcavationWindows();
    const session = await chrome.storage.session.get([
        'excavationActive',
        'excavationQuery',
        'excavationStartTime'
    ]);
    
    // Get tab info for each window
    const windowsWithTabs = await Promise.all(
        valid.map(async (win) => {
            try {
                const tabs = await chrome.tabs.query({ windowId: win.windowId });
                return {
                    ...win,
                    tabs: tabs.map(t => ({
                        id: t.id,
                        url: t.url,
                        title: t.title,
                        active: t.active
                    })),
                    url: tabs[0]?.url,
                    title: tabs[0]?.title
                };
            } catch (e) {
                return win;
            }
        })
    );
    
    return {
        active: session.excavationActive && valid.length > 0,
        query: session.excavationQuery,
        startTime: session.excavationStartTime,
        duration: session.excavationStartTime ? Date.now() - session.excavationStartTime : 0,
        windows: windowsWithTabs,
        windowCount: valid.length,
        closedCount: invalid.length,
        allClosed: valid.length === 0
    };
}
Step 2: Add Dashboard Notification Helper
Add this function to background.js:
JavaScriptCopy
// Notify dashboard of status changes
async function notifyDashboard(message) {
    // Find dashboard tab
    const tabs = await chrome.tabs.query({
        url: '*://your-domain.com/archaeology/*'
    });
    
    if (tabs.length === 0) {
        console.log('Dashboard not found, cannot notify');
        return;
    }
    
    // Send message to dashboard
    for (const tab of tabs) {
        try {
            await chrome.tabs.sendMessage(tab.id, {
                source: 'ARCHAEOLOGY_EXTENSION',
                ...message
            });
        } catch (e) {
            // Dashboard may not have listener yet
            console.log('Failed to notify dashboard tab:', tab.id);
        }
    }
}
Step 3: Update Message Handler
Add this to your onMessage listener:
JavaScriptCopy
if (request.action === 'GET_DETAILED_STATUS') {
    getDetailedExcavationStatus()
        .then(status => sendResponse({ success: true, status }))
        .catch(error => sendResponse({ success: false, error: error.message }));
    return true;
}

if (request.action === 'VALIDATE_WINDOWS') {
    validateExcavationWindows()
        .then(result => sendResponse({ success: true, result }))
        .catch(error => sendResponse({ success: false, error: error.message }));
    return true;
}
Step 4: Test Window Tracking
Test the tracking system:
JavaScriptCopy
// Open excavation
chrome.runtime.sendMessage({
    action: 'EXCAVATE_ALL',
    query: 'Test tracking',
    options: { platforms: ['chatgpt', 'claude'] }
});

// Check status
setTimeout(() => {
    chrome.runtime.sendMessage({
        action: 'GET_DETAILED_STATUS'
    }).then(console.log);
}, 2000);

// Close one window manually, then check status again
setTimeout(() => {
    chrome.runtime.sendMessage({
        action: 'GET_DETAILED_STATUS'
    }).then(console.log);
}, 10000);
What this controls or affects:
The extension now maintains accurate real-time knowledge of which excavation windows exist. When windows close, tracking updates automatically. The dashboard can query detailed status including which tab is active in each window.
What goes wrong when this is misunderstood:
chrome.windows.onRemoved fires after window closes → cannot prevent close, only react
WINDOW_ID_NONE (-1) means all windows lost focus → not a real window
Trying to message closed window → throws exception, must try-catch
Tab permissions required for tab queries → add to manifest if needed
Concept Lock-In:
Window tracking requires event-driven architecture. You cannot poll for window status efficiently. Instead, listen for browser events and maintain state. Always validate before use—windows can close between your check and your action (TOCTOU race condition).

8.4 The "Capture All" Function
What this is:
A coordinated capture operation that extracts content from all open excavation windows simultaneously and sends each to your server with appropriate metadata linking them as a single research session.
Where this exists in the real world:
Think of a photographer at a wedding taking pictures of the ceremony. They do not just photograph the bride; they capture the whole scene—groom, officiant, guests, reactions. "Capture All" is the photographer taking simultaneous snapshots of every AI platform's response to your query.
How you encounter this:
You will implement a messaging system that: (1) sends capture commands to each excavation window's content script, (2) collects responses from all platforms, (3) correlates them with session metadata, (4) saves each to server with reference to the shared query.
What this controls or affects:
This is the core value proposition—simultaneous multi-AI research with one-click archival. Without it, you would manually capture each platform individually, losing the temporal correlation of responses.
What goes wrong when this is misunderstood:
Messaging closed windows → errors, incomplete captures
Not handling different load states → some platforms not ready, capture empty
Race conditions between captures → server overwhelmed, dropped data
No session correlation → cannot later find all responses to same query
Concept Lock-In:
Content scripts in different windows are isolated instances. They do not share state. You must message each individually using chrome.tabs.sendMessage() with the specific tab ID. Responses come back asynchronously and may arrive in any order.
CLICK-BY-CLICK: Implementing Coordinated Multi-Window Capture
Step 1: Add Capture All Handler to background.js
Add this to your onMessage listener:
JavaScriptCopy
if (request.action === 'CAPTURE_ALL_WINDOWS') {
    captureAllWindows(request.options)
        .then(result => sendResponse({ success: true, result }))
        .catch(error => sendResponse({ success: false, error: error.message }));
    return true;
}
Step 2: Add Capture All Implementation
Add this function to background.js:
JavaScriptCopy
// Capture all open excavation windows
async function captureAllWindows(options = {}) {
    const status = await getDetailedExcavationStatus();
    
    if (!status.active || status.windows.length === 0) {
        throw new Error('No excavation windows are currently open');
    }
    
    console.log(`Capturing all ${status.windows.length} excavation windows...`);
    
    const sessionId = generateSessionId();
    const timestamp = new Date().toISOString();
    
    const capturePromises = status.windows.map(async (win) => {
        try {
            // Send capture command to content script in this window
            const response = await chrome.tabs.sendMessage(win.tabs[0].id, {
                action: 'PERFORM_CAPTURE',
                metadata: {
                    sessionId: sessionId,
                    query: status.query,
                    timestamp: timestamp,
                    sequence: status.windows.indexOf(win) + 1,
                    totalWindows: status.windows.length,
                    isCoordinatedCapture: true
                }
            });
            
            if (response && response.success) {
                return {
                    platform: win.platform,
                    success: true,
                    title: response.data.title,
                    preview: response.data.preview
                };
            } else {
                throw new Error(response?.error || 'Capture failed');
            }
            
        } catch (error) {
            console.error(`Failed to capture ${win.platform}:`, error);
            return {
                platform: win.platform,
                success: false,
                error: error.message
            };
        }
    });
    
    // Wait for all captures to complete (with timeout)
    const results = await Promise.allSettled(
        capturePromises.map(p => 
            Promise.race([
                p,
                new Promise((_, reject) => 
                    setTimeout(() => reject(new Error('Timeout')), 30000)
                )
            ])
        )
    );
    
    // Process results
    const captures = results.map((result, index) => {
        const platform = status.windows[index].platform;
        
        if (result.status === 'fulfilled') {
            return result.value;
        } else {
            return {
                platform: platform,
                success: false,
                error: result.reason?.message || 'Unknown error'
            };
        }
    });
    
    const successful = captures.filter(c => c.success);
    const failed = captures.filter(c => !c.success);
    
    // Save session metadata
    await saveSessionMetadata(sessionId, {
        query: status.query,
        timestamp: timestamp,
        windowCount: status.windows.length,
        captures: captures.map(c => ({
            platform: c.platform,
            success: c.success,
            filename: c.success ? c.title : null
        }))
    });
    
    return {
        sessionId: sessionId,
        query: status.query,
        total: captures.length,
        successful: successful.length,
        failed: failed.length,
        captures: captures
    };
}

// Generate unique session ID
function generateSessionId() {
    return 'exc_' + Date.now().toString(36) + '_' + Math.random().toString(36).substr(2, 9);
}

// Save session metadata to server
async function saveSessionMetadata(sessionId, metadata) {
    const config = await getConfiguration();
    
    try {
        await fetch(config.serverUrl + 'session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-API-Key': config.apiKey || ''
            },
            body: JSON.stringify({
                sessionId: sessionId,
                type: 'excavation_session',
                ...metadata
            })
        });
    } catch (error) {
        console.error('Failed to save session metadata:', error);
        // Non-critical, don't throw
    }
}
Step 3: Update Content Script to Handle Capture Command
Add this to your content.js inside the main function, before the closing brace:
JavaScriptCopy
// Listen for messages from background script
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === 'PERFORM_CAPTURE') {
        performCoordinatedCapture(request.metadata)
            .then(result => sendResponse({ success: true, data: result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true; // Async response
    }
});

// Perform capture with session metadata
async function performCoordinatedCapture(metadata) {
    console.log('Performing coordinated capture:', metadata);
    
    // Extract current chat data
    const chatData = extractChatData();
    
    if (!chatData.content || chatData.content.length < 10) {
        throw new Error('No content available to capture');
    }
    
    // Add session metadata
    chatData.sessionId = metadata.sessionId;
    chatData.isCoordinatedCapture = true;
    chatData.sequence = metadata.sequence;
    chatData.totalInSession = metadata.total;
    chatData.captureTimestamp = metadata.timestamp;
    
    // Send to background for server upload
    const response = await chrome.runtime.sendMessage({
        action: 'CAPTURE_CHAT',
        data: chatData
    });
    
    if (!response.success) {
        throw new Error(response.error || 'Server rejected capture');
    }
    
    // Show visual feedback
    showToast(`Captured! (${metadata.sequence}/${metadata.total})`, 'success');
    
    // Return preview data
    return {
        title: chatData.title,
        preview: chatData.content.substring(0, 200) + '...',
        filename: response.result.filename
    };
}
Step 4: Create Server Session Endpoint
Create session.php in your archaeology/api/ folder:
phpCopy
<?php
/**
 * Session metadata storage
 * File: api/session.php
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || empty($data['sessionId'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid session data']);
    exit;
}

$sessionId = preg_replace('/[^a-z0-9_-]/', '', $data['sessionId']);

// Ensure sessions directory exists
$sessionsDir = __DIR__ . '/../../storage/sessions/';
if (!is_dir($sessionsDir)) {
    mkdir($sessionsDir, 0755, true);
}

// Save session metadata
$filename = $sessionsDir . $sessionId . '.json';
if (file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'sessionId' => $sessionId]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save session']);
}
Step 5: Update Capture.php for Session Support
Modify your existing capture.php to handle session metadata:
phpCopy
// Add to the payload processing section:
if (!empty($data['sessionId'])) {
    $markdown .= "**Session:** {$data['sessionId']}  \n";
    $markdown .= "**Sequence:** {$data['sequence']} of {$data['totalInSession']}  \n";
}

if (!empty($data['isCoordinatedCapture'])) {
    $markdown .= "**Type:** Coordinated Multi-Platform Capture  \n";
}
Step 6: Test Capture All
Test the coordinated capture:
JavaScriptCopy
// First, open excavation windows
chrome.runtime.sendMessage({
    action: 'EXCAVATE_ALL',
    query: 'What are the implications of AGI?',
    options: { platforms: ['chatgpt', 'claude'] }
});

// Wait for content to load, then capture all
setTimeout(() => {
    chrome.runtime.sendMessage({
        action: 'CAPTURE_ALL_WINDOWS'
    }).then(result => {
        console.log('Capture all result:', result);
        // Should show 2 captures with same sessionId
    });
}, 15000); // Wait 15 seconds for AI responses
What this controls or affects:
All four platforms can now be captured simultaneously with a single command. Each capture is tagged with the same session ID, allowing you to later retrieve all responses to a single research query as a group.
What goes wrong when this is misunderstood:
Promise.all() fails fast on first rejection → use Promise.allSettled() instead
Not setting message response timeout → hangs forever if content script doesn't respond
Content script not injected yet → messaging fails, need retry logic
Session ID collisions → use timestamp + random for uniqueness
Concept Lock-In:
Coordinated capture is eventually consistent. Some windows may succeed, others fail. Each operates independently. The session metadata ties them together after the fact. Design for partial success—do not require all platforms to succeed for the operation to be valuable.

8.5 Communication Between Dashboard and Extension
What this is:
A bidirectional messaging system that allows your Archaeology dashboard (webpage) to send commands to the extension and receive status updates back, enabling seamless integration between your archive interface and the capture tool.
Where this exists in the real world:
Think of a smart home app on your phone controlling your thermostat. The app (dashboard) sends commands to the thermostat (extension), and the thermostat reports temperature back to the app. They are separate systems but communicate through a defined protocol.
How you encounter this:
You will implement: (1) dashboard JavaScript that detects if the extension is installed, (2) message sending from dashboard to extension, (3) status polling or push updates from extension to dashboard, (4) UI elements in dashboard that trigger excavation and capture.
What this controls or affects:
This integration makes the extension feel like part of your dashboard rather than a separate tool. Users can launch excavations and capture results without leaving your archive interface.
What goes wrong when this is misunderstood:
Dashboard trying to message extension that is not installed → errors, undefined behavior
Not handling extension reloads → old connections break, messages lost
Cross-origin messaging restrictions → security errors, blocked communication
Not validating message source → security vulnerability to spoofed messages
Concept Lock-In:
Web pages cannot directly message extensions. Extensions can message web pages using chrome.tabs.sendMessage() if they have the tab ID. For the webpage to initiate communication, it must use chrome.runtime.sendMessage() which requires the extension ID. This is a privileged operation that only works if the extension declares externally_connectable in the manifest.
CLICK-BY-CLICK: Implementing Dashboard-Extension Integration
Step 1: Update Manifest for External Communication
Add to your manifest.json:
JSONCopy
"externally_connectable": {
    "matches": [
        "https://your-domain.com/archaeology/*"
    ],
    "accepts_tls_channel_id": false
}
Replace your-domain.com with your actual domain.
Step 2: Add External Message Handler to background.js
Add this to your onMessage listener in background.js:
JavaScriptCopy
// Handle messages from external webpages (dashboard)
chrome.runtime.onMessageExternal.addListener((request, sender, sendResponse) => {
    // Validate sender
    if (!sender.url || !sender.url.includes('your-domain.com')) {
        console.warn('Rejected message from unauthorized sender:', sender.url);
        sendResponse({ success: false, error: 'Unauthorized' });
        return false;
    }
    
    console.log('Received external message:', request.action, 'from', sender.url);
    
    // Handle excavation request from dashboard
    if (request.action === 'DASHBOARD_EXCAVATE') {
        handleExcavateAll(request.query, request.options)
            .then(result => sendResponse({ success: true, result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
    
    // Handle capture all request from dashboard
    if (request.action === 'DASHBOARD_CAPTURE_ALL') {
        captureAllWindows(request.options)
            .then(result => sendResponse({ success: true, result }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
    
    // Handle status request from dashboard
    if (request.action === 'DASHBOARD_GET_STATUS') {
        getDetailedExcavationStatus()
            .then(status => sendResponse({ success: true, status }))
            .catch(error => sendResponse({ success: false, error: error.message }));
        return true;
    }
    
    // Handle ping (connection test)
    if (request.action === 'DASHBOARD_PING') {
        sendResponse({ 
            success: true, 
            version: chrome.runtime.getManifest().version,
            extensionId: chrome.runtime.id
        });
        return false;
    }
    
    sendResponse({ success: false, error: 'Unknown action' });
    return false;
});
Step 3: Create Dashboard Integration JavaScript
Create a new file in your dashboard: dashboard-integration.js
Add this to your dashboard's index.html before the closing </body> tag:
HTMLPreviewCopy
<script src="dashboard-integration.js"></script>
Create dashboard-integration.js:
JavaScriptCopy
// ARCHAEOLOGY INTELLIGENCE PLATFORM
// Dashboard-Extension Integration
// Chapter 8.5

(function() {
    'use strict';
    
    // Extension configuration
    const EXTENSION_ID = 'YOUR_EXTENSION_ID_HERE'; // Get from chrome://extensions
    const DASHBOARD_ORIGIN = window.location.origin;
    
    // State
    let extensionAvailable = false;
    let extensionVersion = null;
    let statusPollingInterval = null;
    
    // Initialize integration
    function init() {
        console.log('Archaeology Dashboard: Extension integration initializing');
        
        // Check for extension
        checkExtensionAvailability();
        
        // Add dashboard UI controls
        addExcavationControls();
        
        // Start status polling if extension found
        startStatusPolling();
    }
    
    // Check if extension is installed and responding
    async function checkExtensionAvailability() {
        try {
            const response = await sendToExtension('DASHBOARD_PING', {});
            
            if (response && response.success) {
                extensionAvailable = true;
                extensionVersion = response.version;
                console.log('Archaeology Extension found, version:', extensionVersion);
                updateExtensionStatus('connected', response.version);
                return true;
            }
        } catch (error) {
            console.log('Archaeology Extension not available:', error);
        }
        
        extensionAvailable = false;
        updateExtensionStatus('disconnected');
        return false;
    }
    
    // Send message to extension
    function sendToExtension(action, data = {}) {
        return new Promise((resolve, reject) => {
            if (!window.chrome || !chrome.runtime) {
                reject(new Error('Chrome runtime not available'));
                return;
            }
            
            try {
                chrome.runtime.sendMessage(EXTENSION_ID, {
                    action: action,
                    ...data
                }, (response) => {
                    if (chrome.runtime.lastError) {
                        reject(new Error(chrome.runtime.lastError.message));
                    } else {
                        resolve(response);
                    }
                });
            } catch (error) {
                reject(error);
            }
        });
    }
    
    // Update UI status indicator
    function updateExtensionStatus(status, version = null) {
        const indicator = document.getElementById('extension-status');
        if (!indicator) return;
        
        if (status === 'connected') {
            indicator.innerHTML = `🟢 Extension v${version} connected`;
            indicator.className = 'status-connected';
            
            // Enable excavation buttons
            document.querySelectorAll('.excavation-btn').forEach(btn => {
                btn.disabled = false;
                btn.title = 'Launch multi-AI excavation';
            });
        } else {
            indicator.innerHTML = `🔴 Extension not connected`;
            indicator.className = 'status-disconnected';
            
            // Disable excavation buttons
            document.querySelectorAll('.excavation-btn').forEach(btn => {
                btn.disabled = true;
                btn.title = 'Install Archaeology Extension to use this feature';
            });
        }
    }
    
    // Add excavation controls to dashboard UI
    function addExcavationControls() {
        // Find or create excavation panel
        let panel = document.getElementById('excavation-panel');
        
        if (!panel) {
            // Add to existing excavation panel or create new section
            const container = document.querySelector('.panel-content') || document.body;
            
            panel = document.createElement('div');
            panel.id = 'excavation-panel';
            panel.className = 'excavation-controls';
            
            container.prepend(panel);
        }
        
        panel.innerHTML = `
            <div class="excavation-header">
                <h3>⛏️ Multi-AI Excavation</h3>
                <span id="extension-status" class="extension-status">Checking...</span>
            </div>
            
            <div class="excavation-form">
                <input type="text" 
                       id="excavation-query" 
                       placeholder="Enter research query..."
                       class="excavation-input">
                
                <div class="platform-selector">
                    <label><input type="checkbox" class="platform-check" value="chatgpt" checked> ChatGPT</label>
                    <label><input type="checkbox" class="platform-check" value="claude" checked> Claude</label>
                    <label><input type="checkbox" class="platform-check" value="gemini" checked> Gemini</label>
                    <label><input type="checkbox" class="platform-check" value="perplexity" checked> Perplexity</label>
                </div>
                
                <div class="excavation-actions">
                    <button class="btn-primary excavation-btn" onclick="launchExcavation()" disabled>
                        🚀 Excavate All
                    </button>
                    <button class="btn-secondary excavation-btn" onclick="captureAll()" disabled>
                        📥 Capture All Windows
                    </button>
                    <button class="btn-secondary" onclick="closeAllWindows()">
                        ❌ Close All
                    </button>
                </div>
            </div>
            
            <div id="excavation-status" class="excavation-status"></div>
        `;
        
        // Make functions global for onclick handlers
        window.launchExcavation = launchExcavation;
        window.captureAll = captureAll;
        window.closeAllWindows = closeAllWindows;
    }
    
    // Launch excavation from dashboard
    async function launchExcavation() {
        const queryInput = document.getElementById('excavation-query');
        const query = queryInput.value.trim();
        
        if (!query) {
            showExcavationStatus('Please enter a research query', 'error');
            return;
        }
        
        // Get selected platforms
        const checkboxes = document.querySelectorAll('.platform-check:checked');
        const platforms = Array.from(checkboxes).map(cb => cb.value);
        
        if (platforms.length === 0) {
            showExcavationStatus('Select at least one platform', 'error');
            return;
        }
        
        showExcavationStatus('Launching excavation...', 'info');
        
        try {
            const response = await sendToExtension('DASHBOARD_EXCAVATE', {
                query: query,
                options: {
                    platforms: platforms,
                    screenWidth: window.screen.availWidth,
                    screenHeight: window.screen.availHeight
                }
            });
            
            if (response.success) {
                showExcavationStatus(
                    `Opened ${response.result.opened} windows. Query: "${query}"`, 
                    'success'
                );
                queryInput.value = ''; // Clear input
            } else {
                throw new Error(response.error);
            }
            
        } catch (error) {
            showExcavationStatus('Failed: ' + error.message, 'error');
        }
    }
    
    // Capture all open windows from dashboard
    async function captureAll() {
        showExcavationStatus('Capturing all windows...', 'info');
        
        try {
            const response = await sendToExtension('DASHBOARD_CAPTURE_ALL', {});
            
            if (response.success) {
                const result = response.result;
                showExcavationStatus(
                    `Captured ${result.successful}/${result.total} windows. ` +
                    `Session: ${result.sessionId}`, 
                    'success'
                );
                
                // Refresh recent captures display
                if (typeof loadRecentChats === 'function') {
                    setTimeout(loadRecentChats, 2000);
                }
            } else {
                throw new Error(response.error);
            }
            
        } catch (error) {
            showExcavationStatus('Capture failed: ' + error.message, 'error');
        }
    }
    
    // Close all excavation windows
    async function closeAllWindows() {
        try {
            await sendToExtension('CLOSE_ALL_EXCAVATION', {});
            showExcavationStatus('All excavation windows closed', 'success');
        } catch (error) {
            showExcavationStatus('Error: ' + error.message, 'error');
        }
    }
    
    // Show status message
    function showExcavationStatus(message, type) {
        const statusEl = document.getElementById('excavation-status');
        if (statusEl) {
            statusEl.textContent = message;
            statusEl.className = `excavation-status ${type}`;
            
            setTimeout(() => {
                statusEl.textContent = '';
                statusEl.className = 'excavation-status';
            }, 10000);
        }
    }
    
    // Poll for excavation status
    async function pollExcavationStatus() {
        if (!extensionAvailable) return;
        
        try {
            const response = await sendToExtension('DASHBOARD_GET_STATUS', {});
            
            if (response.success && response.status.active) {
                updateExcavationActivity(response.status);
            }
        } catch (error) {
            // Silent fail on polling errors
        }
    }
    
    // Start periodic status polling
    function startStatusPolling() {
        // Poll every 5 seconds
        statusPollingInterval = setInterval(pollExcavationStatus, 5000);
    }
    
    // Update UI with current excavation activity
    function updateExcavationActivity(status) {
        const statusEl = document.getElementById('excavation-status');
        if (!statusEl || statusEl.textContent.includes('Captured')) return;
        
        const duration = Math.floor(status.duration / 1000);
        statusEl.textContent = `Excavation active: ${status.windowCount} windows open (${duration}s)`;
        statusEl.className = 'excavation-status active';
    }
    
    // Listen for messages from extension
    window.addEventListener('message', (event) => {
        // Validate origin
        if (event.origin !== window.location.origin) return;
        
        // Handle extension messages forwarded through window
        if (event.data && event.data.source === 'ARCHAEOLOGY_EXTENSION') {
            console.log('Dashboard received extension message:', event.data);
            
            // Handle specific message types
            switch(event.data.type) {
                case 'WINDOW_CLOSED':
                    showExcavationStatus(
                        `${event.data.platform} window closed. ${event.data.remainingWindows} remaining.`, 
                        'info'
                    );
                    break;
                    
                case 'WINDOW_FOCUSED':
                    // Could update UI to show which window is active
                    break;
            }
        }
    });
    
    // Initialize when DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
Step 4: Add CSS for Excavation Controls
Add to your style.css:
cssCopy
/* Excavation Controls Styles */

.excavation-controls {
    background: var(--bg-primary);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.excavation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.excavation-header h3 {
    margin: 0;
    font-size: 18px;
}

.extension-status {
    font-size: 13px;
    padding: 4px 10px;
    border-radius: 12px;
}

.status-connected {
    background: #d4edda;
    color: #155724;
}

.status-disconnected {
    background: #f8d7da;
    color: #721c24;
}

.excavation-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.excavation-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 15px;
}

.platform-selector {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.platform-selector label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    cursor: pointer;
}

.excavation-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.excavation-actions button {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
}

.excavation-actions button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.excavation-status {
    margin-top: 12px;
    padding: 10px;
    border-radius: 6px;
    font-size: 13px;
    min-height: 20px;
}

.excavation-status.info {
    background: #d1ecf1;
    color: #0c5460;
}

.excavation-status.success {
    background: #d4edda;
    color: #155724;
}

.excavation-status.error {
    background: #f8d7da;
    color: #721c24;
}

.excavation-status.active {
    background: #fff3cd;
    color: #856404;
}
Step 5: Get Your Extension ID
Go to chrome://extensions
Find "Archaeology Intelligence Capture"
Copy the Extension ID (long string of letters)
Replace YOUR_EXTENSION_ID_HERE in dashboard-integration.js
Step 6: Test Dashboard Integration
Open your Archaeology dashboard in browser
Look for the "⛏️ Multi-AI Excavation" panel
Check extension status indicator (should show 🟢 if connected)
Enter a query in the input field
Select platforms (or leave all checked)
Click "🚀 Excavate All"
Windows should open in layout
Wait for AI responses, then click "📥 Capture All Windows"
Check that captures appear in Recent panel
What this controls or affects:
Your dashboard now has full control over the extension. Users can launch excavations, monitor status, and capture results without leaving the archive interface. The extension availability is clearly indicated.
What goes wrong when this is misunderstood:
Wrong Extension ID → messages never reach extension, silent failure
externally_connectable not declared → security error, communication blocked
Dashboard not on HTTPS → Chrome blocks extension communication
Not checking chrome.runtime.lastError → error messages lost, debugging impossible
Concept Lock-In:
External communication requires explicit manifest declaration. The extension must whitelist your domain in externally_connectable. The dashboard must know the extension ID. Both conditions must be met. There is no way for a webpage to "discover" extensions—security requires explicit mutual consent.

WORKBOOK EXERCISES
Exercise 8.1: Window Layout Calculation
Calculate window positions for a 2560x1440 monitor (no taskbar) with 4 platforms in 2x2 layout. Account for 16px horizontal chrome and 88px vertical chrome. What are the exact left, top, width, height values for each window?
Exercise 8.2: Extension ID Discovery
Explain why the dashboard cannot automatically discover the extension ID. What security problem would this create if it were possible?
Exercise 8.3: Race Condition Analysis
Describe what happens if:
User clicks "Capture All"
One window closes during capture
Content script in that window does not respond
How does Promise.allSettled() handle this differently than Promise.all()? Why did we choose allSettled?
Exercise 8.4: Message Flow Tracing
Trace the complete message path when dashboard clicks "Excavate All":
Dashboard JavaScript sends message to...
Which forwards to...
Which creates windows via...
Which stores IDs in...
List every step and component involved.
Exercise 8.5: CORS Verification
Your dashboard is at https://your-domain.com/archaeology/. The extension tries to message it. What manifest declaration is required? What happens if you omit externally_connectable?
Exercise 8.6: Session Correlation
You capture from 4 platforms with session ID "exc_abc123". Later, you want to find all 4 captures. What metadata is stored in each file to enable this? What server file links them together?

CHAPTER 8 MEMORY DUMP / RESTORE POINT
COPY EVERYTHING BELOW THIS LINE TO SAVE YOUR PROGRESS:
plainCopy
ARCHAEOLOGY INTELLIGENCE PLATFORM - CHAPTER 8 COMPLETE
Date: [CURRENT DATE]
Status: Multi-Window Excavation System fully operational

FILES CREATED/UPDATED:
Extension:
- manifest.json (added windows, tabs permissions + externally_connectable)
- background.js (window management, tracking, capture coordination)
- content.js (PERFORM_CAPTURE handler for coordinated capture)

Server:
- api/session.php (session metadata storage)
- api/capture.php (updated with session support)

Dashboard:
- dashboard-integration.js (excavation controls, extension communication)
- index.html (includes dashboard-integration.js)
- style.css (excavation panel styles)

CONCEPTS LOCKED IN:
- Window creation requires "windows" permission
- calculateOptimalLayout() handles 1/2/3/4 platform arrangements
- Chrome compensation (16px H, 88px V) for accurate content sizing
- Window IDs are ephemeral, must validate before use
- chrome.windows.onRemoved event for tracking cleanup
- Promise.allSettled() for resilient multi-window operations
- Session IDs correlate captures across platforms
- externally_connectable required for dashboard→extension messaging
- Extension ID must be hardcoded in dashboard (no discovery mechanism)
- Bidirectional communication: dashboard sends commands, extension pushes updates

SYSTEM CAPABILITIES:
✅ Single-click multi-window launch (2x2, 3-column, 2-up, single layouts)
✅ Window position optimization for screen size
✅ Real-time window tracking (open/closed/focused status)
✅ Coordinated "Capture All" with session correlation
✅ Dashboard integration with status polling
✅ Query pre-fill where platforms support URL parameters
✅ Visual feedback during excavation and capture

EXCAVATION WORKFLOW:
Dashboard: Enter query → Click "Excavate All" → Extension opens windows → 
User waits for responses → Click "Capture All" → Extension messages each content script → 
Each content script extracts and sends to background → Background POSTs to server → 
Server saves with session metadata → Dashboard refreshes recent captures

NEXT CHAPTER: Chapter 9 - Understanding the Email Pipe
- Will implement email-based capture as backup/alternative
- Will set up email forwarding to archive address
- Will process incoming emails automatically
- Will extract chat content from email format

RESTORE INSTRUCTIONS:
To restore this state in a new chat, paste this memory dump and say:
"I am restoring Chapter 8 of the Archaeology Intelligence Platform manual.
I have complete multi-window excavation system with dashboard integration.
Extension can open 1/2/3/4 platform layouts, track windows, coordinate captures.
Dashboard has excavation panel with query input, platform selection, status display.
Session correlation links multi-platform captures together.
Please continue with Chapter 9: Understanding the Email Pipe."

CHAPTER 8 COMPLETE
What Chapter 8 Contains (Per TOC):
✅ 8.1 Opening Multiple Windows from One Click (excavation launch system)
✅ 8.2 Positioning Windows Side-by-Side (responsive layout algorithms)
✅ 8.3 Tracking Which Windows Are Open (event-driven window monitoring)
✅ 8.4 The "Capture All" Function (coordinated multi-window capture)
✅ 8.5 Communication Between Dashboard and Extension (bidirectional messaging)
Files Updated:
manifest.json - Added permissions and externally_connectable
background.js - Window management, tracking, capture coordination
content.js - Coordinated capture handler
api/session.php - Session metadata storage
dashboard-integration.js - Dashboard controls and messaging
style.css - Excavation panel styling
Ready for Chapter 9: Understanding the Email Pipe (alternative capture method via email)

Should I proceed with Chapter 9, or do you need any adjustments to Chapter 8?

