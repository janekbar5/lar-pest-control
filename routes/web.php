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

Route::group(['middleware' => ['auth']], function() {
///////////////////////////////////////////////////////////////////////////////////////////////////////USERS
         //Route::get('user/index', 'UserController@index');
         Route::get('v1/api/users/index', 'UserController@index');
         Route::get('v1/api/users/{id}/edit', 'UserController@edit'); //edit 
         Route::get('v1/api/users/create', 'UserController@create'); //create     
         Route::post('v1/api/users/create', 'UserController@store'); //create post
         Route::post('v1/api/users/update/{id}', 'UserController@update'); //update  post
          Route::put('v1/api/users/update/{id}', 'UserController@update'); //update  post 
       Route::delete('v1/api/users/delete/{id}', 'UserController@destroy'); //update  post
///////////////////////////////////////////////////////////////////////////////////////////////////////ROLES
          Route::get('v1/api/roles/index', 'RoleController@index'); //list    
          Route::get('v1/api/roles/{id}/edit', 'RoleController@edit'); //edit
          Route::get('v1/api/roles/create', 'RoleController@create'); //create     
         Route::post('v1/api/roles/create', 'RoleController@store'); //create post
         Route::post('v1/api/roles/update/{id}', 'RoleController@update'); //update  post
         Route::put('v1/api/roles/update/{id}', 'RoleController@update'); //update  post 
       Route::delete('v1/api/roles/delete/{id}', 'RoleController@destroy'); //update  post
///////////////////////////////////////////////////////////////////////////////////////////////////////IMAGES      
Route::post('/v1/api/images/index', 'ImageController@index');
Route::delete('/v1/api/images/delete/{id}', 'ImageController@destroy');
  Route::post('/images/post', 'ImageController@post');                
});    
    
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' ); //match any route in VUE