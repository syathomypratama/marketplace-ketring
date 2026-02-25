<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function show(\App\Models\Order $order)
    {
        $merchant = auth()->user()->merchant;
        abort_if($order->merchant_id !== $merchant->id, 403);

        $order->load(['merchant', 'customer', 'items']);
        return view('merchant.invoices.show', compact('order'));
    }
}
