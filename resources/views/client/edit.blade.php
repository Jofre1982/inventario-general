@extends('layouts.app', ['page' => __('Clientes'), 'pageSlug' => 'Editclients'])

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Editar Clientes</h1>
      </div>
    </div>
  </div>
</section>

{!! Form::model($client,['route'=>['clients.update',$client],
'method'=>'PUT','files'=>true]) !!}

<div class="form-group">
  <label for="name">Nombre</label>
  <input type="text" class="form-control" name="name" id="name" value="{{$client->name}}" aria-describedby="helpId" required>
  <small id="helpId" class="form-text text-muted"></small>
</div>
<div class="form-group">
  <label for="document">Documento</label>
  <input type="text" class="form-control" name="document" id="document" value="{{$client->document}}" aria-describedby="helpId" required>
  <small id="helpId" class="form-text text-muted"></small>
</div>
<div class="form-group">
  <label for="adress">Direccion</label>
  <input type="text" class="form-control" name="adress" id="adress"value="{{$client->adress}}" aria-describedby="helpId">
  <small id="helpId" class="form-text text-muted"></small>
</div>
<div class="form-group">
  <label for="phone">Contacto</label>
  <input type="text" class="form-control" name="phone" id="phone" value="{{$client->phone}}" aria-describedby="helpId">
  <small id="helpId" class="form-text text-muted"></small>
</div>
<div class="form-group">
  <label for="email">Correo Electronico</label>
  <input type="text" class="form-control" name="email" id="email" value="{{$client->email}}" aria-describedby="helpId">
  <small id="helpId" class="form-text text-muted"></small>
</div>

<button type="submit" class="btn btn-primary mr-2">Registrar</button>
<a href="{{ route('clients.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection