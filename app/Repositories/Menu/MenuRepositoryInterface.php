<?php

namespace App\Repositories\Menu;

interface MenuRepositoryInterface
{
    public function menuIndex();
    public function menuCreate();
    public function menuStore($request);
    public function menuEdit($id);
    public function menuUpdate($request, $id);
    public function menuDestroy($id);
    public function menuDeletes($request);
    public function menuStatusChange($request);
}
