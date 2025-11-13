<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

class StaticFileRequestHandler
{
    private const MIME_TYPES = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'html' => 'text/html',
        'xml' => 'application/xml',
    ];

    public function handle(string $requestPath, string $projectRoot): bool
    {
        $publicPath = $projectRoot . '/public' . $requestPath;
        
        if (!is_file($publicPath)) {
            return false;
        }

        $extension = strtolower(pathinfo($publicPath, PATHINFO_EXTENSION));
        $contentType = self::MIME_TYPES[$extension] ?? 'application/octet-stream';
        
        header('Content-Type: ' . $contentType);
        header('Cache-Control: public, max-age=3600');
        readfile($publicPath);
        
        return true;
    }
}

