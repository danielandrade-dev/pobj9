<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use PDO;
use Pobj\Api\Container\Container;
use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;

class HealthController
{
    public function check(array $params, $payload = null): void
    {
        $status = [
            'status' => 'ok',
            'database' => 'ok',
            'timestamp' => date('c'),
        ];

        try {
            $container = Container::getInstance();
            $pdo = $container->get(PDO::class);
            
            $stmt = $pdo->query('SELECT 1 as test');
            $result = $stmt->fetch();
            
            if ($result === false || !isset($result['test'])) {
                $status['status'] = 'error';
                $status['database'] = 'error';
                $status['message'] = 'Banco de dados não respondeu corretamente';
                ResponseHelper::error('Banco de dados não está respondendo', HttpStatusCode::SERVICE_UNAVAILABLE->value);
            }
            
            ResponseHelper::json($status);
        } catch (\Throwable $e) {
            \Pobj\Api\Helpers\Logger::exception($e, [
                'endpoint' => 'health',
            ]);
            
            $status['status'] = 'error';
            $status['database'] = 'error';
            $status['message'] = 'Não foi possível conectar ao banco de dados';
            $status['error'] = $e->getMessage();
            
            http_response_code(HttpStatusCode::SERVICE_UNAVAILABLE->value);
            ResponseHelper::json($status);
        }
    }
}
