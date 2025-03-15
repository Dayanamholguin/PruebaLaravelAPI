<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = ['name'];

    public $timestamps = false;

    public function buys()
    {
        return $this->hasMany(Buy::class);
    }
}
