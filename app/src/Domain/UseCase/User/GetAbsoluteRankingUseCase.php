<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Domain\Entity\User;
use SP\Infrastructure\Data\Repository\UserRepository;

class GetAbsoluteRankingUseCase
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function execute(User $user): int
    {
        return 1;
    }

}