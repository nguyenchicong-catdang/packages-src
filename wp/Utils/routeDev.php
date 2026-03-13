<?php

use Illuminate\Support\Facades\Route;

// dev
Route::prefix('dev')->group(function () {
    // controller
    Route::controller(\Vendorpath\Wp\Utils\DevController::class)->group(function () {
        Route::get('', 'dev');
        // category
        // Route::get('category', 'category');
        // category-data
        Route::get('category-data', 'dataCat');
        // category-ids
        Route::get('category-ids', 'dataIds');
    });
});