<x-layouts>
    <x-slot name="header">
        <h1>Customize Your Account</h1>
    </x-slot>

    <div>
        <form action="{{ route('settings.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            @include('user.settings.field')
            <x-button.submit>Update Profile</x-button.submit>
        </form>
    </div>
</x-layouts>
