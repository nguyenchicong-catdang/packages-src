@mock('cat_card')
@php
    $data ??= ['null: data'];
@endphp
{{-- {{ debug($data) }} --}}
{{-- <h1 class="fw-bold" style="font-size: calc(1.375rem + 1.5vw);">{{ strtoupper($data['name']) }}</h1> --}}

<div class="row pb-lg-5" style="margin-bottom: calc(2vw);">
    <div class="col-12 col-lg-6">
        <div class="ratio ratio-1x1 mx-auto" style="max-width: 650px; margin-bottom: calc(1rem + 1vw);">
            <img class="img-fluid shadow-lg rounded-2" src="{{ $data['featured_src'] ?? 'null: featured_src' }}" alt="{{ $data['featured_alt'] ?? 'null: featured_alt' }}"
                fetchpriority="high">
            {{-- tham khao --}}
            {{-- <link rel="preload" as="image" href="/images/hero.webp" fetchpriority="high">
                    <img src="/images/hero.webp" fetchpriority="high" class="..."> --}}
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card border-0">
            <div class="card-header d-flex align-items-center">
                <x-dev-comp::breadcrumb />
            </div>
            <div class="card-body ps-4">
                <h1 class="fw-bold" style="font-size: calc(1rem + 0.5vw);">{{ strtoupper($data['name'] ?? 'null: name') }}</h1>

                {{-- <h1 class="card-title py-2">{{ strtoupper($data['name']) }}</h1> --}}
                <p class="card-text" style="text-indent: 20px;">{{ $data['description'] ?? 'null: description' }}</p>
            </div>
        </div>
    </div>
</div>
