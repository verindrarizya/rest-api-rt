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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->post('register-rt', 'AuthController@registerRT');
$router->post('register-warga', 'AuthController@registerWarga');
$router->post('login' , 'AuthController@login');

$router->get('token', 'AuthController@getToken');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('logout', 'AuthController@logout');
    $router->post('change-password', 'AuthController@changePassword');

    // RT
    $router->group(['prefix' => 'rt'], function () use ($router) {
        $router->get('show-profile', 'RtController@show');
        $router->put('update-profile', 'RtController@updateProfile');
        $router->get('laporan-kesejahteraan', 'RtController@lapKesejahteraan');
        // $router->get('laporan-kesehatan', 'RtController@lapKesehatan');

        //Tester buat nge fix laporan kesehatan
        $router->get('laporan-kesehatan', 'RtController@kesehatan');
    });

    // Warga
    $router->group(['prefix' => 'warga'], function () use ($router) {
        $router->get('show-profile', 'WargaController@show');
        $router->put('update-profile', 'WargaController@updateProfile');
        $router->post('kesejahteraan', 'WargaController@kondisiKesejahteraan');
        $router->post('kesehatan', 'WargaController@kondisiKesehatan');
    });
});