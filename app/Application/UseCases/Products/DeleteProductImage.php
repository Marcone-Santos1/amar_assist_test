<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Repositories\ProductImageRepositoryInterface;

class DeleteProductImage
{
    private ProductImageRepositoryInterface $productImageRepository;

    public function __construct(ProductImageRepositoryInterface $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }

    public function execute(int $imageId): void
    {
        $this->productImageRepository->delete($imageId);
    }
}
