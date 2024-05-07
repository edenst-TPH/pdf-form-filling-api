<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use mikehaertl\pdftk\Pdf;

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

    $app->get('/ppdftk', function(ServerRequestInterface $request, ResponseInterface $response){

        $pdf = new Pdf('pdftk_test_document.pdf');
        $result = $pdf->getDataFields();

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    });


    $app->get('/test', function(ServerRequestInterface $request, ResponseInterface $response){

        $test = array();

        $test["password"] = $_ENV['DB_PASSWORD'] ?: 'password';

        $test["date"] = date("Y-m-d h:i:s",time());

        $response->getBody()->write(json_encode($test));

        return $response->withHeader('Content-Type', 'application/json');
    });    


    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {
            $app->get('/',function(ServerRequestInterface $request, ResponseInterface $response){
                $response->getBody()->write("API Documentation");
                return $response;
            });
            
            $app->get('/customers', \App\Action\Customer\CustomerFinderAction::class);
            $app->post('/customers', \App\Action\Customer\CustomerCreatorAction::class);
            $app->get('/customers/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
            $app->put('/customers/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
            $app->delete('/customers/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);

            $app->get('/folders', \App\Action\Folder\FolderFinderAction::class);
            $app->post('/folders', \App\Action\Folder\FolderCreatorAction::class);
            $app->get('/folders/{folder_id}', \App\Action\Folder\FolderReaderAction::class);
            $app->put('/folders/{folder_id}', \App\Action\Folder\FolderUpdaterAction::class);
            $app->delete('/folders/{folder_id}', \App\Action\Folder\FolderDeleterAction::class);

            $app->get('/documents', \App\Action\Document\DocumentFinderAction::class);
            $app->post('/documents', \App\Action\Document\DocumentCreatorAction::class);
            $app->get('/documents/{document_id}', \App\Action\Document\DocumentReaderAction::class);
            $app->put('/documents/{document_id}', \App\Action\Document\DocumentUpdaterAction::class);
            $app->delete('/documents/{document_id}', \App\Action\Document\DocumentDeleterAction::class);

            $app->get('/jobs', \App\Action\Job\JobFinderAction::class);
            $app->post('/jobs', \App\Action\Job\JobCreatorAction::class);
            $app->get('/jobs/{job_id}', \App\Action\Job\JobReaderAction::class);
            $app->put('/jobs/{job_id}', \App\Action\Job\JobUpdaterAction::class);
            $app->delete('/jobs/{job_id}', \App\Action\Job\JobDeleterAction::class);
        }
    );

};
