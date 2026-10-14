@extends('layouts.app', ['page' => 'Productos', 'pageSlug' => 'products'])

@section('content')
@include('partials.page-header', ['title' => 'Productos', 'action' => route('products.create'), 'can' => 'products.create'])
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-start">
            @include('partials.search', ['placeholder' => 'Nombre o código de barras'])
            <div class="mb-3">
                @if (request()->boolean('low'))
                    <a href="{{ route('products.index', request()->except(['low', 'page'])) }}" class="btn btn-sm btn-warning">Mostrando stock bajo · ver todos</a>
                @else
                    <a href="{{ route('products.index', request()->except('page') + ['low' => 1]) }}" class="btn btn-sm btn-default">Solo stock bajo</a>
                @endif
                @if (request('category'))
                    <a href="{{ route('products.index', request()->except(['category', 'page'])) }}" class="btn btn-sm btn-info">Quitar filtro de categoría</a>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Código</th><th>Nombre</th><th>Categoría</th><th class="text-right">Precio</th><th class="text-right">Stock</th><th>Estado</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><small>{{ $product->code }}</small></td>
                        <td>@can('products.show')<a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>@else{{ $product->name }}@endcan</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td class="text-right">{{ money($product->sell_price) }}</td>
                        <td class="text-right">
                            <span class="{{ $product->stock <= $product->min_stock ? 'text-warning font-weight-bold' : '' }}" title="Mínimo: {{ $product->min_stock }}">{{ $product->stock }}</span>
                        </td>
                        <td>@include('partials.status', ['status' => $product->status])</td>
                        <td class="text-right">
                            @can('change.status.products')
                                <form action="{{ route('change.status.products', $product) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-link btn-sm btn-icon {{ $product->isActive() ? 'btn-warning' : 'btn-success' }}" title="{{ $product->isActive() ? 'Desactivar' : 'Activar' }}">
                                        <i class="tim-icons {{ $product->isActive() ? 'icon-button-pause' : 'icon-button-power' }}"></i>
                                    </button>
                                </form>
                            @endcan
                            @can('products.edit')
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-link btn-info btn-sm btn-icon" title="Editar"><i class="tim-icons icon-pencil"></i></a>
                            @endcan
                            @can('products.destroy')
                                @include('partials.delete', ['action' => route('products.destroy', $product)])
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No hay productos.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection
