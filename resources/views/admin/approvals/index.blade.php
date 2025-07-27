<x-layouts>
    <x-slot:header>
        Dashboard Persetujuan
    </x-slot:header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card untuk Penarikan Dana -->
        <a href="{{ route('admin.approvals.withdrawals') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Permintaan Penarikan</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Terdapat <span class="font-bold text-blue-600 dark:text-blue-400">{{ $pendingWithdrawalsCount }}</span> permintaan penarikan dana yang menunggu untuk diproses.</p>
        </a>

        <!-- Card untuk Klaim Peringkat -->
        <a href="{{ route('admin.approvals.ranks') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Klaim Peringkat</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Terdapat <span class="font-bold text-blue-600 dark:text-blue-400">{{ $pendingRankClaimsCount }}</span> klaim peringkat yang perlu diverifikasi.</p>
        </a>
    </div>
</x-layouts>
