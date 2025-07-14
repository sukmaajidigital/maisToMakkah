<x-layouts>
    <x-slot:header>
        Kualifikasi Peringkat
    </x-slot:header>

    {{-- Progress Card --}}
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Peringkat Anda: Senior Manager</h3>
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4">Anda selangkah lagi menuju peringkat selanjutnya!</p>

        <div class="mb-4">
            <div class="flex justify-between mb-1">
                <span class="text-base font-medium text-blue-700 dark:text-white">Progress ke Executive Manager</span>
                <span class="text-sm font-medium text-blue-700 dark:text-white">124 / 200 Orang</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                <div class="bg-blue-600 h-4 rounded-full" style="width: 62%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Dibutuhkan 76 orang lagi di total jaringan Anda untuk dapat melakukan klaim peringkat Executive Manager.</p>
        </div>

        {{-- Tombol ini bisa di-enable/disable dari backend --}}
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Klaim Peringkat Sekarang
        </button>
    </div>

    {{-- Claim History Table --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Riwayat Klaim Peringkat
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal Klaim</th>
                    <th scope="col" class="px-6 py-3">Peringkat Diklaim</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Catatan Admin</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">01 Mei 2025</td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Senior Manager</td>
                    <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Approved</span></td>
                    <td class="px-6 py-4">Selamat!</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">15 Apr 2025</td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Manager</td>
                    <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Approved</span></td>
                    <td class="px-6 py-4">Verifikasi berhasil</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layouts>
