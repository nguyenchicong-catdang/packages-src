@props(['post'])

{{-- <div class="card mb-3" style="max-width: 540px;"> --}}
    <div class="card mb-3">

  <div class="row g-0">
    <div class="col-md-4 border-end">
    <div class="ratio ratio-1x1">
        <img src="{{ $post->thumbnail->attachment->url }}" 
             class="img-fluid object-fit-cover border rounded" 
             alt="{{ $post->title }}">
    </div>
</div>
    <div class="col-md-8">
      <div class="card-body d-flex flex-column h-100">
        <h5 class="card-title">{{$post->title}}</h5>
        {{-- <p class="card-text">{{$post->excerpt}}</p> --}}
        <p class="card-text">{{ Str::limit($post->excerpt, 120) }}</p>
        <a href="{{ url($post->slug) }}" class=" text-primary mt-auto align-self-baseline">Xem Thêm</a>
      </div>
    </div>
  </div>
</div>