<?php

/*
|--------------------------------------------------------------------------
| Quetzal Application Routes
|--------------------------------------------------------------------------
*/

$app->get('/', ['as' => 'index', 'uses' => 'FrontendController@getIndex']);

$app->post('/generate', ['as' => 'generate', 'middleware' => 'csrf', 'uses' => 'BackendController@postGenerate']);
$app->post('/destroy', ['as' => 'destroy', 'middleware' => 'csrf', 'uses' => 'BackendController@postDestroy']);

$app->post('/api/generate', ['as' => 'generate', 'uses' => 'BackendController@postGenerate']);
$app->post('/api/destroy', ['as' => 'destroy', 'uses' => 'BackendController@postDestroy']);


