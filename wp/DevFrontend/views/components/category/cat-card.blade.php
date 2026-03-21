@mock('cat_card')
@if (!empty($data))
    {{-- {{ debug($data) }} --}}
{{-- @endif --}}
{{-- <h1 class="fw-bold" style="font-size: calc(1.375rem + 1.5vw);">{{ strtoupper($data['name']) }}</h1> --}}

<div class="row" style="margin-bottom: calc(2vw);">
    <div class="col-12 col-lg-6">
        <div class="ratio ratio-1x1 mx-auto" style="max-width: 650px; margin-bottom: calc(1rem + 1vw);">
            <img class="img-fluid shadow-lg rounded-2" src="{{ $data['featured_src'] }}" alt="{{ $data['featured_alt'] }}">
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card border-0">
            <div class="card-header d-flex align-items-center">
                <x-dev-comp::breadcrumb />
            </div>
            <div class="card-body ps-4">
              <h1 class="fw-bold" style="font-size: calc(1rem + 0.5vw);">{{ strtoupper($data['name']) }} đa sd sad d asd asd sd asd asd sd asd sd</h1>

                {{-- <h1 class="card-title py-2">{{ strtoupper($data['name']) }}</h1> --}}
                <p class="card-text" style="text-indent: 20px;">{{ $data['description'] }}</p>
            </div>
        </div>
    </div>
</div>
@endif
