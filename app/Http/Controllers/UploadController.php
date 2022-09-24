<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $pasien = Pasien::where(
            'no_rkm_medis',
            request('no_rkm_medis')
        )->first();

        if (!$pasien) {
            return redirect('/');
        }
        return view('content.upload', [
            'upload' => $this->showUpload(request('no_rawat')),
            'no_rawat' => request('no_rawat'),
            'tgl_masuk' => request('tgl_masuk'),
            'no_rkm_medis' => $pasien->no_rkm_medis,
            'nm_pasien' => $pasien->nm_pasien,
            'tgl_lahir' => $pasien->tgl_lahir,
            'alamat' => $pasien->alamat,
        ]);
    }
    public function showUpload($no_rawat)
    {
        $upload = Upload::where('no_rawat', $no_rawat)->first();
        return $upload;
    }
    public function upload(Request $request)
    {
        $no_rkm_medis = $request->no_rkm_medis;
        $no_rawat = $request->no_rawat;
        $tgl_masuk = $request->tgl_masuk;
        $username = $request->username;
        $arrNama = [];
        // return $request->tgl_masuk;
        foreach ($request->images as $images) {
            $image_parts[] = explode(';base64,', $images);
            foreach ($image_parts as $parts) {
                $image_type_aux = explode('image/', $parts[0]);
                $image_base64[] = base64_decode($parts[1]);
            }

            $image_type[] = $image_type_aux[1];
            foreach ($image_type as $type) {
                foreach ($image_base64 as $base) {
                    $base = base64_decode($parts[1]);
                }
            }
            $name = uniqid() . '.' . $type;
            array_push($arrNama, $name);
            $storage = Storage::disk('public_upload')->put(
                'erm/' . $name,
                $base
            );
        }
        $fileName = implode(',', $arrNama);

        Upload::create([
            'file' => $fileName,
            'no_rkm_medis' => $no_rkm_medis,
            'no_rawat' => $no_rawat,
            'tgl_masuk' => $tgl_masuk,
            'username' => $username,
        ]);
        return redirect()->back();
        // return $request->all();
    }
}
