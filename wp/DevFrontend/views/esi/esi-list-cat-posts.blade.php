@mock('esi_cat_slugs')
@env('local')
<x-dev-comp::category.cat-lists :data="$data"/>
@else
<div>b</div>
@endenv