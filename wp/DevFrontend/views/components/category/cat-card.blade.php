@mock('cat_card')
@if (!empty($data))
    {{ debug($data) }}
@endif
<x-dev-comp::breadcrumb />
<h1 class="px-1 fw-bold"> {{ strtoupper($data['name']) }}</h1>
<div class="row mt-4">
  <div class="col">
      <div class="p-1 pt-5" style="text-indent: 10px;">{{ $data['description'] }}</div>
    </div>
    <div class="col">
      <div class="ratio ratio-1x1" style="max-width: 600px;">
        <img class="img-fluid shadow-lg rounded-5" src="{{ $data['featured_src'] }}" alt="{{ $data['featured_alt'] }}">
      </div>
    </div>
</div>
