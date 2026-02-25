@extends('layouts.app', ['title' => 'Order Saya'])

@section('content')
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
            <div>
                <h2 style="margin:0">Order Saya</h2>
                <div class="muted">Daftar pesanan makan siang kantor.</div>
            </div>

            <a href="{{ route('customer.dashboard') }}"
                style="padding:6px 12px;border-radius:8px;background:#e5e7eb;text-decoration:none;">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="card">
        @if($orders->isEmpty())
            <div class="muted">Belum ada order.</div>
            <div style="margin-top:10px">
                <a href="{{ route('customer.caterings.index') }}">Cari katering →</a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal Order</th>
                        <th>Tanggal Kirim</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                        <tr>
                            <td><b>{{ $o->invoice_number }}</b></td>
                            <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($o->delivery_date)->format('d/m/Y') }}</td>
                            <td>{{ $o->status }}</td>
                            <td>Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('customer.invoices.show', $o) }}"
                                    style="padding:6px 12px;border-radius:8px;background:#111827;color:#fff;text-decoration:none;">
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:12px">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection