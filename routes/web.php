<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('customer');

Route::prefix('ticket')->group(function () {
    Route::post('create', [TicketController::class, 'create'])->name('ticket.create');
});

Route::middleware(['auth', 'verified'])->prefix('agent')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('agent');
});

require __DIR__.'/auth.php';
