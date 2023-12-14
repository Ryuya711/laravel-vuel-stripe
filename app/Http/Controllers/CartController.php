<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cart_id = Session::get('cart');
        $cart = Cart::with('products')->find($cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $line_items = $cart->products->map(function ($product) {
            return [
                'id' => $product->pivot->id, 
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'subtotal' => $product->price * $product->pivot->quantity,
            ];
        });

        $total_price = $line_items->sum('subtotal');

        return response()->json([
            'line_items' => $line_items,
            'total_price' => $total_price,
        ]);
    }

    public function checkout() 
    {
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $line_items = [];
        foreach ($cart->products as $product) {
            $line_item = [
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $product->price,
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->description,
                    ],
                ],
                'quantity' => $product->pivot->quantity,
            ];
            array_push($line_items, $line_item);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $line_items,
            'success_url'          => env('APP_URL') . '/cart',
            'cancel_url'           => env('APP_URL') . '/cart',
            'mode'                 => 'payment',
        ]);

        return response()->json([
            'sessionId' => $session->id,
            'publicKey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }
}

