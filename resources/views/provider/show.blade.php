@extends('layouts.app', ['page' => 'Proveedores', 'pageSlug' => 'providers'])

@section('content')
@include('partials.page-header', ['title' => $provider->name])
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p><span class="text-muted">NIT</span><br>{{ $provider->nit }}</p>
                <p><span class="text-muted">Teléfono</span><br>{{ $provider->phone }}</p>
                <p><span class="text-muted">Correo</span><br>{{ $provider->email }}</p>
                <p><span class="text-muted">Dirección</span><br>{{ $provider->adress ?: '—' }}</p>
            </div>
            <div class="card-footer">
                @can('providers.edit')<a href="{{ route('providers.edit', $provider) }}" class="btn btn-primary btn-sm">Editar</a>@endcan
                <a href="{{ route('providers.index') }}" class="btn btn-default btn-sm">Regresar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Productos de este proveedor</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Código</th><th>Producto</th><th class="text-right">Stock</th><th class="text-right">Precio</th></tr></thead>
                    <tbody>
                    @forelse ($provider->products()->orderBy('name')->get() as $product)
                        <tr>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-right">{{ $product->stock }}</td>
                            <td class="text-right">{{ money($product->sell_price) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin productos.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
