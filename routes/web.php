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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/filter', 'HomeController@filter');
Route::get('/user/edit/{id}', 'HomeController@getUserByID');
Route::get('/hno3', 'HNO3Controller@index')->name('hno3');
Route::get('/hf', 'HFController@index')->name('hf');
Route::get('/concentration', 'ConcentrationController@index')->name('concentration');
Route::get('/brushrollerelectricity', 'BrushRollerElectricityController@index')->name('brushrollerelectricity');
