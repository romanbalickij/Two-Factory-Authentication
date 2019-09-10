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

Route::get('/{id}', 'MainController@index');

Auth::routes();
Route::get('/parser', 'TestController@index');
Route::post('/verifyOTP', 'VerifyOTPController@verify');
Route::get('/verifyOTP', 'VerifyOTPController@showVerifyPage')->name('OTP.page');
Route::post('/recent_otp', 'ResendOTPController@resend');
Route::group(['middleware' => 'TwoFa'], function (){


});


//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@test')->name('test');
Route::post('/file-upload','HomeController@upload')->name('file-upload');



