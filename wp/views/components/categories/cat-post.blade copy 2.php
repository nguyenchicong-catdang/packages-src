{{debug($post)}}
<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      {{-- post thumbnail --}}
      <x-wp-comp::categories.cat-post-thumbnail :thumbnail="$post->thumbnail" />
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <p class="card-text">{{ $post->excerpt }}</p>
        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
        <a href="/{{ $post->slug }}" class="btn btn-primary">Read more</a>
      </div>
    </div>
  </div>
</div>