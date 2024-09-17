<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{

    public function show(string $id)
    {
        $getorder = Order::findOrFail($id);

        return new OrderResource($getorder);
    }

    public function store(StoreOrderRequest $request)
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

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $result = $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $result
        ], 201);

    }

    public function update(UpdateOrderRequest $request)
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

        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $result = $order->update();

        return response()->json([
            'status' => true,
            'message' => 'Order updated successfully',
            'data' => $result
        ], 200);
    }

    public function destroy(Order $order)
    {
        $getorder = Order::findOrFail($order->id);
        $getorder->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully'
        ], 204);
    }
}
