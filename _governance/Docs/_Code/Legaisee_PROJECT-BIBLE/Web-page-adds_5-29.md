656 lines · 4,085 words. Everything is in there.

The Bible covers all 11 sections — paste it into any new session with the instruction “Read this before we start” and we pick up exactly here with zero reconstruction time.

What a new session can do immediately with this document:

	•	Know every class name, colour token, font, and card type without asking
	•	See exactly which patches are built but not yet applied to which pages
	•	Have the complete Carr Multimedia excavation with all three eras, key proof points, and unresolved threads
	•	Have the full practitioner page brief ready to write — three anchors, tone guidance, pull quotes
	•	Know the Priority 1 queue: upload CSS files, apply nav template, test live

The one thing to do before closing this session:Save the Bible somewhere permanent — Google Drive, Notion, a local folder. The download link above gives you the file. The excavation and the build state are too valuable to leave only in a chat history.

Good work today. The record is documented.


# LEGAiSEE PROJECT BIBLE

**Last Updated:** May 29, 2026  
**Session Count:** Multiple extended sessions  
**Status:** Active build — site live, patches pending upload  
**Primary Domain:** legaisee.com  
**Server:** SureServer s413.sureserver.com · Username: carrmulti  
**Practitioner:** John Carr · New Braunfels, TX 78130 · (713) 899-1776 · [john@carrmultimedia.com](mailto:john@carrmultimedia.com)

-----

## TABLE OF CONTENTS

