<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Domain\Entity\User;
use SP\Domain\Exception\UserNotFoundException;
use SP\Domain\Repository\UserRepositoryInterface;

class ModifyRelativeScoreUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(
        string $userId,
        int $score
    ): User {
        $user = new User(
            id: $userId
        );
        if(false === $this->userRepository->getScore(user: $user)) {
            throw new UserNotFoundException();
        }
        $user->setScore($user->getScore() + $score);
        $this->userRepository->saveScore(user: $user);
        return $user;
    }

}
