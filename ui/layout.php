<?php
// layout.php — LEGAiSEE Command Center UI Shell
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LEGAiSEE Command Center</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

<style>

/* =========================
   CORE VARIABLES
========================= */

:root {
    --black: #050509;
    --black-soft: #0b0b12;
    --obsidian: #050505;
    --obsidian-raised: #111111;

    --gold: #f5c76a;
    --gold-deep: #c89a3c;

    --diamond: #f9f9ff;
}

/* =========================
   BASE
========================= */

body {
    margin:0;
    background: var(--black);
    font-family: 'Inter', sans-serif;
    color: var(--gold-deep);
}

/* =========================
   TOP NAV (YOUR DESIGN)
========================= */

header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 90;
    backdrop-filter: blur(18px);
    background: linear-gradient(to bottom, rgba(5,5,9,0.95), rgba(5,5,9,0.75), transparent);
    border-bottom: 1px solid rgba(245,199,106,0.12);
}

.nav {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:1rem 2rem;
}

.logo img {
    height:38px;
}

.nav-links {
    display:flex;
    gap:1.8rem;
    text-transform:uppercase;
    font-size:0.8rem;
    letter-spacing:0.18em;
}

.nav-links a {
    color: rgba(249,249,255,0.7);
    text-decoration:none;
    position:relative;
}

.nav-links a::after {
    content:"";
    position:absolute;
    left:0;
    bottom:-4px;
    width:0;
    height:2px;
    background:linear-gradient(to right, var(--gold), var(--gold-deep));
    transition:0.3s;
}

.nav-links a:hover::after {
    width:100%;
}

/* =========================
   MAIN
========================= */

.main {
    padding:110px 30px 40px;
    max-width:1200px;
    margin:auto;
}

/* =========================
   HEADINGS
========================= */

h1, h2, h3 {
    color: var(--gold);
    font-family: 'Cinzel', serif;
}

/* =========================
   CARDS
========================= */

.card-grid {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(240px,1fr));
    gap:20px;
}

.card {
    background: var(--obsidian-raised);
    border: 1px solid rgba(245,199,106,0.2);
    border-radius:16px;
    padding:20px;
    transition:0.3s;
}

.card:hover {
    transform:translateY(-4px);
    border-color: rgba(245,199,106,0.5);
}

.card-title {
    font-size:14px;
    letter-spacing:0.15em;
    text-transform:uppercase;
    color: var(--gold);
    margin-bottom:10px;
}

.card p {
    color: var(--diamond);
    font-size:20px;
    margin:5px 0;
}

.card-meta {
    font-size:12px;
    color: rgba(249,249,255,0.5);
}

/* =========================
   LINKS
========================= */

a {
    color: var(--gold);
    text-decoration:none;
    font-size:12px;
}

a:hover {
    text-decoration:underline;
}

/* =========================
   INPUTS
========================= */

input, textarea {
    background: var(--obsidian-raised);
    color: var(--diamond);
    border: 1px solid rgba(245,199,106,0.2);
    padding:10px;
    width:100%;
    margin-bottom:10px;
}

button {
    background: linear-gradient(135deg, var(--gold), var(--gold-deep));
    border:none;
    padding:10px 18px;
    cursor:pointer;
    color:#000;
}

</style>
</head>

<body>

<header>
    <div class="nav">

        <div class="logo">
            <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png">
        </div>

        <nav class="nav-links">
            <a href="?module=dashboard">Dashboard</a>
            <a href="?module=files">Files</a>
            <a href="?module=search">Search</a>
            <a href="?module=graph">Graph</a>
            <a href="?module=ingest">Ingest</a>
        </nav>

    </div>
</header>

<div class="main">
    <?= $content ?>
</div>

</body>
</html>