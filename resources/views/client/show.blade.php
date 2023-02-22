@extends('layouts.app', ['page' => __('Clientes'), 'pageSlug' => 'Show'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalles Clientes</h1>
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

                            <h3>{{$client->name}}</h3>
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>

                        <div class="py-4">
                            <p class="clearfix">
                                <span class="float-left">
                                    Historial de compras
                                </span>
                                <span class="float-right tex-muted">
                                    
                                </span>
                            </p>
                           
                        </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Informacion del Cliente</h4>
                            </div>
                        </div>
                        <div class="profile-feed">
                            <div class="d-flex aling-item-star profile-feed-item">
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-send mr-1"></i>Nombre</strong>
                                    <p class="text-muted">{{$client->name}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-chat-33 mr-1"></i>Documento</strong>
                                    <p class="text-muted">{{$client->document}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-chat-33 mr-1"></i>Direccion</strong>
                                    <p class="text-muted">{{$client->adress}}</p>
                                    <hr>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-badge mr-1"></i>Contacto</strong>
                                    <p class="text-muted">{{$client->phone}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-square-pin mr-1"></i>Correo electronico</strong>
                                    <p class="text-muted">{{$client->email}}</p>
                                    <hr>
        
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('clients.index') }}" class="btn btn-primary float-right">
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