1. [Business Identity](#1-business-identity)
1. [Design System](#2-design-system)
1. [Site Architecture](#3-site-architecture)
1. [CSS File Inventory](#4-css-file-inventory)
1. [Patch Build Log](#5-patch-build-log)
1. [Nav & Global Fixes](#6-nav--global-fixes)
1. [Institutional Record — Carr Multimedia Excavation](#7-institutional-record--carr-multimedia-excavation)
1. [Practitioner Page Brief](#8-practitioner-page-brief)
1. [Outstanding Build Queue](#9-outstanding-build-queue)
1. [LEGAiSEE AI System Integration](#10-legaisee-ai-system-integration)
1. [Strategic Notes](#11-strategic-notes)

-----

## 1. BUSINESS IDENTITY

### What LEGAiSEE Is

Forensic business archaeology and authority positioning practice. Not marketing. Not strategy consulting. Not content creation. The excavation of what a business has already proved — organised into a signal that commands attention.

**The methodology in one sentence:**  
We don’t find your history. We turn it into Unavoidable Logic.

**The practitioner in one sentence:**  
The forensic discipline of an archivist with the DNA of a master broadcaster.

### Market Position

- Primary: $30M+ enterprises, San Antonio / Austin I-35 corridor
- Principals only — founders, owners, executive leadership
- No intermediaries, no committee-approval organisations
- Entry point: $2,500 Phase 0 Shallow Dig (non-refundable)

### The Exhibit System (Full Pricing)

|Exhibit  |Name                             |Price          |Type                       |
|---------|---------------------------------|---------------|---------------------------|
|Phase 0  |The Shallow Dig                  |$2,500         |One-time, non-refundable   |
|Exhibit A|Signal Excavation                |$5,000–$7,500  |Project, 3–5 weeks         |
|Exhibit B|Full Institutional Record        |$8,500–$18,000 |Project, 6–10 weeks        |
|Exhibit C|Institutional Signal Retainer    |$4,500/mo      |Retainer, month-to-month   |
|Exhibit D|Provenance and Property Narrative|$6,500–$7,500  |Project, 4–6 weeks         |
|Exhibit E|Enterprise Signal Retainer       |$18,000/mo     |Retainer, min 6 months     |
|Exhibit F|Full Enterprise Excavation       |$25,000–$50,000|Project, 12–20 weeks       |
|Exhibit G|The Permanent Record             |$35,000/qtr    |Retainer, annual commitment|

### Core Value Metrics

- **Enterprise Value** — documented history drives acquisition multiples
- **Exit Multiples** — provable origin story commands premium at sale
- **Forensic CAC** — true cost of acquisition, surfaced not estimated
- **LTV:CAC 3:1** — minimum ratio engineered before new acquisition spend

### Five Industry Phrasings (verbatim, used throughout site)

1. Technical Depth
1. Institutional Reputation Recovery
1. Mission Clarity
1. Revenue Leak Detection System
1. Provenance and Property Narrative

-----

## 2. DESIGN SYSTEM

### Colour Palette

```
--obsidian:    #050505   (page background)
--surface:     #181818   (darkest section bg)
--card:        #141414   (card background)
--gold:        #C9A961   (primary accent, all gold)
--gold-dim:    rgba(201, 169, 97, 0.32)
--gold-low:    rgba(201, 169, 97, 0.12)
--gold-glow:   rgba(201, 169, 97, 0.08)
--text-primary: rgba(255, 255, 255, 0.92)
--text-body:    rgba(255, 255, 255, 0.72)
--text-muted:   rgba(255, 255, 255, 0.45)
```

**NO VIOLET. Ever.**

### Typography

```
--font-display: 'Cinzel Decorative', serif   (headings, h1-h6, display)
--font-body:    'Inter', sans-serif           (body, UI, labels, everything else)
```

**Google Fonts link (correct, confirmed):**

```html
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
```

**NOTE:** Previous sessions used Cinzel + Cormorant Garamond. Those have been superseded. Cinzel Decorative + Inter is the confirmed final font system. All patch CSS references Cormorant Garamond — these are overridden by legaisee-global-fixes.css font declarations.

### Font Size Scale

```
html base:     17px (desktop) / 16px (tablet) / 15.5px (mobile)
h1:            clamp(1.8rem, 5vw, 3.4rem)
h2:            clamp(1.4rem, 3.5vw, 2.4rem)
h3:            clamp(1rem, 2vw, 1.3rem)
.section-title: clamp(1.5rem, 4vw, 2.6rem)
.section-lead:  clamp(1.05rem, 2vw, 1.25rem) · weight 300
p:             1.05rem · line-height 1.8
body:          1rem · line-height 1.75
UI labels:     0.65–0.7rem · weight 500 · letter-spacing 0.2em
```

### Nav Height

```
--nav-height:    72px (desktop)
--nav-height-sm: 60px (mobile ≤768px)
```

### Card System

Three card types — all separate text from background images:

```
.card-text   — background: #141414, border: rgba(201,169,97,0.13), padding
.card-photo  — background: #141414, no padding, img fills to edges
.card-glass  — background: rgba(14,14,14,0.68), backdrop-filter: blur(18px)
```

Modifiers:

```
.card-text--accented  — 2px gold top border
.card-glass--accented — 2px gold top border
```

Grid layouts:

```
.card-row               — base grid
.card-row--2col         — 1fr 1fr
.card-row--3col         — 1fr 1fr 1fr
.card-row--text-photo   — 1fr 1fr
.card-row--wide-text    — 3fr 2fr
```

All collapse to 1fr on ≤900px.

### Track Lighting System

Museum-style radial gold gradient overlays. Usage:

```html
<section class="section-lit">
  <div class="lighting-overlay"></div>
  <div class="container">
    <!-- content here, z-index: 1 -->
  </div>
</section>
```

Five light positions baked into `.lighting-overlay`:

- A: top centre (main overhead, 0.11 opacity)
- B: bottom left (floor accent, 0.07)
- C: centre right (side track, 0.06)
- D: top left secondary (0.05)
- E: bottom centre fill (0.04)

### Background Image System

```css
/* Desktop — parallax */
.section-bg--parallax { background-attachment: fixed; }

/* All backgrounds */
.section-bg {
  background-size: cover;
  background-position: center center;
  width: 100%;
}

/* Mobile — parallax disabled (iOS Safari bug) */
@media (max-width: 1024px) {
  background-attachment: scroll !important;
  background-size: cover !important;
}
```

Images live at: `legaisee.com/Images/`

### Section Label Pattern (line — TEXT — line)

```html
<div class="section-label">
  <span class="label-line"></span>
  <span class="label-text">Your Label Here</span>
  <span class="label-line"></span>
</div>
```

### Button System

```
.btn             — base (Inter, 0.7rem, 500, 0.2em tracking, uppercase)
.btn-primary     — gold bg, obsidian text
.btn-secondary   — transparent, gold border, gold text
```

-----

## 3. SITE ARCHITECTURE

### 7-Page Structure

|File            |Page              |Session Built|Status                    |
|----------------|------------------|-------------|--------------------------|
|index.html      |Home              |Session 1    |Live                      |
|archaeology.html|The Archaeology   |Session 2    |Live + Patch 4 pending    |
|method.html     |The Method        |Session 2    |Live                      |
|serve.html      |Who We Serve      |Session 3    |Live + Patch 5 pending    |
|architect.html  |The Architect     |Session 3    |Live + Patch 3 pending    |
|commissions.html|Commissions       |Session 4    |Live + Patches 1+2 pending|
|registry.html   |Enter the Registry|Session 4    |Live + Patch 6 pending    |

**Plus: architect.html (practitioner page) — NOT YET WRITTEN**  
This is the 8th page, the practitioner’s own institutional record. Brief fully developed. Awaiting build session.

### File Structure on Server

```
legaisee.com/
├── index.html
├── archaeology.html
├── method.html
├── serve.html
├── architect.html
├── commissions.html
├── registry.html
├── legaisee.css                  (original site stylesheet)
├── legaisee-patches.css          (NEW — all patch classes, 1,239 lines)
├── legaisee-global-fixes.css     (NEW — fonts, contrast, cards, parallax)
├── Images/
│   └── [all background/gem images]
└── claudetemp/
    └── commissions.html          (test page used for CSS debugging)
```

### CSS Load Order (every page `<head>`)

```html
<link rel="stylesheet" href="/legaisee.css">
<link rel="stylesheet" href="/legaisee-patches.css">
<link rel="stylesheet" href="/legaisee-global-fixes.css">
```

Order matters. Global fixes overrides patches which overrides base.

### Nav `data-page` Values (for active state JS)

```
index | archaeology | method | serve | architect | commissions | registry
```

Set on `<body data-page="___">` — drives automatic active nav highlight.

-----

## 4. CSS FILE INVENTORY

### legaisee.css (original)

Original site stylesheet. Do not modify except to append.  
Known gap: was missing `.container`, `.section-label`, `.label-line`, `.label-text`, `.section-title`, `.section-lead`, `.btn`, `.btn-primary` — these are now defined in legaisee-global-fixes.css.

### legaisee-patches.css (1,239 lines)

All new classes for Patches 1–6. Sections:

- Patch 1: Exhibit system (`.exhibits-intro` → `.value-item__body`)
- Patch 2: Case studies + FAQ (`.case-studies-section` → `.private-record-cta__text`)
- Patch 3: Architect phrases (`.architect-phrase-block` → `.pull-quote__rule`)
- Patch 4: Archaeology philosophy (`.archaeology-philosophy` → `.philosophy-pull__text`)
- Patch 5: Serve phrasings (`.serve-capabilities` → `.serve-definition-body`)
- Patch 6: Registry Shallow Dig (`.registry-entry-hook` → `.registry-form-preamble__text`)
- Patch Foundation: `.container`, `.section-block`, `.section-label`, `.label-line`, `.label-text`, `.section-title`, `.section-lead`, `.btn`, `.btn-primary`, `.btn-secondary`

### legaisee-global-fixes.css

Global overrides for entire site. Sections:

1. Font system (Cinzel Decorative + Inter declarations and overrides)
1. Body text sizing (larger, Inter-optimised)
1. Contrast fixes (light text on dark throughout)
1. Card system (.card-text, .card-photo, .card-glass + grids)
1. Track lighting (.section-lit, .lighting-overlay — 5 radial positions)
1. Background images (cover, parallax desktop / scroll mobile)
1. Section scaffolding (spacing, container, dark backgrounds)
1. Gem stage cards (.gem-stage-grid, .gem-stage-card)
1. Stats strip (.stats-strip, .stat-cell, .stat-figure)
1. Scrollbar + selection colour

### LEGAISEE-HEAD-NAV.html

Universal `<head>` + `<header>` block. Paste-and-replace on every page.  
Customise per page: `<title>`, `<meta description>`, `<body data-page="___">`  
Contains: embedded nav CSS (self-contained `<style>` block) + hamburger JS.

**Key fixes in nav template:**

- Logo = `<a href="/index.html">` — clickable, no “Home” text
- Logo image: `width="160"` fixed, `flex-shrink: 0` — never squeezes
- Desktop nav: hidden ≤1024px
- Hamburger: visible ≤1024px, animates to X on open
- Mobile menu: `position: absolute; top: 100%` — drops DOWN, never off top
- All 7 page links in mobile menu (index through registry)
- Closes on: link click, outside click, Escape key, resize to desktop
- Active state: driven by `data-nav` attribute matched to `body data-page`

-----

## 5. PATCH BUILD LOG

### PATCH 1 — commissions.html

**Replace:** Existing four commission cards  
**Insert:** Full Exhibit system (Phase 0 → Exhibit G) + four-metric value bar + Value Metrics callout  
**File:** `PATCH1-commissions-exhibits.html` (351 lines)  
**Status:** Built, not yet applied to live page

### PATCH 2 — commissions.html

**Insert after Patch 1:** Case Studies (Cases I–IV) + Private Record FAQ (6 questions)  
**File:** `PATCH2-commissions-cases-faq.html` (271 lines)  
**Status:** Built, not yet applied to live page

### PATCH 3 — architect.html

**Insert:** Three missing phrases as drop-in blocks

- Block A: “forensic discipline of an archivist with the DNA of a master broadcaster”
- Block B: “We don’t find your history; we turn it into Unavoidable Logic” (pull-quote)
- Block C: “mastering the Signal that commands attention”  
  **File:** `PATCH3-architect-phrases.html` (111 lines)  
  **Status:** Built, not yet applied to live page

### PATCH 4 — archaeology.html

**Insert:** Philosophy section — four numbered blocks

- “Traditional strategy is built on interpretation”
- “what your business has already proved”
- “stabilise your institutional foundation before you invest another dollar”
- “We do not cherry-pick the cleanest story”  
  **File:** `PATCH4-archaeology-philosophy.html` (153 lines)  
  **Status:** Built, not yet applied to live page

### PATCH 5 — serve.html

**Insert:** Five service definition items

- Technical Depth · Institutional Reputation Recovery · Mission Clarity
- Revenue Leak Detection System · Provenance and Property Narrative  
  **File:** `PATCH5-serve-phrasings.html` (175 lines)  
  **Status:** Built, not yet applied to live page

### PATCH 6 — registry.html

**Insert:** Shallow Dig entry hook

- Four surface items: Estimated Golden Era · One Abandoned Asset · The Competitive Gap · One Undeniable Inflection Point
- “This is not a lead magnet” reinforcement block
- Terms bar ($2,500 · one-time · written brief · principals only)
- Form preamble line  
  **File:** `PATCH6-registry-shallow-dig.html` (296 lines)  
  **Status:** Built, not yet applied to live page

-----

## 6. NAV & GLOBAL FIXES

### Issues Identified (live site audit)

1. ✅ Nav “Home” text — remove, make logo clickable to index
1. ✅ Hamburger menu runs off top of screen — fixed with `position: absolute; top: 100%`
1. ✅ Mobile menu missing page links — all 7 links now in template
1. ✅ Background images too large on mobile — fixed with `background-attachment: scroll; background-size: cover` on ≤1024px
1. ✅ Body/paragraph text too small — base bumped to 17px, Inter-optimised scale
1. ✅ Contrast failures (dark on dark) — global light-text overrides applied
1. ✅ Logo squeezes on narrow windows — `width: 160px; flex-shrink: 0; min-width: 120px`
1. ✅ Fonts updated — Cinzel Decorative + Inter replacing Cinzel + Cormorant Garamond
1. ✅ Card system — `.card-text`, `.card-photo`, `.card-glass` with frosted glass option
1. ✅ Track lighting — 5-position radial gold gradient overlay system
1. ✅ Content to screen edge — `.container` now defined with max-width + padding

### Files to Upload to Server

```
legaisee-patches.css       → legaisee.com/legaisee-patches.css
legaisee-global-fixes.css  → legaisee.com/legaisee-global-fixes.css
```

Then add to every page `<head>` (after legaisee.css):

```html
<link rel="stylesheet" href="/legaisee-patches.css">
<link rel="stylesheet" href="/legaisee-global-fixes.css">
```

### Nav Template Application

Replace `<head>` through `</header>` on all 7 pages with `LEGAISEE-HEAD-NAV.html`.  
Only change per page: `<title>`, `<meta description>`, `<body data-page="___">`  
Nav script paste once just before `</body>`.

-----

## 7. INSTITUTIONAL RECORD — CARR MULTIMEDIA EXCAVATION

### Primary Sources Used

- Live Wayback Machine captures: 52 total (July 28, 2004 – May 28, 2026)
- 19 archive screenshots reviewed in session
- Full resume document (modern polished version)
- AI-generated business archaeology report (first pass)
- Vimeo profile metadata
- YouTube channel keyword data
- LinkedIn positioning statement

### The Three Eras

#### Era One: The Broadcast Years (1992–2006) — Lake Charles, Louisiana

**The Signal Era. The Golden Era.**

- **KPLC-TV NBC Affiliate** — Sep 1992 – Aug 1998  
  Director / TD / Master Control Operator  
  Live broadcasts, operations staff, FCC compliance
- **KVHP-TV FOX 29** — Nov 1998 – Jul 2006  
  Head Director / Technical Director / Producer  
  Live newscasts, promos, specialty shows, operations crew supervision
- **Carr Multimedia founded November 2000** — while still at KVHP  
  Original name: **Carr Multimedia Digital Creations**  
  The practice was built before leaving broadcast — deliberate, not reactive
- **Addy Award** — “Television: Local Self Promotion Campaign”  
  Sunny That Morning Show campaign  
  American Advertising Federation — adjudicated excellence, documented proof
- Education anchors:  
  Sowela Technical Institute — Electronics / Instrumentation  
  McNeese State University — Music  
  Sulphur High School — Diploma 1988  
  **Guitar and piano since mid-1980s. Multiple bands, live performance, recording, producing.**

#### Era Two: The Houston Build (2006–2020)

**The Expansion Era.**

- **Reel Connection Media Inc.** (Spring, TX) — Jun 2006 – Oct 2011  
  Editor / Animator / Videographer / IT Technician  
  Corporate videos, animations, graphics, IT/network management
- **Capital Technologies Inc.** (Houston, TX) — Oct 2011 – Sep 2016  
  Video Producer / Audio Engineer / Technical Coordinator  
  Texas Flying Legends Museum media, Music Doing Good nonprofit  
  Pro audio/video for concerts, live events, studio productions
- **DFS Marketing Inc.** (Conroe, TX) — Dec 2018 – Feb 2020  
  Production Manager / Content Creator  
  Social media, SEO, website, analytics  
  Live sales events, PowerPoint, audio assets  
  In-office IT technician
- **Drone operations since 2014** — 2 years before FAA Part 107 (Aug 2016)  
  FAA Part 107 certified immediately on availability (2017)  
  Owned 5 DJI drones. Operates fleet currently.
- **Clients documented:**  
  Houston Methodist Hospital — live streams, cinematic brand video  
  MyCare Medical — multi-location broadcast (Tampa, Houston, Rio Grande Valley simultaneously)  
  Texas Flying Legends Museum  
  Music Doing Good nonprofit  
  Jazz concerts
- **Cypress, TX address:** 8622 Cape Royal Dr., Cypress, TX 77433
- **Interactive Video vertical built (c. 2018–2021):**  
  Full demonstration library across 7 industries:  
  Pool Cleaning, Skin Care, Lawyer, Home Insurance, Coffee Shop, Chiropractor, Personal Training  
  Technology: branching video paths, embedded lead capture, embedded CTAs  
  **STATUS: Abandoned. Capability and library likely still exist. Major recoverable asset.**
- **Musician/Soundman identity active through 2016+:**  
  Professional live sound rig: Presonus StudioLive 24 + 2x Bose L1 Model II + Bass II subs  
  Guitar featured in 2013 and 2016 site headers — co-equal brand identity  
  “Music” primary nav item 2013–2016+

#### Era Three: The Methodology Emergence (2020–present)

**The Archaeology Era.**

- **WLFT-TV** (Baker, LA) — Jan 2022 – Aug 2022  
  Production Manager / Director / Technical Director  
  Live shows, virtual sets, motion graphics, streaming  
  (Return to broadcast — likely pandemic-era bridge)
- **Discovery Call system** — documented pre-2021  
  Pre-qualification intake form + structured call  
  Direct ancestor of Phase 0 / Shallow Dig  
  Language: “gets the mundane stuff out of the way”
- **“Rockstar Marketing Machine” phase** — visible in 2024 Wayback capture  
  “Rockstardom takes flight! \m/” in official services copy  
  Music identity bleeding into business voice as recently as 2024  
  The shift to LEGAiSEE represents the final identity resolution
- **LEGAiSEE launched** — positioning as business archaeology / forensic authority  
  Domain migration: carrmultimedia.com → legaisee.com  
  WordPress → plain HTML migration (SureServer)  
  SSL issue resolved (Let’s Encrypt wildcard for legaisee.com)

### Key Proof Points for Practitioner Page

1. **52 Wayback captures, 22 years continuous web presence** — documented institutional record
1. **Addy Award** — only formally adjudicated excellence in the record. Use it.
1. **1992 start date** — 33 years, not “30+”
1. **Drone 2014** — 2 years before regulation. Early adoption documented.
1. **Houston Methodist Hospital** — institutional client tier, not small business
1. **MyCare Medical multi-city broadcast** — enterprise-scale live production
1. **Discovery Call pre-qualification** — Phase 0 methodology predates LEGAiSEE
1. **Boy Scout oath in official values document** — ethical framework documented and dated
1. **“Digital Creations” → “Rockstar Marketing” → “Business Archaeology”** — 3 identities, all documented, all coherent in progression
1. **Vimeo bio claims “national” scope** — partially evidenced, Steve Vai/Tony Iommi thread unresolved

### Abandoned Assets (recoverable)

|Asset                                                        |Status                               |Value                                   |
|-------------------------------------------------------------|-------------------------------------|----------------------------------------|
|Interactive Video library (7 industry verticals)             |Discontinued, likely intact          |High — demonstrate methodology in action|
|Musician/Soundman practice                                   |Suppressed in LEGAiSEE positioning   |Medium — origin story, cultural proof   |
|Music industry production (Steve Vai / Tony Iommi connection)|Unconfirmed, YouTube keyword evidence|High if confirmed — national scope proof|
|Wedding vertical                                             |Separate subdomain, separate brand   |Low for LEGAiSEE, separate decision     |
|Photography division                                         |Separate subdomain                   |Low for LEGAiSEE, separate decision     |
|“Digital Creations” brand era                                |Archived only                        |Historical record value                 |

### Unresolved Threads (need John’s direct answer)

1. **Steve Vai / Tony Iommi connection** — what was the production work? Is it in YouTube playlists?
1. **Vimeo “national” claim** — what specific national work does this reference?
1. **Louisiana origin** — Georgia Street DBA: what was the founding entity name?
1. **YouTube playlist structure** — playlist names and date ranges by job held?

-----

## 8. PRACTITIONER PAGE BRIEF

**Page:** architect.html (currently serves as “The Architect” — methodology page)  
**NOTE:** The practitioner’s own institutional record page may need to be a separate page (e.g., `record.html`) or replace/expand the current architect.html. Decide at build time.

### Three-Anchor Structure

#### Anchor 1: The Signal Era (1992–2006)

*Louisiana. Network television. The foundation.*

The practitioner’s record begins not at a freelance gig or a production house. It begins at a network television affiliate, in 1992, directing live broadcasts under FCC regulation with no second takes. Fourteen years across KPLC NBC and KVHP FOX 29. The craft was learned inside a regulated, high-stakes, real-time environment where what goes out over the air is permanent.

This is where the methodology was born. Not theorised — built, under broadcast conditions.

The Addy Award is the documented proof of excellence from this era.  
Carr Multimedia was founded in November 2000, before leaving broadcast. The decision was deliberate.

#### Anchor 2: The Build (2006–2020)

*Texas. Institutional clients. The depth record.*

Fourteen years of documented client work at institutional scale. Houston Methodist Hospital. Texas Flying Legends Museum. MyCare Medical across three cities simultaneously. Early drone operations. Interactive Video built before most production companies had considered it. Discovery Call pre-qualification system operational before the methodology had a name.

The technical substrate: Sowela Technical Institute electronics and instrumentation training. FCC compliance expertise. IT network management across multiple organisations. The practitioner’s capability is not creative — it is technically grounded and systematically applied.

#### Anchor 3: The Archaeology (2020–present)

*The methodology emerges from the record.*

The COVID pivot is not a crisis response. It is the logical conclusion of 28 years of watching businesses use media incorrectly — spending against fictions, building on assumptions, burying their own proof under opinion.

LEGAiSEE is what happens when someone who spent 14 years controlling what goes out over the air, and another 14 years watching what that signal can build or fail to build for institutions of every size, decides to stop producing content and start excavating the proof that should have been driving it.

The methodology applies broadcast discipline — what commands attention, what is unavoidable, what the audience cannot ignore — to the problem of institutional identity.

### Tone Guidance for Page Copy

- First person is acceptable on this page only. Elsewhere the site is third person.
- No false modesty. The record is what it is.
- No marketing language. Every claim cites its source in the record.
- The page should read as LEGAiSEE’s own Exhibit B applied to itself.
- End with the invitation: the practitioner’s record is open. The question is whether yours is.

### Pull Quotes Available

- *“The forensic discipline of an archivist with the DNA of a master broadcaster.”*
- *“We don’t find your history. We turn it into Unavoidable Logic.”*
- *“Mastering the Signal that commands attention.”*
- *“I started my career in 1992 at a NBC affiliate TV station in Lake Charles, Louisiana.”* (direct from archive)
- *“If it has to do with creativity, I can produce it.”* (from 2013 archive — use ironically, as the statement the methodology superseded)

-----

## 9. OUTSTANDING BUILD QUEUE

### Priority 1 — Immediate (next session)

- [ ] Upload `legaisee-patches.css` to server root
- [ ] Upload `legaisee-global-fixes.css` to server root
- [ ] Apply nav template to all 7 pages (replace head/header)
- [ ] Add CSS link tags to all 7 pages
- [ ] Apply Patches 1–6 to respective pages
- [ ] Test live on mobile (hamburger, background images, text size)

### Priority 2 — Next build session

- [ ] Write and build `architect.html` practitioner page (full institutional record)
- [ ] Resolve unresolved excavation threads (Steve Vai, Vimeo national claim, Louisiana DBA)
- [ ] Add one verified metric to each Case Study (I–IV) to replace hypothetical numbers

### Priority 3 — AI System Integration

- [ ] Design AI-powered registry interview (forensic intake, not a form)
- [ ] Define LEGAiSEE system architecture for the AI layer
- [ ] Seed the intake AI with the Carr Multimedia excavation as training reference
- [ ] Build the intake interface as a React artifact or dedicated page

### Priority 4 — Ongoing

- [ ] Periodic dispatch / published signal (4x/year minimum)
- [ ] Deep excavation: Wayback Machine full timeline, Louisiana DBA records, YouTube/Vimeo archive dating
- [ ] Consider practitioner’s own full Exhibit B as the first documented commission

-----

## 10. LEGAISEE AI SYSTEM INTEGRATION

### Concept

Replace the registry form with an AI-powered forensic intake interview. The principal does not fill out a static form. They enter a conversational interface that conducts a structured forensic interview — surfacing preliminary signals before Phase 0 begins.

### What It Does

1. Conducts structured forensic interview (business history, inflection points, competitive environment)
1. Identifies preliminary signals in real time (potential Golden Era, Abandoned Assets, Competitive Gap)
1. Produces structured pre-brief document — delivered to the practitioner, not the principal
1. Principal receives confirmation of receipt and assessment pending
1. Practitioner receives a structured intake document before Phase 0 starts

### Why It Is Not a Lead Magnet

The output goes to the practitioner. The principal gets nothing to keep. It produces a more qualified Phase 0 brief and a faster, deeper Shallow Dig. It self-selects: principals who won’t engage with a forensic interview won’t survive Phase 0.

### Technical Architecture (concept)

- Frontend: React component or dedicated `intake.html` page
- AI layer: Claude API (claude-sonnet-4-20250514) via Anthropic /v1/messages
- Seed context: Carr Multimedia excavation as reference for what a forensic record contains
- Output: Structured JSON brief → formatted PDF or email to practitioner
- No output stored or delivered to principal

### Secondary Integration

- Exhibit C/E/G retainer clients: AI runs continuous signal scanning
- Practitioner interprets forensic layer on top
- Competitive monitoring automated; strategic judgment remains human

### Seed Context for AI

The Carr Multimedia excavation (Section 7 of this Bible) is the reference case. When the AI asks about inflection points, Golden Era, Abandoned Assets — it is drawing from a pattern it has already seen in the practitioner’s own record. That is the most credible possible training context.

-----

## 11. STRATEGIC NOTES

### What the Site Is Missing (structural gaps, not content)

1. **Practitioner page** — the single biggest trust gap. Largest conversion barrier for cold principals. Closes when architect.html or record.html is built.
1. **Verified case study metrics** — Cases I–IV are strong but read as hypothetical. One real number per case changes how all four are read.
1. **Periodic published signal** — not content marketing. Forensic observations. 4x/year minimum. Demonstrates the practitioner is active.

### The Competitive Gap

Nobody in the business archaeology / forensic positioning space has:

- 33 years of documented operational record
- 22 years of timestamped web presence (Wayback)
- Network broadcast credentials
- A formally adjudicated advertising award
- Early drone certification (pre-regulation)
- Institutional clients at hospital system scale

That combination is structurally unassailable if it is documented and published. It is currently under-documented on the live site.

### The Identity Resolution

Three business identities, all documented, all coherent in progression:

1. **Carr Multimedia Digital Creations** (2000–c.2015) — broadcast practitioner applies craft to independent production. Guitar in the header. “Digital Creations” in the logo.
1. **Carr Multimedia Rockstar Marketing Machine** (c.2015–2024) — the strategic pivot. Video as a business tool. Discovery calls. Content strategy. The musical identity still present (“Rockstardom takes flight \m/”).
1. **LEGAiSEE** (2025–present) — the identity resolution. The music identity suppressed. The broadcast discipline formalized as methodology. The excavation turned on the excavator’s own record first.

Each identity is documented. Each transition is evidenced. That is a stronger institutional record than most 33-year-old businesses possess.

### The Founding Principle (from the archive)

*“A Scout is Trustworthy, Loyal, Helpful, Friendly, Courteous, Kind, Obedient, Cheerful, Thrifty, Brave, Clean and Reverent. Once a Scout, Always a Scout.”*

Published in the official institutional values document. Predates LEGAiSEE by at least a decade. The forensic integrity the methodology demands — no cherry-picking, full record, honesty over convenience — has a documented ethical origin. Use it on the practitioner page.

-----

*End of LEGAiSEE Project Bible — Session Record May 29, 2026*  
*Next session: begin with Priority 1 queue. Upload CSS files first. Test live before writing.*
