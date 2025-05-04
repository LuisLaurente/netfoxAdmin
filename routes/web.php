<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación ya están configuradas por Laravel Breeze

// Rutas protegidas con autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('cuentas.index');
    })->name('dashboard');
    
    Route::resource('cuentas', CuentaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('historial', HistorialController::class)->only(['index', 'show']);
    
    // Ruta para transferir usuarios entre cuentas
    Route::post('usuarios/{usuario}/transferir', [UsuarioController::class, 'transferir'])->name('usuarios.transferir');
    
    // Rutas de perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';