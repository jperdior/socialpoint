<?php

declare(strict_types=1);

namespace SP\Presentation\Validator;

interface ValidatorInterface
{

    public function validate(
        array $data
    ): array;

}