<?php

use Illuminate\Support\Facades\Route;

Route::prefix('fe')->group(function () {
    Route::get('', function () {
        // Matches The "/admin/users" URL
        return view('dev-view::index');
    });

    Route::get('category/{slug}', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'show']);
});