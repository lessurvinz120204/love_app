@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --pink: #e91e8c;
    --pink-dark: #c2177a;
    --pink-deeper: #a01262;
    --pink-light: #fce4f0;
    --pink-pale: #fff0f6;
    --blush: #fdf5f9;
    --text: #2d1a26;
    --muted: #9a7088;
    --border: rgba(233,30,140,0.12);
    --white: #ffffff;
  }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--blush);
    min-height: 100vh;
    padding: 0;
    color: var(--text);
  }
  body::before {
    content: '';
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 220px;
    background: linear-gradient(160deg, #fce4f0 0%, #fff0f6 60%, transparent 100%);
    pointer-events: none;
    z-index: 0;
  }

  .page { position: relative; z-index: 1; max-width: 960px; margin: 0 auto; padding: 1.25rem .9rem 4rem; }

  /* Header */
  .header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; margin-bottom: 1.75rem; animation: fadeDown .5s ease both; }
  .header-left h1 { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 600; color: var(--pink); letter-spacing: -.3px; line-height: 1; }
  .header-left p { color: var(--muted); margin-top: .3rem; font-style: italic; font-family: 'Cormorant Garamond', serif; font-size: .95rem; }
  .logout-btn { background: none; border: 1.5px solid var(--border); border-radius: 2rem; padding: .45rem 1.1rem; color: var(--muted); cursor: pointer; font-family: 'DM Sans', sans-serif; font-size: .82rem; transition: all .2s; letter-spacing: .3px; }
  .logout-btn:hover { border-color: var(--pink); color: var(--pink); background: var(--pink-light); }

  /* Alerts */
  .alert { border-radius: .75rem; padding: .85rem 1.1rem; margin-bottom: 1.25rem; font-size: .88rem; }
  .alert-error { background: #fff0f0; border: 1px solid #ffcdd2; color: #c62828; }
  .alert-success { background: #f0fff4; border: 1px solid #c8e6c9; color: #2e7d32; }

  /* Layout - mobile first single column */
  .layout { display: grid; grid-template-columns: 1fr; gap: 1.25rem; align-items: start; }

  /* Card */
  .card { background: var(--white); border-radius: 1rem; padding: 1.1rem; border: 1px solid var(--border); box-shadow: 0 2px 16px rgba(233,30,140,0.06); animation: fadeUp .5s ease both; }
  .card-title { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 600; color: var(--text); margin-bottom: .9rem; display: flex; align-items: center; gap: .5rem; }
  .card-title-icon { width: 26px; height: 26px; background: var(--pink-light); border-radius: .45rem; display: flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink: 0; }

  /* Form elements */
  select, input[type=text], input[type=file], textarea {
    width: 100%; padding: .6rem .8rem; margin: .35rem 0;
    border: 1.5px solid rgba(233,30,140,0.15);
    border-radius: .65rem; background: var(--blush);
    font-family: 'DM Sans', sans-serif; font-size: .92rem;
    color: var(--text); transition: border-color .2s, background .2s;
    outline: none;
  }
  select:focus, input[type=text]:focus, textarea:focus { border-color: var(--pink); background: white; }
  textarea { resize: vertical; font-style: italic; font-family: 'Cormorant Garamond', serif; font-size: 1rem; line-height: 1.65; }

  .btn-primary { width: 100%; padding: .7rem; background: linear-gradient(135deg, var(--pink), var(--pink-dark)); color: white; border: none; border-radius: .65rem; cursor: pointer; font-family: 'DM Sans', sans-serif; font-size: .9rem; font-weight: 500; letter-spacing: .3px; margin-top: .5rem; transition: all .25s; box-shadow: 0 3px 12px rgba(233,30,140,0.25); }
  .btn-primary:hover { background: linear-gradient(135deg, var(--pink-dark), var(--pink-deeper)); box-shadow: 0 5px 18px rgba(233,30,140,0.35); transform: translateY(-1px); }
  .btn-primary:active { transform: translateY(0); }

  /* Table */
  .table-section { animation: fadeUp .5s .1s ease both; }
  .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  table { width: 100%; min-width: 520px; border-collapse: collapse; font-size: .84rem; }
  thead th { padding: .6rem .85rem; text-align: left; font-weight: 500; font-size: .72rem; letter-spacing: .6px; text-transform: uppercase; color: var(--muted); border-bottom: 1.5px solid var(--pink-light); }
  tbody td { padding: .65rem .85rem; border-bottom: 1px solid rgba(233,30,140,0.07); vertical-align: middle; }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr { transition: background .15s; }
  tbody tr:hover td { background: #fff7fb; }

  .badge { display: inline-block; padding: .18rem .55rem; border-radius: 2rem; font-size: .72rem; font-weight: 500; }
  .badge-letter { background: #e3f2fd; color: #1565c0; }
  .badge-song   { background: #f3e5f5; color: #6a1b9a; }
  .badge-photo  { background: #e8f5e9; color: #2e7d32; }

  .thumb { height: 38px; border-radius: .45rem; object-fit: cover; display: block; }
  .file-name { color: var(--muted); font-size: .78rem; font-style: italic; }
  .preview-text { color: var(--muted); font-style: italic; font-size: .8rem; }
  .date-cell { color: var(--muted); font-size: .78rem; white-space: nowrap; }
  .empty-row td { text-align: center; color: var(--muted); padding: 2.5rem; font-style: italic; font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; }

  /* Action buttons */
  .actions { display: flex; flex-wrap: wrap; gap: .35rem; align-items: center; }
  .btn-edit, .btn-del {
    border: none; border-radius: .5rem; cursor: pointer;
    padding: .35rem .7rem; font-size: .78rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif; transition: all .2s;
    white-space: nowrap;
  }
  .btn-edit { background: var(--pink-light); color: var(--pink); }
  .btn-edit:hover { background: var(--pink); color: white; }
  .btn-del { background: #fff0f0; color: #e53935; }
  .btn-del:hover { background: #e53935; color: white; }

  /* Modal */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(45,10,30,0.4); backdrop-filter: blur(3px);
    z-index: 999; justify-content: center; align-items: center;
    padding: 1rem;
  }
  .modal-overlay.active { display: flex; }
  .modal {
    background: white; border-radius: 1.1rem; padding: 1.5rem;
    width: 95%; max-width: 460px;
    box-shadow: 0 20px 60px rgba(233,30,140,0.15);
    border: 1px solid var(--border);
    animation: modalIn .25s cubic-bezier(.34,1.56,.64,1) both;
    position: relative;
  }
  .modal-title { font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; font-weight: 600; color: var(--pink); margin-bottom: 1rem; }
  .modal-close { position: absolute; top: 1rem; right: 1rem; background: var(--blush); border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; color: var(--muted); font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all .2s; }
  .modal-close:hover { background: var(--pink-light); color: var(--pink); }
  .field-label { font-size: .78rem; color: var(--muted); margin-top: .6rem; margin-bottom: .1rem; font-weight: 500; letter-spacing: .3px; }
  .modal-actions { display: flex; gap: .75rem; margin-top: 1rem; }
  .modal-actions .btn-primary { margin: 0; }
  .btn-cancel { flex: 0 0 auto; padding: .7rem 1.1rem; background: var(--blush); color: var(--muted); border: 1.5px solid var(--border); border-radius: .65rem; cursor: pointer; font-family: 'DM Sans', sans-serif; font-size: .88rem; transition: all .2s; }
  .btn-cancel:hover { border-color: var(--pink); color: var(--pink); }

  /* Desktop: side by side */
  @media(min-width: 720px) {
    .layout { grid-template-columns: 320px 1fr; }
    .page { padding: 2rem 1.25rem 5rem; }
    .header-left h1 { font-size: 2rem; }
    .card { padding: 1.5rem; border-radius: 1.25rem; }
    .card-title { font-size: 1.25rem; }
  }

  @keyframes fadeDown { from { opacity:0; transform:translateY(-14px); } to { opacity:1; transform:translateY(0); } }
  @keyframes fadeUp   { from { opacity:0; transform:translateY(14px);  } to { opacity:1; transform:translateY(0); } }
  @keyframes modalIn  { from { opacity:0; transform:scale(.94) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
</style>
</head>
<body>
<div class="page">

  <div class="header">
    <div class="header-left">
      <h1>💕 Admin Panel</h1>
      <p>Manage your uploads with love</p>
    </div>
    <form method="POST" action="/logout">
      @csrf
      <button class="logout-btn">🚪 Log Out</button>
    </form>
  </div>

  @if($errors->any())
    <div class="alert alert-error">
      <strong>Error:</strong>
      <ul style="margin:.4rem 0 0 1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="layout">

    {{-- Upload Form --}}
    <div class="card">
      <div class="card-title">
        <span class="card-title-icon">⬆️</span> Upload Content
      </div>
      <form method="POST" action="/admin/upload" enctype="multipart/form-data">
        @csrf
        <select name="type" id="typeSelect" required onchange="toggleInput(this.value)">
          <option value="">— Select type —</option>
          <option value="letter">📝 Letter</option>
          <option value="song">🎵 Song</option>
          <option value="photo">📷 Photo</option>
        </select>
        <input type="text" name="title" placeholder="Title (optional)">
        <div id="letterInput" style="display:none;">
          <textarea name="content" rows="7" placeholder="Write your letter here…"></textarea>
        </div>
        <div id="fileInput" style="display:none;">
          <input type="file" name="file">
        </div>
        <button type="submit" class="btn-primary">⬆️ Save</button>
      </form>
    </div>

    {{-- Table --}}
    <div class="card table-section">
      <div class="card-title">
        <span class="card-title-icon">📋</span> All Uploads
        <span style="margin-left:auto;font-size:.78rem;font-weight:400;color:var(--muted);font-family:'DM Sans',sans-serif;">
          {{ $uploads->count() }} item{{ $uploads->count() !== 1 ? 's' : '' }}
        </span>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Type</th>
              <th>Title</th>
              <th>Preview</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($uploads as $i => $item)
            <tr>
              <td style="color:var(--muted);font-size:.78rem;">{{ $i + 1 }}</td>
              <td>
                @if($item->type === 'letter') <span class="badge badge-letter">📝 Letter</span>
                @elseif($item->type === 'song') <span class="badge badge-song">🎵 Song</span>
                @else <span class="badge badge-photo">📷 Photo</span>
                @endif
              </td>
              <td style="font-weight:500;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                {{ $item->title ?? '—' }}
              </td>
              <td>
                @if($item->type === 'letter')
                  <span class="preview-text">{{ Str::limit($item->content, 30) }}</span>
                @elseif($item->type === 'photo' && $item->file_path)
                  <img class="thumb" src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}">
                @elseif($item->type === 'song' && $item->file_path)
                  <span class="file-name">{{ $item->original_name }}</span>
                @else —
                @endif
              </td>
              <td class="date-cell">{{ $item->created_at->format('M d, Y') }}</td>
              <td>
                <div class="actions">
                  <button class="btn-edit"
                    onclick="openEdit({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->content ?? '') }}', '{{ $item->type }}')">
                    ✏️ Edit
                  </button>
                  <form method="POST" action="/admin/delete/{{ $item->id }}" style="display:inline;"
                    onsubmit="return confirm('Delete this item?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-del">🗑️ Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="6">Nothing uploaded yet 🌸</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <button class="modal-close" onclick="closeEdit()">✕</button>
    <div class="modal-title">✏️ Edit Upload</div>
    <form method="POST" id="editForm">
      @csrf
      @method('PUT')
      <div class="field-label">Title</div>
      <input type="text" name="title" id="editTitle" placeholder="Title (optional)">
      <div id="editContentWrap">
        <div class="field-label">Content</div>
        <textarea name="content" id="editContent" rows="7" placeholder="Letter content…"></textarea>
      </div>
      <div class="modal-actions">
        <button type="submit" class="btn-primary" style="flex:1;">💾 Save Changes</button>
        <button type="button" class="btn-cancel" onclick="closeEdit()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleInput(type) {
    document.getElementById('letterInput').style.display = type === 'letter' ? 'block' : 'none';
    document.getElementById('fileInput').style.display = (type === 'song' || type === 'photo') ? 'block' : 'none';
  }
  function openEdit(id, title, content, type) {
    document.getElementById('editForm').action = '/admin/update/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editContent').value = content;
    document.getElementById('editContentWrap').style.display = type === 'letter' ? 'block' : 'none';
    document.getElementById('editModal').classList.add('active');
  }
  function closeEdit() {
    document.getElementById('editModal').classList.remove('active');
  }
  document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
  });
</script>
</body>
</html>
@endsection