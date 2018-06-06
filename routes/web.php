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

Route::get('/videos/{id}', 'VideoController@show');

Route::post('/channels', 'ChannelController@index');

Route::get('/subscriptions/no-folder', 'SubscriptionController@noFolder');
Route::post('/subscriptions', 'SubscriptionController@store');
Route::get('/subscriptions/{subscription_id}/{folder_id}/edit', 'SubscriptionController@edit');
Route::get('/subscriptions/{subscription_id}/edit', 'SubscriptionController@editNoFolder');
Route::delete('subscriptions/{subscription_id}', 'SubscriptionController@destroy');

Route::post('/folders', 'FolderController@store');
Route::get('/folders', 'FolderController@index');
Route::delete('/folders/{folder_id}', 'FolderController@destroy');

Route::post('/playlists/{playlist_id}/{video_id}', 'PlaylistController@store');
