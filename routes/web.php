<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('customer');

Route::prefix('customer')->group(function () {
    //
});

Route::middleware(['auth', 'verified'])->prefix('agent')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('agent');
});

require __DIR__.'/auth.php';
