{{debug($cat)}}
{{debug($posts->items())}}
{{-- {{debug($paginate)}} --}}
<x-wp-comp::layout>
    <x-slot name="title">
        {{$cat->name}}
    </x-slot>
    <h1>{{$cat->name}}</h1>
    <div>{{$cat->description}}</div>

    {{-- categoryCard --}}
    @if ($posts->isNotEmpty()) 
        @foreach($posts as $post)
            <x-wp-comp::categories.categoryCard :post="$post"/>
        @endforeach
        <div class="pagination-wrapper">
            {{ $posts->links('wp-view::components.pagination') }}
        </div>
    @else
        <div>no post</div>
    @endif
</x-wp-comp::layout>