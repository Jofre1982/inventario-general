@extends('layouts.app', ['page' => 'Productos', 'pageSlug' => 'products'])

@section('content')
@include('partials.page-header', ['title' => $product->name])
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if ($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-thumb mb-3">
                @endif
                <h3 class="mb-1">{{ money($product->sell_price) }}</h3>
                @include('partials.status', ['status' => $product->status])
            </div>
            <div class="card-footer">
                @can('products.edit')<a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">Editar</a>@endcan
                <a href="{{ route('products.index') }}" class="btn btn-default btn-sm">Regresar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6"><p><span class="text-muted">Código de barras</span><br>{{ $product->code }}</p></div>
                    <div class="col-sm-6"><p><span class="text-muted">Categoría</span><br>{{ $product->category->name ?? '—' }}</p></div>
                    <div class="col-sm-6"><p><span class="text-muted">Stock actual</span><br><b class="{{ $product->stock <= $product->min_stock ? 'text-warning' : '' }}">{{ $product->stock }}</b> (mínimo {{ $product->min_stock }})</p></div>
                    <div class="col-sm-6"><p><span class="text-muted">Proveedor</span><br>{{ $product->provider->name ?? '—' }}</p></div>
                    <div class="col-sm-6"><p><span class="text-muted">Unidades vendidas</span><br>{{ $product->saleDetails()->whereHas('sale', fn ($q) => $q->valid())->sum('quantity') }}</p></div>
                    <div class="col-sm-6"><p><span class="text-muted">Último costo de compra</span><br>
                        @php($lastCost = $product->purchaseDetails()->whereHas('purchase', fn ($q) => $q->valid())->latest('id')->value('price'))
                        {{ $lastCost !== null ? money($lastCost) : '—' }}
                    </p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
