@mock('sidebar')

<div class="list-group border-0 mt-2 fw-medium">
    @if (!empty($data))
        {{-- {{ debug($data) }} --}}
        @foreach ($data as $item)
            <a href="{{$item['slug']}}" class="text-uppercase border-0 list-group-item list-group-item-action list-group-item-light">{{mb_strtoupper($item['label'], 'UTF-8')}}</a>
        @endforeach
    @endif
</div>
