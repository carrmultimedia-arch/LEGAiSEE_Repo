8-17-26_Legaisee Website
Summary
LEGAiSEE public website (legaisee.com) — luxury site build, lighting engine, portfolio page
Details
Public website at legaisee.com
Files: legaisee.css + index/archaeology/method/serve/architect/commissions/registry.html
Fonts: Cinzel / Cormorant Garamond / Inter
Palette locked: pure neutral blacks (#050505, #080808, #0c0c0c), clean 4000K museum-white light (255,248,225), gold at #C9A961; absolute no-violet rule
Fixed-bg parallax images; gem metaphor on every page
Seven-page structure: Home, Business Archaeology, The Practitioner, Methodology, Industries, Private Commissions, The Registry
The Practitioner page framed as "Exhibit Zero: A Live Reconstruction"
Aged copper + amber wood grain palette for "dig site" pages (archaeology, method, comparison); gloss obsidian + gold for "museum display" pages
intaketest.html embed inside registry.html is the single brightest element on the site
Hidden methodology comparison page styled as a discovered field document with archive badge
CSS consolidation replaced legaisee.css and legaisee-luxury.css with a single master external stylesheet using !important throughout (required because page-level <style> blocks load after the external file)
lighting-test.html debug page developed across four major versions to prove a viewport-space (not page-space) lighting engine before porting to the live cascade
Lighting engine uses getBoundingClientRect per rAF frame, calculates distance from named viewport-fixed light sources (key/fill/back), accumulates additive contributions, and writes --el-intensity, --el-specular, --el-angle, --el-key-x, --el-key-y as custom properties on each lit element
Per-page lighting rig configs (museum track, softbox, speakeasy, concert spotlight) loaded as data objects
Gold material system has three levels (shadow/lit/specular): flat and dim in shadow, gaining luminance as elements enter a light zone, specular only at light center
.card--illumine modifier class: museum light from top shining down, gold palette, hover-triggered
.card--illumine HTML structure: insert .illumine-layer div (with .slit, .lumen > .min + .mid + .hi, .darken > .sl + .ll + .slt + .srt) as first child inside card; CSS lives in legaisee-luxury.css
Apply .card--illumine to: commissions.html exhibit cards + Bedrock Pledge clauses; serve.html three archetype cards; archaeology.html Lindy proof cells; registry.html confidentiality cells
Career portfolio page (career.html) built as a two-file system (career.html + career-config.js) with hierarchical folder-tree drill-down by Era → Station → content type, LEGAiSEE-styled lightbox, and YouTube thumbnail auto-generation
Deployment lesson: use the Download button (not Copy) from Claude artifacts to avoid smart-quote and markdown corruption when pasting into cPanel
Currently rebuilding the portfolio for job hunting purposes first, intending it to become the LEGAiSEE career page later; built a system this past weekend that scrapes YouTube playlist data into an organized portfolio page, but it isn't working as advertised yet
legaisee.com email is already set up on cPanel
Previously used HoneyBook with Stripe connected for billing; the flow was essentially an email containing a link to a payment page
Was told the locked black+gold luxury palette and big top-menu layout are cliché/generic; site scored 80/100 on narrative but 30/100 on visual/experience; wants these design rules to evolve rather than stay fixed
Envisions the redesign as a museum-metaphor experience: a Lobby entrance, then distinct non-linear "rooms" (not a straight hall to an exit), navigated via a smooth scroll experience with a Z-axis/depth feel, not just vertical or horizontal scroll — wants the whole site, start to finish, to feel like a single continuous experience
Has pivoted the room-navigation concept toward a Myst-style pre-rendered approach: builds museum rooms in Lightwave, renders room-to-room travel/transition video clips connected by doors, extracts first/last frame stills, and sequences video-transition-lands-on-still with content animating in/out on trigger
Already has a large set of rendered luxury-museum room concept images (gem display halls, artifact rooms, vaults, ateliers, libraries) originally made as backgrounds for gem-transformation explanation content


