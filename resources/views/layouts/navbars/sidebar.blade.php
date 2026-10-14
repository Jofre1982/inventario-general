@php
    $menu = [
        'principal' => ['PRINCIPAL', 'icon-tap-02', [
            ['dashboard', 'home', 'INICIO', 'icon-laptop', null],
            ['profile', 'profile.edit', 'PERFIL', 'icon-satisfied', null],
        ]],
        'transacciones' => ['TRANSACCIONES', 'icon-coins', [
            ['sales_create', 'sales.create', 'NUEVA VENTA', 'icon-cart', 'sales.create'],
            ['sales', 'sales.index', 'VENTAS', 'icon-money-coins', 'sales.index'],
            ['purchases', 'purchases.index', 'COMPRAS', 'icon-delivery-fast', 'purchases.index'],
        ]],
        'elementos' => ['INVENTARIO', 'icon-bullet-list-67', [
            ['products', 'products.index', 'PRODUCTOS', 'icon-paper', 'products.index'],
            ['categories', 'categories.index', 'CATEGORÍAS', 'icon-single-copy-04', 'categories.index'],
        ]],
        'personas' => ['PERSONAS', 'icon-single-02', [
            ['clients', 'clients.index', 'CLIENTES', 'icon-user-run', 'clients.index'],
            ['providers', 'providers.index', 'PROVEEDORES', 'icon-bus-front-12', 'providers.index'],
        ]],
        'reportes' => ['REPORTES', 'icon-chart-bar-32', [
            ['reports_day', 'reports.day', 'DEL DÍA', 'icon-chart-pie-36', 'reports.day'],
            ['reports_date', 'reports.date', 'POR FECHAS', 'icon-notes', 'reports.date'],
        ]],
        'administrar' => ['ADMINISTRAR', 'icon-settings-gear-63', [
            ['users', 'users.index', 'USUARIOS', 'icon-badge', 'users.index'],
            ['roles', 'roles.index', 'ROLES', 'icon-key-25', 'roles.index'],
            ['business', 'business.index', 'EMPRESA', 'icon-bank', 'business.index'],
            ['printer', 'printer.index', 'IMPRESORA', 'icon-paper', 'printer.index'],
        ]],
    ];
    $user = auth()->user();
    $current = $pageSlug ?? '';
@endphp
<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-normal">
                <i class="tim-icons icon-align-left-2"></i>
                {{ \Illuminate\Support\Str::limit(\App\Models\Business::current()->name, 22) }}
            </a>
        </div>

        <ul class="nav">
            @foreach ($menu as $id => [$title, $icon, $items])
                @php($visible = array_filter($items, fn ($i) => $i[4] === null || $user->can($i[4])))
                @continue(empty($visible))
                @php($open = collect($visible)->contains(fn ($i) => $i[0] === $current))
                <li>
                    <a data-toggle="collapse" href="#menu-{{ $id }}" aria-expanded="{{ $open ? 'true' : 'false' }}">
                        <i class="tim-icons {{ $icon }}"></i>
                        <span class="nav-link-text">{{ $title }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse {{ $open ? 'show' : '' }}" id="menu-{{ $id }}">
                        <ul class="nav pl-4">
                            @foreach ($visible as [$slug, $route, $label, $itemIcon])
                                <li @if ($current === $slug) class="active" @endif>
                                    <a href="{{ route($route) }}">
                                        <i class="tim-icons {{ $itemIcon }}"></i>
                                        <p>{{ $label }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
