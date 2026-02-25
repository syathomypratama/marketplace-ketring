@extends('layouts.app', ['title' => $merchant->company_name])
@section('content')

<div style="max-width:1200px;margin:0 auto">

    {{-- HEADER MERCHANT --}}
    <div class="card" style="
        padding:18px 20px;
        border-radius:18px;
        background:#ffffff;
        border:1px solid #e5e7eb;
        box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap">
            <div style="min-width:260px">
                <h2 style="margin:0;font-size:24px;font-weight:900;color:#0f172a">
                    {{ $merchant->company_name }}
                </h2>
                <div style="margin-top:6px;color:#64748b;line-height:1.6">
                    {{ $merchant->city ?? '-' }}
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <a href="{{ route('customer.caterings.index') }}"
                   style="
                    padding:10px 14px;border-radius:12px;
                    background:#f3f4f6;color:#111827;
                    border:1px solid #e5e7eb;
                    text-decoration:none;font-weight:900;
                   ">
                    Kembali
                </a>
            </div>
        </div>

        <div style="height:1px;background:#eef2f7;margin:16px 0"></div>

        {{-- INFO MERCHANT --}}
        <div id="merchantInfoGrid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px">
            <div style="
                padding:14px 16px;border-radius:16px;
                background:#f9fafb;border:1px solid #e5e7eb;
            ">
                <div style="font-size:12px;color:#64748b;font-weight:900;margin-bottom:6px">Alamat</div>
                <div style="color:#0f172a;line-height:1.6">
                    {{ $merchant->address ?? '-' }}
                </div>
            </div>

            <div style="
                padding:14px 16px;border-radius:16px;
                background:#f9fafb;border:1px solid #e5e7eb;
            ">
                <div style="font-size:12px;color:#64748b;font-weight:900;margin-bottom:6px">Kontak</div>
                <div style="color:#0f172a;line-height:1.7">
                    <div>{{ $merchant->contact_person ?? '-' }}</div>
                    <div style="color:#64748b">{{ $merchant->contact_phone ?? '-' }}</div>
                </div>
            </div>
        </div>

        @if($merchant->description)
            <div style="
                margin-top:14px;
                padding:14px 16px;border-radius:16px;
                background:#ffffff;border:1px solid #e5e7eb;
            ">
                <div style="font-size:12px;color:#64748b;font-weight:900;margin-bottom:6px">Deskripsi</div>
                <div style="color:#0f172a;line-height:1.7">
                    {{ $merchant->description }}
                </div>
            </div>
        @endif
    </div>

    {{-- MENU + CHECKOUT --}}
    <div class="card" style="
        margin-top:14px;
        padding:18px 20px;
        border-radius:18px;
        background:#ffffff;
        border:1px solid #e5e7eb;
        box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap">
            <div>
                <h3 style="margin:0;font-size:20px;font-weight:900;color:#0f172a">Menu</h3>
                <div style="margin-top:6px;color:#64748b;line-height:1.6">
                    Atur pengiriman, lalu tentukan qty menu yang ingin dipesan.
                </div>
            </div>
        </div>

        <div style="height:1px;background:#eef2f7;margin:16px 0"></div>

        @if($menus->isEmpty())
            <div style="
                padding:16px;
                border-radius:14px;
                background:#f9fafb;
                border:1px dashed #e5e7eb;
                color:#64748b;
            ">
                Belum ada menu aktif.
            </div>
        @else
            <form method="POST" action="{{ route('customer.checkout') }}">
                @csrf
                <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">

                {{-- FORM PENGIRIMAN --}}
                <div id="shippingGrid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px">
                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">
                            Tanggal Pengiriman
                        </label>
                        <input type="date" name="delivery_date" required
                               style="
                                width:100%;
                                padding:12px 12px;
                                border-radius:14px;
                                border:1px solid #e5e7eb;
                                background:#ffffff;
                                outline:none;
                               ">
                    </div>

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">
                            Alamat Pengiriman
                        </label>
                        <textarea name="delivery_address" rows="3" required
                                  style="
                                    width:100%;
                                    padding:12px 12px;
                                    border-radius:14px;
                                    border:1px solid #e5e7eb;
                                    background:#ffffff;
                                    outline:none;
                                    resize:vertical;
                                  "></textarea>
                    </div>
                </div>

                {{-- LIST MENU (CARD GRID) --}}
                <div style="margin-top:18px">
                    <div style="font-weight:900;color:#0f172a;margin-bottom:10px">Pilih Menu</div>

                    <div style="
                        display:grid;
                        grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
                        gap:14px;
                    ">
                        @foreach($menus as $i => $menu)
                            <div style="
                                border:1px solid #e5e7eb;
                                border-radius:18px;
                                overflow:hidden;
                                background:#ffffff;
                                box-shadow:0 10px 20px rgba(15,23,42,.05);
                            ">
                                @if($menu->photo_path)
                                    <img src="{{ asset('storage/' . $menu->photo_path) }}"
                                         alt="{{ $menu->name }}"
                                         style="width:100%;height:150px;object-fit:cover;display:block">
                                @else
                                    <div style="
                                        height:150px;
                                        background:#f3f4f6;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        color:#64748b;
                                        font-weight:800;
                                    ">
                                        Foto tidak tersedia
                                    </div>
                                @endif

                                <div style="padding:14px">
                                    <div style="font-weight:900;color:#0f172a;line-height:1.35">
                                        {{ $menu->name }}
                                    </div>

                                    <div style="margin-top:6px;color:#64748b;font-size:12px">
                                        {{ $menu->category ?? 'Tanpa kategori' }}
                                    </div>

                                    @if(!empty($menu->description))
                                        <div style="margin-top:8px;color:#64748b;line-height:1.6;font-size:13px">
                                            {{ \Illuminate\Support\Str::limit($menu->description, 110) }}
                                        </div>
                                    @endif

                                    <div style="
                                        margin-top:12px;
                                        display:flex;
                                        justify-content:space-between;
                                        align-items:center;
                                        gap:12px;
                                    ">
                                        <div style="font-weight:900;color:#0f172a">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </div>

                                        <div style="min-width:120px;text-align:right">
                                            <input type="hidden" name="items[{{ $i }}][menu_id]" value="{{ $menu->id }}">
                                            <input type="number"
                                                   name="items[{{ $i }}][qty]"
                                                   min="0"
                                                   value="0"
                                                   style="
                                                    width:100%;
                                                    padding:10px 10px;
                                                    border-radius:12px;
                                                    border:1px solid #e5e7eb;
                                                    outline:none;
                                                    text-align:right;
                                                   ">
                                            <div style="margin-top:6px;color:#64748b;font-size:12px">
                                                Qty (0 = tidak pesan)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="
                        margin-top:14px;
                        padding:12px 14px;
                        border-radius:14px;
                        background:#f9fafb;
                        border:1px dashed #e5e7eb;
                        color:#64748b;
                        line-height:1.6;
                        font-size:13px;
                    ">
                        Catatan: Qty 0 berarti tidak dipesan. Disarankan minimal 1 menu dengan qty &gt; 0.
                    </div>
                </div>

                {{-- ACTION --}}
                <div style="
                    margin-top:16px;
                    display:flex;
                    justify-content:flex-end;
                    gap:10px;
                    flex-wrap:wrap;
                ">
                    <button type="submit" style="
                        padding:12px 18px;border-radius:14px;
                        background:#111827;color:#ffffff;
                        border:none;cursor:pointer;
                        font-weight:900;
                    ">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        @endif
    </div>

</div>

{{-- Responsive aman tanpa selector aneh --}}
<style>
    @media (max-width: 980px){
        #merchantInfoGrid{ grid-template-columns:1fr !important; }
        #shippingGrid{ grid-template-columns:1fr !important; }
    }
</style>

@endsection