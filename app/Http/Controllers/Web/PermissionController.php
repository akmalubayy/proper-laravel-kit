<?php

namespace App\Http\Controllers\Web;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use Authorizable;

    private $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->permissionRepository->permissionIndex();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->permissionRepository->permissionStore($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->permissionRepository->permissionDestroy($id);
    }

    public function deletes(string $model)
    {
        return $this->permissionRepository->permissionDeletes($model);
    }
}
