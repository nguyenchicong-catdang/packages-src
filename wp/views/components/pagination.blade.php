@props(['data' => []])
@php
    $limit = $data['limit'] ?? 12;
    // Đảm bảo $totalItems luôn là số nguyên, kể cả khi data rỗng
    $totalItems = (int) ($data['total_items'] ?? 0); // Để 0 để đúng thực tế data
    
    // Tính toán xong mới chặn dưới là 1
    $totalPages = (int) max(1, ceil($totalItems / $limit));
    $currentPage = (int) request()->query('page', 1);
    // Lấy URL hiện tại sạch sẽ
    // $baseUrl = url()->current();
    // $url = request()->fullUrlWithQuery(['page' => 1]);
@endphp
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item {{$currentPage <=1 ? 'disabled' : ''}}">
      <a class="page-link" href="{{ $currentPage <=1 ? '#' : request()->fullUrlWithQuery(['page' => $currentPage -1]) }}">Previous</a>
    </li>

    @for($i=1; $i<= $totalPages; $i++)
    <li class="page-item {{$i == $currentPage ? 'active' : ''}}">
      <a class="page-link" href="{{request()->fullUrlWithQuery(['page' => $i])}}">{{$i}}</a>
    </li>
    @endfor
    <li class="page-item {{$currentPage >= $totalPages ? 'disabled' : ''}}">
      <a class="page-link" href="{{ $currentPage >= $totalPages ? '#' : request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Next</a>
    </li>
  </ul>
</nav>
