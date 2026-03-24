@mock('cat_post')
@if (!empty($data))
    {{-- {{ debug($data) }} --}}
<div class="col">
    <div class="card h-100 shadow-sm">
        <div class="card-header">
            <p class="h5 card-title text-center my-1"><a href="{{$data['slug']}}"
                    class="stretched-link text-decoration-none link-dark">{{ucfirst($data['title'])}}</a></p>
        </div>
        <div class="row g-0">
            <div class="col" style="max-width:250px;">
                <div class="ratio ratio-1x1">
                    <img src="{{$data['featured_src']}}" class="img-fluid" alt="{{$data['featured_alt']}}" loading="lazy">
                </div>
            </div>
            <div class="col">
                <div class="card-body">
                    <p class="card-text"
                        style="
                            display: -webkit-box;
                            -webkit-line-clamp: 6; /* Hiện đúng 4 dòng là dừng */
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            line-height: 1.5; /* Khoảng cách dòng ổn định */
                        ">{{$data['excerpt']}}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endif