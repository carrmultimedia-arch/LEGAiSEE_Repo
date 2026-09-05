Neither — just HTML. Add one <a> line to each list using the same pattern already there. No CSS or JS changes needed since you’re reusing the existing nav-links / nav-mobile classes and data-nav attribute convention.
Desktop nav — add before the Enter the Registry link (so the CTA stays last):

<a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
<a href="/career.html"       data-nav="career">Career</a>
<a href="/commissions.html"  data-nav="commissions">Commissions</a>
<a href="/registry.html"     class="nav-cta" data-nav="home">Enter the Registry</a>

Mobile drawer — same position, same pattern:

<a href="/practitioner.html" data-nav="practitioner">The Practitioner</a>
<a href="/career.html"       data-nav="career">Career</a>
<a href="/commissions.html"  data-nav="commissions">Commissions</a>
<a href="/registry.html"     data-nav="registry">Enter the Registry</a>

One thing to decide: label text. “Career” is clean and matches your other one-word links (Method, Commissions). If you’d rather keep the public-facing framing softer — since this page is partly a job-hunt tool — you could use something like “Availability” or “Engagements” instead. Your call; “Career” reads the most direct and honest, which fits the site’s tone.
If career.html ever gets its own active-state highlighting (the style="color: var(--gold);" treatment Home has), that’ll need to be handled wherever your data-nav active-page logic lives — likely a small JS snippet elsewhere that sets the gold color based on data-page on <body>, per your existing site convention. If you’ve got that active-nav script in another file, point me to it and I’ll add the career case to it.​​​​​​​​​​​​​​​​

