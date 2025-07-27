@php
    // Definisikan menu untuk User biasa
    $userMenus = [
        'Dashboard' => ['icon' => 'ti ti-dashboard', 'route' => 'dashboard.index'],
        'Order' => ['icon' => 'ti ti-shopping-bag', 'route' => 'order.index'],
        'Jaringan' => [
            'icon' => 'ti ti-network',
            'submenu' => [
                [
                    'title' => 'Jaringan Saya',
                    'route' => 'network.index',
                ],
                [
                    'title' => 'Daftarkan Member',
                    'route' => 'network.register.index',
                ],
            ],
        ],
        'Bonus & Keuangan' => [
            'icon' => 'ti ti-wallet',
            'submenu' => [
                [
                    'title' => 'Riwayat Bonus',
                    'route' => 'bonus.history',
                ],
                [
                    'title' => 'Penarikan Dana',
                    'route' => 'bonus.withdraw',
                ],
            ],
        ],
        'Peringkat' => ['icon' => 'ti ti-trophy', 'route' => 'rank.qualification'],
    ];

    // Definisikan menu untuk Admin
    $adminMenus = [
        'Manajemen' => [
            'icon' => 'ti ti-settings-cog',
            'submenu' => [
                [
                    'title' => 'Pengguna',
                    'route' => 'admin.users.index',
                ],
                [
                    'title' => 'Produk',
                    'route' => 'admin.product.index',
                ],
            ],
        ],
        'Persetujuan' => [
            'icon' => 'ti ti-check',
            'submenu' => [
                [
                    'title' => 'Penarikan',
                    'route' => 'admin.approvals.withdrawals',
                ],
                [
                    'title' => 'Klaim Peringkat',
                    'route' => 'admin.approvals.ranks',
                ],
            ],
        ],
    ];
@endphp

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            {{-- TAMPILKAN MENU INI HANYA JIKA YANG LOGIN ADALAH USER BIASA (GUARD 'web') --}}
            @if (Auth::guard('web')->check())
                <li class="pt-2 pb-2 px-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</span>
                </li>
                @foreach ($userMenus as $title => $menu)
                    {{-- Logika untuk render menu (single/submenu) --}}
                    @include('components.sidebar-item', ['title' => $title, 'menu' => $menu])
                @endforeach
            @endif

            {{-- TAMPILKAN MENU INI HANYA JIKA YANG LOGIN ADALAH ADMIN (GUARD 'admin') --}}
            @if (Auth::guard('admin')->check())
                <li class="pt-2 pb-2 px-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Admin Area</span>
                </li>
                @foreach ($adminMenus as $title => $menu)
                    {{-- Logika untuk render menu (single/submenu) --}}
                    @include('components.sidebar-item', ['title' => $title, 'menu' => $menu])
                @endforeach
            @endif
        </ul>
    </div>
</aside>
