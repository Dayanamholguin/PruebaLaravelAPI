<?php

namespace App\DTOs;

class BuyResponseDTO
{
    public $user;
    public $products;
    public $state;
    public $total;
    public $payment;

    public function __construct($user, $products, $state, $total, $payment)
    {
        $this->user = $user;
        $this->products = $products;
        $this->state = $state;
        $this->total = $total;
        $this->payment = $payment;
    }

    public static function formatProducts($buyProducts)
    {
        return $buyProducts->map(function($buyProduct) {
            return [
                'name' => $buyProduct->product->name,
                'price' => number_format($buyProduct->price_product, $buyProduct->price_product == floor($buyProduct->price_product) ? 0 : 2, ',', '.'),
                'amount' => $buyProduct->amount,
            ];
        });
    }

    public static function fromBuy($buy)
    {
        $products = self::formatProducts($buy->buyProducts);

        return new self(
            $buy->user->name,
            $products,
            $buy->state,
            number_format($buy->total, $buy->total == floor($buy->total) ? 0 : 2, ',', '.'),
            $buy->payment->name
        );
    }
}
