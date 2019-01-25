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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'HomeController@admin');
Route::get('/admin/home', 'HomeController@admin');
Route::get('/admin/profile', 'HomeController@profile');
Route::get('/admin/give/{id}', 'HomeController@giveRights');
Route::get('/admin/take/{id}', 'HomeController@takeRights');
Route::get('/users', 'UserController@index');

//Route::get('questions/create/{$id}', 'QuestionsController@create');

Route::resource('admin/tests', 'TestsController');
Route::resource('admin/questions', 'QuestionsController');
Route::resource('admin/answers', 'AnswersController');
Route::get('admin/answers/evaluate/{id}', 'AnswersController@evaluate');

Route::resource('students', 'StudentsController');
Route::get('/students/submit', 'StudentsController@submit');