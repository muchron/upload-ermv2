<?php

use App\Models\Pasien;
use App\Models\Poliklinik;
use App\Models\DetailPemberianObat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\RegPeriksaController;
use App\Http\Controllers\DetailPemberianObatController;
use App\Http\Controllers\LabController;

Route::get('/login', function () {
    return view('content.auth.login');
});
Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login')
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/', function () {
        return redirect('/poliklinik');
    });

    Route::get('/pasien', [PasienController::class, 'index']);
    Route::get('/pasien/cari', [PasienController::class, 'search']);
    Route::get('/pasien/show/{no_rkm_medis}', [
        PasienController::class,
        'show',
    ]);
    Route::get('/periksa/show/{no_rkm_medis}', [
        RegPeriksaController::class,
        'show',
    ]);
    Route::get('periksa/detail', [
        RegPeriksaController::class,
        'detailPeriksa',
    ]);
    Route::get('/test/{no_rkm_medis}', [RegPeriksaController::class, 'show']);
    Route::get('/upload', [UploadController::class, 'index']);
    Route::get('/upload/show', [UploadController::class, 'showUpload']);
    Route::delete('/upload/delete/{id}', [UploadController::class, 'delete']);
    Route::post('/upload', [UploadController::class, 'upload']);
    Route::get('/upload/status', [PoliklinikController::class, 'statusUpload']);
    Route::get('/test', function () {
        return Pasien::limit(10)
            ->with('regPeriksa')
            ->get();
    });

    Route::get('/poliklinik', [PoliklinikController::class, 'index'])->name('poliklinik');
    Route::get('/poliklinik/dokter', [
        PoliklinikController::class,
        'poliDokter',
    ]);
    Route::get('/poliklinik/table/{kd_poli}', [
        PoliklinikController::class,
        'tbPoliPasien',
    ]);
    Route::get('/poliklinik/{kd_poli}', [
        PoliklinikController::class,
        'viewPoliPasien',
    ]);
    Route::get('/poliklinik/count/{kd_poli}', [PoliklinikController::class, 'countUpload']);
});
Route::get('/aes/{input}/{string}', [LoginController::class, 'aes_encrypt']);
Route::get('/test/{no_rkm_medis}', [RegPeriksaController::class, 'pemeriksaanRalan']);
Route::get('/aturan', [DetailPemberianObatController::class, 'aturanPakai']);
Route::get('lab/petugas', [LabController::class, 'petugas']);
