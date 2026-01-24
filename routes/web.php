<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/_debug/clear-org', function () {
    session()->forget('current_organisation_id');

    return 'Org cleared';
});

require __DIR__.'/auth.php';
