<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'ContactController@getIndex');
Route::get('get-contact', 'ContactController@getData');
Route::post('contacts/store', 'ContactController@postStore');
Route::get('contact/edit/{id}', 'ContactController@contactEdit');
Route::post('contact/update/{id}', 'ContactController@contactUpdate');
Route::post('contact/delete/{id}', 'ContactController@contactDelete');

Route::get('ajax','TeacherController@index');
Route::get('ajax/get-all','TeacherController@getData');
Route::post('ajax/create-new-teacher','TeacherController@createTeacher');
Route::get('ajax/edit-teacher/{id}','TeacherController@editTeacher');
Route::post('ajax/update-teacher/{id}','TeacherController@updateTeacher');
Route::get('ajax/delete/{id}','TeacherController@deleteTeacher');
