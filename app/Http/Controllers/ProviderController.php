<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provider\StoreRequest;
use App\Http\Requests\Provider\UpdateRequest;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->protectWithPermissions('providers');
    }

    public function index(Request $request)
    {
        $providers = Provider::query()
            ->when($request->q, fn ($q, $term) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$term}%")
                ->orWhere('nit', 'like', "%{$term}%")))
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('provider.index', compact('providers'));
    }

    public function create()
    {
        return view('provider.create');
    }

    public function store(StoreRequest $request)
    {
        Provider::create($request->validated());

        return redirect()->route('providers.index')->with('success', 'Proveedor creado.');
    }

    public function show(Provider $provider)
    {
        return view('provider.show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        return view('provider.edit', compact('provider'));
    }

    public function update(UpdateRequest $request, Provider $provider)
    {
        $provider->update($request->validated());

        return redirect()->route('providers.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy(Provider $provider)
    {
        return $this->deleteOrExplain($provider, 'providers.index', 'No se puede eliminar: el proveedor tiene productos o compras.');
    }
}
