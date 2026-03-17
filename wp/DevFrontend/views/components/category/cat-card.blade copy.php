@mock('cat_card')
@if (!empty($data))
    {{ debug($data) }}
@endif
<div class="row">
    <div class="col-6">
        <h1>{{$data['name']}}</h1>
        <div>{{$data['description']}}</div>
    </div>
    <div class="col-6">
        <img class="img-fluid" src="{{$data['featured_src']}}" alt="{{$data['featured_alt']}}">
    </div>
</div>
