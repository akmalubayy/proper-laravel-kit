<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function userIndex();
    public function userCreate();
    public function userStore($request);
    public function userEdit($id);
    public function userUpdate($request, $id);
    public function userDestroy($id);
    public function userDeletes($request);
}
