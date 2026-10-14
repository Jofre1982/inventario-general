@extends('layouts.app', ['page' => 'Reporte por fechas', 'pageSlug' => 'reports_date'])

@section('content')
@include('partials.page-header', ['title' => 'Reporte por fechas'])
<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.date') }}" class="row align-items-end">
            <div class="col-md-4 form-group">
                <label for="fecha_ini">Desde</label>
                <input class="form-control" type="date" name="fecha_ini" id="fecha_ini" value="{{ $from->toDateString() }}" max="{{ now()->toDateString() }}">
            </div>
            <div class="col-md-4 form-group">
                <label for="fecha_fin">Hasta</label>
                <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" value="{{ $to->toDateString() }}" max="{{ now()->toDateString() }}">
            </div>
            <div class="col-md-4 form-group">
                <button type="submit" class="btn btn-primary">Consultar</button>
            </div>
        </form>
    </div>
</div>
@include('report._results')
@endsection
