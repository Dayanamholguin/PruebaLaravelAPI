<?php

namespace App\Services;

use App\Models\Buy;
use App\Models\BuyProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function processPurchase($validated)
    {
        DB::beginTransaction();

        $total = 0;
        $amountProducts = 0;
        $productsToBuy = [];
        $errorProducts = [];

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);

            if (!$product) {
                $errorProducts[] = [
                    'id' => $productData['id'],
                    'message' => 'Product not foand',
                ];
                continue;
            }

            if ($product->amount_available < $productData['amount']) {
                $errorProducts[] = [
                    'id' => $productData['id'],
                    'name' => $product->name,
                    'available' => $product->amount_available,
                    'requested' => $productData['amount'],
                    'message' => 'There is note enough quantity for this product',
                ];
                continue;
            }

            $total += $product->price * $productData['amount'];
            $amountProducts += $productData['amount'];

            $productsToBuy[] = [
                'product_id' => $product->id,
                'price_product' => $product->price,
                'amount' => $productData['amount'],
                'product_name' => $product->name
            ];

            $product->decrement('amount_available', $productData['amount']);
        }

        $buy = Buy::create([
            'user_id' => $validated['user_id'],
            'payment_id' => $validated['payment'],
            'state' => 'processing',
            'total' => $total,
            'amount_products' => $amountProducts
        ]);

        foreach ($productsToBuy as $productToBuy) {
            BuyProduct::create([
                'buy_id' => $buy->id,
                'product_id' => $productToBuy['product_id'],
                'price_product' => $productToBuy['price_product'],
                'amount' => $productToBuy['amount'],
            ]);
        }

        DB::commit();

        return [
            'buy' => $buy,
            'products' => $productsToBuy,
            'errorProducts' => $errorProducts
        ];
    }
}
