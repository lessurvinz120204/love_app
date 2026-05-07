@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <style>
        body { font-family:sans-serif; background:#fff0f6; margin:0; padding:1rem; }
        h1 { color:#e91e8c; text-align:center; }
        .upload-card { background:white; border-radius:1rem; padding:1.5rem; max-width:500px; margin:1rem auto; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
        select, input[type=text], input[type=file] { width:100%; padding:.6rem; margin:.4rem 0; border:1px solid #ddd; border-radius:.5rem; box-sizing:border-box; }
        .btn { width:100%; padding:.75rem; background:#e91e8c; color:white; border:none; border-radius:.5rem; cursor:pointer; font-size:1rem; }
        .btn-danger { background:#ff4444; width:auto; padding:.4rem .8rem; }
        .logout { display:block; text-align:center; margin:1rem auto; color:#e91e8c; cursor:pointer; background:none; border:1px solid #e91e8c; border-radius:.5rem; padding:.5rem 1rem; }
        .success { color:green; text-align:center; }
        table { width:100%; border-collapse:collapse; font-size:.85rem; }
        td, th { padding:.5rem; border-bottom:1px solid #eee; text-align:left; }
    </style>
</head>
<body>
    <h1>💕 Admin Panel</h1>
    @if($errors->any())
        <div style="background:#ffe0e0; border:1px solid red; padding:1rem; border-radius:.5rem; max-width:500px; margin:1rem auto;">
            <strong>Error:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <div class="upload-card">
        <h3>Upload Content</h3>
        <form method="POST" action="/admin/upload" enctype="multipart/form-data">
            @csrf
            <select name="type" id="typeSelect" required onchange="toggleInput(this.value)">
                <option value="">-- Select Type --</option>
                <option value="letter">📝 Letter</option>
                <option value="song">🎵 Song</option>
                <option value="photo">📷 Photo</option>
            </select>

            <input type="text" name="title" placeholder="Title (optional)">

            <!-- Letter textarea -->
            <div id="letterInput" style="display:none;">
                <textarea name="content" rows="8" placeholder="Write your letter here..."
                    style="width:100%; padding:.75rem; border:1px solid #ddd; border-radius:.5rem;
                    font-style:italic; font-family:Georgia, serif; font-size:1rem;
                    box-sizing:border-box; resize:vertical; line-height:1.6;"></textarea>
            </div>

            <!-- File input for song/photo -->
            <div id="fileInput" style="display:none;">
                <input type="file" name="file">
            </div>

            <button type="submit" class="btn" style="margin-top:.75rem;">⬆️ Save</button>
        </form>
    </div>

    <script>
    function toggleInput(type) {
        document.getElementById('letterInput').style.display = type === 'letter' ? 'block' : 'none';
        document.getElementById('fileInput').style.display = (type === 'song' || type === 'photo') ? 'block' : 'none';
    }
    </script>

    <form method="POST" action="/logout">
        @csrf
        <button class="logout">🚪 Log Out</button>
    </form>
</body>
</html>
@endsection