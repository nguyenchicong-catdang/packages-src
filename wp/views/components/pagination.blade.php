<nav aria-label="Page navigation example">
  <ul class="pagination">
    {{-- Nút Quay lại --}}
    @if (!$paginator->onFirstPage())
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
    @else
        <li class="page-item disabled"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
    @endif

    {{-- Các con số trang --}}
    @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
    <li class="page-item">
        <a class="page-link {{$page == $paginator->currentPage() ? 'active' : ''}}" href="{{$url}}">{{$page}}</a>
    </li>
    @endforeach
    
    {{-- Nút Tiếp theo --}}
    @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link"href="{{ $paginator->nextPageUrl() }}">Next</a></li>
    @else
        <li class="page-item disabled"><a class="page-link"href="{{ $paginator->nextPageUrl() }}">Next</a></li>
    @endif
</ul>
</nav>