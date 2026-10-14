@extends('layouts.app', ['page' => 'Productos', 'pageSlug' => 'products'])
@php($product = new \App\Models\Product())
@section('content')
@include('partials.page-header', ['title' => 'Nuevo producto'])
<div class="card">
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="card-body">@include('product._form')</div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="{{ route('products.index') }}" class="btn btn-default">Cancelar</a>
    </div>
    </form>
</div>
@endsection
