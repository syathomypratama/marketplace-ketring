@extends('layouts.app', ['title' => 'Login'])
@section('content')

    <div style="max-width:520px;margin:0 auto">

        <div class="card" style="
                            padding:22px 22px;
                            border-radius:20px;
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            box-shadow:0 14px 30px rgba(15,23,42,.08);
                        ">

            <div style="margin-bottom:16px">
                <h2 style="margin:0;font-size:24px;font-weight:900;color:#0f172a">Masuk</h2>
                <div style="margin-top:6px;color:#64748b;line-height:1.6">
                    Silakan masuk untuk melanjutkan.
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

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div style="display:flex;flex-direction:column;gap:12px">

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">
                            Email
                        </label>
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

                    <div>
                        <label style="display:block;font-weight:900;color:#0f172a;margin-bottom:6px">
                            Password
                        </label>

                        {{-- Wrapper supaya tombol toggle bisa nempel kanan --}}
                        <div style="position:relative">
                            <input id="passwordInput" type="password" name="password" required
                                placeholder="Masukkan password" style="
                                                        width:100%;
                                                        padding:12px 92px 12px 12px; /* kanan dibuat lebar utk tombol */
                                                        border-radius:14px;
                                                        border:1px solid #e5e7eb;
                                                        outline:none;
                                                        background:#ffffff;
                                                   ">

                            <button id="togglePasswordBtn" type="button" style="
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

                    <button type="submit" style="
                                        width:100%;
                                        padding:12px 14px;
                                        border-radius:14px;
                                        background:#111827;
                                        color:#ffffff;
                                        border:none;
                                        cursor:pointer;
                                        font-weight:900;
                                    ">
                        Masuk
                    </button>

                    <div style="text-align:center;color:#64748b;line-height:1.6">
                        Belum punya akun?
                        <a href="{{ url('/register') }}" style="color:#111827;font-weight:900;text-decoration:none">
                            Register
                        </a>
                    </div>

                </div>
            </form>
        </div>

    </div>

    <style>
        input:focus {
            border-color: #111827 !important;
            box-shadow: 0 0 0 4px rgba(17, 24, 39, .08);
        }

        #togglePasswordBtn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(17, 24, 39, .10);
        }
    </style>

    <script>
        (function () {
            const input = document.getElementById('passwordInput');
            const btn = document.getElementById('togglePasswordBtn');

            if (!input || !btn) return;

            btn.addEventListener('click', function () {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                btn.textContent = isHidden ? 'Sembunyikan' : 'Lihat';
                input.focus();
            });
        })();
    </script>

@endsection