<?php

/*
|--------------------------------------------------------------------------
| Quetzal Application Routes
|--------------------------------------------------------------------------
*/

if(env('APP_FRONTEND')) {
    $app->get('/', ['as' => 'index', 'uses' => 'FrontendController@getIndex']);

    $app->post('/generate', ['as' => 'generate', 'middleware' => 'csrf', 'uses' => 'BackendController@postGenerate']);
    $app->post('/destroy', ['as' => 'destroy', 'middleware' => 'csrf', 'uses' => 'BackendController@postDestroy']);
}

if(env('APP_API')) {
    $app->post('/api/generate', ['as' => 'generate', 'uses' => 'BackendController@apiPostGenerate']);
    $app->delete('/api/destroy', ['as' => 'destroy', 'uses' => 'BackendController@apiDeleteDestroy']);
}

$app->get('/test', function(App\Services\FlareService $flare) {
    print_r($flare->available('9fb9152865af0d73ab47476d911823f6', 'test', '1.1.1.2'));
});