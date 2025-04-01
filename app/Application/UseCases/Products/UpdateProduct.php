<?php

namespace App\Application\UseCases\Products;

use App\Domain\Products\Entities\Product;
use App\Domain\Products\Entities\ProductImage;
use App\Domain\Products\Repositories\ProductImageRepositoryInterface;
use App\Domain\Products\Repositories\ProductRepositoryInterface;
use App\Domain\Products\Services\ProductImageService;

class UpdateProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductImageRepositoryInterface $productImageRepository,
        private ProductImageService             $imageService,
    )
    {
    }

    public function execute(array $data, int $id): void
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            throw new \Exception("Produto não encontrado");
        }

        $updatedProduct = new Product(
            $data['title'],
            $data['description'],
            $data['price'],
            $data['cost'],
            $id
        );

        $this->productRepository->update($updatedProduct);

        if (!empty($data['images'])) {
            $paths = $this->imageService->processUploadedImages($data['images']);

            foreach ($paths as $path) {
                $productImage = new ProductImage($updatedProduct->getId(), $path);
                $this->productImageRepository->save($productImage);
            }
        }

    }
}
