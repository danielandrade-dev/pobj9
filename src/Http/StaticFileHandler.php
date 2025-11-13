<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

class StaticFileHandler
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

    public function serve(string $filePath): bool
    {
        if (!is_file($filePath)) {
            return false;
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $contentType = self::MIME_TYPES[$extension] ?? 'application/octet-stream';
        
        header('Content-Type: ' . $contentType);
        header('Cache-Control: public, max-age=3600');
        readfile($filePath);
        
        return true;
    }
}

