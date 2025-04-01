<?php

namespace App\Domain\Products\Entities;

use DomainException;

class Product
{
    private string $title;
    private string $description;
    private float $price;
    private float $cost;
    private ?int $id;

    public function __construct(string $title, string $description, float $price, float $cost, ?int $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->cost = $cost;
        $this->validate();
        $this->id = $id;
    }

    private function validate(): void
    {
        if (bccomp($this->price, $this->cost * 1.1, 2) < 0) {
            throw new \DomainException("O preço não pode ser inferior ao custo + 10%");
        }
    }

    // Getters
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }
}
