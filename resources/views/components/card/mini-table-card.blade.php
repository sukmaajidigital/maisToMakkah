@props(['data'])

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
            @foreach ($data as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $item['created_at'] }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-{{ $item['badge_color'] }}-100 text-{{ $item['badge_color'] }}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-{{ $item['badge_color'] }}-900 dark:text-{{ $item['badge_color'] }}-300">{{ $item['type'] }}</span>
                    </td>
                    <td class="px-6 py-4 font-medium text-green-600 dark:text-green-500">+ Rp {{ number_format($item['amount'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $item['description'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
