<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContaPagarController;
use App\Http\Controllers\ContaReceberController;

Route::get('/', function () {
    return redirect()->route('index');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('contas_pagar', ContaPagarController::class);
Route::resource('contas_receber', ContaReceberController::class);
