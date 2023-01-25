@extends('layouts.app', ['page' => __('Categorias'), 'pageSlug' => 'categories'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Categorias</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('categories.create') }}">
                    Nuevo
                </a>
            </div>
        </div>
    </div>
</section>
<div class="content px-3">
    <div class="clearfix"></div>
        <div class="card">
            <div class="card-body p-0">
                <div id="dataTableBuilder_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="btn-group"><button class="btn btn-secondary buttons-collection dropdown-toggle buttons-export btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button" aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-download"></i> Exportar&nbsp;<span class="caret"></span></span></button></div> <button class="btn btn-secondary buttons-print btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button> <button class="btn btn-secondary buttons-reset btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-undo"></i> Reset</span></button> <button class="btn btn-secondary buttons-reload btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-refresh"></i> Actualizar</span></button>
                </div>
                <div id="dataTableBuilder_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTableBuilder"></label></div>
                <div id="dataTableBuilder_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
                <table class="table table-striped table-bordered dataTable no-footer" id="dataTableBuilder" width="100%" role="grid" aria-describedby="dataTableBuilder_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th title="Id" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Id: activate to sort column ascending" style="width: 316px;">ID</th>
                            <th title="Nombre" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Nombre: activate to sort column ascending" style="width: 316px;">NOMBRE</th>
                            <th title="Cantidad" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 83px;">DESCRIPCION </th>
                            <th title="Acciones" width="120px" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Acciones" style="width: 123px;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{$category->id}}</th>
                            <td>
                                <a href="{{route('categories.show',$category)}}"></a>
                            </td>
                            <td>{{$category->descriptions}}</td>
                            <td style="width:50px;">
                            {!!Form::open(['route'=>['categories.destroy',
                            $category],'method'=>'DELETE']) !!}

                            <a class="jsgrid-button jsgrid-edit-button" href="{{route('categories.edit',$category)}}" title="Editar">
                                <i class="far fa-edit"></i>
                            </a>
                            <a class="jsgrid-button jsgrid-delet-button"type="submit" title="Eliminar">
                                <i class="far fa-trash-alt"></i>
                            </a>
                            {!! Form::close() !!}
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