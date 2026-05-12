<?php
namespace App\Http\Controllers;
use App\Models\Upload;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard() {
        if (session('role') !== 'user') return redirect('/login');
        return view('user.dashboard');
    }

    public function category(Request $request, $type) {
        if (session('role') !== 'user') return redirect('/login');
        $uploads = Upload::where('type', $type)->latest()->get();

        if ($request->query('json')) {
            return response()->json($uploads);
        }

        return view('user.category', compact('uploads', 'type'));
    }
}