<div class="card mb-3 overflow-hidden" style="max-width: 540px;">
  <div class="row g-0 align-items-center">
    <div class="col-4"> {{-- Sử dụng col-4 thay vì col-md-4 để giữ tỉ lệ trên cả mobile --}}
      <div class="ratio ratio-1x1"> {{-- Class của Bootstrap 5 tạo khung 1:1 --}}
         <x-wp-comp::categories.cat-post-thumbnail 
            :thumbnail="$post->thumbnail" 
            class="img-fluid object-fit-cover w-100 h-100" 
         />
      </div>
    </div>
    <div class="col-8">
      <div class="card-body">
        <h5 class="card-title text-truncate">{{ $post->title }}</h5>
        <p class="card-text d-none d-sm-block">{{ Str::limit($post->excerpt, 80) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-body-secondary">Updated 3 mins ago</small>
            <a href="/{{ $post->slug }}" class="btn btn-primary btn-sm">Read</a>
        </div>
      </div>
    </div>
  </div>
</div>