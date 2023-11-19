<?php

declare(strict_types=1);

namespace SP\Domain\Exception;

class UserNotFoundException extends \Exception
{

    public function __construct(
    )
    {
        parent::__construct(message: "User not found", code: 404);
    }

}