<?php

namespace App\Repositories\Menu;

use App\Models\Menu;
use App\Models\Role;
use DataTables;

class MenuRepository implements MenuRepositoryInterface
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
                'data' => 'menuName',
                'name' => 'menuName'
            ],
            [
                'data' => 'url',
                'name' => 'url'
            ],
            [
                'data' => 'icon',
                'name' => 'icon'
            ],
            [
                'data' => 'order',
                'name' => 'order'
            ],
            [
                'data' => 'active_status',
                'name' => 'active_status'
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

    /**
     * Private method untuk thead configuration (optional)
     */
    private function getThead(): string
    {
        return '
            <tr>
                <th class="center">
                    <label class="pos-rel">
                        <input type="checkbox" name="main_checkbox" class="ace" />
                        <span class="lbl"></span>
                    </label>
                </th>
                <th>#</th>
                <th>Title</th>
                <th>Url</th>
                <th>Icon</th>
                <th>Order</th>
                <th>OFF/ON</th>
                <th>Action</th>
            </tr>
        ';
    }

    public function menuIndex()
    {
        $menus = Menu::with(['parent', 'roles'])
            ->orderBy('order', 'asc')
            ->get();

        if (request()->ajax()) {
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return '<a href="' . route('menus.edit', $item->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger delete" data-id=' . $item->id . ' data-name="' . $item->title . '"><i class="fas fa-trash"></i></a>';
                })
                ->addColumn('menuName', function ($data) {
                    return $data->title;
                })
                ->addColumn('checkbox', function ($data) {
                    return '<label class="pos-rel"><input type="checkbox" class="ace" name="column_checkbox" data-id=' . $data->id . '><span class="lbl"></span></label>';
                })
                ->addColumn('active_status', function ($item) {
                    return '<div class="form-check form-switch py-2" style="writing-mode: vertical-rl;">
                            <input class="form-check-input statusChange" data-id="' . $item->id . '" data-name="' . $item->title . '" type="checkbox" id="menuActive" name="is_active" ' . ($item->is_active == 1 ? 'checked' : '') . '>
                        </div>';
                })
                ->escapeColumns([])
                ->rawColumns(['action', 'menuName', 'checkbox', 'active_status'])
                ->make(true);
        }

        $columns = $this->columnTable();

        return view('pages.menu.index', compact(['columns']));
    }

    public function menuCreate()
    {
        $menus = Menu::orderBy('order', 'asc')
            ->get();

        $roles = Role::all();

        return view('pages.menu.create', compact(['menus', 'roles']));
    }

    public function menuStore($request)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'icon' => 'nullable',
            'order' => 'min:1|integer|unique:menus,order',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $menuOrder = Menu::select('order')->orderBy('order', 'desc')->first();

        $input = [
            'title' => $request->title,
            'url' => $request->url == null ? '#' : $request->url,
            'icon' => $request->icon,
            'order' => !$menuOrder ? 1 : $menuOrder->order + 1,
            'is_parent' => ($request->is_parent == true ? 1 : ($request->is_parent == false ? 0 : 0)),
            'has_child' => ($request->has_child == true ? 1 : ($request->has_child == false ? 0 : 0)),
            'is_active' => ($request->is_active == true ? 1 : ($request->is_active == false ? 0 : 0)),
            'parent_id' => $request->parent_id ?? null,
        ];

        $menu = Menu::create($input);

        $menu->roles()->sync($request->roles);

        return redirect()->route('menus.index')->with('sukses', 'Input Data Berhasil');
    }

    public function menuEdit($id)
    {
        $data = Menu::findOrFail($id);

        $roles = Role::all();

        $menus = Menu::with(['parent', 'roles'])->get();

        return view('pages.menu.edit', compact(['data', 'menus', 'roles']));
    }

    public function menuUpdate($request, $id)
    {
        $menu = Menu::with(['roles'])->findOrFail($id);

        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'icon' => 'required',
            'order' => 'required|integer|min:1',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $newOrder = $request->order;
        $currentOrder = $menu->order;

        if ($newOrder != $currentOrder) {
            if ($newOrder > $currentOrder) {
                Menu::whereBetween('order', [$currentOrder + 1, $newOrder])
                    ->decrement('order');
            } else {
                Menu::whereBetween('order', [$newOrder, $currentOrder - 1])
                    ->increment('order');
            }
        }

        if ($request->roles < 1) {
            return redirect()->back()->with('error', 'Roles visibility harus terisi');
        }

        $menu->update([
            'title' => $request->title,
            'url' => $request->url == null ? '#' : $request->url,
            'icon' => $request->icon,
            'order' => $newOrder,
            'is_parent' => ($request->is_parent == true ? 1 : ($request->is_parent == false ? 0 : 0)),
            'has_child' => ($request->has_child == true ? 1 : ($request->has_child == false ? 0 : 0)),
            'is_active' => ($request->is_active == true ? 1 : ($request->is_active == false ? 0 : 0)),
            'parent_id' => $request->is_parent == true || $request->has_child == true ? null : ($request->parent_id != null ? $request->parent_id : $menu->parent_id),
        ]);

        $menu->roles()->sync($request->roles);

        return redirect()->route('menus.index')->with('sukses', 'Update Data Berhasil');
    }

    public function menuDestroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function menuStatusChange($request)
    {
        $data = Menu::with(['roles'])->findOrFail($request->id);

        $data->is_active = $request->is_active;

        $data->save();

        return response()->json([
            'message' => 'Status Change Succesfully'
        ], 200);
    }

    public function menuDeletes($request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:menus,id'
        ]);

        $validIds = Menu::whereIn('id', $request->ids)->pluck('id')->toArray();

        if (empty($validIds)) {
            return response()->json([
                'code' => 404,
                'message' => 'Data tidak ditemukan atau sudah dihapus.'
            ], 404);
        }

        $deletedRows = Menu::whereIn('id', $validIds)->delete();

        return response()->json([
            'code' => 200,
            'message' => "{$deletedRows} Menu berhasil dihapus."
        ]);
    }
}
