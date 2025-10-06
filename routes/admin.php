<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\IncidentController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;

// Admin Login
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

// Admin Logout
Route::post('/admin/logout', function () {
    auth()->logout();
    return redirect()->route('admin.login');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    
    // Incidents Management
    Route::resource('incidents', IncidentController::class);
    Route::post('incidents/{incident}/toggle-verification', [IncidentController::class, 'toggleVerification'])->name('incidents.toggle-verification');
    Route::post('incidents/{incident}/update-status', [IncidentController::class, 'updateStatus'])->name('incidents.update-status');
    
    // Comments Management
    Route::resource('comments', CommentController::class);
    Route::post('comments/{comment}/toggle-status', [CommentController::class, 'toggleStatus'])->name('comments.toggle-status');
    
    // Verifications Management
    Route::resource('verifications', VerificationController::class);
    
    // Media Management
    Route::resource('media', MediaController::class);
    Route::delete('media/{media}/force-delete', [MediaController::class, 'forceDelete'])->name('media.force-delete');
    
    // Alerts Management
    Route::resource('alerts', AlertController::class);
    
    // Roles & Permissions Management
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');
});
