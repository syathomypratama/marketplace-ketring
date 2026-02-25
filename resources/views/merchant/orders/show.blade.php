@extends('layouts.app', ['title' => 'Detail Order'])
@section('content')

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
            <div>
                <h2 style="margin:0">Detail Order</h2>
                <div class="muted"><b>{{ $order->invoice_number }}</b> • Status: {{ $order->status }}</div>
            </div>

            <a href="{{ route('merchant.orders.index') }}"
                style="padding:6px 12px;border-radius:8px;background:#e5e7eb;text-decoration:none;">
                ← Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('merchant.orders.status', $order) }}" style="margin-top:12px">
            @csrf
            <label>Ubah Status</label>
            <select name="status">
                @foreach(['pending', 'confirmed', 'processing', 'delivered', 'canceled'] as $st)
                    <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                @endforeach
            </select>
            <button type="submit" style="margin-top:8px">Update Status</button>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0">Data Customer</h3>

        <div><b>{{ $order->customer->name }}</b></div>
        <div class="muted">{{ $order->customer->email }}</div>
        <div class="muted">{{ $order->customer->phone ?? '-' }}</div>

        <div style="margin-top:10px">
            <b>Alamat Pengiriman:</b>
            <div class="muted">{{ $order->delivery_address }}</div>
        </div>

        <div style="margin-top:10px">
            <b>Tanggal Kirim:</b>
            <div class="muted">
                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top:0">Item Pesanan</h3>

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
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->menu_name_snapshot }}</td>
                        <td>Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->line_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:12px;text-align:right">
            <div>Subtotal: <b>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</b></div>
            <div>Pajak: <b>Rp {{ number_format($order->tax, 0, ',', '.') }}</b></div>
            <div style="font-size:18px;margin-top:6px">
                Total: <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>
            </div>
        </div>
    </div>

@endsection