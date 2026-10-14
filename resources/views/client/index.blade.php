@extends('layouts.app', ['page' => 'Clientes', 'pageSlug' => 'clients'])

@section('content')
@include('partials.page-header', ['title' => 'Clientes', 'action' => route('clients.create'), 'can' => 'clients.create'])
<div class="card">
    <div class="card-body">
        @include('partials.search', ['placeholder' => 'Nombre o documento'])
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Nombre</th><th>Documento</th><th>Teléfono</th><th>Correo</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>@can('clients.show')<a href="{{ route('clients.show', $client) }}">{{ $client->name }}</a>@else{{ $client->name }}@endcan</td>
                        <td>{{ $client->document }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->email }}</td>
                        <td class="text-right">
                            @can('clients.edit')
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-link btn-info btn-sm btn-icon" title="Editar"><i class="tim-icons icon-pencil"></i></a>
                            @endcan
                            @can('clients.destroy')
                                @include('partials.delete', ['action' => route('clients.destroy', $client)])
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No hay clientes.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $clients->links() }}
    </div>
</div>
@endsection
