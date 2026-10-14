@extends('layouts.app', ['page' => 'Proveedores', 'pageSlug' => 'providers'])

@section('content')
@include('partials.page-header', ['title' => 'Proveedores', 'action' => route('providers.create'), 'can' => 'providers.create'])
<div class="card">
    <div class="card-body">
        @include('partials.search', ['placeholder' => 'Nombre o NIT'])
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Nombre</th><th>NIT</th><th>Teléfono</th><th>Correo</th><th class="text-right">Acciones</th></tr></thead>
                <tbody>
                @forelse ($providers as $provider)
                    <tr>
                        <td>@can('providers.show')<a href="{{ route('providers.show', $provider) }}">{{ $provider->name }}</a>@else{{ $provider->name }}@endcan</td>
                        <td>{{ $provider->nit }}</td>
                        <td>{{ $provider->phone }}</td>
                        <td>{{ $provider->email }}</td>
                        <td class="text-right">
                            @can('providers.edit')
                                <a href="{{ route('providers.edit', $provider) }}" class="btn btn-link btn-info btn-sm btn-icon" title="Editar"><i class="tim-icons icon-pencil"></i></a>
                            @endcan
                            @can('providers.destroy')
                                @include('partials.delete', ['action' => route('providers.destroy', $provider)])
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No hay proveedores.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $providers->links() }}
    </div>
</div>
@endsection
