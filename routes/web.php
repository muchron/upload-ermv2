<?php

use App\Models\Pasien;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RegPeriksaController;
use App\Http\Controllers\UploadController;
use App\Models\Poliklinik;

Route::get('/', function () {
    return view('index');
});

Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/cari', [PasienController::class, 'search']);
Route::get('/pasien/show/{no_rkm_medis}', [PasienController::class, 'show']);
Route::get('/periksa/show/{no_rkm_medis}', [
    RegPeriksaController::class,
    'show',
]);
Route::get('periksa/detail', [RegPeriksaController::class, 'detailPeriksa']);
Route::get('/test/{no_rkm_medis}', [RegPeriksaController::class, 'show']);
Route::get('/upload', [UploadController::class, 'index']);
Route::get('/upload/show', [UploadController::class, 'showUpload']);
Route::delete('/upload/delete/{id}', [UploadController::class, 'delete']);
Route::post('/upload', [UploadController::class, 'upload']);
Route::get('/test', function () {
    return Pasien::limit(10)
        ->with('regPeriksa')
        ->get();
});

Route::get('/poliklinik', [PoliklinikController::class, 'index']);
Route::get('/poliklinik/dokter', [PoliklinikController::class, 'poliDokter']);
