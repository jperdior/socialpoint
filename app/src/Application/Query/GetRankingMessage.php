<?php

declare(strict_types=1);

namespace SP\Application\Query;

class GetRankingMessage
{

    public function __construct(
        public readonly string $type,
    )
    {
    }


}