<?php

namespace App\Action\Auth;

use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;
use App\Domain\Auth\Service\AuthLogin;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use App\Factory\QueryFactory;

use Cake\Validation\Validator;
use Exception;

final class AuthLoginSubmitAction {


    private SessionInterface $session;
    private SessionManagerInterface $sessionManager;

    private JsonRenderer $renderer;
    private AuthLogin $authLogin;
    private Validator $validator;

    private QueryFactory $queryFactory;


    public function __construct(
        SessionInterface $session,
        SessionManagerInterface $sessionManager,
        JsonRenderer $renderer, 
        ResponseFactoryInterface $responseFactory,
        AuthLogin $authLogin,
        Validator $validator,
        QueryFactory $queryFactory
        ) {
        $this->session = $session;
        $this->sessionManager = $sessionManager;
        $this->renderer = $renderer;
        $this->authLogin = $authLogin;
        $this->validator = $validator;
        $this->queryFactory = $queryFactory;
        
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface 
    {

        //  Prepare routeparser for redirects
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        //  Validate Input

        $this->validator
            ->requirePresence('email', true, 'Input required')
            ->notEmptyString('email', 'Input required')
            //->nonNegativeInteger('id_folder', 'Folder id must be a positive integer')

            ->requirePresence('password', true, 'Input required')
            ->notEmptyString('password', 'Input required');

        $errors = $this->validator->validate($data);

        if($errors) {

            //  Clear all flash messages
            $flash = $this->session->getFlash();
            $flash->clear();
            $flash->add('error', 'Login failed!');

            //  Redirect to login
            $url = $routeParser->urlFor('login');

        } else {

            //  Get User
            $query = $this->queryFactory->newSelect('users');

            $query->select(
                [
                    'id', 
                    'email', 
                    'password', 
                    'role'
                ]
            );

            $query->where(['email' => $data['email']]);
            $user = $query->execute()->fetch('assoc');

            //  error if user does not exist
            if (!$user || $user == NULL) {
                //  Clear all flash messages
                $flash = $this->session->getFlash();
                $flash->clear();
                $flash->add('error', 'Username or Password not valid!');

                //  Redirect to login
                $url = $routeParser->urlFor('login');
            }

            if($user) {

                //  Password Verify
                $verify = password_verify( $data['password'], $user['password']);

                if(!$verify) {
                    //  Clear all flash messages
                    $flash = $this->session->getFlash();
                    $flash->clear();
                    $flash->add('error', 'Username or Password not valids!');

                    //  Redirect to login
                    $url = $routeParser->urlFor('login');
                }

                if($verify) {

                    $flash = $this->session->getFlash();

                    $this->sessionManager->destroy();
                    $this->sessionManager->start();
                    $this->sessionManager->regenerateId();
                    $this->session->set('user', $user);
                    $flash->add('success', 'Login successfully');

                    // Redirect to protected page
                    $url = $routeParser->urlFor('dashboard');
                }
            }

        }

        return $response->withStatus(302)->withHeader('Location', $url);

    }



}