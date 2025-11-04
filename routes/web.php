<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Página principal
Route::get('/', fn() => view('welcome'))->name('welcome');

// Área autenticada
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Ejemplo: componente Volt solo para usuarios autenticados
    Volt::route('/users', 'users.index')->name('users.index');
});

// Rutas de autenticación separadas
require __DIR__ . '/auth.php';