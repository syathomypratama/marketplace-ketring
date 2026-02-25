@extends('layouts.app', ['title' => 'Merchant Dashboard'])

@section('content')
    <div style="max-width:1200px;margin:0 auto">

        {{-- HEADER / HERO --}}
        <div class="card" style="
                    padding:20px 22px;
                    border-radius:20px;
                    background:linear-gradient(135deg,#0f172a 0%, #111827 60%, #0b1220 100%);
                    color:#ffffff;
                    box-shadow:0 18px 40px rgba(0,0,0,.18);
                    border:1px solid rgba(255,255,255,.10);
                ">
            <div id="merchantHeroGrid" style="
                        display:grid;
                        grid-template-columns:1.4fr .8fr;
                        gap:22px;
                        align-items:start;
                    ">
                <div>
                    <h2 style="margin:0;font-size:26px;font-weight:900">Dashboard Merchant</h2>
                    <div style="margin-top:10px;opacity:.85;line-height:1.6">
                        <div style="font-weight:900">{{ $merchant->company_name }}</div>
                        <div>{{ $merchant->city ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div id="statsGrid" style="
                    margin-top:14px;
                    display:grid;
                    grid-template-columns:repeat(4,minmax(0,1fr));
                    gap:14px;
                ">
            <div style="
                        padding:16px 16px;border-radius:18px;background:#ffffff;
                        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
                    ">
                <div style="color:#64748b;font-size:12px;font-weight:900">Total Menu</div>
                <div style="margin-top:8px;font-size:26px;font-weight:900;color:#0f172a">
                    {{ $stats['menus_total'] ?? 0 }}
                </div>
            </div>

            <div style="
                        padding:16px 16px;border-radius:18px;background:#ffffff;
                        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
                    ">
                <div style="color:#64748b;font-size:12px;font-weight:900">Total Order</div>
                <div style="margin-top:8px;font-size:26px;font-weight:900;color:#0f172a">
                    {{ $stats['orders_total'] ?? 0 }}
                </div>
            </div>

            <div style="
                        padding:16px 16px;border-radius:18px;background:#ffffff;
                        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
                    ">
                <div style="color:#64748b;font-size:12px;font-weight:900">Order Pending</div>
                <div style="margin-top:8px;font-size:26px;font-weight:900;color:#0f172a">
                    {{ $stats['orders_pending'] ?? 0 }}
                </div>
            </div>

            <div style="
                        padding:16px 16px;border-radius:18px;background:#ffffff;
                        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
                    ">
                <div style="color:#64748b;font-size:12px;font-weight:900">Total Omzet</div>
                <div style="margin-top:8px;font-size:20px;font-weight:900;color:#0f172a">
                    Rp {{ number_format($stats['revenue_total'] ?? 0, 0, ',', '.') }}
                </div>
                <div style="margin-top:6px;color:#64748b;font-size:12px;line-height:1.4">
                    confirmed / processing / delivered
                </div>
            </div>
        </div>

        {{-- ORDER TERBARU --}}
        <div class="card" style="
                    margin-top:14px;
                    padding:18px 20px;border-radius:18px;background:#ffffff;
                    border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
                ">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap">
                <div>
                    <h3 style="margin:0;font-size:20px;font-weight:900;color:#0f172a">Order Terbaru</h3>
                    <div style="margin-top:6px;color:#64748b;line-height:1.6">
                        Ringkasan order terbaru yang masuk.
                    </div>
                </div>

                <a href="{{ route('merchant.orders.index') }}" style="
                            padding:10px 14px;border-radius:14px;
                            background:#f3f4f6;color:#111827;
                            border:1px solid #e5e7eb;
                            text-decoration:none;font-weight:900;
                        ">Lihat semua</a>
            </div>

            <div style="height:1px;background:#eef2f7;margin:16px 0"></div>

            @if($latestOrders->isEmpty())
                <div style="
                                        padding:16px;border-radius:14px;
                                        background:#f9fafb;border:1px dashed #e5e7eb;
                                        color:#64748b;
                                    ">
                    Belum ada order masuk.
                </div>
            @else
                <div style="overflow-x:auto;border:1px solid #e5e7eb;border-radius:16px">
                    <table style="width:100%;border-collapse:collapse;background:#fff">
                        <thead>
                            <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb">
                                <th style="text-align:left;padding:12px;font-size:13px;color:#0f172a">Invoice</th>
                                <th style="text-align:left;padding:12px;font-size:13px;color:#0f172a">Tanggal Kirim</th>
                                <th style="text-align:left;padding:12px;font-size:13px;color:#0f172a">Status</th>
                                <th style="text-align:right;padding:12px;font-size:13px;color:#0f172a">Total</th>
                                <th style="text-align:right;padding:12px;font-size:13px;color:#0f172a">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestOrders as $o)
                                @php
                                    $st = $o->status ?? 'unknown';
                                    if ($st === 'paid' || $st === 'completed' || $st === 'delivered') {
                                        $bg = '#dcfce7';
                                        $tx = '#166534';
                                    } elseif ($st === 'pending') {
                                        $bg = '#fef9c3';
                                        $tx = '#854d0e';
                                    } elseif ($st === 'cancelled' || $st === 'canceled' || $st === 'failed') {
                                        $bg = '#fee2e2';
                                        $tx = '#991b1b';
                                    } else {
                                        $bg = '#e5e7eb';
                                        $tx = '#374151';
                                    }
                                @endphp

                                <tr style="border-bottom:1px solid #eef2f7">
                                    <td style="padding:12px;color:#0f172a">
                                        <div style="font-weight:900">{{ $o->invoice_number }}</div>
                                    </td>

                                    <td style="padding:12px;color:#0f172a">
                                        {{ $o->delivery_date ? \Carbon\Carbon::parse($o->delivery_date)->format('d/m/Y') : '-' }}
                                    </td>

                                    <td style="padding:12px">
                                        <span style="
                                                                            padding:4px 10px;border-radius:999px;
                                                                            background:{{ $bg }};color:{{ $tx }};
                                                                            font-weight:900;font-size:12px;
                                                                            border:1px solid rgba(15,23,42,.06);
                                                                        ">
                                            {{ strtoupper(str_replace('_', ' ', $st)) }}
                                        </span>
                                    </td>

                                    <td style="padding:12px;text-align:right;color:#0f172a;font-weight:900">
                                        Rp {{ number_format($o->total, 0, ',', '.') }}
                                    </td>

                                    <td style="padding:12px;text-align:right">
                                        <div style="display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap">
                                            <a href="{{ route('merchant.orders.show', $o) }}" style="
                                                                                padding:8px 12px;border-radius:12px;
                                                                                background:#111827;color:#ffffff;
                                                                                text-decoration:none;font-weight:900;font-size:13px;
                                                                            ">Detail</a>

                                            <a href="{{ route('merchant.invoices.show', $o) }}" style="
                                                                                padding:8px 12px;border-radius:12px;
                                                                                background:#f3f4f6;color:#111827;
                                                                                border:1px solid #e5e7eb;
                                                                                text-decoration:none;font-weight:900;font-size:13px;
                                                                            ">Invoice</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <style>
        @media (max-width: 980px) {
            #merchantHeroGrid {
                grid-template-columns: 1fr !important;
            }

            #statsGrid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 560px) {
            #statsGrid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

@endsection