<?php

namespace App\Repositories\Permission;

interface PermissionRepositoryInterface
{
    public function permissionIndex();
    public function permissionStore($request);
    public function permissionDestroy($id);
    public function permissionDeletes($id);
}
