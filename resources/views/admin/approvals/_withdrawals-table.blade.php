<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Rekening Tujuan</th>
                <th scope="col" class="px-6 py-3">Tanggal Minta</th>
                <th scope="col" class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($withdrawals as $withdrawal)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $withdrawal->user->longname }}
                        <div class="text-xs font-normal text-gray-500">{{ $withdrawal->user->email }}</div>
                    </th>
                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-xs">
                        {{ $withdrawal->user->bank_name }} <br>
                        {{ $withdrawal->user->bank_account_number }} <br>
                        a.n {{ $withdrawal->user->bank_account_name }}
                    </td>
                    <td class="px-6 py-4">{{ $withdrawal->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menyetujui penarikan ini?')">
                            @csrf
                            <button type="submit" class="font-medium text-green-600 dark:text-green-500 hover:underline me-3">Setujui</button>
                        </form>
                        <button @click="rejectModal = true; rejectAction = '{{ route('admin.approvals.withdrawals.reject', $withdrawal) }}'" type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline">Tolak</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada permintaan penarikan dana yang pending.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
