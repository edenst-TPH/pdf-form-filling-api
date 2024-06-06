<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Action\Test;
use App\Action\User;
use App\Action\Folder;
use App\Action\Document;
use App\Action\Job;
use App\Action\Output;
use App\Action\Auth;
use App\Action\Dashboard;

use App\Middleware\AuthMiddleware;
use App\Middleware\DashboardAuthMiddleware;
use App\Middleware\LoginAuthMiddleware;
use App\Middleware\ValidationMiddleware;
use App\Middleware\TwigFlashMiddleware;
use Slim\Views\TwigMiddleware;

use Odan\Session\Middleware\SessionStartMiddleware;

return function (App $app) {

    $app->group('', function(RouteCollectorProxy $app){

        $app->get('', \App\Action\Home\HomeAction::class)->setName('home');

        $app->get('/dashboard', Dashboard\DashboardHomeAction::class)->setName('dashboard')->add(DashboardAuthMiddleware::class);

        $app->group('', function(RouteCollectorProxy $app){

            $app->get('/login', Auth\AuthLoginAction::class)->setName('login')->add(LoginAuthMiddleware::class);
            $app->post('/login', Auth\AuthLoginSubmitAction::class)->setName('login.submit');

            $app->get('/logout', Auth\AuthLogoutAction::class)->setName('logout');

            $app->get('/register', Auth\AuthRegisterAction::class)->setName('register')->add(AuthMiddleware::class);

            $app->post('/register', Auth\AuthRegisterSubmitAction::class)->setName('register.submit'); 
        });

    })->add(TwigFlashMiddleware::class)->add(TwigMiddleware::class)->add(SessionStartMiddleware::class);


    $app->group(
        '/test',
        function(RouteCollectorProxy $app) {
            
            //  Manual testing (this will be removed as soon as we have implemented Unit Tests)
            $app->get('/storage', Test\TestStorageAction::class);
            $app->get('/php', Test\TestPhpAction::class);
            $app->get('/pdftk', Test\TestPdftkAction::class);
            $app->get('/php-pdftk', Test\TestPhpPdftkAction::class);
            $app->get('/misc', Test\TestMiscAction::class);
        }
    );

    // API
    $app->group(
        '/api',
        function (RouteCollectorProxy $app) {

            $app->group('/v1', function (RouteCollectorProxy $app) {

                $app->get('',function(ServerRequestInterface $request, ResponseInterface $response){
                    $response->getBody()->write("API Documentation");
                    return $response;
                });
    
                $app->group('/users', function (RouteCollectorProxy $app) {
                    $app->get('', User\UserFinderAction::class);
                    $app->post('', User\UserCreatorAction::class);
                    $app->get('/{user_id}', User\UserReaderAction::class);
                    $app->put('/{user_id}', User\UserUpdaterAction::class);
                    $app->delete('/{user_id}', User\UserDeleterAction::class);
                });
            
                $app->group('/folders', function (RouteCollectorProxy $app) {
                    $app->get('', Folder\FolderFinderAction::class);
                    $app->post('', Folder\FolderCreatorAction::class);
                    $app->get('/{folder_id}', Folder\FolderReaderAction::class);
                    $app->put('/{folder_id}', Folder\FolderUpdaterAction::class);
                    $app->delete('/{folder_id}', Folder\FolderDeleterAction::class);
                });
    
                $app->group('/documents', function (RouteCollectorProxy $app) {
                    $app->get('', Document\DocumentFinderAction::class);
                    $app->post('', Document\DocumentCreatorAction::class);
                    $app->get('/{document_id}', Document\DocumentReaderAction::class);
                    $app->put('/{document_id}', Document\DocumentUpdaterAction::class);
                    $app->delete('/{document_id}', Document\DocumentDeleterAction::class);
                });
    
                $app->group('/jobs', function (RouteCollectorProxy $app) {
                    $app->get('', Job\JobFinderAction::class);
                    $app->post('', Job\JobCreatorAction::class);
                    $app->get('/{job_id}', Job\JobReaderAction::class);
                    $app->put('/{job_id}', Job\JobUpdaterAction::class);
                    $app->delete('/{job_id}', Job\JobDeleterAction::class);
                });
    
                $app->group('/outputs', function (RouteCollectorProxy $app) {
                    $app->get('/{output_uuid}', Output\OutputStreamerAction::class);
                });

            });            
        }
    )->add(ValidationMiddleware::class);

};
