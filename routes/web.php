<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('product.index');
});


// すべてのリクエストをVueアプリケーションにリダイレクトする
Route::get('/{any}', function () {
  return view('product.index');
})->where('any', '.*');
