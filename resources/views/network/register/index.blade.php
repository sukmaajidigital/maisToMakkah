<x-layouts>
    <x-slot:header>
        Daftarkan Member
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <form>
                    @include('network.register.field')
                    <x-button.submit>Daftarkan</x-button.submit>
                </form>
            </div>
        </div>

        {{-- Withdrawal History Table --}}
        <div class="lg:col-span-2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Member yang telah didaftarkan
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Detail</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Tgl. Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 10; $i++)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">John Doe {{ $i + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">Email: <span class="font-medium text-gray-700 dark:text-gray-400">5x5d6@example.com</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white">No. HP: <span class="font-medium text-gray-700 dark:text-gray-400">08123456789</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white">Rekening: <span class="font-medium text-gray-700 dark:text-gray-400">1234567890</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white">Nama di Bank: <span class="font-medium text-gray-700 dark:text-gray-400">John Doe</span></div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Approved</span></td>
                                <td class="px-6 py-4">11 Jul 2025</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts>
