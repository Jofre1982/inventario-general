<div class="row">
    <div class="col-md-4"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Total vendido</p><p class="kpi-value text-success">{{ money($total) }}</p>
    </div></div></div>
    <div class="col-md-4"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Ventas válidas</p><p class="kpi-value">{{ $count }}</p>
        <small class="text-muted">Promedio por venta: {{ money($count ? $total / $count : 0) }}</small>
    </div></div></div>
    <div class="col-md-4"><div class="card kpi"><div class="card-body">
        <p class="kpi-label">Ventas anuladas</p><p class="kpi-value {{ $canceled ? 'text-danger' : '' }}">{{ $canceled }}</p>
    </div></div></div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Ventas</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>#</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th>Estado</th><th class="text-right">Total</th><th class="text-right"></th></tr></thead>
                        <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->sale_date->format('d/m/Y h:i a') }}</td>
                                <td>{{ $sale->client->name ?? '—' }}</td>
                                <td>{{ $sale->user->name ?? '—' }}</td>
                                <td>@include('partials.status', ['status' => $sale->status])</td>
                                <td class="text-right">{{ money($sale->total) }}</td>
                                <td class="text-right">@include('sale._actions')</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No hay ventas en este periodo.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Productos más vendidos</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Producto</th><th class="text-right">Unid.</th><th class="text-right">Valor</th></tr></thead>
                    <tbody>
                    @forelse ($topProducts as $row)
                        <tr><td>{{ $row->name }}</td><td class="text-right">{{ (int) $row->units }}</td><td class="text-right">{{ money($row->amount) }}</td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Sin datos.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
