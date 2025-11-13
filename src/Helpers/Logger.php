<?php

declare(strict_types=1);

namespace Pobj\Api\Helpers;

class Logger
{
    private static ?string $logDir = null;

    public static function setLogDir(string $dir): void
    {
        self::$logDir = rtrim($dir, '/');
        if (!is_dir(self::$logDir)) {
            @mkdir(self::$logDir, 0755, true);
        }
    }

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

    public static function log(string $level, string $message, array $context = []): void
    {
        $logDir = self::getLogDir();
        $date = date('Y-m-d');
        $logFile = $logDir . '/' . $date . '.log';

        $timestamp = date('Y-m-d H:i:s');
        
        $contextStr = '';
        if (!empty($context)) {
            if (isset($context['exception'])) {
                $exception = $context['exception'];
                unset($context['exception']);
                
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

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log('DEBUG', $message, $context);
    }

    public static function exception(\Throwable $exception, array $context = []): void
    {
        $message = sprintf(
            '%s: %s',
            get_class($exception),
            $exception->getMessage()
        );

        $projectRoot = dirname(__DIR__, 2);
        $relativeFile = str_replace($projectRoot . '/', '', $exception->getFile());

        $context['exception'] = [
            'class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $relativeFile,
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ];

        $location = "$relativeFile:{$exception->getLine()}";
        $message = "$message (at $location)";

        self::error($message, $context);
    }
}
