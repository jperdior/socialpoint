<?php

declare(strict_types=1);

namespace SP\Application\Command;

readonly class ModifyScoreMessage
{
    public function __construct(
        public string $userId,
        public string $operation,
        public int $score
    ) {
    }

}
