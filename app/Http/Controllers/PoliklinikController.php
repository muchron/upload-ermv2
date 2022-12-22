<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Poliklinik;
use App\Models\RegPeriksa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\MappingPoliklinik;
use App\Models\Upload;

use function PHPUnit\Framework\isEmpty;

class PoliklinikController extends Controller
{
    public function index()
    {
        $poliklinik = $this->poliDokter();
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
    public function poliPasien($kd_poli, $kd_dokter)
    {
        $tanggal = new Carbon();

        $sekarang = $tanggal->now()->toDateString();
        return $pasienPoli = RegPeriksa::whereYear('tgl_registrasi', '2021')
            ->with(['pasien', 'dokter'])
            ->where('kd_poli', $kd_poli)
            ->where('kd_dokter', $kd_dokter);

        // return response()->json($pasienPoli);
    }
    public function namaPoli($kd_poli = '')
    {
        return $poliklinik = Poliklinik::where('status', '1')
            ->where('kd_poli', $kd_poli)
            ->first();
    }
    public function pasienPoliUpload()
    {
        // return $regPeriksa = RegPeriksa::
    }
    public function dokterPoli($kd_dokter = '')
    {
        if ($kd_dokter) {
            $dokter = Dokter::where('kd_dokter', $kd_dokter)->first();
        } else {
            $dokter = Dokter::where('status', '1')->get();
        }
        return $dokter;
    }
    public function viewPoliPasien($kd_poli, Request $request)
    {
        $pasien = $this->poliPasien($kd_poli, $request->dokter);
        $poliklinik = $this->namaPoli($kd_poli);
        $dokter = $this->dokterPoli($request->dokter);
        $jmlUpload = 0;
        foreach ($pasien as $p) {
            $jmlUpload = $jmlUpload + $p->upload_count;
        }

        // return $jmlUpload;
        return view('content.poliklinik.pasien', [
            'pasien' => $pasien->get(),
            'jumlah' => $pasien->count(),
            'poli' => $poliklinik,
            'dokter' => $dokter,
            'uploaded' => $jmlUpload,
        ]);
    }
    public function countUpload($kd_poli, Request $request)
    {
        $pasien = $this->poliPasien($kd_poli, $request->dokter)->withCount('upload')->get();
        $jmlUpload = 0;
        foreach ($pasien as $p) {
            $jmlUpload = $jmlUpload + $p->upload_count;
        }
        return $jmlUpload;
    }
    public function tbPoliPasien($kd_poli, Request $request)
    {
        $pasien = $this->poliPasien($kd_poli, $request->dokter);

        return DataTables::of($pasien)
            ->editColumn('nm_pasien', function ($q) {
                return $q->pasien->nm_pasien . ' <br/> (' . $q->no_rawat . ')';
            })
            ->addColumn('upload', function ($q) {
                $no_rawat = $this->statusUpload($q->no_rawat);

                if ($no_rawat) {
                    $btnClass =
                        'class="btn btn-success btn-sm"><i class="bi bi-check2-circle"></i></a>';
                } else {
                    $btnClass =
                        'class="btn btn-primary btn-sm"><i class="bi bi-cloud-upload-fill"></i></a>';
                }

                $btnUpload =
                    '<a href="#form-upload" onclick="detailPeriksa(\'' .
                    $q->no_rawat .
                    '\', \'' .
                    $q->status_lanjut .
                    '\')" ' .
                    $btnClass;

                return $btnUpload;
            })
            ->rawColumns(['upload', 'nm_pasien'])
            ->make(true);
    }

    public function statusUpload($no_rawat)
    {
        $upload = Upload::select('no_rawat')
            ->where('no_rawat', $no_rawat)
            ->first();
        return $upload;
    }
}
