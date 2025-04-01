<?php


use App\Domain\Products\Entities\Product;
use App\Domain\Products\Entities\ProductImage;
use PHPUnit\Framework\TestCase;

class ProductImageTest extends TestCase
{
    public function testCreateProductImageWithoutId()
    {
        // Teste criando a imagem do produto sem id
        $productImage = new ProductImage(1, '/images/product1.jpg');

        $this->assertInstanceOf(ProductImage::class, $productImage);
        $this->assertEquals(1, $productImage->getProductId());
        $this->assertEquals('/images/product1.jpg', $productImage->getPath());
        $this->assertNull($productImage->getId());
    }

    public function testCreateProductImageWithId()
    {
        // Teste criando a imagem do produto com id
        $productImage = new ProductImage(1, '/images/product2.jpg', 123);

        $this->assertInstanceOf(ProductImage::class, $productImage);
        $this->assertEquals(1, $productImage->getProductId());
        $this->assertEquals('/images/product2.jpg', $productImage->getPath());
        $this->assertEquals(123, $productImage->getId());
    }
}
