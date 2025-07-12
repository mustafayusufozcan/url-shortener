<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidCredentialsException extends Exception
{
    const CODE = 401;
    
    public function __construct(?string $message = null)
    {
        $message ??= __('Invalid credentials!');
        parent::__construct($message, self::CODE);
    }
}
