@php
    // Definisikan menu untuk User biasa dan Admin
    $userMenus = [
        'Dashboard' => [
            'icon' => 'ti ti-dashboard',
            'route' => 'dashboard.index',
        ],
        'Jaringan Saya' => [
            'icon' => 'ti ti-network',
            'route' => 'network.index',
        ],
        'Bonus & Keuangan' => [
            'icon' => 'ti ti-wallet',
            'submenu' => [['title' => 'Riwayat Bonus', 'route' => 'bonus.history', 'icon' => 'ti ti-history'], ['title' => 'Penarikan Dana', 'route' => 'bonus.withdraw', 'icon' => 'ti ti-cash']],
        ],
        'Peringkat' => [
            'icon' => 'ti ti-trophy',
            'route' => 'rank.qualification',
        ],
    ];

    $adminMenus = [
        'Manajemen' => [
            'icon' => 'ti ti-settings-cog',
            'submenu' => [['title' => 'Pengguna', 'route' => 'admin.users.index', 'icon' => 'ti ti-users'], ['title' => 'Peringkat', 'route' => 'admin.ranks.index', 'icon' => 'ti ti-license']],
        ],
        'Persetujuan' => [
            'icon' => 'ti ti-check',
            'submenu' => [['title' => 'Penarikan', 'route' => 'admin.approvals.withdrawals', 'icon' => 'ti ti-currency-dollar'], ['title' => 'Klaim Peringkat', 'route' => 'admin.approvals.ranks', 'icon' => 'ti ti-arrow-up-right']],
        ],
    ];
@endphp

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            {{-- =================== --}}
            {{-- ==   MENU USER   == --}}
            {{-- =================== --}}
            <li class="pt-2 pb-2 px-4">
                <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</span>
            </li>
            @foreach ($userMenus as $title => $menu)
                @if (isset($menu['submenu']))
                    @php
                        // Cek apakah ada submenu yang aktif. Wildcard '*' digunakan agar semua rute di bawahnya dianggap aktif.
                        // contoh: 'bonus.history' dan 'bonus.withdraw' akan mengaktifkan parent 'Bonus & Keuangan'
                        $isActiveGroup = collect($menu['submenu'])->pluck('route')->some(fn($r) => request()->routeIs($r) || request()->routeIs(explode('.', $r)[0] . '.*'));
                    @endphp
                    <li>
                        <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" data-collapse-toggle="dropdown-{{ Str::slug($title) }}" aria-expanded="{{ $isActiveGroup ? 'true' : 'false' }}">
                            <i class="{{ $menu['icon'] }} text-gray-500 dark:text-gray-400"></i>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $title }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-{{ Str::slug($title) }}" class="{{ $isActiveGroup ? '' : 'hidden' }} py-2 space-y-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->routeIs($submenu['route']) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                        {{ $submenu['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs($menu['route']) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <i class="{{ $menu['icon'] }} text-gray-500 dark:text-gray-400"></i>
                            <span class="ms-3">{{ $title }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            {{-- =================== --}}
            {{-- ==   MENU ADMIN  == --}}
            {{-- =================== --}}
            {{-- Di aplikasi nyata, Anda bisa membungkus bagian ini dengan @if (auth()->user()->isAdmin()) --}}
            <li class="pt-4 pb-2 px-4">
                <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Admin Area</span>
            </li>
            @foreach ($adminMenus as $title => $menu)
                @if (isset($menu['submenu']))
                    @php
                        $isActiveGroup = collect($menu['submenu'])->pluck('route')->some(fn($r) => request()->routeIs($r) || request()->routeIs(explode('.', $r)[0] . '.' . explode('.', $r)[1] . '.*'));
                    @endphp
                    <li>
                        <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" data-collapse-toggle="dropdown-{{ Str::slug($title) }}" aria-expanded="{{ $isActiveGroup ? 'true' : 'false' }}">
                            <i class="{{ $menu['icon'] }} text-gray-500 dark:text-gray-400"></i>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $title }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-{{ Str::slug($title) }}" class="{{ $isActiveGroup ? '' : 'hidden' }} py-2 space-y-2">
                            @foreach ($menu['submenu'] as $submenu)
                                <li>
                                    <a href="{{ route($submenu['route']) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->routeIs(explode('.', $submenu['route'])[0] . '.' . explode('.', $submenu['route'])[1] . '.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                        {{ $submenu['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route($menu['route']) }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs($menu['route']) ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <i class="{{ $menu['icon'] }} text-gray-500 dark:text-gray-400"></i>
                            <span class="ms-3">{{ $title }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
