<?php

use Illuminate\Support\Facades\Route;

Route::get('/{id?}', function ($id = null) {
    return view('welcome', ['id' => $id]);
});

