{{debug($data)}}
<nav aria-label="Page navigation example">
    <ul class="pagination">
        {{-- Previous --}}
        @if (data_get($data, 'prevPageUrl'))
            <li class="page-item"><a class="page-link" href="{{ data_get($data, 'prevPageUrl') }}">Previous</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        @endif

        {{-- Số trang --}}
        @for ($i = 1; $i <= data_get($data, 'lastPage', 1); $i++)
            <li class="page-item {{ $i == data_get($data, 'currentPage', 1) ? 'active' : '' }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Next --}}
        @if (data_get($data, 'nextPageUrl'))
            <li class="page-item"><a class="page-link" href="{{ data_get($data, 'nextPageUrl') }}">Next</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
        @endif
    </ul>
</nav>