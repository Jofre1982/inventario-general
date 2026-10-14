@extends('layouts.app', ['page' => 'Ventas', 'pageSlug' => 'sales'])

@section('content')
@include('partials.page-header', ['title' => 'Venta #' . $sale->id])
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><span class="text-muted">Fecha</span><br>{{ $sale->sale_date->format('d/m/Y h:i a') }}</div>
            <div class="col-md-3"><span class="text-muted">Cliente</span><br>{{ $sale->client->name ?? '—' }}<br><small>{{ $sale->client->document ?? '' }}</small></div>
            <div class="col-md-3"><span class="text-muted">Vendedor</span><br>{{ $sale->user->name ?? '—' }}</div>
            <div class="col-md-3"><span class="text-muted">Estado</span><br>@include('partials.status', ['status' => $sale->status])</div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Producto</th><th class="text-right">Cantidad</th><th class="text-right">Precio</th><th class="text-right">Desc.</th><th class="text-right">Subtotal</th></tr></thead>
                <tbody>
                @foreach ($sale->saleDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name ?? 'Producto eliminado' }}</td>
                        <td class="text-right">{{ $detail->quantity }}</td>
                        <td class="text-right">{{ money($detail->price) }}</td>
                        <td class="text-right">{{ $detail->discount > 0 ? rtrim(rtrim(number_format($detail->discount, 2, ',', '.'), '0'), ',') . ' %' : '—' }}</td>
                        <td class="text-right">{{ money($detail->subtotal) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="4" class="text-right">Subtotal</th><th class="text-right">{{ money($sale->subtotal) }}</th></tr>
                    <tr><th colspan="4" class="text-right">Impuesto ({{ rtrim(rtrim(number_format($sale->tax, 2, ',', '.'), '0'), ',') }} %)</th><th class="text-right">{{ money($sale->tax_amount) }}</th></tr>
                    <tr><th colspan="4" class="text-right">TOTAL</th><th class="text-right"><h4 class="mb-0">{{ money($sale->total) }}</h4></th></tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex flex-wrap justify-content-between">
        <div>@include('sale._actions')</div>
        <div>
            @can('sales.create')<a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">Nueva venta</a>@endcan
            <a href="{{ route('sales.index') }}" class="btn btn-default btn-sm">Regresar</a>
        </div>
    </div>
</div>
@endsection
