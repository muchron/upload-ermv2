<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('index');
});

Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/upload', [UploadController::class, 'index']);
