<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class InvalidIntervalException extends Exception
{
    public static function create(?string $row): InvalidIntervalException
    {
        return new self(
            message: 'Row (' . $row . ') is not dateInterval',
            code: Errors::INVALID_INTERVAL
        );
    }
}