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
    return view('home');
});

Route::get('/index','EmployeeController@index')->name('employees');

Route::get('/create', 'EmployeeController@create')->name('create_employee');

Route::post('/store', 'EmployeeController@store')->name('store_employee');

Route::post('/search', 'EmployeeController@searchEmployee')->name('search_employee');