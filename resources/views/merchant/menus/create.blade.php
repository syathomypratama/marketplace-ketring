@extends ('layouts.app', ['title' => 'Tambah Menu Baru']);
@section('content')
    <div class="card">
        <h2>Tambah Menu Baru</h2>
        <p><a href="{{ route('merchant.menus.index') }}">← Kembali ke Daftar Menu</a></p>

        <form method="POST" action="{{ route('merchant.menus.store') }}" enctype="multipart/form-data"> @csrf

            <label>Nama Menu</label>
            <input type="text" name="name" required>

            <label>Kategori</label>
            <input type="text" name="category" required>

            <label>Deskripsi</label>
            <textarea name="description" rows="3"></textarea>

            <label>Harga (Rp)</label>
            <input type="number" name="price" required>

            <label>Gambar Menu</label>
            <input type="file" name="photo" accept="image" required>
            <button type="submit" style="margin-top:12px">Simpan Menu</button>
        </form>
    </div>
@endsection