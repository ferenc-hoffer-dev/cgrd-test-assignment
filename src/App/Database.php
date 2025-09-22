<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $db;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? 'db';
        $this->db = $_ENV['DB_NAME'] ?? 'news_app';
        $this->user = $_ENV['DB_USER'] ?? 'user';
        $this->pass = $_ENV['DB_PASS'] ?? 'password';
    }

    public function getConnection(): PDO
    {
        try {
            return new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->user, $this->pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }
}
