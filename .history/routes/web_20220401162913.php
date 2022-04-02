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

$router->get("/payments", ["uses" => "\App\Http\Controllers\Answerable@getClient"]);

$router->get("/parcels", ["uses" => "\App\Http\Controllers\Answerable@getParcel"]);

// http://localhost:8000/select?filter%22nu_parcela%22,%22vl_parcela%22&
$router->get("/select?filter={params}", ["uses" => "\App\Http\Controllers\Answerable@getWithParams"]);