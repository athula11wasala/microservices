<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

 Route::group(["middleware" =>[
 	   "auth:api"],
 	  'prefix' => 'api'
 	], function ()  use ($router) {

     $router->get('category/show-category', 'CategoryController@showCategory');
     $router->post('category/add-category', 'CategoryController@createCategory');
     $router->put('category/edit-category', 'CategoryController@editCategory');
     $router->delete('category/delete-category/{id}', 'CategoryController@deleteCategory');
   });


