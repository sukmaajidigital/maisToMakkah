@php
    $menus = [
        'Dashboard' => [
            // This is a single menu item
            'icon' => 'ti ti-dashboard',
            'route' => 'dashboard.index',
        ],
        'Jaringan' => [
            // This is a group with submenus
            'icon' => 'ti ti-network',
            'submenu' => [
                [
                    'title' => 'Dashboard',
                    'icon' => 'ti ti-dashboard', 'route' => 'dashboard.index'
                ],
                [
                    'title' => 'Users',
                    'icon' => 'ti ti-users', 'route' => 'user.index'
                ]
            ],
        ],
        'Users' => [
            'icon' => 'ti ti-users',
            'route' => 'user.index',
        ],
    ];
@endphp

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($menus as $title => $menu)
                @if (isset($menu['submenu']))
                    @php
                        $isActiveGroup = collect($menu['submenu'])->pluck('route')->some(fn($r) => request()->routeIs($r));
                    @endphp
                    <li>
                        <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group
                                   {{ $isActiveGroup ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}" data-collapse-toggle="dropdown-{{ Str::slug($title) }}" aria-controls="dropdown-{{ Str::slug($title) }}" aria-expanded="{{ $isActiveGroup ? 'true' : 'false' }}">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">{{ $title }}</span>
                            <svg class="w-3 h-3 ms-auto transform transition-transform {{ $isActiveGroup ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul id="dropdown-{{ Str::slug($title) }}" class="{{ $isActiveGroup ? '' : 'hidden' }} py-2 space-y-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group
                                               {{ request()->routeIs($submenu['route']) ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                        <i class="{{ $submenu['icon'] }} me-2"></i> {{ $submenu['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg group
                                   {{ request()->routeIs($menu['route']) ? 'text-blue-600 bg-gray-100 dark:bg-gray-700 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span class="ms-3">{{ $title }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
