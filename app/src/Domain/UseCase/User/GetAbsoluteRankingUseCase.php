<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Domain\Repository\UserRepositoryInterface;

class GetAbsoluteRankingUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(int $top): array
    {
        return $this->userRepository->getTop($top);
    }

}
