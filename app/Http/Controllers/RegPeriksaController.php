<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
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
            ->with('pasien')
            ->first();
        return response()->json($regPeriksa);
    }
    public function pemeriksaanRalan($no_rkm_medis)
    {
        $pemeriksaan = Pasien::where('no_rkm_medis', $no_rkm_medis)

            ->with('regPeriksa', function ($q) {
                return $q->where('stts', 'Sudah')->with(['poliklinik', 'dokter', 'penjab', 'pemeriksaanRalan', 'diagnosaPasien' => function ($q) {
                    return $q->with('penyakit');
                }]);
            })
            ->get();

        return response()->json($pemeriksaan);
    }
}
