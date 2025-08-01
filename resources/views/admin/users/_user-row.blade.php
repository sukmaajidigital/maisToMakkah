@props(['user', 'level' => 0])

<tr x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
    <!-- User Details -->
    <td class="px-6 py-4">
        <div class="flex items-center">
            @if ($user->children->isNotEmpty())
                <button @click="open = !open" class="mr-2 text-gray-500">
                    <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            @else
                <div class="w-5 h-5 mr-2"></div>
            @endif
            <div>
                <div class="text-base font-semibold">{{ $user->longname }}</div>
                <div class="font-normal text-gray-500">{{ $user->email }}</div>
            </div>
        </div>
    </td>
    <!-- Rank -->
    <td class="px-6 py-4">
        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
            {{ $user->rank->name ?? 'N/A' }}
        </span>
    </td>
    <!-- Upline -->
    <td class="px-6 py-4 text-sm text-gray-500">
        {{ $user->parent->longname ?? '-' }}
    </td>
    <!-- Downlines -->
    <td class="px-6 py-4 text-center">
        {{ $user->children->count() }} / 5
    </td>
    <!-- Action Buttons -->
    <td class="px-6 py-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <x-button.edit href="{{ route('admin.users.edit', $user) }}" />
            <x-button.delete action="{{ route('admin.users.destroy', $user) }}" />
        </div>
    </td>
</tr>

<!-- Downline Rows -->
<tr x-show="open" x-transition style="display: none;">
    <td colspan="5" class="p-0">
        <div class="pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-800/50">
            @if ($user->children->isNotEmpty())
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Downlines of {{ $user->longname }}:</h4>
                <table class="w-full">
                    <tbody>
                        @foreach ($user->children as $child)
                            @include('admin.users._user-row', ['user' => $child, 'level' => $level + 1])
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-500">No downlines found.</p>
            @endif
        </div>
    </td>
</tr>
