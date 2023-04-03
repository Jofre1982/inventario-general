@extends('layouts.app', ['page' => __('Productos'), 'pageSlug' => 'Registerproducts'])

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Crear Productos</h1>
      </div>
    </div>
  </div>
</section>

{!! Form::open(['route'=>'products.store','method'=>'POST','files'=>true]) !!}
<div class="form-group">
  <label for="name">Nombre</label>
  <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
  <label for="sell_price">Precio de Venta</label>
  <input type="number" class="form-control" name="sell_price" id="sell_price" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
  <label for="category_id">Categoria</label>
  <select style="background-color: #1e1e2f" class="form-control" name="category_id" id="category_id">
    @foreach($categories as $category)
    <option value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="provider_id">Proveedor</label>
  <select style="background-color: #1e1e2f" class="form-control" name="provider_id" id="provider_id">
    @foreach($providers as $provider)
    <option value="{{$provider->id}}">{{$provider->name}}</option>
    @endforeach
  </select>
</div>
<!-- <div class="custom-file mb-4">
  <input type="file" class="custom-file-input" id="image" name="image" lang="es">
  <label class="custom-file-label" for="image">Seleccione archivo</label>
</div> -->
<div class="card-body">
  <h4 class="card-title d-flex">Imagen de producto
    <small class="ml-auto aling-self-end">
      <a href="" class="font-weight-ligth" target="_blank">Seleccionar Archivo</a>
    </small>
  </h4>
  <input type="file" id="picture" name="picture" class="dropify">
</div>
<button type="submit" class="btn btn-primary mr-2">Registrar</button>
<a href="{{ route('products.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection
