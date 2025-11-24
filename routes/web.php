<?php

use App\Http\Controllers\CMS\GejalaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.user');
});
Route::get('/gejala', function () {
    return view('pages.gejala');
});

// Route api

Route::prefix('naive-bayes')->group(function () {
    // Routes gejala
    Route::prefix('gejala')->controller(GejalaController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
});
