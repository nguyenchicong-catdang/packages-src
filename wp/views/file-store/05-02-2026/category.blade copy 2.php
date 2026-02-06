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
            {{ $posts->links('wp-view::components.pagination') }}
        </div>
    @else
        <div>Chu co post</div>
    @endif

</x-wp-comp::layout>