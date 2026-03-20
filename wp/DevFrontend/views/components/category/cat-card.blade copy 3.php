@mock('cat_card')
@if (!empty($data))
    {{ debug($data) }}
@endif
<div class="row mt-4 mb-5">
    <div class="col-6 p-2">
        <div class="ratio ratio-1x1" style="max-width: 650px;">
            <img class="img-fluid shadow-lg rounded-2" src="{{ $data['featured_src'] }}" alt="{{ $data['featured_alt'] }}">
        </div>
    </div>
    <div class="col-6 p-2">
        <x-dev-comp::breadcrumb />

        <h1 class="fw-bold text-center"> {{ strtoupper($data['name']) }}</h1>
        <div class="p-3" style="text-indent: 20px;">
            {{ $data['description'] }}
        </div>
    </div>
</div>
<div class="mx-auto col-lg-8 p-2">
    <div class="ratio ratio-1x1">
        <img class="w-100 shadow-lg rounded-2" src="{{ $data['featured_src'] }}" alt="{{ $data['featured_alt'] }}">
    </div>

</div>
<div class="p-3" style="text-indent: 10px;">{{ $data['description'] }}</div>
