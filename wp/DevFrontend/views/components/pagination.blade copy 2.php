@mock('pagination')
@if (!empty($data))
    {{-- {{ debug($data) }} --}}
@endif
@php
    $space = 'p-0 m-2 p-md-2 px-md-3';
    $items = $data['total_items'] ?? 1;
    // $limit = $data['limit'] ?? 12;
    $limit = 1;

    $total_pages = min((int) ceil($items / $limit), 10);

    $current_page = request()->query('page') ?? 1;
@endphp

{{ debug($total_pages) }}
{{-- {{ debug(request()->fullUrlWithQuery(['type' => 'phone'])) }} --}}
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            @if ($current_page <= 1)
                <a class="page-link disabled {{ $space }}" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            @elseif($current_page == 2)
                <a class="page-link {{ $space }}" href="{{ request()->url() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            @else
                <a class="page-link {{ $space }}" href="{{ request()->fullUrlWithQuery(['page' => $current_page -1]) }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            @endif
        </li>
        <li class="page-item"><a class="page-link {{ $space }}" href="{{ request()->url() }}">1</a></li>
        @for ($i = 2; $i <= $total_pages; $i++)
            <li class="page-item"><a class="page-link {{ $space }}"
                    href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a></li>
        @endfor


        <li class="page-item">
            @if ($current_page >= $total_pages)
                <a class="page-link disabled {{ $space }}" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            @else
                <a class="page-link {{ $space }}"
                    href="{{ request()->fullUrlWithQuery(['page' => $current_page + 1]) }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            @endif

        </li>
    </ul>
</nav>
