<form method="POST" action="{{ isset($user_to_edit) ? route('network.register.update', $user_to_edit) : route('network.register.store') }}">
    @csrf
    @if (isset($user_to_edit))
        @method('PUT')
    @endif
    @include('network.register.field', ['user' => $user_to_edit ?? null])
    <div class="flex items-center gap-4">
        <x-button.submit>{{ isset($user_to_edit) ? 'Update Member' : 'Daftarkan' }}</x-button.submit>
        @if (isset($user_to_edit))
            <a href="{{ route('network.register.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                Batal
            </a>
        @endif
    </div>
</form>
