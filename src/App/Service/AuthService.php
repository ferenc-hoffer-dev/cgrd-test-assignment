<?php

namespace App\Service;

use App\Repository\AuthRepository;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function attempt(string $username, string $password): bool
    {
        $user = $this->authRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function user(): ?string
    {
        return $_SESSION['user'] ?? null;
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
