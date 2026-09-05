MEMORY HANDOFF DOCUMENT
Project: JobHunt Command Center v3
URL: johnjobs.legaisee.com
Status: 500 Server Error (was previously loading but forms not saving)
Date: 2026-07-03

￼
ORIGINAL WORKING STATE (Before Any Fixes)
Three files in /public_html/ (or equivalent web root):
 • index.php — Single-file dashboard (PHP + HTML + CSS + JS). Navigation worked. Forms displayed. BUT clicking Save did nothing.
 • db.php — SQLite setup. Creates jobhunt.db, documents/ folder, conversations/ folder.
 • api.php — REST API router using $_GET['path'] for endpoint routing.
Original symptom: Clicking "Save to Pipeline" or "Save to Prospect Cue" produced no response — no toast, no error, no database entry.

￼
ROOT CAUSE DISCOVERED
The original index.php had JavaScript syntax errors in inline onclick handlers that broke the entire script execution:

<!-- BROKEN: \' inside HTML attribute becomes literal backslash+quote in JS -->
onclick="showSection('prospect-cue', document.querySelector('.nav-item[onclick*=\'prospect-cue\']'))"


￼
This created a JS parse error: inside the string '.nav-item[onclick*='prospect-cue']', the ' after *= terminated the string, making prospect-cue bare JS code.
Additionally, showSection(id, el) expected event.currentTarget but inline handlers passed this without event.

ATTEMPTED FIXES (Led to 500 Error)
Fix 1: Replaced all inline onclick="showSection('x', this)" with data-section="x" + event delegation. Replaced broken querySelector calls with navTo() helper. Added apiPost/apiGet/apiDelete wrappers with response.ok checking.
Fix 2: Rewrote api.php path extraction to use REQUEST_URI parsing + $_GET['path'] fallback + $_GET['__path'] + $input['__path'] from POST body. Added query string stripping (? and &) from path values.
Fix 3: Changed JS to send __path in POST body instead of URL query param. Changed GET/DELETE to use ?__path= instead of ?path=.
Result: 500 Server Error. Likely caused by PHP syntax error in api.php or index.php (possibly from the triple-quoted string writing corrupting escape sequences).

￼
WHAT THE USER NEEDS
1. Get back to a working page (no 500 error)
2. Fix the form saving so Pipeline and Prospect Cue actually write to the SQLite database

￼
RECOMMENDED APPROACH FOR NEXT CHAT
Step 1: Start Fresh with Known-Good Files
The user has the original three files that loaded without 500 errors. The next chat should:
1. Ask the user to re-upload the original index.php, db.php, and api.php (the versions that showed the page but didn't save)
2. Verify the page loads without 500 error
3. Open browser DevTools → Console to see the actual JS error
Step 2: Minimal Surgical Fix
Instead of rewriting the entire JS block, make the smallest possible changes:
 • Fix the inline onclick syntax errors by replacing \' with proper escaping
 • OR remove the problematic Quick Action buttons entirely (they're non-essential)
 • Keep showSection(id, el) signature as-is — it works when called correctly
 • Keep the original api.php routing — $_GET['path'] works on this server (confirmed by debug output showing "request_uri":"/api.php?path=prospects?status=all")
Step 3: Add Diagnostic Logging
Add error_log() calls in api.php to trace what's happening:

error_log("API: method=$method path=$path input=" . json_encode($input));


Add console.log() in JS before every fetch() to see what's being sent.
Step 4: Test Incrementally
1. Test api.php?path=applications directly in browser — should return []
2. Test a simple POST with curl or fetch console
3. Then test the form

￼
SERVER ENVIRONMENT NOTES
 • Hosting: SureServer cPanel (shared hosting)
 • PHP: Likely 7.4+ (PDO SQLite available)
 • Domain: Subdomain johnjobs.legaisee.com
 • Database: SQLite file jobhunt.db in same directory
 • File permissions needed: jobhunt.db writable (666), documents/ directory writable (755)
 • Potential issue: WordPress .htaccess in parent legaisee.com may affect subdomain routing

￼
FILES THE USER SHOULD HAVE
The user uploaded three original files to this chat. They are available in the conversation history as:
1. user_pasted_clipboard_long_content_as_file__php_index.php_-_JobHunt_Command_Cen1.txt
2. user_pasted_clipboard_long_content_as_file__php_db.php_-_SQLite_database_setup_2.txt
3. user_pasted_clipboard_long_content_as_file__php_api.php_-_REST_API_for_JobHunt_3.txt

￼
CRITICAL: DO NOT
 • Do NOT rewrite the entire api.php routing system
 • Do NOT change from $_GET['path'] to $_GET['__path'] or POST body routing — the server handles $_GET['path'] correctly
 • Do NOT replace all inline onclick with event delegation unless necessary — the original nav items worked, only the Quick Action buttons were broken
 • Do NOT add complex .htaccess rules — shared hosting may reject them

￼
SUCCESS CRITERIA
1. Page loads without 500 error
2. Navigation between sections works
3. Filling out Pipeline form and clicking "Save to Pipeline" creates a row in the applications table
4. Filling out Prospect Cue form and clicking "Save to Prospect Cue" creates a row in the prospects table
5. Saved items appear in the list below the form

￼
LAST SCREENSHOT FROM USER
Showed console error:

Error loading prospects: HTTP 404: {"error":"Endpoint not found: prospects?status=all","debug":{"method":"GET","path":"prospects?status=all","request_uri":"/api.php?path=prospects?status=all&source=all&sort=newest",...}}

This confirmed:
 • api.php IS executing (returns JSON, not 500)
 • $_GET['path'] IS being received by PHP
 • The path value includes the query string (prospects?status=all instead of prospects)
 • The URL construction in JS is malformed: ?path=prospects?status=all has two ?
The fix needed is simply: strip ? and everything after it from the path value in api.php before routing, OR fix the JS URL construction to use & for additional params.

￼
SIMPLEST FIX (If Starting from Original Files)
In api.php, after $path = $_GET['path'];, add:

if (($pos = strpos($path, '?')) !== false) {
    $path = substr($path, 0, $pos);
}

In index.php, in the loadProspectCue() function, change:

// OLD (broken - creates ?path=prospects?status=all):
const r = await fetch(API_BASE + 'prospects?status=' + status + '&source=' + source + '&sort=' + sort);

// NEW:
const r = await fetch(API_BASE + 'prospects&status=' + status + '&source=' + source + '&sort=' + sort);

Where API_BASE = 'api.php?path=';
So the URL becomes: api.php?path=prospects?status=all&source=all&sort=newest
The fix is to change API_BASE and how URLs are built:

const API_BASE = 'api.php';
// Then: fetch(API_BASE + '?path=prospects&status=' + status + ...)


const API_BASE = 'api.php';
// Then: fetch(API_BASE + '?path=prospects&status=' + status + ...)


This is a 3-line fix in the JS, not a full rewrite.

￼
END OF HANDOFF



















