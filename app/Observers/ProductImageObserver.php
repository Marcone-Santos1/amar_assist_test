<?php

namespace App\Observers;

use App\Models\ProductImage;
use Spatie\Activitylog\ActivityLogger;

class ProductImageObserver
{


    public function __construct(
        private ActivityLogger $logger
    )
    {
    }


    /**
     * Handle the ProductImage "created" event.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return void
     */
    public function created(ProductImage $productImage)
    {
        $this->logger->performedOn($productImage)
            ->withProperties([
                'product_id' => $productImage->getProductId(),
                'path' => $productImage->getPath(),
                'custom' => ['ip' => request()->ip()]
            ])
            ->event('image_created')
            ->log('Imagem do produto adicionada');
    }

    /**
     * Handle the ProductImage "updated" event.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return void
     */
    public function updated(ProductImage $productImage)
    {
        //
    }

    /**
     * Handle the ProductImage "deleted" event.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return void
     */
    public function deleted(ProductImage $productImage)
    {
        $this->logger->performedOn($productImage)
            ->withProperties([
                'product_id' => $productImage->getProductId(),
                'path' => $productImage->getPath(),
                'custom' => ['ip' => request()->ip()]
            ])
            ->event('image_deleted')
            ->log('Imagem do produto removida');
    }

    /**
     * Handle the ProductImage "restored" event.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return void
     */
    public function restored(ProductImage $productImage)
    {
        //
    }

    /**
     * Handle the ProductImage "force deleted" event.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return void
     */
    public function forceDeleted(ProductImage $productImage)
    {
        //
    }
}
