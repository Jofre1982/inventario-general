<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->protectWithPermissions('roles');
    }

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();

        return view('role.index', compact('roles'));
    }

    public function create()
    {
        return view('role.create', ['role' => new Role(), 'permissionGroups' => $this->permissionGroups()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRole($request);

        $role = Role::create($this->roleAttributes($data));
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol creado.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('role.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        return view('role.edit', ['role' => $role, 'permissionGroups' => $this->permissionGroups()]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $this->validateRole($request, $role);

        $role->update($this->roleAttributes($data));
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado.');
    }

    public function destroy(Role $role)
    {
        if ($role->special === 'all-access' && Role::where('special', 'all-access')->count() === 1) {
            return back()->with('error', 'No se puede eliminar el único rol con acceso total.');
        }

        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }

    private function validateRole(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role)],
            'description' => ['nullable', 'string', 'max:255'],
            'special' => ['nullable', Rule::in(['all-access', 'no-access'])],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ], [], ['name' => 'nombre', 'description' => 'descripción', 'special' => 'acceso especial']);
    }

    private function roleAttributes(array $data): array
    {
        return [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'special' => $data['special'] ?? null,
        ];
    }

    /** Permisos agrupados por módulo ("products", "sales"...) para mostrarlos ordenados. */
    private function permissionGroups()
    {
        return Permission::orderBy('id')->get()->groupBy(fn ($p) => match (Str::before($p->slug, '.')) {
            'change' => 'cambios de estado',
            'upload' => 'purchases',
            default => Str::before($p->slug, '.'),
        });
    }
}
