<?php

namespace App\Observers;

use App\Models\ProductVariant;
use App\Models\Product;

class ProductVariantObserver
{
    /**
     * Handle the ProductVariant "created" event.
     */
    public function created(ProductVariant $productVariant): void
    {
        $this->syncTotalStock($productVariant->product_id);
    }

    /**
     * Handle the ProductVariant "updated" event.
     */
    public function updated(ProductVariant $productVariant): void
    {
        $this->syncTotalStock($productVariant->product_id);
    }

    /**
     * Handle the ProductVariant "deleted" event.
     */
    public function deleted(ProductVariant $productVariant): void
    {
        $this->syncTotalStock($productVariant->product_id);
    }

    /**
     * Re-calculate the total stock for the parent product.
     */
    protected function syncTotalStock($productId): void
    {
        $product = Product::find($productId);
        if ($product) {
            $totalStock = ProductVariant::where('product_id', $productId)->sum('stock');
            $product->update(['stock' => $totalStock]);

            // Also sync JSON color_stock for backward compatibility with older UI parts
            $variants = ProductVariant::where('product_id', $productId)->get();
            $colorStockMap = [];
            foreach ($variants as $v) {
                // If the product detail page still looks at color_stock JSON, we keep it in sync
                $colorStockMap[$v->color] = ($colorStockMap[$v->color] ?? 0) + $v->stock;
            }
            $product->update(['color_stock' => $colorStockMap]);
        }
    }
}
