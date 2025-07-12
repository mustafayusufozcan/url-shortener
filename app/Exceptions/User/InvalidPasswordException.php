<?php

namespace App\Exceptions\User;

use Exception;

class InvalidPasswordException extends Exception
{
    const CODE = 401;

    public function __construct(?string $message = null)
    {
        $message ??= __('Invalid password!');
        parent::__construct($message, self::CODE);
    }
}
