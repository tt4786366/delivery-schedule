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





// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('orderdrafts', 'OrderDraftsController');
    Route::resource('orders', 'OrdersController', ['except' => ['destroy', 'show']]);
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);    
    Route::resource('stores', 'StoresController');    
    Route::resource('products', 'ProductsController');    
Route::get('/', function () {
        return view('welcome');
});


    
//    Route::group(['prefix' => 'users/{id}'], function () {
//        Route::post('follow', 'UserFollowController@store')->name('user.follow');
//       Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
//        Route::get('followings', 'UsersController@followings')->name('users.followings');
//        Route::get('followers', 'UsersController@followers')->name('users.followers');
//       Route::get('favorites', 'UsersController@favorites')->name('users.favorites');

//    });    
    
    // 追加
//    Route::group(['prefix' => 'microposts/{id}'], function () {
//        Route::post('favorite', 'FavoriteController@store')->name('favorites.favorite');
 //       Route::delete('unfavorite', 'FavoriteController@destroy')->name('favorites.unfavorite');
//    });    
    
//    Route::resource('orders', 'OrdersController', ['except' => ['destroy', 'show']]);
    
//    Route::resource('orderdrafts', 'OrderdraftsController', ['only' => ['store', 'destroy']]);
});  







// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

