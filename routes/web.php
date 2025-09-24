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

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

// $router->group(['middleware' => 'auth'], function () use ($router) {
// });
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'employee'], function () use ($router) {
        $router->get('/list', 'EmployeeController@list');
        $router->get('/detail/{employeeId}', 'EmployeeController@detail');
        $router->get('/by-working-unit/{workingUnitId}', 'EmployeeController@listByWorkingUnit');

        $router->post('/create', 'EmployeeController@create');
        $router->post('/create-multiple', 'EmployeeController@createMultiple');

        $router->get('/list-dummy/{month}/{year}', 'EmployeeController@listDummy');
    });

    $router->group(['prefix' => 'mutasi'], function () use ($router) {
        $router->get('/list', 'MutasiController@list');
        $router->get('/detail/{mutasiId}', 'MutasiController@detail');

        $router->get('/list-dummy/{month}/{year}', 'MutasiController@listDummy');
    });

    $router->group(['prefix' => 'journal-item'], function () use ($router) {
        $router->get('/list', 'JournalItemController@list');
        $router->get('/detail/{mutasiId}', 'JournalItemController@detail');
        
        $router->get('/list-dummy/{month}/{year}', 'JournalItemController@listDummy');
    });
});
