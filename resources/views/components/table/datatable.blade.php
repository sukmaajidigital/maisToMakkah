@props([
    'tablename' => '',
])

<table id="datatable-{{ $tablename }}" class="table min-w-full">
    {{ $slot }}
</table>


@push('componentscript')
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#datatable-{{ $tablename }}", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endpush
