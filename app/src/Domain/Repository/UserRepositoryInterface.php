<?php

declare(strict_types=1);

namespace SP\Domain\Repository;

use SP\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getScore(User $user): bool;

    public function saveScore(User $user): void;

    public function getTop(int $top): array;

    public function getRelativeRanking(int $position, int $range): array;

}
