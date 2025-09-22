<?php

namespace App\Core;

class Router
{
    private Request $request;
    private Response $response;
    private array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, callable $handler): void
    {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->map('POST', $path, $handler);
    }

    public function put(string $path, callable $handler): void
    {
        $this->map('PUT', $path, $handler);
    }

    public function delete(string $path, callable $handler): void
    {
        $this->map('DELETE', $path, $handler);
    }

    private function map(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [$method, $path, $handler];
    }

    public function dispatch(): void
    {
        $method = $this->request->method();
        $uri = $this->request->uri();

        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            $pattern = "@^" . preg_replace('/\{[a-zA-Z_]+}/', '([0-9]+)', $routePath) . "$@";
            if ($method === $routeMethod && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $handler(...array_merge([$this->request, $this->response], $matches));
                return;
            }
        }

        $this->response->json([
            'success' => false,
            'message' => 'Route not found'
        ], 404);
    }
}
