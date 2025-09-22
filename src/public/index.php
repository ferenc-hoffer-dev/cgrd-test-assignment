<?php
require_once __DIR__ . '/../App/init.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Repository\AuthRepository;
use App\Service\AuthService;
use App\Controller\AuthController;
use App\Controller\NewsController;
use App\Repository\NewsRepository;
use App\Service\NewsService;

$request = new Request();
$response = new Response();

$authRepository = new AuthRepository($db);
$authService = new AuthService($authRepository);
$newsRepository = new NewsRepository($db);
$newsService = new NewsService($newsRepository);

$authController = new AuthController($authService);
$newsController = new NewsController($newsService, $authService);

$router = new Router($request, $response);

$router->get('/', [$authController, 'showLogin']);
$router->get('/login', [$authController, 'showLogin']);
$router->post('/login', [$authController, 'processLogin']);
$router->get('/logout', [$authController, 'logout']);
$router->get('/news', [$newsController, 'showNews']);

$middleware = new AuthMiddleware($authService, 'web');
$middleware->handle(function () use ($router) {
    $router->dispatch();
});
