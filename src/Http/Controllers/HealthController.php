<?php

declare(strict_types=1);

namespace Pobj\Api\Http\Controllers;

use Pobj\Api\Database\DatabaseConnection;
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
            $pdo = DatabaseConnection::getConnection();
            
            $stmt = $pdo->query('SELECT 1 as test');
            $result = $stmt->fetch();
            
            if ($result === false || !isset($result['test'])) {
                $status['status'] = 'error';
                $status['database'] = 'error';
                $status['message'] = 'Banco de dados não respondeu corretamente';
                ResponseHelper::error('Banco de dados não está respondendo', 503);
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
            
            http_response_code(503);
            ResponseHelper::json($status);
        }
    }
}
