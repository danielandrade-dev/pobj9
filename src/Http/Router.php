<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Response\ResponseHelper;

/**
 * Router - Gerencia rotas da API
 */
class Router
{
    /**
     * @var array<string, array{controller: string, method: string, allowedMethods: array<string>}>
     */
    private array $routes = [];

    /**
     * Registra uma rota
     *
     * @param string $endpoint
     * @param string $controller Classe do controller
     * @param string $method Método do controller
     * @param array<string> $allowedMethods Métodos HTTP permitidos
     */
    public function add(string $endpoint, string $controller, string $method, array $allowedMethods = ['GET']): void
    {
        $this->routes[$endpoint] = [
            'controller' => $controller,
            'method' => $method,
            'allowedMethods' => $allowedMethods,
        ];
    }

    /**
     * Resolve e executa a rota
     *
     * @param string $endpoint
     * @param string $httpMethod
     * @param array<string, mixed> $params
     * @param mixed $payload
     */
    public function dispatch(string $endpoint, string $httpMethod, array $params, $payload = null): void
    {
        if (!isset($this->routes[$endpoint])) {
            ResponseHelper::error('endpoint não encontrado', 404);
        }

        $route = $this->routes[$endpoint];

        // Verifica método HTTP
        if (!in_array($httpMethod, $route['allowedMethods'], true)) {
            ResponseHelper::error(
                sprintf('Método não permitido. Use: %s', implode(', ', $route['allowedMethods'])),
                405
            );
        }

        // Instancia controller e chama método
        if (!class_exists($route['controller'])) {
            ResponseHelper::error('Controller não encontrado: ' . $route['controller'], 500);
        }

        $controller = new $route['controller']();

        if (!method_exists($controller, $route['method'])) {
            ResponseHelper::error('Método não encontrado no controller: ' . $route['method'], 500);
        }

        $controller->{$route['method']}($params, $payload);
    }

    /**
     * Retorna todas as rotas registradas
     *
     * @return array<string, array{controller: string, method: string, allowedMethods: array<string>}>
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}

