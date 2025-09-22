<?php

namespace App\Helpers;

/** @deprecated */
class BaseHelper
{
    public static function isUserSet(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function getUser(): ?string
    {
        return $_SESSION['user'] ?? null;
    }
}
