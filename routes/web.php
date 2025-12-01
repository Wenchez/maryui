<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register; 
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Usuarios\Index as UsuariosIndex;
use App\Livewire\Brands\Index as BrandsIndex;
use App\Livewire\ProductTypes\Index as ProductTypesIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Sales\Index as SalesIndex;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', UsuariosIndex::class)->name('index');
    });

    Route::prefix('marcas')->name('brands.')->group(function () {
        Route::get('/', BrandsIndex::class)->name('index');
    });

    Route::prefix('categorias')->name('product-types.')->group(function () {
        Route::get('/', ProductTypesIndex::class)->name('index');
    });

    Route::prefix('productos')->name('products.')->group(function () {
        Route::get('/', ProductsIndex::class)->name('index');
    });

    Route::prefix('ventas')->name('sales.')->group(function () {
        Route::get('/', SalesIndex::class)->name('index');
    });
});


// Ruta para el Registro
Route::get('/register', Login::class)->name('register');

// Ruta para el Inicio de Sesión
Route::get('/login', Login::class)->name('login');