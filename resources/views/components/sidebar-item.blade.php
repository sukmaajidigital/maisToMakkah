@if (isset($menu['submenu']))
    @php
        $isActiveGroup = collect($menu['submenu'])->pluck('route')->some(fn($r) => request()->routeIs($r) || request()->routeIs(explode('.', $r)[0] . '.*') || request()->routeIs(implode('.', array_slice(explode('.', $r), 0, 2)) . '.*'));
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
