@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>For You 💕</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --pink: #e91e8c;
      --pink-light: #fce4f0;
      --pink-dark: #c2177a;
      --blush: #fff0f6;
      --white: #ffffff;
      --text: #3a2030;
      --muted: #a07090;
    }

    body {
      font-family: 'Lato', sans-serif;
      background: var(--blush);
      min-height: 100vh;
      padding: 0;
      overflow-x: hidden;
    }

    /* Decorative background */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 40% at 10% 20%, rgba(233,30,140,0.07) 0%, transparent 70%),
        radial-gradient(ellipse 50% 50% at 90% 80%, rgba(233,30,140,0.05) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .page-wrap {
      position: relative;
      z-index: 1;
      max-width: 680px;
      margin: 0 auto;
      padding: 2.5rem 1.25rem 4rem;
    }

    /* Header */
    .header {
      text-align: center;
      margin-bottom: 2.5rem;
      animation: fadeDown .6s ease both;
    }
    .header h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2.6rem;
      color: var(--pink);
      line-height: 1.2;
      letter-spacing: -.5px;
    }
    .header p {
      color: var(--muted);
      font-size: .95rem;
      margin-top: .5rem;
      font-style: italic;
      font-family: 'Playfair Display', serif;
    }
    .heart-divider {
      display: flex;
      align-items: center;
      gap: .75rem;
      margin: 1rem auto;
      width: fit-content;
      color: var(--pink);
      font-size: .8rem;
      opacity: .5;
    }
    .heart-divider::before, .heart-divider::after {
      content: '';
      display: block;
      width: 48px;
      height: 1px;
      background: var(--pink);
    }

    /* Category buttons */
    .categories {
        display: flex;
        gap: .75rem;
        justify-content: center;
        flex-wrap: nowrap;
        margin-bottom: 1rem;
        width: 100%;
    }

    .cat-btn {
        position: relative;
        padding: .75rem 1rem;
        background: var(--white);
        border: 2px solid var(--pink-light);
        border-radius: 3rem;
        cursor: pointer;
        font-size: .82rem;
        font-family: 'Lato', sans-serif;
        font-weight: 400;
        color: var(--pink);
        text-decoration: none;
        text-align: center;
        transition: all .3s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 2px 12px rgba(233,30,140,0.08);
        animation: fadeUp .5s ease both;
        overflow: hidden;
        letter-spacing: .3px;
        flex: 1;          /* each button takes equal width */
        min-width: 0;     /* prevents overflow */
        white-space: nowrap;
    }
    .cat-btn::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--pink), var(--pink-dark));
      opacity: 0;
      transition: opacity .3s ease;
      border-radius: 3rem;
    }
    .cat-btn span { position: relative; z-index: 1; }
    .cat-btn:nth-child(1) { animation-delay: .1s; }
    .cat-btn:nth-child(2) { animation-delay: .2s; }
    .cat-btn:nth-child(3) { animation-delay: .3s; }

    .cat-btn:hover {
      color: white;
      border-color: var(--pink);
      transform: translateY(-3px) scale(1.04);
      box-shadow: 0 8px 24px rgba(233,30,140,0.25);
    }
    .cat-btn:hover::before { opacity: 1; }
    .cat-btn:active { transform: translateY(-1px) scale(1.01); }

    .cat-btn.active {
      color: white;
      border-color: var(--pink);
      box-shadow: 0 6px 20px rgba(233,30,140,0.3);
    }
    .cat-btn.active::before { opacity: 1; }

    /* Content panel */
    .content-panel {
      margin-top: 1.5rem;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height .5s cubic-bezier(.4,0,.2,1), opacity .4s ease;
    }
    .content-panel.open {
      max-height: 5000px;
      opacity: 1;
    }

    .panel-header {
      display: flex;
      align-items: center;
      gap: .75rem;
      margin-bottom: 1.25rem;
      padding-bottom: .75rem;
      border-bottom: 1.5px solid var(--pink-light);
    }
    .panel-header h2 {
      font-family: 'Playfair Display', serif;
      color: var(--pink);
      font-size: 1.3rem;
      font-weight: 400;
      font-style: italic;
    }
    .panel-label {
      font-size: .82rem;
      color: var(--muted);
      font-style: italic;
      margin-left: auto;
    }

    /* Items */
    .item {
      background: var(--white);
      border-radius: 1.25rem;
      padding: 1.25rem 1.4rem;
      margin-bottom: .9rem;
      box-shadow: 0 2px 14px rgba(233,30,140,0.07);
      border: 1px solid rgba(233,30,140,0.08);
      animation: fadeUp .4s ease both;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .item:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(233,30,140,0.12);
    }
    .item-title {
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      color: var(--text);
      margin-bottom: .6rem;
      font-style: italic;
    }
    .item img {
      width: 100%;
      border-radius: .85rem;
      display: block;
      max-height: 340px;
      object-fit: cover;
    }
    .item audio {
      width: 100%;
      margin-top: .25rem;
      border-radius: .5rem;
      accent-color: var(--pink);
    }
    .letter-body {
      font-style: italic;
      font-family: 'Playfair Display', serif;
      line-height: 1.85;
      white-space: pre-wrap;
      color: #5a3050;
      font-size: .97rem;
      padding: .5rem 0;
    }
    .empty-msg {
      text-align: center;
      color: var(--muted);
      padding: 2rem;
      font-style: italic;
      font-family: 'Playfair Display', serif;
    }

    /* Loading spinner */
    .loader {
      display: flex;
      justify-content: center;
      padding: 2rem;
    }
    .loader::after {
      content: '';
      width: 28px;
      height: 28px;
      border: 3px solid var(--pink-light);
      border-top-color: var(--pink);
      border-radius: 50%;
      animation: spin .7s linear infinite;
    }

    /* Logout */
    .logout-wrap { text-align: center; margin-top: 3rem; animation: fadeUp .5s .4s ease both; }
    .logout {
      background: none;
      border: 1.5px solid rgba(233,30,140,0.3);
      border-radius: 2rem;
      padding: .55rem 1.5rem;
      color: var(--muted);
      cursor: pointer;
      font-size: .88rem;
      font-family: 'Lato', sans-serif;
      letter-spacing: .5px;
      transition: all .25s ease;
    }
    .logout:hover {
      border-color: var(--pink);
      color: var(--pink);
      background: var(--pink-light);
    }

    /* Animations */
    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
