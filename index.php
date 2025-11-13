<?php

declare(strict_types=1);

if (ob_get_level() > 0) {
    ob_end_clean();
}

require_once __DIR__ . '/src/bootstrap.php';

use Pobj\Api\Enums\HttpStatusCode;

$requestUri  = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?? '/';

if (str_starts_with($requestPath, '/api/')) {
    $_SERVER['PATH_INFO'] = substr($requestPath, 4);
    parse_str(parse_url($requestUri, PHP_URL_QUERY) ?? '', $_GET);
    require __DIR__ . '/src/index.php';
    exit;
}

$indexPath = __DIR__ . '/public/index.html';

if (!is_file($indexPath)) {
    http_response_code(HttpStatusCode::NOT_FOUND->value);
    exit('Arquivo index.html não encontrado em /public.');
}

$content = file_get_contents($indexPath);

$replacements = [
    '/(href|src)="(?!public\/|https?:\/\/)((?:style|leads|omega)\.(?:css|js))"/' => '$1="public/$2"',
    '/(href|src)="(?!public\/|https?:\/\/)(img\/[^"]+)"/' => '$1="public/$2"',
    '/(href|src)="(?!public\/|https?:\/\/)(script\.js)"/' => '$1="public/$2"',
];

$content = preg_replace(
    array_keys($replacements),
    array_values($replacements),
    $content
);

header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
echo $content;
exit;
