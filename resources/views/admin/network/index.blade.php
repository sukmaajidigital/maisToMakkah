<x-layouts>
    <x-slot:header>
        Struktur Jaringan Global
    </x-slot:header>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pohon Jaringan Keseluruhan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Klik pada member untuk melihat atau menyembunyikan downline di bawahnya.</p>
        </div>

        <!-- Network Tree List -->
        <ul class="space-y-2">
            @forelse ($rootUsers as $rootUser)
                @include('admin.network._node', ['user' => $rootUser])
            @empty
                <li>
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Tidak ada pengguna yang ditemukan dalam jaringan.</p>
                </li>
            @endforelse
        </ul>
    </div>
</x-layouts>
