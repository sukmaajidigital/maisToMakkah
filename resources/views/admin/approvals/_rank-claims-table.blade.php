<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Dari Peringkat</th>
                <th scope="col" class="px-6 py-3">Klaim Peringkat</th>
                <th scope="col" class="px-6 py-3">Syarat Jaringan</th>
                <th scope="col" class="px-6 py-3">Tgl. Klaim</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rankClaims as $claim)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $claim->user->longname }}
                    </th>
                    <td class="px-6 py-4">{{ $claim->user->rank->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $claim->claimedRank->name }}</td>
                    <td class="px-6 py-4">
                        {{ $claim->user->downline_count }} / {{ $claim->claimedRank->min_downline_count }}
                        @if ($claim->user->downline_count >= $claim->claimedRank->min_downline_count)
                            <i class="ti ti-circle-check text-green-500"></i>
                        @else
                            <i class="ti ti-circle-x text-red-500"></i>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $claim->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.approvals.ranks.approve', $claim) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menyetujui klaim peringkat ini?')">
                            @csrf
                            <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline me-3">Setujui</button>
                        </form>
                        <button @click="rejectModal = true; rejectAction = '{{ route('admin.approvals.ranks.reject', $claim) }}'" type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline">Tolak</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada klaim peringkat yang pending.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
