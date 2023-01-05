@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inicio</h1>
                </div>
            </div>
        </div>
    </section>


    <div class="container">
        <div class="row">
            

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Usuarios</span>
                        <span class="info-box-number">{{$tot_users}}</span>
                    </div>

                </div>

            </div>

            
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Clientes</span>
                        <span class="info-box-number">{{$tot_clients}}</span>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Productos</span>
                        <span class="info-box-number">{{$tot_products}}</span>
                    </div>

                </div>

            </div>
            
            
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Movimientos</span>
                        <span class="info-box-number">{{$tot_deliveries}}</span>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
