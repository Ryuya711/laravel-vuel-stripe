<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\LineItem;

class LineItemController extends Controller
{
    public function create(Request $request)
    {
        $cart_id = Session::get('cart');
        $line_item = LineItem::where('cart_id', $cart_id)
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($line_item) {
            $line_item->quantity += $request->input('quantity');
            $line_item->save();
        } else {
            $line_item = LineItem::create([
                'cart_id' => $cart_id,
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
            ]);
        }

        return response()->json(['line_item' => $line_item]);
    }

    public function destroy(LineItem $lineItem)
    {
        $lineItem->delete();
        return response()->json(['message' => 'Item removed successfully']);
    }
}

