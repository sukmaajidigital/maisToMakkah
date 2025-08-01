@props(['user'])

<li x-data="{ open: false }" class="my-2">
    <!-- User Information Card -->
    <div @click="open = !open" class="flex items-start p-3 text-base rounded-lg transition duration-75 group hover:bg-gray-100 dark:hover:bg-gray-700 {{ $user->children->isNotEmpty() ? 'cursor-pointer' : '' }}">

        <!-- Toggle Icon -->
        <div class="pt-1">
            @if ($user->children->isNotEmpty())
                <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            @else
                <span class="w-5 h-5"></span>
            @endif
        </div>

        <!-- Main & Bank Details Grid -->
        <div class="flex-1 ms-3 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
            <!-- Main Details -->
            <div>
                <p class="text-md font-semibold text-gray-900 dark:text-white">{{ $user->longname }} <span class="font-normal text-gray-500">({{ $user->name }})</span></p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone }}</p>
            </div>
            <!-- Bank & Network Details -->
            <div class="text-sm text-gray-600 dark:text-gray-400 md:text-right">
                <p>
                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">{{ $user->rank->name ?? 'N/A' }}</span>
                </p>
                <p class="mt-1">Downlines: <span class="font-semibold">{{ $user->children->count() }}</span></p>
                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Info Bank:</p>
                    <p>{{ $user->bank_name }}</p>
                    <p>{{ $user->bank_account_number }}</p>
                    <p>a.n. {{ $user->bank_account_name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nested List for Downlines -->
    @if ($user->children->isNotEmpty())
        <ul x-show="open" x-transition class="pl-8 mt-2 space-y-2 border-l-2 border-gray-200 dark:border-gray-600" style="display: none;">
            @foreach ($user->children as $child)
                @include('admin.network._node', ['user' => $child])
            @endforeach
        </ul>
    @endif
</li>
