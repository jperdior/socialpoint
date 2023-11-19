<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Infrastructure\Data\Repository\UserRepository;

class ModifyAbsoluteScoreUseCase
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function execute(
        string $userId,
        int $total
    ): void
    {
        $user = $this->userRepository->find($userId);
        dump($user);die;
    }

}