@mock('cat_lists')
@if (!empty($data))
    {{-- {{ debug($data) }} --}}
@endif
<div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-4">
    @foreach ($data as $item)
    <x-dev-comp::category.cat-post :data="$item"/>
    @endforeach
</div>
<div class="py-1"></div>
<x-dev-comp::pagination />
{{-- @endif --}}

