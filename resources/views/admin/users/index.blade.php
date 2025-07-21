<x-layouts>
    <x-slot:header>
        {{ $header ?? 'Data User' }}
    </x-slot:header>
    <div>
        <x-table.datatable tablename="users">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>username</th>
                    <th>Nama Panjang</th>
                    <th>email</th>
                    <th>Nomor Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->longname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td> {{ $user->phone }} </td>
                    </tr>
                @endforeach
            </tbody>
        </x-table.datatable>
    </div>
</x-layouts>
