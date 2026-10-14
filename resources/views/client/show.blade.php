@extends('layouts.app', ['page' => 'Clientes', 'pageSlug' => 'clients'])

@section('content')
@include('partials.page-header', ['title' => $client->name])
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p><span class="text-muted">Documento</span><br>{{ $client->document }}</p>
                <p><span class="text-muted">Teléfono</span><br>{{ $client->phone ?: '—' }}</p>
                <p><span class="text-muted">Correo</span><br>{{ $client->email ?: '—' }}</p>
                <p><span class="text-muted">Dirección</span><br>{{ $client->adress ?: '—' }}</p>
            </div>
            <div class="card-footer">
                @can('clients.edit')<a href="{{ route('clients.edit', $client) }}" class="btn btn-primary btn-sm">Editar</a>@endcan
                <a href="{{ route('clients.index') }}" class="btn btn-default btn-sm">Regresar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Últimas compras del cliente</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>#</th><th>Fecha</th><th>Estado</th><th class="text-right">Total</th></tr></thead>
                    <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>@can('sales.show')<a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a>@else{{ $sale->id }}@endcan</td>
                            <td>{{ $sale->sale_date->format('d/m/Y h:i a') }}</td>
                            <td>@include('partials.status', ['status' => $sale->status])</td>
                            <td class="text-right">{{ money($sale->total) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin ventas.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
