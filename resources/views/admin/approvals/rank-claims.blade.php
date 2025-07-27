<x-layouts>
    <x-slot:header>
        Persetujuan Klaim Peringkat
    </x-slot:header>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-medium">Sukses!</span> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </div>
    @endif

    <div x-data="{ rejectModal: false, rejectAction: '', rejectNotes: '' }">
        @include('admin.approvals._rank-claims-table', ['rankClaims' => $pendingRankClaims])

        <div class="mt-4">
            {{ $pendingRankClaims->links() }}
        </div>

        <!-- Modal untuk konfirmasi penolakan -->
        <div x-show="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="rejectModal = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Alasan Penolakan</h3>
                <form :action="rejectAction" method="POST">
                    @csrf
                    <textarea x-model="rejectNotes" name="admin_notes" rows="3" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Tuliskan alasan penolakan di sini..." required></textarea>
                    <div class="mt-4 flex justify-end gap-3">
                        <button type="button" @click="rejectModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Tolak Permintaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts>
