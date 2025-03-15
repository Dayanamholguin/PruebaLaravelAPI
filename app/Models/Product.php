<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'amount_available'
    ];

    public $timestamps = false;

    public function buyProducts()
    {
        return $this->hasMany(BuyProduct::class, 'product_id');
    }
}
