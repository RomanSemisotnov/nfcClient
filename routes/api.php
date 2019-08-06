<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'jwt.auth'], function ($router) {

    Route::group(['prefix' => 'client'], function ($router) {
        Route::get('/all', 'ClientController@index');
        Route::get('/{name}', 'ClientController@get');
        Route::post('create', 'ClientController@store');
    });

    Route::group(['prefix' => 'params'], function ($router) {
        Route::post('/update/{id}', 'QueryParamsController@update');
        Route::post('/delete/{id}', 'QueryParamsController@delete');
    });

    Route::group(['prefix' => 'variable'], function ($router) {
        Route::post('/create', 'VariableParamController@create');
        Route::post('/delete/{id}', 'VariableParamController@delete');
    });

    Route::group(['prefix' => 'links'], function ($router) {
        Route::get('/{client_id}', 'LinksController@get');
        Route::post('/', 'LinksController@store');
    });

});*/

