<?php

namespace App;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Traits/JsonResponseTrait.php';
require_once __DIR__ . '/Helpers/BaseHelper.php';
require_once __DIR__ . '/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/Enums/NewsResponseEnum.php';
foreach (glob(__DIR__ . '/Core/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Controller/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Service/*.php') as $file) {
    require_once $file;
}
foreach (glob(__DIR__ . '/Repository/*.php') as $file) {
    require_once $file;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Database;

$db = (new Database())->getConnection();
