<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', auth()->id())->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        abort_if($order->customer_id !== auth()->id(), 403);

        $order->load(['merchant', 'items']);
        return view('customer.orders.show', compact('order'));
    }
}