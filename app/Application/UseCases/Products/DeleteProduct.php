<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Repositories\ProductRepositoryInterface;

class DeleteProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(int $id): void
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new \Exception("Produto não encontrado");
        }

        $this->productRepository->delete($id);
    }
}
