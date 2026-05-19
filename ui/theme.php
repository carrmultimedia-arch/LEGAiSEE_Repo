:root {
  --black: #050509;
  --black-soft: #0b0b12;
  --obsidian: #050505;
  --obsidian-raised: #111111;

  --gold: #f5c76a;
  --gold-deep: #c89a3c;

  --diamond: #f9f9ff;
}

.ui-card {
  background: var(--obsidian-raised);
  border: 1px solid rgba(245,199,106,0.15);
  border-radius: 14px;
  padding: 16px;
  color: var(--gold-deep);
}

.ui-card-title {
  color: var(--gold);
  font-size: 18px;
  margin-bottom: 10px;
}

.ui-card-tag {
  font-size: 11px;
  color: var(--gold);
  opacity: 0.8;
  margin-bottom: 8px;
}

.ui-card-body {
  color: var(--gold-deep);
  font-size: 13px;
  line-height: 1.5;
}