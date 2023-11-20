<?php

declare(strict_types=1);

namespace SP\Infrastructure\Data\Repository;

use DI\Container;
use SP\Domain\Entity\User;
use SP\Domain\Repository\UserRepositoryInterface;
use SP\Infrastructure\Data\DatasetStorage;
use SP\Infrastructure\Data\Redis\RedisClient;

class UserRepository implements UserRepositoryInterface
{

    private const KEY = 'user';

    public function __construct(
        private readonly RedisClient $redisClient,
    )
    {
    }

    public function getScore(User $user): bool
    {
        $score = $this->redisClient->getClient()->hget(self::KEY, $user->getId());
        if ($score === null) {
            return false;
        }
        $user->setScore((int)$score);
        return true;
    }

    public function saveScore(User $user): void
    {
        $this->redisClient->getClient()->hset(self::KEY, $user->getId(), (string)$user->getScore());
    }

    public function getTop(int $top): array
    {
        $users = $this->redisClient->getClient()->hgetall(self::KEY);
        arsort($users);
        return array_slice($users, 0, $top, true);
    }

    public function getRelativeRanking(int $position, int $range): array
    {
        $users = $this->redisClient->getClient()->hgetall(self::KEY);
        arsort($users);

        $startIndex = max(0, $position - $range -1);

        return array_slice($users, $startIndex, $range * 2 + 1, true);
    }

}