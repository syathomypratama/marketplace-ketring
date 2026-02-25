@extends('layouts.app', ['title' => 'Customer Dashboard'])

@section('content')
    {{-- =========================
    HERO / HEADER
    ========================= --}}
    <div class="card" style="
                                        padding:18px;
                                        border-radius:16px;
                                        background:linear-gradient(135deg,#0f172a 0%, #111827 55%, #0b1220 100%);
                                        color:#fff;
                                        box-shadow:0 10px 28px rgba(0,0,0,.18);
                                        border:1px solid rgba(255,255,255,.06);
                                    ">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap">
            <div style="min-width:260px;max-width:680px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                    <div>
                        <h2 style="margin:0;font-size:22px;line-height:1.2">Dashboard Kantor</h2>
                        <div style="opacity:.78;font-size:13px;margin-top:2px">
                            Kelola makan siang lebih cepat: pilih katering, cek menu, lalu order.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- =========================
    REKOMENDASI KATERING
    ========================= --}}
    <div class="card" style="
                                        margin-top:14px;
                                        padding:18px;
                                        border-radius:16px;
                                        background:#fff;
                                        border:1px solid #e5e7eb;
                                        box-shadow:0 8px 18px rgba(15,23,42,.06);
                                    ">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap">
            <div>
                <h3 style="margin:0;font-size:18px">Rekomendasi Katering</h3>
                <div class="muted" style="margin-top:6px">
                    Beberapa katering terdekat & populer untuk kamu.
                </div>
            </div>
        </div>

        <div style="height:1px;background:#eef2f7;margin:14px 0"></div>

        @if($merchants->isEmpty())
            <div style="
                                                                                padding:14px;border-radius:14px;
                                                                                background:#f9fafb;border:1px dashed #e5e7eb;
                                                                                color:#6b7280
                                                                            ">
                Belum ada katering terdaftar.
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:14px">
                @foreach($merchants as $m)
                    <div style="
                                                                                                                        padding:16px;border-radius:16px;
                                                                                                                        border:1px solid #e5e7eb;
                                                                                                                        background:linear-gradient(180deg,#ffffff 0%, #fbfdff 100%);
                                                                                                                        box-shadow:0 10px 22px rgba(15,23,42,.05);
                                                                                                                    ">
                        {{-- Header merchant --}}
                        <div style="display:flex;justify-content:space-between;gap:14px;align-items:flex-start;flex-wrap:wrap">
                            <div style="min-width:260px;max-width:740px">
                                <div style="display:flex;align-items:flex-start;gap:10px">
                                    <div
                                        style="
                                                                                                                                        width:42px;height:42px;border-radius:14px;
                                                                                                                                        background:#111827;color:#fff;
                                                                                                                                        display:flex;align-items:center;justify-content:center;
                                                                                                                                        font-weight:800
                                                                                                                                    ">
                                        {{ strtoupper(substr($m->company_name ?? 'M', 0, 1)) }}
                                    </div>

                                    <div style="min-width:0">
                                        <div style="font-size:18px;line-height:1.3;font-weight:800">
                                            {{ $m->company_name }}
                                        </div>
                                        <div class="muted" style="margin-top:2px">
                                            {{ $m->city ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                @if($m->description)
                                    <div class="muted" style="margin-top:10px;line-height:1.5">
                                        {{ \Illuminate\Support\Str::limit($m->description, 160) }}
                                    </div>
                                @endif

                                <div style="margin-top:12px">
                                    <a href="{{ route('customer.caterings.show', $m) }}"
                                        style="
                                                                                                                                        display:inline-flex;align-items:center;gap:8px;
                                                                                                                                        padding:10px 12px;border-radius:12px;
                                                                                                                                        background:#111827;color:#fff;
                                                                                                                                        text-decoration:none;font-weight:800;font-size:13px;
                                                                                                                                       ">
                                        Lihat profil & semua menu <span style="opacity:.9">→</span>
                                    </a>
                                </div>
                            </div>

                            <div style="
                                                                                                                                min-width:240px;
                                                                                                                                padding:12px 12px;border-radius:14px;
                                                                                                                                background:#f9fafb;border:1px solid #e5e7eb;
                                                                                                                                color:#111827
                                                                                                                            ">
                                <div style="font-weight:800;margin-bottom:6px">Kontak</div>
                                <div class="muted" style="margin-bottom:2px">{{ $m->contact_person ?? '-' }}</div>
                                <div class="muted">{{ $m->contact_phone ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- Menu preview --}}
                        <div style="margin-top:14px">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap">
                                <div class="muted" style="font-weight:800">Menu preview</div>
                                <div class="muted" style="font-size:12px">Tampilkan beberapa menu aktif</div>
                            </div>

                            @php
                                $preview = $menuPreview[$m->id] ?? collect();
                            @endphp

                            @if($preview->isEmpty())
                                <div
                                    style="
                                                                                                                                                                    margin-top:10px;
                                                                                                                                                                    padding:12px;border-radius:14px;
                                                                                                                                                                    background:#f9fafb;border:1px dashed #e5e7eb;
                                                                                                                                                                    color:#6b7280
                                                                                                                                                                ">
                                    Belum ada menu aktif.
                                </div>
                            @else
                                <div
                                    style="
                                                                                                                                                                    margin-top:10px;
                                                                                                                                                                    display:grid;
                                                                                                                                                                    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
                                                                                                                                                                    gap:12px
                                                                                                                                                                ">
                                    @foreach($preview as $menu)
                                        <div
                                            style="
                                                                                                                                                                                                            border:1px solid #e5e7eb;
                                                                                                                                                                                                            border-radius:16px;
                                                                                                                                                                                                            overflow:hidden;
                                                                                                                                                                                                            background:#fff;
                                                                                                                                                                                                            box-shadow:0 8px 16px rgba(15,23,42,.05);
                                                                                                                                                                                                        ">
                                            @if($menu->photo_path)
                                                <img src="{{ asset('storage/' . $menu->photo_path) }}" alt="{{ $menu->name }}"
                                                    style="width:100%;height:130px;object-fit:cover">
                                            @else
                                                <div
                                                    style="
                                                                                                                                                                                                                                                    width:100%;height:130px;
                                                                                                                                                                                                                                                    background:linear-gradient(135deg,#eef2ff 0%, #f8fafc 70%);
                                                                                                                                                                                                                                                    display:flex;align-items:center;justify-content:center;
                                                                                                                                                                                                                                                    color:#64748b;font-weight:800
                                                                                                                                                                                                                                                ">
                                                    🍱
                                                </div>
                                            @endif

                                            <div style="padding:12px">
                                                <div style="font-weight:900;line-height:1.3">
                                                    {{ $menu->name }}
                                                </div>

                                                <div class="muted" style="margin-top:4px;font-size:12px">
                                                    {{ $menu->category ?? 'Tanpa kategori' }}
                                                </div>

                                                <div
                                                    style="margin-top:10px;display:flex;justify-content:space-between;align-items:center;gap:10px">
                                                    <div style="font-weight:900">
                                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                                    </div>

                                                    <a href="{{ route('customer.caterings.show', $m) }}"
                                                        style="font-size:13px;font-weight:800;text-decoration:none;color:#111827">
                                                        Pilih →
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div style="margin-top:14px">
            <a href="{{ route('customer.caterings.index') }}" style="text-decoration:none;font-weight:800;color:#111827">
                Lihat semua katering →
            </a>
        </div>
    </div>
@endsection