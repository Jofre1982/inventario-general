@extends('layouts.app', ['page' => 'Ventas', 'pageSlug' => 'sales'])

@section('content')
@include('partials.page-header', ['title' => 'Ventas', 'action' => route('sales.create'), 'can' => 'sales.create', 'label' => 'Nueva venta'])
<div class="card">
    <div class="card-body">
        @include('partials.search', ['placeholder' => 'N.º de venta, cliente o documento'])
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>#</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th>Estado</th><th class="text-right">Total</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td>@can('sales.show')<a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a>@else{{ $sale->id }}@endcan</td>
                        <td>{{ $sale->sale_date->format('d/m/Y h:i a') }}</td>
                        <td>{{ $sale->client->name ?? '—' }}</td>
                        <td>{{ $sale->user->name ?? '—' }}</td>
                        <td>@include('partials.status', ['status' => $sale->status])</td>
                        <td class="text-right">{{ money($sale->total) }}</td>
                        <td class="text-right">@include('sale._actions')</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No hay ventas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $sales->links() }}
    </div>
</div>
@endsection
