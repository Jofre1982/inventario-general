<?php

namespace App\Http\Controllers;

use Fxneiram\Shinobi\Models\Permission;
use Fxneiram\Shinobi\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return view('role.index', compact('roles'));
    }

       public function create()
    {
        $permissions = Permission::get();
        return view('role.create', compact('permissions'));
    }

   
    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->get('permissions'));
        return redirect()->route('roles.index');

    }

    public function show(Role $role)
    {
        return view('role.show', compact('role'));
    }

  
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        return view('role.edit', compact('role', 'permissions'));
    }

  
    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->get('permissions'));
        return redirect()->route('roles.index');
    }

  
    public function destroy(Role $role)
    {
        $role->delete();
        return back();
    }
}
