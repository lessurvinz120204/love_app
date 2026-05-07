@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ ucfirst($type) }}</title>
    <style>
        body { font-family:sans-serif; background:#fff0f6; margin:0; padding:1rem; }
        h1 { color:#e91e8c; text-align:center; }
        .label { text-align:center; font-style:italic; color:#888; margin-bottom:1.5rem; }
        .items { max-width:500px; margin:0 auto; }
        .item { background:white; border-radius:1rem; padding:1rem; margin:.75rem 0; box-shadow:0 2px 8px rgba(0,0,0,0.08); }
        .item img { width:100%; border-radius:.5rem; }
        .item audio { width:100%; }
        .back { display:block; text-align:center; margin:1.5rem auto; color:#e91e8c; background:none; border:1px solid #e91e8c; border-radius:.5rem; padding:.5rem 1rem; cursor:pointer; text-decoration:none; }
    </style>
</head>
<body>
    <h1>
        @if($type === 'letter') 📝 Letters
        @elseif($type === 'song') 🎵 Songs
        @else 📷 Photos
        @endif
    </h1>

    <p class="label">
        @if($type === 'song') Songs that remind me of you 🎶
        @elseif($type === 'photo') My favorite photos of you 📸
        @else A letter just for you 💌
        @endif
    </p>

    <div class="items">
        @forelse($uploads as $upload)
        <div class="item">
            <p><strong>{{ $upload->title ?? $upload->original_name }}</strong></p>
            @if($type === 'photo')
                <img src="{{ asset('storage/' . $upload->file_path) }}" alt="{{ $upload->title }}">
            @elseif($type === 'song')
                <audio controls src="{{ asset('storage/' . $upload->file_path) }}"></audio>
            @elseif($type === 'letter')
                <div style="font-style:italic; font-family:Georgia, serif; line-height:1.8; white-space:pre-wrap; color:#333;">
                    {{ $upload->content }}
                </div>
            @endif
        </div>
        @empty
            <p style="text-align:center;color:#aaa;">Nothing here yet 🌸</p>
        @endforelse
    </div>

    <a href="/user/dashboard" class="back">← Back</a>
</body>
</html>
@endsection