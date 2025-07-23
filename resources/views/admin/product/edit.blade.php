<x-layouts>
    <x-slot:header>
        Edit User: {{ $product->name }}
    </x-slot:header>

    <form action="{{ route('admin.product.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.product.field', ['product' => $product])
        <x-button.submit>Update</x-button.submit>
    </form>
</x-layouts>
