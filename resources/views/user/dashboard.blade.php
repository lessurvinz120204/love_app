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
      flex: 1;
      min-width: 0;
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
    .cat-btn.active { color: white; border-color: var(--pink); box-shadow: 0 6px 20px rgba(233,30,140,0.3); }
    .cat-btn.active::before { opacity: 1; }

    .content-panel {
      margin-top: 1.5rem;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height .5s cubic-bezier(.4,0,.2,1), opacity .4s ease;
    }
    .content-panel.open { max-height: 5000px; opacity: 1; }

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
    .item:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(233,30,140,0.12); }
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
      cursor: pointer;
      transition: transform .2s ease, filter .2s ease;
    }
    .item img:hover { transform: scale(1.02); filter: brightness(0.95); }
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
    .loader { display: flex; justify-content: center; padding: 2rem; }
    .loader::after {
      content: '';
      width: 28px;
      height: 28px;
      border: 3px solid var(--pink-light);
      border-top-color: var(--pink);
      border-radius: 50%;
      animation: spin .7s linear infinite;
    }

    /* ===== PHOTO MODAL ===== */
    .photo-modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.88);
      z-index: 1000;
      animation: fadeInOverlay .3s ease;
      overflow: auto;
      backdrop-filter: blur(5px);
    }
    .photo-modal.active {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-content {
      position: relative;
      background: var(--white);
      border-radius: 1.5rem;
      max-width: 90vw;
      max-height: 90vh;
      width: auto;
      animation: zoomIn .4s cubic-bezier(.34,1.56,.64,1);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }
    .modal-image {
      display: block;
      width: 100%;
      height: auto;
      max-height: 75vh;
      object-fit: contain;
      cursor: pointer;
      user-select: none;
    }
    .modal-label {
      padding: 1.25rem 1.5rem;
      text-align: center;
      background: var(--white);
      border-top: 1px solid var(--pink-light);
    }
    .modal-label-text {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem;
      color: var(--text);
      font-style: italic;
      margin: 0;
      line-height: 1.6;
    }

    /* Controls wrapper — fades as one unit */
    .modal-controls {
      transition: opacity .3s ease;
    }
    .modal-controls.hidden {
      opacity: 0;
      pointer-events: none;
    }

    /* Close button */
    .modal-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.95);
      border: none;
      border-radius: 50%;
      font-size: 1.4rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .2s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      z-index: 10;
      color: var(--pink-dark);
      font-weight: bold;
    }
    .modal-close:hover {
      background: var(--white);
      transform: rotate(90deg) scale(1.1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Download button — pink filled for contrast */
    .modal-download {
      position: absolute;
      top: 1rem;
      left: 1rem;
      width: 40px;
      height: 40px;
      background: var(--pink);
      border: none;
      border-radius: 50%;
      font-size: 1.1rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .25s ease;
      box-shadow: 0 2px 12px rgba(233,30,140,0.45);
      z-index: 10;
      color: white;
      text-decoration: none;
    }
    .modal-download:hover {
      background: var(--pink-dark);
      transform: scale(1.12);
      box-shadow: 0 6px 20px rgba(233,30,140,0.55);
    }
    .modal-download svg {
      width: 18px;
      height: 18px;
      stroke: white;
      fill: none;
      stroke-width: 2.2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* Nav arrows */
    .modal-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 46px;
      height: 46px;
      background: rgba(255, 255, 255, 0.92);
      border: none;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .2s ease;
      z-index: 10;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      color: var(--pink-dark);
    }
    .modal-nav:hover {
      background: var(--white);
      transform: translateY(-50%) scale(1.1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .modal-prev { left: 1rem; }
    .modal-next { right: 1rem; }

    /* Counter pill */
    .modal-counter {
      position: absolute;
      bottom: 1rem;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(233,30,140,0.75);
      color: white;
      padding: .35rem .9rem;
      border-radius: 2rem;
      font-size: .82rem;
      font-family: 'Lato', sans-serif;
      letter-spacing: .4px;
      z-index: 10;
      backdrop-filter: blur(4px);
    }

    /* Zen mode hint */
    .zen-hint {
      position: absolute;
      bottom: 1rem;
      right: 1rem;
      font-size: .72rem;
      font-family: 'Lato', sans-serif;
      color: rgba(255,255,255,0.45);
      pointer-events: none;
      letter-spacing: .3px;
      transition: opacity .3s ease;
    }
    .modal-controls.hidden ~ .zen-hint { opacity: 0; }

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
    .logout:hover { border-color: var(--pink); color: var(--pink); background: var(--pink-light); }

    @keyframes fadeDown { from { opacity: 0; transform: translateY(-18px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeUp   { from { opacity: 0; transform: translateY(16px);  } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin     { to { transform: rotate(360deg); } }
    @keyframes fadeInOverlay { from { opacity: 0; } to { opacity: 1; } }
    @keyframes zoomIn {
      from { opacity: 0; transform: scale(0.8); }
      to   { opacity: 1; transform: scale(1); }
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

<!-- Photo Modal -->
<div class="photo-modal" id="photoModal">
  <div class="modal-content">

    <!-- Controls group (fade together on click) -->
    <div class="modal-controls" id="modalControls">

      <!-- Download button (top-left, pink) -->
      <button class="modal-download" id="modalDownload" title="Download photo">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 3v13M7 11l5 5 5-5"/>
          <path d="M5 20h14"/>
        </svg>
      </button>

      <!-- Close button (top-right) -->
      <button class="modal-close" onclick="closePhotoModal()" title="Close">✕</button>

      <!-- Nav arrows -->
      <button class="modal-nav modal-prev" onclick="prevPhoto()" style="display:none;" id="prevBtn">❮</button>
      <button class="modal-nav modal-next" onclick="nextPhoto()" style="display:none;" id="nextBtn">❯</button>

      <!-- Counter -->
      <div class="modal-counter" id="modalCounter" style="display:none;"></div>

    </div><!-- /modal-controls -->

    <!-- Photo — click toggles zen mode -->
    <img class="modal-image" id="modalImage" src="" alt="" onclick="toggleZenMode()">

    <!-- Label — always visible -->
    <div class="modal-label" id="modalLabel">
      <p class="modal-label-text" id="modalLabelText"></p>
    </div>

  </div>
</div>

<script>
  let currentType    = null;
  let currentPhotos  = [];
  let currentPhotoIndex = 0;
  let zenMode        = false;

  const labels = {
    letter: { sub: 'A Letter Just For You 💌' },
    song:   { sub: 'Songs That Remind Me Of You 🎶' },
    photo:  { sub: 'My Favorite Photos of You 📸' },
  };

  async function toggleCategory(type, btn) {
    const panel = document.getElementById('content-panel');
    const inner = document.getElementById('panel-inner');
    const allBtns = document.querySelectorAll('.cat-btn');

    if (currentType === type) {
      panel.classList.remove('open');
      btn.classList.remove('active');
      currentType = null;
      setTimeout(() => { inner.innerHTML = ''; }, 500);
      return;
    }

    allBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentType = type;

    inner.innerHTML = '<div class="loader"></div>';
    panel.classList.add('open');

    try {
      const res  = await fetch(`/user/category/${type}?json=1`);
      const data = await res.json();
      if (type === 'photo') currentPhotos = data;
      renderItems(type, data);
    } catch(e) {
      inner.innerHTML = '<p class="empty-msg">Could not load content 🌸</p>';
    }
  }

  function renderItems(type, uploads) {
    const inner = document.getElementById('panel-inner');
    const meta  = labels[type];
    let html = `<p style="text-align:center;font-style:italic;font-family:'Playfair Display',serif;color:var(--muted);font-size:1.15rem;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1.5px solid var(--pink-light);">${meta.sub}</p>`;

    if (!uploads.length) {
      html += '<p class="empty-msg">Nothing here yet 🌸</p>';
    } else {
      uploads.forEach((u, i) => {
        const title = u.title || u.original_name || '';
        html += `<div class="item" style="animation-delay:${i * 0.07}s">`;
        if (title) html += `<p class="item-title">${escHtml(title)}</p>`;

        if (type === 'photo') {
          html += `<img src="/storage/${escHtml(u.file_path)}" alt="${escHtml(title)}" onclick="openPhotoModal(${i})">`;
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

  function openPhotoModal(index) {
    currentPhotoIndex = index;
    zenMode = false; // always start with controls visible

    const photo       = currentPhotos[index];
    const modal       = document.getElementById('photoModal');
    const modalImg    = document.getElementById('modalImage');
    const labelText   = document.getElementById('modalLabelText');
    const counter     = document.getElementById('modalCounter');
    const prevBtn     = document.getElementById('prevBtn');
    const nextBtn     = document.getElementById('nextBtn');
    const downloadBtn = document.getElementById('modalDownload');
    const controls    = document.getElementById('modalControls');
    const labelEl     = document.getElementById('modalLabel');

    const src = `/storage/${photo.file_path}`;
    modalImg.src    = src;
    modalImg.alt    = photo.title || photo.original_name || 'Photo';
    labelText.textContent = photo.title || photo.original_name || 'Photo';

    // Download: canvas composite with label
    downloadBtn.onclick = (e) => {
      e.preventDefault();
      downloadWithLabel(src, photo.title || photo.original_name || 'photo');
    };

    counter.textContent  = `${index + 1} / ${currentPhotos.length}`;
    counter.style.display = currentPhotos.length > 1 ? 'block' : 'none';
    prevBtn.style.display = currentPhotos.length > 1 ? 'flex' : 'none';
    nextBtn.style.display = currentPhotos.length > 1 ? 'flex' : 'none';

    // Show controls
    controls.classList.remove('hidden');
    labelEl.classList.remove('hidden');

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function toggleZenMode() {
    zenMode = !zenMode;
    document.getElementById('modalControls').classList.toggle('hidden', zenMode);
  }

  function downloadWithLabel(src, labelText) {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      const padding   = 28;
      const labelH    = 70;
      const fontSize  = 18;
      const lineH     = 28;

      const canvas  = document.createElement('canvas');
      canvas.width  = img.naturalWidth;
      canvas.height = img.naturalHeight + labelH;
      const ctx     = canvas.getContext('2d');

      // White background
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Draw photo
      ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);

      // Pink top border on label area
      ctx.fillStyle = '#fce4f0';
      ctx.fillRect(0, img.naturalHeight, canvas.width, 2);

      // Label background
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, img.naturalHeight + 2, canvas.width, labelH - 2);

      // Label text — italic Playfair style
      ctx.fillStyle = '#3a2030';
      ctx.font      = `italic ${fontSize}px 'Playfair Display', Georgia, serif`;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(labelText, canvas.width / 2, img.naturalHeight + labelH / 2 + 2, canvas.width - padding * 2);

      // Trigger download
      const a    = document.createElement('a');
      a.href     = canvas.toDataURL('image/png');
      a.download = (labelText || 'photo').replace(/[^a-z0-9\-_ ]/gi, '_') + '.png';
      a.click();
    };
    img.onerror = () => {
      // Fallback: plain download if CORS fails
      const a    = document.createElement('a');
      a.href     = src;
      a.download = (labelText || 'photo') + '.png';
      a.click();
    };
    img.src = src;
  }

  function closePhotoModal() {
    document.getElementById('photoModal').classList.remove('active');
    document.body.style.overflow = '';
    zenMode = false;
  }

  function nextPhoto() {
    if (currentPhotoIndex < currentPhotos.length - 1) openPhotoModal(currentPhotoIndex + 1);
  }

  function prevPhoto() {
    if (currentPhotoIndex > 0) openPhotoModal(currentPhotoIndex - 1);
  }

  document.addEventListener('keydown', (e) => {
    const modal = document.getElementById('photoModal');
    if (!modal.classList.contains('active')) return;
    if (e.key === 'ArrowRight') nextPhoto();
    if (e.key === 'ArrowLeft')  prevPhoto();
    if (e.key === 'Escape')     closePhotoModal();
    if (e.key === ' ')          { e.preventDefault(); toggleZenMode(); }
  });

  document.getElementById('photoModal').addEventListener('click', (e) => {
    if (e.target.id === 'photoModal') closePhotoModal();
  });

  function escHtml(str) {
    return String(str)
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }
</script>
</body>
</html>
@endsection