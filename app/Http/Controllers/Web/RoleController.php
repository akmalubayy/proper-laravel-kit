<?php

namespace App\Http\Controllers\Web;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use Authorizable;

    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->roleRepository->roleIndex();
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
        return $this->roleRepository->roleStore($request);
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
    public function update(Request $request, Role $role)
    {
        return $this->roleRepository->roleUpdate($request, $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->roleRepository->roleDestroy($id);
    }
}
