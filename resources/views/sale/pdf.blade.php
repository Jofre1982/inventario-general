@extends('partials.pdf-layout', ['title' => 'Comprobante de venta', 'number' => $sale->id, 'date' => $sale->sale_date])

@section('body')
@unless ($sale->isValid())<div class="canceled">VENTA ANULADA</div>@endunless
<table class="info">
    <tr>
        <td><b>Cliente</b><br>{{ $sale->client->name ?? '—' }}<br>Documento: {{ $sale->client->document ?? '—' }}
            @if ($sale->client && $sale->client->phone)<br>Tel: {{ $sale->client->phone }}@endif</td>
        <td><b>Atendido por</b><br>{{ $sale->user->name ?? '—' }}<br>{{ $sale->user->email ?? '' }}</td>
    </tr>
</table>
<table class="items">
    <thead><tr><th>Producto</th><th class="r">Cant.</th><th class="r">Precio</th><th class="r">Desc.</th><th class="r">Subtotal</th></tr></thead>
    <tbody>
    @foreach ($sale->saleDetails as $detail)
        <tr>
            <td>{{ $detail->product->name ?? 'Producto eliminado' }}</td>
            <td class="r">{{ $detail->quantity }}</td>
            <td class="r">{{ money($detail->price) }}</td>
            <td class="r">{{ $detail->discount > 0 ? rtrim(rtrim(number_format($detail->discount, 2, ',', '.'), '0'), ',') . ' %' : '—' }}</td>
            <td class="r">{{ money($detail->subtotal) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tbody class="totals">
        <tr><td colspan="4" class="r">Subtotal</td><td class="r">{{ money($sale->subtotal) }}</td></tr>
        <tr><td colspan="4" class="r">Impuesto ({{ rtrim(rtrim(number_format($sale->tax, 2, ',', '.'), '0'), ',') }} %)</td><td class="r">{{ money($sale->tax_amount) }}</td></tr>
        <tr class="grand"><td colspan="4" class="r">TOTAL</td><td class="r">{{ money($sale->total) }}</td></tr>
    </tbody>
</table>
@endsection
