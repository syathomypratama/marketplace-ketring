<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;
        $menus = \App\Models\Menu::where('merchant_id', $merchant->id)
            ->latest()
            ->paginate(10);
        return view('merchant.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('merchant.menus.create');
    }

    public function store(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('menus', 'public');
        }

        Menu::create([
            'merchant_id' => $merchant->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'category' => $data['category'] ?? null,
            'photo_path' => $path,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('merchant.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $merchant = auth()->user()->merchant;
        abort_if($menu->merchant_id !== $merchant->id, 403);

        return view('merchant.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $merchant = auth()->user()->merchant;
        abort_if($menu->merchant_id !== $merchant->id, 403);

        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($menu->photo_path)
                Storage::disk('public')->delete($menu->photo_path);
            $menu->photo_path = $request->file('photo')->store('menus', 'public');
        }

        $menu->name = $data['name'];
        $menu->description = $data['description'] ?? null;
        $menu->price = $data['price'];
        $menu->category = $data['category'] ?? null;
        $menu->is_active = $request->boolean('is_active', false);

        $menu->save();

        return redirect()->route('merchant.menus.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $merchant = auth()->user()->merchant;
        abort_if($menu->merchant_id !== $merchant->id, 403);

        if ($menu->photo_path)
            Storage::disk('public')->delete($menu->photo_path);
        $menu->delete();

        return back()->with('success', 'Menu dihapus.');
    }
}
