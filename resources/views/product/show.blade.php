@extends('layouts.app', ['page' => __('Proveedores'), 'pageSlug' => 'Show'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalles Producto</h1>
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
                            <img src="{{asset('image/'.$product->image)}}" alt="profile" class="img-lg mb-3">
                            <h3>{{$product->name}}</h3>
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>
                        <!-- <div class="birder-bottom py-4">
                            <div class="list-group">
                                <button type="button" class="list-group-item list-group-item-action active">Sobre producto</button>
                                <button type="button" class="list-group-item list-group-item-action active">Cateoria</button>
                                <button type="button" class="list-group-item list-group-item-action active">Registrar Producto</button>
                            </div>
                        </div> -->
                        <div class="py-4">
                            <p class="clearfix">
                                <span class="float-left">
                                    Estado
                                </span>
                                <span class="float-right tex-muted">
                                    {{$product->status}}
                                </span>
                            </p>
                            <p class="clearfix">
                                <span class="float-left">   
                                Proveedor
                                </span>
                                <span class="float-right tex-muted">
                                <a href="{{route('providers.show', $product->provider->id)}}">{{$product->provider->name}}</a> 
                                </span>
                            </p>
                            <p class="clearfix">
                                <span class="float-left">
                                    Categoria
                                </span>
                                <span class="float-right tex-muted">
                                    <a href="">{{$product->category->name}}</a>
                                </span>
                            </p>
                        </div>
                        @if($product->status == 'ACTIVE')
                        <button class="btn btn-success btn-block">{{$product->status}}</button>
                        @else
                        <button class="btn btn-warning btn-block">{{$product->status}}</button>
                        @endif
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>Informacion del producto</h4>
                            </div>
                        </div>
                        <div class="profile-feed">
                            <div class="d-flex aling-item-star profile-feed-item">
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-delivery-fast mr-1"></i>Codigo</strong>
                                    <p class="text-muted">{{$product->code}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-send mr-1"></i>Nombre</strong>
                                    <p class="text-muted">{{$product->name}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-chat-33 mr-1"></i>Stock</strong>
                                    <p class="text-muted">{{$product->stock}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-chat-33 mr-1"></i>Imagen</strong>
                                    <p class="text-muted">{{$product->image}}</p>
                                    <hr>
                                </div>
                                <div class="form-group col-md-6">
                                    <strong><i class="tim-icons icon-badge mr-1"></i>Precio</strong>
                                    <p class="text-muted">{{$product->sell_price}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-square-pin mr-1"></i>Estado</strong>
                                    <p class="text-muted">{{$product->status}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-square-pin mr-1"></i>Categoria</strong>
                                    <p class="text-muted">{{$product->category_id}}</p>
                                    <hr>
                                    <strong><i class="tim-icons icon-square-pin mr-1"></i>Proveedor</strong>
                                    <p class="text-muted">{{$product->provider_id}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ route('providers.index') }}" class="btn btn-primary float-right">
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