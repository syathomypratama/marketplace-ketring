@extends('layouts.app', ['title' => 'Profil Merchant'])

@section('content')
    <div class="card">
        <h2>Profil Merchant</h2>
        <p class="muted">Data ini akan tampil di halaman customer saat mencari katering.</p>

        <form method="POST" action="{{ route('merchant.profile.update') }}">
            @csrf

            <label>Nama Perusahaan</label>
            <input name="company_name" value="{{ old('company_name', $merchant->company_name) }}" required>

            <label>Kota</label>
            <input name="city" value="{{ old('city', $merchant->city) }}" required>

            <label>Alamat</label>
            <textarea name="address" rows="3" required>{{ old('address', $merchant->address) }}</textarea>

            <label>Nama PIC (opsional)</label>
            <input name="contact_person" value="{{ old('contact_person', $merchant->contact_person) }}">

            <label>No HP/WA (opsional)</label>
            <input name="contact_phone" value="{{ old('contact_phone', $merchant->contact_phone) }}">

            <label>Deskripsi (opsional)</label>
            <textarea name="description" rows="4">{{ old('description', $merchant->description) }}</textarea>

            <div style="margin-top:12px">
                <button type="submit">Simpan</button>
                <a href="{{ route('merchant.dashboard') }}" style="margin-left:10px">Kembali</a>
            </div>
        </form>
    </div>
@endsection