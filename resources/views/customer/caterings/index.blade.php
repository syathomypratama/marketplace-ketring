@extends('layouts.app', ['title' => 'Cari Katering'])
@section('content')

    <div style="max-width:1200px;margin:0 auto">

        {{-- Header --}}
        <div class="card" style="
                                        padding:18px 20px;
                                        border-radius:18px;
                                        background:#ffffff;
                                        border:1px solid #e5e7eb;
                                        box-shadow:0 10px 25px rgba(15,23,42,.06);
                                        display:flex;
                                        justify-content:space-between;
                                        align-items:flex-start;
                                        gap:16px;
                                        flex-wrap:wrap;
                                    ">
            <div>
                <h2 style="margin:0;font-size:24px;font-weight:900;color:#0f172a">Cari Katering</h2>
                <div style="margin-top:6px;color:#64748b;line-height:1.6">
                    Gunakan filter untuk menemukan katering yang sesuai kebutuhan.
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <a href="{{ route('customer.orders.index') }}" style="
                                                padding:10px 14px;border-radius:12px;
                                                background:#111827;color:#ffffff;
                                                text-decoration:none;font-weight:800;
                                               ">
                    Order Saya
                </a>
                <a href="{{ url('/customer/dashboard') }}" style="
                                                padding:10px 14px;border-radius:12px;
                                                background:#f3f4f6;color:#111827;
                                                text-decoration:none;font-weight:800;
                                                border:1px solid #e5e7eb;
                                               ">
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Filter Form --}}
        <div class="card" style="
                                        margin-top:14px;
                                        padding:18px 20px;
                                        border-radius:18px;
                                        background:#ffffff;
                                        border:1px solid #e5e7eb;
                                        box-shadow:0 10px 25px rgba(15,23,42,.06);
                                    ">
            <form method="GET" action="{{ route('customer.caterings.index') }}">

                <div id="filterGrid" style="
                      display:grid;
                      grid-template-columns:repeat(3,minmax(0,1fr));
                      gap:14px;
                    ">

                    <div style="min-width:0">
                        <label style="display:block;font-weight:800;color:#0f172a;margin-bottom:6px">Keyword</label>
                        <input name="q" value="{{ $keyword }}" placeholder="Nama katering / deskripsi" style="
                                                            width:100%;
                                                            padding:12px 12px;
                                                            border-radius:14px;
                                                            border:1px solid #e5e7eb;
                                                            background:#ffffff;
                                                            outline:none;
                                                           ">
                        <div style="margin-top:6px;color:#64748b;font-size:12px;line-height:1.4">
                            Contoh: “Nasi box”, “harian”, atau nama katering.
                        </div>
                    </div>

                    <div style="min-width:0">
                        <label style="display:block;font-weight:800;color:#0f172a;margin-bottom:6px">Kota</label>
                        <select name="city" style="
                                                                width:100%;
                                                                padding:12px 12px;
                                                                border-radius:14px;
                                                                border:1px solid #e5e7eb;
                                                                background:#ffffff;
                                                                outline:none;
                                                            ">
                            <option value="">Semua</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" @selected($city === $c)>{{ $c }}</option>
                            @endforeach
                        </select>
                        <div style="margin-top:6px;color:#64748b;font-size:12px;line-height:1.4">
                            Pilih kota untuk mempersempit hasil.
                        </div>
                    </div>

                    <div style="min-width:0">
                        <label style="display:block;font-weight:800;color:#0f172a;margin-bottom:6px">Kategori Menu</label>
                        <select name="category" style="
                                                                width:100%;
                                                                padding:12px 12px;
                                                                border-radius:14px;
                                                                border:1px solid #e5e7eb;
                                                                background:#ffffff;
                                                                outline:none;
                                                            ">
                            <option value="">Semua</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <div style="margin-top:6px;color:#64748b;font-size:12px;line-height:1.4">
                            Filter berdasarkan kategori menu.
                        </div>
                    </div>

                </div>

                <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                    <button type="submit" style="
                                                            padding:12px 16px;border-radius:14px;
                                                            background:#111827;color:#ffffff;
                                                            border:none;cursor:pointer;font-weight:900;
                                                        ">
                        Terapkan Filter
                    </button>

                    <a href="{{ route('customer.caterings.index') }}" style="
                                                    padding:12px 16px;border-radius:14px;
                                                    background:#f3f4f6;color:#111827;
                                                    border:1px solid #e5e7eb;
                                                    text-decoration:none;font-weight:900;
                                                   ">
                        Reset
                    </a>

                    <div style="color:#64748b;font-size:12px;margin-left:auto">
                        Hasil akan diperbarui sesuai filter.
                    </div>
                </div>

            </form>
        </div>

        {{-- Results --}}
        <div class="card" style="
                                        margin-top:14px;
                                        padding:18px 20px;
                                        border-radius:18px;
                                        background:#ffffff;
                                        border:1px solid #e5e7eb;
                                        box-shadow:0 10px 25px rgba(15,23,42,.06);
                                    ">

            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
                <div>
                    <div style="font-weight:900;color:#0f172a;font-size:16px">Hasil Pencarian</div>
                    <div style="margin-top:4px;color:#64748b;font-size:13px">
                        Menampilkan daftar katering yang sesuai dengan filter.
                    </div>
                </div>

                <div style="color:#64748b;font-size:13px">
                    Total: <b style="color:#0f172a">{{ $merchants->total() ?? $merchants->count() }}</b>
                </div>
            </div>

            <div style="height:1px;background:#eef2f7;margin:16px 0"></div>

            @if($merchants->isEmpty())
                <div style="
                                                                                padding:16px;
                                                                                border-radius:14px;
                                                                                background:#f9fafb;
                                                                                border:1px dashed #e5e7eb;
                                                                                color:#64748b;
                                                                            ">
                    Tidak ada katering sesuai filter.
                </div>
            @else

                <div style="display:flex;flex-direction:column;gap:14px">
                    @foreach($merchants as $m)
                        <div style="
                                                                                                                        padding:18px;
                                                                                                                        border-radius:18px;
                                                                                                                        border:1px solid #e5e7eb;
                                                                                                                        background:#ffffff;
                                                                                                                        box-shadow:0 10px 20px rgba(15,23,42,.05);
                                                                                                                        display:flex;
                                                                                                                        justify-content:space-between;
                                                                                                                        align-items:flex-start;
                                                                                                                        gap:16px;
                                                                                                                        flex-wrap:wrap;
                                                                                                                    ">
                            <div style="min-width:260px;max-width:780px">
                                <div style="font-size:18px;font-weight:900;color:#0f172a">
                                    {{ $m->company_name }}
                                </div>
                                <div style="margin-top:4px;color:#64748b">
                                    {{ $m->city ?? '-' }}
                                </div>

                                @if($m->description)
                                    <div style="margin-top:10px;color:#64748b;line-height:1.7">
                                        {{ \Illuminate\Support\Str::limit($m->description, 160) }}
                                    </div>
                                @endif
                            </div>

                            <div style="display:flex;flex-direction:column;gap:10px;min-width:220px;align-items:flex-end">
                                <a href="{{ route('customer.caterings.show', $m) }}" style="
                                                                                                                                padding:10px 14px;border-radius:14px;
                                                                                                                                background:#111827;color:#ffffff;
                                                                                                                                text-decoration:none;font-weight:900;
                                                                                                                               ">
                                    Lihat Profil & Menu
                                </a>

                                <div style="
                                                                                                                                padding:10px 12px;border-radius:14px;
                                                                                                                                background:#f9fafb;border:1px solid #e5e7eb;
                                                                                                                                color:#64748b;font-size:12px;line-height:1.5;text-align:right;
                                                                                                                                min-width:220px
                                                                                                                            ">
                                    Kontak: <b style="color:#0f172a">{{ $m->contact_person ?? '-' }}</b><br>
                                    Telepon: <b style="color:#0f172a">{{ $m->contact_phone ?? '-' }}</b>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:16px">
                    {{ $merchants->links() }}
                </div>

            @endif

        </div>

    </div>

    {{-- Responsive helper (inline, tanpa app.css) --}}
    <style>
        @media (max-width: 980px) {
            #filterGrid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

@endsection