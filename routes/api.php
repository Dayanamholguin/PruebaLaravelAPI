<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BuyController;

Route::post('buy', [BuyController::class, 'store']);
Route::get('buy/{id}', [BuyController::class, 'show']);
