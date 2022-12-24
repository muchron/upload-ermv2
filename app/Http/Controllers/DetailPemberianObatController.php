<?php

namespace App\Http\Controllers;

use App\Models\AturanPakai;
use Illuminate\Http\Request;

class DetailPemberianObatController extends Controller
{
    public function aturanPakai(Request $request)
    {
        $aturan = AturanPakai::where('no_rawat', $request->no_rawat)
            ->where('kode_brng', $request->kode_brng)->first();
        return response()->json($aturan);
    }
}
