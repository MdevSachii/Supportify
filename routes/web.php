<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerController::class, 'index'])->name('customer');

Route::prefix('ticket')->group(function () {
    Route::post('create', [TicketController::class, 'create'])->name('ticket.create');
    Route::get('all', [TicketController::class, 'all'])->name('ticket.all');
    Route::get('get/{id}', [TicketController::class, 'get'])->name('ticket.get');
    Route::put('open/{id}', [TicketController::class, 'open'])->name('ticket.open');
    Route::post('open', [TicketController::class, 'reply'])->name('ticket.reply');
});

Route::middleware(['auth', 'verified'])->prefix('agent')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('agent');
});

require __DIR__.'/auth.php';
