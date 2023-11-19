<?php

declare(strict_types=1);

namespace SP\Presentation\Validator\User;

use SP\Presentation\Validator\ValidatorInterface;

class ModifyScoreValidator implements ValidatorInterface
{

    private const FIELD_USER_ID = 'user_id';
    private const FIELD_SCORE = 'score';
    private const FIELD_TOTAL = 'total';

    public function __construct(
    )
    {
    }

    public function validate(
        array $body
    ): void
    {
        if (!isset($body[self::FIELD_USER_ID])) {
            throw new \InvalidArgumentException('user_id cannot be null');
        }
        if (!isset($body[self::FIELD_SCORE]) && !isset($body[self::FIELD_TOTAL])) {
            throw new \InvalidArgumentException('score or total cannot be null');
        }
        if (isset($body[self::FIELD_TOTAL]) && $body[self::FIELD_TOTAL] < 0) {
            throw new \InvalidArgumentException('total cannot be negative');
        }
    }

}