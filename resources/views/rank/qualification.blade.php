<x-layouts>
    <x-slot:header>
        Kualifikasi Peringkat
    </x-slot:header>

    @if (session('success'))
        <x-alert.success :message="session('success')" />
    @endif
    @if (session('error'))
        <x-alert.error :message="session('error')" />
    @endif

    {{-- Progress Card --}}
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Peringkat Anda: {{ $currentRank->name ?? 'Belum Ada Peringkat' }}</h3>

        @if ($nextRank)
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4">Anda selangkah lagi menuju peringkat selanjutnya!</p>
            <div class="mb-4">
                <div class="flex justify-between mb-1">
                    <span class="text-base font-medium text-blue-700 dark:text-white">Progress ke {{ $nextRank->name }}</span>
                    <span class="text-sm font-medium text-blue-700 dark:text-white">{{ number_format($totalNetwork) }} / {{ number_format($nextRank->min_downline_count) }} Orang</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress > 100 ? 100 : $progress }}%"></div>
                </div>
                @if (!$canClaim)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Dibutuhkan {{ number_format($nextRank->min_downline_count - $totalNetwork) }} orang lagi di total jaringan Anda untuk dapat melakukan klaim peringkat {{ $nextRank->name }}.</p>
                @else
                    <p class="text-xs text-green-600 dark:text-green-400 mt-2">Selamat! Anda sudah memenuhi syarat untuk klaim peringkat {{ $nextRank->name }}.</p>
                @endif
            </div>

            <form action="{{ route('rank.claim.store') }}" method="POST">
                @csrf
                <input type="hidden" name="rank_id_to_claim" value="{{ $nextRank->id }}">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed" {{ !$canClaim || $hasPendingClaim ? 'disabled' : '' }}>
                    {{ $hasPendingClaim ? 'Klaim Sedang Diproses' : 'Klaim Peringkat Sekarang' }}
                </button>
            </form>
        @else
            <p class="mt-4 text-lg font-semibold text-green-600 dark:text-green-400">Selamat! Anda telah mencapai peringkat tertinggi.</p>
        @endif
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
                @forelse ($claimHistory as $claim)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $claim->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $claim->claimedRank->name }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                ];
                            @endphp
                            <span class="text-sm font-medium me-2 px-2.5 py-0.5 rounded {{ $statusColors[$claim->status] ?? '' }}">
                                {{ ucfirst($claim->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $claim->admin_notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Anda belum pernah melakukan klaim peringkat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts>
