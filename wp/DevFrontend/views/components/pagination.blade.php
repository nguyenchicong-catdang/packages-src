@php
    $space = "p-0 m-2 p-md-2 px-md-3";
@endphp
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link {{$space}}" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        @for ($i = 1; $i <= 10; $i++)
            <li class="page-item"><a class="page-link {{$space}}" href="#">{{ $i }}</a></li>
        @endfor


        <li class="page-item">
            <a class="page-link {{$space}}" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
