<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/policies', [ApiController::class, 'policies']);
    Route::get('/policies/{policy}', [ApiController::class, 'policyDetails']);
    Route::post('/queries', [ApiController::class, 'raiseQuery']);
    Route::get('/queries', [ApiController::class, 'queries']);
});
