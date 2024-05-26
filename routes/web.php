<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\frontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [frontendController::class, 'index'])->name('/');
Route::get('/navs/{slug}', [frontendController::class, 'navbar'])->name('view_post_by_navigation');
Route::get('/{nav_name}/{cat_name}/blogs', [frontendController::class, 'nav_cat_blog'])->name('nav_cat_blog');
Route::get('/blog/{slug}', [frontendController::class, 'view_post'])->name('view_post');
Route::get('/tags/{slug}', [frontendController::class, 'view_post_by_tag'])->name('view_post_by_tag');
Route::get('/all-tags', [frontendController::class, 'all_tag'])->name('all_tag');
Route::get('/category/{slug}', [frontendController::class, 'view_post_by_category'])->name('view_post_by_category');


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('/blog', BlogController::class)->shallow();
    Route::resource('/category', CategoryController::class)->shallow();
    Route::resource('/tag', TagController::class)->shallow();
    Route::resource('/navigation', NavigationController::class)->shallow();
    Route::resource('/author', AuthorController::class)->shallow();
});


// Hello Test 
