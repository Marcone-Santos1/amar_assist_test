<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Products\CreateProduct;
use App\Application\UseCases\Products\UpdateProduct;
use App\Application\UseCases\Products\DeleteProduct;
use App\Application\UseCases\Products\GetProductList;
use App\Application\UseCases\Products\GetProductById;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(GetProductList $getProductList): Response
    {
        $products = $getProductList->execute();
        return Inertia::render('Products/Index', ['products' => $products]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(ProductRequest $request, CreateProduct $createProduct): RedirectResponse
    {
        try {
            $createProduct->execute($request->validated());
            return redirect()->route('products.index')
                ->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar produto: ' . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function edit($id, GetProductById $getProductById): Response
    {
        try {
            $product = $getProductById->execute($id);
            return Inertia::render('Products/Edit', [
                'product' => $product
            ]);
        } catch (\Exception $e) {
            abort(404, 'Produto não encontrado');
        }
    }

    /**
     * @throws \Exception
     */
    public function update(ProductRequest $request, $id, UpdateProduct $updateProduct): RedirectResponse
    {
        try {
            $updateProduct->execute($request->validated(), $id);
            return redirect()->route('products.index')
                ->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar produto: ' . $e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function destroy($id, DeleteProduct $deleteProduct): RedirectResponse
    {
        try {
            $deleteProduct->execute($id);
            return redirect()->route('products.index')
                ->with('success', 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }
}
