CHAPTER 3: Creating Your First Web Page
3.1 What HTML Is (Plain English)
What this is:
HTML (HyperText Markup Language) is the standard language for creating web pages. It is not programming. It is markup—a way of labeling content so browsers know what to display. Think of it like labeling boxes when moving: "Kitchen," "Bedroom," "Fragile." The labels don't change what's inside, they tell the handler how to treat it.
Where this exists in the real world:
Every website you visit uses HTML. When you view a page, right-click and select "View Page Source," you see HTML. Your Archaeology Dashboard will be an HTML file that the browser reads and displays as a visual interface.
How you encounter this:
You will write HTML files that create the structure of your dashboard: where the sidebar goes, where the search box goes, where content panels appear. Without HTML, there is no visual interface.
What this controls or affects:
HTML controls:
What content appears on screen (text, images, buttons)
The structure and hierarchy (headers, paragraphs, sections)
Navigation between pages (links)
Forms for user input (search boxes, text areas)
What goes wrong when this is misunderstood:
Confusing HTML with programming (it's markup, not code that "runs")
Thinking HTML controls appearance (that's CSS—HTML is structure only)
Forgetting closing tags (every <tag> needs </tag>)
Not understanding that browsers are forgiving (broken HTML often still displays, but unpredictably)
Concept Lock-In:
HTML is the skeleton of your web page. It defines what exists. CSS (Chapter 4) is the skin and clothes—how it looks. JavaScript (Chapter 4) is the muscles—how it moves and responds. You are building the skeleton first.

3.2 Opening a Text Editor
What this is:
A text editor is a program that creates plain text files without formatting. Not Microsoft Word (which adds hidden formatting). Not Notepad (which works but is primitive). You need an editor that shows line numbers, highlights syntax, and doesn't corrupt code with invisible characters.
Where this exists in the real world:
Programmers use text editors daily. Common free options: Notepad++ (Windows), TextEdit (Mac, in plain text mode), VS Code (cross-platform, most popular), Sublime Text.
How you encounter this:
You will write all files for this project in a text editor: HTML, CSS, JavaScript, PHP. The editor saves files that you upload to SureServer.
What this controls or affects:
File integrity. Word processors insert hidden characters that break code. Text editors save exactly what you type.
What goes wrong when this is misunderstood:
Using Microsoft Word → files full of invisible formatting → broken website
Using rich text editors → curly quotes instead of straight quotes → syntax errors
Not saving as .html extension → browser doesn't know how to render
Not understanding that "plain text" is a specific format, not just "typing simply"
Concept Lock-In:
A text editor is your workshop. Just as you wouldn't paint with a spreadsheet program, you don't write code in a word processor. The tool must match the material.

CLICK-BY-CLICK: Installing and Opening a Text Editor
Option A: Notepad++ (Windows, Recommended for Beginners)
Step 1: Download Notepad++
Open browser, go to: https://notepad-plus-plus.org/downloads/
Click the latest version download link
Save the .exe file to your Downloads folder
Step 2: Install
Open Downloads folder
Double-click the downloaded file
Follow installation wizard (accept defaults, click Next/Install/Finish)
Check "Create shortcut on desktop" if offered
Step 3: Open Notepad++
Double-click desktop icon, or
Press Windows key, type "notepad++", press Enter
Window opens with blank document titled "new 1"
Step 4: Configure for Web Development
Click menu: Settings → Preferences
Left sidebar: click New Document
Under "Format," select Unix (LF) (important for server compatibility)
Under "Encoding," select UTF-8
Click Close
Option B: TextEdit (Mac, Already Installed)
Step 1: Open TextEdit
Press Cmd+Space, type "textedit", press Enter
Or: Applications folder → TextEdit
Step 2: Switch to Plain Text Mode
TextEdit defaults to Rich Text (bad for code)
Click menu: Format → Make Plain Text
Or press Shift+Cmd+T
Window should show plain white background, no formatting toolbar
Step 3: Configure Defaults
Click menu: TextEdit → Preferences
Tab: New Document
Select Plain text as default
Tab: Open and Save
Check Display HTML files as HTML code (not formatted text)
Close preferences window
Option C: VS Code (Any Platform, Professional Standard)
Step 1: Download
Go to: https://code.visualstudio.com/
Click download for your platform (Windows/Mac/Linux)
Save installer
Step 2: Install
Run installer
Accept defaults
Important: Check "Add to PATH" if offered (makes command-line access easier)
Step 3: Open
Launch VS Code
Welcome screen appears
Step 4: Install Helpful Extensions (Optional but Recommended)
Click icon on left sidebar that looks like four squares (Extensions)
Search: "HTML"
Install: "HTML Preview" or "Live Server" (for seeing changes instantly)
Search: "Auto Rename Tag"
Install it (automatically closes tags when you type)
Verification: Test Your Editor
Step 1: Create Test File
Type in editor: This is a test
Click File → Save As (or Save)
Navigate to your Desktop
Filename: test.txt
Click Save
Step 2: Verify Plain Text
Close editor
Find file on Desktop
Right-click → Open With → Notepad (Windows) or TextEdit (Mac)
You should see exactly: This is a test with no formatting, no bold, no fonts
Why this matters:
If you see formatted text, curly quotes, or different fonts, you are not in plain text mode. Your code will break when uploaded. Stop and fix your editor settings before proceeding.

3.3 Writing Your First HTML File
What this is:
Creating the basic structure of a web page. Every HTML file has required elements that tell the browser "this is a web page." You will create the foundation that all future chapters build upon.
Where this exists in the real world:
Every .html file on the internet starts with the same basic structure. This is the standard template.
How you encounter this:
You will write index.html—the default page that loads when someone visits your folder. This becomes your dashboard's entry point.
What this controls or affects:
Whether browsers recognize your file as a web page. Without proper structure, browsers display raw code or nothing at all.
What goes wrong when this is misunderstood:
Forgetting <!DOCTYPE html> → browser renders in "quirks mode" (unpredictable)
Missing <html>, <head>, or <body> → broken page
Typos in tags → browser ignores them or displays raw code
Not saving with .html extension → browser treats as plain text
Concept Lock-In:
HTML structure is like a letter format: date, greeting, body, closing. Skip the greeting and people are confused. Skip <head> and browsers are confused.

CLICK-BY-CLICK: Creating index.html
Step 1: Open Your Text Editor
Use the editor you configured in Section 3.2
You should see blank document, cursor blinking
Step 2: Type the Complete HTML Structure
Type exactly as shown below (copy-paste ready):
HTMLPreviewCopy
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archaeology Intelligence Platform</title>
</head>
<body>
    <h1>Your Dashboard Is Working</h1>
    <p>This is your Archaeology Intelligence Platform.</p>
    <p>Chapter 3 complete. Ready for Chapter 4.</p>
</body>
</html>
Step 3: Understanding What You Typed
Table
Line
What It Is
What It Does
<!DOCTYPE html>
Document type declaration
Tells browser: "This is HTML5"
<html lang="en">
Root element
Container for entire page; lang="en" = English
<head>
Head section
Metadata: title, character set, links to CSS/JS (not visible on page)
<meta charset="UTF-8">
Character encoding
Ensures special characters display correctly
<meta name="viewport"...>
Mobile responsiveness
Makes page work on phones/tablets
<title>...
Page title
Appears in browser tab and bookmarks
</head>
Close head section
Required closing tag
<body>
Body section
All visible content goes here
<h1>...
Heading 1
Main title, largest text
<p>...
Paragraph
Body text
</body>
Close body section
Required closing tag
</html>
Close HTML document
Required closing tag

Step 4: Save the File Correctly
Critical Save Steps:
Click File → Save As (or Ctrl+Shift+S / Cmd+Shift+S)
Navigate to location where you can find it easily (Desktop recommended for now)
Filename: index.html (exactly, with .html extension)
File type: If asked, select "All Files" or "HTML Files" (not .txt)
Click Save
Step 5: Verify File Type
Look at the file icon on Desktop
Should show browser icon (Chrome, Edge, Safari) or "HTML" label
If it shows text file icon or Notepad icon, extension is wrong
Fix: Rename to ensure .html not .html.txt

3.4 Uploading to SureServer
What this is:
Transferring your HTML file from your computer to your server so it becomes accessible via web browser. This is the bridge between "file on your desk" and "website on the internet."
Where this exists in the real world:
Every website requires files to be on a server. Uploading is how they get there. Methods: cPanel File Manager (point-and-click), FTP programs (FileZilla), or direct server editing.
How you encounter this:
You will upload every file you create to your SureServer. This manual uses cPanel File Manager (no additional software needed).
What this controls or affects:
Whether your dashboard is accessible. File on computer = only you can see it. File on server = anyone with URL can see it (or just you, if you keep URL private).
What goes wrong when this is misunderstood:
Uploading to wrong folder → file not found at expected URL
Uploading with wrong name → broken links
Not refreshing browser after upload → seeing old version
Uploading as binary vs. ASCII (rarely matters for HTML, but critical for images/scripts)
Concept Lock-In:
Uploading is moving. Like moving a document from your desk to a filing cabinet where others can access it. The filing cabinet has specific drawers (folders) and you must put it in the right one.

CLICK-BY-CLICK: Uploading index.html
Step 1: Open cPanel File Manager
Log into cPanel (Chapter 2, Section 2.1)
Click File Manager under FILES section
Ensure you are in public_html/archaeology-dashboard/ (path shows at top)
Step 2: Open Upload Interface
Look for button: Upload (top toolbar)
Click it
New tab or dialog opens showing "Drop files here" area
Step 3: Select Your File
Click button: Select File or Browse
File browser opens (your computer's file picker)
Navigate to where you saved index.html (Desktop)
Click on index.html to select it
Click Open (Windows) or Choose (Mac)
Step 4: Complete Upload
File uploads automatically
Progress bar shows completion
Green checkmark or "100%" appears
Close upload tab/dialog (click X or Close)
Step 5: Verify Upload
Return to File Manager main tab
Refresh if needed (click circular arrow or press F5)
You should now see index.html in file list
Size shows (should be small, ~400 bytes)
Permissions show 644 (correct for HTML files)
Step 6: Check File Contents (Optional but Recommended)
Right-click on index.html
Select Edit or Code Edit
New tab opens showing your HTML code
Verify it matches what you typed
If correct, close tab
If incorrect, you can edit directly here and save

3.5 Viewing Your Page in a Browser
What this is:
Testing that your upload worked and your HTML renders correctly. This confirms the entire pipeline: create file → upload file → access via web.
Where this exists in the real world:
Every web developer does this hundreds of times per project. The cycle: edit → save → upload → refresh browser → repeat.
How you encounter this:
You will do this constantly. Every change you make, you upload and check. This is web development.
What this controls or affects:
Validation that your work is correct. If it doesn't display, something is wrong in the chain.
What goes wrong when this is misunderstood:
Forgetting to upload after editing → seeing old version, thinking changes failed
Browser caching old version → Ctrl+F5 needed (hard refresh)
Typo in URL → 404 error, thinking file is broken when it's just wrong address
Not understanding that server errors (500, 403) are different from "file not found" (404)
Concept Lock-In:
The browser is your testing ground. It shows you exactly what visitors will see. If it works in your browser, it works for others (mostly—there are cross-browser differences, but that's advanced).

CLICK-BY-CLICK: Testing Your Page
Step 1: Construct Your URL
Your domain: yourdomain.com (your actual domain)
Your folder: archaeology-dashboard
Your file: index.html (default, so optional to include)
Full URL: http://yourdomain.com/archaeology-dashboard/ or http://yourdomain.com/archaeology-dashboard/index.html
Step 2: Open Browser
Open Chrome, Edge, Firefox, or Safari
Click in address bar
Type your full URL
Press Enter
Step 3: Expected Result
Page loads showing:
Browser tab title: "Archaeology Intelligence Platform"
Large heading: "Your Dashboard Is Working"
Two lines of body text below
Step 4: Verify HTML Structure Worked
Right-click anywhere on page
Select View Page Source (or Inspect then Elements tab)
You should see your exact HTML code
This confirms the file uploaded correctly and is being served as HTML
Step 5: If You See "404 Not Found"
Check: Did you upload to archaeology-dashboard folder?
Check: Is file named index.html (not Index.html or index.htm)?
Check: Did you include public_html in URL? (Should NOT: yourdomain.com/archaeology-dashboard/ not yourdomain.com/public_html/archaeology-dashboard/)
Return to File Manager and verify file exists
Step 6: If You See "403 Forbidden"
This is actually progress—server sees the folder
Check: Is index.html spelled correctly?
Check: Are permissions 644 (not 000 or hidden)?
Try accessing: http://yourdomain.com/archaeology-dashboard/index.html (explicit filename)
Step 7: If You See Raw Code
File is not being processed as HTML
Check: File extension is .html not .txt
Check: Server is configured to serve HTML (it is by default)
Try re-uploading, ensure "ASCII" mode if FTP options appear
Step 8: Celebrate Success
Screenshot or note: "Chapter 3 complete, index.html working"
You have created and served your first web page

3.6 When Something Doesn't Work: Troubleshooting
What this is:
Diagnostic procedures for common problems. Systematic checking eliminates guesswork.
Where this exists in the real world:
Debugging is 50% of development. Knowing how to diagnose separates those who finish from those who abandon projects.
How you encounter this:
You will use these steps multiple times. Memorize the flow.
What this controls or affects:
Whether you get stuck for hours or fix problems in minutes.
What goes wrong when this is misunderstood:
Randomly changing things hoping for magic
Not checking the obvious (is file there? is URL correct?)
Assuming server is broken when it's a typo
Giving up instead of systematically checking
Concept Lock-In:
Troubleshooting is elimination. Check one thing at a time, verify it works, move to next. The problem is always in the chain: Editor → File → Upload → Location → URL → Browser.

TROUBLESHOOTING FLOWCHART
Problem: 404 Not Found
Table
Check
How
If Wrong
File exists on server?
File Manager → navigate folder
Re-upload
Filename correct?
Check spelling, case, extension
Rename or re-upload
In correct folder?
Check path shows archaeology-dashboard
Move file or re-upload to correct location
URL correct?
Domain + /archaeology-dashboard/
Fix URL construction
public_html included?
Should NOT be in URL
Remove from URL

Problem: 403 Forbidden
Table
Check
How
If Wrong
Index file exists?
File Manager listing
Create/upload index.html
Permissions correct?
Should be 644
Right-click → Change Permissions
Folder has index?
Check archaeology-dashboard has index.html
Upload to correct location

Problem: Page Blank or Wrong Content
Table
Check
How
If Wrong
View source shows code?
Right-click → View Page Source
If shows code, file uploaded as text not HTML (fix extension)
Uploaded after editing?
Check timestamp in File Manager
Re-upload
Browser cache?
Press Ctrl+F5 (hard refresh)
Clear cache or use incognito window
Editor saved correctly?
Re-open file in editor
Re-save as .html not .txt

Problem: Formatting Looks Wrong
Table
Check
How
If Wrong
CSS loaded?
Check Chapter 4 not done yet
Normal—no styling until CSS added
HTML structure valid?
View source, check tags match
Fix unclosed tags
Special characters garbled?
Check <meta charset="UTF-8"> present
Add to <head>


CHAPTER 3 MEMORY DUMP / RESTORE POINT
Completed in This Chapter:
Text editor installed and configured (Notepad++, TextEdit, or VS Code)
First HTML file created: index.html
HTML structure understood: DOCTYPE, html, head, body, basic tags
File uploaded to: public_html/archaeology-dashboard/index.html
File verified working at: http://yourdomain.com/archaeology-dashboard/
Troubleshooting flowchart documented
Active Decisions:
Using cPanel File Manager for uploads (not FTP)
File naming: lowercase, hyphens, .html extension
Editor in plain text mode, UTF-8 encoding, Unix line endings
Files Created:
/home/username/public_html/archaeology-dashboard/index.html (464 bytes, permissions 644)
Working URL:
http://yourdomain.com/archaeology-dashboard/
Next Chapter: 4 — Building the Main Dashboard Interface
Restore Prompt for New Chat:
plainCopy
I am building the Archaeology Intelligence Platform per the manual.
Chapter 3 is complete. index.html created and uploaded to 
/home/username/public_html/archaeology-dashboard/index.html.
File is live at http://yourdomain.com/archaeology-dashboard/ 
showing "Your Dashboard Is Working". 
Ready to begin Chapter 4: Building the Main Dashboard Interface.

