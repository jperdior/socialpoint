<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\Ranking;

use SP\Infrastructure\Http\Response;

class GetRankingController
{

    public function __invoke(): Response
    {
        return new Response(200, 'Hello Ranking');
    }

}