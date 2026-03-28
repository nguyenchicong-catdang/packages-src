@mock('cat_card')
@if (!isset($data))
    {{ debug('Null: data') }}
@else
    <x-wp-comp::breadcrumb />
    <h1 class="fw-bold p-1" style="font-size: calc(1rem + 0.5vw);">
        {{ strtoupper($data['name'] ?? 'null: name') }}</h1>
    <div class="ratio ratio-1x1" style="max-width: 650px;">
        <img class="img-fluid shadow-lg rounded-2" src="{{ $data['featured_src'] ?? 'null: featured_src' }}"
            alt="{{ $data['featured_alt'] ?? 'null: featured_alt' }}" fetchpriority="high">
    </div>
    <p style="text-indent: 20px;">{{ $data['description'] ?? 'null: description' }}
    </p>
@endif
