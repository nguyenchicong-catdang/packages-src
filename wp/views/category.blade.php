
<x-wp-comp::layout>
    {{-- {{debug($cat)}} --}}
    {{-- {{debug($cat->dev->dev['posts']->toArray())}} --}}
    {{-- {{debug($cat->dev->category->term)}} --}}
    {{-- {{debug($cat->dev->category->meta->rank_math_title)}} --}}
    {{-- {{debug($cat->cat_data)}} --}}
    {{-- {{debug($cat->cat_data_item)}} --}}
    {{-- {{debug($cat->cat_card)}} --}}
    {{-- {{debug($cat->dev->dev["posts"]->toArray())}} --}}
    {{-- {{debug($cat->posts)}} --}}

    <x-wp-comp::categories.cat-card :data="data_get($cat, 'cat_card', [])"/>
    {{-- posts --}}
    @if (!empty($cat->posts))
        @foreach ($cat->posts as $post)
            <x-wp-comp::categories.cat-post :data="$post"/>
        @endforeach
        {{-- pagination --}}
        <x-wp-comp::categories.cat-pagination :data="data_get($cat, 'pagination', [])" />
    @else
        <p>No posts found.</p>
    @endif
</x-wp-comp::layout>