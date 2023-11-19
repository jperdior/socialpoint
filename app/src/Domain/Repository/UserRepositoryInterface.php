<?php

declare(strict_types=1);

namespace SP\Domain\Repository;

use SP\Domain\Entity\User;

interface UserRepositoryInterface
{

    public function getScore(User $user): bool;

}