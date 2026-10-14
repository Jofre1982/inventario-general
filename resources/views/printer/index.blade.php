@extends('layouts.app', ['page' => 'Impresora', 'pageSlug' => 'printer'])

@section('content')
@include('partials.page-header', ['title' => 'Impresora de tickets'])
@php($canEdit = auth()->user()->can('printer.edit'))
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <form method="POST" action="{{ route('printer.update') }}">
            @csrf
            @method('PUT')
            <fieldset @disabled(! $canEdit)>
            <div class="card-body">
                <div class="form-group">
                    <label for="connector">Tipo de conexión *</label>
                    <select class="form-control" name="connector" id="connector">
                        @foreach (\App\Models\Printer::CONNECTORS as $value => $label)
                            <option value="{{ $value }}" @selected(old('connector', $printer->connector) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" data-show="windows cups">
                    <label for="name">Nombre de la impresora</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $printer->name) }}" placeholder="Ej: TM20">
                    <small class="form-text text-muted">En Windows: el <b>nombre con que se compartió</b> la impresora (Propiedades → Compartir).</small>
                </div>
                <div class="row" data-show="network">
                    <div class="col-8 form-group">
                        <label for="host">IP de la impresora</label>
                        <input type="text" class="form-control" name="host" id="host" value="{{ old('host', $printer->host) }}" placeholder="192.168.1.100">
                    </div>
                    <div class="col-4 form-group">
                        <label for="port">Puerto</label>
                        <input type="number" class="form-control" name="port" id="port" value="{{ old('port', $printer->port ?: 9100) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="width">Caracteres por línea *</label>
                    <select class="form-control" name="width" id="width">
                        @foreach ([32 => 'Papel de 58 mm (32)', 42 => 'Papel de 80 mm (42)', 48 => 'Papel de 80 mm, letra pequeña (48)'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('width', $printer->width) == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($canEdit)
                <div class="card-footer"><button type="submit" class="btn btn-primary">Guardar</button></div>
            @endif
            </fieldset>
            </form>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4>¿Cómo funciona?</h4>
                <p>El ticket lo envía el <b>servidor</b> donde corre el sistema:</p>
                <ul>
                    <li>Si el sistema está instalado en el mismo computador de la caja (XAMPP, Laragon), use <b>Windows</b> y comparta la impresora.</li>
                    <li>Si el sistema está en un hosting o en otro computador, use una <b>impresora de red</b> con IP fija.</li>
                </ul>
                @if ($canEdit)
                    <form method="POST" action="{{ route('printer.test') }}">
                        @csrf
                        <button class="btn btn-success"><i class="tim-icons icon-paper"></i> Imprimir página de prueba</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(function () {
        function toggle() {
            var type = $('#connector').val();
            $('[data-show]').each(function () {
                $(this).toggle($(this).data('show').split(' ').indexOf(type) !== -1);
            });
        }
        $('#connector').on('change', toggle);
        toggle();
    });
</script>
@endpush
