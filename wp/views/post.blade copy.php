<x-wp-comp::layout>
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>
    {{-- Đẩy dữ liệu vào slot có tên là yoastSchema --}}
    {{-- <x-slot name="schema">
        <script type="application/ld+json">
        </script>
    </x-slot> --}}
    {{-- <script type="application/ld+json">
    {!!$yoastSchema!!}
    </script> --}}
    {{-- {{debug($yoastSchema)}} --}}
    {{-- {{ debug($post) }} --}}
    {{-- {{debug($schema)}} --}}
    {{-- <h1>{{$post->title}}</h1>
    <p>{{$post->excerpt}}</p>
    <img src="{{$post->featured_image_src}}" alt="{{$post->featured_image_alt}}"> --}}

    {{-- <x-wp-comp::posts.post-header-wrapper :post="$post" /> --}}

    {{-- {!! $post->content !!} --}}

    
</x-wp-comp::layout>
