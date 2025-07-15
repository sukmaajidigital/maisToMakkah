@props(['label', 'readonly' => '', 'placeholder' => '', 'id', 'name', 'required', 'value'])

<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
    {{ $label }}
</label>
<textarea class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ $placeholder }}" id="{{ $id }}" name="{{ $name }}" {{ $required }} {{ $readonly }}>{{ $value }}</textarea>
@if ($errors->get($name))
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
        @foreach ((array) $errors->get($name) as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
