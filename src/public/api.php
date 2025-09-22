<?php
require_once __DIR__ . '/../App/init.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Repository\AuthRepository;
use App\Service\AuthService;
use App\Repository\NewsRepository;
use App\Service\NewsService;
use App\Controller\NewsController;
use App\Middleware\AuthMiddleware;

$request = new Request();
$response = new Response();

$authRepository = new AuthRepository($db);
$authService = new AuthService($authRepository);

$newsRepository = new NewsRepository($db);
$newsService = new NewsService($newsRepository);
$newsController = new NewsController($newsService, $authService);

$router = new Router($request, $response);

$router->get('/api/news', [$newsController, 'getNews']);
$router->post('/api/news', [$newsController, 'createNews']);
$router->put('/api/news/{id}', [$newsController, 'updateNews']);
$router->delete('/api/news/{id}', [$newsController, 'deleteNews']);

$middleware = new AuthMiddleware($authService, 'api');
$middleware->handle(function () use ($router) {
    $router->dispatch();
});
