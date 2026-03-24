<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

Route::prefix('fe')->group(function () {
    Route::get('', function () {
        // Matches The "/admin/users" URL
        return view('dev-view::index');
    });

    Route::get('category/{slug}', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'show']);

    // esi

    Route::prefix('esi')->group(function() {
        Route::get('', function() {
            return Blade::render('<x-dev-esi::esi />');
        });
        // /fe/esi/esi-list-cat-posts
        Route::get('esi-list-cat-posts', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'esi']);
    });
});