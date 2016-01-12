<?php

/*
|--------------------------------------------------------------------------
| Quetzal Application Routes
|--------------------------------------------------------------------------
*/

$app->get('/', ['as' => 'index', 'uses' => 'FrontendController@getIndex']);

$app->post('/generate', ['as' => 'generate', 'uses' => 'BackendController@postGenerate']);
$app->post('/destroy', ['as' => 'destroy', 'uses' => 'BackendController@postDestroy']);
