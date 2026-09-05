<iframe width="1253" height="661" src="https://www.youtube.com/embed/WZS0EHSXBkk" title="10 Minutes of 4K Organic Dust Particles On Black Background - Overlay" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

Timelines Code

<Style>
.timeline-section {
  position: relative;
  padding: 5rem 0;
  background: radial-gradient(circle at top, rgba(59,43,95,0.2), transparent 60%);
}

.timeline-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2.5rem;
}

.timeline-item {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  position: relative;
}

.timeline-date {
  flex: 0 0 80px;
  font-family: 'Cinzel', serif;
  font-weight: 600;
  font-size: 0.85rem;
  color: var(--gold);
  text-transform: uppercase;
  letter-spacing: 0.15em;
  position: relative;
}

.timeline-date::after {
  content: "";
  position: absolute;
  left: 50%;
  top: 100%;
  width: 2px;
  height: 100%;
  background: var(--gold);
  transform: translateX(-50%);
}

.timeline-card {
  background: rgba(5,5,9,0.85);
  border-radius: 16px;
  padding: 1.5rem;
  border: 1px solid rgba(245,199,106,0.25);
  box-shadow: 0 0 20px rgba(0,0,0,0.9), 0 0 30px rgba(245,199,106,0.1);
  transition: all 0.3s ease;
}

.timeline-card h3 {
  font-family: 'Cinzel', serif;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  color: var(--diamond);
}

.timeline-card p {
  font-size: 0.9rem;
  color: rgba(249,249,255,0.75);
  line-height: 1.5;
}

.timeline-card:hover {
  transform: translateY(-3px);
  border-color: rgba(245,199,106,0.5);
  box-shadow: 0 0 40px rgba(245,199,106,0.2), 0 0 60px rgba(0,0,0,0.95);
}

@media (min-width: 768px) {
  .timeline-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1200px) {
  .timeline-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
</style>


<html>
<section id="timeline-<PAGE-NAME>" class="timeline-section">
  <div class="container">
    <div class="section-header">
      <h2 class="stage-heading">Timeline – <PAGE-NAME></h2>
    </div>
    <div class="timeline-grid">
      <div class="timeline-item">
        <div class="timeline-date">YYYY</div>
        <div class="timeline-card">
          <h3>Event Title</h3>
          <p>Event description goes here. Keep it concise, highlight key points.</p>
        </div>
      </div>

      <div class="timeline-item">
        <div class="timeline-date">YYYY</div>
        <div class="timeline-card">
          <h3>Event Title</h3>
          <p>Event description goes here. Highlight key moments or outcomes.</p>
        </div>
      </div>

      <!-- Add as many timeline-items as needed -->
    </div>
  </div>
</section>

