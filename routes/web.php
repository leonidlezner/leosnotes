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

if (App::environment('production')) {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

# Let the logout be accessible via a GET request
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'],
              'namespace' => 'Admin', 'as' => 'admin.'], function() {

    Route::group(['as' => 'dashboard.'], function () {
        Route::get('/', 'DashboardController@index')->name('index');
    });
    
    Route::resource('users', 'UsersController');
});