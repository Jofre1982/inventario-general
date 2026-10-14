@extends('partials.pdf-layout', ['title' => 'Comprobante de compra', 'number' => $purchase->id, 'date' => $purchase->purchase_date])

@section('body')
@unless ($purchase->isValid())<div class="canceled">COMPRA ANULADA</div>@endunless
<table class="info">
    <tr>
        <td><b>Proveedor</b><br>{{ $purchase->provider->name ?? '—' }}<br>NIT: {{ $purchase->provider->nit ?? '—' }}
            @if ($purchase->provider)<br>Tel: {{ $purchase->provider->phone }}@endif</td>
        <td><b>Registrada por</b><br>{{ $purchase->user->name ?? '—' }}<br>{{ $purchase->user->email ?? '' }}</td>
    </tr>
</table>
<table class="items">
    <thead><tr><th>Producto</th><th class="r">Cant.</th><th class="r">Costo unitario</th><th class="r">Subtotal</th></tr></thead>
    <tbody>
    @foreach ($purchase->purchaseDetails as $detail)
        <tr>
            <td>{{ $detail->product->name ?? 'Producto eliminado' }}</td>
            <td class="r">{{ $detail->quantity }}</td>
            <td class="r">{{ money($detail->price) }}</td>
            <td class="r">{{ money($detail->quantity * $detail->price) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tbody class="totals">
        <tr><td colspan="3" class="r">Subtotal</td><td class="r">{{ money($purchase->subtotal) }}</td></tr>
        <tr><td colspan="3" class="r">Impuesto ({{ rtrim(rtrim(number_format($purchase->tax, 2, ',', '.'), '0'), ',') }} %)</td><td class="r">{{ money($purchase->tax_amount) }}</td></tr>
        <tr class="grand"><td colspan="3" class="r">TOTAL</td><td class="r">{{ money($purchase->total) }}</td></tr>
    </tbody>
</table>
@endsection
