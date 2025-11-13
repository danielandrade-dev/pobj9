<?php

declare(strict_types=1);

namespace Pobj\Api\Response;

/**
 * Helper para respostas HTTP JSON
 */
class ResponseHelper
{
    /**
     * Envia resposta JSON e encerra a execução
     *
     * @param mixed $data
     */
    public static function json($data): void
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Envia erro JSON e encerra a execução
     */
    public static function error(string $message, int $status = 400): void
    {
        http_response_code($status);
        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

