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
    ) {
    }

    public function validate(
        array $data
    ): array {
        $errors = [];

        if (!isset($data[self::FIELD_USER_ID])) {
            $errors[self::FIELD_USER_ID] = 'user_id cannot be null';
        }
        if (!isset($data[self::FIELD_SCORE]) && !isset($data[self::FIELD_TOTAL])) {
            $errors[self::FIELD_SCORE] = 'score or total must be set';
        }
        if (isset($data[self::FIELD_TOTAL]) && $data[self::FIELD_TOTAL] < 0) {
            $errors[self::FIELD_TOTAL] = 'total must be greater than 0';
        }

        return $errors;
    }

}
