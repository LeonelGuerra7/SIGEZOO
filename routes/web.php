<?php

use App\Http\Controllers\ProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

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
    // Route::resource('limpieza', LimpiezaController::class);
    // Route::resource('alimentacion', AlimentacionController::class);
    // Route::resource('control-clinico', ControlClinicoController::class);
});

// Módulo público de entradas y promociones (portal para visitantes).
Route::prefix('entradas')->group(function () {
    // Route::get('/', [EntradasController::class, 'index'])->name('entradas.index');
});

require __DIR__.'/auth.php';
