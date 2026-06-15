<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PolicyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/policies', [ApiController::class, 'policies']);
    Route::post('/policies', [ApiController::class, 'addPolicy']);
    Route::get('/policies/{policy}', [ApiController::class, 'policyDetails']);
    Route::get('/policy-types', [ApiController::class, 'getPolicyTypes']);
    Route::post('/queries', [ApiController::class, 'raiseQuery']);
    Route::get('/queries', [ApiController::class, 'queries']);
    
    // Document upload endpoint - for mobile app and web clients
    Route::post('/policies/{policy}/documents', [ApiController::class, 'uploadDocument']);
});
