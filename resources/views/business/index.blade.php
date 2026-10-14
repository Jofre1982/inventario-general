@extends('layouts.app', ['page' => 'Empresa', 'pageSlug' => 'business'])

@section('content')
@include('partials.page-header', ['title' => 'Datos de la empresa'])
<div class="card">
    <form method="POST" action="{{ route('business.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @php($canEdit = auth()->user()->can('business.edit'))
    <fieldset @disabled(! $canEdit)>
    <div class="card-body">
        <p class="text-muted">Estos datos aparecen en los tickets y en los PDF de ventas y compras.</p>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name">Nombre del negocio *</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $business->name) }}" required>
            </div>
            <div class="col-md-6 form-group">
                <label for="nit">NIT</label>
                <input type="text" class="form-control" name="nit" id="nit" value="{{ old('nit', $business->nit) }}">
            </div>
            <div class="col-md-6 form-group">
                <label for="mail">Correo</label>
                <input type="email" class="form-control" name="mail" id="mail" value="{{ old('mail', $business->mail) }}">
            </div>
            <div class="col-md-6 form-group">
                <label for="address">Dirección / teléfono</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $business->address) }}">
            </div>
            <div class="col-12 form-group">
                <label for="description">Descripción</label>
                <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $business->description) }}" maxlength="255">
            </div>
            <div class="col-md-6 form-group">
                <label class="d-block">Logo</label>
                @if ($business->logo_url && file_exists(public_path('image/' . $business->logo)))
                    <img src="{{ $business->logo_url }}" alt="Logo" class="logo-preview mb-2 d-block">
                @endif
                <input type="file" name="picture" accept="image/*">
            </div>
        </div>
    </div>
    @if ($canEdit)
        <div class="card-footer"><button type="submit" class="btn btn-primary">Guardar</button></div>
    @endif
    </fieldset>
    </form>
</div>
@endsection
