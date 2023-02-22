@extends('layouts.app', ['page' => __('Productos'), 'pageSlug' => 'Editproducts'])

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Editar Productos</h1>
      </div>
    </div>
  </div>
</section>

{!! Form::model($product,['route'=>['products.update',$product],
  'method'=>'PUT','files'=>true]) !!}
<div class="form-group">
  <label for="name">Nombre</label>
  <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
  <label for="sell_price">Precio de Venta</label>
  <input type="number" class="form-control" name="sell_price" id="sell_price" value="{{$product->sell_price}}" aria-describedby="helpId" placeholder="" required>

</div>
<div class="form-group">
  <label for="category_id">Categoria</label>
  <select class="form-control" name="category_id" id="category_id">
    @foreach($categories as $category)
    <option value="{{$category->id}}"
     @if($category->id == $product->category_id)
      selected
      @endif
      >{{$category->name}}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="provider_id">Proveedor</label>
  <select class="form-control" name="provider_id" id="provider_id">
    @foreach($providers as $provider)
    <option value="{{$provider->id}}"
    @if($provider->id == $product->provider_id)
      selected
      @endif
      >{{$provider->name}}</option>
    @endforeach
  </select>
</div>
<div class="card-body">
  <h4 class="card-title d-flex">Imagen de producto
    <small class="ml-auto aling-self-end">
    <a href="" class="font-weight-ligth" target="_blank">Seleccionar Archivo</a>
    </small>
  </h4>
  <input type="file"id="picture" name="ícture" class="dropify">
</div>
<button type="submit" class="btn btn-primary mr-2">Registrar</button>
<a href="{{ route('products.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection