<x-layouts>
    <x-slot:header>
        Create User
    </x-slot:header>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users.field')
        <x-button.submit>Create</x-button.submit>
    </form>
</x-layouts>
