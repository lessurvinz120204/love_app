<?php
namespace App\Http\Controllers;

use App\Models\Upload;

class UserController extends Controller
{
    public function dashboard() {
        if (session('role') !== 'user') return redirect('/login');
        return view('user.dashboard');
    }

    public function category($type) {
        if (session('role') !== 'user') return redirect('/login');
        $uploads = Upload::where('type', $type)->latest()->get();
        return view('user.category', compact('uploads', 'type'));
    }
}