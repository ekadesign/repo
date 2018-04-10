<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
        Route::get('proxy', function(Request $request){

            $client = new Client();

            $url = 'https://api.coinmarketcap.com/v1/global';

            $result = null;

            $queryString = $url;

            if($request->getQueryString()){
                $queryString .= '?' . $request->getQueryString();
            }

            $response = $client->get($queryString);

            if($response){
            $result = json_decode($response->getBody()->getContents());
            }

            return response()->json($result);
        });
        Route::get('feed', 'FeedController@index');
        Route::get('forum', 'ForumController@index');
        Route::get('forum/category/{name}', 'ForumController@getTopicsByCategoryName');
        Route::get('forum/category/cryptos/{name}', 'ForumController@getTopicByTopicName');
        Route::get('forum/categories', 'ForumController@getAllCategories');
        Route::get('forum/topics', 'ForumController@getAllTopics');
        Route::get('forum/topics/hot', 'ForumController@getHotTopics');
        Route::get('forum/topic/{id}', 'ForumController@getMessagesByTopicId');
        Route::post('forum/reply', 'ForumController@reply');
    });
});