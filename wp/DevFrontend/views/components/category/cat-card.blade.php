@mock('cat_card')
@if (!empty($data))
    {{ debug($data) }}
@endif

<div class="card text-bg-dark">
  <img class="object-fit-cover" src="{{ $data['featured_src'] }}" class="card-img" alt="{{ $data['featured_alt'] }}">
  <div class="card-img-overlay">
    <h1 class="card-title">{{ $data['name'] }}</h1>
    <p class="card-text">{{ $data['description'] }}</p>
  </div>
</div>