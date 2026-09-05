CHAPTER 2: Preparing Your SureServer Workspace
2.1 Logging Into cPanel for the First Time
What this is:
cPanel is the control panel for your SureServer hosting account. It provides a visual interface to manage files, email, databases, and other server functions without needing command-line knowledge.
Where this exists in the real world:
Every web hosting account has a control panel. cPanel is the industry standard. Your hosting provider (SureServer) gave you login credentials when you signed up.
How you encounter this:
You access cPanel through your web browser by entering a specific URL and credentials.
What this controls or affects:
cPanel controls everything on your server: where files are stored, how email works, what domains are connected, security settings, and more. This is the foundation layer for everything you will build.
What goes wrong when this is misunderstood:
Losing login credentials (requires contacting support)
Not understanding that cPanel is separate from your website (it's the control panel behind the website)
Accidentally deleting files or changing settings without knowing what they do
Concept Lock-In:
cPanel is your server's dashboard. Just as your Archaeology Platform will have a dashboard to manage research, cPanel is the dashboard to manage your server.

CLICK-BY-CLICK: First Login
Step 1: Find Your cPanel Login Information
Locate the email from SureServer with subject like "Your Hosting Account Details" or "Welcome to SureServer"
Find the line that says "cPanel URL" or "Control Panel"
The URL will look like: https://yourdomain.com:2083 or https://server.sureserver.com/cpanel
Step 2: Open Your Web Browser
Open Chrome, Edge, Firefox, or Safari
Click in the address bar at the top
Type or paste your cPanel URL exactly as provided
Press Enter
Step 3: Enter Your Credentials
You will see a login page with two fields:
Username: Enter the username from your welcome email
Password: Enter the password from your welcome email
Click the "Log in" button
Step 4: You Are Now in cPanel
You will see a dashboard with many icons organized in sections
The layout has a header with your account name, a sidebar with categories, and main area with icons
Do not click anything yet. Just observe.
Why this matters:
This is the control center. Every file you upload, every email you create, every setting you change happens here. Understanding this interface is prerequisite to everything that follows.

2.2 Understanding the cPanel Layout
What this is:
cPanel organizes functions into categories. You need to know where File Manager (for uploading) and Email (for your archive pipe) are located.
Where this exists in the real world:
This is the standard cPanel interface used by millions of websites globally. Once learned, it transfers to any cPanel-based host.
How you encounter this:
You will use File Manager in nearly every chapter. You will use Email Forwarders in Part IV. Knowing where these are saves time and prevents errors.
What this controls or affects:
Efficiency and accuracy. Clicking wrong sections leads to wrong settings.
What goes wrong when this is misunderstood:
Looking in "Domains" when you need "Files"
Using "Email Accounts" when you need "Forwarders"
Accidentally modifying "DNS" or "PHP Settings" without understanding
Concept Lock-In:
cPanel is organized by function: Files, Email, Databases, Domains, Metrics, Security, Software, Advanced. You primarily need Files and Email.

CLICK-BY-CLICK: Finding Key Sections
Step 1: Locate the FILES Section
Scroll down the main cPanel page
Look for a heading labeled FILES
Under it, you will see icons including:
File Manager (looks like a folder) — THIS IS YOUR PRIMARY TOOL
Images
Directory Privacy
Disk Usage
Web Disk
Click once on "File Manager" to open it, then close it (we're just learning location)
Step 2: Locate the EMAIL Section
Scroll up or down to find heading EMAIL
Under it, you will see:
Email Accounts (for creating addresses)
Forwarders (for routing emails to scripts)
Email Routing
Mailing Lists
Autoresponders
Track Delivery
Note these locations. Do not click yet.
Step 3: Locate the DOMAINS Section
Find heading DOMAINS
Note "Subdomains" — you may use this later
Note "Redirects" — useful for testing
Step 4: Return to Main cPanel Dashboard
Click the cPanel logo or "Home" button if you opened anything
You should see the full icon grid again
Why this matters:
You will open File Manager 50+ times during this build. Knowing exactly where it is prevents hunting and clicking wrong icons.

2.3 Creating Your First Directory (Folder)
What this is:
A directory (folder) is a container for files. Your Archaeology Platform needs specific folders: one for the dashboard, one for chat storage, one for business profiles. Creating these now establishes the foundation.
Where this exists in the real world:
Every computer has folders. Your desktop has folders. Your phone has folders (called "albums" or "directories"). Server folders work identically but are accessed through cPanel instead of your computer's file explorer.
How you encounter this:
You will create /archaeology-dashboard/ as the main container. Inside it, subfolders for api/, storage/, system/. This organization prevents chaos later.
What this controls or affects:
File organization determines whether you can find things later. Good structure: easy maintenance. Bad structure: lost files, broken references, abandoned project.
What goes wrong when this is misunderstood:
Creating folders in wrong location (public_html vs. root)
Misspelling folder names (case sensitivity matters: API ≠ api)
Creating nested folders accidentally (folder inside folder inside folder)
Not understanding that web-accessible files must be in public_html/
Concept Lock-In:
Your server has a public_html/ folder. Anything inside it is accessible via web browser. Your dashboard goes here. Your storage folders also go here (protected later).

CLICK-BY-CLICK: Creating the Main Directory
Step 1: Open File Manager
In cPanel main dashboard, click File Manager under FILES section
A new tab or window opens showing File Manager interface
You see a folder tree on left, file list on right
The current location shows as /home/username/ or similar at top
Step 2: Navigate to public_html
In left sidebar, click on public_html
The right panel updates to show contents of public_html
This is where your website files live
If you see cgi-bin, that's normal. Ignore it.
Step 3: Create New Folder
Look for button labeled + Folder or New Folder (top left of file list)
Click it
A dialog box appears asking for "New Folder Name"
Type exactly: archaeology-dashboard
Click Create New Folder
Step 4: Verify Creation
You should now see archaeology-dashboard in the file list
It has a folder icon (📁)
Double-click it to enter the folder
The path at top should show /home/username/public_html/archaeology-dashboard/
The folder is empty (no files yet)
Step 5: Create Subfolders
While inside archaeology-dashboard, click + Folder again
Create folder: api
Click + Folder again
Create folder: storage
Click + Folder again
Create folder: system
You now have 3 subfolders
Step 6: Create storage subfolders
Double-click storage to enter it
Click + Folder
Create: chats
Enter chats, create: chatgpt
Enter chats, create: claude
Enter chats, create: gemini
Enter chats, create: perplexity
Enter chats, create: business-profiles
Step 7: Verify Complete Structure
Navigate back to archaeology-dashboard (click it in breadcrumb or left sidebar)
You should see:
api/ (folder)
storage/ (folder)
system/ (folder)
Enter storage/, you should see:
chats/ (folder)
business-profiles/ (folder)
Enter chats/, you should see:
chatgpt/
claude/
gemini/
perplexity/
Why this matters:
This folder structure is the skeleton of your system. Every file created in future chapters goes in a specific location. Knowing where things belong prevents "where did I put that?" problems.

2.4 Understanding File Permissions (What 755 and 644 Mean)
What this is:
File permissions control who can read, write, or execute files. On a web server, this determines whether visitors can see your pages, whether scripts can run, and whether you can upload or modify files.
Where this exists in the real world:
Every file on every computer has permissions. Your personal computer hides this complexity. Servers expose it because multiple users (you, the web server, visitors) need different access levels.
How you encounter this:
cPanel File Manager shows permissions as numbers (644, 755) or letters (rw-r--r--). You will set permissions when uploading scripts that need to run or folders that need to be written to.
What this controls or affects:
Whether your website displays or shows "Forbidden" error
Whether your scripts can save files (chat captures)
Whether hackers can exploit your system
Whether you can edit files through cPanel
What goes wrong when this is misunderstood:
Setting everything to 777 (world-writable) = security vulnerability
Setting scripts to 644 (not executable) = "Internal Server Error"
Setting folders to 644 (not traversable) = "404 Not Found"
Not understanding that 755 = owner can do everything, others can only read/traverse
Concept Lock-In:
Permissions are three-digit numbers representing owner/group/world access. For this project: folders = 755, PHP files = 644, executable scripts = 755. You rarely need anything else.

CLICK-BY-CLICK: Setting Permissions
Step 1: Locate Permission Column
In File Manager, look at file list
There is a column labeled "Permissions" or "Perms"
Folders likely show 755, files show 644
Step 2: Understand What You See
755 on a folder means: owner can read/write/enter, others can read/enter only
644 on a file means: owner can read/write, others can read only
These are correct defaults. Do not change yet.
Step 3: When You WILL Change Permissions
Later, when creating PHP scripts that save files, you may need to ensure folders are 755
If a script cannot write to a folder, you check permissions
If a page shows "Forbidden," you check permissions
Step 4: How to Change (When Needed)
Right-click on file or folder
Select "Change Permissions" or "Permissions"
Dialog shows checkboxes for Read, Write, Execute
Or shows numeric input
For folders: ensure 755 (rwxr-xr-x)
For PHP files: ensure 644 (rw-r--r--)
Click "Change Permissions"
Why this matters:
Permission errors are cryptic ("500 Internal Server Error"). Understanding permissions lets you diagnose and fix without contacting support.

2.5 Creating the Complete Directory Structure
What this is:
The full folder tree where every file in this manual will live. Creating it now means never stopping mid-chapter to "create a folder."
Where this exists in the real world:
This is your project's filing system. Just as a physical office has filing cabinets with labeled drawers, your server has directories with specific purposes.
How you encounter this:
You will upload files to these folders. The code references these paths. If a file expects to be in api/ but you put it in storage/, it breaks.
What this controls or affects:
Every file location in every code block in this manual. One wrong folder = broken system.
What goes wrong when this is misunderstood:
Creating folders in wrong parent (storage inside api instead of archaeology-dashboard)
Typos in folder names (Archaeology vs archaeology — servers are case-sensitive)
Forgetting to create subfolders (missing chatgpt/ inside chats/)
Not understanding that paths are relative (../ means parent folder)
Concept Lock-In:
You are building a physical structure on your server. The blueprint is fixed. Follow it exactly.

CLICK-BY-CLICK: Complete Structure Creation
Step 1: Verify You Are in archaeology-dashboard
File Manager path should show: /home/username/public_html/archaeology-dashboard/
If not, navigate there via left sidebar or breadcrumb
Step 2: Create All First-Level Folders
Click + Folder, type: api, click Create
Click + Folder, type: storage, click Create
Click + Folder, type: system, click Create
Step 3: Enter storage and Create Second-Level
Double-click storage
Click + Folder, type: chats, click Create
Click + Folder, type: business-profiles, click Create
Click + Folder, type: processed, click Create
Step 4: Enter chats and Create Third-Level
Double-click chats
Click + Folder, type: chatgpt, click Create
Click + Folder, type: claude, click Create
Click + Folder, type: gemini, click Create
Click + Folder, type: perplexity, click Create
Step 5: Enter api and Prepare for Files
Navigate back to archaeology-dashboard
Double-click api
This folder starts empty. You will upload files here in Chapter 4 and 10.
Step 6: Enter system and Prepare for Files
Navigate back to archaeology-dashboard
Double-click system
This folder starts empty. You will upload files here in Chapter 2 and 10.
Step 7: Final Verification
Navigate to archaeology-dashboard (top level)
You should see exactly 3 folders: api, storage, system
Enter storage → see 3 folders: chats, business-profiles, processed
Enter chats → see 4 folders: chatgpt, claude, gemini, perplexity
COMPLETE STRUCTURE:
plainCopy
archaeology-dashboard/
├── api/
├── storage/
│   ├── chats/
│   │   ├── chatgpt/
│   │   ├── claude/
│   │   ├── gemini/
│   │   └── perplexity/
│   ├── business-profiles/
│   └── processed/
└── system/
Why this matters:
This exact structure is referenced in every file path in this manual. Deviating from it means every code block needs manual editing. Following it means copy-paste works.

2.6 Verifying Your Setup
What this is:
Confirmation that everything is in place before proceeding. Catches errors early when they're easy to fix.
Where this exists in the real world:
Quality control checkpoint. Like checking you have all ingredients before cooking.
How you encounter this:
You will attempt to access your folder via web browser to confirm it's reachable.
What this controls or affects:
Confidence that foundation is solid. Prevents building on broken base.
What goes wrong when this is misunderstood:
Skipping verification, discovering problems in Chapter 5
Not understanding that empty folder = "Forbidden" is normal (no index file yet)
Panicking when you see errors that are actually expected
Concept Lock-In:
Verification is not "making it work" yet. It's "confirming the container exists."

CLICK-BY-CLICK: Verification Test
Step 1: Open New Browser Tab
Press Ctrl+T (Windows) or Cmd+T (Mac)
New empty tab opens
Step 2: Construct Your URL
Your domain is: yourdomain.com (replace with your actual domain)
Your folder is: archaeology-dashboard
Full URL: http://yourdomain.com/archaeology-dashboard/
Step 3: Enter URL and Test
Click in address bar
Type your full URL
Press Enter
Step 4: Expected Result
You will see an error: "403 Forbidden" or "404 Not Found" or directory listing
THIS IS CORRECT. You have no index file yet.
If you see "403" or directory listing = folder exists and is web-accessible ✓
If you see "404" = folder name typo or wrong location ✗
Step 5: If You See 404
Check: did you spell archaeology-dashboard correctly?
Check: is it inside public_html?
Check: does your domain point to this server?
Return to File Manager and verify location
Step 6: Document Your URL
Write down: http://yourdomain.com/archaeology-dashboard/
This is your dashboard URL for the entire project
Why this matters:
Confirming the container exists and is accessible means when you upload your first file in Chapter 3, you know exactly where to find it.

CHAPTER 2 MEMORY DUMP / RESTORE POINT
Completed in This Chapter:
cPanel located and logged into
File Manager identified and opened
Directory structure created:
archaeology-dashboard/ (main container)
api/ (for backend scripts)
storage/chats/ with platform subfolders
storage/business-profiles/
storage/processed/
system/ (for configuration)
Permissions understood (755 folders, 644 files)
Web accessibility verified (403/404 error = success)
Active Decisions:
Folder names are lowercase with hyphens (archaeology-dashboard, not ArchaeologyDashboard)
Structure is flat: no deeper nesting than 3 levels
All storage is in storage/ — no scattered files
Files Created: None yet (folders only)
Next Chapter: 3 — Creating Your First Web Page
Restore Prompt for New Chat:
plainCopy
I am building the Archaeology Intelligence Platform per the manual. 
Chapter 2 is complete. Directory structure exists at:
/home/username/public_html/archaeology-dashboard/ with subfolders 
api/, storage/chats/(chatgpt,claude,gemini,perplexity), 
storage/business-profiles/, storage/processed/, system/.
Ready to begin Chapter 3: Creating Your First Web Page.

