@props(['post'])
<div class="post-header-wrapper mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7 order-2 order-lg-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Thùng rác</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold mb-3">{{$post->title}}</h1>
            <p class="lead text-muted">{{$post->excerpt}}</p>
            <div class="post-meta text-secondary small">
                <span>By Admin</span> • <span>Feb 7, 2026</span>
            </div>
        </div>

        <div class="col-lg-5 order-1 order-lg-2">
            <div class="ratio ratio-1x1 shadow-sm">
                <img src="{{$post->featured_image_src}}" 
                     alt="{{$post->featured_image_alt}}" 
                     class="rounded-3 object-fit-cover">
            </div>
        </div>
    </div>
</div>
<hr class="my-4">