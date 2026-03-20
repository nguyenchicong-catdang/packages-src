@mock('cat_card')
@if (!empty($data))
    {{ debug($data) }}
@endif
<h1 class="px-1 fw-bold text-center"> {{ strtoupper($data['name']) }}</h1>
<div class="mx-auto col-lg-8 p-2">
  <div class="ratio ratio-1x1">
    <img class="w-100 shadow-lg rounded-2" src="{{ $data['featured_src'] }}" alt="{{ $data['featured_alt'] }}">
  </div>

</div>
<div class="p-3" style="text-indent: 10px;">{{ $data['description'] }}</div>
