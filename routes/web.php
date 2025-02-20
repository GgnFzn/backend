<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});

feat-login
$router->post('auth/register', ['uses' => 'AuthController@register']);
$router->post('auth/login', ['uses' => 'AuthController@login']);

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/profile', function () {
        return response()->json(auth()->user());
    });

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('barangs', ['uses' => 'BarangController@index']);
    $router->get('barangs/{id}', ['uses' => 'BarangController@show']);
    $router->post('barangs', ['uses' => 'BarangController@store', 'middleware' => 'jwt.auth']);
    $router->put('barangs/{id}', ['uses' => 'BarangController@update', 'middleware' => 'jwt.auth']);
    $router->delete('barangs/{id}', ['uses' => 'BarangController@destroy', 'middleware' => 'jwt.auth']);
dev
});