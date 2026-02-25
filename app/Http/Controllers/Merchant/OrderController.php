<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;
        $orders = Order::where('merchant_id', $merchant->id)->latest()->paginate(10);
        return view('merchant.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        $merchant = auth()->user()->merchant;
        abort_if($order->merchant_id !== $merchant->id, 403);

        $order->load(['customer', 'items']);
        return view('merchant.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $merchant = auth()->user()->merchant;
        abort_if($order->merchant_id !== $merchant->id, 403);

        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,delivered,canceled',
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Status order berhasil diubah.');
    }


}