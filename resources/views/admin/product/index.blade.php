<x-layouts>
    <x-slot:header>
        {{ $header ?? 'Data Produk' }}
        <x-button.create href="{{ route('admin.product.create') }}" />
    </x-slot:header>
    <x-table.datatable tablename="products">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Nama Produk</th>
                <th class="px-4 py-2 text-left">Harga</th>
                <th class="px-4 py-2 text-left">Deskripsi</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td class="px-4 py-2 font-medium">{{ $product->name }}</td>
                    <td class="px-4 py-2 text-sm">{{ $product->base_price }}</td>
                    <td class="px-4 py-2 text-sm">{{ $product->description }}</td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center gap-2">
                            <x-button.edit href="{{ route('admin.product.edit', $product) }}" />
                            <x-button.delete action="{{ route('admin.product.destroy', $product) }}" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-table.datatable>
</x-layouts>
