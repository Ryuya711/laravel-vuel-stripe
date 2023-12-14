<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class CartSession
{
    public function handle(Request $request, Closure $next)
    {

        if (!Session::has('cart')) {
            $cart = Cart::create();
            Session::put('cart', $cart->id);
        }

        return $next($request);
    }
}
