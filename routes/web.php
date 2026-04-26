<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContaPagarController;
use App\Http\Controllers\ContaReceberController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;

Route::get('/', function () {
    return redirect()->route('/dashboard');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('contas_pagar', ContaPagarController::class);
Route::resource('contas_receber', ContaReceberController::class);
Route::resource('cliente', ClienteController::class);
Route::patch('/cliente/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])->name('cliente.toggleStatus');
Route::resource('fornecedor', FornecedorController::class);
Route::patch('/fornecedor/{fornecedor}/toggle-status', [FornecedorController::class, 'toggleStatus'])->name('fornecedor.toggleStatus');