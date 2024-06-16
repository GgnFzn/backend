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

$router->post('auth/register', ['uses' => 'AuthController@register']);
$router->post('auth/login', ['uses' => 'AuthController@login']);
$router->post('/reset-password', ['uses' => 'AuthController@resetPassword']);

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/profile', function () {
        return response()->json(auth()->user());
    });
});

$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');
$router->get('user', ['middleware' => 'auth', 'uses' => 'AuthController@getUser']);

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('presensi', 'PresensiController@store');
    $router->get('presensi', 'PresensiController@index');
});

// $router->group(['prefix' => 'api', 'middleware' => ['auth', 'check.location']], function ($app) {
//     $app->post('clock-in', 'AttendanceController@clockIn');
//     $app->post('clock-out', 'AttendanceController@clockOut');
//     // tambahkan routes lainnya
// });

// $router->group(['prefix' => 'api', 'middleware' => 'auth'], function ($router) {
//     $router->post('clock-in', 'AttendanceController@clockIn')->middleware('check.location');
//     $router->post('clock-out', 'AttendanceController@clockOut')->middleware('check.location');
// });

// $router->group(['prefix' => 'api'], function () use ($router) {
//     $router->post('register', 'AuthController@register');
//     $router->post('login', 'AuthController@login');

//     $router->group(['middleware' => 'auth'], function() use ($router) {
//         $router->get('user', 'AuthController@getAuthenticatedUser');
//         $router->post('password/change', 'PasswordChangeController@changePassword');
//         $router->get('posts', 'PostController@index');
//         $router->get('posts/{id}', 'PostController@show');
//         $router->post('posts', 'PostController@store');
//         $router->put('posts/{id}', 'PostController@update');
//         $router->delete('posts/{id}', 'PostController@destroy');
//     });
// });

// $router->group(['prefix' => 'api'], function () use ($router) {
//     $router->post('register', 'AuthController@register');
//     $router->post('login', 'AuthController@login');

//     $router->group(['middleware' => 'auth'], function() use ($router) {
//         $router->post('password/change', 'PasswordChangeController@changePassword');
//         // Routes lainnya yang memerlukan autentikasi
//     });
// });


