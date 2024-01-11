<?php

use App\Http\Controllers\Backoffice\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/backoffice')
    ->middleware(['auth', 'prevent-back-history', 'permission'])
    ->group(function () {
        Route::resource('pengguna', UserController::class)->parameters(['pengguna' => 'user']);
    });
