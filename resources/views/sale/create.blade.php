@extends('layouts.app', ['page' => 'Nueva venta', 'pageSlug' => 'sales_create'])

@section('content')
@include('partials.page-header', ['title' => 'Nueva venta'])
<form method="POST" action="{{ route('sales.store') }}" id="sale-form" autocomplete="off">
@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group position-relative mb-0">
                    <label for="scan">Producto <small class="text-muted">— escanee el código de barras o escriba el nombre y presione Enter</small></label>
                    <input type="text" id="scan" class="form-control scan-box" placeholder="Código de barras o nombre..." autofocus>
                    <div id="scan-results" class="list-group scan-results" style="display:none"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table line-items">
                        <thead><tr><th>Producto</th><th style="width:110px">Cant.</th><th class="text-right">Precio</th><th style="width:110px">Desc. %</th><th class="text-right">Subtotal</th><th></th></tr></thead>
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
                    <label for="client_id">Cliente *</label>
                    <select class="form-control" name="client_id" id="client_id" required>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $clients->firstWhere('document', '222222222222')->id ?? null) == $client->id)>{{ $client->name }} — {{ $client->document }}</option>
                        @endforeach
                    </select>
                    @can('clients.create')
                        <small><a href="{{ route('clients.create') }}" target="_blank">+ Registrar cliente nuevo</a></small>
                    @endcan
                </div>
                <div class="form-group">
                    <label for="tax">Impuesto (%)</label>
                    <input type="number" class="form-control" name="tax" id="tax" value="{{ old('tax', 0) }}" min="0" max="100" step="0.01">
                    <small class="text-muted">Deje 0 si los precios ya incluyen IVA.</small>
                </div>
                <hr>
                <p class="d-flex justify-content-between mb-1"><span>Subtotal</span><span id="t-subtotal">$ 0</span></p>
                <p class="d-flex justify-content-between mb-1"><span>Impuesto</span><span id="t-tax">$ 0</span></p>
                <p class="d-flex justify-content-between align-items-center mb-3"><span>TOTAL</span><span id="t-total" class="total-final">$ 0</span></p>

                <div class="form-group">
                    <label for="cash">Paga con (opcional)</label>
                    <input type="number" class="form-control" id="cash" min="0" step="any" placeholder="Para calcular el cambio">
                    <p class="mt-2 mb-0">Cambio: <b id="change">$ 0</b></p>
                </div>

                <button type="submit" id="save" class="btn btn-primary btn-block btn-lg" disabled>Registrar venta</button>
                <a href="{{ route('sales.index') }}" class="btn btn-default btn-block">Cancelar</a>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('js')
<script>
    $(function () {
        var editor = new Inventario.LineEditor({
            mode: 'sale',
            lookupUrl: @json(route('products.lookup')),
            scan: '#scan', results: '#scan-results', body: '#lines', tax: '#tax', submit: '#save',
            subtotal: '#t-subtotal', taxAmount: '#t-tax', total: '#t-total'
        });

        function updateChange() {
            var total = Number($('#t-total').text().replace(/[^\d,]/g, '').replace(',', '.')) || 0;
            var cash = parseFloat($('#cash').val()) || 0;
            $('#change').text(Inventario.money(cash > total ? cash - total : 0));
        }
        $('#cash').on('input', updateChange);
        $('#lines, #tax').on('input change click', function () { setTimeout(updateChange); });
    });
</script>
@endpush
