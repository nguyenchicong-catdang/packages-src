{{-- {{debug($data)}} --}}
<div class="list-group shadow-sm">
    @foreach($data as $parent)
        {{-- Mục Cha --}}
        <a href="{{ $parent['slug'] }}" class="list-group-item list-group-item-action fw-bold">
            {{ $parent['label'] }}
        </a>

        {{-- Kiểm tra nếu có mục Con --}}
        @if(!empty($parent['children']))
            <div class="list-group list-group-flush ps-3">
                @foreach($parent['children'] as $child)
                    <a href="{{ $child['slug'] }}" class="list-group-item list-group-item-action small text-muted">
                    {{ $child['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
    @endforeach
</div>