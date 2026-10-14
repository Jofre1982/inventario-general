@extends('layouts.app', ['page' => 'Compras', 'pageSlug' => 'purchases'])

@section('content')
@include('partials.page-header', ['title' => 'Compra #' . $purchase->id])
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><span class="text-muted">Fecha</span><br>{{ $purchase->purchase_date->format('d/m/Y h:i a') }}</div>
            <div class="col-md-3"><span class="text-muted">Proveedor</span><br>{{ $purchase->provider->name ?? '—' }}<br><small>NIT {{ $purchase->provider->nit ?? '' }}</small></div>
            <div class="col-md-3"><span class="text-muted">Registró</span><br>{{ $purchase->user->name ?? '—' }}</div>
            <div class="col-md-3"><span class="text-muted">Estado</span><br>@include('partials.status', ['status' => $purchase->status])</div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Producto</th><th class="text-right">Cantidad</th><th class="text-right">Costo unitario</th><th class="text-right">Subtotal</th></tr></thead>
                <tbody>
                @foreach ($purchase->purchaseDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name ?? 'Producto eliminado' }}</td>
                        <td class="text-right">{{ $detail->quantity }}</td>
                        <td class="text-right">{{ money($detail->price) }}</td>
                        <td class="text-right">{{ money($detail->quantity * $detail->price) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="3" class="text-right">Subtotal</th><th class="text-right">{{ money($purchase->subtotal) }}</th></tr>
                    <tr><th colspan="3" class="text-right">Impuesto ({{ rtrim(rtrim(number_format($purchase->tax, 2, ',', '.'), '0'), ',') }} %)</th><th class="text-right">{{ money($purchase->tax_amount) }}</th></tr>
                    <tr><th colspan="3" class="text-right">TOTAL</th><th class="text-right"><h4 class="mb-0">{{ money($purchase->total) }}</h4></th></tr>
                </tfoot>
            </table>
        </div>

        <hr>
        <h4>Factura del proveedor</h4>
        @if ($purchase->picture)
            <p><a href="{{ asset('image/purchases/' . $purchase->picture) }}" target="_blank" class="btn btn-sm btn-info"><i class="tim-icons icon-attach-87"></i> Ver comprobante adjunto</a></p>
        @else
            <p class="text-muted">No se ha adjuntado la factura.</p>
        @endif
        @can('upload.purchases')
            <form action="{{ route('upload.purchases', $purchase) }}" method="POST" enctype="multipart/form-data" class="form-inline">
                @csrf
                <input type="file" name="picture" accept="image/*,application/pdf" required class="mr-2">
                <button class="btn btn-sm btn-default">{{ $purchase->picture ? 'Reemplazar' : 'Adjuntar' }}</button>
            </form>
        @endcan
    </div>
    <div class="card-footer d-flex flex-wrap justify-content-between">
        <div>@include('purchase._actions')</div>
        <div><a href="{{ route('purchases.index') }}" class="btn btn-default btn-sm">Regresar</a></div>
    </div>
</div>
@endsection
