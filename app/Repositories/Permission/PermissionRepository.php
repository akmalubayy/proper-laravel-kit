<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * Regex untuk validasi nama model: hanya huruf (a-z), tidak boleh angka/simbol
     */
    private const MODEL_NAME_REGEX = '/^[a-zA-Z]+$/';

    /**
     * Regex untuk validasi nama permission manual
     * Format: huruf, angka, underscore, dash (umum di permission)
     */
    private const PERMISSION_NAME_REGEX = '/^[a-zA-Z0-9_-]+$/';

    private function getGroupedPermissions()
    {
        $permissions = Permission::orderBy('name')->get();
        $grouped = [
            'models' => collect(),
            'manual' => collect()
        ];

        foreach ($permissions as $perm) {
            if (preg_match('/^(view|add|edit|delete)_(.+)$/', $perm->name, $matches)) {
                $pluralModel = $matches[2];
                if (preg_match(self::MODEL_NAME_REGEX, Str::singular($pluralModel))) {
                    $singular = Str::singular($pluralModel);
                    $grouped['models']->push([
                        'model' => $singular,
                        'permission' => $perm
                    ]);
                } else {
                    $grouped['manual']->push($perm);
                }
            } else {
                $grouped['manual']->push($perm);
            }
        }

        $grouped['models'] = $grouped['models']
            ->groupBy('model')
            ->map(fn($items) => $items->pluck('permission'))

            ->sortBy('model');

        return $grouped;
    }

    public function permissionIndex()
    {
        $grouped = $this->getGroupedPermissions();

        $roles = Role::all();

        return view('pages.permission.index', compact('grouped', 'roles'));
    }

    public function permissionStore($request): JsonResponse
    {
        try {
            $this->validateStoreRequest($request);

            $permissionNames = [];

            if ($request->type === 'model') {
                $permissionNames = $this->createModelPermissions($request->model_name);
                $msg = "Permission untuk model '{$request->model_name}' berhasil dibuat.";
            } else {
                $permission = Permission::create(['name' => $request->name]);
                $permissionNames = [$permission->name];
                $msg = "Permission '{$request->name}' berhasil dibuat.";
            }

            if ($request->has('assign_to_roles') && is_array($request->assign_to_roles)) {
                $roleIds = array_filter($request->assign_to_roles, 'is_numeric');
                if (!empty($roleIds)) {
                    $roles = Role::whereIn('id', $roleIds)->get();
                    foreach ($roles as $role) {
                        $role->givePermissionTo($permissionNames);
                    }
                }
            }

            $this->forgetCache();
            return response()->json(['success' => true, 'message' => $msg]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->getMessageBag()->first()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Error creating permission: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ], 500);
        }
    }

    private function validateStoreRequest($request): void
    {
        if (!in_array($request->type, ['manual', 'model'])) {
            throw ValidationException::withMessages([
                'type' => 'Tipe permission tidak valid.'
            ]);
        }

        if ($request->has('assign_to_roles')) {
            if (!is_array($request->assign_to_roles)) {
                throw ValidationException::withMessages([
                    'assign_to_roles' => 'Role harus berupa array.'
                ]);
            }
            foreach ($request->assign_to_roles as $roleId) {
                if (!is_numeric($roleId) || $roleId <= 0) {
                    throw ValidationException::withMessages([
                        'assign_to_roles' => 'ID role tidak valid.'
                    ]);
                }
            }
            $existingRoleIds = Role::whereIn('id', $request->assign_to_roles)->pluck('id')->toArray();
            $invalidRoles = array_diff($request->assign_to_roles, $existingRoleIds);
            if (!empty($invalidRoles)) {
                throw ValidationException::withMessages([
                    'assign_to_roles' => 'Beberapa role tidak ditemukan.'
                ]);
            }
        }

        if ($request->type === 'manual') {
            if (empty($request->name)) {
                throw ValidationException::withMessages([
                    'name' => 'Nama permission wajib diisi.'
                ]);
            }
            if (!preg_match(self::PERMISSION_NAME_REGEX, $request->name)) {
                throw ValidationException::withMessages([
                    'name' => 'Nama permission hanya boleh mengandung huruf, angka, underscore, dan dash.'
                ]);
            }
            if (Permission::where('name', $request->name)->exists()) {
                throw ValidationException::withMessages([
                    'name' => 'Permission ini sudah ada.'
                ]);
            }
        } else {
            if (empty($request->model_name)) {
                throw ValidationException::withMessages([
                    'model_name' => 'Nama model wajib diisi.'
                ]);
            }
            if (!preg_match(self::MODEL_NAME_REGEX, $request->model_name)) {
                throw ValidationException::withMessages([
                    'model_name' => 'Nama model hanya boleh berisi huruf (a-z).'
                ]);
            }
            if (strlen($request->model_name) < 2 || strlen($request->model_name) > 50) {
                throw ValidationException::withMessages([
                    'model_name' => 'Nama model harus antara 2-50 karakter.'
                ]);
            }
        }
    }

    public function createModelPermissions(string $modelName): array
    {
        if (!preg_match(self::MODEL_NAME_REGEX, $modelName)) {
            throw new \InvalidArgumentException('Nama model tidak valid.');
        }

        $plural = Str::plural(strtolower(trim($modelName)));
        $actions = ['view', 'add', 'edit', 'delete'];
        $created = [];

        foreach ($actions as $action) {
            $name = "{$action}_{$plural}";
            if (!preg_match(self::PERMISSION_NAME_REGEX, $name)) continue;
            if (!Permission::where('name', $name)->exists()) {
                Permission::create(['name' => $name]);
                $created[] = $name;
            }
        }

        return $created;
    }

    public function permissionDestroy($id): JsonResponse
    {
        if ($this->permissionDestroyLogic($id)) {
            $this->forgetCache();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Permission tidak ditemukan.'], 404);
    }

    private function permissionDestroyLogic($id): bool
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return true;
        } catch (\Exception $e) {
            \Log::error("Gagal menghapus permission ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function permissionDeletes($model): JsonResponse
    {
        if ($this->permissionDeletesLogic($model)) {
            $this->forgetCache();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Model tidak valid atau permission tidak ditemukan.'], 400);
    }

    private function permissionDeletesLogic($model): bool
    {
        if (!preg_match(self::MODEL_NAME_REGEX, $model)) {
            \Log::warning("Upaya hapus permission dengan model tidak valid: {$model}");
            return false;
        }

        try {
            $plural = Str::plural(strtolower(trim($model)));
            $actions = ['view', 'add', 'edit', 'delete'];
            $deleted = 0;

            foreach ($actions as $action) {
                $name = "{$action}_{$plural}";
                if (preg_match(self::PERMISSION_NAME_REGEX, $name)) {
                    $deleted += Permission::where('name', $name)->delete();
                }
            }

            \Log::info("Berhasil menghapus {$deleted} permission untuk model: {$model}");
            return $deleted > 0;
        } catch (\Exception $e) {
            \Log::error("Gagal menghapus permission untuk model {$model}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Flush cache permission (dipanggil setelah operasi write)
     */
    public function forgetCache(): void
    {
        Cache::forget('spatie.permission.cache');
    }
}
