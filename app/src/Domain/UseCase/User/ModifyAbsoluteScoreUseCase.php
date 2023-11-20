<?php

declare(strict_types=1);

namespace SP\Domain\UseCase\User;

use SP\Domain\Entity\User;
use SP\Domain\Exception\UserNotFoundException;
use SP\Infrastructure\Data\Repository\UserRepository;

class ModifyAbsoluteScoreUseCase
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function execute(
        string $userId,
        int $total
    ): User
    {
        $user = new User(
            id: $userId
        );
        if(false === $this->userRepository->getScore(user: $user)){
            throw new UserNotFoundException();
        }
        $user->setScore($total);
        $this->userRepository->saveScore(user: $user);
        return $user;
    }

}