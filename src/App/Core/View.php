<?php

namespace App\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data);
        include __DIR__ . '/../../public/views/' . $template . '.php';
    }

    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
