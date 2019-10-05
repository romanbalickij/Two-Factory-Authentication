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

Route::get('/','HomeController@exportForm');
Route::get('/export', 'HomeController@export')->name('export');
Route::get('/filter', 'HomeController@filter')->name('filter');

Route::get('/rus', 'HomeController@rus')->name('rus');
Auth::routes();






