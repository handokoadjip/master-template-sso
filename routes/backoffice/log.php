<?php

use App\Http\Controllers\Backoffice\LogController;
use Illuminate\Support\Facades\Route;

Route::prefix('/backoffice')
    ->middleware(['sso.auth', 'prevent-back-history', 'permission'])
    ->group(function () {
        Route::resource('log', LogController::class)->except([
            'show'
        ])->parameters(['log' => 'log']);
    });
