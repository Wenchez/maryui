<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register; 
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Usuarios\Index as UsuariosIndex;
use App\Livewire\Brands\Index as BrandsIndex;
use App\Livewire\ProductTypes\Index as ProductTypesIndex;
use App\Livewire\Products\Index as ProductsIndex;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/usuarios', UsuariosIndex::class)->name('usuarios.index');
    Route::get('/marcas', BrandsIndex::class)->name('brands.index');
    Route::get('/categorias', ProductTypesIndex::class)->name('product-types.index');
    Route::get('/productos', ProductsIndex::class)->name('products.index');
    
});

// Ruta para el Registro
Route::get('/register', Register::class)->name('register');

// Ruta para el Inicio de Sesión
Route::get('/login', Login::class)->name('login');