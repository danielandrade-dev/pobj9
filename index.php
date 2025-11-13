<?php

declare(strict_types=1);

if (ob_get_level() > 0) {
    ob_end_clean();
}

require_once __DIR__ . '/src/bootstrap.php';

use Pobj\Api\Http\ApiRequestHandler;
use Pobj\Api\Http\IndexRequestHandler;
use Pobj\Api\Http\NotFoundRequestHandler;
use Pobj\Api\Http\StaticFileRequestHandler;

$requestUri  = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?? '/';
$projectRoot = __DIR__;

if (str_starts_with($requestPath, '/api/')) {
    (new ApiRequestHandler())->handle($requestPath, $requestUri);
    exit;
}

if ($requestPath !== '/' && (new StaticFileRequestHandler())->handle($requestPath, $projectRoot)) {
    exit;
}

if ($requestPath !== '/') {
    (new NotFoundRequestHandler())->handle($projectRoot);
    exit;
}

(new IndexRequestHandler())->handle($projectRoot);
exit;
