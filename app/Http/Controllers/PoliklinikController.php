<?php

namespace App\Http\Controllers;

use App\Models\MappingPoliklinik;
use App\Models\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    public function index()
    {
        $poliklinik = MappingPoliklinik::with(['dokter', 'poliklinik'])->get();
        return view('content.poliklinik.poliklinik', [
            'data' => $poliklinik,
        ]);
    }
    public function poliDokter()
    {
        return $poliklinik = MappingPoliklinik::with([
            'dokter',
            'poliklinik',
        ])->get();
    }
}
