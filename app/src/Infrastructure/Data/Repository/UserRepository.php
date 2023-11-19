<?php

declare(strict_types=1);

namespace SP\Infrastructure\Data\Repository;

use DI\Container;
use SP\Domain\Entity\User;
use SP\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    private array $dataset;

    public function __construct(
        private readonly Container $container
    )
    {
        $this->dataset =$this->container->get('dataset');
    }

    public function getScore(User $user): bool
    {
        $score = $this->dataset[$user->getId()] ?? null;
        if ($score === null) {
            return false;
        }
        $user->setScore($score);
        return true;
    }


}