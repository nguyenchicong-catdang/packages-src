
<x-wp-comp::layout>
    {{debug($data)}}
    <x-wp-comp::categories.cat-card :cat="$data->catCard" />
    @if ($data->catPosts->isEmpty())
        <p>No posts found in this category.</p>
    @else
        @foreach ($data->catPosts as $post)
            <x-wp-comp::categories.cat-post :post="$post" />
        @endforeach
        <x-wp-comp::categories.cat-pagination :data="$data->paginator" />
    @endif
</x-wp-comp::layout>