@mock('navbar')
{{-- {{debug($data)}} --}}
<nav class="navbar bg-light navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand mx-auto" href="/">Offcanvas navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header shadow">
                <p class="h5 offcanvas-title mx-auto" id="offcanvasNavbarLabel">Offcanvas</p>
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
                                <li class="nav-item dropdown shadow-sm p-1 mb-1 ps-3">
                                    <a class="nav-link active dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $item['label'] }}
                                    </a>
                                    <ul class="dropdown-menu ms-3 border-0">
                                        @foreach ($item['children'] as $child)
                                            <li class='shadow-sm p-1 mb-1 ps-3'><a class="dropdown-item"
                                                    href="{{ $child['slug'] }}">{{ $child['label'] }}</a></li>
                                        @endforeach

                                    </ul>
                                </li>
                            @else
                                <li class="nav-item shadow-sm p-1 mb-1 ps-3">
                                    <a class="nav-link active" aria-current="page"
                                        href="{{ $item['slug'] }}">{{ $item['label'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <form class="d-flex mt-3 my-lg-1 shadow-sm" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>
