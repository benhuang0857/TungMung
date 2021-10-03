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
Route::get('/user/edit_submit', 'HomeController@editSubmit');
Route::get('/user/delete/{id}', 'HomeController@delete');
Route::get('/user/create', 'HomeController@createUserPage')->name('cuserpage');
Route::post('/user/create/submit', 'HomeController@createUser')->name('createuser');

Route::get('/hno3', 'HNO3Controller@index')->name('hno3');
Route::get('/hno3_repor', 'HNO3Controller@showReportDay')->name('hno3_repor');
Route::get('/hno3_spec', 'HNO3Controller@setSpecPage')->name('hno3spec');
Route::get('/hno3_spec/submit', 'HNO3Controller@submitSpec')->name('setting_hno3spec');
Route::get('/hno3/showchart', 'HNO3Controller@showChart')->name('hno3showchart');
//Route::get('/hno3/{name}', 'HNO3Controller@getOne')->name('onehno3');

Route::get('/hf', 'HFController@index')->name('hf');
Route::get('/hf_spec', 'HFController@setSpecPage')->name('hfspec');
Route::get('/hf_spec/submit', 'HFController@submitSpec')->name('setting_hfspec');
Route::get('/hf_repor', 'HFController@showReportDay')->name('hf_repor');
Route::get('/hf/showchart', 'HFController@showChart')->name('hfshowchart');

Route::get('/concentration', 'ConcentrationController@index')->name('concentration');
Route::get('/brushrollerelectricity', 'BrushRollerElectricityController@index')->name('brushrollerelectricity');

Route::get('/no3_setting', 'HNO3Controller@settingPage')->name('no3_setting');
Route::get('/no3_setting/pass', 'HNO3Controller@passSettingPara')->name('no3_setting_pass');

Route::get('/hno3_cal', 'HNO3Controller@calculate')->name('hno3_calculate');
Route::get('/hno3_predict', 'HNO3Controller@predictPage')->name('hno3_predict');
Route::get('/hno3_predict_repor', 'HNO3Controller@showPredictReportDay')->name('hno3_predict_repor');
Route::get('/hno3_predict_8h', 'HNO3Controller@predict8HPage')->name('hno3_predict_8h');

Route::get('/hf_cal', 'HFController@calculate')->name('hf_calculate');
Route::get('/hf_predict', 'HFController@predictPage')->name('hf_predict');
Route::get('/hf_predict_repor', 'HFController@showPredictReportDay')->name('hf_predict_repor');
Route::get('/hf_predict_8h', 'HFController@predict8HPage')->name('hf_predict_8h');

//Route::get('/hf_setting', 'HFController@settingPage')->name('hf_setting');
//Route::get('/hf_setting/pass', 'HFController@passSettingPara')->name('hf_setting_pass');
