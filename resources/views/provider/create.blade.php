@extends('layouts.app', ['page' => __('Proveedores'), 'pageSlug' => 'Registerproviders'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Proveedores</h1>
            </div>
        </div>
    </div>
</section>

{!! Form::open(['route'=>'providers.store','method'=>'POST']) !!}
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="email">Correo Electronico</label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="ejemplo@email.com" required>
</div>
<div class="form-group">
    <label for="nit">Nit</label>
    <input type="number" class="form-control" name="nit" id="nit" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="adress">Direccion</label>
    <input type="text" class="form-control" name="adress" id="adress" aria-describedby="helpId" placeholder="" required>
</div>
<div class="form-group">
    <label for="phone">Contacto</label>
    <input type="number" class="form-control" name="phone" id="phone" aria-describedby="helpId" placeholder="" required>
</div>
<button type="submit" class="btn btn-primary mr-2">Registrar</button>
<a href="{{ route('providers.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection