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
Route::post('/home', 'TweetController@newTweet');

Route::get('/api/channel/{channel}', 'TweetController@getChannel');

Route::get('/api/tweets', 'TweetController@getTweets');

Route::get('/debug', function () {
    echo date('Y-m-d H:m:s');
});