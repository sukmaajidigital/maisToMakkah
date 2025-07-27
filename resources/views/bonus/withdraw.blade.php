<x-layouts>
    <x-slot:header>
        Penarikan Dana
    </x-slot:header>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
        </div>
    @endif
    @if ($errors->any())
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <div>
                <span class="font-medium">Oops! Terjadi kesalahan:</span>
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Withdrawal Form --}}
        <div class="col-span-1">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Ajukan Penarikan</h3>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4">Saldo Anda saat ini: <span class="font-bold text-green-600">Rp {{ number_format($user->bonus_balance, 0, ',', '.') }}</span></p>

                <form action="{{ route('bonus.withdraw.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penarikan</label>
                        <input type="number" id="amount" name="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Min. Rp 50.000" required value="{{ old('amount') }}">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rekening Tujuan</label>
                        <div class="p-2.5 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-700 dark:text-gray-300">
                            {{ $user->bank_name }} - {{ $user->bank_account_number }} <br> a.n. {{ $user->bank_account_name }}
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Konfirmasi</label>
                        <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Permintaan
                    </button>
                </form>
            </div>
        </div>

        {{-- Withdrawal History Table --}}
        <div class="col-span-2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Riwayat Penarikan Dana
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tgl. Permintaan</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Tgl. Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($withdrawalHistory as $withdrawal)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $withdrawal->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        ];
                                    @endphp
                                    <span class="text-sm font-medium me-2 px-2.5 py-0.5 rounded {{ $statusColors[$withdrawal->status] ?? '' }}">
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $withdrawal->processed_at ? $withdrawal->processed_at->format('d M Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada riwayat penarikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination Links --}}
                <div class="p-4">
                    {{ $withdrawalHistory->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts>
