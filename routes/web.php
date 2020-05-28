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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/editprofile','ProfileController@editprofile');
Route::post('/updateprofile','ProfileController@updateprofile');

Route::get('/createpost', 'PostsController@createpost');
Route::post('/store', 'PostsController@storepost');
Route::get('/editpost/{id}', 'PostsController@editpost');
Route::post('/update/{id}', 'PostsController@updatepost');



// RESTFUL APIs
Route::get('/api/logged-in-user', 'ApiController@logged_in_user');
Route::get('/api/posts', 'ApiController@posts');
Route::get('/api/friends', 'ApiController@friends');
Route::get('/api/friend-requests', 'ApiController@get_friend_requests');
Route::get('/api/advertisements', 'ApiController@advertisements');
Route::get('/api/interested/{id}', 'ApiController@interested');
Route::delete('/api/friends', 'ApiController@cancel_friendship');
Route::post('/api/posts','ApiController@like_post');
Route::put('/api/posts/{id}','ApiController@unlike_post');
Route::get('/api/found-users/',function(){return [];});
Route::get('/api/found-users/{keyword}','ApiController@found_users');
Route::delete('/api/posts/{id}','ApiController@remove_post');
Route::put('/api/friend-requests','ApiController@change_friend_requests');
Route::put('/api/request','ApiController@make_requests');