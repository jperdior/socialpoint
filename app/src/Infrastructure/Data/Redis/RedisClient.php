<?php

declare(strict_types=1);

namespace SP\Infrastructure\Data\Redis;

use Predis\Client;

class RedisClient
{
    private Client $client;

    public function __construct(
        string $host,
        int $port,
        string $password
    ) {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => $host,
            'port' => $port,
            'password' => $password
        ]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function initializeDataset(string $key, array $dataset): void
    {
        //delete all
        $this->client->del($key);


        if (!$this->client->exists($key)) {
            $this->client->hmset($key, $dataset);
        }
    }

}
