{{debug($data_cat)}}
{{-- {{debug($data_ids)}} --}}
<x-wp-comp::layout :data="$data_cat">
    <x-wp-comp::categories.category-card :data="$data_cat"/>
    <x-wp-comp::categories.category-ids :slug="$data_cat['slug']"/>
</x-wp-comp::layout>