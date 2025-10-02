<?php

namespace App\Http\Controllers\Web;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Repositories\Menu\MenuRepositoryInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use Authorizable;

    private $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->menuRepository->menuIndex();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->menuRepository->menuCreate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->menuRepository->menuStore($request);
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
        return $this->menuRepository->menuEdit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->menuRepository->menuUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->menuRepository->menuDestroy($id);
    }

    /**
     * Change Status Active Menu
     *
     * @param Request $request
     * @return void
     */
    public function statuschange(Request $request)
    {
        return $this->menuRepository->menuStatusChange($request);
    }

    /**
     * Delete multiple select menu
     *
     * @param Request $request
     * @return void
     */
    public function deletes(Request $request)
    {
        return $this->menuRepository->menuDeletes($request);
    }
}
