<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-items-start mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $header ?? 'Content Header' }}
            </h2>
        </div>
        {{ $slot }}
    </div>
</div>
