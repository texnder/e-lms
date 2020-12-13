<?php  

/*
 |------------------------------------------------------------------
 | APPLICATION ROUTES
 |------------------------------------------------------------------
 |
 | defined all apllication Routes here, only these routes are Authenticated
 | or allowed, other routes apart these will return 404 http error page
 | here, Routex api is used to handle routes. To, know more please visit
 | our documentation: http://texnder.com/documentation/
 */

use Routex\Route;

Route::get('/texnder', function(){
	return view('app');
});


//  redCarpet Interview project links

// migrate Tables in database

Route::get('/migrate-tables-in-database', "App\controllers\adminController@migrate");

Route::get('/', 'App\controllers\loanManagementController@index');
Route::get('/login/{role}', 'App\controllers\adminController@login');
Route::get('/logout', 'App\controllers\adminController@logout');
Route::get('/dashboard/{role}', 'App\controllers\loanManagementController@show_all')->middelware('Auth');
Route::get('/register-new-administrator', 'App\controllers\adminController@index');
Route::post('/user+request+form+loan', 'App\controllers\loanManagementController@create');
Route::post('/login', 'App\controllers\adminController@submit');


// Ajax calls===

Route::get('/check-application-status', 'App\controllers\loanManagementController@checkStatus');

Route::post('/user-application', 'App\controllers\loanManagementController@show_ById')->middelware('Auth');
Route::post('/update+user+profile', 'App\controllers\loanManagementController@update')->middelware('Auth');
Route::post('/forword+user+profile', 'App\controllers\loanManagementController@forword')->middelware('Auth');
Route::post('/approve-application', 'App\controllers\loanManagementController@approve')->middelware('Auth');
Route::post('/delete+user+profile', 'App\controllers\loanManagementController@delete')->middelware('Auth');
Route::post('/upload-admin-image', 'App\controllers\loanManagementController@uploadImage')->middelware('Auth');
Route::post('/delete+permanently+user+profile', 'App\controllers\loanManagementController@destroy')->middelware('Auth');
Route::post('/register-new-admin', 'App\controllers\adminController@register');

