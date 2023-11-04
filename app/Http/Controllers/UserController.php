<?php

namespace App\Http\Controllers;

use Fxneiram\Shinobi\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{ public function index()
    {
        $users = User::get();
        return view('user.index', compact('users'));
    }

       public function create()
    {
        $roles = Role::get();
        return view('user.create', compact('roles'));
    }

   
    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.index');

    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

  
    public function edit(User $user)
    {
        $roles = Role::get();
        return view('user.edit', compact('user', 'roles'));
    }

  
    public function update(Request $request, user $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.index');
    }

  
    public function destroy(user $user)
    {
        $user->delete();
        return back();
    }

}
