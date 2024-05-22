<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    //  Manual testing (this will be removed as soon as we have implemented Unit Tests)
    $app->get('/test/storage', \App\Action\Test\TestStorageAction::class);
    $app->get('/test/php', \App\Action\Test\TestPhpAction::class);
    $app->get('/test/pdftk', \App\Action\Test\TestPdftkAction::class);
    $app->get('/test/php-pdftk', \App\Action\Test\TestPhpPdftkAction::class);
    $app->get('/test/misc', \App\Action\Test\TestMiscAction::class);    

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
