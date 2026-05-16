<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContaPagarController;
use App\Http\Controllers\ContaReceberController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RelatorioFinanceiroController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas públicas
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('contas_pagar', ContaPagarController::class);

    Route::resource('contas_receber', ContaReceberController::class);

    Route::resource('cliente', ClienteController::class);
    Route::patch('/cliente/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])
        ->name('cliente.toggleStatus');

    Route::resource('fornecedor', FornecedorController::class);
    Route::patch('/fornecedor/{fornecedor}/toggle-status', [FornecedorController::class, 'toggleStatus'])
        ->name('fornecedor.toggleStatus');

    Route::resource('configuracao.usuarios', UserController::class);
    Route::patch('/configuracao.usuarios/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('configuracao.usuarios.toggleStatus');

    // Rotas de Relatórios Financeiros
    Route::prefix('relatorios')->group(function () {
        Route::get('/financeiro', [RelatorioFinanceiroController::class, 'index'])->name('relatorios.financeiro.index');
        Route::get('/financeiro/listar', [RelatorioFinanceiroController::class, 'listar'])->name('relatorios.financeiro.listar');
        Route::get('/financeiro/por-mes', [RelatorioFinanceiroController::class, 'porMes'])->name('relatorios.financeiro.porMes');
        Route::get('/financeiro/por-fornecedor', [RelatorioFinanceiroController::class, 'porFornecedor'])->name('relatorios.financeiro.porFornecedor');
        Route::get('/financeiro/por-cliente', [RelatorioFinanceiroController::class, 'porCliente'])->name('relatorios.financeiro.porCliente');
        Route::get('/financeiro/atrasos', [RelatorioFinanceiroController::class, 'atrasos'])->name('relatorios.financeiro.atrasos');
        Route::get('/financeiro/exportar-json', [RelatorioFinanceiroController::class, 'exportarJSON'])->name('relatorios.financeiro.exportarJSON');
    });
});