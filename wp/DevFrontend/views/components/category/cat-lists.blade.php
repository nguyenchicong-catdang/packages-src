<div class="row row-cols-2 g-1">
    @for ($i = 0; $i < 12; $i++)
        <x-dev-comp::category.cat-post />
    @endfor
</div>
<div class="py-1"></div>
<x-dev-comp::pagination />
