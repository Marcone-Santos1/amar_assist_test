<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Domain\Products\Entities\Product;

class ProductTest extends TestCase
{
    public function test_can_create_product_with_valid_data()
    {
        $product = new Product(
            title: 'Produto Teste',
            description: 'Descrição do produto',
            price: 120.00,
            cost: 100.00
        );

        $this->assertEquals('Produto Teste', $product->getTitle());
        $this->assertEquals('Descrição do produto', $product->getDescription());
        $this->assertEquals(120.00, $product->getPrice());
        $this->assertEquals(100.00, $product->getCost());
        $this->assertNull($product->getId());
    }

    public function test_cannot_create_product_with_price_lower_than_cost_plus_10_percent()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("O preço não pode ser inferior ao custo + 10%");

        new Product(
            title: 'Produto Inválido',
            description: 'Descrição do produto',
            price: 100.00,
            cost: 110.00
        );
    }

    public function test_can_set_and_get_id()
    {
        $product = new Product(
            title: 'Produto Teste',
            description: 'Descrição do produto',
            price: 120.00,
            cost: 100.00
        );

        $product->setId(1);

        $this->assertEquals(1, $product->getId());
    }

    public function test_can_create_product_with_exactly_10_percent_margin()
    {

        $product = new Product(
            title: 'Produto Exato',
            description: 'Descrição Teste',
            price: 110.00,
            cost: 100.00
        );


        $this->assertEquals(110.00, $product->getPrice());
    }

    public function test_can_override_existing_id()
    {
        $product = new Product(
            title: 'Produto Teste',
            description: 'Descrição Teste',
            price: 120.00,
            cost: 100.00,
            id: 1
        );

        $product->setId(99);

        $this->assertEquals(99, $product->getId());
    }

    public function test_can_create_product_with_high_price_margin()
    {
        $product = new Product(
            title: 'Produto Premium',
            description: 'Descrição Teste',
            price: 2000.00,
            cost: 1000.00
        );

        $this->assertEquals(2000.00, $product->getPrice());
    }
}
