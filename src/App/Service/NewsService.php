<?php

namespace App\Service;

use App\Repository\NewsRepository;

class NewsService
{
    private NewsRepository $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllNews(): array
    {
        return $this->repository->all();
    }

    public function createNews(string $title, string $body, string $author): bool
    {
        return $this->repository->create($title, $body, $author);
    }

    public function updateNews(int $id, string $title, string $body): bool
    {
        return $this->repository->update($id, $title, $body);
    }

    public function deleteNews(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
