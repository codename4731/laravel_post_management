<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Check if a user is logged in
    if (Auth::check()) {
        // Check if the logged-in user is an admin
        if (Auth::user()->isAdmin()) {
            // Redirect admin users to admin posts index
            return redirect()->route('admin.posts.index');
        } else {
            // Redirect regular users to posts index
            return redirect()->route('posts.index');
        }
    } else {
        // If no user logged in, redirect to login
        return redirect()->route('login');
    }
});

Auth::routes();

// Routes for users
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
});

// Routes for admins
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/posts', [AdminController::class, 'index'])->name('admin.posts.index');
    Route::get('/admin/posts/create', [AdminController::class, 'create'])->name('admin.posts.create');
    Route::post('/admin/posts', [AdminController::class, 'store'])->name('admin.posts.store');
    Route::get('/admin/posts/{post}/edit', [AdminController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/admin/posts/{post}', [AdminController::class, 'update'])->name('admin.posts.update');
    Route::delete('/admin/posts/{post}', [AdminController::class, 'destroy'])->name('admin.posts.destroy');
    Route::get('/admin/posts/{post}', [AdminController::class, 'show'])->name('admin.posts.show');
});
