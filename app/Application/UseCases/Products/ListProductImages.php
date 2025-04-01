<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Repositories\ProductImageRepositoryInterface;

class ListProductImages
{
    private ProductImageRepositoryInterface $productImageRepository;

    public function __construct(ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function execute(int $productId): array
    {
        // Chama o repositório para obter todas as imagens do produto
        return $this->productImageRepository->findByProductId($productId);
    }
}
