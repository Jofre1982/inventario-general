@extends('layouts.app', ['page' => __('Categorias'), 'pageSlug' => 'Editcategories'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Editar categorias</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('categories.create') }}">
                    Nuevo
                </a>
            </div>
        </div>
    </div>
</section>

{!! Form::model($category,['route'=>['categories.update',$category],'method'=>'PUT']) !!}

<div class="form-group">
    <label for="name"></label>
    <input type="text" name="name" id="name" value="{{$category->name}}"class="form-control" placeholder="Nombre" required>
    <small id="helpId" class="text-muted">Aqui va el nombre que le quieres poner a tu categoria</small>
</div>
<div class="form-group">
    <label for="descriptions">Descripcion</label>
    <textarea class="form-control" name="descriptions" id="descriptions" rows="3">{{$category->descriptions}}</textarea>
</div>

<button type="submit" class="btn btn-primary mr-2">Actualizar</button>
<a href="{{ route('categories.index') }}" class="btn btn -ligth">Cancelar</a>
{!! Form::close() !!}

@endsection