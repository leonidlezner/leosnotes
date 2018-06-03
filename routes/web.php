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


# Restricted Admin URLs
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin',
                'namespace' => 'Admin', 'as' => 'admin.'], function() {
                    
    Route::get('/', 'DashboardController@index')->name('dashboard');
    
    Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
        Route::post('/{user}/restore', 'UsersController@restore')->name('restore');
        Route::delete('/{user}/forcedelete', 'UsersController@forceDelete')->name('forcedelete');
        Route::get('/trash', 'UsersController@trash')->name('trash');
    });

    Route::resource('users', 'UsersController');
});

# Admin Login URLs
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function() {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout.submit');
});