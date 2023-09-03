@extends('layouts.app', ['page' => __('Reporte Diario'), 'pageSlug' => 'reports_day'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reporte Diario</h1>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12 col-md-4 text-center">
        <span>Fecha de Consulta: <b> </b></span>
        <div class="form-group">
            <strong>{{\Carbon\Carbon::now()->format('d/m/y')}}</strong>
        </div>
    </div>
    <div class="col-12 col-md-4 text-center">
        <span>Cantidad de Registros: <b> </b></span>
        <div class="form-group">
            <strong>{{$sales->count()}}</strong>
        </div>
    </div>
    <div class="col-12 col-md-4 text-center">
        <span>Total de ingresos: <b> </b></span>
        <div class="form-group">
            <strong>{{$total}}</strong>
        </div>
    </div>
</div>
<div class="content px-3">
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            <div id="dataTableBuilder_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="btn-group"><button class="btn btn-secondary buttons-collection dropdown-toggle buttons-export btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"  aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-download"></i> Exportar&nbsp;<span class="caret"></span></span></button></div> <button class="btn btn-secondary buttons-print btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button>
            </div>
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

@endsection
