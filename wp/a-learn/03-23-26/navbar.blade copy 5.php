@mock('navbar')
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">Offcanvas navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <p class="h5 offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</p>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul
                    class="navbar-nav justify-content-end flex-grow-1 pe-3 justify-content-lg-start align-items-lg-center ps-lg-4">
                    {{-- foreach --}}
                    @if (!empty($data))
                    {{-- {{ debug($data) }} --}}
                    @foreach ($data as $item)
                    @if ($item['children'])
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $item['label'] }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($item['children'] as $child)
                            <li><a class="dropdown-item"
                                    href="{{ $child['slug'] }}">{{ $child['label'] }}</a></li>
                            @endforeach

                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="{{ $item['slug'] }}">{{ $item['label'] }}</a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ul>
                <form class="d-flex mt-3 my-lg-1" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>