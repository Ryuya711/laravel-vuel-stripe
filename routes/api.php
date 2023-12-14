<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LineItemController;
use App\Http\Controllers\CartController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products', ProductController::class);

// routes/web.php または routes/api.php
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/carts', [CartController::class, 'index'])->name('cart.index');


Route::post('/line-items', [LineItemController::class, 'create']);

// カートの内容を取得する
Route::get('/cart', [CartController::class, 'index']);

// カート内の特定の商品を更新する
Route::patch('/line-items/{lineItem}', [LineItemController::class, 'update']);

// カート内の商品を削除する
Route::delete('/line-items/{lineItem}', [LineItemController::class, 'destroy']);

// 決済画面へのルート定義
Route::get('/cart/checkout', [CartController::class, 'checkout']);