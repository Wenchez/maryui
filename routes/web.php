<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register; 
use App\Livewire\Auth\Login;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

// Ruta para el Registro
Route::get('/register', Register::class)->name('register');

// Ruta para el Inicio de Sesión
Route::get('/login', Login::class)->name('login');