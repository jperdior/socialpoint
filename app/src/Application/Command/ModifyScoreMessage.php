<?php

declare(strict_types=1);

namespace SP\Application\Command;

class ModifyScoreMessage
{

    public function __construct(
        public readonly string $userId,
        public readonly string $operation,
        public readonly int $score
    ){
    }

}