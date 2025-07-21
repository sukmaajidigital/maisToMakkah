@props(['href'])

<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
]) }}>
    {{ $slot->isEmpty() ? 'Create' : $slot }}
</a>
