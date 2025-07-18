@props(['label', 'readonly' => '', 'placeholder' => '', 'id', 'type' => 'text', 'name', 'required', 'value'])

<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
    {{ $label }}
</label>
<input type="{{ $type }}" placeholder="{{ $placeholder }}" name="{{ $name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-4" id="{{ $id }}" value="{{ $value }}" {{ $required }} {{ $readonly }} />
@if ($errors->get($name))
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
        @foreach ((array) $errors->get($name) as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
