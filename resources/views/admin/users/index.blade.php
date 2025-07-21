<x-layouts>
    <x-slot:header>
        {{ $header ?? 'Data User' }}
        <x-button.create href="{{ route('admin.users.create') }}" />
    </x-slot:header>
    <x-table.datatable tablename="users">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Username</th>
                <th class="px-4 py-2 text-left">Detail</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">
                        <div class="font-medium text-gray-900">{{ $user->longname }}</div>
                        <div>Email: {{ $user->email }}</div>
                        <div>Phone: {{ $user->phone }}</div>
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center gap-2">
                            <x-button.edit href="{{ route('admin.users.edit', $user) }}" />
                            <x-button.delete action="{{ route('admin.users.destroy', $user) }}" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-table.datatable>
</x-layouts>
