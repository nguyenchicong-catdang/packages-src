<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

Route::prefix('fe')->group(function () {
    Route::get('', function () {
        // Matches The "/admin/users" URL
        return view('dev-view::index');
    });
    Route::get('test', function () {
        // Matches The "/admin/users" URL
        return view('dev-view::test');
    });

    Route::get('category/{slug}', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'show']);

    // {{post/slug}}
    Route::get('post/{slug}', function() {
        return view('dev-view::post');
    })->name('post');
    // esi

    Route::prefix('esi')->group(function() {
        Route::get('', function() {
            return Blade::render('<x-dev-esi::index />');
        });
        // /fe/esi/esi-list-cat-posts
        Route::get('esi-list-cat-posts', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'esi']);
    });
});