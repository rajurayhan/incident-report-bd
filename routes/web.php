<?php

use Illuminate\Support\Facades\Route;

// Sitemap route
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap')->header('Content-Type', 'application/xml');
});

// Specific routes for better SEO and direct access
Route::get('/incident/{id}', function () {
    return view('welcome');
})->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

// Map route
Route::get('/map', function () {
    return view('welcome');
});

// Serve the Vue.js app for all other frontend routes
// This catch-all route should be last to avoid conflicts with API routes
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
