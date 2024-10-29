<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowerController;

Route::get('/', [PostController::class, 'welcome'])->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PostController::class, 'allPosts'])->name('dashboard');
    
    // Posts
    Route::get('/users/{user}/posts', [PostController::class, 'userPosts'])->name('users.posts');
    Route::resource('posts', PostController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // follower routes
    Route::post('/users/{user}/follow', [FollowerController::class, 'follow'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [FollowerController::class, 'unfollow'])->name('users.unfollow');
    Route::get('/following', [PostController::class, 'following'])->name('following');
});

require __DIR__.'/auth.php';
