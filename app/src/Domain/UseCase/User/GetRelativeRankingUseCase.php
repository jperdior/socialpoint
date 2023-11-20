<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Infrastructure\Data\Repository\UserRepository;

class GetRelativeRankingUseCase
{

    public function __construct(
        private readonly UserRepository $userRepository
    ){
    }

    public function execute(
        int $position,
        int $range
    ): array
    {
        return $this->userRepository->getRelativeRanking(
            position: $position,
            range: $range
        );
    }

}