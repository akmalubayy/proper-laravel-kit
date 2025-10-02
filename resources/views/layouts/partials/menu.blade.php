<div class="startbar d-print-none">
    <div class="brand">
        <a href="index.html" class="logo">
            <span>
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
            </span>
            <span class="">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
            </span>
        </a>
    </div>
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label pt-0 mt-0">
                        <span>Main Menu</span>
                    </li>
                    @php
                    $currentRoute = request()->route()->getName();
                    @endphp

                    @forelse ($menus as $menu)
                    @php
                    $hasChildren = $menu->children->isNotEmpty();
                    $collapseId = 'sidebar-' . $menu->id;
                    $isActiveParent = $menu->children->contains(fn($child) => Str::startsWith($currentRoute,
                    ltrim($child->url, '/')))
                    || Str::startsWith($currentRoute, ltrim($menu->url, '/'));
                    @endphp

                    <li class="nav-item">
                        <a class="nav-link {{ $isActiveParent ? 'active' : '' }}" href="{{ $hasChildren ? "
                            #$collapseId" : ($menu->url === '#' ? 'javascript:void(0);' : url('apps' . $menu->url)) }}"
                            @if($hasChildren) data-bs-toggle="collapse" role="button" aria-expanded="{{ $isActiveParent
                            ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}" @endif>
                            <i class="{{ $menu->icon ?? 'iconoir-view-grid' }} menu-icon"></i>
                            <span>{{ $menu->title }}</span>
                        </a>

                        @if ($hasChildren)
                        <div class="collapse {{ $isActiveParent ? 'show' : '' }}" id="{{ $collapseId }}">
                            <ul class="nav flex-column">
                                @foreach ($menu->children as $submenu)
                                @php
                                $isSubActive = $currentRoute === ltrim($submenu->url, '/');
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link {{ $isSubActive ? 'active' : '' }}"
                                        href="{{ $submenu->url === '#' ? 'javascript:void(0);' : url('apps' . $submenu->url) }}">
                                        {{ $submenu->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    @empty
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="javascript:void(0);" style="pointer-events: none;">
                            <i class="iconoir-home-simple menu-icon"></i>
                            <span>Dashboards</span>
                        </a>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>