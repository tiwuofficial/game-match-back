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
        'uses' => 'UserController@me'
    ]);
    $router->get('/users', [
        'uses' => 'UserController@index'
    ]);
    $router->put('/users/edit', [
        'uses' => 'UserController@update'
    ]);
    $router->get('/users/{id}', [
        'uses' => 'UserController@show'
    ]);
    $router->post('/requests', [
        'uses' => 'FriendController@store'
    ]);
    $router->get('/requests', [
        'uses' => 'FriendController@requests'
    ]);
    $router->post('/approval', [
        'uses' => 'FriendController@approval'
    ]);
    $router->post('/rejection', [
        'uses' => 'FriendController@rejection'
    ]);
    $router->get('/friends', [
        'uses' => 'FriendController@friends'
    ]);
});