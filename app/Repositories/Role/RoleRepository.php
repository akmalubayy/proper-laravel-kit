<?php

namespace App\Repositories\Role;

use App\Models\Permission;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function roleIndex()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('pages.role.index', compact(['roles', 'permissions']));
    }

    public function roleStore($request)
    {
        Role::create($request->only('name'));

        return redirect()->back()->with('sukses', 'Berhasil Tambah Role');
    }

    public function roleUpdate($request, $role)
    {
        if (strtolower($role->name) == 'admin') {
            $role->syncPermissions(Permission::all());

            return redirect()->back()->with('sukses', 'Permission Berhasil Ditambahkan');
        }

        $permission = $request->get('permissions', []);

        $role->syncPermissions($permission);

        return redirect()->back()->with('sukses', 'Permission Berhasil Ditambahkan');
    }

    public function roleDestroy($id)
    {
        try {
            $role = Role::findOrFail($id);

            // Opsional: cegah hapus role 'admin'
            if (strtolower($role->name) === 'admin') {
                return response()->json([
                    'message' => 'Tidak bisa menghapus role admin.'
                ], 403);
            }

            $role->delete();

            return response()->json([
                'message' => 'Role berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
