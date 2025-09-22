<?php

namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Service\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin(): void
    {
        if ($this->authService->check()) {
            $this->authService->redirect('/news');
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        View::render('login', ['error' => $error]);
    }

    public function processLogin(Request $request, Response $response): void
    {
        $username = $request->input('username', '');
        $password = $request->input('password', '');
        if ($this->authService->attempt($username, $password)) {
            $this->authService->redirect('/news');
            return;
        }

        $_SESSION['login_error'] = "Wrong Login Data!";
        $this->authService->redirect('/login');
    }

    public function logout(): void
    {
        $this->authService->logout();
        $this->authService->redirect('/login');
    }
}
