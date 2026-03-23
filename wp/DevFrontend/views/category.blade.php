{{debug($data)}}
<x-dev-comp::layout>
    {{-- <x-dev-comp::breadcrumb /> --}}
    <x-dev-comp::category.cat-card :data="$data['cat_card']"/>
    <x-dev-comp::category.cat-lists :data="$data['cat_lists']"/>
</x-dev-comp::layout>