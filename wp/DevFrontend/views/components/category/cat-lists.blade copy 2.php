@mock('cat_lists')
@if (!empty($data))
    {{ debug($data) }}
<div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-4">
    @foreach ($data['slugs'] as $slug)
    {{-- <x-dev-comp::category.cat-post :data="$item"/> --}}
    {{-- <div>{{$slug}}</div> --}}
    @endforeach
</div>
<div class="py-1"></div>
<x-dev-comp::pagination :data="$data['pagination']"/>
@endif

