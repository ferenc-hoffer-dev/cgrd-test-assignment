<?php

namespace App\Repository;

use PDO;

class NewsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): array
    {
        return $this->pdo
            ->query("SELECT * FROM news ORDER BY created_at DESC")
            ->fetchAll();
    }

    public function create(string $title, string $body, string $author): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO news (title, body, author) VALUES (:title, :body, :author)"
        );
        return $stmt->execute([
            'title' => $title,
            'body' => $body,
            'author' => $author,
        ]);
    }

    public function update(int $id, string $title, string $body): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE news SET title = :title, body = :body WHERE id = :id"
        );
        return $stmt->execute([
            'title' => $title,
            'body' => $body,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM news WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
