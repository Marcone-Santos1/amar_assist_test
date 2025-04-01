<?php

namespace App\Domain\Products\Repositories;

use App\Models\Product as EloquentProduct;
use App\Domain\Products\Entities\Product;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(Product $product): void
    {
        $eloquentProduct = EloquentProduct::create([
            'title' => $product->getTitle(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'cost' => $product->getCost(),
        ]);

        // Setar o ID do produto recém-criado
        $product->setId($eloquentProduct->id);
    }

    public function update(Product $product): void
    {
        $eloquentProduct = EloquentProduct::findOrFail($product->getId());
        $eloquentProduct->update([
            'title' => $product->getTitle(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'cost' => $product->getCost(),
        ]);

        $product->setId($eloquentProduct->id);
    }

    public function delete(int $id): void
    {
        EloquentProduct::where('id', $id)->update(['active' => false]);
    }

    public function getAll(): array
    {
        return EloquentProduct::where('active', true)->get()->toArray();
    }

    public function findById(int $id): array
    {
        return EloquentProduct::with('images')->findOrFail($id)->toArray();
    }
}
