Chapter 2 — Prerequisites (REAL SYSTEM READINESS)
This chapter ensures your system actually runs in the real world, not just in a controlled dev environment.
We are eliminating the most common failure points:
Environment mismatches


Missing dependencies


Browser automation failures


API/network blocking


By the end of this chapter, your machine will be verified and production-capable for the Data Acquisition Layer.

2.1 Hardware Requirements (WHY + HOW)
Minimum (Will Run, Not Ideal)
CPU: Dual-core


RAM: 8 GB


Storage: 10 GB free


Recommended (Real Workload)
CPU: 4+ cores


RAM: 16 GB


Storage: 50+ GB SSD


Why this matters
Browser automation (Puppeteer/Playwright) spins up headless Chromium instances


Each instance can consume:


200–500 MB RAM


AI pipelines + indexing later will multiply usage



Verification (Run This)
Open terminal:
On Mac/Linux:
free -h
On Windows:
wmic computersystem get TotalPhysicalMemory
Expected result:
You should see at least 8 GB



2.2 Operating System Requirements
Supported
Windows 10 / 11


macOS (Intel or Apple Silicon)


Linux (Ubuntu preferred)



Critical Requirement
You must have:
Terminal access


Ability to install global packages


File system write permissions



Verify Environment
Run:
node -v
Expected:
v18.x or higher
If below:
→ upgrade Node immediately

2.3 Network / Firewall Considerations
This system depends on:
External APIs (OpenAI, Gemini, etc.)


Browser automation (loads real websites)



Potential Problems
Corporate firewall blocking APIs


ISP throttling headless browsers


SSL interception breaking requests



Test API Connectivity
Run this quick test script.
Create file:
test-api.js
Add:
require(‘dotenv’).config();
const axios = require(‘axios’);
axios.get(“https://api.openai.com/v1/models”, {
 headers: {
  Authorization: Bearer ${process.env.OPENAI_API_KEY}
 }
})
.then(res => console.log(“API Connected”))
.catch(err => console.error(“API FAILED:”, err.message));

Run:
node test-api.js

Expected Result
API Connected
If you see:
401 → bad API key


ECONNREFUSED → firewall issue


timeout → network blocking



2.4 Software Requirements (INSTALL + VERIFY)
We are now locking your stack.

Node.js (REQUIRED)
Required Version
Node.js v18 or higher

Verify
node -v

If not installed
Download from:
https://nodejs.org

npm or yarn
Verify npm
npm -v

Optional: Install Yarn
npm install -g yarn

Install Core Dependencies
Inside your project folder:
npm install axios dotenv fs-extra

Install Browser Automation
Choose ONE (we will standardize on Playwright):
Install Playwright
npm install playwright

Install Browsers
npx playwright install

Why Playwright over Puppeteer
Better multi-browser support


More stable automation


Built-in waiting mechanisms



Verification Script (MANDATORY)
Create file:
test-browser.js
Add:
const { chromium } = require(‘playwright’);
(async () => {
 const browser = await chromium.launch();
 const page = await browser.newPage();
 await page.goto(‘https://example.com’);
 console.log(await page.title());
 await browser.close();
})();

Run:
node test-browser.js

Expected Output
Example Domain

If it fails:
Missing dependencies → reinstall Playwright


OS permission issues → fix before proceeding



Optional: Docker (FOR SCALING LATER)
Install Docker
https://www.docker.com

Verify
docker -v

Why Docker matters later
Isolated environments


Deployment consistency


Scaling pipelines



Optional: Search Engines (Index Layer Prep)
We are not activating them yet, but preparing.
Options
MeiliSearch (recommended lightweight)


Elasticsearch (enterprise scale)


Whoosh (Python-based, optional)



Install MeiliSearch (Optional Now)
Mac:
brew install meilisearch
Linux:
curl -L https://install.meilisearch.com | sh

Run
./meilisearch

Expected Output
Server running on http://127.0.0.1:7700

2.5 Accounts & Credentials (CRITICAL)
You are building a multi-source acquisition system, not just OpenAI.

AI Platforms (REQUIRED FOR LATER)
You should have accounts for:
OpenAI (already set up)


Google Gemini


Anthropic Claude


Optional: Kimi (if accessible)



Why this matters
Later you will:
Cross-compare outputs


Extract higher-quality insights


Build ensemble intelligence



Credential Storage (IMPLEMENT NOW)
Update your .env file:
OPENAI_API_KEY=your_key
GEMINI_API_KEY=your_key
CLAUDE_API_KEY=your_key

Server Access (YOUR USE CASE)
You mentioned SureServer.
You need:
FTP or SSH access


Folder write permissions



Test Local File Write (MANDATORY)
Run this in Node:
const fs = require(‘fs-extra’);
fs.writeFileSync(’./outputs/test.txt’, ‘test’);

Check:
File exists in /outputs

If this fails:
→ permissions issue must be fixed before continuing

2.6 What You Have Now (SYSTEM STATE UPDATE)
At this point, your system is:
Verified Components
Node runtime


Package manager


API connectivity


File system write


Browser automation capability



Operational Capabilities
Can call AI APIs


Can launch real browsers


Can store structured data


Can run automation scripts



2.7 Failure Points You Eliminated
You just removed:
“It works on my machine” problems


Missing browser binaries


API connectivity surprises


Permission issues



2.8 Memory Dump — Chapter 2

SYSTEM STATE v2
Environment:
Node.js >= v18


npm installed


Playwright installed + browsers working


Connectivity:
API access verified


No firewall blocking


Storage:
Local file write confirmed


Credentials:
Stored in .env


Multi-provider ready



NEW CAPABILITIES UNLOCKED
Browser automation (critical for scraping AI platforms)


Multi-AI integration readiness


Local persistence confirmed



NEXT OBJECTIVE (Chapter 3)
We move into:
Data Acquisition Layer — REAL AUTOMATION
You will build:
Automated prompt runner


Multi-prompt batching


Structured asset IDs


Logging system


Error handling system


And most importantly:
You will stop running scripts manually
→ and start building a repeatable acquisition engine

When ready, say:
“Proceed to Chapter 3 — Data Acquisition Layer”

