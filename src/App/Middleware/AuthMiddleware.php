<?php

namespace App\Middleware;

use App\Service\AuthService;

class AuthMiddleware
{
    private AuthService $authService;
    private string $mode;
    private const array PUBLIC_ROUTES = ['/', '/login', '/logout'];

    public function __construct(AuthService $authService, string $mode = 'web')
    {
        $this->mode = $mode;
        $this->authService = $authService;
    }

    public function handle(callable $next): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($this->isPublicRoute($uri)) {
            $next();
            return;
        }

        if (!$this->authService->check()) {
            if ($this->mode === 'api') {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            } else {
                header('Location: /login');
            }
            exit;
        }

        $next();
    }

    private function isPublicRoute(string $uri): bool
    {
        return in_array($uri, self::PUBLIC_ROUTES, true);
    }
}
