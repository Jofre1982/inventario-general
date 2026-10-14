@extends('layouts.app', ['page' => 'Reporte del día', 'pageSlug' => 'reports_day'])

@section('content')
@include('partials.page-header', ['title' => 'Reporte del día — ' . $from->translatedFormat('l d \d\e F \d\e Y')])
@include('report._results')
@endsection
