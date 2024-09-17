<?php

namespace App\Http\Controllers\Admin\Cart;

use App\Models\Cart;
use App\Http\Controllers\Controller;


class CartController extends Controller
{
    public function index()
    {
        $perPage = 25;
        $carts = Cart::latest()->paginate($perPage);
        return view('admin.carts.index', compact('carts'));
    }

    public function show (Cart $cart)
    {
        $getcart = Cart::findOrFail($cart->id);
        return view('admin.carts.show', compact('getcart'));
    }
}
