<div class="row row-cols-1 row-cols-lg-2 g-2 g-lg-4">
    @for ($i = 0; $i < 12; $i++)
        <x-dev-comp::category.cat-post />
    @endfor
</div>
<div class="py-1"></div>
<x-dev-comp::pagination />
