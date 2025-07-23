@props(['user', 'level' => 0])

{{-- Menggunakan Alpine.js untuk state buka/tutup --}}
<li x-data="{ open: {{ $level < 1 ? 'true' : 'false' }} }">
    <div @if ($user->children->isNotEmpty()) @click="open = !open" @endif class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $user->children->isNotEmpty() ? 'cursor-pointer' : '' }}">

        {{-- arrow icon --}}
        @if ($user->children->isNotEmpty())
            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        @else
            <span class="w-5 h-5"></span>
        @endif

        <i class="ti ti-user text-xl ml-2 {{ $level == 0 ? 'text-blue-600' : 'text-gray-600' }} dark:{{ $level == 0 ? 'text-blue-400' : 'text-gray-400' }}"></i>

        <span class="flex-1 ms-3 whitespace-nowrap">
            {{ $user->longname }}
            <span class="font-normal text-gray-500 dark:text-gray-400">({{ $user->rank->name ?? 'No Rank' }})</span>
        </span>

        {{-- count downline --}}
        @if ($user->downline_count > 0)
            <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-600 dark:text-gray-300">
                <i class="ti ti-users mr-1"></i>
                {{ $user->downline_count }}
            </span>
        @endif
    </div>

    {{-- Daftar downline (rekursif), hanya ditampilkan jika 'open' adalah true --}}
    @if ($user->children->isNotEmpty())
        <ul x-show="open" x-transition class="pl-8 mt-2 space-y-2 border-l-2 border-gray-200 dark:border-gray-600">
            @foreach ($user->children as $child)
                {{-- Memanggil component ini lagi untuk setiap anak --}}
                @include('network.node-user', ['user' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
