<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.user');
});
Route::get('/gejala', function () {
    return view('pages.gejala');
});
