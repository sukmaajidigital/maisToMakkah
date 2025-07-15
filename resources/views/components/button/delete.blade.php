@props(['routes', 'confirmationMessage' => 'Are you sure?', 'title' => 'Delete'])
<div>
    <form action="{{ $routes }}" method="POST" onsubmit="return confirm('{{ $confirmationMessage }}')" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-error">
            <span class="icon-[tabler--trash] size-8  "></span>{{ $title }}
        </button>
    </form>
</div>
