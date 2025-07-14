<x-layouts>
    <x-slot:header>
        Penarikan Dana
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Withdrawal Form --}}
        <div class="lg:col-span-1">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Ajukan Penarikan</h3>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4">Saldo Anda saat ini: <span class="font-bold text-green-600">Rp 7.250.000</span></p>

                <form>
                    <div class="mb-4">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penarikan</label>
                        <input type="number" id="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Min. Rp 50.000" required>
                    </div>
                    <div class="mb-4">
                        <label for="bank" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rekening Tujuan</label>
                        <select id="bank" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option selected>BCA - 1234567890 a.n David</option>
                            <option>Mandiri - 0987654321 a.n David</option>
                        </select>
                        <a href="#" class="text-xs text-blue-600 dark:text-blue-500 hover:underline mt-1 inline-block">Kelola Rekening</a>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Konfirmasi</label>
                        <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Permintaan
                    </button>
                </form>
            </div>
        </div>

        {{-- Withdrawal History Table --}}
        <div class="lg:col-span-2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Riwayat Penarikan Dana
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Tgl. Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">10 Jul 2025</td>
                            <td class="px-6 py-4">Rp 2.000.000</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Approved</span></td>
                            <td class="px-6 py-4">11 Jul 2025</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">05 Jun 2025</td>
                            <td class="px-6 py-4">Rp 1.500.000</td>
                            <td class="px-6 py-4"><span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Rejected</span></td>
                            <td class="px-6 py-4">05 Jun 2025</td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">14 Jul 2025</td>
                            <td class="px-6 py-4">Rp 1.000.000</td>
                            <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pending</span></td>
                            <td class="px-6 py-4">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts>
