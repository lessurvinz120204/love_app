<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $code = $request->input('code');

        if ($code === 'admin052305') {
            session(['role' => 'admin']);
            return redirect('/admin/dashboard');
        } elseif ($code === '052305') {
            session(['role' => 'user']);
            return redirect('/user/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid code.']);
    }

    public function logout() {
        session()->flush();
        return redirect('/login');
    }
}