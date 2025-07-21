@props(['action', 'confirmationMessage' => 'apa kamu yakin?', 'title' => 'Delete'])
<div>
    <form action="{{ $action }}" method="POST" onsubmit="return confirm('{{ $confirmationMessage }}')" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
            Delete
        </button>
    </form>
</div>
