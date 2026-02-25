@extends ('layouts.app', ['title' => 'Edit Menu']);
@section('content')

    <div class="card">
        <h2>Edit Menu</h2>
        <p><a href="{{ route('merchant.menus.index') }}">← Kembali ke Daftar Menu</a></p>

        <form method="POST" action="{{ route('merchant.menus.update', $menu) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label>Nama Menu</label>
            <input type="text" name="name" value="{{ old('name', $menu->name) }}" required>

            <label>Kategori</label>
            <input type="text" name="category" value="{{ old('category', $menu->category) }}">

            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description', $menu->description) }}</textarea>

            <label>Harga (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $menu->price) }}" required>

            <label>Status</label>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', $menu->is_active) ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !old('is_active', $menu->is_active) ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <label>Gambar Menu (biarkan kosong untuk tidak mengubah)</label>
            <input type="file" name="photo" accept="image">

            @if($menu->photo_path)
                <div style="margin-top:8px">
                    <img src="{{ asset('storage/' . $menu->photo_path) }}"
                        style="width:120px;height:80px;object-fit:cover;border-radius:10px">
                </div>
            @endif

            <button type="submit" style="margin-top:12px">Simpan Perubahan</button>
        </form>

    </div>

@endsection