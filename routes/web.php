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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('ajaxdata','AjaxdataController@index')->name('ajaxdata');
Route::get('ajaxdata/getdata','AjaxdataController@getdata')->name('ajaxdata.getdata');
Route::post('ajaxdata/insertdata','AjaxdataController@insertdata')->name('ajaxdata.insertdata');
Route::get('ajaxdata/fetchdata','AjaxdataController@fetchdata')->name('ajaxdata.fetchdata');
Route::get('ajaxdata/removedata','AjaxdataController@removedata')->name('ajaxdata.removedata');


Route::get('/','SessionController@index');
Route::get('setSingle','SessionController@setSingle');
Route::get('setMultiple','SessionController@setMultiple');
Route::get('getSingle','SessionController@getSingle');
Route::get('deleteSes','SessionController@delSes');
