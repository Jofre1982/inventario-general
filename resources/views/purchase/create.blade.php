@extends('layouts.app', ['page' => 'Nueva compra', 'pageSlug' => 'purchases'])

@section('content')
@include('partials.page-header', ['title' => 'Nueva compra'])
<div class="alert alert-info">Al registrar la compra, las cantidades se <b>suman al stock</b> de cada producto.</div>
<form method="POST" action="{{ route('purchases.store') }}" autocomplete="off">
@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group position-relative mb-0">
                    <label for="scan">Producto <small class="text-muted">— escanee el código de barras o escriba el nombre y presione Enter</small></label>
                    <input type="text" id="scan" class="form-control scan-box" placeholder="Código de barras o nombre..." autofocus>
                    <div id="scan-results" class="list-group scan-results" style="display:none"></div>
                    @can('products.create')
                        <small><a href="{{ route('products.create') }}" target="_blank">+ Crear producto nuevo</a></small>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table line-items">
                        <thead><tr><th>Producto</th><th style="width:110px">Cant.</th><th style="width:160px">Costo unitario</th><th class="text-right">Subtotal</th><th></th></tr></thead>
                        <tbody id="lines"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card totals-box">
            <div class="card-body">
                <div class="form-group">
                    <label for="provider_id">Proveedor *</label>
                    <select class="form-control" name="provider_id" id="provider_id" required>
                        <option value="">Seleccione...</option>
                        @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}" @selected(old('provider_id') == $provider->id)>{{ $provider->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tax">Impuesto (%)</label>
                    <input type="number" class="form-control" name="tax" id="tax" value="{{ old('tax', 0) }}" min="0" max="100" step="0.01">
                </div>
                <hr>
                <p class="d-flex justify-content-between mb-1"><span>Subtotal</span><span id="t-subtotal">$ 0</span></p>
                <p class="d-flex justify-content-between mb-1"><span>Impuesto</span><span id="t-tax">$ 0</span></p>
                <p class="d-flex justify-content-between align-items-center mb-3"><span>TOTAL</span><span id="t-total" class="total-final">$ 0</span></p>
                <button type="submit" id="save" class="btn btn-primary btn-block btn-lg" disabled>Registrar compra</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-default btn-block">Cancelar</a>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('js')
<script>
    $(function () {
        new Inventario.LineEditor({
            mode: 'purchase',
            lookupUrl: @json(route('products.lookup')),
            scan: '#scan', results: '#scan-results', body: '#lines', tax: '#tax', submit: '#save',
            subtotal: '#t-subtotal', taxAmount: '#t-tax', total: '#t-total'
        });
    });
</script>
@endpush
