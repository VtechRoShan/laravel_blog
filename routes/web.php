<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\frontendController;
use App\Models\Tag;
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
Route::get('/blog/{slug}', [frontendController::class, 'view_post'])->name('view_post');
Route::get('/tag/{slug}', [frontendController::class, 'view_post_by_tag'])->name('view_post_by_tag');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::resource('/blog', BlogController::class)->shallow();
    Route::resource('/category', CategoryController::class)->shallow();
    Route::resource('/tag', TagController::class)->shallow();
    Route::resource('/navigation', NavigationController::class)->shallow();
});