<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $merchants = Merchant::latest()->take(8)->get();

        $menuPreview = Menu::query()
            ->whereIn('merchant_id', $merchants->pluck('id'))
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('merchant_id');
        return view('customer.dashboard', compact('merchants', 'menuPreview'));
    }
}
