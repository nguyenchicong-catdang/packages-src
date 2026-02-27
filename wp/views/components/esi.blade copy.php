@props(['src'])

<div {{ $attributes->merge(['class' => 'esi-container']) }}>
    @env('local')
        {{-- Môi trường DEV: Giả lập get_content --}}
        {{-- @php
            try {
                // Sử dụng url($src) để lấy đầy đủ domain local
                echo file_get_contents(url($src));
            } catch (\Exception $e) {
                // Log lỗi ra file để bạn dễ debug ở local thay vì im lặng hoàn toàn
                \Illuminate\Support\Facades\Log::error("ESI Local Error: " . $e->getMessage());
            }
        @endphp --}}
        {{-- @php
            try {
                // Sử dụng Http Client của Laravel
                $response = \Illuminate\Support\Facades\Http::timeout(5)->get(url($src));
                if ($response->successful()) {
                    echo $response->body();
                } else {
                    echo '';
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('ESI Local Error: ' . $e->getMessage());
            }
        @endphp --}}

        {{-- Cách đơn giản hơn: Sử dụng Blade include để giả lập ESI --}}
        @include($src)
    @else
        {{-- Môi trường PROD: In ra thẻ ESI thuần túy --}}
        <esi:include src="{{ url($src) }}" />
    @endenv
</div>
