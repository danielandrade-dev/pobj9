<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Enums\HttpStatusCode;

class IndexRequestHandler
{
    public function handle(string $projectRoot): void
    {
        $view = new ViewRenderer($projectRoot);

        if (!$view->exists('index')) {
            http_response_code(HttpStatusCode::NOT_FOUND->value);
            exit('View index não encontrada.');
        }

        $this->sendHtmlResponse($view->render('index'));
    }

    private function sendHtmlResponse(string $content): void
    {
        header('Content-Type: text/html; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        echo $content;
    }
}

