<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        return view('content.pasien.pencarian');
    }
    public function search(Request $request)
    {
        $pasien = [];
        if ($request->has('q')) {
            $pasien = Pasien::select(['nm_pasien', 'no_rkm_medis'])
                ->where('nm_pasien', 'like', $request->q . '%')
                ->orWhere('no_rkm_medis', 'like', $request->q . '%')
                ->limit(10)
                ->get();
        }
        return response()->json($pasien);
    }
}
