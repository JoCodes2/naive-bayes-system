<?php

use App\Http\Controllers\CMS\GejalaController;
use App\Http\Controllers\CMS\PenyakitController;
use App\Http\Controllers\CMS\PerawatanController;
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




// Route api
Route::prefix('naive-bayes')->group(function () {

    Route::prefix('gejala')->controller(GejalaController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    Route::prefix('penyakit')->controller(PenyakitController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    Route::prefix('perawatan')->controller(PerawatanController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
});
