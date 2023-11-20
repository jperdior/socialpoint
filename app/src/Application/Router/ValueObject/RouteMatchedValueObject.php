<?php

declare(strict_types=1);

namespace SP\Application\Router\ValueObject;

readonly class RouteMatchedValueObject
{
    public function __construct(
        public string $controller,
        public array $params
    ) {
    }

}
