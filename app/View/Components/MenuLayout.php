<?php

namespace App\View\Components;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Auth;

class MenuLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (Auth::check()) {
            $menus = Menu::with(['roles'])
                ->where('is_active', true)
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', auth()->user()->getRoleNames());
                })
                ->orderBy('order', 'asc')
                ->get();

            // Mengelompokkan menu
            $menuTree = $menus->where('is_parent', true)->map(function ($menu) use ($menus) {
                $menu->children = $menus->where('parent_id', $menu->id)->values();
                return $menu;
            });
        }

        return view('layouts.partials.menu', [
            'menus' => $menuTree
        ]);
    }
}
