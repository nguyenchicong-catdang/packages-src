<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

Route::prefix('fe')->name('fe.')->group(function () {
    Route::get('', function () {
        // Matches The "/admin/users" URL
        return view('dev-view::index');
    })->name('index');;

    Route::get('category/{slug}', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'show'])->name('cat');

    // {{post/slug}}
    Route::get('post/{slug}', function() {
        return 'abc';
    })->name('post');
    // esi

    Route::prefix('esi')->name('esi.')->group(function() {
        Route::get('', function() {
            return Blade::render('<x-dev-esi::index />');
        })->name('index');
        // /fe/esi/esi-list-cat-posts
        Route::get('esi-list-cat-posts', [\Vendorpath\Wp\DevFrontend\Categories\DevCategoryController::class, 'esi'])->name('list-cat-posts');
    });
});