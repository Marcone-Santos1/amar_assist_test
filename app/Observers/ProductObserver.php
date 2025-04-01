<?php

namespace App\Observers;

use App\Models\Product;
use Spatie\Activitylog\ActivityLogger;

class ProductObserver
{

    public function __construct(
        private ActivityLogger $logger
    )
    {
    }

    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->logger->performedOn($product)
            ->withProperties([
                'attributes' => $product->getAttributes(),
                'custom' => ['ip' => request()->ip()]
            ])
            ->event('created')
            ->log('Produto criado');
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $changes = $product->getChanges();

        $this->logger->performedOn($product)
            ->withProperties([
                'old' => $product->getOriginal(),
                'attributes' => $changes,
                'custom' => ['ip' => request()->ip()]
            ])
            ->event('updated')
            ->log('Produto atualizado');
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $this->logger->performedOn($product)
            ->withProperties([
                'attributes' => $product->getOriginal(),
                'custom' => ['ip' => request()->ip()]
            ])
            ->event('deleted')
            ->log('Produto removido');
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
