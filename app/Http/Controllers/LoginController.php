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
    public function aes_encrypt($input, $string)
    {
        // $secret_key     = 'Bar12345Bar12345';
        // $secret_iv      = 'sayangsamakhanza';
        // return base64_encode(openssl_encrypt($input, 'AES-128-CBC', $secret_key, OPENSSL_RAW_DATA, $secret_iv));
        $secret_key     = 'Bar12345Bar12345';
        $secret_iv      = 'sayangsamakhanza';
        $output         = FALSE;
        $encrypt_method = "AES-256-CBC";
        $key            = hash('sha256', $secret_key);
        $iv             = substr(hash('sha256', $secret_iv), 0, 16);

        switch ($input) {
            case "e":
                $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
                break;
            case "d":
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                break;
        }

        return $output;
    }
}
