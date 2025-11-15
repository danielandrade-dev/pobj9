<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Http\ViewRenderer;

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
        
        // Se não encontrou em public/, tenta em resources/views/ para arquivos HTML específicos
        if (!is_file($publicPath)) {
            $fileName = basename($requestPath);
            $allowedViews = ['omega.html'];
            
            if (in_array($fileName, $allowedViews, true)) {
                $viewPath = $projectRoot . '/resources/views/' . $fileName;
                if (is_file($viewPath)) {
                    $viewRenderer = new ViewRenderer($projectRoot);
                    $viewName = pathinfo($fileName, PATHINFO_FILENAME);
                    $content = $viewRenderer->render($viewName);
                    
                    header('Content-Type: text/html; charset=utf-8');
                    header('Cache-Control: public, max-age=3600');
                    echo $content;
                    
                    return true;
                }
            }
            
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

