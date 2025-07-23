<x-layouts>
    <x-slot:header>
        Create Product
    </x-slot:header>

    <form action="{{ route('admin.product.store') }}" method="POST">
        @csrf
        @include('admin.product.field')
        <x-button.submit>Create</x-button.submit>
    </form>
</x-layouts>
