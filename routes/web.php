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
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => ['web', 'auth', 'role']],  function(){
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/tim', 'TimCon@index');
  
  
  // project
  Route::get('/project', 'ProjectCon@index');
  Route::get('/project/jsonDetailProject', 'ProjectCon@jsonDetailProject');
  Route::get('/project/jsonListProject', 'ProjectCon@jsonlListProject');
  Route::post('/project/processForm', 'ProjectCon@processForm');
  Route::get('/project/deleteProject', 'ProjectCon@deleteProject');

  // User
  Route::get('/users', 'UserCon@index');
  Route::get('/users/form', 'UserCon@showForm');
  Route::post('/users/processForm', 'UserCon@processForm');
  Route::get('/users/jsonListUser', 'UserCon@jsonListUser');
  Route::get('/user/deleteUser', 'UserCon@deleteUser');
  Route::get('/users/setThemeUser', 'UserCon@setThemeUser');

  // Tim
  Route::get('/tim/jsonListTim', 'TimCon@jsonListTim');
  Route::post('/tim/processForm', 'TimCon@processForm');
  Route::get('/tim/jsonDetailTim', 'TimCon@jsonDetailTim');
  Route::get('/tim/deleteTim', 'TimCon@deleteTim');
  Route::get('/tim/selectTimByProject', 'TimCon@selectTimByProject');

  // Request
  Route::get('/request', 'RequestCon@index');
  Route::get('request/add', 'RequestCon@addRequest');
  Route::post('/request/processForm', 'RequestCon@processForm');
  Route::get('/request/jsonListRequest', 'RequestCon@jsonListRequest');
  Route::get('/request/loadRequestUser', 'RequestCon@loadRequestUser');
  Route::get('/request/deleteRequest', 'RequestCon@deleteRequest');
  Route::get('/request/download', 'RequestCon@download');
});
