<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/api')->middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Listar todos os produtos
        Route::get('/{id}', [ProductController::class, 'show'])->name('products.show'); // Mostrar produto por ID
        Route::post('/', [ProductController::class, 'store'])->name('products.store'); // Criar novo produto
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update'); // Atualizar produto existente
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Inativar produto (soft delete)
    });

});

