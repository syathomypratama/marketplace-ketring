@extends('layouts.app', ['title' => 'Register'])
@section('content')

    <div style="max-width:620px;margin:0 auto">

        <div class="card" style="
            padding:22px 22px;
            border-radius:20px;
            background:#ffffff;
            border:1px solid #e5e7eb;
            box-shadow:0 14px 30px rgba(15,23,42,.08);
        ">

            <div style="margin-bottom:16px">
                <h2 style="margin:0;font-size:24px;font-weight:900;color:#0f172a">Buat Akun</h2>
                <div style="margin-top:6px;color:#64748b;line-height:1.6">
                    Isi data berikut untuk membuat akun baru.
                </div>
            </div>

            {{-- Error global --}}
            @if ($errors->any())
                <div style="
                        padding:12px 14px;
                        border-radius:14px;
                        background:#fef2f2;
                        border:1px solid #fecaca;
                        color:#991b1b;
                        margin-bottom:14px;
                        line-height:1.6;
                    ">
                    <div style="font-weight:900;margin-bottom:6px">Terjadi kesalahan</div>
                    <ul style="margin:0;padding-left:18px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                {{-- Nama + HP --}}
                <div id="regRow1" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px">
                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">Nama</label>
                        <input name="name" value="{{ old('name') }}" required placeholder="Nama lengkap" style="
                                width:100%;
                                padding:12px 12px;
                                border-radius:14px;
                                border:1px solid #e5e7eb;
                                outline:none;
                                background:#ffffff;
                               ">
                        @error('name')
                            <div style="margin-top:6px;color:#b91c1c;font-size:12px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">No HP</label>
                        <input name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" style="
                                width:100%;
                                padding:12px 12px;
                                border-radius:14px;
                                border:1px solid #e5e7eb;
                                outline:none;
                                background:#ffffff;
                               ">
                        @error('phone')
                            <div style="margin-top:6px;color:#b91c1c;font-size:12px">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div style="margin-top:12px">
                    <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@domain.com"
                        style="
                            width:100%;
                            padding:12px 12px;
                            border-radius:14px;
                            border:1px solid #e5e7eb;
                            outline:none;
                            background:#ffffff;
                           ">
                    @error('email')
                        <div style="margin-top:6px;color:#b91c1c;font-size:12px">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role --}}
                <div style="margin-top:12px">
                    <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">Role</label>
                    <select name="role" required style="
                                width:100%;
                                padding:12px 12px;
                                border-radius:14px;
                                border:1px solid #e5e7eb;
                                outline:none;
                                background:#ffffff;
                            ">
                        <option value="customer" @selected(old('role') === 'customer')>Kantor (Customer)</option>
                        <option value="merchant" @selected(old('role') === 'merchant')>Katering (Merchant)</option>
                    </select>
                    @error('role')
                        <div style="margin-top:6px;color:#b91c1c;font-size:12px">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password + Konfirmasi (dengan toggle) --}}
                <div id="regRow2"
                    style="margin-top:12px;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px">

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">Password</label>

                        <div style="position:relative">
                            <input id="regPassword" type="password" name="password" required
                                placeholder="Minimal 8 karakter" style="
                                    width:100%;
                                    padding:12px 92px 12px 12px;
                                    border-radius:14px;
                                    border:1px solid #e5e7eb;
                                    outline:none;
                                    background:#ffffff;
                                   ">

                            <button id="toggleRegPassword" type="button" style="
                                        position:absolute;
                                        top:50%;
                                        right:10px;
                                        transform:translateY(-50%);
                                        padding:8px 10px;
                                        border-radius:12px;
                                        border:1px solid #e5e7eb;
                                        background:#f3f4f6;
                                        color:#111827;
                                        font-weight:900;
                                        font-size:12px;
                                        cursor:pointer;
                                    ">
                                Lihat
                            </button>
                        </div>

                        @error('password')
                            <div style="margin-top:6px;color:#b91c1c;font-size:12px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">Konfirmasi
                            Password</label>

                        <div style="position:relative">
                            <input id="regPasswordConfirm" type="password" name="password_confirmation" required
                                placeholder="Ulangi password" style="
                                    width:100%;
                                    padding:12px 92px 12px 12px;
                                    border-radius:14px;
                                    border:1px solid #e5e7eb;
                                    outline:none;
                                    background:#ffffff;
                                   ">

                            <button id="toggleRegPasswordConfirm" type="button" style="
                                        position:absolute;
                                        top:50%;
                                        right:10px;
                                        transform:translateY(-50%);
                                        padding:8px 10px;
                                        border-radius:12px;
                                        border:1px solid #e5e7eb;
                                        background:#f3f4f6;
                                        color:#111827;
                                        font-weight:900;
                                        font-size:12px;
                                        cursor:pointer;
                                    ">
                                Lihat
                            </button>
                        </div>
                    </div>

                </div>

                {{-- Action --}}
                <button type="submit" style="
                    width:100%;
                    margin-top:14px;
                    padding:12px 14px;
                    border-radius:14px;
                    background:#111827;
                    color:#ffffff;
                    border:none;
                    cursor:pointer;
                    font-weight:900;
                ">
                    Daftar
                </button>

                <div style="text-align:center;margin-top:12px;color:#64748b;line-height:1.6">
                    Sudah punya akun?
                    <a href="{{ url('/login') }}" style="color:#111827;font-weight:900;text-decoration:none">Login</a>
                </div>
            </form>
        </div>

    </div>

    <style>
        input:focus,
        select:focus,
        textarea:focus {
            border-color: #111827 !important;
            box-shadow: 0 0 0 4px rgba(17, 24, 39, .08);
        }

        @media (max-width: 720px) {

            #regRow1,
            #regRow2 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <script>
        (function () {
            function bindToggle(inputId, btnId) {
                const input = document.getElementById(inputId);
                const btn = document.getElementById(btnId);
                if (!input || !btn) return;

                btn.addEventListener('click', function () {
                    const hidden = input.type === 'password';
                    input.type = hidden ? 'text' : 'password';
                    btn.textContent = hidden ? 'Sembunyikan' : 'Lihat';
                    input.focus();
                });
            }

            bindToggle('regPassword', 'toggleRegPassword');
            bindToggle('regPasswordConfirm', 'toggleRegPasswordConfirm');
        })();
    </script>

@endsection