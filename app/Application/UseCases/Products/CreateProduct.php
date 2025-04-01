<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Entities\Product;
use App\Domain\Products\Entities\ProductImage;
use App\Domain\Products\Repositories\ProductImageRepositoryInterface;
use App\Domain\Products\Repositories\ProductRepositoryInterface;
use App\Domain\Products\Services\ProductImageService;

class CreateProduct
{
    public function __construct(
        private ProductRepositoryInterface      $productRepository,
        private ProductImageRepositoryInterface $productImageRepository,
        private ProductImageService             $imageService,
    )
    {
    }

    public function execute(array $data): void
    {
        $product = new Product(
            $data['title'],
            $data['description'],
            $data['price'],
            $data['cost'],
        );

        $this->productRepository->save($product);

        if (!empty($data['images'])) {
            $paths = $this->imageService->processUploadedImages($data['images']);

            foreach ($paths as $path) {
                $productImage = new ProductImage($product->getId(), $path);
                $this->productImageRepository->save($productImage);
            }
        }
    }
}
