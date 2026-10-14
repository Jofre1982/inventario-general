@can('purchases.show')
    <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-link btn-info btn-sm btn-icon" title="Ver"><i class="tim-icons icon-zoom-split"></i></a>
@endcan
@can('purchases.pdf')
    <a href="{{ route('purchases.pdf', $purchase) }}" class="btn btn-link btn-primary btn-sm btn-icon" title="Descargar PDF"><i class="tim-icons icon-cloud-download-93"></i></a>
@endcan
@can('change.status.purchases')
    <form action="{{ route('change.status.purchases', $purchase) }}" method="POST" class="d-inline"
          onsubmit="return confirm('{{ $purchase->isValid() ? '¿Anular la compra #'.$purchase->id.'? Sus cantidades se descontarán del stock.' : '¿Reactivar la compra #'.$purchase->id.'? Sus cantidades se sumarán de nuevo al stock.' }}')">
        @csrf @method('PATCH')
        <button class="btn btn-link btn-sm btn-icon {{ $purchase->isValid() ? 'btn-danger' : 'btn-warning' }}" title="{{ $purchase->isValid() ? 'Anular' : 'Reactivar' }}">
            <i class="tim-icons {{ $purchase->isValid() ? 'icon-simple-remove' : 'icon-refresh-01' }}"></i>
        </button>
    </form>
@endcan
