@extends('layouts.app', ['page' => __('Compras'), 'pageSlug' => 'ShowPurchases'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalles Compras</h1>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 pl-lg-5">
                        <div class="d-flex justify-content-between">
                        </div>
                        <!-- Desde aqui va la tabla y demas -->
                        <div class="form-group row">
                            <div class="col-md-6 text center">
                                <label class="form-control-label" for="nombre">Proveedor</label>
                                <p>{{$purchase->provider->name}}</p>
                            </div>

                            <div class="col-md-6 text center">
                                <label class="form-control-label" for="nombre">Proveedor</label>
                                <p>{{$purchase->id}}</p>
                            </div>
                        </div>
                        <div class="profile-feed">
                            <div class="form-group">
                                <h4 class="card-title">Detalle de la Compra</h4>
                                <div class="table-responsive col-md-12">
                                    <table id="detalles" class="table table-striped">
                                        <thead>
                                            <th>Eliminar</th>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">
                                                    <p style="text-align:right">TOTAL</p>
                                                </th>
                                                <th>
                                                    <p style="text-align:right">
                                                        <span id="total">PEN 0.00:</span>
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr id="dvOcultar">
                                                <th colspan="4">
                                                    <p style="text-align:right">TOTAL IMPUESTO ({{$purchase->tax}}):</p>
                                                </th>
                                                <th>
                                                    <p style="text-align:right">
                                                        <span id="total_impuesto">PEN 0.00</span>
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4">
                                                    <p style="text-align:right">TOTAL PAGAR:</p>
                                                </th>
                                                <th>
                                                    <p style="text-align:right">
                                                        <span aling="right" id="total_pagar_html">PEN 0.00</span>
                                                        <input type="hidden" name="total" id="total_pagar">
                                                    </p>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <a href="{{ route('purchases.index') }}" class="btn btn-primary float-right">
                                    REGRESAR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
