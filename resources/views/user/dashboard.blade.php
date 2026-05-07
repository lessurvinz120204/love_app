@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>For You 💕</title>
    <style>
        body { font-family:sans-serif; background:#fff0f6; margin:0; padding:1rem; }
        h1 { color:#e91e8c; text-align:center; }
        .categories { display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; margin:1.5rem 0; }
        .cat-btn { padding:1rem 1.5rem; background:white; border:2px solid #e91e8c; border-radius:1rem; cursor:pointer; font-size:1rem; color:#e91e8c; text-decoration:none; text-align:center; transition:all .2s; }
        .cat-btn:hover { background:#e91e8c; color:white; }
        .logout { display:block; text-align:center; margin:2rem auto; color:#e91e8c; background:none; border:1px solid #e91e8c; border-radius:.5rem; padding:.5rem 1rem; cursor:pointer; }
    </style>
</head>
<body>
    <h1>Made With Love 💕</h1>
    <div class="categories">
        <a href="/user/category/letter" class="cat-btn">📝 Letters</a>
        <a href="/user/category/song" class="cat-btn">🎵 Songs</a>
        <a href="/user/category/photo" class="cat-btn">📷 Photos</a>
    </div>
    <form method="POST" action="/logout">
        @csrf
        <button class="logout">🚪 Log Out</button>
    </form>
</body>
</html>
@endsection