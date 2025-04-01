<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Repositories\ProductRepositoryInterface;

class GetProductList
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(): array
    {
        return $this->productRepository->getAll();
    }
}
