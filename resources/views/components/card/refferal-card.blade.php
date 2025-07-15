@props(['referralLink' => 'https://example.com/referral'])
<div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Link Referral Anda</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Bagikan link ini untuk merekrut anggota baru di bawah jaringan Anda.</p>
    <div class="flex items-center">
        <input type="text" id="referral-link" value="{{ $referralLink }}" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        <button onclick="copyToClipboard()" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <i class="ti ti-copy"></i>
        </button>
    </div>
</div>
@push('script')
    <script>
        function copyToClipboard() {
            const input = document.getElementById('referral-link');
            input.select();
            document.execCommand('copy');
            // Ganti ikon atau tampilkan notifikasi
            alert('Link referral disalin!');
        }
    </script>
@endpush
