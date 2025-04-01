<?php

namespace App\Domain\Products\Entities;

class ProductImage
{
    private string $path;
    private int $productId;
    private ?int $id;

    public function __construct(int $productId, string $path, ?int $id = null)
    {
        $this->productId = $productId;
        $this->path = $path;
        $this->id = $id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
