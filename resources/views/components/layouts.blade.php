<!doctype html>
<html lang="en" dir="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="">
    <meta property="og:title" content="{{ $subname ?? '' }}">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#ffc107">
    <meta name="theme-color" content="#ffc107">
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" type="image/png" href="" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/datatable/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('select2/custom.select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('flowbite/flowbite.min.css') }}" />
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('alert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @stack('style')
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <x-header />
    <x-sidebar />
    <x-content :header="$header ?? str()->title(request()->route()->getPrefix())">
        {{ $slot }}
    </x-content>

    <script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/datatable/datatable.min.js') }}"></script>
    <script src="{{ asset('flowbite/flowbite.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}
    <script src="{{ asset('alert/sweetalert2.all.min.js') }}"></script>
    @stack('script')
    @stack('componentscript')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || "Select an option";
                },
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        @elseif (session('error'))
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'warning',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        @elseif (session('info'))
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'info',
                title: '{{ session('info') }}',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        @elseif (session('delete'))
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: '{{ session('delete') }}',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>

</html>
