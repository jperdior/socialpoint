<?php

declare(strict_types=1);

namespace SP\Presentation\Controller;

use SP\Infrastructure\Request;
use SP\Infrastructure\Response;

interface ControllerInterface
{
    public function __invoke(Request $request, ...$params): Response;
}