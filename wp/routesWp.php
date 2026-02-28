<?php

use Illuminate\Support\Facades\Blade;
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
        $html = Blade::render('<x-wp-compName::sidebar-component />');
        return response($html)
            ->header('Cache-Control', 'public, s-maxage=600') // Quan trọng cho ESI
            ->header('X-Component', 'Sidebar')               // Để dễ soi/debug
            ->header('Content-Type', 'text/html');
    });
});