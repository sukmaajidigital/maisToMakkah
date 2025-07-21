@props(['href'])

<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
]) }}>
    {{ $slot->isEmpty() ? 'Edit' : $slot }}
</a>
