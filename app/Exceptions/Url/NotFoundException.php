<?php

namespace App\Exceptions\Url;

use Exception;

class NotFoundException extends Exception
{
    const CODE = 404;

    public function __construct(?string $message = null)
    {
        $message ??= __('Not Found');
        parent::__construct($message, self::CODE);
    }
}
