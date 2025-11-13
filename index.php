<?php

declare(strict_types=1);

if (ob_get_level() > 0) {
    ob_end_clean();
}

require_once __DIR__ . '/src/bootstrap.php';

use Pobj\Api\Http\ApiHandler;
use Pobj\Api\Http\IndexHandler;
use Pobj\Api\Http\NotFoundHandler;
use Pobj\Api\Http\StaticFileHandler;

$requestUri  = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?? '/';
$projectRoot = __DIR__;

if (str_starts_with($requestPath, '/api/')) {
    $apiHandler = new ApiHandler();
    $apiHandler->handle($requestPath, $requestUri);
    exit;
}

$staticFileHandler = new StaticFileHandler();
$publicPath = $projectRoot . '/public' . $requestPath;

if ($requestPath !== '/' && $staticFileHandler->serve($publicPath)) {
    exit;
}

if ($requestPath !== '/') {
    $notFoundHandler = new NotFoundHandler();
    $notFoundHandler->handle($projectRoot);
    exit;
}

$indexHandler = new IndexHandler();
$indexHandler->serve($projectRoot);
exit;
