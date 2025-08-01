<x-layouts>
    <x-slot:header>
        {{ $header ?? 'Data Pengguna' }}
        <x-button.create href="{{ route('admin.users.create') }}" />
    </x-slot:header>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <x-table.datatable tablename="users">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Pengguna</th>
                    <th scope="col" class="px-6 py-3">Info Jaringan</th>
                    <th scope="col" class="px-6 py-3">Info Bank</th>
                    <th scope="col" class="px-6 py-3">Tanggal Bergabung</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="text-base font-semibold">{{ $user->longname }}</div>
                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                            <div class="font-normal text-gray-500">{{ $user->phone }}</div>
                        </th>
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-semibold">Peringkat:</span>
                                <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">{{ $user->rank->name ?? 'N/A' }}</span>
                            </div>
                            <div class="mt-1"><span class="font-semibold">Upline:</span> {{ $user->parent->longname ?? '-' }}</div>
                            <div class="mt-1"><span class="font-semibold">Downline:</span> {{ $user->children->count() }} / 5</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            <div>{{ $user->bank_name }}</div>
                            <div>{{ $user->bank_account_number }}</div>
                            <div>a.n. {{ $user->bank_account_name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <x-button.edit href="{{ route('admin.users.edit', $user) }}" />
                                <x-button.delete action="{{ route('admin.users.destroy', $user) }}" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pengguna yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table.datatable>
    </div>
</x-layouts>
