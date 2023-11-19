<?php

declare(strict_types=1);

namespace SP\Application\Command;

use SP\Domain\Entity\User;
use SP\Infrastructure\Messenger\CommandMessage;

class ModifyScoreMessage implements CommandMessage
{

    public function __construct(
        public readonly string $userId,
        public readonly string $operation,
        public readonly int $score,
        public ?User $user = null
    ){
    }

}