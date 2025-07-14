<x-layouts>
    <x-slot:header>
        Dashboard
    </x-slot:header>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Rp 7.250.000</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total Saldo Bonus</p>
        </div>
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Senior Manager</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Peringkat Saat Ini</p>
        </div>
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">5 Orang</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Downline Langsung</p>
        </div>
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">124 Orang</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total Jaringan</p>
        </div>
    </div>

    {{-- Referral Link --}}
    <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Link Referral Anda</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Bagikan link ini untuk merekrut anggota baru di bawah jaringan Anda.</p>
        <div class="flex items-center">
            <input type="text" id="referral-link" value="https://aplikasimlmsaya.com/register?ref=USER123XYZ" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <button onclick="copyToClipboard()" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="ti ti-copy"></i>
            </button>
        </div>
    </div>

    {{-- Recent Bonus Activity Table --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Aktivitas Bonus Terbaru
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Berikut adalah 5 bonus terakhir yang Anda terima.</p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Tipe Bonus</th>
                    <th scope="col" class="px-6 py-3">Jumlah</th>
                    <th scope="col" class="px-6 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">14 Jul 2025</td>
                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Direct Referral</span></td>
                    <td class="px-6 py-4 font-medium text-green-600 dark:text-green-500">+ Rp 1.000.000</td>
                    <td class="px-6 py-4">Bonus rekrut langsung dari Budi Santoso</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">13 Jul 2025</td>
                    <td class="px-6 py-4"><span class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Indirect Referral</span></td>
                    <td class="px-6 py-4 font-medium text-green-600 dark:text-green-500">+ Rp 50.000</td>
                    <td class="px-6 py-4">Bonus dari rekrutmen oleh Siti Aminah</td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">13 Jul 2025</td>
                    <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Rank Transaction</span></td>
                    <td class="px-6 py-4 font-medium text-green-600 dark:text-green-500">+ Rp 20.000</td>
                    <td class="px-6 py-4">Bonus dari transaksi oleh Eko Prasetyo</td>
                </tr>
            </tbody>
        </table>
    </div>

    @push('script')
        <script>
            function copyToClipboard() {
                const input = document.getElementById('referral-link');
                input.select();
                document.execCommand('copy');
                // Ganti ikon atau tampilkan notifikasi
                alert('Link referral disalin!');
            }
        </script>
    @endpush
</x-layouts>
