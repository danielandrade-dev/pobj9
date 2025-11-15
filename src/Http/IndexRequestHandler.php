<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Helpers\EnvHelper;

class IndexRequestHandler
{
    public function handle(string $projectRoot): void
    {
        $view = new ViewRenderer($projectRoot);

        if (!$view->exists('index')) {
            http_response_code(HttpStatusCode::NOT_FOUND->value);
            exit('View index não encontrada.');
        }

        $apiUrl = EnvHelper::get('API_URL', '');
        $apiHttpBase = EnvHelper::get('API_HTTP_BASE', '');

        $this->sendHtmlResponse($view->render('index', [
            'API_URL' => $apiUrl,
            'API_HTTP_BASE' => $apiHttpBase,
        ]));
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

