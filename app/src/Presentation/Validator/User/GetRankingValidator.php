<?php

declare(strict_types=1);

namespace SP\Presentation\Validator\User;

use SP\Presentation\Validator\ValidatorInterface;

class GetRankingValidator implements ValidatorInterface
{

    const FIELD_TOP = 'type';

    public function validate(array $data): array
    {
        $errors = [];

        if (!isset($data[self::FIELD_TOP])) {
            $errors[self::FIELD_TOP] = 'type cannot be null';
        }

        return $errors;
    }
}