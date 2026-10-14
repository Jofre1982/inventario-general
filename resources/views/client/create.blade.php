@extends('layouts.app', ['page' => 'Clientes', 'pageSlug' => 'clients'])
@php($client = new \App\Models\Client())
@section('content')
@include('partials.page-header', ['title' => 'Nuevo cliente'])
<div class="card">
    <form method="POST" action="{{ route('clients.store') }}">
    @csrf
    <div class="card-body">@include('client._form')</div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-default">Cancelar</a>
    </div>
    </form>
</div>
@endsection
