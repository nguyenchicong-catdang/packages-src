<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return view('wp-view::test');
});

Route::get('/', function(){
    return view('wp-view::index');
});

Route::get('/{slug}', [\Vendorpath\Wp\Posts\PostController::class, 'show']);

Route::get('/category/{slug}', [\Vendorpath\Wp\Categories\CategoryController::class, 'show']);
