@extends('layouts.app', ['page' => __('Productos'), 'pageSlug' => 'products'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Lista de Productos</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('products.create') }}">
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
                        <th title="Id" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 83px;">ID</th>
                        <th title="Nombre" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Nombre: activate to sort column ascending" style="width: 316px;">NOMBRE</th>
                        <th title="Stock" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 83px;">STOCK</th>
                        <th title="Estado" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">ESTADO</th>
                        <th title="Categoria" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">CATEGORIA</th>
                        <th title="Acciones" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Descripcion: activate to sort column ascending" style="width: 316px;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>
                            <a href="{{route('products.show',$product   )}}">{{$product->name}}</a>
                        </td>
                        <td>{{$product->stock}}</td>
                        
                        <td>{{$product->status}}</td>
                        
                        <td>{{$product->category->name}}</td>
                        <td style="width:50px;">

                            {!!Form::open(['route'=>['products.destroy', $product],'method'=>'DELETE']) !!}
                            <a href="{{route('products.edit',$product)}}" class="btn btn-default btn-xs">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
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