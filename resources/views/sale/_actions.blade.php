@can('sales.show')
    <a href="{{ route('sales.show', $sale) }}" class="btn btn-link btn-info btn-sm btn-icon" title="Ver"><i class="tim-icons icon-zoom-split"></i></a>
@endcan
@can('sales.pdf')
    <a href="{{ route('sales.pdf', $sale) }}" class="btn btn-link btn-primary btn-sm btn-icon" title="Descargar PDF"><i class="tim-icons icon-cloud-download-93"></i></a>
@endcan
@can('sales.print')
    <form action="{{ route('sales.print', $sale) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-link btn-success btn-sm btn-icon" title="Imprimir ticket"><i class="tim-icons icon-paper"></i></button>
    </form>
@endcan
@can('change.status.sales')
    <form action="{{ route('change.status.sales', $sale) }}" method="POST" class="d-inline"
          onsubmit="return confirm('{{ $sale->isValid() ? '¿Anular la venta #'.$sale->id.'? El stock de sus productos será devuelto.' : '¿Reactivar la venta #'.$sale->id.'? Se volverá a descontar el stock.' }}')">
        @csrf @method('PATCH')
        <button class="btn btn-link btn-sm btn-icon {{ $sale->isValid() ? 'btn-danger' : 'btn-warning' }}" title="{{ $sale->isValid() ? 'Anular' : 'Reactivar' }}">
            <i class="tim-icons {{ $sale->isValid() ? 'icon-simple-remove' : 'icon-refresh-01' }}"></i>
        </button>
    </form>
@endcan
