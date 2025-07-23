<x-layouts>
    <x-slot:header>
        Dashboard
    </x-slot:header>

    {{-- Data untuk kartu statistik, diambil dari controller --}}
    @php
        $dataCards = [
            'Total Saldo Bonus' => $totalBonus,
            'Peringkat Saat Ini' => $currentRank,
            'Downline Langsung' => $directDownlines . ' Orang',
            'Total Jaringan' => $totalNetwork . ' Orang',
        ];
    @endphp

    {{-- Menampilkan Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach ($dataCards as $title => $value)
            {{-- Pastikan Anda memiliki komponen ini --}}
            <x-card.mini-card :value="$value" :title="$title" />
        @endforeach
    </div>

    {{-- Kartu Link Referral --}}
    <x-card.refferal-card :referralLink="$referralLink" />

    {{-- Tabel Riwayat Bonus Terbaru --}}
    <div class="mt-6">
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
                Riwayat Bonus Terbaru
            </h5>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipe & Deskripsi
                            </th>
                            <th scope="col" class="px-6 py-3 text-right">
                                Jumlah
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBonuses as $bonus)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    {{ $bonus->created_at->format('d M Y, H:i') }}
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{-- Badge untuk tipe bonus --}}
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ Str::title(str_replace('_', ' ', $bonus->type)) }}</span>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $bonus->description }}</p>
                                </th>
                                <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-500 text-right">
                                    + Rp {{ number_format($bonus->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada riwayat bonus.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts>
