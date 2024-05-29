<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    $app->group(
        '/test',
        function(RouteCollectorProxy $app) {
            
            //  Manual testing (this will be removed as soon as we have implemented Unit Tests)
            $app->get('/storage', \App\Action\Test\TestStorageAction::class);
            $app->get('/php', \App\Action\Test\TestPhpAction::class);
            $app->get('/pdftk', \App\Action\Test\TestPdftkAction::class);
            $app->get('/php-pdftk', \App\Action\Test\TestPhpPdftkAction::class);
            $app->get('/misc', \App\Action\Test\TestMiscAction::class);
        }
    );

    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {

            $app->group('/v1', function (RouteCollectorProxy $app) {

                $app->get('/',function(ServerRequestInterface $request, ResponseInterface $response){
                    $response->getBody()->write("API Documentation");
                    return $response;
                });
    
                $app->group('/customers', function (RouteCollectorProxy $app) {
                    $app->get('', \App\Action\Customer\CustomerFinderAction::class);
                    $app->post('', \App\Action\Customer\CustomerCreatorAction::class);
                    $app->get('/{customer_id}', \App\Action\Customer\CustomerReaderAction::class);
                    $app->put('/{customer_id}', \App\Action\Customer\CustomerUpdaterAction::class);
                    $app->delete('/{customer_id}', \App\Action\Customer\CustomerDeleterAction::class);
                });
            
                $app->group('/folders', function (RouteCollectorProxy $app) {
                    $app->get('', \App\Action\Folder\FolderFinderAction::class);
                    $app->post('', \App\Action\Folder\FolderCreatorAction::class);
                    $app->get('/{folder_id}', \App\Action\Folder\FolderReaderAction::class);
                    $app->put('/{folder_id}', \App\Action\Folder\FolderUpdaterAction::class);
                    $app->delete('/{folder_id}', \App\Action\Folder\FolderDeleterAction::class);
                });
    
                $app->group('/documents', function (RouteCollectorProxy $app) {
                    $app->get('', \App\Action\Document\DocumentFinderAction::class);
                    $app->post('', \App\Action\Document\DocumentCreatorAction::class);
                    $app->get('/{document_id}', \App\Action\Document\DocumentReaderAction::class);
                    $app->put('/{document_id}', \App\Action\Document\DocumentUpdaterAction::class);
                    $app->delete('/{document_id}', \App\Action\Document\DocumentDeleterAction::class);
                });
    
                $app->group('/jobs', function (RouteCollectorProxy $app) {
                    $app->get('', \App\Action\Job\JobFinderAction::class);
                    $app->post('', \App\Action\Job\JobCreatorAction::class);
                    $app->get('/{job_id}', \App\Action\Job\JobReaderAction::class);
                    $app->put('/{job_id}', \App\Action\Job\JobUpdaterAction::class);
                    $app->delete('/{job_id}', \App\Action\Job\JobDeleterAction::class);
                });
    
                $app->group('/outputs', function (RouteCollectorProxy $app) {
                    $app->get('/{output_uuid}', \App\Action\Output\OutputStreamerAction::class);
                });

            });            
        }
    );

};
