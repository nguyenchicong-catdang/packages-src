@props(['data' => []])
{{-- {{debug($data)}} --}}
@if ($data)
@foreach ($data as $item)
<x-wp-comp::categories.category-post :data="$item"/>
@endforeach
@else
<div>Sản phẩm đang cập nhật</div>
@endif