<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;
        return view('merchant.profile.index', compact('merchant'));
    }
    public function edit()
    {
        $merchant = auth()->user()->merchant;
        return view('merchant.profile.index', compact('merchant'));
    }

    public function update(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $data = $request->validate([
            'company_name' => 'required|string|max:150',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'contact_person' => 'nullable|string|max:120',
            'contact_phone' => 'nullable|string|max:30',
        ]);

        $merchant->update($data);
        return redirect()->route('merchant.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}