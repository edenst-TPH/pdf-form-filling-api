<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    $app->get('/info', function(ServerRequestInterface $request, ResponseInterface $response){

        ob_start () ;
        phpinfo () ;
        $pinfo = ob_get_contents () ;
        ob_end_clean () ;

        $response->getBody()->write($pinfo);
        return $response;
    });


    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);
            // $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);
            // $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
            // $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
            // $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);
        }
    );

};
