<?php

use App\Http\Controllers\AUTH\AuthController;
use App\Http\Controllers\CMS\AturanGejalaController;
use App\Http\Controllers\CMS\AturanPenyakitLingkunganController;
use App\Http\Controllers\CMS\DiagnosaController;
use App\Http\Controllers\CMS\GejalaController;
use App\Http\Controllers\CMS\ParameterLingkunganController;
use App\Http\Controllers\CMS\PenyakitController;
use App\Http\Controllers\CMS\PerawatanController;
use App\Http\Controllers\CMS\RekomendasiController;
use Illuminate\Support\Facades\Route;



Route::post('auth/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');


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

    // aturan gejala
    Route::prefix('aturan-gejala')->controller(AturanGejalaController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // aturan Penyakit
    Route::prefix('aturan-penyakit')->controller(AturanPenyakitLingkunganController::class)->group(function () {
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

Route::middleware(['auth', 'web'])->group(function () {

    //admin/view
    Route::get('/', function () {
        return view('pages.diagnosa');
    });
    Route::get('/penyakit', function () {
        return view('admin.penyakit');
    });
    Route::get('/aturan-gejala', function () {
        return view('admin.aturan_gejala');
    });
    Route::get('/aturan-penyakit-lingkungan', function () {
        return view('admin.aturan_penyakit_lingkungan');
    });
    //pagesview
    Route::get('/gejala', function () {
        return view('pages.gejala');
    });
    Route::get('/parameter-lingkungan', function () {
        return view('pages.lingkungan');
    });
    Route::get('/riwayat', function () {
        return view('pages.riwayat');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
