@extends('layouts.app', ['page' => __('Dato'), 'pageSlug' => 'reports_date'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reporte por fechas</h1>
            </div>
        </div>
    </div>
</section>
{!! Form::open(['route'=>'report.results','method'=>'POST']) !!}
<div class="row">
    <div class="col-12 col-md-3">
        <span>Fecha Inicial</span>
        <div class="form-group">
            <input class="form-control" type="date" value="{{old('fecha_ini')}}" name="fecha_ini" id="fecha_ini">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <span>Fecha Final</span>
        <div class="form-group">
            <input class="form-control" type="date" value="{{old('fecha_fin')}}" name="fecha_fin" id="fecha_fin">
        </div>
    </div>
    <div class="col-12 col-md-3 text-center mt-4">
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm">Consultar</button>        
        </div>
    </div>
    <div class="col-12 col-md-3 text-center">
        <span>Fecha Final: <b> </b></span>
        <div class="form-group">
            <strong>$ {{$total}}</strong>    
    </div>
</div>
{!! FORM::close() !!}
<div class="content px-3">
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            <div id="dataTableBuilder_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTableBuilder"></label></div>
            <div id="dataTableBuilder_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
            <table class="table table-striped table-bordered dataTable no-footer" id="dataTableBuilder" width="100%" role="grid" aria-describedby="dataTableBuilder_info" style="width: 100%;">
                <thead>
                    <tr role="row">
                        <th title="Id" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 83px;">ID</th>
                        <th title="Fecha" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Nombre: activate to sort column ascending" style="width: 316px;">FECHA</th>
                        <th title="Total" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">TOTAL</th>
                        <th title="Estado" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">ESTADO</th>
                        <th title="Acciones" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">ACCIONES</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <th scope="row">
                            <a href="{{route('sales.show', $sale)}}">{{$sale->id}}</a>
                        </th>
                        <td>{{$sale->sale_date}}</td>
                        <td>{{$sale->total}}</td>
                        <td>{{$sale->status}}</td>
                        <td>
                            <a href="{{route('sales.pdf', $sale)}}" class="btn btn-primary btn-link" ><i class="fa fa-download"></i></button></a>
                            <a href="{{route('sales.print', $sale)}}" class="btn btn-primary btn-link" ><i class="fa fa-print"></i></button></a>
                            <a href="#" class="btn btn-primary btn-link" ><i class="fa fa-eye"></i></button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="dataTables_info" id="dataTableBuilder_info" role="status" aria-live="polite"></div>
            <div class="dataTables_paginate paging_simple_numbers" id="dataTableBuilder_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled" id="dataTableBuilder_previous"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item next disabled" id="dataTableBuilder_next"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
        <div class="card-footer clearfix">
            <div class="float-right">
            </div>
        </div>
    </div>
</div>
</div>
<script>
    window.onload = function() {
        var fecha = new Date();
        var mes = fecha.getMonth()+1;
        var dia = fecha.getDate();
        var ano = fecha.getFullyear();
        if (mes<10) 
            dia='0'+dia;
        if (mes<10) 
            mes='0'+mes;
        document.getElementById('fecha_ini').value=ano+"-"mes+"-"+dia;
    }
</script>
@endsection
