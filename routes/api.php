<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentCommentController;
use App\Http\Controllers\Api\IncidentVerificationController;
use App\Http\Controllers\Api\IncidentMediaController;
use App\Http\Controllers\Api\AnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Incident routes (public read access)
Route::get('/incidents', [IncidentController::class, 'index']);
Route::get('/incidents/{id}', [IncidentController::class, 'show']);

// Analytics (public read access)
Route::get('/analytics/stats', [AnalyticsController::class, 'stats']);
Route::get('/analytics/trends', [AnalyticsController::class, 'trends']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    
    // Incident management
    Route::post('/incidents', [IncidentController::class, 'store']);
    Route::put('/incidents/{id}', [IncidentController::class, 'update']);
    Route::delete('/incidents/{id}', [IncidentController::class, 'destroy']);
    
    // Comments
    Route::post('/incidents/{id}/comments', [IncidentCommentController::class, 'store']);
    Route::put('/comments/{id}', [IncidentCommentController::class, 'update']);
    Route::delete('/comments/{id}', [IncidentCommentController::class, 'destroy']);
    
    // Verifications
    Route::post('/incidents/{id}/verifications', [IncidentVerificationController::class, 'store']);
    Route::put('/verifications/{id}', [IncidentVerificationController::class, 'update']);
    Route::delete('/verifications/{id}', [IncidentVerificationController::class, 'destroy']);
    
    // Media
    Route::post('/incidents/{id}/media', [IncidentMediaController::class, 'store']);
    Route::delete('/media/{id}', [IncidentMediaController::class, 'destroy']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/incidents', [IncidentController::class, 'adminIndex']);
    Route::put('/admin/incidents/{id}/status', [IncidentController::class, 'updateStatus']);
    Route::get('/admin/analytics', [AnalyticsController::class, 'adminAnalytics']);
});
