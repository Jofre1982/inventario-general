@extends('layouts.app', ['page' => __('Proveedores'), 'pageSlug' => 'Editproviders'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar Proveedores</h1>
            </div>
        </div>
    </div>
</section>

{!! Form::model($provider,['route'=>['providers.update',$provider],'method'=>'PUT']) !!}
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" name="name" id="name" value="{{$provider->name}}" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="email">Correo Electronico</label>
    <input type="email" class="form-control" name="email" id="email" value="{{$provider->email}}" aria-describedby="emailHelpId" placeholder="ejemplo@email.com" required>
</div>
<div class="form-group">
    <label for="nit">Nit</label>
    <input type="number" class="form-control" name="nit" id="nit" value="{{$provider->phone}}" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="adress">Direccion</label>
    <input type="text" class="form-control" name="adress" id="adress" value="{{$provider->adress}}" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="phone">Contacto</label>
    <input type="number" class="form-control" name="phone" id="phone" value="{{$provider->phone}}" aria-describedby="helpId" placeholder="" required>
</div>
<button type="submit" class="btn btn-primary mr-2">Actualizar</button>
<a href="{{ route('providers.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection