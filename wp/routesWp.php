<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return view('wp-view::test');
});

Route::get('/', function(){
    return view('wp-view::index');
});

// esi
Route::prefix('esi')->group(function() {
    Route::get('/sidebar', function() {
        return \Vendorpath\Wp\Components\Sidebars\SidebarEsi::getHtml();
    });
});
