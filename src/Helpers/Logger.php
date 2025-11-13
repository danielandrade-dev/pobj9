<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

/**
 * Logger simples para registrar erros e eventos
 */
class Logger
{
    private static ?string $logDir = null;

    /**
     * Define o diretório de logs
     */
    public static function setLogDir(string $dir): void
    {
        self::$logDir = rtrim($dir, '/');
        if (!is_dir(self::$logDir)) {
            @mkdir(self::$logDir, 0755, true);
        }
    }

    /**
     * Retorna o diretório de logs
     */
    private static function getLogDir(): string
    {
        if (self::$logDir === null) {
            self::$logDir = __DIR__ . '/../../var/log';
            if (!is_dir(self::$logDir)) {
                @mkdir(self::$logDir, 0755, true);
            }
        }
        return self::$logDir;
    }

    /**
     * Registra uma mensagem de log
     *
     * @param string $level Nível do log (error, warning, info, debug)
     * @param string $message Mensagem a ser logada
     * @param array<string, mixed> $context Contexto adicional
     */
    public static function log(string $level, string $message, array $context = []): void
    {
        $logDir = self::getLogDir();
        $date = date('Y-m-d');
        $logFile = $logDir . '/' . $date . '.log';

        $timestamp = date('Y-m-d H:i:s');
        
        // Formata contexto de forma mais legível
        $contextStr = '';
        if (!empty($context)) {
            // Remove informações duplicadas da exception se já estão na mensagem
            if (isset($context['exception'])) {
                $exception = $context['exception'];
                unset($context['exception']);
                
                // Adiciona trace em linhas separadas para melhor legibilidade
                $trace = $exception['trace'] ?? '';
                $contextStr = PHP_EOL . "  Context: " . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                if ($trace) {
                    $contextStr .= PHP_EOL . "  Stack trace:" . PHP_EOL . "  " . str_replace("\n", "\n  ", $trace);
                }
            } else {
                $contextStr = PHP_EOL . "  Context: " . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }
        
        $logLine = "[$timestamp] [$level] $message$contextStr" . PHP_EOL . PHP_EOL;

        @file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log de erro
     */
    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    /**
     * Log de aviso
     */
    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    /**
     * Log de informação
     */
    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    /**
     * Log de debug
     */
    public static function debug(string $message, array $context = []): void
    {
        self::log('DEBUG', $message, $context);
    }

    /**
     * Registra uma exceção completa
     */
    public static function exception(\Throwable $exception, array $context = []): void
    {
        // Mensagem principal mais limpa
        $message = sprintf(
            '%s: %s',
            get_class($exception),
            $exception->getMessage()
        );

        // Calcula caminho relativo ao projeto
        $projectRoot = dirname(__DIR__, 2);
        $relativeFile = str_replace($projectRoot . '/', '', $exception->getFile());

        // Adiciona informações da exceção ao contexto
        $context['exception'] = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $relativeFile,
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ];

        // Adiciona localização no início da mensagem para facilitar leitura
        $location = "$relativeFile:{$exception->getLine()}";
        $message = "$message (at $location)";

        self::error($message, $context);
    }
}

