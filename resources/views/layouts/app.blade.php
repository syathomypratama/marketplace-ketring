<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Marketplace Katering' }}</title>

    <style>
        /* =============== Base =============== */
        :root {
            --bg: #f6f7fb;
            --text: #0f172a;
            --muted: #64748b;
            --card: #ffffff;
            --border: #e5e7eb;

            --side: #0b1220;
            --sideText: #e5e7eb;
            --sideMuted: #94a3b8;
            --sideHover: rgba(255, 255, 255, .06);
            --sideActive: rgba(255, 255, 255, .12);

            --btn: #111827;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial;
            background: var(--bg);
            color: var(--text);
        }

        a {
            color: inherit
        }

        .muted {
            color: var(--muted)
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin: 10px 0 6px;
            color: #334155;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            background: #fff;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #cbd5e1
        }

        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 10px;
            background: var(--btn);
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            opacity: .95
        }

        /* Helpers */
        .row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        @media (max-width: 720px) {
            .row {
                grid-template-columns: 1fr
            }
        }

        .table-wrap {
            width: 100%;
            overflow: auto;
            /* tabel aman di mobile */
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
            font-size: 13px
        }

        /* =============== Layout =============== */
        .app {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar container: fixed full height (desktop) */
        .sbWrap {
            position: fixed;
            inset: 0 auto 0 0;
            /* top 0 bottom 0 left 0 */
            width: 270px;
            height: 100vh;
            z-index: 50;
            background: var(--side);
            border-right: 1px solid rgba(255, 255, 255, .06);
        }

        /* Sidebar */
        .sb {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            color: var(--sideText);
            overflow: auto;
        }

        .sb__top {
            padding: 14px
        }

        .sb__brand {
            display: flex;
            gap: 10px;
            align-items: center
        }

        .sb__logo {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #111827;
            display: grid;
            place-items: center;
            font-weight: 900
        }

        .sb__title {
            font-weight: 800
        }

        .sb__sub {
            font-size: 12px;
            color: var(--sideMuted);
            margin-top: 2px
        }

        .sb__nav {
            padding: 6px
        }

        .sb__link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--sideText);
            margin: 4px 6px;
        }

        .sb__link:hover {
            background: var(--sideHover)
        }

        .sb__link.is-active {
            background: var(--sideActive)
        }

        .sb__bottom {
            margin-top: auto;
            padding: 14px;
            border-top: 1px solid rgba(255, 255, 255, .08)
        }

        .sb__user {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px
        }

        .sb__avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .10);
            display: grid;
            place-items: center;
            font-weight: 800
        }

        .sb__userName {
            font-weight: 700
        }

        .sb__userEmail {
            font-size: 12px;
            color: var(--sideMuted)
        }

        .sb__logout {
            width: 100%;
            background: rgba(255, 255, 255, .10);
            color: var(--sideText)
        }

        .sb__logout:hover {
            background: rgba(255, 255, 255, .14)
        }

        /* Main */
        .main {
            margin-left: 270px;
            /* geser sesuai sidebar */
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar (mobile) */
        .topbar {
            display: none;
            position: sticky;
            top: 0;
            z-index: 30;
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 12px 14px;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .topbar__btn {
            background: var(--btn);
            border-radius: 10px;
            padding: 8px 10px;
            color: #fff;
        }

        /* Content */
        .content {
            padding: 16px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        @media (max-width: 920px) {
            .content {
                padding: 12px
            }
        }

        /* Overlay for mobile sidebar */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, .55);
            z-index: 40;
        }

        /* =============== Mobile offcanvas =============== */
        @media (max-width: 920px) {
            .topbar {
                display: flex
            }

            .main {
                margin-left: 0
            }

            .sbWrap {
                transform: translateX(-100%);
                transition: transform .18s ease;
                width: 270px;
            }

            .sbWrap.is-open {
                transform: translateX(0)
            }

            .overlay.is-open {
                display: block
            }
        }
    </style>
</head>

<body>
    @php
        $user = auth()->user();
        $isAuth = auth()->check();
    @endphp

    @if(!$isAuth)
        {{-- Guest: tanpa sidebar --}}
        <div class="content">
            @yield('content')
        </div>
    @else
        <div class="overlay" id="overlay" onclick="toggleSidebar(false)"></div>

        <div class="app">
            <div class="sbWrap" id="sbWrap">
                @include('layouts.partials.sidebar')
            </div>

            <div class="main">
                <div class="topbar">
                    <button type="button" class="topbar__btn" onclick="toggleSidebar(true)">☰</button>
                    <div style="font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        {{ $title ?? 'Marketplace Katering' }}
                    </div>
                    <div class="muted"
                        style="font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:120px">
                        {{ $user->name }}
                    </div>
                </div>

                <div class="content">
                    {{-- Flash message --}}
                    @if(session('success'))
                        <div class="card" style="border-color:#86efac;background:#f0fdf4">
                            <b>Sukses:</b> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="card" style="border-color:#fecaca;background:#fff1f2">
                            <b>Terjadi kesalahan:</b>
                            <ul style="margin:8px 0 0 18px">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <script>
            function toggleSidebar(open) {
                const sb = document.getElementById('sbWrap');
                const ov = document.getElementById('overlay');
                if (open) {
                    sb.classList.add('is-open');
                    ov.classList.add('is-open');
                } else {
                    sb.classList.remove('is-open');
                    ov.classList.remove('is-open');
                }
            }

            // close sidebar when resizing to desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth > 920) toggleSidebar(false);
            });
        </script>
    @endif
</body>

</html>