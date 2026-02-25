@extends('layouts.app', ['title' => 'Kelola Menu'])

@section('content')
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px">
            <h2 style="margin:0">Kelola Menu</h2>
            <a href="{{ route('merchant.menus.create') }}">+ Tambah Menu</a>
        </div>
    </div>

    <div class="card">
        @if($menus->isEmpty())
            <div class="muted">Belum ada menu. Klik “Tambah Menu”.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $m)
                        <tr>
                            <td style="width:110px">
                                @if($m->photo_path)
                                    <img src="{{ asset('storage/' . $m->photo_path) }}"
                                        style="width:90px;height:60px;object-fit:cover;border-radius:10px">
                                @else
                                    <span class="muted">-</span>
                                @endif
                            </td>
                            <td>
                                <b>{{ $m->name }}</b><br>
                                <span class="muted">{{ $m->category ?? '-' }}</span><br>
                                <span class="muted">{{ \Illuminate\Support\Str::limit($m->description, 90) }}</span>
                            </td>
                            <td>Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                            <td>{{ $m->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td>
                                <a href="{{ route('merchant.menus.edit', $m) }}">Edit</a>
                                <form method="POST" action="{{ route('merchant.menus.destroy', $m) }}" style="display:inline"
                                    onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" style="background:#ef4444;margin-left:8px">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:12px">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
@endsection