<?php

declare(strict_types=1);

namespace Pobj\Api\Http;

use Pobj\Api\Enums\HttpStatusCode;
use Pobj\Api\Response\ResponseHelper;

class Router
{
    private array $routes = [];

    public function add(string $endpoint, string $controller, string $method, array $allowedMethods = []): void
    {
        $this->routes[$endpoint] = [
            'controller' => $controller,
            'method' => $method,
            'allowedMethods' => $allowedMethods,
        ];
    }

    public function dispatch(string $endpoint, string $httpMethod, array $params, $payload = null): void
    {
        if (!isset($this->routes[$endpoint])) {
            ResponseHelper::error('endpoint não encontrado', HttpStatusCode::NOT_FOUND->value);
        }

        $route = $this->routes[$endpoint];

        if (!in_array($httpMethod, $route['allowedMethods'], true)) {
            ResponseHelper::error(
                sprintf('Método não permitido. Use: %s', implode(', ', $route['allowedMethods'])),
                HttpStatusCode::METHOD_NOT_ALLOWED->value
            );
        }

        if (!class_exists($route['controller'])) {
            ResponseHelper::error('Controller não encontrado: ' . $route['controller'], HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }

        $controller = new $route['controller']();

        if (!method_exists($controller, $route['method'])) {
            ResponseHelper::error('Método não encontrado no controller: ' . $route['method'], HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }

        $controller->{$route['method']}($params, $payload);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
