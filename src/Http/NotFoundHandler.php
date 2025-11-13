<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Enums\HttpStatusCode;

class NotFoundHandler
{
    public function handle(string $projectRoot): void
    {
        $view = new View($projectRoot);
        
        if ($view->exists('404')) {
            http_response_code(HttpStatusCode::NOT_FOUND->value);
            $this->sendHtmlResponse($view->render('404'));
            return;
        }

        $this->sendJsonError();
    }

    private function sendHtmlResponse(string $content): void
    {
        header('Content-Type: text/html; charset=utf-8');
        echo $content;
    }

    private function sendJsonError(): void
    {
        http_response_code(HttpStatusCode::NOT_FOUND->value);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'error' => 'not_found',
            'message' => 'Rota não encontrada',
        ], JSON_UNESCAPED_UNICODE);
    }
}

