<x-layouts>
    <x-slot:header>
        {{ isset($user_to_edit) ? 'Edit Member: ' . $user_to_edit->longname : 'Daftarkan Member Baru' }}
    </x-slot:header>
    @if (session('success'))
        <x-alert.success :message="session('success')" />
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="col-span-1">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @include('network.register.form', ['user' => $user_to_edit ?? null])
            </div>
        </div>
        <div class="col-span-2">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <x-table.datatable tablename="downline_registered">
                    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Member yang Telah Didaftarkan
                        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Ini adalah daftar semua member yang berada langsung di bawah Anda.</p>
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Detail Kontak & Bank</th>
                            <th scope="col" class="px-6 py-3">Tgl. Daftar</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($downlines as $downline)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $downline->longname }}
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">ID: {{ $downline->name }}</div>
                                </th>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">Email: <span class="font-normal text-gray-700 dark:text-gray-400">{{ $downline->email }}</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white">No. HP: <span class="font-normal text-gray-700 dark:text-gray-400">{{ $downline->phone }}</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white mt-2">Bank: <span class="font-normal text-gray-700 dark:text-gray-400">{{ $downline->bank_name }}</span></div>
                                    <div class="text-sm text-gray-900 dark:text-white">Rek: <span class="font-normal text-gray-700 dark:text-gray-400">{{ $downline->bank_account_number }} ({{ $downline->bank_account_name }})</span></div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $downline->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-button.edit href="{{ route('network.register.edit', $downline) }}" />
                                    <x-button.delete action="{{ route('network.register.destroy', $downline) }}" />
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Anda belum mendaftarkan member.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-table.datatable>
            </div>
        </div>
    </div>
</x-layouts>
