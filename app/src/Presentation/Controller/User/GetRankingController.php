<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\User;

use SP\Infrastructure\Http\Response;
use SP\Infrastructure\Request;
use SP\Presentation\Controller\ControllerInterface;

class GetRankingController implements ControllerInterface
{

    public function __invoke(
        Request $request
    ): Response
    {
        return new Response(200, 'Hello Ranking');
    }

}