<?php

namespace App\Providers;

use App\Repositories\Menu\MenuRepository;
use App\Repositories\Menu\MenuRepositoryInterface;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Option\OptionRepositoryInterface;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(OptionRepositoryInterface::class, OptionRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }
}
