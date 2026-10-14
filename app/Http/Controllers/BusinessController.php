<?php

namespace App\Http\Controllers;

use App\Http\Requests\Business\UpdateRequest;
use App\Models\Business;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:business.index')->only('index');
        $this->middleware('can:business.edit')->only('update');
    }

    public function index()
    {
        $business = Business::current();

        return view('business.index', compact('business'));
    }

    public function update(UpdateRequest $request)
    {
        $business = Business::current();
        $data = $request->safe()->except('picture');

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $name = 'logo_' . time() . '.' . $file->extension();
            $file->move(public_path('image'), $name);
            $data['logo'] = $name;
        }

        $business->update($data);

        return redirect()->route('business.index')->with('success', 'Datos de la empresa actualizados.');
    }
}
