@extends('layouts.app', ['title' => 'Detail Order']);
@section('content');

    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
            <div>
                <h2 style="margin:0">Detail Order</h2>
                <div class="muted"><b>{{ $order->invoice_number }}</b> • Status: {{ $order->status }}</div>
            </div>

            <a href="{{ route('customer.orders.index') }}"
                style="padding:6px 12px;border-radius:8px;background:#e5e7eb;text-decoration:none;">
                ← Kembali
            </a>
        </div>

@endsection