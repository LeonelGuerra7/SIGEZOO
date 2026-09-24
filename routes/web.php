<?php

use App\Http\Controllers\Alimentacion\AlimentoController;
use App\Http\Controllers\Entradas\EntradaController;
use App\Http\Controllers\ProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlClinico\MedicamentoController;
use App\Http\Controllers\ControlClinico\ProcedimientoClinicoController;
use App\Http\Controllers\Limpieza\TareaLimpiezaController;
use App\Http\Controllers\Alimentacion\DietaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Módulos internos: solo administrador y personal operativo.
// Cada integrante registra sus rutas de módulo dentro de este grupo.
Route::middleware(['auth', 'role:'.Role::ADMINISTRADOR.','.Role::OPERATIVO])->group(function () {
    Route::resource('limpieza', TareaLimpiezaController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::prefix('alimentacion')->name('alimentacion.')->group(function () {
        Route::resource('alimentos', AlimentoController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('dietas', DietaController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });
    // Route::resource('control-clinico', ControlClinicoController::class);
});

// Módulo público de entradas y promociones (portal para visitantes).
Route::prefix('entradas')->name('entradas.')->group(function () {
    Route::get('/', [EntradaController::class, 'index'])->name('index');
    Route::get('/comprar', [EntradaController::class, 'create'])->name('comprar');
    Route::post('/comprar', [EntradaController::class, 'store'])->name('store');
    Route::get('/confirmacion/{id}', [EntradaController::class, 'confirmacion'])->name('confirmacion');
});

Route::prefix('control-clinico')->name('control-clinico.')->group(function () {
    Route::resource('medicamentos', MedicamentoController::class)->except(['show', 'create', 'edit']);
    Route::resource('procedimientos', ProcedimientoClinicoController::class)->except(['show', 'create', 'edit']);
});

require __DIR__.'/auth.php';
