<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{{ data_get($data, 'featured_image_src', '') }}" class="img-fluid rounded-start" alt="{{ data_get($data, 'featured_image_alt', '') }}">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{ data_get($data, 'title', 'No title') }}</h5>
        <p class="card-text">{{ data_get($data, 'excerpt', '') }}</p>
        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
        <a href="/{{ data_get($data, 'slug', '#') }}" class="btn btn-primary">Read more</a>
      </div>
    </div>
  </div>
</div>