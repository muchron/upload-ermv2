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
            ->get();
        return response()->json($regPeriksa);
    }
}
