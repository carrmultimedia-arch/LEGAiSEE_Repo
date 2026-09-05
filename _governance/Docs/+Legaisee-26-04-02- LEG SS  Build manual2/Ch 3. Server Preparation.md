Chapter 3 — Server Preparation (FOUNDATION FOR REAL DATA PIPELINE)
This is where your system transitions from:
Local experiment

 → to


Persistent, server-backed asset system


We are preparing a central archive environment that your acquisition layer will write into.
This is critical because:
Local files = temporary


Server archive = long-term asset storage



3.1 Create Archive Folder Structure (WHY + HOW)
WHY This Matters
Right now your system saves files like:
output-123.json
That is not scalable.
You need:
Organized storage


Platform separation


Future indexing compatibility


Clean ingestion for search engines



TARGET STRUCTURE (LOCK THIS IN)
On your server (or local if simulating), you will create:
/archive/
  /gpt/
  /gemini/
  /claude/
  /kimi/
  /logs/
  /errors/

HOW — Create Structure
Option A — Local (Testing Phase)
Inside your project folder:
Run:
mkdir archive
cd archive
mkdir gpt gemini claude kimi logs errors

Option B — Server (SureServer via SSH)
Connect to your server:
ssh yourusername@yourserver.com
Navigate to your web root or storage directory:
cd ~/public_html
Create structure:
mkdir archive
cd archive
mkdir gpt gemini claude kimi logs errors

VERIFY STRUCTURE
Run:
ls -R
Expected output:
archive/
gpt/
gemini/
claude/
kimi/
logs/
errors/

SET PERMISSIONS (CRITICAL)
If Node scripts cannot write → system fails.

Linux/macOS
Run:
chmod -R 755 archive
chmod -R 775 archive
If needed for full write access:
chmod -R 777 archive
(Use 777 only if permissions fail — not ideal for production)

VERIFY WRITE ACCESS
Create test file:
touch archive/gpt/test.txt
If it works → permissions are correct

3.2 Configure API Endpoints (SERVER MODE)
WHY This Exists
Later, your system will:
Run locally OR remotely


Send data to your server via POST


Store assets centrally


This allows:
Distributed scraping


Centralized storage


Multi-machine scaling



STEP 1 — Install Express (Server API)
Inside your project:
npm install express body-parser

STEP 2 — Create Server File
Create file:
server.js

STEP 3 — Add Server Code
Write:
require(‘dotenv’).config();
const express = require(‘express’);
const fs = require(‘fs-extra’);
const app = express();
app.use(express.json());
const PORT = 3000;
app.post(’/save’, async (req, res) => {
 try {
  const { platform, data } = req.body;
  const filePath = ./archive/${platform}/${Date.now()}.json;
  await fs.writeJson(filePath, data, { spaces: 2 });
  res.json({ status: “saved”, path: filePath });
 } catch (err) {
  await fs.writeFile(./archive/errors/error-${Date.now()}.txt, err.message);
  res.status(500).json({ error: err.message });
 }
});
app.listen(PORT, () => {
 console.log(Server running on port ${PORT});
});

STEP 4 — Run Server
node server.js

EXPECTED OUTPUT
Server running on port 3000

STEP 5 — TEST ENDPOINT
Create test file:
test-post.js

Add:
const axios = require(‘axios’);
axios.post(‘http://localhost:3000/save’, {
 platform: “gpt”,
 data: {
  test: “Hello from client”
 }
})
.then(res => console.log(res.data))
.catch(err => console.error(err.message));

Run:
node test-post.js

EXPECTED RESULT
Console:
{ status: “saved”, path: “./archive/gpt/xxxxx.json” }
Check folder:
/archive/gpt/
You should see a new JSON file.

WHAT YOU JUST BUILT
You now have:
A local API server


A central ingestion endpoint


Structured storage by platform


Error logging system



3.3 Install Node.js & npm (SERVER SIDE)
WHY This Matters
Your server must:
Run scripts


Accept API requests


Process data


Without Node:
→ system cannot operate remotely

STEP 1 — CHECK INSTALLATION
On server:
node -v
npm -v

IF NOT INSTALLED (Ubuntu Example)
Run:
sudo apt update
sudo apt install -y nodejs npm

VERIFY AGAIN
node -v

OPTIONAL — INSTALL PM2 (PROCESS MANAGER)
This keeps your server running 24/7.
Install:
npm install -g pm2

RUN SERVER WITH PM2
pm2 start server.js –name ai-asset-server

CHECK STATUS
pm2 list

EXPECTED OUTPUT
Your process should show:
online

AUTO-RESTART ON REBOOT
pm2 startup
pm2 save

3.4 End-to-End Test (CRITICAL)
You now test full pipeline:
Start server


Run POST script


Confirm file saved



SUCCESS CONDITION
You have:
Working API server


Data written to archive


Organized storage



3.5 What You Have Now (SYSTEM STATE)
You officially have:
Data Ingestion Infrastructure
API endpoint


Structured archive system


Platform separation



Storage Evolution
Before:
Local → /outputs
Now:
Server → /archive/platform/

System Capability Upgrade
You can now:
Send data from ANY script


Store centrally


Prepare for multi-source ingestion



3.6 Memory Dump — Chapter 3

SYSTEM STATE v3
Storage:
/archive/ root established


Platform folders created


logs + errors tracking added


Server:
Express server running


POST endpoint: /save


JSON ingestion working


Execution:
Local scripts can send data to server


Server writes structured files



NEW CAPABILITIES
Centralized storage


Multi-machine architecture readiness


Error logging system


Platform-based organization



NEXT OBJECTIVE (Chapter 4)
Now we build the real engine:
Data Acquisition Layer (AUTOMATION)
You will implement:
Multi-prompt system


Platform switching (GPT, Claude, etc.)


Automated runs


Logging + retry logic


Asset ID system


This is where your system becomes:
→ self-running

When ready, say:
“Proceed to Chapter 4 — Data Acquisition Layer”

