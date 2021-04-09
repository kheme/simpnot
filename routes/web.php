<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('subscribe/{topic}',      'SubscriptionController@store');
$router->post('publish/{topic}',        'BroadcastController@store');
$router->delete('subscribe/{topic}',    'SubscriptionController@destroy');

$router->post('{topic}', function (Request $request, string $topic) {
    Log::info($request->all());
    
    return 'Broadcast received';
});