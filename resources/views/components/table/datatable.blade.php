@props([
    'tablename' => '',
])

<table id="datatable-{{ $tablename }}">
    {{ $slot }}
</table>


@push('componentscript')
    <script>
        if (document.getElementById("datatable-{{ $tablename }}") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#datatable-{{ $tablename }}", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endpush
