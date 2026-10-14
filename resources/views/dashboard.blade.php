@extends('layouts.app', ['page' => 'Inicio', 'pageSlug' => 'dashboard'])

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Hola, {{ auth()->user()->name }}</h2>
    @can('sales.create')
        <a href="{{ route('sales.create') }}" class="btn btn-primary"><i class="tim-icons icon-cart"></i> Nueva venta</a>
    @endcan
</div>

<div class="row">
    <div class="col-lg-3 col-md-6"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Ventas de hoy</p>
        <p class="kpi-value text-success">{{ money($todayTotal) }}</p>
        <small class="text-muted">{{ $todayCount }} {{ $todayCount === 1 ? 'venta' : 'ventas' }}</small>
    </div></div></div>
    <div class="col-lg-3 col-md-6"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Ventas del mes</p>
        <p class="kpi-value">{{ money($monthTotal) }}</p>
        <small class="text-muted">{{ now()->translatedFormat('F Y') }}</small>
    </div></div></div>
    <div class="col-lg-3 col-md-6"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Compras del mes</p>
        <p class="kpi-value">{{ money($monthPurchases) }}</p>
    </div></div></div>
    <div class="col-lg-3 col-md-6"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Productos activos</p>
        <p class="kpi-value">{{ $productCount }}</p>
        @if ($lowStockCount)
            <small class="text-warning">{{ $lowStockCount }} con stock bajo</small>
        @endif
    </div></div></div>
</div>

<div class="card card-chart">
    <div class="card-header">
        <h5 class="card-category">Últimos 14 días</h5>
        <h3 class="card-title">Ventas por día</h3>
    </div>
    <div class="card-body">
        <div class="chart-area"><canvas id="salesChart"></canvas></div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Stock bajo</h4>
                @can('products.index')<a href="{{ route('products.index', ['low' => 1]) }}" class="btn btn-link btn-sm">Ver todos</a>@endcan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Producto</th><th class="text-right">Stock</th><th class="text-right">Mínimo</th></tr></thead>
                    <tbody>
                    @forelse ($lowStock as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="text-right {{ $product->stock <= 0 ? 'text-danger' : 'text-warning' }}"><b>{{ $product->stock }}</b></td>
                            <td class="text-right">{{ $product->min_stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Todo el inventario está por encima del mínimo.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Últimas ventas</h4>
                @can('sales.index')<a href="{{ route('sales.index') }}" class="btn btn-link btn-sm">Ver todas</a>@endcan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>#</th><th>Hora</th><th>Cliente</th><th class="text-right">Total</th></tr></thead>
                    <tbody>
                    @forelse ($latestSales as $sale)
                        <tr>
                            <td>@can('sales.show')<a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a>@else{{ $sale->id }}@endcan</td>
                            <td>{{ $sale->sale_date->isToday() ? $sale->sale_date->format('h:i a') : $sale->sale_date->format('d/m h:i a') }}</td>
                            <td>{{ $sale->client->name ?? '—' }}</td>
                            <td class="text-right {{ $sale->isValid() ? '' : 'text-muted' }}">
                                @unless ($sale->isValid())<small>(anulada)</small>@endunless {{ money($sale->total) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Aún no hay ventas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
<script>
    $(function () {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 230, 0, 50);
        gradient.addColorStop(1, 'rgba(66,134,121,0.15)');
        gradient.addColorStop(0, 'rgba(66,134,121,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chart['labels']),
                datasets: [{
                    label: 'Ventas',
                    data: @json($chart['values']),
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#00d6b4',
                    borderWidth: 2,
                    pointBackgroundColor: '#00d6b4',
                    pointRadius: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: { display: false },
                tooltips: { callbacks: { label: function (item) { return Inventario.money(item.yLabel); } } },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, fontColor: '#9a9a9a', callback: function (v) { return Inventario.money(v); } }, gridLines: { color: 'rgba(29,140,248,0.1)' } }],
                    xAxes: [{ ticks: { fontColor: '#9a9a9a' }, gridLines: { display: false } }]
                }
            }
        });
    });
</script>
@endpush
