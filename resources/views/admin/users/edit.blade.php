<x-layouts>
    <x-slot:header>
        Edit User: {{ $user->name }}
    </x-slot:header>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.users.field', ['user' => $user])
        <x-button.submit>Update</x-button.submit>
    </form>
</x-layouts>
