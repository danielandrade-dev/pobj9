<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Http\Handlers\AgentHandler;
use Pobj\Api\Response\ResponseHelper;

class AgentController
{
    public function handle(array $params, $payload = null): void
    {
        if (!is_array($payload)) {
            ResponseHelper::error('Payload inválido. Esperado JSON.', 400);
        }

        $handler = new AgentHandler();
        $handler->handle($payload ?: []);
    }
}
