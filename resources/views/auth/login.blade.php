@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background:#fff0f6; margin:0; }
        .card { background:white; padding:2rem; border-radius:1rem; box-shadow:0 4px 20px rgba(0,0,0,0.1); width:300px; text-align:center; }
        h1 { color:#e91e8c; }
        input { width:100%; padding:.75rem; margin:.5rem 0; border:1px solid #ddd; border-radius:.5rem; font-size:1rem; box-sizing:border-box; }
        button { width:100%; padding:.75rem; background:#e91e8c; color:white; border:none; border-radius:.5rem; font-size:1rem; cursor:pointer; }
        .error { color:red; font-size:.85rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>💕</h1>
        <h2>Welcome</h2>
        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif
        <form method="POST" action="/login">
            @csrf
            <input type="password" name="code" placeholder="Enter your code" required>
            <button type="submit">Enter ✨</button>
        </form>
    </div>
</body>
</html>
@endsection