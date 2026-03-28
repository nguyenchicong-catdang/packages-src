@mock('sidebar')
@if (!isset($data))
    {{ debug('Null: Data') }}
@else
    <div class="list-group border-0 mt-2 fw-medium">
        @foreach ($data as $item)
            <a href="{{ $item['slug'] ?? 'null: slug' }}"
                class="text-uppercase border-0 list-group-item list-group-item-action list-group-item-light">{{ mb_strtoupper($item['label'] ?? 'null: label', 'UTF-8') }}</a>
        @endforeach
    </div>

@endif