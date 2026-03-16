@mock('sidebar')

<div class="list-group">
    @if (!empty($data))
        {{-- {{ debug($data) }} --}}
        @foreach ($data as $item)
            <a href="{{$item['slug']}}" class="list-group-item list-group-item-action">{{$item['label']}}</a>
        @endforeach
    @endif
</div>
