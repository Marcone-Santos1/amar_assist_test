<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route:: prefix('/profile')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/products')->as('products.')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('index'); // Lista de produtos
        Route::get('/create', [ProductController::class, 'create'])->name('create'); // Formulário de criação de produto
        Route::post('/', [ProductController::class, 'store'])->name('store'); // Criação de produto
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit'); // Formulário de edição de produto
        Route::put('/{id}', [ProductController::class, 'update'])->name('update'); // Atualização de produto
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy'); // Inativar produto

        Route::get('/{productId}/images', [ProductImageController::class, 'index'])->name('images.index');
        Route::delete('/images/{imageId}', [ProductImageController::class, 'destroy'])->name('images.destroy');



    });

});

require __DIR__.'/auth.php';
