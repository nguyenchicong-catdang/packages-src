<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return view('wp-view::test');
});

Route::get('/', function(){
    return view('wp-view::index');
});

// dev
Route::prefix('dev')->group(function(){
    // controller
    Route::controller(\Vendorpath\Wp\Utils\DevController::class)->group(function(){
        Route::get('', 'dev');
        // category
        Route::get('category', 'category');
        // category-data
        Route::get('category-data', 'catData');
    });
    
});

// esi
Route::prefix('esi')->group(function() {
    // sidebar
    Route::get('/sidebar', function() {
        return \Vendorpath\Wp\Esi\Sidebars\SidebarEsi::esi();
    });
    // navbar
    Route::get('/navbar', function() {
        return \Vendorpath\Wp\Esi\Navbars\NavbarEsi::esi();
    });
});
