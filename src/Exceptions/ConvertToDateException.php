<?php

namespace Ruslanovich\DateConverter\Exceptions;

use Exception;
use Ruslanovich\DateConverter\Constants\Errors;

class ConvertToDateException extends Exception
{
    public static function create(?string $row): ConvertToDateException
    {
        return new self(
            message: 'Converting row (' . $row . ') to date is impossible',
            code: Errors::INVALID_DATE_CONVERT
        );
    }
}