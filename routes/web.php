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

Route::get('/', 'StartController@index')->name('start');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newcurr', 'NewcurrController@index')->name('newcurr');
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/newcurr/{id}', 'NewcurrController@add_curr');

Route::get('/admin/{id}', 'AdminController@del_curr');
Route::get('/mail/{id}', 'AdminController@del_curr_mail');

Route::get('/username/{inf}', 'UsersController@update_name');
Route::get('/email/{inf}', 'UsersController@update_email');
Route::get('/off_curr/{inf}', 'UsersController@off_curr');
Route::get('/on_curr/{inf}', 'UsersController@on_curr');
Route::get('/send/email/{inf}', 'AdminController@mail');

Route::get('/get_id', function() {
    return Auth::user()->id;
})->middleware('auth');