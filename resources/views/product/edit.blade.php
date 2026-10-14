@extends('layouts.app', ['page' => 'Productos', 'pageSlug' => 'products'])

@section('content')
@include('partials.page-header', ['title' => 'Editar producto'])
<div class="card">
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-body">@include('product._form')</div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
    </div>
    </form>
</div>
@endsection
