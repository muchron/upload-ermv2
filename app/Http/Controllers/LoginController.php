<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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


        // $user = User::where('username', $request->get('username'))
        //     ->where('password', md5($request->get('password')))
        //     ->first();

        $user = User::select('*', DB::raw("AES_DECRYPT(id_user, 'nur') as username, AES_DECRYPT(password, 'windi') as passwd"))->where('id_user', DB::raw("AES_ENCRYPT('" . $request->get('username') . "', 'nur')"))
            ->where('password', DB::raw("AES_ENCRYPT('" . $request->get('password') . "', 'windi')"))
            ->first();

        // return $user;

        if ($user) {
            Auth::login($user);
            $pegawai = Pegawai::where('nik', $request->get('username'))->first();
            $request->session()->regenerate();
            Session::put('pegawai', $pegawai);
            return redirect('/poliklinik');
        } else {
            return back()->with('loginError', 'Login Gagal');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    // public function aes_encrypt($input, $string)
    // {
    //     // $secret_key     = 'Bar12345Bar12345';
    //     // $secret_iv      = 'sayangsamakhanza';
    //     // return base64_encode(openssl_encrypt($input, 'AES-128-CBC', $secret_key, OPENSSL_RAW_DATA, $secret_iv));
    //     $secret_key     = 'Bar12345Bar12345';
    //     $secret_iv      = 'sayangsamakhanza';
    //     $output         = FALSE;
    //     $encrypt_method = "AES-256-CBC";
    //     $key            = hash('sha256', $secret_key);
    //     $iv             = substr(hash('sha256', $secret_iv), 0, 16);

    //     switch ($input) {
    //         case "e":
    //             $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    //             break;
    //         case "d":
    //             $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    //             break;
    //     }

    //     return $output;
    // }
}
