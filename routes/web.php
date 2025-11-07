<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register; 
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Usuarios\Index as UsuariosIndex;
use App\Livewire\Brands\Index as BrandsIndex;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/usuarios', UsuariosIndex::class)->name('usuarios.index');
    Route::get('/marcas', BrandsIndex::class)->name('brands.index');
});

// Ruta para el Registro
Route::get('/register', Register::class)->name('register');

// Ruta para el Inicio de Sesión
Route::get('/login', Login::class)->name('login');