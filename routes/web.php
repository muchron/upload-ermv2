<?php

use App\Models\Pasien;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RegPeriksaController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('index');
});

Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/cari', [PasienController::class, 'search']);
Route::get('/periksa/{no_rkm_medis}', [RegPeriksaController::class, 'show']);
Route::get('/test/{no_rkm_medis}', [RegPeriksaController::class, 'show']);
Route::get('/upload', [UploadController::class, 'index']);
Route::post('/upload', [UploadController::class, 'upload']);
Route::get('/test', function () {
    return Pasien::limit(10)
        ->with('regPeriksa')
        ->get();
});
