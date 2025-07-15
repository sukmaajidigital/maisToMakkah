@props(['label', 'readonly' => '', 'onchange' => '', 'jsvalue' => '', 'optionname' => '', 'jscolname1' => '', 'jscolname2' => '', 'id', 'options' => [], 'name', 'required', 'selected' => null])

<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
    {{ $label }}
</label>
<select class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="padding-right: 2.5rem !important; background-position: right 0.75rem center !important;" id="{{ $id }}" name="{{ $name }}" {{ $required ? 'required' : '' }} {{ $readonly ? 'readonly' : '' }} onchange="{{ $onchange }}" dir="ltr">
    @if (is_array($options) && !is_object(reset($options)))
        {{-- Jika options adalah array asosiatif --}}
        <option value="">Select {{ $label }}</option>
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    @else
        {{-- Jika options adalah koleksi Eloquent atau array objek --}}
        <option value="">Select {{ $label }}</option>
        @foreach ($options as $key)
            <option value="{{ $key->id }}" @if ($jsvalue) data-select="{{ $key->$jscolname2 }}" @endif {{ $selected == $key->id ? 'selected' : '' }}>
                {{ $key->$optionname }}
            </option>
        @endforeach
    @endif
</select>
@if ($errors->get($name))
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
        @foreach ((array) $errors->get($name) as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
@push('componentscript')
    {{-- <script>
        $(document).ready(function() {
            $('#{{ $id }}').select2({
                placeholder: "Select {{ $label }}",
                allowClear: true,
                width: '100%' // penting agar full-width mengikuti Tailwind
            });
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || "Select an option";
                },
                allowClear: true,
                width: '100%' // penting agar full-width mengikuti Tailwind
            });
        });
    </script> --}}
@endpush
