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
                        <!-- Desde aqui va la tabla-->
                        <div class="form-group row">
                            <div class="col-md-6 text center">
                                <label class="form-control-label" for="nombre">Proveedor</label>
                                <p>{{$purchase->provider->name}}</p>
                            </div>

                            <div class="col-md-6 text center">
                                <label class="form-control-label" for="nombre">Numero de Compra</label>
                                <p>{{$purchase->id}}</p>
                            </div>
                        </div>
                        <br /><br />
                        <div class="form-group">
                            <h4 class="card-title ml-3">Detalle de la Compra</h4>
                            <div class="table-responsive col-md-12">
                                <table id="detalles" class="table table-striped">
                                    <thead>
                                        <th>Producto</th>
                                        <th>Precio (PEN)</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal (PEN)</th>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th colspan="3">
                                                <p style="text-align:right">SUBTOTAL:</p>
                                            </th>
                                            <th>
                                                <p style="text-align:right">s/{{number_format($subtotal,2)}}
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">
                                                <p style="text-align:right">TOTAL IMPUESTO ({{$purchase->tax}}):</p>
                                            </th>
                                            <th>
                                                <p style="text-align:right">s/{{number_format($subtotal*$purchase->tax/100,2)}}
                                                </p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">
                                                <p style="text-align:right">TOTAL:</p>
                                            </th>
                                            <th>
                                                <p style="text-align:right">s/{{number_format($purchase->total,2)}}
                                                </p>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($purchaseDetails as $purchaseDetail)
                                        <tr>
                                            <td>{{$purchaseDetail->product->name}}</td>
                                            <td>s/{{$purchaseDetail->price}}</td>
                                            <td>{{$purchaseDetail->quantity}}</td>
                                            <td>s/{{number_format($purchaseDetail->quantity*$purchaseDetail->price,2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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

@endsection
