<nav class="custom-pagination">
    <ul class="flex list-none gap-2">
        {{-- Nút Quay lại --}}
        @if (!$paginator->onFirstPage())
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 border">« Trước</a>
            </li>
        @endif

        {{-- Các con số trang --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" 
                   class="px-3 py-2 border {{ $page == $paginator->currentPage() ? 'bg-blue-500 text-white' : '' }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Nút Tiếp theo --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 border">Sau »</a>
            </li>
        @endif
    </ul>
</nav>