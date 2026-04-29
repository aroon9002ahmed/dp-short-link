<?php

use App\Http\Controllers\Front\ShortLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Short link redirection (keep this as the last route)
Route::get('/{shortCode}', [ShortLinkController::class, 'redirect'])
    ->name('short-link.redirect')
    ->where('shortCode', '[A-Za-z0-9]{6}');
