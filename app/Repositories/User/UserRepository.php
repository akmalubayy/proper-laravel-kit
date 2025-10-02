<?php

namespace App\Repositories\User;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\User;

use DataTables;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Private method untuk columns configuration
     */
    private function columnTable(): array
    {
        return [
            [
                'data' => 'checkbox',
                'name' => 'checkbox',
                'width' => '2%',
                'className' => 'center',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'className' => 'text-center',
                'width' => '4%'
            ],
            [
                'data' => 'name',
                'name' => 'name'
            ],
            [
                'data' => 'email',
                'name' => 'email'
            ],
            [
                'data' => 'role',
                'name' => 'role'
            ],
            [
                'data' => 'date',
                'name' => 'date'
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
                'width' => '10%',
            ],
        ];
    }

    public function userIndex()
    {
        $users = User::all();

        if (request()->ajax()) {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $action = '';

                    if (strtolower($item->roles->implode('name')) === 'admin') {
                        $action = '<a href="' . route('users.edit', $item->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>';
                    } else {
                        $action = '<a href="' . route('users.edit', $item->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" data-id=' . $item->id . ' data-name="' . $item->name . '"><i class="fas fa-trash"></i></a>';
                    }

                    return $action;
                })
                ->addColumn('checkbox', function ($data) {
                    return '<label class="pos-rel"><input type="checkbox" class="ace" name="column_checkbox" data-id=' . $data->id . '><span class="lbl"></span></label>';
                })
                ->addColumn('role', function ($data) {
                    return $data->roles->implode('name');
                })
                ->addColumn('date', function ($data) {
                    return $data->created_at->format('d M Y');
                })
                ->escapeColumns([])
                ->rawColumns(['action', 'checkbox', 'role', 'date'])
                ->make(true);
        }

        $columns = $this->columnTable();

        return view('pages.user.index', compact(['columns']));
    }

    public function userCreate()
    {
        $roles = Role::all();

        return view('pages.user.create', compact(['roles']));
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::findOrFail($roles);

        // Check for current role change
        if (!$user->hasAllRoles($roles)) {
            // Reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }

    public function userStore($request)
    {
        $request->validate([
            'name' => 'required|bail|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required|min:1',
        ]);

        $input = array_merge($request->all(), [
            'password' => bcrypt($request->password),
        ]);

        DB::transaction(function () use ($request, $input) {
            if ($user = User::create($input)) {
                $this->syncPermissions($request, $user);
            }
        });

        return redirect()->route('users.index')->with('sukses', 'Berhasil menambahkan User');
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        return view('pages.user.edit', compact(['user', 'roles']));
    }

    public function userUpdate($request, $id)
    {
        $request->validate([
            'name' => 'required|bail|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'roles' => 'required|min:1',
        ]);

        $user = User::findOrFail($id);

        $input = array_merge($request->all(), [
            'password' => ($request->password == null ? $user->password : bcrypt($request->password)),
        ]);

        DB::transaction(function () use ($request, $user, $input) {
            $user->fill($input);

            if ($request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }

            $this->syncPermissions($request, $user);

            $user->save();
        });

        return redirect()->route('users.index')->with('sukses', 'Berhasil update data');
    }

    public function userDestroy($id)
    {
        $userCount = User::all();

        if ($userCount->count() <= 1) {
            return redirect()->back()->with('error', 'User terakhir tidak bisa dihapus');
        }

        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function userDeletes($request)
    {
        $userCount = User::all();

        if ($userCount->count() <= 1) {
            return response()->json([
                'code' => 500,
                'message' => 'User terakhir tidak bisa dihapus.'
            ], 500);
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $validIds = User::whereIn('id', $request->ids)->pluck('id')->toArray();

        if (empty($validIds)) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan atau sudah dihapus.'
            ], 404);
        }

        $deletedRows = 0;
        User::whereIn('id', $validIds)->each(function ($user) use (&$deletedRows) {
            $user->delete();
            $deletedRows++;
        });

        return response()->json([
            'code' => 200,
            'message' => "{$deletedRows} User berhasil dihapus."
        ]);
    }
}
