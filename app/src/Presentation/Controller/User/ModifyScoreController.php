<?php

declare(strict_types=1);

namespace SP\Presentation\Controller\User;

use SP\Infrastructure\Request;
use SP\Infrastructure\Http\Response;

class ModifyScoreController
{

    public function __invoke(
        string $userId,
        Request $request
    ): Response
    {
        return new Response(200, "Hello Modify user $userId score");
    }

}