<?php

use App\Http\Controllers\CMS\DiagnosaController;
use App\Http\Controllers\CMS\GejalaController;
use App\Http\Controllers\CMS\ParameterLingkunganController;
use App\Http\Controllers\CMS\PenyakitController;
use App\Http\Controllers\CMS\PerawatanController;
use App\Http\Controllers\CMS\RekomendasiController;
use Illuminate\Support\Facades\Route;

//admin/view
Route::get('/', function () {
    return view('admin.user');
});
Route::get('/penyakit', function () {
    return view('admin.penyakit');
});
Route::get('/perawatan', function () {
    return view('admin.perawatan');
});

//pagesview
Route::get('/gejala', function () {
    return view('pages.gejala');
});
Route::get('/parameter-lingkungan', function () {
    return view('pages.lingkungan');
});
Route::get('/diagnosa', function () {
    return view('pages.diagnosa');
});




// Route api
Route::prefix('naive-bayes')->group(function () {

    // Penyakit
    Route::prefix('penyakit')->controller(PenyakitController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // Gejala
    Route::prefix('gejala')->controller(GejalaController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // Parameter Lingkungan
    Route::prefix('parameter-lingkungan')->controller(ParameterLingkunganController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // Diagnosa
    Route::prefix('diagnosa')->controller(DiagnosaController::class)->group(function () {
        Route::get('/', 'getMasterData');
        Route::post('/create', 'diagnosa');
        Route::get('/riwayat', 'getRiwayat');
    });
});
