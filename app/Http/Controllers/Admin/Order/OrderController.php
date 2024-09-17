<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $perPage = 25;

        $orders = Order::latest()->paginate($perPage);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $getorder = Order::findOrFail($order->id);
        return view('admin.orders.show', compact('getorder'));
    }

    public function destroy(Order $order)
    {
        $getorder = Order::findOrFail($order->id);
        $getorder->delete();
        return redirect('admin/brands')->with('flash_message', 'Категория удалена');
    }
}
