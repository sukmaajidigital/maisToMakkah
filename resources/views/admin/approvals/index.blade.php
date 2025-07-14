<x-layouts>
    <x-slot:header>
        Persetujuan
    </x-slot:header>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="approvalTabs" data-tabs-toggle="#approvalTabsContent" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="withdrawals-tab" data-tabs-target="#withdrawals" type="button" role="tab" aria-controls="withdrawals" aria-selected="true">Permintaan Penarikan</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="ranks-tab" data-tabs-target="#ranks" type="button" role="tab" aria-controls="ranks" aria-selected="false">Klaim Peringkat</button>
            </li>
        </ul>
    </div>
    <div id="approvalTabsContent">
        {{-- Withdrawals Tab Content --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="withdrawals" role="tabpanel" aria-labelledby="withdrawals-tab">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Tanggal Minta</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Rina Wati</td>
                            <td class="px-6 py-4">Rp 500.000</td>
                            <td class="px-6 py-4">14 Jul 2025</td>
                            <td class="px-6 py-4">
                                <button class="font-medium text-green-600 dark:text-green-500 hover:underline me-3">Setujui</button>
                                <button class="font-medium text-red-600 dark:text-red-500 hover:underline">Tolak</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Rank Claims Tab Content --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="ranks" role="tabpanel" aria-labelledby="ranks-tab">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Klaim Peringkat</th>
                            <th scope="col" class="px-6 py-3">Tgl. Klaim</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Budi Santoso</td>
                            <td class="px-6 py-4">Manager</td>
                            <td class="px-6 py-4">13 Jul 2025</td>
                            <td class="px-6 py-4">
                                <button class="font-medium text-green-600 dark:text-green-500 hover:underline me-3">Setujui</button>
                                <button class="font-medium text-red-600 dark:text-red-500 hover:underline">Tolak</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts>
