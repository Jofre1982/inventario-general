@extends('layouts.app', ['page' => 'Compras', 'pageSlug' => 'purchases'])

@section('content')
@include('partials.page-header', ['title' => 'Compras', 'action' => route('purchases.create'), 'can' => 'purchases.create', 'label' => 'Nueva compra'])
<div class="card">
    <div class="card-body">
        @include('partials.search', ['placeholder' => 'N.º de compra o proveedor'])
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>#</th><th>Fecha</th><th>Proveedor</th><th>Registró</th><th>Estado</th><th class="text-right">Total</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td>@can('purchases.show')<a href="{{ route('purchases.show', $purchase) }}">{{ $purchase->id }}</a>@else{{ $purchase->id }}@endcan</td>
                        <td>{{ $purchase->purchase_date->format('d/m/Y h:i a') }}</td>
                        <td>{{ $purchase->provider->name ?? '—' }}</td>
                        <td>{{ $purchase->user->name ?? '—' }}</td>
                        <td>@include('partials.status', ['status' => $purchase->status])</td>
                        <td class="text-right">{{ money($purchase->total) }}</td>
                        <td class="text-right">@include('purchase._actions')</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">No hay compras.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $purchases->links() }}
    </div>
</div>
@endsection
