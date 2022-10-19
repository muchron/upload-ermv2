<?php

namespace App\Http\Controllers;

use App\Models\RegPeriksa;
use Illuminate\Http\Request;

class RegPeriksaController extends Controller
{
    //
    public function show($no_rkm_medis)
    {
        $regPeriksa = RegPeriksa::where('no_rkm_medis', $no_rkm_medis)
            ->with('upload')
            ->orderBy('tgl_registrasi', 'DESC')
            ->get();
        return response()->json($regPeriksa);
    }
    public function detailPeriksa(Request $request)
    {
        $regPeriksa = RegPeriksa::where('no_rawat', $request->no_rawat)
            ->with('kamarInap', function ($q) {
                $q->where('stts_pulang', '!=', 'Pindah Kamar');
            })
            ->first();
        return response()->json($regPeriksa);
    }
}
