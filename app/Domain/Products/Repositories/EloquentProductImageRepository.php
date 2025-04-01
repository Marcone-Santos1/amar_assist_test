<?php

namespace App\Domain\Products\Repositories;

use App\Models\ProductImage as EloquentProductImage;
use App\Domain\Products\Entities\ProductImage;
use Illuminate\Support\Facades\Storage;

class EloquentProductImageRepository implements ProductImageRepositoryInterface
{
    public function save(ProductImage $image): void
    {
        EloquentProductImage::create([
            'product_id' => $image->getProductId(),
            'path' => $image->getPath(),
        ]);
    }

    public function delete(int $id): void
    {
        $image = EloquentProductImage::findOrFail($id);

        Storage::disk('public')->delete($image->path);

        $image->delete();
    }

    public function findByProductId(int $productId): array
    {
        $images = EloquentProductImage::where('product_id', $productId)->get();

        return $images->map(function ($image) {
            return $image->toArray();
        })->toArray();
    }
}
