<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function index()
    {
        $cart = Session::get('cart', []);
        // dd($cart);
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');


        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $request->input('product_name'),
                'price' => $request->input('product_price'),
                'photo' => $request->input('product_photo'),
                'quantity' => $quantity
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function updateQuantity(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;

            Session::put('cart', $cart);
        }

        $updateItem = [
            'success' => true,
            'item' => $cart[$request->id]
        ];
        // dd($updateItem);
        return response()->json($updateItem);
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);

            Session::put('cart', $cart);
        }

        $removeItem = [
            'success' => true,
            'message' => 'Item removed successfully'
        ];
        return response()->json($removeItem);
    }
}
