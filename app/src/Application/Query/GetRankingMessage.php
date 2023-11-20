<?php

declare(strict_types=1);

namespace SP\Application\Query;

readonly class GetRankingMessage
{

    public function __construct(
        public string $type,
    )
    {
    }


}