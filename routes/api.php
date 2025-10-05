<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentCommentController;
use App\Http\Controllers\Api\IncidentVerificationController;
use App\Http\Controllers\Api\IncidentMediaController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\UserController;

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
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Incident routes (public read access)
Route::get('/incidents', [IncidentController::class, 'index']);
Route::get('/incidents/{id}', [IncidentController::class, 'show']);
Route::get('/incidents/{id}/comments', [IncidentCommentController::class, 'index']);
Route::get('/incidents/{id}/nearby', [IncidentController::class, 'nearby']);
Route::get('/incidents/map/data', [IncidentController::class, 'mapData']);

// Analytics (public read access)
Route::get('/analytics/stats', [AnalyticsController::class, 'stats']);
Route::get('/analytics/trends', [AnalyticsController::class, 'trends']);
Route::get('/analytics/detailed', [AnalyticsController::class, 'detailed']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'changePassword']);
    Route::get('/user/stats', [UserController::class, 'stats']);
    Route::get('/user/incidents', [UserController::class, 'incidents']);
    Route::get('/user/comments', [UserController::class, 'userComments']);
    Route::get('/user/verifications', [UserController::class, 'userVerifications']);
    
    // Incident management
    Route::post('/incidents', [IncidentController::class, 'store']);
    Route::put('/incidents/{id}', [IncidentController::class, 'update']);
    Route::delete('/incidents/{id}', [IncidentController::class, 'destroy']);
    
    // Comments
    Route::post('/incidents/{id}/comments', [IncidentCommentController::class, 'store']);
    Route::put('/comments/{id}', [IncidentCommentController::class, 'update']);
    Route::delete('/comments/{id}', [IncidentCommentController::class, 'destroy']);
    Route::post('/comments/{id}/upvote', [IncidentCommentController::class, 'upvote']);
    Route::post('/comments/{id}/downvote', [IncidentCommentController::class, 'downvote']);
    
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
