<?php

declare(strict_types=1);

namespace SP\Domain\Entity;

class User
{

    private string $id;

    private ?int $score;

    public function __construct(string $id, ?int $score = null)
    {
        $this->id = $id;
        $this->score = $score;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }



}