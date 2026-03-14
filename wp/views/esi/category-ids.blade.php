{{-- {{ debug($data) }} --}}
{{-- {{debug($pagination)}} --}}
@if ($data)
    @foreach ($data as $item)
        <x-wp-comp::categories.category-post :slug="$item" />
    @endforeach
    @if ($pagination)
    <x-wp-comp::pagination :data="$pagination" />
    @endif
@else
    <p>Sản phẩm đang cập nhật</p>
@endif
