<?php

namespace App\Domain\Products\Repositories;

use App\Domain\Products\Entities\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    public function update(Product $product): void;
    public function delete(int $id): void;
    public function getAll(): array;
    public function findById(int $id): array;
}
