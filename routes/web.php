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

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/{id}', 'DashboardController@show');

Route::get('/youtube', 'YouTubeController@index');

Route::post('/subscriptions', 'SubscriptionController@store');
Route::get('/subscriptions/{subscription_id}/{folder_id}/edit', 'SubscriptionController@edit');

Route::post('/folders', 'FolderController@store');

Route::get('/folders', 'FolderController@index');

Route::post('/playlists/{playlist_id}/{video_id}', 'PlaylistController@store');
