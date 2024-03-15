<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    $app->get('/pinfo', function(ServerRequestInterface $request, ResponseInterface $response){


        #throw new \RuntimeException('This is a test');

        ob_start () ;
        phpinfo () ;
        $pinfo = ob_get_clean () ;

        $response->getBody()->write($pinfo);
        return $response;
    });

    $app->get('/pdftk', function(ServerRequestInterface $request, ResponseInterface $response){

        $pdftk = shell_exec('pdftk -version');
        $which = shell_exec('which pdftk');
        $locales = shell_exec('locale -a');
        $env = json_encode($_ENV);

        $result = '<pre>pdftk -version<br><br>'.$pdftk.'</pre>';
        $result .= '<br><pre>locale -a<br><br>'.$locales.'</pre>';
        $result .= '<br><pre>which pdftk<br><br>'.$which.'</pre>';
        $result .= '<br><pre>'.$env.'</pre>';

        $response->getBody()->write($result);
        return $response;
    });


    $app->get('/test', function(ServerRequestInterface $request, ResponseInterface $response){

        $test = $_ENV['DB_PASSWORD'] ?: 'password';

        $response->getBody()->write(json_encode($test));

        return $response->withHeader('Content-Type', 'application/json');
    });    


    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);
            $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);
            $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
            $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
            $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);
        }
    );

};
