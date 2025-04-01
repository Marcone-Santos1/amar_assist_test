<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Products\DeleteProductImage;
use App\Application\UseCases\Products\ListProductImages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ProductImageController extends Controller
{
    public function index(ListProductImages $listProductImages, int $productId): JsonResponse
    {
        $images = $listProductImages->execute($productId);
        return response()->json($images);
    }

    public function destroy(DeleteProductImage $deleteProductImage, int $imageId): RedirectResponse
    {
        $deleteProductImage->execute($imageId);
        return back()
            ->with('success', 'Imagem excluída com sucesso');
    }
}
