<?php
/**
 * Ponto de entrada principal - Serve public/index.html ou processa rotas da API
 * 
 * Este arquivo funciona tanto para Apache (.htaccess) quanto para servidor de desenvolvimento PHP
 */

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Processa rotas da API com prefixo /api/
if (preg_match('#^/api/(health|bootstrap|agent|filtros|status_indicadores|resumo)(/.*)?$#', $requestPath, $matches)) {
    $endpoint = $matches[1];
    // Define PATH_INFO para que src/index.php possa processar
    $_SERVER['PATH_INFO'] = '/' . $endpoint;
    // Preserva os parâmetros GET
    parse_str(parse_url($requestUri, PHP_URL_QUERY) ?? '', $queryParams);
    $_GET = array_merge($_GET, $queryParams);
    // Processa a requisição da API
    require __DIR__ . '/src/index.php';
    exit;
}

// Serve o front-end (public/index.html)
$indexPath = __DIR__ . '/public/index.html';

if (!file_exists($indexPath)) {
    http_response_code(404);
    die('Arquivo index.html não encontrado em public/');
}

// Lê o conteúdo do arquivo
$content = file_get_contents($indexPath);

// Ajusta caminhos relativos para funcionar a partir da raiz
// Substitui referências a arquivos estáticos para apontar para public/
$patterns = [
    // CSS e JS
    '/href="(style\.css|leads\.css|omega\.css)"/' => 'href="public/$1"',
    '/src="(script\.js|leads\.js|omega\.js)"/' => 'src="public/$1"',
    // Imagens
    '/href="(img\/[^"]+)"/' => 'href="public/$1"',
    '/src="(img\/[^"]+)"/' => 'src="public/$1"',
];

foreach ($patterns as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

// Define o tipo de conteúdo
header('Content-Type: text/html; charset=utf-8');

// Exibe o conteúdo
echo $content;

