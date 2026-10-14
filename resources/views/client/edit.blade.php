@extends('layouts.app', ['page' => 'Clientes', 'pageSlug' => 'clients'])

@section('content')
@include('partials.page-header', ['title' => 'Editar cliente'])
<div class="card">
    <form method="POST" action="{{ route('clients.update', $client) }}">
    @csrf
    @method('PUT')
    <div class="card-body">@include('client._form')</div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('clients.index') }}" class="btn btn-default">Cancelar</a>
    </div>
    </form>
</div>
@endsection
