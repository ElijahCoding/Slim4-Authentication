<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class SignInController extends Controller
{
    protected $view;

    protected $flash;

    protected $routeParser;

    public function __construct(Twig $view, Messages $flash, RouteParserInterface $routeParser)
    {
        $this->view = $view;
        $this->flash = $flash;
        $this->routeParser = $routeParser;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'pages/auth/signin.twig');
    }

    public function action(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $this->validate($request, [
            'email' => ['email', 'required'],
            'password' => ['required']
        ]);

        try {
            if (!$user = Sentinel::authenticate($data)) {
                throw new \Exception('Incorrect email or password');
            }
        } catch (\Exception $e) {
            $this->flash->addMessage('status', $e->getMessage());

            return $response->withHeader(
                'Location', $this->routeParser->urlFor('auth.signin')
            );
        }

        return $response->withHeader(
          'Location', $this->routeParser->urlFor('home')
        );
    }
}