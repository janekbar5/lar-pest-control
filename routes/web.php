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
	
///////////////////////////////////////////////////////////////////////////////////////////////////////HISTORY  
Route::get('v1/api/history/index', 'HistoryController@index');
Route::get('/v1/api/home/searchbox', 'HomeController@searchBox')->name('home.search'); //list 
Route::get('/v1/api/home/globalsettings', 'HomeController@globalsettings');
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
///////////////////////////////////////////////////////////////////////////////////////////////////////TREATMENT
Route::get('v1/api/treatments/index', 'TreatmentController@index'); //list    
Route::get('v1/api/treatments/{id}/edit', 'TreatmentController@edit'); //edit
Route::get('v1/api/treatments/create', 'TreatmentController@create'); //create     
Route::post('v1/api/treatments/create', 'TreatmentController@store'); //create post
Route::post('v1/api/treatments/update/{id}', 'TreatmentController@update'); //update  post
Route::put('v1/api/treatments/update/{id}', 'TreatmentController@update'); //update  post 
Route::delete('v1/api/treatments/delete/{id}', 'TreatmentController@destroy'); //update  post  
///////////////////////////////////////////////////////////////////////////////////////////////////////TASKS
Route::get('v1/api/tasks/calendar', 'TaskController@calendar'); //list 
Route::get('v1/api/tasks/usercalendar', 'TaskController@userCalendar'); //list
Route::get('v1/api/tasks/index', 'TaskController@index'); //list    
Route::get('v1/api/tasks/{id}/edit', 'TaskController@edit'); //edit
Route::get('v1/api/tasks/create', 'TaskController@create'); //create     
Route::post('v1/api/tasks/create', 'TaskController@store'); //create post
Route::post('v1/api/tasks/update/{id}', 'TaskController@update'); //update  post
Route::put('v1/api/tasks/update/{id}', 'TaskController@update'); //update  post 
Route::delete('v1/api/tasks/delete/{id}', 'TaskController@destroy'); //update  post

Route::get('/v1/api/tasks/gettasksbydate', 'TaskController@getTasksByDate'); //list 

///////////////////////////////////////////////////////////////////////////////////////////////////////LOCATIONS
Route::get('v1/api/locations/filter', 'LocationController@filter'); //list 
Route::get('v1/api/locations/index', 'LocationController@index'); //list    
Route::get('v1/api/locations/{id}/edit', 'LocationController@edit'); //edit
Route::get('v1/api/locations/create', 'LocationController@create'); //create     
Route::post('v1/api/locations/create', 'LocationController@store'); //create post
Route::post('v1/api/locations/update/{id}', 'LocationController@update'); //update  post
Route::put('v1/api/locations/update/{id}', 'LocationController@update'); //update  post 
Route::delete('v1/api/locations/delete/{id}', 'LocationController@destroy'); //update  post 
///////////////////////////////////////////////////////////////////////////////////////////////////////STATUSES
Route::get('v1/api/statuses/index', 'StatusController@index'); //list    
Route::get('v1/api/statuses/{id}/edit', 'StatusController@edit'); //edit
Route::get('v1/api/statuses/create', 'StatusController@create'); //create     
Route::post('v1/api/statuses/create', 'StatusController@store'); //create post
Route::post('v1/api/statuses/update/{id}', 'StatusController@update'); //update  post
Route::put('v1/api/statuses/update/{id}', 'StatusController@update'); //update  post 
Route::delete('v1/api/statuses/delete/{id}', 'StatusController@destroy'); //update  post 
///////////////////////////////////////////////////////////////////////////////////////////////////////SUB STATUSES
Route::get('v1/api/substatuses/index', 'SubStatusController@index'); //list    
Route::get('v1/api/substatuses/{id}/edit', 'SubStatusController@edit'); //edit
Route::get('v1/api/substatuses/create', 'SubStatusController@create'); //create     
Route::post('v1/api/substatuses/create', 'SubStatusController@store'); //create post
Route::post('v1/api/substatuses/update/{id}', 'SubStatusController@update'); //update  post
Route::put('v1/api/substatuses/update/{id}', 'SubStatusController@update'); //update  post 
Route::delete('v1/api/substatuses/delete/{id}', 'SubStatusController@destroy'); //update  post
///////////////////////////////////////////////////////////////////////////////////////////////////////CLIENTS
Route::get('v1/api/clients/searchclients', 'ClientController@searchClients'); //list 
Route::get('v1/api/clients/index', 'ClientController@index'); //list    
Route::get('v1/api/clients/{id}/edit', 'ClientController@edit'); //edit
Route::get('v1/api/clients/create', 'ClientController@create'); //create     
Route::post('v1/api/clients/create', 'ClientController@store'); //create post
Route::post('v1/api/clients/update/{id}', 'ClientController@update'); //update  post
Route::put('v1/api/clients/update/{id}', 'ClientController@update'); //update  post 
Route::delete('v1/api/clients/delete/{id}', 'ClientController@destroy'); //update  post 

});    
    
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' ); //match any route in VUE