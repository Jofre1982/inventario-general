@extends('layouts.app', ['page' => __('Proveedores'), 'pageSlug' => 'Show'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalles Proveedores</h1>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="border-bottom tex-center pb-4">
                            <h3>{{$provider->name}}</h3>
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>
                        <div class="birder-bottom py-4">
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action active">Sobre proveedor</button>
                                <button type="button" class="list-group-item list-group-item-action active">Productos</button>
                                <button type="button" class="list-group-item list-group-item-action active">Registrar Producto</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Informacion del proveedor</h4>
                            </div>
                        </div>
                        <div class="profile-feed">
                            <div class="d-flex aling-item-star profile-feed-item">
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-delivery-fast mr-1"></i>Nombre</strong>
                                    <p class="text-muted">{{$provider->name}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-send mr-1"></i>Correo Electronico</strong>
                                    <p class="text-muted">{{$provider->email}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-chat-33 mr-1"></i>Contacto</strong>
                                    <p class="text-muted">{{$provider->phone}}</p>
                                    <hr>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-badge mr-1"></i>NIT</strong>
                                    <p class="text-muted">{{$provider->nit}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-square-pin mr-1"></i>Direccion</strong>
                                    <p class="text-muted">{{$provider->adress}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-sm-6">
                        <a href="{{ route('providers.index') }}" class="btn btn-primary float-right" >
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