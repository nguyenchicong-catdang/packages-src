{{-- {{debug($data)}} --}}
<h3>Sidebar</h3>
<div class="list-group">
    @if($data)
    @foreach ($data as $item)
        <a href="{{$item['slug']}}" class="list-group-item list-group-item-action">{{$item['label']}}</a>
    @endforeach
    @endif
</div>