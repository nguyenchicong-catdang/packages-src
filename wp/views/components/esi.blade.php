@props(['view', 'url'])

<div {{ $attributes->merge(['class' => 'esi-container']) }}>
    @env('locals')
        {{-- Ở local, ta render trực tiếp file view --}}
        {{-- @include($view) --}}
        @php
        // https://laravel.com/docs/12.x/container#method-invocation-and-injection
        echo app()->call(function() {
            return 'abcdef';
        });
        @endphp
    @else
        {{-- Ở prod, ta bắt OpenLiteSpeed gọi vào URL của route --}}
        <esi:include src="{{ url($url) }}" />
    @endenv
</div>

