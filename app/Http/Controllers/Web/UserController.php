<?php

namespace App\Http\Controllers\Web;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Authorizable;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userRepository->userIndex();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->userRepository->userCreate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userRepository->userStore($request);
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
        return $this->userRepository->userEdit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->userRepository->userUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->userRepository->userDestroy($id);
    }

    /**
     * Remove selected record
     */
    public function deletes(Request $request)
    {
        return $this->userRepository->userDeletes($request);
    }
}
