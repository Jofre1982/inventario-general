@extends('layouts.app', ['page' => __('Categorias'), 'pageSlug' => 'Registercategories'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear categorias</h1>
            </div>
        </div>
    </div>
</section>

    {!! Form::open(['route'=>'categories.store','method'=>'POST']) !!}

    @include('category._form')
        <button type="submit" class="btn btn-primary mr-2">Registrar</button>
        <a href="{{ route('categories.index') }}" class="btn btn -ligth">Cancelar</a>
    {!! Form::close() !!}

@endsection