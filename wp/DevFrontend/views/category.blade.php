{{-- {{debug($data)}} --}}
<x-dev-comp::layout>
    {{-- <x-dev-comp::breadcrumb /> --}}
    <x-dev-comp::category.cat-card :data="$data['cat_card']"/>
    <h2>Sản phẩm nổi bật</h2>
    <x-dev-esi::esi-list-cat-posts :data="$data['cat_lists']" />
</x-dev-comp::layout>