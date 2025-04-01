<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreProduct()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        // Simula o upload de uma imagem
        Storage::fake('public');

        $image = UploadedFile::fake()->image('product.jpg');

        // Dados do produto
        $productData = [
            'title' => 'Produto Teste',
            'description' => '<p>Descrição do produto</p>',
            'price' => 150.00,
            'cost' => 100.00,
            'images' => [$image],
        ];

        // Envia a requisição POST para armazenar o produto
        $response = $this->post(route('products.store'), $productData);

        // Verifica se o produto foi criado no banco de dados
        $this->assertDatabaseHas('products', [
            'title' => 'Produto Teste',
            'description' => '<p>Descrição do produto</p>',
            'price' => 150.00,
            'cost' => 100.00,
        ]);

        // Obtém o produto salvo
        $product = Product::where('title', 'Produto Teste')->first();
        $this->assertNotNull($product);

        // Verifica se a imagem foi salva corretamente no banco de dados
        $this->assertDatabaseHas('product_images', [
            'product_id' => $product->id,
        ]);

        // Obtém a imagem salva
        $savedImage = ProductImage::where('product_id', $product->id)->first();
        $this->assertNotNull($savedImage);

        // Verifica se a imagem foi realmente salva no storage
        Storage::disk('public')->assertExists($savedImage->path);

        // Verifica se o redirecionamento ocorreu corretamente
        $response->assertRedirect(route('products.index'));

        // Verifica se a mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Produto criado com sucesso!');
    }
}
