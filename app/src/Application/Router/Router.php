<?php

declare(strict_types=1);

namespace SP\Application\Router;

use SP\Application\Router\ValueObject\RouteMatchedValueObject;
use SP\Presentation\Controller\User\GetRankingController;
use SP\Presentation\Controller\User\ModifyScoreController;

class Router
{

    private array $routes = [
        'GET' => [
            '/ranking' => GetRankingController::class
        ],
        'POST' => [
            '/user/%s/score' => ModifyScoreController::class
        ],
        'PUT' => [],
        'DELETE' => [],
    ];


    public function match(string $method, string $path): ?RouteMatchedValueObject
    {

        $controller =  $this->routes[$method][$path] ?? null;
        if (null === $controller) {
            foreach ($this->routes[$method] as $route => $controller) {
                $params = $this->matchWithParams(
                    path: $path,
                    route: $route
                );
                if ($params !== null) {
                    return new RouteMatchedValueObject(
                        controller: $controller,
                        params: $params
                    );
                }
            }
            return null;
        }
        return new RouteMatchedValueObject(
            controller: $controller,
            params: []
        );
    }

    private function matchWithParams(string $path, string $route): ?array
    {

        $pathParts = explode('/', $path);
        $routeParts = explode('/', $route);

        if (count($pathParts) !== count($routeParts)) {
            return null;
        }

        $params = [];

        foreach ($routeParts as $index => $routePart) {
            if ($routePart !== $pathParts[$index] && $routePart !== '%s') {
                return null;
            }

            if ($routePart === '%s') {
                $params[] = $pathParts[$index];
            }
        }

        return $params;
    }

}