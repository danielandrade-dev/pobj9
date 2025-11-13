<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

/**
 * Handler de erros e exceções para logging
 */
class ErrorHandler
{
    /**
     * Registra os handlers de erro e exceção
     */
    public static function register(): void
    {
        // Handler de exceções não capturadas
        set_exception_handler([self::class, 'handleException']);

        // Handler de erros
        set_error_handler([self::class, 'handleError'], E_ALL);

        // Handler de erros fatais
        register_shutdown_function([self::class, 'handleShutdown']);

        // Desabilita exibição de erros (só log)
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');
        ini_set('error_log', self::getErrorLogPath());
    }

    /**
     * Handler de exceções
     */
    public static function handleException(\Throwable $exception): void
    {
        Logger::exception($exception, [
            'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);

        // Se não estamos em modo de API, mostra erro amigável
        if (!self::isApiRequest()) {
            http_response_code(500);
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
            }
            echo json_encode([
                'error' => 'server_error',
                'message' => 'Ocorreu um erro interno. Verifique os logs para mais detalhes.',
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Handler de erros PHP
     *
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @return bool
     */
    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        // Não loga erros que são suprimidos com @
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $level = self::getErrorLevel($severity);
        Logger::log($level, $message, [
            'file' => $file,
            'line' => $line,
            'severity' => $severity,
            'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
        ]);

        // Retorna false para permitir que o handler padrão também execute
        return false;
    }

    /**
     * Handler de shutdown (erros fatais)
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE], true)) {
            Logger::error('Fatal error: ' . $error['message'], [
                'file' => $error['file'],
                'line' => $error['line'],
                'type' => $error['type'],
            ]);
        }
    }

    /**
     * Converte código de severidade para nível de log
     */
    private static function getErrorLevel(int $severity): string
    {
        return match (true) {
            $severity === E_ERROR,
            $severity === E_CORE_ERROR,
            $severity === E_COMPILE_ERROR,
            $severity === E_PARSE,
            $severity === E_RECOVERABLE_ERROR => 'ERROR',
            $severity === E_WARNING,
            $severity === E_CORE_WARNING,
            $severity === E_COMPILE_WARNING,
            $severity === E_USER_WARNING => 'WARNING',
            $severity === E_NOTICE,
            $severity === E_USER_NOTICE,
            $severity === E_STRICT,
            $severity === E_DEPRECATED,
            $severity === E_USER_DEPRECATED => 'INFO',
            default => 'DEBUG',
        };
    }

    /**
     * Verifica se é uma requisição de API
     */
    private static function isApiRequest(): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        return strpos($uri, '/src/') !== false || strpos($uri, '/health') !== false;
    }

    /**
     * Retorna o caminho do arquivo de log de erros do PHP
     */
    private static function getErrorLogPath(): string
    {
        $logDir = __DIR__ . '/../../var/log';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        return $logDir . '/php-errors.log';
    }
}

