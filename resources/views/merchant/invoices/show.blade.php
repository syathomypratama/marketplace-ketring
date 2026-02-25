@extends('layouts.app', ['title' => 'Invoice'])
@section('content')

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
            <div>
                <h2 style="margin:0">Invoice</h2>
                <div class="muted"><b>{{ $order->invoice_number }}</b> • Status: {{ $order->status }}</div>
                <div class="muted">Dibuat: {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>

            <a href="{{ route('merchant.orders.index') }}"
                style="padding:6px 12px;border-radius:8px;background:#e5e7eb;text-decoration:none;">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="card">
            <h3 style="margin-top:0">Merchant</h3>
            <div><b>{{ $order->merchant->company_name }}</b></div>
            <div class="muted">{{ $order->merchant->city }}</div>
            <div class="muted">{{ $order->merchant->address }}</div>
            <div class="muted">{{ $order->merchant->contact_person ?? '-' }} • {{ $order->merchant->contact_phone ?? '-' }}
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top:0">Customer</h3>
            <div><b>{{ $order->customer->name }}</b></div>
            <div class="muted">{{ $order->customer->email }}</div>
            <div class="muted">{{ $order->customer->phone ?? '-' }}</div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0">Pengiriman</h3>
        <div><b>Tanggal Kirim:</b> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</div>
        <div style="margin-top:6px"><b>Alamat:</b> <span class="muted">{{ $order->delivery_address }}</span></div>
    </div>

    <div class="card">
        <h3 style="margin-top:0">Item</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $it)
                    <tr>
                        <td>{{ $it->menu_name_snapshot }}</td>
                        <td>Rp {{ number_format($it->price_snapshot, 0, ',', '.') }}</td>
                        <td>{{ $it->qty }}</td>
                        <td>Rp {{ number_format($it->line_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:12px;text-align:right">
            <div>Subtotal: <b>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</b></div>
            <div>Pajak: <b>Rp {{ number_format($order->tax, 0, ',', '.') }}</b></div>
            <div style="font-size:18px;margin-top:6px">Total: <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>
            </div>
        </div>
    </div>

@endsection