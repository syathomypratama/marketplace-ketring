@php
    $user = auth()->user();
    $role = $user?->role;
@endphp

<aside class="sb">
    <div class="sb__top">
        <div class="sb__brand">
            <div class="sb__logo">MK</div>
            <div>
                <div class="sb__title">Marketplace Katering</div>
                <div class="sb__sub">{{ $role ? ucfirst($role) : 'Guest' }}</div>
            </div>
        </div>
    </div>

    <nav class="sb__nav">
        @if($role === 'merchant')
            <a class="sb__link @if(request()->routeIs('merchant.dashboard')) is-active @endif"
                href="{{ route('merchant.dashboard') }}">Dashboard</a>
            <a class="sb__link @if(request()->routeIs('merchant.profile.*')) is-active @endif"
                href="{{ route('merchant.profile.edit') }}">Profil Merchant</a>
            <a class="sb__link @if(request()->routeIs('merchant.menus.*')) is-active @endif"
                href="{{ route('merchant.menus.index') }}">Menu</a>
            <a class="sb__link @if(request()->routeIs('merchant.orders.*')) is-active @endif"
                href="{{ route('merchant.orders.index') }}">Order Masuk</a>

        @elseif($role === 'customer')
            <a class="sb__link @if(request()->routeIs('customer.dashboard')) is-active @endif"
                href="{{ route('customer.dashboard') }}">Dashboard</a>
            <a class="sb__link @if(request()->routeIs('customer.caterings.*')) is-active @endif"
                href="{{ route('customer.caterings.index') }}">Cari Katering</a>
            <a class="sb__link @if(request()->routeIs('customer.orders.*')) is-active @endif"
                href="{{ route('customer.orders.index') }}">Order Saya</a>

        @else
            <a class="sb__link" href="/">Home</a>
        @endif
    </nav>

    <div class="sb__bottom">
        <div class="sb__user">
            <div class="sb__avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
            <div class="sb__userMeta">
                <div class="sb__userName">{{ $user->name ?? 'User' }}</div>
                <div class="sb__userEmail">{{ $user->email ?? '' }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb__logout">Logout</button>
        </form>
    </div>
</aside>