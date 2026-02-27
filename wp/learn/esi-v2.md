# learn

@props(['src', 'action' => null])

<div {{ $attributes->merge(['class' => 'esi-container']) }}>
    @env('local')
        @php
            try {
                if ($action) {
                    // $action lúc này sẽ là [\App\Http\Controllers\EsiController::class, 'popularPosts']
                    // App::call sẽ tự động inject các tham số cần thiết vào method
                    $response = App::call($action);

                    // Xử lý kết quả trả về (Response object hoặc View object)
                    if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
                        echo $response->getContent();
                    } elseif ($response instanceof \Illuminate\Contracts\View\View) {
                        echo $response->render();
                    } else {
                        echo $response;
                    }
                }
            } catch (\Exception $e) {
                echo "";
            }
        @endphp
    @else
        {{-- Môi trường PROD: OpenLiteSpeed gọi qua URL --}}
        <esi:include src="{{ url($src) }}" />
    @endenv
</div>

<x-esi 
    src="/esi/popular-posts" 
    :action="[\App\Http\Controllers\EsiController::class, 'popularPosts']" 
/>

public function popularPosts() {
    return response()
        ->view('esi.popular-posts')
        ->header('X-LiteSpeed-Cache-Control', 'public,max-age=3600'); // Cache mảnh này 1 giờ
}

# Middleware cho Trang Chính:

Như đã thảo luận ở trên, OpenLiteSpeed chỉ quét thẻ <esi:include> nếu trang chính có header X-LiteSpeed-ESI: 1. Đừng quên thêm nó vào Middleware hoặc trực tiếp tại Controller của trang chính.

if (!app()->environment('local') && !request()->hasHeader('X-LSCACHE')) {
    abort(403, 'Chỉ server mới được phép truy cập trực tiếp.');
}