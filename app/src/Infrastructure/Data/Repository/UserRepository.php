<?php

declare(strict_types=1);

namespace SP\Infrastructure\Data\Repository;

use DI\Container;
use SP\Domain\Entity\User;
use SP\Domain\Repository\UserRepositoryInterface;
use SP\Infrastructure\Data\DatasetStorage;

class UserRepository implements UserRepositoryInterface
{

    private array $dataset;

    public function __construct()
    {
        $this->dataset = DatasetStorage::getDataset();
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

    public function saveScore(User $user): void
    {
        $this->dataset[$user->getId()] = $user->getScore();
        DatasetStorage::updateDataset($this->dataset);
    }


}