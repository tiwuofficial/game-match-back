<?php

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', [
        'uses' => 'AuthController@login'
    ]);
    $router->post('/register', [
        'uses' => 'AuthController@register'
    ]);
});

$router->group(['middleware' => 'auth', 'prefix' => 'api'], function () use ($router) {
    $router->get('/me', [
        'uses' => 'AuthController@me'
    ]);
    $router->get('/users', [
        'uses' => 'UserController@index'
    ]);
    $router->get('/users/{id}', [
        'uses' => 'UserController@show'
    ]);
});