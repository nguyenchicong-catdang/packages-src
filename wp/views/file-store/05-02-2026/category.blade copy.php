{{debug($cat)}}
{{debug($posts)}}
{{-- {{debug($paginate)}} --}}
<x-wp-comp::layout>
    <x-slot name="title">
        {{$cat->name}}
    </x-slot>
    <h1>{{$cat->name}}</h1>
    <div>{{$cat->description}}</div>
    
    @if ($posts->isNotEmpty()) 
        @foreach($posts as $post)
            <article class="post-item">
                @if($post->thumbnail && $post->thumbnail->attachment)
                    <img src="{{ $post->thumbnail->attachment->url }}" alt="{{ $post->thumbnail->attachment->alt }}">
                @endif
                
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->excerpt }}</p>
                <a href="{{ url($post->slug) }}">Xem thêm</a>
            </article>
        @endforeach
        <div class="pagination-wrapper">
            {{-- {{ $posts->links() }} --}}
            <nav class="custom-pagination">
    <ul class="flex list-none gap-2">
        {{-- Nút Quay lại --}}
        @if (!$posts->onFirstPage())
            <li>
                <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-2 border">« Trước</a>
            </li>
        @endif

        {{-- Các con số trang --}}
        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" 
                   class="px-3 py-2 border {{ $page == $posts->currentPage() ? 'bg-blue-500 text-white' : '' }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Nút Tiếp theo --}}
        @if ($posts->hasMorePages())
            <li>
                <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-2 border">Sau »</a>
            </li>
        @endif
    </ul>
</nav>
        </div>
    @else
        <div>Chu co post</div>
    @endif

</x-wp-comp::layout>