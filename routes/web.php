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

Route::get('/test', 'DataController@test')->name('test');

Route::get('/', 'DataController@showSearch')->name('home');

Route::get('admin', 'DataController@showAdminPanel')->name('admin');

Route::post('uploadFile', 'DataController@uploadFile')->name('uploadFile');

Route::get('download/{fileName}', 'DataController@download')->name('download');

Route::post('getData', 'DataController@getData')->name('getData');

Route::post('export', 'DataController@export')->name('export');

// Rutas de autenticación

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name("register");

// -> Rutas de autenticación