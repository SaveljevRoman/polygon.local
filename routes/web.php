<?php

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
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', 'PostController')->names('blog.post');
});

$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    //Blog Categories
    $methods = ['index', 'create', 'store', 'edit', 'update',];
    Route::resource('categories', 'CategoryController')
        ->only($methods) //white list
        ->names('blog.admin.categories');

    //Blog Posts
    Route::resource('posts', 'PostController')
        ->except(['show']) //black list
        ->names('blog.admin.posts');
});


// маршрут для изучения коллекций
Route::prefix('digging_deeper')->group(function () {
    Route::get('collections', 'DiggingDeeperController@collections')
        ->name('digging_deeper.collections');

    Route::get('process-video', 'DiggingDeeperController@processVideo')
        ->name('digging_deeper.processVideo');

    Route::get('prepare-catalog', 'DiggingDeeperController@prepareCatalog')
        ->name('digging_deeper.prepareCatalog');

});

//Route::resource('rest', 'RestTestController')->names('home');

