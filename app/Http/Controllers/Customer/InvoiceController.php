<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function show(\App\Models\Order $order)
    {
        abort_if($order->customer_id !== auth()->id(), 403);

        $order->load(['merchant', 'customer', 'items']);
        return view('customer.invoices.show', compact('order'));
    }
}
