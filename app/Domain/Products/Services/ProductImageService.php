<?php

namespace App\Domain\Products\Services;

use Illuminate\Http\UploadedFile;

class ProductImageService
{
    public function processUploadedImages(array $images): array
    {
        $paths = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $paths[] = $image->store('products/images', 'public');
            }
        }

        return $paths;
    }
}
