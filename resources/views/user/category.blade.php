<?php
// If JSON requested, return data only
if (request('json')) {
    return response()->json($uploads);
}
?>
@extends('layouts.app')
@section('content')
{{-- Fallback direct-URL view (rarely used now) --}}
<p style="text-align:center;padding:2rem;">
  <a href="/user/dashboard" style="color:#e91e8c;">← Back to Dashboard</a>
</p>
@endsection