<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->get('username'))
            ->where('password', md5($request->get('password')))
            ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect('/poliklinik');
        } else {
            return back()->with('loginError', 'Login Gagal');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
