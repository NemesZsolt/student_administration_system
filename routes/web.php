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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('students', 'StudentController');

Route::get('/pagination/fetch_data', 'StudentController@fetch_data');

Route::get('enrollment', 'EnrollmentController@index')->name('enrollment.index');
Route::post('enrollment', 'EnrollmentController@store')->name('enrollment.store');