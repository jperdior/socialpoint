<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Infrastructure\Data\Repository\UserRepository;

class GetAbsoluteRankingUseCase
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function execute(int $top): array
    {
        return $this->userRepository->getTop($top);
    }

}