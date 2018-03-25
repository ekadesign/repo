<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api\V1')->group(function (){
    Route::prefix('v1')->group(function (){
        Route::get('feed', 'FeedController@index');
        Route::get('forum', 'ForumController@index');
        Route::get('forum/category/{id}', 'ForumController@getTopicsByCategoryId');
        Route::get('forum/topic/{id}', 'ForumController@getMessagesByTopicId');
        Route::post('forum/reply', 'ForumController@reply');
    });
});