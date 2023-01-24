@extends('layouts.app', ['page' => __('Clientes'), 'pageSlug' => 'clients'])

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Clientes</h1>
      </div>
      <div class="col-sm-6">
        <a class="btn btn-primary float-right" href="{{ route('clients.create') }}">
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
                <div id="dataTableBuilder_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"><div class="dt-buttons btn-group flex-wrap">          <button class="btn btn-secondary buttons-create btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-plus"></i> Create</span></button> <div class="btn-group"><button class="btn btn-secondary buttons-collection dropdown-toggle buttons-export btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button" aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-download"></i> Export&nbsp;<span class="caret"></span></span></button></div> <button class="btn btn-secondary buttons-print btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-print"></i> Print</span></button> <button class="btn btn-secondary buttons-reset btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-undo"></i> Reset</span></button> <button class="btn btn-secondary buttons-reload btn-default btn-sm no-corner" tabindex="0" aria-controls="dataTableBuilder" type="button"><span><i class="fa fa-refresh"></i> Reload</span></button> </div><div id="dataTableBuilder_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTableBuilder"></label></div><div id="dataTableBuilder_processing" class="dataTables_processing card" style="display: none;">Processing...</div><table class="table table-striped table-bordered dataTable no-footer" id="dataTableBuilder" width="100%" role="grid" aria-describedby="dataTableBuilder_info" style="width: 100%;"><thead><tr role="row"><th title="Nombre" class="sorting_desc" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Nombre: activate to sort column ascending" style="width: 316px;">Nombre</th><th title="Cantidad" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 83px;">Cantidad</th><th title="Acciones" width="120px" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Acciones" style="width: 123px;">Acciones</th></tr></thead><tbody><tr role="row" class="odd"><td class="sorting_1">JABON LIQUIDO</td><td>0</td><td><form method="POST" action="http://127.0.0.6/products/6" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="6UEAT4b1cI8ijKV3xRoTG6yScozcxqQmsipZ3WT8">
<div class="btn-group">
    <a href="http://127.0.0.6/products/6/logs" class="btn btn-default btn-xs">
        <i class="fa fa-file-invoice"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-inbound" onclick="addModalId(6)">
        <i class="fas fa-arrow-up"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-outbound" onclick="addModalId(6)">
        <i class="fas fa-arrow-down"></i>
    </a>
    <a href="http://127.0.0.6/products/6" class="btn btn-default btn-xs">
        <i class="fa fa-eye"></i>
    </a>
    <a href="http://127.0.0.6/products/6/edit" class="btn btn-default btn-xs">
        <i class="fa fa-edit"></i>
    </a>
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
</div>
</form>
</td></tr><tr role="row" class="even"><td class="sorting_1">JABON EN POLVO</td><td>90</td><td><form method="POST" action="http://127.0.0.6/products/4" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="6UEAT4b1cI8ijKV3xRoTG6yScozcxqQmsipZ3WT8">
<div class="btn-group">
    <a href="http://127.0.0.6/products/4/logs" class="btn btn-default btn-xs">
        <i class="fa fa-file-invoice"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-inbound" onclick="addModalId(4)">
        <i class="fas fa-arrow-up"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-outbound" onclick="addModalId(4)">
        <i class="fas fa-arrow-down"></i>
    </a>
    <a href="http://127.0.0.6/products/4" class="btn btn-default btn-xs">
        <i class="fa fa-eye"></i>
    </a>
    <a href="http://127.0.0.6/products/4/edit" class="btn btn-default btn-xs">
        <i class="fa fa-edit"></i>
    </a>
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
</div>
</form>
</td></tr><tr role="row" class="odd"><td class="sorting_1">ESCOBA</td><td>40</td><td><form method="POST" action="http://127.0.0.6/products/5" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="6UEAT4b1cI8ijKV3xRoTG6yScozcxqQmsipZ3WT8">
<div class="btn-group">
    <a href="http://127.0.0.6/products/5/logs" class="btn btn-default btn-xs">
        <i class="fa fa-file-invoice"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-inbound" onclick="addModalId(5)">
        <i class="fas fa-arrow-up"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-outbound" onclick="addModalId(5)">
        <i class="fas fa-arrow-down"></i>
    </a>
    <a href="http://127.0.0.6/products/5" class="btn btn-default btn-xs">
        <i class="fa fa-eye"></i>
    </a>
    <a href="http://127.0.0.6/products/5/edit" class="btn btn-default btn-xs">
        <i class="fa fa-edit"></i>
    </a>
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
</div>
</form>
</td></tr><tr role="row" class="even"><td class="sorting_1">Aerosol Matavoladores Rai Frasco *285cc</td><td>99</td><td><form method="POST" action="http://127.0.0.6/products/1" accept-charset="UTF-8"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="6UEAT4b1cI8ijKV3xRoTG6yScozcxqQmsipZ3WT8">
<div class="btn-group">
    <a href="http://127.0.0.6/products/1/logs" class="btn btn-default btn-xs">
        <i class="fa fa-file-invoice"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-inbound" onclick="addModalId(1)">
        <i class="fas fa-arrow-up"></i>
    </a>
    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-outbound" onclick="addModalId(1)">
        <i class="fas fa-arrow-down"></i>
    </a>
    <a href="http://127.0.0.6/products/1" class="btn btn-default btn-xs">
        <i class="fa fa-eye"></i>
    </a>
    <a href="http://127.0.0.6/products/1/edit" class="btn btn-default btn-xs">
        <i class="fa fa-edit"></i>
    </a>
    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
</div>
</form>
</td></tr></tbody></table><div class="dataTables_info" id="dataTableBuilder_info" role="status" aria-live="polite">Showing 1 to 4 of 4 entries</div><div class="dataTables_paginate paging_simple_numbers" id="dataTableBuilder_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="dataTableBuilder_previous"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item next disabled" id="dataTableBuilder_next"><a href="#" aria-controls="dataTableBuilder" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></ul></div></div>


                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection