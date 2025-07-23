<x-layouts>
    <x-slot:header>
        Jaringan Saya
    </x-slot:header>
    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Struktur Jaringan Anda</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Klik pada member yang memiliki ikon panah untuk melihat atau menyembunyikan downline di bawahnya.</p>
        </div>
        {{-- Pohon Jaringan --}}
        <ul class="space-y-2">
            <li>
                <div class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-blue-50 dark:bg-gray-700 dark:text-white">
                    <i class="ti ti-user-circle text-2xl text-blue-600 dark:text-blue-400"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">
                        Anda: {{ $user->longname }}
                        <span class="font-normal text-gray-600 dark:text-gray-300">({{ $user->rank->name ?? 'No Rank' }})</span>
                    </span>
                    @if ($user->downline_count > 0)
                        <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-900 dark:text-blue-300">
                            <i class="ti ti-users mr-1"></i>
                            Total {{ $user->downline_count }} Downline
                        </span>
                    @endif
                </div>
                {{-- Level 1 (Downline Langsung ) --}}
                @if ($user->children->isNotEmpty())
                    <ul class="pl-8 mt-2 space-y-2 border-l-2 border-blue-200 dark:border-blue-700">
                        @foreach ($user->children as $child)
                            @include('network.node-user', ['user' => $child, 'level' => 1])
                        @endforeach
                    </ul>
                @else
                    <div class="pl-8 mt-4 text-sm text-gray-500">
                        Anda belum memiliki downline.
                    </div>
                @endif
            </li>
        </ul>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-layouts>
