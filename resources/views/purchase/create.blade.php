@extends('layouts.app', ['page' => __('Compras'), 'pageSlug' => 'Registerpurchases'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Compra</h1>
            </div>
        </div>
    </div>
</section>

{!! Form::open(['route'=>'purchases.store','method'=>'POST']) !!}

@include('purchase._form')

{!! Form::close() !!}
<button type="submit" class="btn btn-primary mr-2">Registrar</button>
<a href="{{ route('purchases.index') }}" class="btn btn -ligth">Cancelar</a>
@endsection