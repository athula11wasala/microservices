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


$router->group(['prefix' => 'api'], function () use ($router) {
     $router->post('login', 'Auth\AccessTokenController@login');
    $router->post('register', 'Auth\AccessTokenController@signup');

    Route::group(["middleware" =>[ "auth:api"]], function () use ($router) {
        Route::group(['middleware' => ['role:ADMINISTRATOR|Manger']], function ($router) {
            $router->post('logout', 'Auth\AccessTokenController@logout');
            $router->get('show', 'AssetController@show');
        });

        Route::group(["prefix" => "permissions"], function () use ($router) {
            Route::group(['middleware' => ['role:ADMINISTRATOR']], function ($router) {

                Route::group(['middleware' => ['permission:ADMINTOOLS']], function ($router) {
                    $router->post("add-permission","RoleUserController@addPermissions");
                });

                Route::post("add-permission-role", "RoleUserController@addPermissionToRole");
                Route::get("role-permission", "RoleUserController@getUserRoleAndPermissions");
                Route::get("user-has-role/{role}", "RoleUserController@hasRole");
                Route::get("user-has-permission/{permission}", "RoleUserController@hasPermission");
            });

            });

          Route::group(["prefix" => "category"], function () use ($router) {

            $router->get("show-category","AssetController@show");
            $router->post("add-category","AssetController@createCategory");
            $router->put('edit-category', 'AssetController@editCategory');
            $router->delete('delete-category/{id}', 'AssetController@deleteCategory');
      });

        Route::group(["prefix" => "sms"], function () use ($router) {

            $router->post("send-sms","SmsController@sendSms");

        });
    });
});


