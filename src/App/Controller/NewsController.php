<?php

namespace App\Controller;

use App\Core\View;
use App\Service\AuthService;
use App\Service\NewsService;
use App\Core\Request;
use App\Core\Response;
use App\Enums\NewsResponseEnum;

class NewsController
{
    private NewsService $service;
    private AuthService $authService;

    public function __construct(NewsService $service, AuthService $authService)
    {
        $this->service = $service;
        $this->authService = $authService;
    }

    public function showNews(Request $request, Response $response): void
    {
        View::render('news');
    }

    // API: GET /api/news
    public function getNews(Request $request, Response $response): void
    {
        $news = $this->service->getAllNews();
        $response->json([
            'success' => true,
            'data' => $news
        ]);
    }

    // API: POST /api/news
    public function createNews(Request $request, Response $response): void
    {
        $title = $request->input('title', '');
        $body = $request->input('body', '');

        $isCreated = $this->service->createNews($title, $body, $this->authService->user());

        if ($isCreated) {
            $response->json([
                'success' => true,
                'message' => NewsResponseEnum::CREATED_SUCCESS->value
            ], 201);
        } else {
            $response->json([
                'success' => false,
                'message' => NewsResponseEnum::CREATED_ERROR->value
            ], 400);
        }
    }

    // API: PUT /api/news/{id}
    public function updateNews(Request $request, Response $response, int $id): void
    {
        $title = $request->input('title', '');
        $body = $request->input('body', '');

        $isUpdated = $this->service->updateNews($id, $title, $body);

        if ($isUpdated) {
            $response->json([
                'success' => true,
                'message' => NewsResponseEnum::UPDATED_SUCCESS->value
            ]);
        } else {
            $response->json([
                'success' => false,
                'message' => NewsResponseEnum::UPDATED_ERROR->value
            ], 400);
        }
    }

    // API: DELETE /api/news/{id}
    public function deleteNews(Request $request, Response $response, int $id): void
    {
        $isDeleted = $this->service->deleteNews($id);

        if ($isDeleted) {
            $response->json([
                'success' => true,
                'message' => NewsResponseEnum::DELETED_SUCCESS->value
            ]);
        } else {
            $response->json([
                'success' => false,
                'message' => NewsResponseEnum::DELETED_ERROR->value
            ], 400);
        }
    }
}
