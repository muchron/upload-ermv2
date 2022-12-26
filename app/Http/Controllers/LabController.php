<?php

namespace App\Http\Controllers;

use App\Models\PeriksaLab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function petugas(Request $request)
    {
        $lab = PeriksaLab::where('no_rawat', $request->no_rawat)
            ->where('kd_jenis_prw', $request->kd_jenis_prw)->with(['petugas', 'dokter'])->first();
        return response()->json($lab);
    }
}
