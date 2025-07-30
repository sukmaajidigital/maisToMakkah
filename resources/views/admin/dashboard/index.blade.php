<x-layouts>
    <x-slot:header>
        Admin Dashboard
    </x-slot:header>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</h5>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk</h5>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Penarikan</h5>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPendingWithdrawalAmount, 0, ',', '.') }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Klaim Peringkat</h5>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPendingRankClaims) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activities -->
        <div class="lg:col-span-1">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Persetujuan Terbaru</h5>
                <ol class="relative border-s border-gray-200 dark:border-gray-700">
                    @forelse ($latestPendingWithdrawals as $withdrawal)
                        <li class="mb-6 ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $withdrawal->created_at->diffForHumans() }}</time>
                            <h3 class="text-md font-semibold text-gray-900 dark:text-white">Penarikan: {{ $withdrawal->user->longname }}</h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Sebesar Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                            <a href="{{ route('admin.approvals.withdrawals') }}" class="inline-flex items-center px-3 py-1 mt-2 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Proses</a>
                        </li>
                    @empty
                        <p class="ms-4 text-sm text-gray-500">Tidak ada permintaan penarikan.</p>
                    @endforelse

                    @forelse ($latestPendingRankClaims as $claim)
                        <li class="mb-6 ms-4">
                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $claim->created_at->diffForHumans() }}</time>
                            <h3 class="text-md font-semibold text-gray-900 dark:text-white">Klaim: {{ $claim->user->longname }}</h3>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Ke peringkat {{ $claim->claimedRank->name }}</p>
                            <a href="{{ route('admin.approvals.ranks') }}" class="inline-flex items-center px-3 py-1 mt-2 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Proses</a>
                        </li>
                    @empty
                        <p class="ms-4 text-sm text-gray-500">Tidak ada klaim peringkat.</p>
                    @endforelse
                </ol>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-span-2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Pengguna Baru Terdaftar
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Upline</th>
                            <th scope="col" class="px-6 py-3">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentUsers as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->longname }}</th>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->parent->longname ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada pengguna baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts>
