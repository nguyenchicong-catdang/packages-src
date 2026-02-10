<x-wp-comp::layout>
    <x-slot name="title">
        {{ $post->title }}
    </x-slot>
    {{debug($data)}}
    {{debug($post)}}
        {{debug($post->featured_src)}}
                {{debug($post->featured_alt)}}




</x-wp-comp::layout>
