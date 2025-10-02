<?php

namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function roleIndex();
    public function roleStore($request);
    public function roleUpdate($request, $role);
    public function roleDestroy($id);
}
