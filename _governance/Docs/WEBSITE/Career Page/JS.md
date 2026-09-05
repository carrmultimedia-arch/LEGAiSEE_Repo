/**

- ============================================================
- LEGAiSEE CAREER PAGE — PORTFOLIO CONFIGURATION
- ============================================================
- This is the ONLY file you need to edit to update the page.
- 
- HOW TO ADD A VIDEO:
- type: ‘video’
- url:  paste the full YouTube URL (share link works fine)
- ```
      e.g. 'https://www.youtube.com/watch?v=abc123'
  ```
- ```
      or   'https://youtu.be/abc123'
  ```
- 
- HOW TO ADD A PHOTO:
- type: ‘photo’
- url:  paste any direct image URL
- ```
      Works with: Google Photos shared links, Dropbox
  ```
- ```
      direct links, Imgur, your own server, etc.
  ```
- 
- CATEGORIES (used for filter tabs — add your own as needed):
- ‘Broadcast’  ‘Documentary’  ‘Institutional’
- ‘Aerial’     ‘Corporate’    ‘Event’  ‘Other’
- 
- LEAVE SLOT EMPTY? Just set enabled: false — it won’t show.
- ORDER on page = order in this list (rearrange freely).
- ============================================================
  */

const CAREER_CONFIG = {

/* ── PAGE META ──────────────────────────────────────────── */
meta: {
name:       ‘John Carr’,
title:      ‘Broadcast Director · Multimedia Producer · Aerial Cinematographer’,
tagline:    ‘Thirty years of broadcast-grade production. One standard of excellence.’,
email:      ‘john@carrmultimedia.com’,
phone:      ‘’,         // optional — leave blank to hide
location:   ‘New Braunfels, TX’,
linkedin:   ‘’,         // full URL or leave blank
resume_url: ‘’,         // link to PDF resume or leave blank
},

/* ── CREDENTIALS (pills shown in hero) ──────────────────── */
credentials: [
‘KPLC NBC · Broadcast Director’, Technical Director’
‘KVHP FOX 29 · Head Director’,
‘Addy Award Recipient’,
‘FAA Part 107 Certified’,
‘Houston Methodist Hospital’,
‘33-Year Production Career’,
],

/* ── CAREER STATS ───────────────────────────────────────── */
stats: [
{ value: ‘33+’, label: ‘Years in Production’ },
{ value: ‘14’,  label: ‘Years Broadcast Television’ },
{ value: ‘10+’, label: ‘Years Drone / Aerial’ },
{ value: ‘∞’,   label: ‘Hours of Live Direction’ },
],

/* ── PORTFOLIO SLOTS 1–24 ────────────────────────────────

- Copy a slot block, paste it below, fill in your details.
- Slots with no url set are automatically hidden.
- ──────────────────────────────────────────────────────── */
  portfolio: [

```
/* SLOT 1 */
{
  slot:        1,
  enabled:     true,
  type:        'video',           // 'video' or 'photo'
  url:         '''https://youtu.be/qcjBBnZu3ho',                // paste YouTube URL here
  title:       'Carr Multimedia | Video Business Card',
  category:    'Broadcast',       // see category list above
  era:         'Era Two',         // 'Era One' | 'Era Two' | 'Era Three'
  description: '',               // optional caption shown in lightbox
},

/* SLOT 2 */
{
  slot:        2,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 2 — Paste your title here',
  category:    'Broadcast',
  era:         'Era One',
  description: '',
},

/* SLOT 3 */
{
  slot:        3,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 3 — Paste your title here',
  category:    'Documentary',
  era:         'Era One',
  description: '',
},

/* SLOT 4 */
{
  slot:        4,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 4 — Paste your title here',
  category:    'Institutional',
  era:         'Era Two',
  description: '',
},

/* SLOT 5 */
{
  slot:        5,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 5 — Paste your title here',
  category:    'Institutional',
  era:         'Era Two',
  description: '',
},

/* SLOT 6 */
{
  slot:        6,
  enabled:     true,
  type:        'photo',
  url:         '',                // paste direct image URL here
  title:       'Slot 6 — Paste your title here',
  category:    'Aerial',
  era:         'Era Two',
  description: '',
},

/* SLOT 7 */
{
  slot:        7,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 7 — Paste your title here',
  category:    'Aerial',
  era:         'Era Two',
  description: '',
},

/* SLOT 8 */
{
  slot:        8,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 8 — Paste your title here',
  category:    'Corporate',
  era:         'Era Two',
  description: '',
},

/* SLOT 9 */
{
  slot:        9,
  enabled:     true,
  type:        'photo',
  url:         '',
  title:       'Slot 9 — Paste your title here',
  category:    'Corporate',
  era:         'Era Two',
  description: '',
},

/* SLOT 10 */
{
  slot:        10,
  enabled:     true,
  type:        'video',
  url:         '',
  title:       'Slot 10 — Paste your title here',
  category:    'Other',
  era:         'Era Three',
  description: '',
},

/* SLOT 11 */
{
  slot:        11,
  enabled:     false,            // set to true when ready
  type:        'video',
  url:         '',
  title:       '',
  category:    'Other',
  era:         'Era Three',
  description: '',
},

/* SLOT 12 */
{
  slot:        12,
  enabled:     false,
  type:        'photo',
  url:         '',
  title:       '',
  category:    'Other',
  era:         'Era Three',
  description: '',
},

/* ── ADD MORE SLOTS BY COPYING THE BLOCK ABOVE ── */
```

],

};

