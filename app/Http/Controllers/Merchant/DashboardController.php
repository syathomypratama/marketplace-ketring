<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;

        $stats = [
            'menus_total' => Menu::where('merchant_id', $merchant->id)->count(),
            'orders_total' => Order::where('merchant_id', $merchant->id)->count(),
            'orders_pending' => Order::where('merchant_id', $merchant->id)->where('status', 'pending')->count(),
            'revenue_total' => (float) Order::where('merchant_id', $merchant->id)->whereIn('status', ['confirmed', 'processing', 'delivered'])->sum('total'),
        ];

        $latestOrders = Order::where('merchant_id', $merchant->id)->latest()->take(8)->get();
        return view('merchant.dashboard', [
            'merchant' => $merchant,
            'stats' => $stats,
            'latestOrders' => $latestOrders,

        ]);

    }
}