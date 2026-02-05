@props(['post'])

<div class="card mb-3 shadow-sm border-0 overflow-hidden">
    <div class="row g-0">
        {{-- Cột ảnh 1:1 --}}
        <div class="col-md-3">
            <div class="ratio ratio-1x1 bg-light">
                <img src="{{ $post->thumbnail->attachment->url }}" class="object-fit-cover" alt="{{ $post->title }}">
            </div>
        </div>

        {{-- Cột nội dung --}}
        <div class="col-md-9">
            <div class="card-body d-flex flex-column h-100 p-3">
                <h5 class="card-title fw-bold text-dark mb-2">{{ $post->title }}</h5>

                <p class="card-text text-secondary small mb-3">
                    {{ Str::limit($post->excerpt, 120) }}
                </p>

                {{-- Nút Xem Thêm nằm sát đáy --}}
                <div class="mt-auto">
                    <a href="{{ url($post->slug) }}" class="link-primary text-decoration-none fw-semibold">
                        Xem Thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
