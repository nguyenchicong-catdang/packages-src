@props(['data' => []])
{{-- {{debug($data)}} --}}
@if($data)
<div class="row">
    <div class="col-6">
        <h1>{{$data['name']}}</h1>
        <div>{{$data['description']}}</div>
    </div>
    <div class="col-6 mb-3">
        <img class="img-fluid" src="{{url($data['featured_image_src'])}}" alt="{{$data['featured_image_alt']}}">
    </div>
</div>
@else
<div>Danh mục sản phẩm đang cập nhật!</div>
@endif
