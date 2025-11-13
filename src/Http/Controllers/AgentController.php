<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;
use Pobj\Api\Services\AgentService;

class AgentController
{
    public function handle(array $params, $payload = null): void
    {
        if (!is_array($payload)) {
            ResponseHelper::error('Payload inválido. Esperado JSON.', HttpStatusCode::BAD_REQUEST->value);
        }

        try {
            $container = Container::getInstance();
            $service = $container->get(AgentService::class);
            $result = $service->processQuestion($payload ?: []);
            ResponseHelper::json($result);
        } catch (\InvalidArgumentException $e) {
            ResponseHelper::error($e->getMessage(), HttpStatusCode::UNPROCESSABLE_ENTITY->value);
        } catch (\RuntimeException $e) {
            ResponseHelper::error($e->getMessage(), HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        } catch (\Throwable $err) {
            http_response_code(HttpStatusCode::INTERNAL_SERVER_ERROR->value);
            $message = trim($err->getMessage()) ?: 'Falha interna ao processar a pergunta.';
            ResponseHelper::error($message, HttpStatusCode::INTERNAL_SERVER_ERROR->value);
    }
}
}
