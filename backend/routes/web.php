<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin & Policy Officer (for client management)
    Route::middleware('role:admin,policy_officer')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Admin & Policy Officer only (Policies, Docs, Queries)
    Route::middleware('role:admin,policy_officer')->group(function () {
        Route::resource('policies', PolicyController::class);
        Route::post('policies/{policy}/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        
        Route::get('queries', [QueryController::class, 'index'])->name('queries.index');
        Route::get('queries/{query}', [QueryController::class, 'show'])->name('queries.show');
        Route::patch('queries/{query}', [QueryController::class, 'update'])->name('queries.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/sop', function () {
        return view('sop');
    })->name('sop');
});

require __DIR__.'/auth.php';
