<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $table = 'buys';

    protected $fillable = [
        'user_id',
        'payment_id',
        'state',
        'total',
        'amount_products'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function buyProducts()
    {
        return $this->hasMany(BuyProduct::class);
    }

}
