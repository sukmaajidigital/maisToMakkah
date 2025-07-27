<x-layouts>
    <x-slot:header>
        Riwayat Bonus
    </x-slot:header>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                Daftar Semua Bonus Diterima
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Ini adalah catatan semua bonus yang pernah masuk ke akun Anda.</p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bonusHistory as $bonus)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $bonus->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $typeColors = [
                                    'direct_referral' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'indirect_referral' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                    'rank_transaction' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                ];
                            @endphp
                            <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded-full {{ $typeColors[$bonus->type] ?? '' }}">
                                {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $bonus->type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs">{{ $bonus->description }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-500 text-right whitespace-nowrap">
                            + Rp {{ number_format($bonus->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada riwayat bonus.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $bonusHistory->links() }}
    </div>
</x-layouts>
