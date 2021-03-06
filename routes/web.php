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

Route::any('/', 'PreregController@index')->middleware('auth');
Route::post('save', 'PreregController@save');
Route::any('cancel', 'PreregController@cancel');
Route::any('finished', 'PreregController@finished');
Route::any('eticket/{code}', 'PreregController@eticket');
Route::post('get_municipality', 'PreregController@get_municipality');
Route::post('get_provinces', 'PreregController@get_provinces');
//Route::any('test/{id}', 'PreregController@test');
//Route::any('guests', 'PreregController@guests');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registrantslist', 'PreregController@reglist')->name('registrants')->middleware('auth');
Route::post('/updateregistrant/{id}', 'PreregController@updatereglist')->name('updateregistrant')->middleware('auth');
Route::get('/sendconfirmation/{id}', 'PreregController@sendconfirmation')->name('sendconfirmation')->middleware('auth');
