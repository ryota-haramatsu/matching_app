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

// socialite
// socialite 各プロバイダにリダイレクトするルート
Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->name('socialOAuth');
// socialite 各プロバイダからのコールバックを受けるルート
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('oauthCallback');

Route::get('/{any}', function() {
    return view('app');
})->where('any', '.*');
