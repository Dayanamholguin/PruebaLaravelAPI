<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ShowProduct;

Route::get('/', function () {
    return redirect()->route('products');
});

Route::get('/products', ShowProduct::class)->name('products');
