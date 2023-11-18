<?php

declare(strict_types=1);

namespace SP\Application\Router;

use SP\Presentation\Controller\Ranking\GetRankingController;
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


    public function match(string $method, string $path): ?callable
    {
        $controller =  $this->routes[$method][$path] ?? null;
        if (null === $controller) {
            foreach ($this->routes[$method] as $route => $controller) {
                $params = $this->matchWithParams($path, $route);
                if ($params !== null) {
                    return function () use ($controller, $params) {
                        return call_user_func_array([new $controller(), '__invoke'], $params);
                    };
                }
            }
            return null;
        }
        return new $controller();
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
                // If the route part doesn't match and isn't a parameter, return null
                return null;
            }

            if ($routePart === '%s') {
                // If it's a parameter, add it to the $params array
                $params[] = $pathParts[$index];
            }
        }

        return $params;
    }

}