<div class="page-wrap">

  <div class="header">
    <h1>Made With Love 💕</h1>
    <div class="heart-divider">♥</div>
    <p>Everything Here Was Made Just For You</p>
  </div>

  <div class="categories">
    <button class="cat-btn" onclick="toggleCategory('letter', this)"><span>📝 Letters</span></button>
    <button class="cat-btn" onclick="toggleCategory('song', this)"><span>🎵 Songs</span></button>
    <button class="cat-btn" onclick="toggleCategory('photo', this)"><span>📷 Photos</span></button>
  </div>

  <div class="content-panel" id="content-panel">
    <div id="panel-inner"></div>
  </div>

  <div class="logout-wrap">
    <form method="POST" action="/logout">
      @csrf
      <button class="logout">🚪 Log Out</button>
    </form>
  </div>

</div>

<script>
  let currentType = null;

  const labels = {
    letter: { sub: 'A Letter Just For You 💌' },
    song:   { sub: 'Songs That Remind Me Of You 🎶' },
    photo:  { sub: 'My Favorite Photos of You 📸' },
    };

  async function toggleCategory(type, btn) {
    const panel = document.getElementById('content-panel');
    const inner = document.getElementById('panel-inner');
    const allBtns = document.querySelectorAll('.cat-btn');

    // Clicking same button = close
    if (currentType === type) {
      panel.classList.remove('open');
      btn.classList.remove('active');
      currentType = null;
      setTimeout(() => { inner.innerHTML = ''; }, 500);
      return;
    }

    // Switch active button
    allBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentType = type;

    // Show loader
    inner.innerHTML = '<div class="loader"></div>';
    panel.classList.add('open');

    // Fetch data
    try {
      const res = await fetch(`/user/category/${type}?json=1`);
      const data = await res.json();
      renderItems(type, data);
    } catch(e) {
      inner.innerHTML = '<p class="empty-msg">Could not load content 🌸</p>';
    }
  }

  function renderItems(type, uploads) {
    
    const inner = document.getElementById('panel-inner');
    const meta = labels[type];

    let html = `<p style="text-align:center; font-style:italic; font-family:'Playfair Display',serif; color:var(--muted); font-size:1.15rem; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1.5px solid var(--pink-light);">${meta.sub}</p>`;
    if (!uploads.length) {
      html += '<p class="empty-msg">Nothing here yet 🌸</p>';
    } else {
      uploads.forEach((u, i) => {
        // ... rest stays the same
        const title = u.title || u.original_name || '';
        html += `<div class="item" style="animation-delay:${i * 0.07}s">`;
        if (title) html += `<p class="item-title">${escHtml(title)}</p>`;

        if (type === 'photo') {
          html += `<img src="/storage/${escHtml(u.file_path)}" alt="${escHtml(title)}">`;
        } else if (type === 'song') {
          html += `<audio controls src="/storage/${escHtml(u.file_path)}"></audio>`;
        } else if (type === 'letter') {
          html += `<div class="letter-body">${escHtml(u.content || '')}</div>`;
        }
        html += `</div>`;
      });
    }

    inner.innerHTML = html;
  }

  function escHtml(str) {
    return String(str)
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
</script>
</body>
</html>
@endsection