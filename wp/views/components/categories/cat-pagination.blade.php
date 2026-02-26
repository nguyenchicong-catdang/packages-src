{{-- {{debug($data['items'][0]->thumbnail->attachment)}}
@php
    $meta_raw = $data['items'][0]->thumbnail->attachment->meta->_wp_attachment_metadata;
    $meta_array = unserialize($meta_raw);
@endphp
{{debug($meta_array['sizes'])}} --}}
<nav aria-label="Page navigation example">
    <ul class="pagination">
        {{-- Nút Previous --}}
        @php $currentPage = (int) data_get($data, 'currentPage', 1); @endphp
        
        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $currentPage > 1 ? request()->fullUrlWithQuery(['page' => $currentPage - 1]) : '#' }}">
                Previous
            </a>
        </li>

        {{-- Số trang --}}
        @for ($i = 1; $i <= (int) data_get($data, 'lastPage', 1); $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Nút Next --}}
        @php $lastPage = (int) data_get($data, 'lastPage', 1); @endphp
        <li class="page-item {{ $currentPage >= $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $currentPage < $lastPage ? request()->fullUrlWithQuery(['page' => $currentPage + 1]) : '#' }}">
                Next
            </a>
        </li>
    </ul>
</nav>