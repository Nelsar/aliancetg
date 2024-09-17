<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

class CartController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validated();

        if($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validate->errors()
            ]);
        }

        $getrequest = $request->all();

        /*Find User */
        $user = User::findOrFail($getrequest['user_id']);

        /*Find Product */
        $product = Product::findOrFail($getrequest['product_id']);

        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $product->id;

        $result = $cart->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart created successfully',
            'data' => $result
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getcart = Cart::findOrFail($id);
        return new CartResource($getcart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validated();

        if($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validate->errors()
            ]);
        }

        $getrequest = $request->all();

        /*Find User */
        $user = User::findOrFail($getrequest['user_id']);

        /*Find Product */
        $product = Product::findOrFail($getrequest['product_id']);

        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $product->id;

        $result = $cart->update();

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'data' => $result
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getbrand = Brand::findOrFail($id);
        $getbrand->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully'
        ], 204);
    }
}
