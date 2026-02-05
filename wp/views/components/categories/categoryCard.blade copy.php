@props(['post'])

{{-- <div class="card mb-3" style="max-width: 540px;"> --}}
    <div class="card mb-3">

  <div class="row g-0">
    <div class="col-md-4">
    <div class="position-relative w-100" style="aspect-ratio: 1 / 1; background-color: #f8f9fa;">
        @if($post->thumbnail && $post->thumbnail->attachment)
            <img src="{{ $post->thumbnail->attachment->url }}" 
                 class="position-absolute top-0 start-0 w-100 h-100" 
                 style="object-fit: cover;" 
                 alt="{{ $post->thumbnail->attachment->alt }}">
        @else
            {{-- Placeholder khi không có ảnh --}}
            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                No Image
            </div>
        @endif
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