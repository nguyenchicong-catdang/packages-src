@props(['post'])
<div class="post-header-wrapper container mb-4">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1 class="post-title">{{$post->title}}</h1>
            <p class="post-excerpt text-muted">{{$post->excerpt}}</p>
        </div>
        <div class="col-lg-5">
            <div class="featured-img-frame">
                <img src="{{$post->featured_image_src}}" alt="{{$post->featured_image_alt}}" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div>
</div>