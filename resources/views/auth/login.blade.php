@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --pink: #e91e8c;
    --pink-dark: #c2177a;
    --pink-deeper: #a01262;
    --pink-light: #fce4f0;
    --blush: #fff0f6;
    --text: #2d1a26;
    --muted: #9a7088;
    --border: rgba(233,30,140,0.15);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--blush);
    overflow: hidden;
    position: relative;
  }

  /* Decorative blobs */
  body::before {
    content: '';
    position: fixed;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(233,30,140,0.10) 0%, transparent 70%);
    top: -120px; left: -120px;
    pointer-events: none;
  }
  body::after {
    content: '';
    position: fixed;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(233,30,140,0.08) 0%, transparent 70%);
    bottom: -100px; right: -80px;
    pointer-events: none;
  }

  /* Floating hearts */
  .hearts {
    position: fixed;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
  }
  .heart {
    position: absolute;
    bottom: -40px;
    font-size: 1.2rem;
    opacity: 0;
    animation: floatUp linear infinite;
  }
  .heart:nth-child(1)  { left: 8%;  animation-duration: 7s;  animation-delay: 0s;   font-size: .9rem; }
  .heart:nth-child(2)  { left: 18%; animation-duration: 9s;  animation-delay: 1.5s; font-size: 1.3rem; }
  .heart:nth-child(3)  { left: 30%; animation-duration: 6s;  animation-delay: 3s;   font-size: .8rem; }
  .heart:nth-child(4)  { left: 50%; animation-duration: 10s; animation-delay: .8s;  font-size: 1.1rem; }
  .heart:nth-child(5)  { left: 65%; animation-duration: 8s;  animation-delay: 2.2s; font-size: .85rem; }
  .heart:nth-child(6)  { left: 78%; animation-duration: 7.5s;animation-delay: 4s;   font-size: 1rem; }
  .heart:nth-child(7)  { left: 90%; animation-duration: 9.5s;animation-delay: 1s;   font-size: .75rem; }

  @keyframes floatUp {
    0%   { transform: translateY(0) rotate(-10deg); opacity: 0; }
    10%  { opacity: .35; }
    90%  { opacity: .2; }
    100% { transform: translateY(-100vh) rotate(15deg); opacity: 0; }
  }

  /* Card */
  .card {
    position: relative; z-index: 1;
    background: white;
    border-radius: 1.75rem;
    padding: 2.5rem 2rem;
    width: 92%;
    max-width: 360px;
    border: 1px solid var(--border);
    box-shadow: 0 8px 40px rgba(233,30,140,0.12), 0 1px 3px rgba(233,30,140,0.08);
    text-align: center;
    animation: cardIn .6s cubic-bezier(.34,1.56,.64,1) both;
  }

  /* Emblem */
  .emblem {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, var(--pink-light), #fce4f0);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 1.25rem;
    border: 2px solid rgba(233,30,140,0.15);
    animation: pulse 3s ease-in-out infinite;
  }

  @keyframes pulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(233,30,140,0.15); }
    50%       { transform: scale(1.04); box-shadow: 0 0 0 8px rgba(233,30,140,0); }
  }

  .title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 600;
    color: var(--text);
    line-height: 1.1;
    margin-bottom: .35rem;
  }
  .subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 1rem;
    color: var(--muted);
    margin-bottom: 1.75rem;
  }

  /* Error */
  .error-msg {
    background: #fff0f0;
    border: 1px solid #ffcdd2;
    color: #c62828;
    border-radius: .65rem;
    padding: .6rem .9rem;
    font-size: .82rem;
    margin-bottom: 1rem;
    text-align: left;
  }

  /* Input group */
  .input-wrap {
    position: relative;
    margin-bottom: 1rem;
  }
  .input-wrap input {
    width: 100%;
    padding: .8rem 1rem .8rem 2.8rem;
    border: 1.5px solid var(--border);
    border-radius: .85rem;
    background: var(--blush);
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    color: var(--text);
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    letter-spacing: .08em;
  }
  .input-wrap input:focus {
    border-color: var(--pink);
    background: white;
    box-shadow: 0 0 0 3px rgba(233,30,140,0.08);
  }
  .input-wrap input::placeholder { color: var(--muted); letter-spacing: 0; }
  .input-icon {
    position: absolute;
    left: .9rem; top: 50%;
    transform: translateY(-50%);
    font-size: 1rem;
    pointer-events: none;
    opacity: .5;
  }

  /* Button */
  .btn {
    width: 100%;
    padding: .85rem;
    background: linear-gradient(135deg, var(--pink), var(--pink-dark));
    color: white;
    border: none;
    border-radius: .85rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem;
    font-weight: 500;
    cursor: pointer;
    letter-spacing: .3px;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 4px 15px rgba(233,30,140,0.3);
    position: relative;
    overflow: hidden;
  }
  .btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, var(--pink-dark), var(--pink-deeper));
    opacity: 0;
    transition: opacity .25s;
  }
  .btn:hover { transform: translateY(-2px); box-shadow: 0 7px 22px rgba(233,30,140,0.38); }
  .btn:hover::before { opacity: 1; }
  .btn:active { transform: translateY(0); }
  .btn span { position: relative; z-index: 1; }

  .footer-note {
    margin-top: 1.5rem;
    font-size: .78rem;
    color: var(--muted);
    font-style: italic;
    font-family: 'Cormorant Garamond', serif;
    font-size: .95rem;
  }

  @keyframes cardIn {
    from { opacity: 0; transform: translateY(24px) scale(.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
</style>
</head>
<body>

<div class="hearts">
  <span class="heart">💕</span>
  <span class="heart">🌸</span>
  <span class="heart">💗</span>
  <span class="heart">💕</span>
  <span class="heart">🌸</span>
  <span class="heart">💗</span>
  <span class="heart">💕</span>
</div>

<div class="card">
  <div class="emblem">💕</div>
  <h1 class="title">Welcome Back</h1>
  <p class="subtitle">This Was Made Just For You</p>

  @if($errors->any())
    <div class="error-msg">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="/login">
    @csrf
    <div class="input-wrap">
      <span class="input-icon">🔑</span>
      <input type="password" name="code" placeholder="Enter your secret code" required autofocus>
    </div>
    <button type="submit" class="btn"><span>Enter ✨</span></button>
  </form>

  <p class="footer-note">Made With Love 💌</p>
</div>

</body>
</html>
@endsection