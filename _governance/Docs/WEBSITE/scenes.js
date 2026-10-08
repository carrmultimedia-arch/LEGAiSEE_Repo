/* ═════════════════════════════════════════════════════════════════════════
   HOW TO EDIT THIS FILE — no coding needed
   ─────────────────────────────────────────────────────────────────────────
   This file holds ALL the words of the course. The page (index.html) reads
   this list and builds every screen from it. To change content you only
   ever edit here — never index.html.

   CHAPTERS
   • A chapter is one { ... } block that starts with  id:  and has its own
     scenes:[ ... ] list. Add a chapter by pasting a new block after the
     last one. Delete a chapter by removing its whole block. Reorder
     chapters by moving blocks up or down. The presenter follows this order.

   SCENES
   • A scene is one { ... } block inside a chapter's scenes:[ ... ] list.
     Add, remove or move scene blocks the same way. Each needs a unique
     id (any word), and a  type:  that picks the layout:

       statement – one or two big lines ("lines: [...]"), lots of space.
       contrast  – two big words with a symbol between (left / symbol / right).
       chain     – items in a row joined by arrows ("vertical:true" stacks
                   them). "emphasizeLast:true" makes the last item glow gold.
                   "assistIndex:n" pulls item #n (0,1,2...) out below the row
                   as a side note instead of inline.
       compare   – two columns; left one dimmed/dashed, right one bright.
       branch    – a source sentence on the left fanning out to items;
                   "collapseTo" folds the branches back into the source and
                   swaps in that phrase after the reveal.
       equation  – blocks joined by + and = with a bold result block.
       ring      – items around a circle around "core"; "loop:true" adds a
                   slowly rotating dashed ring and an arrow back to item 1.
       hub       – a center node with satellites around it (not a funnel).
       stack     – short lines revealed one at a time, top to bottom.
       workbook  – participation: big typing fields, saved automatically.

   OPTIONAL EXTRAS ON ANY SCENE
       heading: "…"   small title at the top      note: "…"    small closing line
       landing: "…"   big closing line, lands last
       notes: "…"     private presenter notes — press N to see them

   PHOTOS: put a file name in a chapter's  photo:"myimage.jpg"  (the image
   file sits in the same folder as index.html). Leave photo:"" for the pale
   gradient placeholder.

   SAVING: workbook answers are stored automatically in this browser, keyed
   by chapter id + scene id + field id. Give every field a unique "id".
   ═════════════════════════════════════════════════════════════════════════ */

window.CAMERA_CHAPTERS = [
{
 id: 1, kicker: "CHAPTER ONE", title: "WHAT CAMERA IS", photo: "",
 scenes: [
  { id: "gap", type: "chain", heading: "The Gap",
    items: ["Person","Phone","Camera","AI","Audience"],
    note: "Nothing stands between anyone and an audience anymore." },
  { id: "access", type: "contrast", left: "ACCESS", symbol: "\u2260", right: "CAPABILITY" },
  { id: "system", type: "chain", heading: "CAMERA is a system.", vertical: true,
    items: ["Business Knowledge","Media Capability","Useful Communication","Repeatable Workflow"] },
  { id: "paths", type: "compare", heading: "Two ways to get content made.",
    left:  { title: "OUTSIDE DEPENDENCY", items: ["Need content","Hire","Wait","Receive","Repeat"] },
    right: { title: "INTERNAL CAPABILITY", items: ["Knowledge","Decide","Create","Publish","Repurpose","Repeat"] },
    note: "Some work earns a professional crew. Ordinary communication usually doesn't." },
  { id: "contractor", type: "branch", heading: "One customer question.",
    source: "Does this problem need to be repaired now, or can it wait?",
    items: ["Video","Short Clip","Article","Sales Resource","Customer Response"],
    note: "The point is not quantity. It's reusable communication." },
  { id: "equipment", type: "chain", heading: "Gear is the last decision.", emphasizeLast: true,
    items: ["Communication Requirement","Audience","Objective","Message","Production Requirement","Equipment"] },
  { id: "human-media-ai", type: "equation", heading: "What makes it capable.",
    parts: [
      { title: "HUMAN EXPERTISE", sub: "Substance" },
      { title: "MEDIA SKILL", sub: "Communication" },
      { title: "AI ASSISTANCE", sub: "Speed / Organization / Scale" } ],
    result: { title: "CAPABLE BUSINESS COMMUNICATION" } },
  { id: "workbook1", type: "workbook",
    prompt: "What question do your customers repeatedly ask?",
    fields: [
      { id: "question", label: "The question, exactly as a customer would ask it" },
      { id: "inside",   label: "Can someone inside the business answer it on camera?" },
      { id: "need",     label: "What would they actually need?" },
      { id: "pro",      label: "Does it require professional production?" } ] },
  { id: "return", type: "contrast", left: "ACCESS", symbol: "\u2260", right: "CAPABILITY" },
  { id: "close1", type: "statement",
    lines: ["The camera is only the beginning.", "The real product is the capability behind it."] }
 ]
},
{
 id: 2, kicker: "CHAPTER TWO", title: "THE CAMERA FRAMEWORK", photo: "",
 scenes: [
  { id: "framework", type: "ring", core: "CAMERA",
    items: ["C \u2014 Character","A \u2014 Audience","M \u2014 Monetization","E \u2014 Engagement","R \u2014 Repurposing","A \u2014 AI Acceleration"] },
  { id: "character", type: "chain", heading: "Character",
    items: ["Experience","Perspective","Expertise","Presence","Communication"],
    landing: "The camera is not the authority. The person is." },
  { id: "audience", type: "stack", heading: "Audience",
    items: ["What problem are they solving?","What are they uncertain about?","What are they afraid of getting wrong?","Why would they trust you?"] },
  { id: "monetization", type: "hub", heading: "Monetization", center: "Communication \u2192 Business Purpose",
    items: ["Awareness","Expertise","Questions","Objections","Sales","Retention","Recruitment"],
    note: "Not a funnel. Content simply has different jobs." },
  { id: "engagement", type: "chain", heading: "Engagement",
    items: ["STOP","LISTEN","CONTINUE","RESPOND"],
    note: "Structured communication, not a collection of tricks." },
  { id: "repurposing", type: "branch", heading: "Repurposing",
    source: "One substantive conversation",
    items: ["Long-form video","Short video","Email","Article","Sales resource","FAQ"],
    collapseTo: "ONE IDEA / MANY USES" },
  { id: "ai", type: "chain", heading: "AI Acceleration", assistIndex: 2,
    items: ["Human Expertise","Communication","AI Assistance","More Capacity"] },
  { id: "loop", type: "ring", loop: true, core: "CAMERA",
    items: ["Character","Audience","Monetization","Engagement","Repurposing","AI Acceleration"],
    note: "It doesn't end. It turns." },
  { id: "workbook2", type: "workbook", ring: true,
    prompt: "Run one content idea through all six.",
    fields: [
      { id: "idea",         label: "Your content idea", centerText: true },
      { id: "character",    label: "Character: who should communicate this?" },
      { id: "audience",     label: "Audience: who specifically needs to hear it?" },
      { id: "monetization", label: "Monetization: what job does it perform for the business?" },
      { id: "engagement",   label: "Engagement: why should they stop and continue?" },
      { id: "repurposing",  label: "Repurposing: what other forms could this knowledge take?" },
      { id: "ai",           label: "AI Acceleration: where could AI reduce unnecessary work?" } ] },
  { id: "close2", type: "statement",
    lines: ["The tools will change.", "The operating logic remains."],
    note: "Next: Character" }
 ]
}
];
