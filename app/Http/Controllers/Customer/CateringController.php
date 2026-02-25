<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Menu;
use Illuminate\Http\Request;

class CateringController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $city = trim((string) $request->query('city', ''));
        $category = trim((string) $request->query('category', ''));

        $merchants = Merchant::query()
            // filter kota
            ->when($city !== '', fn($q) => $q->where('city', $city))

            // keyword cari di company_name / description
            ->when($keyword !== '', function ($q) use ($keyword) {
                $q->where(function ($w) use ($keyword) {
                    $w->where('company_name', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            })

            // filter kategori menu (jenis makanan)
            ->when($category !== '', function ($q) use ($category) {
                $q->whereHas('menus', function ($m) use ($category) {
                    $m->where('is_active', true)
                        ->where('category', $category);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // opsi dropdown filter (ambil dari DB)
        $cities = Merchant::query()->select('city')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $categories = Menu::query()->select('category')->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('customer.caterings.index', compact('merchants', 'cities', 'categories', 'keyword', 'city', 'category'));
    }

    public function show(Merchant $merchant)
    {
        $menus = $merchant->menus()
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('customer.caterings.show', compact('merchant', 'menus'));
    }
}