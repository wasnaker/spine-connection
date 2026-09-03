<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Connection\Http\Controllers\ConnectionController;

/*
|--------------------------------------------------------------------------
| ROUTE MODUL Connection (konvensi core: api/v1 + auth:sanctum)
|--------------------------------------------------------------------------
|   /api/v1/connections
|     GET    /                        connection:view    (daftar milik entity)
|     POST   /                        connection:create  (generate link)
|     GET    /{token}                 connection:view    (info link pending)
|     POST   /{token}/approve         connection:approve (approve link)
|     POST   /{id}/cancel             connection:cancel  (batalkan pending)
|*/

Route::prefix('api/v1')->middleware('auth:sanctum')->group(function () {
    Route::prefix('connections')->group(function () {
        Route::get('/', [ConnectionController::class, 'index'])->middleware('permission:connection:view');
        Route::post('/', [ConnectionController::class, 'store'])->middleware('permission:connection:create');
        Route::get('/{token}', [ConnectionController::class, 'show'])->middleware('permission:connection:view');
        Route::post('/{token}/approve', [ConnectionController::class, 'approve'])->middleware('permission:connection:approve');
        Route::post('/{id}/cancel', [ConnectionController::class, 'cancel'])->whereNumber('id')->middleware('permission:connection:cancel');
    });
});
