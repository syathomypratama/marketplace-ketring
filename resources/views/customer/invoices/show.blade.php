@extends('layouts.app', ['title' => 'Invoice'])
@section('content')

<div style="max-width:1200px;margin:0 auto">

    {{-- HEADER --}}
    @php
        $status = $order->status ?? 'unknown';
        if ($status === 'paid' || $status === 'completed') {
            $badgeBg = '#dcfce7'; $badgeText = '#166534'; // hijau
        } elseif ($status === 'pending') {
            $badgeBg = '#fef9c3'; $badgeText = '#854d0e'; // kuning
        } elseif ($status === 'cancelled' || $status === 'canceled' || $status === 'failed') {
            $badgeBg = '#fee2e2'; $badgeText = '#991b1b'; // merah
        } else {
            $badgeBg = '#e5e7eb'; $badgeText = '#374151'; // abu
        }
    @endphp

    <div class="card" style="
        padding:18px 20px;
        border-radius:18px;
        background:#ffffff;
        border:1px solid #e5e7eb;
        box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap">
            <div style="min-width:260px">
                <h2 style="margin:0;font-size:24px;font-weight:900;color:#0f172a">Invoice</h2>

                <div style="margin-top:8px;color:#64748b;line-height:1.6">
                    <div>
                        <b style="color:#0f172a">{{ $order->invoice_number }}</b>
                        <span style="
                            margin-left:8px;
                            padding:4px 10px;
                            border-radius:999px;
                            background:{{ $badgeBg }};
                            color:{{ $badgeText }};
                            font-weight:900;
                            font-size:12px;
                            border:1px solid rgba(15,23,42,.06);
                        ">
                            {{ strtoupper(str_replace('_',' ', $status)) }}
                        </span>
                    </div>
                    <div style="margin-top:4px">Dibuat: {{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <a href="{{ route('customer.orders.index') }}"
                   style="
                    padding:10px 14px;border-radius:12px;
                    background:#f3f4f6;color:#111827;
                    border:1px solid #e5e7eb;
                    text-decoration:none;font-weight:900;
                   ">
                    Kembali
                </a>

                <button onclick="window.print()"
                        style="
                            padding:10px 14px;border-radius:12px;
                            background:#111827;color:#ffffff;
                            border:none;cursor:pointer;font-weight:900;
                        ">
                    Cetak
                </button>
            </div>
        </div>
    </div>

    {{-- MERCHANT + CUSTOMER --}}
    <div style="
        margin-top:14px;
        display:grid;
        grid-template-columns:repeat(2, minmax(0, 1fr));
        gap:14px;
    ">
        <div class="card" style="
            padding:18px 20px;border-radius:18px;background:#ffffff;
            border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
        ">
            <h3 style="margin:0 0 12px 0;font-size:18px;font-weight:900;color:#0f172a">Merchant</h3>
            <div style="font-weight:900;color:#0f172a">{{ $order->merchant->company_name ?? '-' }}</div>
            <div style="margin-top:6px;color:#64748b;line-height:1.6">
                <div>{{ $order->merchant->city ?? '-' }}</div>
                <div>{{ $order->merchant->address ?? '-' }}</div>
                <div style="margin-top:6px">
                    {{ $order->merchant->contact_person ?? '-' }} • {{ $order->merchant->contact_phone ?? '-' }}
                </div>
            </div>
        </div>

        <div class="card" style="
            padding:18px 20px;border-radius:18px;background:#ffffff;
            border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
        ">
            <h3 style="margin:0 0 12px 0;font-size:18px;font-weight:900;color:#0f172a">Customer</h3>
            <div style="font-weight:900;color:#0f172a">{{ $order->customer->name ?? '-' }}</div>
            <div style="margin-top:6px;color:#64748b;line-height:1.6">
                <div>{{ $order->customer->email ?? '-' }}</div>
                <div>{{ $order->customer->phone ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- PENGIRIMAN --}}
    <div class="card" style="
        margin-top:14px;
        padding:18px 20px;border-radius:18px;background:#ffffff;
        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <h3 style="margin:0 0 12px 0;font-size:18px;font-weight:900;color:#0f172a">Pengiriman</h3>

        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px">
            <div style="
                padding:12px 14px;border-radius:14px;
                background:#f9fafb;border:1px solid #e5e7eb;
            ">
                <div style="color:#64748b;font-size:12px;font-weight:800;margin-bottom:6px">Tanggal Kirim</div>
                <div style="font-weight:900;color:#0f172a">
                    {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') : '-' }}
                </div>
            </div>

            <div style="
                padding:12px 14px;border-radius:14px;
                background:#f9fafb;border:1px solid #e5e7eb;
            ">
                <div style="color:#64748b;font-size:12px;font-weight:800;margin-bottom:6px">Alamat</div>
                <div style="color:#0f172a;line-height:1.6">
                    {{ $order->delivery_address ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    {{-- ITEM --}}
    <div class="card" style="
        margin-top:14px;
        padding:18px 20px;border-radius:18px;background:#ffffff;
        border:1px solid #e5e7eb;box-shadow:0 10px 25px rgba(15,23,42,.06);
    ">
        <h3 style="margin:0 0 12px 0;font-size:18px;font-weight:900;color:#0f172a">Item</h3>

        <div style="overflow-x:auto;border:1px solid #e5e7eb;border-radius:16px">
            <table style="width:100%;border-collapse:collapse;background:#fff">
                <thead>
                    <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb">
                        <th style="text-align:left;padding:12px;font-size:13px;color:#0f172a">Menu</th>
                        <th style="text-align:right;padding:12px;font-size:13px;color:#0f172a">Harga</th>
                        <th style="text-align:center;padding:12px;font-size:13px;color:#0f172a">Qty</th>
                        <th style="text-align:right;padding:12px;font-size:13px;color:#0f172a">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $it)
                        <tr style="border-bottom:1px solid #eef2f7">
                            <td style="padding:12px;color:#0f172a">
                                <div style="font-weight:800">{{ $it->menu_name_snapshot }}</div>
                            </td>
                            <td style="padding:12px;text-align:right;color:#0f172a">
                                Rp {{ number_format($it->price_snapshot, 0, ',', '.') }}
                            </td>
                            <td style="padding:12px;text-align:center;color:#0f172a">
                                {{ $it->qty }}
                            </td>
                            <td style="padding:12px;text-align:right;color:#0f172a;font-weight:800">
                                Rp {{ number_format($it->line_total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div style="
            margin-top:14px;
            display:flex;
            justify-content:flex-end;
        ">
            <div style="min-width:320px">
                <div style="
                    padding:14px;border-radius:16px;
                    background:#f9fafb;border:1px solid #e5e7eb;
                ">
                    <div style="display:flex;justify-content:space-between;gap:10px;color:#64748b">
                        <div>Subtotal</div>
                        <div style="font-weight:900;color:#0f172a">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</div>
                    </div>

                    <div style="display:flex;justify-content:space-between;gap:10px;margin-top:8px;color:#64748b">
                        <div>Pajak</div>
                        <div style="font-weight:900;color:#0f172a">Rp {{ number_format($order->tax, 0, ',', '.') }}</div>
                    </div>

                    <div style="height:1px;background:#e5e7eb;margin:12px 0"></div>

                    <div style="display:flex;justify-content:space-between;gap:10px">
                        <div style="font-weight:900;color:#0f172a;font-size:14px">Total</div>
                        <div style="font-weight:900;color:#0f172a;font-size:18px">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div style="margin-top:10px;color:#64748b;font-size:12px;line-height:1.5;text-align:right">
                    Simpan invoice ini sebagai bukti transaksi.
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Responsive kecil (tanpa app.css) --}}
<style>
  @media (max-width: 980px){
    div[style*="grid-template-columns:repeat(2"]{ grid-template-columns:1fr !important; }
  }
  @media print{
    button{ display:none !important; }
    a{ display:none !important; }
    body{ background:#fff !important; }
  }
</style>

@endsection