<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return view('wp-view::test');
});

Route::get('/', function(){
    return view('wp-view::index');
});

// Route esi
Route::prefix('esi')->group(function() {
    Route::get('/sidebar', function() {
        return 'sidebar';
        //return Blade::render('<x-esi::sidebar />');
        /**
         * // Route esi
Route::get('/sidebar', function() {
    // 1. Lấy nội dung HTML từ Component
    $html = Blade::render('<x-wp-view::sidebar />');

    // 2. Tạo Response và gắn Header tại đây
    return response($html)
        ->header('Cache-Control', 'public, s-maxage=600') // Quan trọng cho ESI
        ->header('X-Component', 'Sidebar')               // Để dễ soi/debug
        ->header('Content-Type', 'text/html');
});
         */
    });
});