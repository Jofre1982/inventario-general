<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->protectWithPermissions('clients');
    }

    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->q, fn ($q, $term) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$term}%")
                ->orWhere('document', 'like', "%{$term}%")))
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('client.index', compact('clients'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(StoreRequest $request)
    {
        Client::create($request->validated());

        return redirect()->route('clients.index')->with('success', 'Cliente creado.');
    }

    public function show(Client $client)
    {
        $sales = $client->sales()->latest('sale_date')->limit(20)->get();

        return view('client.show', compact('client', 'sales'));
    }

    public function edit(Client $client)
    {
        return view('client.edit', compact('client'));
    }

    public function update(UpdateRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Client $client)
    {
        return $this->deleteOrExplain($client, 'clients.index', 'No se puede eliminar: el cliente tiene ventas registradas.');
    }
}
