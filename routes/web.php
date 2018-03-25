<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/', function (){
        return view('pages.dashboard');
    })->name('dashboard');
    Route::prefix('forum')->group(function () {
        Route::resource('categories', 'Forum\CategoryController');
        Route::resource('topics', 'Forum\TopicController');
    });
    Route::resource('feed', 'FeedController');
});