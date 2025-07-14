<x-layouts>
    <x-slot:header>
        Jaringan Saya
    </x-slot:header>

    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Struktur Jaringan Anda</h3>

        {{-- pohon nested list --}}
        <ul class="space-y-4">
            {{-- Level 0 (Anda) --}}
            <li>
                <div class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">
                    <i class="ti ti-user-circle text-xl text-blue-600 dark:text-blue-400"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Anda (David - Senior Manager)</span>
                </div>
                {{-- Level 1 (Downline Langsung) --}}
                <ul class="pl-6 mt-4 space-y-4 border-l-2 border-gray-200 dark:border-gray-600">
                    <li>
                        <div class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-white shadow-sm dark:bg-gray-900 dark:text-white">
                            <i class="ti ti-user text-lg"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Budi Santoso (Manager)</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">20 Downlines</span>
                        </div>
                        {{-- Level 2 (Downline dari Budi) --}}
                        <ul class="pl-6 mt-4 space-y-4 border-l-2 border-gray-200 dark:border-gray-600">
                            <li>
                                <div class="flex items-center p-3 text-sm font-medium text-gray-900 rounded-lg bg-white shadow-sm dark:bg-gray-900 dark:text-white">
                                    <i class="ti ti-user text-base"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap">Siti Aminah (Sales)</span>
                                    <span class="inline-flex items-center justify-center px-2 py-1 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">5 Downlines</span>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-3 text-sm font-medium text-gray-900 rounded-lg bg-white shadow-sm dark:bg-gray-900 dark:text-white">
                                    <i class="ti ti-user text-base"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap">Eko Prasetyo (Sales)</span>
                                    <span class="inline-flex items-center justify-center px-2 py-1 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">15 Downlines</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-white shadow-sm dark:bg-gray-900 dark:text-white">
                            <i class="ti ti-user text-lg"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Rina Wati (Sales)</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">0 Downlines</span>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</x-layouts>
