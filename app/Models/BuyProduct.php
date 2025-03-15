<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyProduct extends Model
{
    use HasFactory;

    protected $table = 'buy_product';

    public $timestamps = false;

    protected $fillable = [
        'buy_id',
        'product_id',
        'price_product',
        'amount'
    ];

    public function buy()
    {
        return $this->belongsTo(Buy::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
