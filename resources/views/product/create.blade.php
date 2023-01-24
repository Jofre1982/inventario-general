@extends('layouts.app', ['page' => __('Productos'), 'pageSlug' => 'products'])

@section('content')
<div class="content-wrapper" style="min-height: 543px;">
    <section class="content">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Crear Producto</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="content px-3">


            <div class="card">

                <form method="POST" action="http://127.0.0.10/products" accept-charset="UTF-8"><input name="_token" type="hidden" value="wbY4I5tAEPtt2DrJ8cf0rkgKEcONXwlXs2pjmWx1">

                    <div class="card-body">

                        <div class="row">
                            <!-- Name Field -->
                            <div class="form-group col-sm-6">
                                <label for="name">Nombre:</label>
                                <input class="form-control" maxlength="191" name="name" type="text" id="name">
                            </div>

                            <!-- Amount Field -->
                            <div class="form-group col-sm-6">
                                <label for="amount">Cantidad:</label>
                                <input class="form-control" name="amount" type="number" id="amount">
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <input class="btn btn-primary" type="submit" value="Guardar">
                        <a href="http://127.0.0.6/products" class="btn btn-default">Cancelar</a>
                    </div>

                </form>

            </div>
        </div>
    </section>
</div>
@endsection