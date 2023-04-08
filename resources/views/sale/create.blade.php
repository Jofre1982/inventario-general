
@extends('layouts.app', ['page' => __('Ventas'), 'pageSlug' => 'Registersale'])

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


{!! Form::open(['route'=>'sales.store','method'=>'POST']) !!}

@include('sale._form')



<a href="{{ route('purchases.index') }}" class="btn btn -ligth">Cancelar</a>
<button type="submit" id="guardar" class="btn btn-primary mr-2">Registrar</button>

{!! Form::close() !!}
@endsection

@push('js')

@endpush


