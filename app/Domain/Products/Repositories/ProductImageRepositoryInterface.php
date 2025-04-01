<?php

namespace App\Domain\Products\Repositories;


use App\Domain\Products\Entities\ProductImage;

interface ProductImageRepositoryInterface
{
    public function save(ProductImage $image): void;
    public function delete(int $id): void;
    public function findByProductId(int $productId): array;
}
